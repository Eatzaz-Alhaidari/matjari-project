<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\ChatbotResponse;
use App\Models\ChatbotRule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ChatbotController extends BaseController
{

    /**
     * Get all active chatbot rules.
     *
     * @return JsonResponse
     */
    public function rules(): JsonResponse
    {
        $rules = ChatbotRule::all();
        return $this->sendResponse($rules, 'تم جلب قواعد الشات بوت بنجاح');
    }

    /**
     * Store a chatbot response session from the app.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeResponse(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'message' => 'required|string',
            'response' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $chatbotResponse = ChatbotResponse::create($request->all());

        return $this->sendResponse($chatbotResponse, 'تم حفظ رد الشات بوت بنجاح', 201);
    }
}
