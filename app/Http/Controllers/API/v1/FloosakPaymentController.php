<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\FloosakPaymentAttempt;
use App\Models\Order;
use App\Services\Floosak\FloosakPaymentException;
use App\Services\Floosak\FloosakPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FloosakPaymentController extends BaseController
{
    public function __construct(private readonly FloosakPaymentService $payments)
    {
    }

    public function initiate(Request $request, Order $order): JsonResponse
    {
        try {
            $attempt = $this->payments->initiate($order, $request->user());

            return $this->sendResponse(
                $this->attemptPayload($attempt),
                'تم بدء عملية الدفع عبر محفظة فلوسك بنجاح',
                201
            );
        } catch (FloosakPaymentException $exception) {
            return $this->sendError($exception->getMessage(), $exception->errors, $exception->httpStatus);
        }
    }

    public function confirm(Request $request, FloosakPaymentAttempt $attempt): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $otp = $request->input('otp');
        if (!is_scalar($otp) || (string) $otp === '' || strlen((string) $otp) > 20) {
            return $this->sendError('Validation Error.', [
                'otp' => ['The otp field must be a string or number up to 20 characters.'],
            ], 422);
        }

        try {
            $attempt = $this->payments->confirm($attempt, $request->user(), (string) $otp);

            return $this->sendResponse(
                $this->attemptPayload($attempt),
                $attempt->isCompleted()
                    ? 'تم تأكيد الدفع بنجاح'
                    : 'تم إرسال تأكيد الدفع وتحديث حالة العملية'
            );
        } catch (FloosakPaymentException $exception) {
            return $this->sendError($exception->getMessage(), $exception->errors, $exception->httpStatus);
        }
    }

    public function show(Request $request, FloosakPaymentAttempt $attempt): JsonResponse
    {
        if ((int) $attempt->user_id !== (int) $request->user()->id) {
            return $this->sendError('لا يمكن عرض عملية دفع لا تخص المستخدم الحالي.', [], 403);
        }

        return $this->sendResponse($this->attemptPayload($attempt), 'تم جلب حالة الدفع بنجاح');
    }

    private function attemptPayload(FloosakPaymentAttempt $attempt): array
    {
        return [
            'payment_attempt_id' => $attempt->id,
            'order_id' => $attempt->order_id,
            'request_id' => $attempt->request_id,
            'gateway_purchase_id' => $attempt->gateway_purchase_id,
            'gateway_transaction_id' => $attempt->gateway_transaction_id,
            'gateway_reference_id' => $attempt->gateway_reference_id,
            'status' => $attempt->status,
            'gateway_status' => [
                'en' => $attempt->gateway_status_en,
                'ar' => $attempt->gateway_status_ar,
            ],
            'amount' => $attempt->amount,
            'net' => $attempt->net,
            'fee' => $attempt->fee,
            'gross' => $attempt->gross,
            'requires_otp' => $attempt->status === FloosakPaymentAttempt::STATUS_PENDING,
            'next_reconcile_at' => optional($attempt->next_reconcile_at)->toISOString(),
        ];
    }
}
