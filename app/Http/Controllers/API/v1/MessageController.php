<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\StoreMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class MessageController extends BaseController
{
    /**
     * Store message to vendor.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = \App\Models\User::find($request->user_id);

        $message = StoreMessage::create([
            'user_id' => $request->user_id,
            'store_id' => $request->store_id,
            'message' => $request->message,
            'customer_name' => $user->name,
            'is_read' => false,
            'is_from_vendor' => false,
        ]);

        return $this->sendResponse($message, 'تم إرسال الرسالة إلى التاجر بنجاح', 201);
    }
}
