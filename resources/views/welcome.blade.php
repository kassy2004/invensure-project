<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="invensure">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Invensure - Supply Chain Management Platform for Sunny & Scramble's perishable chicken goods business">

    <title>Invensure - Supply Chain Management Platform</title>

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

        .hero-bg {
            background-color: #f9f9f9;
            background-image: radial-gradient(circle at 10% 20%, rgba(255, 215, 0, 0.2) 0%, transparent 30%),
                radial-gradient(circle at 80% 50%, rgba(255, 107, 53, 0.2) 0%, transparent 40%),
                radial-gradient(circle at 40% 80%, rgba(220, 20, 60, 0.2) 0%, transparent 30%);
        }

        .cta-bg {
            background-image: radial-gradient(circle at 30% 30%, rgba(255, 215, 0, 0.3) 0%, transparent 40%),
                radial-gradient(circle at 70% 60%, rgba(255, 107, 53, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 50% 100%, rgba(220, 20, 60, 0.3) 0%, transparent 40%);
        }
    </style>
</head>

<body class="antialiased font-sans bg-white">
    <div class="min-h-screen hero-bg">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white/30 backdrop-blur-sm">
            <div class=" container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex-shrink-0">
                            <x-invensure-logo />
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-10">
                        <a href="#features"
                            class="text-zinc-600 hover:text-opacity-80 font-medium transition duration-150">Features</a>
                        <a href="#about"
                            class="text-zinc-600 hover:text-opacity-80 font-medium transition duration-150">About</a>
                        <a href="#contact"
                            class="text-zinc-600 hover:text-opacity-80 font-medium transition duration-150">Contact</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center">
                        @if (Route::has('login'))
                            <div class="flex items-center space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                        class="btn btn-sm bg-white text-primary hover:bg-white hover:text-primary border-none">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="btn btn-md shadow-none rounded-lg border border-gray-300 bg-transparent text-zinc-900 font-bold hover:bg-zinc-200 transition duration-300 ease-in-out ">Login</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="btn btn-md rounded-lg bg-orange-500 shadow-none broder border-orange-500 hover:bg-orange-400 transition duration-300 ease-in-out">Sign
                                            Up</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button type="button" class="text-white hover:text-opacity-80" id="mobile-menu-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Menu (hidden by default) -->
                <div class="hidden md:hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="#features"
                            class="block px-3 py-2 text-white hover:text-opacity-80 font-medium">Features</a>
                        <a href="#about" class="block px-3 py-2 text-white hover:text-opacity-80 font-medium">About</a>
                        <a href="#contact"
                            class="block px-3 py-2 text-white hover:text-opacity-80 font-medium">Contact</a>
                    </div>
                </div>

            </div>
        </header>

        <!-- Hero Section -->
        <section id="hero" class="hero-bg">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mx-auto text-center md:w-1/2 mb-12 md:mb-0">
                        <h1 class="text-zinc-900 mt-8 max-w-4xl text-balance mx-auto text-6xl md:text-7xl lg:mt-16 ">
                            Streamline Your Supply Chain
                        </h1>
                        {{-- <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                            <span class="">Streamline Your Supply Chain</span>
                        </h1> --}}
                        <p class="mx-auto mt-8 max-w-2xl text-balance text-lg text-zinc-800">
                            Highly customizable components for building modern websites and applications that look and
                            feel the way you mean it.
                        </p>
                        {{-- <p class="text-lg md:text-xl text-gray-700 mb-8">
                            A comprehensive supply chain management platform tailored specifically for Sunny &
                            Scramble's perishable chicken goods business. Manage inventory, track shipments, and ensure
                            quality in one secure platform.
                        </p> --}}
                        <div class="flex space-y-4 sm:space-y-0 sm:space-x-4 justify-center mt-12">
                            <a href="{{ Route::has('register') ? route('register') : '#' }}"
                                class="bg-orange-500 hover:bg-orange-400 transition duration-500 ease-in-out flex gap-2 items-center text-white px-6 py-3 justify-center rounded-xl">

                                <span>Get Started</span>
                                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg> --}}
                                <x-lucide-move-right class="h-5 w-5" />
                            </a>
                            <a href="#features"
                                class="text-zinc-800 text-center flex items-center justify-center px-4 py-2 rounded-xl border border-transparent hover:border-zinc-400 hover:text-zinc-950 transition duration-500 ease-in-out">
                                <span>Learn More</span>
                            </a>
                        </div>
                    </div>
                    {{-- <div class="md:w-1/2">
                        <div class="relative">
                            <!-- Decorative circles -->
                            <div
                                class="absolute -top-12 -right-4 w-32 h-32 rounded-full bg-brand-gold opacity-20 blur-xl">
                            </div>
                            <div
                                class="absolute bottom-10 -left-8 w-40 h-40 rounded-full bg-brand-orange opacity-20 blur-xl">
                            </div>
                            <div
                                class="absolute top-20 left-20 w-24 h-24 rounded-full bg-brand-crimson opacity-20 blur-xl">
                            </div>

                            <!-- Hero image -->
                            {{-- <img src="https://placehold.co/600x400/f5f5f5/333?text=Invensure+Platform" alt="Invensure Platform" class="rounded-lg shadow-2xl w-full"> --}}
                    {{-- </div>
                    </div>  --}}
                </div>
            </div>

            <div class="relative -mr-56 mt-8 overflow-hidden px-2 sm:mr-0 sm:mt-12 md:mt-20">
                <div aria-hidden="true"
                    class="bg-gradient-to-b from-transparent to-white absolute inset-0 z-10 from-[35%]"></div>
                <div
                    class="bg-white inset-shadow-2xs ring-background dark:inset-shadow-white/20 bg-background relative mx-auto w-full  overflow-hidden rounded-2xl border p-4 ">
                    <img class="border border-border/25 bg-background aspect-[15/8] relative rounded-2xl hidden dark:block opacity-0 dark:opacity-100 transition-opacity duration-700"
                        src="https://tailark.com/_next/image?url=%2Fmail2-light.png&amp;w=3840&amp;q=75"
                        alt="app screen" width="2700" height="1440">
                </div>
            </div>

        </section>



        <!-- Features Section -->
        <section id="features" class="py-20 bg-gradient-to-b from-white to-yellow-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        <span class="text-zinc-900">Powerful Features</span>
                    </h2>
                    <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                        Our comprehensive platform provides all the tools you need to efficiently manage your supply
                        chain,
                        from inventory tracking to quality assurance and real-time analytics.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1: Inventory Management -->
                    <div
                        class="card bg-transparent border border-gray-300 rounded-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body">
                            <div
                                class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-brand-gold bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-gold" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <h3 class="card-title text-xl font-bold text-zinc-800">Inventory Management</h3>
                            <p class="text-gray-600">
                                Real-time tracking with expiration monitoring for perishable goods. Never lose track of
                                your inventory again.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2: Logistics Coordination -->
                    <div
                    class="card bg-transparent border border-gray-300 rounded-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body">
                            <div
                                class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-brand-orange bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-orange" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-xl font-bold text-zinc-800">Logistics Coordination</h3>
                            <p class="text-gray-600">
                                Optimize delivery routes and track shipments in real-time for maximum efficiency and
                                transparency.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3: Quality Assurance -->
                    <div
                    class="card bg-transparent border border-gray-300 rounded-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body">
                            <div
                                class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-brand-crimson bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-crimson"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-xl font-bold text-zinc-800">Quality Assurance</h3>
                            <p class="text-gray-600">
                                Maintain high standards with comprehensive quality control tools designed for perishable
                                goods.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4: Real-time Analytics -->
                    <div
                    class="card bg-transparent border border-gray-300 rounded-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body">
                            <div
                                class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-brand-gold bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-gold"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-xl font-bold text-zinc-800">Real-time Analytics</h3>
                            <p class="text-gray-600">
                                Make data-driven decisions with powerful analytics tools that provide actionable
                                insights.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 5: Role-Based Access -->
                    <div
                    class="card bg-transparent border border-gray-300 rounded-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body">
                            <div
                                class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-brand-orange bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-orange"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-xl font-bold text-zinc-800">Role-Based Access</h3>
                            <p class="text-gray-600">
                                Customized dashboards and permissions for different team roles, ensuring the right
                                access for everyone.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 6: Secure Platform -->
                    <div
                    class="card bg-transparent border border-gray-300 rounded-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="card-body">
                            <div
                                class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-brand-crimson bg-opacity-20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-crimson"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-xl font-bold text-zinc-800">Secure Platform</h3>
                            <p class="text-gray-600">
                                Enterprise-grade security to protect your sensitive supply chain data and business
                                intelligence.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section id="cta" class="relative py-20 cta-bg">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
                {{-- <div
                    class="max-w-3xl mx-auto bg-gradient-to-r from-brand-gold via-brand-orange to-brand-crimson p-1 rounded-xl shadow-xl">
                    <div class="bg-white dark:bg-gray-900 rounded-lg p-8 md:p-12 text-center">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">
                            <span class="gradient-text">Ready to Transform Your Supply Chain?</span>
                        </h2>
                        <p class="text-lg text-gray-700 mb-8">
                            Join Sunny & Scramble and hundreds of other businesses that rely on Invensure to streamline
                            their supply chain management.
                        </p>
                        <a href="{{ Route::has('register') ? route('register') : '#' }}"
                            class="btn btn-lg btn-primary text-white px-8 md:px-12">
                            Get Started Today
                        </a>
                    </div>
                </div> --}}
                <x-glow-card glow-color="orange" size="lg" class="text-white">
                    <p class="text-lg">Welcome to Spotlight Glow in Laravel ✨</p>
                </x-glow-card>
            </div>
        </section>

   

        <!-- Footer -->
        <footer class="bg-neutral text-neutral-content">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <x-invensure-logo textClass="text-neutral-content" />
                        <p class="mt-4">
                            Streamlining supply chain management for Sunny & Scramble's perishable goods business.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#hero" class="hover:text-primary transition">Home</a></li>
                            <li><a href="#features" class="hover:text-primary transition">Features</a></li>
                            <li><a href="#about" class="hover:text-primary transition">About</a></li>
                            <li><a href="#contact" class="hover:text-primary transition">Contact</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold mb-4">Legal</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-primary transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-primary transition">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-primary transition">Cookie Policy</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold mb-4">Connect</h3>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="#" class="hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                </svg>
                            </a>
                            <a href="#" class="hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                </svg>
                            </a>
                            <a href="#" class="hover:text-primary transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                        </div>
                        <p>
                            Email: <a href="mailto:contact@invensure.com"
                                class="hover:text-primary transition">contact@invensure.com</a>
                        </p>
                        <p>Phone: +1 (555) 123-4567</p>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-neutral-content border-opacity-10 text-center">
                    <p>&copy; {{ date('Y') }} Invensure. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
