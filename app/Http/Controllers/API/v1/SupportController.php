<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SupportController extends BaseController
{
    /**
     * Store tech support request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'issue' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $support = SupportRequest::create([
            'user_id' => $request->user_id,
            'issue' => $request->issue,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return $this->sendResponse($support, 'تم استقبال طلب الدعم الفني بنجاح', 201);
    }
}
