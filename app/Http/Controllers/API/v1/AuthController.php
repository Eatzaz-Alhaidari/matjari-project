<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * Send OTP code to a specific phone number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $code = rand(1000, 9999);
        $identifier = $request->phone;

        OtpCode::updateOrCreate(
            ['identifier' => $identifier],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10),
                'is_used' => false,
                'type' => 'auth'
            ]
        );

        // In real app, send SMS here. For now returning in response for testing.
        return $this->sendResponse(['code' => $code], 'تم إرسال رمز التحقق بنجاح');
    }

    /**
     * Verify OTP code and login / return token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'code' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $otp = OtpCode::where('identifier', $request->phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->where('is_used', false)
            ->first();

        if (!$otp) {
            return $this->sendError('رمز التحقق غير صحيح أو منتهي الصلاحية', [], 401);
        }

        $otp->update(['is_used' => true]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->sendError('المستخدم غير موجود، يرجى إنشاء حساب أولاً', [], 404);
        }

        $success['token'] =  $user->createToken('MatjariApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'تم التحقق وتسجيل الدخول بنجاح');
    }

    /**
     * Change user password.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = User::find($request->user_id);

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->sendError('كلمة المرور القديمة غير صحيحة', [], 401);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return $this->sendResponse([], 'تم تغيير كلمة المرور بنجاح');
    }
}
