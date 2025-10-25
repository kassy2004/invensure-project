<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="text-center flex justify-center mb-2">
            <x-logo textClass="gradient-text" />

        </div>
        <h1 class="text-2xl font-bold text-orange-500">Welcome Back</h1>
        <p class="text-sm text-gray-600 mt-2">Sign in to access your Invensure dashboard</p>
    </div>
    <a href="{{ url('/auth/google') }}"
        class="flex items-center border border-gray-300 hover:border-gray-400 py-2 rounded-md justify-center gap-2">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" width="20">
        Continue with Google
    </a>
    <div class="flex items-center w-full my-4">
        <hr class="flex-grow border-gray-300">
        <span class="mx-2 text-gray-500">or</span>
        <hr class="flex-grow border-gray-300">
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input id="email"
                class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />

            <div class="relative">
                <x-text-input id="password"
                    class="block mt-1 w-full border-gray-300 rounded-md focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 pr-10"
                    type="password" name="password" placeholder="•••••••" required autocomplete="current-password" />

                <!-- Eye Icon Button -->
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700"
                    tabindex="-1">
                    {{-- eye open --}}
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye transition-all duration-300 ease-in-out"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                    {{-- eye close --}}
                    {{-- <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-closed-icon lucide-eye-closed transition-all duration-300 ease-in-out opacity-0 absolute" style="display: none;"><path d="m15 18-.722-3.25"/><path d="M2 8a10.645 10.645 0 0 0 20 0"/><path d="m20 15-1.726-2.05"/><path d="m4 15 1.726-2.05"/><path d="m9 18 .722-3.25"/></svg> --}}

                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off-icon lucide-eye-off transition-all duration-300 ease-in-out opacity-0 absolute" style="display: none;">
                        <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
                        <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                        <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                        <path d="m2 2 20 20"/>
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:text-accent transition duration-150 order-2 sm:order-1 mt-3 sm:mt-0"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto justify-center bg-orange-500 order-1 sm:order-2">
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
<script src="https://unpkg.com/lucide@latest"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    togglePassword.addEventListener('click', () => {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';

        // Toggle visibility of the icons with smooth transitions
        if (isHidden) {
            // Show password - fade out eye icon, fade in eye-closed icon
            eyeOpen.style.opacity = '0';
            eyeClosed.style.opacity = '1';
            eyeClosed.style.display = 'block';
        } else {
            // Hide password - fade in eye icon, fade out eye-closed icon
            eyeOpen.style.opacity = '1';
            eyeClosed.style.opacity = '0';
            setTimeout(() => {
                if (eyeClosed.style.opacity === '0') {
                    eyeClosed.style.display = 'none';
                }
            }, 300); // Match the transition duration
        }
    });
});
</script>
