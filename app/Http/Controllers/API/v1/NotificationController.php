<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NotificationController extends BaseController
{
    /**
     * Get notifications for a specific user.
     *
     * @param int $user_id
     * @return JsonResponse
     */
    public function index($user_id): JsonResponse
    {
        $notifications = Notification::where('user_id', $user_id)
            ->latest()
            ->get();

        return $this->sendResponse($notifications, 'تم جلب الإشعارات بنجاح');
    }

    /**
     * Store a notification sent from the app.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return $this->sendResponse($notification, 'تم استقبال الإشعار بنجاح', 201);
    }
}
