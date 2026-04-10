<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CustomerActivity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ActivityController extends BaseController
{
    /**
     * Store customer activity.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'activity' => 'required|string',
            'details' => 'nullable|string',
            'timestamp' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $activity = CustomerActivity::create([
            'user_id' => $request->user_id,
            'activity_type' => $request->activity,
            'description' => $request->details,
            'ip_address' => $request->ip(),
            'device_info' => $request->header('User-Agent'),
        ]);

        return $this->sendResponse($activity, 'تم تسجيل النشاط بنجاح', 201);
    }
}
