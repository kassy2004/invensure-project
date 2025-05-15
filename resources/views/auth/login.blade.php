<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold gradient-text">Welcome Back</h1>
        <p class="text-sm text-gray-600 mt-2">Sign in to access your Invensure dashboard</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:text-accent transition duration-150 order-2 sm:order-1 mt-3 sm:mt-0" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto justify-center bg-gradient-to-r from-brand-gold via-brand-orange to-brand-crimson hover:from-brand-orange hover:to-brand-crimson order-1 sm:order-2">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 pt-4 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600">
            {{ __("Don't have an account?") }} 
            <a href="{{ route('register') }}" class="text-primary hover:text-accent font-medium">{{ __('Sign up') }}</a>
        </p>
    </div>
</x-guest-layout>
