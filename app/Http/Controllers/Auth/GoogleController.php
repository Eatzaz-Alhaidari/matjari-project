<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // If user exists without a google_id, update it
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                // If user doesn't exist, create a new one
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => 'customer',
                    'password' => bcrypt(Str::random(16)),
                ]);

                // Assign role if using Spatie explicitly, as fallback
                if (method_exists($user, 'assignRole')) {
                    $user->assignRole('customer');
                }
            }

            Auth::login($user);

            // Redirect based on role logic
            if ($user->role === 'admin' || $user->hasRole('super-admin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'vendor' || $user->hasRole('vendor')) {
                return redirect('/vendor/dashboard');
            } else {
                // Default customer redirection
                return redirect('/');
            }

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong with Google Login: ' . $e->getMessage());
        }
    }
}
