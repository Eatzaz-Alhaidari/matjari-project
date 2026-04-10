<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\OrderReturn;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ReturnController extends BaseController
{
    /**
     * Store product return request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'reason' => 'required|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $orderReturn = OrderReturn::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'reason' => $request->reason,
            'status' => $request->status ?? 'pending',
        ]);

        return $this->sendResponse($orderReturn, 'تم استقبال طلب الإرجاع بنجاح', 201);
    }
}
