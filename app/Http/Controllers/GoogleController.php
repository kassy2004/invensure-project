<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Models\Audit;
use App\Models\User;
use Illuminate\Support\Str;
class GoogleController extends Controller
{
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // return redirect('/login')->withErrors([
                //     'email' => 'Your Google account is not registered in our system.',
                // ]);
                // Create new user with pending status
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)), // random password since login is via Google
                    'role' => 'pending', // waiting for admin approval
                ]);
                Auth::login($user);

                Audit::create([
                    'user_type' => get_class($user),
                    'user_id' => $user->id,
                    'event' => 'Signed Up (Pending Approval)',
                    'auditable_type' => get_class($user),
                    'auditable_id' => $user->id,
                    'old_values' => [],
                    'new_values' => ['action' => 'Google Signup', 'status' => 'pending'],
                    'url' => request()->fullUrl(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->header('User-Agent'),
                ]);

                return redirect()->route('pending-approval');
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
            if ($user->role === 'pending') {
                return redirect()->route('pending-approval');
            }


            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'oauth' => 'Google login failed. Please try again.',
            ]);
        }
    }
}
