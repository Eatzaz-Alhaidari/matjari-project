<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;
use App\Helpers\ActivityLogger;
use Illuminate\Events\Dispatcher;

class LogAuthActivity
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleLogin',
            Logout::class => 'handleLogout',
            Failed::class => 'handleFailedLogin',
            PasswordReset::class => 'handlePasswordReset',
        ];
    }

    public function handleLogin(Login $event): void
    {
        ActivityLogger::log('login', 'User logged in', 'user', $event->user->id, 'low', $event->user->id);
    }

    public function handleLogout(Logout $event): void
    {
        if ($event->user) {
            ActivityLogger::log('logout', 'User logged out', 'user', $event->user->id, 'low', $event->user->id);
        }
    }

    public function handleFailedLogin(Failed $event): void
    {
        ActivityLogger::log('login_failed', 'Failed login attempt for email: ' . $event->credentials['email'], 'user', null, 'medium');
    }

    public function handlePasswordReset(PasswordReset $event): void
    {
        ActivityLogger::log('password_reset', 'User reset their password', 'user', $event->user->id, 'high', $event->user->id);
    }
}
