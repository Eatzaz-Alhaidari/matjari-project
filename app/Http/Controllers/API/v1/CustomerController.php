<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseController
{
    /**
     * Register a new customer.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['role'] = 'customer'; // Default role

        $user = User::create($input);

        $success['token'] =  $user->createToken('MatjariApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'تم تسجيل الحساب بنجاح', 201);
    }
}
