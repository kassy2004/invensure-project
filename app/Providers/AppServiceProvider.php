<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // make sure this is at the top
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
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
        View::composer('layouts.sidebar', function ($view) {
            $warehouses = DB::table('warehouses')->get();
            $view->with('warehouses', $warehouses);
        });
        Storage::extend('dropbox', function (Application $app, array $config) {
            $adapter = new DropboxAdapter(new DropboxClient(
                $config['authorization_token']
            ));

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });

        // Register Google Drive filesystem driver
        // Storage::extend('google', function ($app, $config) {
        //     $client = new Google_Client();
        //     $client->setClientId($config['clientId']);
        //     $client->setClientSecret($config['clientSecret']);
        //     $client->refreshToken($config['refreshToken']);

        //     $service = new Google_Service_Drive($client);
        //     $adapter = new GoogleDriveAdapter($service, $config['folderId']);

        //     return new Flysystem($adapter);
        // });
        // Storage::extend('google', function ($app, $config) {
        //     $client = new Client();
        //     $client->setAuthConfig($config['service_account_credentials_json']);
        //     $client->addScope(GoogleDrive::DRIVE);
        //     $service = new GoogleDrive($client);

        //     $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);

        //     return new FilesystemAdapter(new Flysystem($adapter), $adapter);
        // });
        // Storage::extend('google', function ($app, $config) {
        //     $client = new Client();
        //     $client->setClientId($config['clientId']);
        //     $client->setClientSecret($config['clientSecret']);
        //     $client->refreshToken($config['refreshToken']);

        //     $service = new Drive($client);
        //     $adapter = new GoogleDriveAdapter($service, $config['folderId']);

        //     return new Filesystem($adapter);
        // });
    }
}
