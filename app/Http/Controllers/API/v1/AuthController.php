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

        $code = rand(100000, 999999);
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

        // التأكد من إسناد دور العميل
        if (!$user->hasRole('customer')) {
            $user->assignRole('customer');
            $user->update(['role' => 'customer']);
        }

        // تسجيل نشاط الدخول في "بطاقة سجل أنشطة العملاء"
        \App\Models\CustomerActivity::create([
            'user_id' => $user->id,
            'activity_type' => 'login',
            'description' => 'تسجيل دخول من تطبيق الهاتف',
            'ip_address' => $request->ip(),
            'device_info' => $request->header('User-Agent'),
        ]);

        $success['token'] =  $user->createToken('MatjariApp')->plainTextToken;
        $success['user'] = $user;

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

    /**
     * Logout user and revoke token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'تم تسجيل الخروج بنجاح');
    }

    /**
     * Login user via identifier (email/phone) and password.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $identifier = $request->identifier;
        \Log::info('Login attempt', [
            'identifier' => $identifier,
            'password_length' => strlen($request->password),
            'ip' => $request->ip()
        ]);
        $user = User::where('email', $identifier)->orWhere('phone', $identifier)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            \Log::warning('Login failed', [
                'user_found' => (bool)$user,
                'identifier' => $identifier
            ]);
            return $this->sendError('بيانات الدخول غير صحيحة.', [], 401);
        }

        // Return token and role
        $success['token'] =  $user->createToken('MatjariAppAuth')->plainTextToken;
        $success['user'] = $user;
        $success['role'] = $user->role ?? 'customer'; // Default to customer if not set

        return $this->sendResponse($success, 'تم تسجيل الدخول بنجاح');
    }
}
