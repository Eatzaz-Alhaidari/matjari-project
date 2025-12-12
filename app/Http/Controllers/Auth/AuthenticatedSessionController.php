<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate(); // <-- هذا يتحقق من الإيميل وكلمة المرور

    // ##### بداية الكود المضاف #####
    $user = Auth::getProvider()->retrieveByCredentials($request->only('email'));
    if ($user && $user->status !== 'active') {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors([
            'email' => 'هذا الحساب غير نشط أو تم حظره.',
        ]);
    }
    // ##### نهاية الكود المضاف #####

    $request->session()->regenerate();

    // ... (باقي كود التوجيه لا يتغير)
    $url = '';
    if ($request->user()->hasRole('super-admin')) { /* ... */ }
    elseif ($request->user()->hasRole('vendor')) { /* ... */ }
    else { $url = '/'; }

    return redirect()->intended($url);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}