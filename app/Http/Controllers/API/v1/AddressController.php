<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AddressController extends BaseController
{
    /**
     * Store a new shipping address.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'details' => 'nullable|string',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $address = Address::create($request->all());

        return $this->sendResponse($address, 'تم حفظ عنوان الشحن بنجاح', 201);
    }
}
