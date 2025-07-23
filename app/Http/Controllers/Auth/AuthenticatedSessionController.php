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
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();


        \OwenIt\Auditing\Models\Audit::create([
            'user_type' => get_class($user),
            'user_id' => $user->id,
            'event' => 'Logged In',
            'auditable_type' => get_class($user),
            'auditable_id' => $user->id,
            'old_values' => [],
            'new_values' => ['status' => 'User logged in'],
            'url' => url()->current(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();


        \OwenIt\Auditing\Models\Audit::create([
            'user_type' => get_class($user),
            'user_id' => $user->id,
            'event' => 'Logged Out',
            'auditable_type' => get_class($user),
            'auditable_id' => $user->id,
            'old_values' => [],
            'new_values' => ['status' => 'User logged out'],
            'url' => url()->current(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
