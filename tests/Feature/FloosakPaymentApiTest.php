<?php

namespace Tests\Feature;

use App\Models\FloosakPaymentAttempt;
use App\Models\FloosakRefund;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Services\Floosak\FloosakPaymentException;
use App\Services\Floosak\FloosakPaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FloosakPaymentApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected Store $store;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();

        config([
            'floosak.enabled' => true,
            'floosak.base_url' => 'https://staging.fintech-expert.net',
            'floosak.merchant_phone' => '967700000000',
            'floosak.merchant_password' => 'secret',
            'floosak.source_wallet_id' => '10000',
            'floosak.reconciliation.max_attempts' => 3,
        ]);

        $this->customer = User::factory()->create(['phone' => '967711111111']);
        $vendor = User::factory()->create();
        $this->store = Store::create([
            'user_id' => $vendor->id,
            'name' => 'Test Store',
            'slug' => 'test-store',
        ]);
    }

    public function test_mobile_can_initiate_floosak_payment_and_duplicate_request_reuses_attempt(): void
    {
        Sanctum::actingAs($this->customer);
        $order = $this->createFloosakOrder();

        $this->fakeLoginAndSend();

        $first = $this->postJson("/api/v1/orders/{$order->id}/payments/floosak/initiate");
        $second = $this->postJson("/api/v1/orders/{$order->id}/payments/floosak/initiate");

        $first->assertStatus(201)
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.gateway_purchase_id', '1699240')
            ->assertJsonPath('data.status', FloosakPaymentAttempt::STATUS_PENDING)
            ->assertJsonPath('data.requires_otp', true);

        $second->assertStatus(201)
            ->assertJsonPath('data.payment_attempt_id', $first->json('data.payment_attempt_id'));

        $this->assertDatabaseCount('floosak_payment_attempts', 1);
        $this->assertDatabaseHas('floosak_payment_attempts', [
            'order_id' => $order->id,
            'target_phone' => '967711111111',
            'source_wallet_id' => 10000,
        ]);

        Http::assertSentCount(2);
        Http::assertSent(fn (Request $request): bool => $request->url() === 'https://staging.fintech-expert.net/api/v1/merchant/p2mcl'
            && $request['target_phone'] === '967711111111');
    }

    public function test_payment_methods_hide_floosak_until_source_wallet_is_configured(): void
    {
        config(['floosak.source_wallet_id' => null]);

        $response = $this->getJson('/api/v1/payment-methods');

        $response->assertOk();
        $ids = collect($response->json('data'))->pluck('id');

        $this->assertFalse($ids->contains('floosak_wallet'));
    }

    public function test_initiation_rejects_missing_customer_phone(): void
    {
        $this->customer->update(['phone' => null]);
        Sanctum::actingAs($this->customer);

        $response = $this->postJson("/api/v1/orders/{$this->createFloosakOrder()->id}/payments/floosak/initiate");

        $response->assertStatus(422)
            ->assertJsonPath('status', false);

        Http::assertNothingSent();
    }

    public function test_mobile_can_confirm_completed_payment_without_persisting_otp(): void
    {
        Sanctum::actingAs($this->customer);
        $order = $this->createFloosakOrder();
        $attempt = $this->createPendingAttempt($order);

        $this->fakeLoginAndConfirm('Completed');

        $response = $this->postJson("/api/v1/payments/floosak/{$attempt->id}/confirm", [
            'otp' => 123456,
        ]);

        $response->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonPath('data.status', FloosakPaymentAttempt::STATUS_COMPLETED)
            ->assertJsonPath('data.gateway_transaction_id', '620453');

        $order->refresh();
        $attempt->refresh();

        $this->assertSame('paid', $order->payment_status);
        $this->assertSame('processing', $order->status);
        $this->assertStringNotContainsString('123456', json_encode($attempt->toArray()));
        $this->assertDatabaseHas('transactions', [
            'transaction_id' => '620453',
            'provider' => 'floosak_wallet',
            'status' => 'success',
        ]);
    }

    public function test_pending_confirm_response_does_not_mark_order_paid(): void
    {
        Sanctum::actingAs($this->customer);
        $order = $this->createFloosakOrder();
        $attempt = $this->createPendingAttempt($order);

        $this->fakeLoginAndConfirm('Pending');

        $response = $this->postJson("/api/v1/payments/floosak/{$attempt->id}/confirm", [
            'otp' => '123456',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.status', FloosakPaymentAttempt::STATUS_PENDING);

        $this->assertSame('pending', $order->fresh()->payment_status);
    }

    public function test_invalid_otp_keeps_attempt_pending_for_retry(): void
    {
        Sanctum::actingAs($this->customer);
        $order = $this->createFloosakOrder();
        $attempt = $this->createPendingAttempt($order);

        Http::fake([
            'https://staging.fintech-expert.net/api/v1/auth/login' => Http::response([
                'data' => ['token' => 'ACCESS_TOKEN'],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/confirm' => Http::response([
                'message' => 'Invalid OTP',
                'errors' => [
                    'otp' => ['Invalid OTP'],
                ],
                'is_success' => false,
            ], 422),
        ]);

        $response = $this->postJson("/api/v1/payments/floosak/{$attempt->id}/confirm", [
            'otp' => '000000',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('status', false);

        $attempt->refresh();
        $this->assertSame(FloosakPaymentAttempt::STATUS_PENDING, $attempt->status);
        $this->assertSame('pending', $order->fresh()->payment_status);
    }

    public function test_reconciliation_marks_unknown_attempt_completed_from_check_status(): void
    {
        $order = $this->createFloosakOrder();
        $attempt = FloosakPaymentAttempt::create([
            'order_id' => $order->id,
            'user_id' => $this->customer->id,
            'request_id' => 'REQ-UNKNOWN',
            'source_wallet_id' => 10000,
            'target_phone' => $this->customer->phone,
            'amount' => $order->total_amount,
            'purpose' => "Order {$order->order_number}",
            'status' => FloosakPaymentAttempt::STATUS_CONFIRM_UNKNOWN,
            'gateway_purchase_id' => '1699240',
            'next_reconcile_at' => now()->subMinute(),
        ]);

        Http::fake([
            'https://staging.fintech-expert.net/api/v1/auth/login' => Http::response([
                'data' => ['token' => 'ACCESS_TOKEN'],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/check-status' => Http::response([
                'data' => 'transaction retrieved successfully',
                'message' => [
                    'id' => 620453,
                    'reference_id' => '4633391771756870',
                    'status' => ['en' => 'Completed', 'ar' => 'مكتملة'],
                    'net' => 100,
                    'fee' => 1,
                    'gross' => 101,
                    'balance' => 400,
                ],
                'is_success' => true,
                'statusCode' => 1,
            ]),
        ]);

        $this->artisan('floosak:reconcile-payments')->assertExitCode(0);

        $attempt->refresh();
        $order->refresh();

        $this->assertSame(FloosakPaymentAttempt::STATUS_COMPLETED, $attempt->status);
        $this->assertSame('620453', $attempt->gateway_transaction_id);
        $this->assertSame('paid', $order->payment_status);
    }

    public function test_refund_success_and_amount_limit(): void
    {
        $order = $this->createFloosakOrder(['payment_status' => 'paid', 'status' => 'processing']);
        $attempt = FloosakPaymentAttempt::create([
            'order_id' => $order->id,
            'user_id' => $this->customer->id,
            'request_id' => 'REQ-COMPLETE',
            'source_wallet_id' => 10000,
            'target_phone' => $this->customer->phone,
            'amount' => 100,
            'purpose' => "Order {$order->order_number}",
            'status' => FloosakPaymentAttempt::STATUS_COMPLETED,
            'gateway_purchase_id' => '1699240',
            'gateway_transaction_id' => '620453',
            'gateway_status_en' => 'Completed',
            'net' => 100,
            'completed_at' => now(),
        ]);

        Http::fake([
            'https://staging.fintech-expert.net/api/v1/auth/login' => Http::response([
                'data' => ['token' => 'ACCESS_TOKEN'],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/refund' => Http::response([
                'data' => [
                    'id' => 620493,
                    'reference_id' => 'Refund',
                    'status' => ['en' => 'Completed', 'ar' => 'مكتملة'],
                ],
                'is_success' => true,
            ]),
        ]);

        $refund = app(FloosakPaymentService::class)->refund($attempt, 40);

        $this->assertSame(FloosakRefund::STATUS_COMPLETED, $refund->status);
        $this->assertSame('620493', $refund->gateway_refund_transaction_id);

        $this->expectException(FloosakPaymentException::class);
        app(FloosakPaymentService::class)->refund($attempt, 70);
    }

    private function createFloosakOrder(array $overrides = []): Order
    {
        return Order::create(array_merge([
            'order_number' => 'ORD-' . uniqid(),
            'user_id' => $this->customer->id,
            'store_id' => $this->store->id,
            'total_amount' => 100,
            'status' => 'pending',
            'shipping_address' => 'Sanaa',
            'payment_method' => 'floosak_wallet',
            'payment_status' => 'pending',
        ], $overrides));
    }

    private function createPendingAttempt(Order $order): FloosakPaymentAttempt
    {
        return FloosakPaymentAttempt::create([
            'order_id' => $order->id,
            'user_id' => $this->customer->id,
            'request_id' => 'REQ-' . uniqid(),
            'source_wallet_id' => 10000,
            'target_phone' => $this->customer->phone,
            'amount' => $order->total_amount,
            'purpose' => "Order {$order->order_number}",
            'status' => FloosakPaymentAttempt::STATUS_PENDING,
            'gateway_purchase_id' => '1699240',
            'gateway_status_en' => 'Pending',
        ]);
    }

    private function fakeLoginAndSend(): void
    {
        Http::fake([
            'https://staging.fintech-expert.net/api/v1/auth/login' => Http::response([
                'data' => ['token' => 'ACCESS_TOKEN'],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl' => Http::response([
                'data' => [
                    'name' => 'Customer Name',
                    'balance' => 300,
                    'phone' => '967711111111',
                    'status' => ['en' => 'Pending', 'ar' => 'معلقه'],
                    'net' => 100,
                    'fee' => 1,
                    'gross' => 101,
                    'reference_id' => '4633395571756870',
                    'id' => 1699240,
                    'created_at' => '2026-02-22T10:41:11',
                ],
                'is_success' => true,
            ]),
        ]);
    }

    private function fakeLoginAndConfirm(string $status): void
    {
        Http::fake([
            'https://staging.fintech-expert.net/api/v1/auth/login' => Http::response([
                'data' => ['token' => 'ACCESS_TOKEN'],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/confirm' => Http::response([
                'data' => [
                    'name' => 'Customer Name',
                    'balance' => 400,
                    'phone' => '967711111111',
                    'status' => ['en' => $status, 'ar' => $status === 'Completed' ? 'مكتملة' : 'معلقه'],
                    'net' => 100,
                    'fee' => 1,
                    'gross' => 101,
                    'reference_id' => '4633391771756870',
                    'id' => 620453,
                    'created_at' => '2026-02-22T10:56:35',
                ],
                'is_success' => true,
            ]),
        ]);
    }
}
