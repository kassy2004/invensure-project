<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
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
            $notifications = DB::table('notifications')
                ->orderBy('created_at', 'desc')
                ->get();
    
            $unreadCount = DB::table('notifications')
                ->whereNull('read_at')
                ->count();
    
            $view->with('global_notifications', $notifications);
            $view->with('global_unread_count', $unreadCount);
        });
    }
}
