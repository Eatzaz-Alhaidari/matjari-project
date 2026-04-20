<?php

namespace App\Services\Floosak;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FloosakClient
{
    private const TOKEN_CACHE_KEY = 'floosak.merchant.access_token';

    public function login(): array
    {
        $payload = [
            'phone' => (string) config('floosak.merchant_phone'),
            'password' => (string) config('floosak.merchant_password'),
        ];

        return $this->decode(
            $this->baseRequest()->post('/api/v1/auth/login', $payload)
        );
    }

    public function forgetPassword(string $phone, string $identityNumber): array
    {
        return $this->decode(
            $this->baseRequest()->post('/api/v1/auth/forget-password', [
                'phone' => $phone,
                'identity_number' => $identityNumber,
            ])
        );
    }

    public function changePassword(string $phone, string $otp, string $newPassword): array
    {
        return $this->decode(
            $this->baseRequest()->post('/api/v1/auth/change-password', [
                'phone' => $phone,
                'otp' => $otp,
                'new_password' => $newPassword,
            ])
        );
    }

    /**
     * @throws ConnectionException
     * @throws FloosakApiException
     */
    public function sendPayment(array $payload): array
    {
        return $this->authorizedPost('/api/v1/merchant/p2mcl', $payload);
    }

    /**
     * @throws ConnectionException
     * @throws FloosakApiException
     */
    public function confirmPayment(string|int $purchaseId, string $otp): array
    {
        return $this->authorizedPost('/api/v1/merchant/p2mcl/confirm', [
            'otp' => $otp,
            'purchase_id' => $purchaseId,
        ]);
    }

    /**
     * @throws ConnectionException
     * @throws FloosakApiException
     */
    public function refundPayment(string|int $transactionId, string $requestId, float|string $amount): array
    {
        return $this->authorizedPost('/api/v1/merchant/p2mcl/refund', [
            'transaction_id' => $transactionId,
            'request_id' => $requestId,
            'amount' => $this->toGatewayAmount($amount),
        ]);
    }

    /**
     * @throws ConnectionException
     * @throws FloosakApiException
     */
    public function checkStatus(string $requestId): array
    {
        // The PDF documents /merchant/check-status. The Postman export contains
        // an /agent/check-status variant, but merchant reconciliation uses this path.
        return $this->authorizedPost('/api/v1/merchant/check-status', [
            'request_id' => $requestId,
        ]);
    }

    private function authorizedPost(string $path, array $payload, bool $allowTokenRefresh = true): array
    {
        $response = $this->baseRequest()
            ->withToken($this->accessToken())
            ->post($path, $payload);

        if ($response->status() === 401 && $allowTokenRefresh) {
            Cache::forget(self::TOKEN_CACHE_KEY);

            return $this->authorizedPost($path, $payload, false);
        }

        return $this->decode($response);
    }

    private function accessToken(): string
    {
        return Cache::remember(
            self::TOKEN_CACHE_KEY,
            now()->addSeconds((int) config('floosak.token_cache_ttl_seconds', 3300)),
            function (): string {
                $response = $this->login();
                $token = data_get($response, 'data.token');

                if (!is_string($token) || $token === '') {
                    throw new FloosakApiException('Floosak login did not return an access token.', 0, $response, false);
                }

                return $token;
            }
        );
    }

    private function baseRequest(): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('floosak.base_url'), '/'))
            ->acceptJson()
            ->asJson()
            ->timeout((int) config('floosak.timeout_seconds', 15))
            ->withHeaders([
                'x-channel' => 'merchant',
            ]);
    }

    private function decode(Response $response): array
    {
        $payload = $response->json();
        $payload = is_array($payload) ? $payload : [];

        if ($response->successful() && (int) data_get($payload, 'statusCode', 1) !== 2 && data_get($payload, 'is_success') !== false) {
            return $payload;
        }

        $message = data_get($payload, 'message');
        if (is_array($message)) {
            $message = 'Floosak API request failed.';
        }

        throw new FloosakApiException(
            $message ?: 'Floosak API request failed.',
            $response->status(),
            $payload,
            $this->isRetryable($response->status())
        );
    }

    private function isRetryable(int $status): bool
    {
        return $status === 409 || $status === 429 || $status >= 500;
    }

    private function toGatewayAmount(float|string $amount): float
    {
        return round((float) $amount, 2);
    }
}
