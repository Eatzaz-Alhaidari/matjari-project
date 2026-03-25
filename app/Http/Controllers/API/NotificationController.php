<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;
        return NotificationResource::collection($notifications);
    }

    public function store(NotificationRequest $request)
    {
        $validated = $request->validated();
        
        $notification = Notification::create($validated);
        
        return new NotificationResource($notification);
    }
}
