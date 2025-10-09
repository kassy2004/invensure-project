<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;
use App\Models\User;

class GoogleController extends Controller
{
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                return redirect('/login')->withErrors([
                    'email' => 'Your Google account is not registered in our system.',
                ]);
            }

            Auth::login($user);

            Audit::create([
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'event' => 'Logged In',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->id,
                'old_values' => [],
                'new_values' => ['action' => 'Google Login', 'status' => 'success'],
                'url' => request()->fullUrl(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'oauth' => 'Google login failed. Please try again.',
            ]);
        }
    }
}
