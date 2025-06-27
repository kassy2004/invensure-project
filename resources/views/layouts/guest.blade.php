<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="invensure">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" /> --}}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .gradient-text {
                background: linear-gradient(90deg, #FFD700, #FF6B35, #DC143C);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                color: transparent;
            }
            
            .auth-bg {
                background-color: #f9f9f9;
                background-image: radial-gradient(circle at 10% 20%, rgba(255, 215, 0, 0.2) 0%, transparent 30%),
                                 radial-gradient(circle at 80% 50%, rgba(255, 107, 53, 0.2) 0%, transparent 40%),
                                 radial-gradient(circle at 40% 80%, rgba(220, 20, 60, 0.2) 0%, transparent 30%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 auth-bg">
            <div class="mt-6">
                <a href="/">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-6 bg-white  overflow-hidden sm:rounded-xl border border-gray-300">
                {{ $slot }}
            </div>
            
            <div class="mt-6 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} Invensure. All rights reserved.
            </div>
        </div>
    </body>
</html>
