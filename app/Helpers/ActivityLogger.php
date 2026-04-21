<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log an activity.
     *
     * @param string $actionType (create, update, delete, login, logout, payment, etc.)
     * @param string $description
     * @param string|null $subjectType
     * @param int|null $subjectId
     * @param string $severity (low, medium, high)
     * @param int|null $userId (Optional, defaults to Auth::id())
     * @return ActivityLog
     */
    public static function log($actionType, $description, $subjectType = null, $subjectId = null, $severity = 'low', $userId = null)
    {
        $user = $userId ? \App\Models\User::find($userId) : Auth::user();

        $userType = 'guest';
        if ($user) {
            if ($user->hasRole('super-admin')) {
                $userType = 'admin';
            } elseif ($user->hasRole('vendor')) {
                $userType = 'vendor';
            } else {
                $userType = 'customer';
            }
        }

        try {
            return ActivityLog::create([
                'user_id' => $user ? $user->id : null,
                'user_type' => $userType,
                'action_type' => $actionType,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'severity' => $severity,
            ]);
        } catch (\Exception $e) {
            // في حال فشل تسجيل النشاط (مثلاً جدول غير موجود)، لا نعطل السيرفر
            \Log::error("ActivityLogger failed: " . $e->getMessage());
            return new ActivityLog(); // نرجع مودل فارغ لتجنب كسر الكود
        }
    }
}
