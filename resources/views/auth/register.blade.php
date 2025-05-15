<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold gradient-text">Create Account</h1>
        <p class="text-sm text-gray-600 mt-2">Join Invensure to streamline your supply chain</p>
    </div>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
            <a class="text-sm text-primary hover:text-accent transition duration-150 order-2 sm:order-1 mt-3 sm:mt-0" href="{{ route('login') }}">
                {{ __('Already have an account?') }}
            </a>

            <x-primary-button class="w-full sm:w-auto justify-center bg-gradient-to-r from-brand-gold via-brand-orange to-brand-crimson hover:from-brand-orange hover:to-brand-crimson order-1 sm:order-2">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    
    <div class="mt-6 pt-4 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600">
            {{ __('By registering, you agree to our') }}
            <a href="#" class="text-primary hover:text-accent">{{ __('Terms') }}</a>
            {{ __('and') }}
            <a href="#" class="text-primary hover:text-accent">{{ __('Privacy Policy') }}</a>
        </p>
    </div>
</x-guest-layout>
