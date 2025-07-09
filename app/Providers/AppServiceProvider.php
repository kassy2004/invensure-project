<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // make sure this is at the top

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role === 'inventory_manager') {
                    $notifications = DB::table('notifications')
                        ->where('for', 'inventory_manager')
                        ->orderBy('created_at', 'desc')
                        ->get();

                    $unreadCount = DB::table('notifications')
                        ->where('for', 'inventory_manager')
                        ->whereNull('read_at')
                        ->count();

                } else {
                    $notifications = DB::table('notifications')
                        ->where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

                    $unreadCount = DB::table('notifications')
                        ->where('user_id', $user->id)
                        ->whereNull('read_at')
                        ->count();
                }


                $view->with('global_notifications', $notifications);
                $view->with('global_unread_count', $unreadCount);
            }
        });
    }
}
