<?php

namespace Tests\Feature;

use App\Services\Floosak\FloosakClient;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FloosakClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();

        config([
            'floosak.base_url' => 'https://staging.fintech-expert.net',
            'floosak.merchant_phone' => '967700000000',
            'floosak.merchant_password' => 'secret',
            'floosak.source_wallet_id' => '10000',
        ]);
    }

    public function test_it_builds_documented_gateway_requests(): void
    {
        Http::fake([
            'https://staging.fintech-expert.net/api/v1/auth/login' => Http::response([
                'data' => ['token' => 'ACCESS_TOKEN'],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl' => Http::response([
                'data' => [
                    'id' => 1699240,
                    'status' => ['en' => 'Pending', 'ar' => 'معلقه'],
                ],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/confirm' => Http::response([
                'data' => [
                    'id' => 620453,
                    'status' => ['en' => 'Completed', 'ar' => 'مكتملة'],
                ],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/refund' => Http::response([
                'data' => [
                    'id' => 620493,
                    'status' => ['en' => 'Completed', 'ar' => 'مكتملة'],
                ],
                'is_success' => true,
            ]),
            'https://staging.fintech-expert.net/api/v1/merchant/check-status' => Http::response([
                'message' => [
                    'id' => 620453,
                    'status' => ['en' => 'Completed', 'ar' => 'مكتملة'],
                ],
                'is_success' => true,
                'statusCode' => 1,
            ]),
        ]);

        $client = app(FloosakClient::class);

        $client->sendPayment([
            'source_wallet_id' => 10000,
            'request_id' => 'REQ-1',
            'target_phone' => '967711111111',
            'amount' => 100,
            'purpose' => 'Order ORD-1',
        ]);
        $client->confirmPayment(1699240, '123456');
        $client->refundPayment(620453, 'REF-1', 10);
        $client->checkStatus('REQ-1');

        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://staging.fintech-expert.net/api/v1/auth/login'
                && $request->method() === 'POST'
                && $request->hasHeader('x-channel', 'merchant')
                && $request['phone'] === '967700000000'
                && $request['password'] === 'secret';
        });

        Http::assertSent(function (Request $request): bool {
            return $request->url() === 'https://staging.fintech-expert.net/api/v1/merchant/p2mcl'
                && $request->method() === 'POST'
                && $request->hasHeader('Authorization', 'Bearer ACCESS_TOKEN')
                && $request->hasHeader('x-channel', 'merchant')
                && $request['source_wallet_id'] === 10000
                && $request['request_id'] === 'REQ-1'
                && $request['target_phone'] === '967711111111'
                && $request['amount'] === 100
                && $request['purpose'] === 'Order ORD-1';
        });

        Http::assertSent(fn (Request $request): bool => $request->url() === 'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/confirm'
            && $request['purchase_id'] === 1699240
            && $request['otp'] === '123456');

        Http::assertSent(fn (Request $request): bool => $request->url() === 'https://staging.fintech-expert.net/api/v1/merchant/p2mcl/refund'
            && $request['transaction_id'] === 620453
            && $request['request_id'] === 'REF-1'
            && $request['amount'] === 10.0);

        Http::assertSent(fn (Request $request): bool => $request->url() === 'https://staging.fintech-expert.net/api/v1/merchant/check-status'
            && $request['request_id'] === 'REQ-1');
    }
}
