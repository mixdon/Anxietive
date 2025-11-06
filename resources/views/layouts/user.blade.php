<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'anxietive')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI",
                "Helvetica Neue", Arial, sans-serif;
        }

        #menu {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #menu.hidden {
            opacity: 0;
            visibility: hidden;
        }

        #menu.flex {
            opacity: 1;
            visibility: visible;
        }

    </style>
</head>

<body class="bg-white text-gray-900">

    <!-- NAVBAR -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">

        <!-- Layer 1 -->
        <div class="w-full px-4 lg:px-8 flex items-center justify-between py-3 border-b border-gray-200">
            <!-- Kiri: Bahasa -->
            <div class="flex items-center space-x-3 text-sm text-gray-700">
                <a href="{{ url('lang/id') }}"
                    class="{{ app()->getLocale() == 'id' ? 'font-semibold text-black' : 'hover:text-black' }}">ID</a>
                <span>|</span>
                <a href="{{ url('lang/en') }}"
                    class="{{ app()->getLocale() == 'en' ? 'font-semibold text-black' : 'hover:text-black' }}">EN</a>
            </div>

            <!-- Tengah: Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo/anxietive_logo.PNG') }}" alt="Logo" class="h-10 w-auto">
            </a>

            <!-- Kanan: Hamburger (mobile) / User / Login -->
            <div class="flex items-center space-x-4">
                <!-- Hamburger untuk mobile -->
                <button id="menu-toggle" class="md:hidden text-2xl text-gray-700 focus:outline-none">☰</button>

                <!-- Login / User (desktop) -->
                <div class="hidden md:flex items-center">
                    @guest('customer')
                    <a href="{{ route('customer.login') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-black transition">
                        <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon" class="h-5 w-auto">
                        <span class="font-medium">{{ __('messages.login') }}</span>
                    </a>
                    @endguest

                    @auth('customer')
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-2 text-gray-700 hover:text-black transition focus:outline-none">
                            <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon" class="h-6 w-auto">
                            <span
                                class="hidden md:inline font-medium">{{ Auth::guard('customer')->user()->fullname ?? __('messages.account') }}</span>
                            <svg class="w-4 h-4 mt-0.5 text-gray-600 group-hover:text-black transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 shadow-lg rounded-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('customer.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('messages.profile') }}</a>
                            <a href="{{ route('customer.bookings') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('messages.my_bookings') }}</a>
                            <div class="border-t my-1"></div>
                            <form action="{{ route('customer.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ __('messages.logout') }}</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Layer 2 (desktop menu) -->
        <div class="hidden md:flex w-full px-4 lg:px-8 py-3 justify-center space-x-8 text-sm font-medium">
            <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.home') }}</a>
            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}"
                class="{{ request()->routeIs('contact') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.contact') }}</a>
            <a href="{{ route('pricelist') }}"
                class="{{ request()->routeIs('pricelist') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.pricelist') }}</a>
            <a href="{{ route('booking') }}"
                class="{{ request()->routeIs('booking') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.booking') }}</a>
        </div>

        <!-- MENU MOBILE -->
        <nav id="menu"
            class="hidden fixed inset-0 bg-white z-40 flex flex-col items-center justify-center space-y-8 text-lg font-medium">
            <button id="menu-close" class="absolute top-6 right-6 text-3xl text-gray-700">✕</button>

            <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.home') }}</a>
            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.about') }}</a>
            <a href="{{ route('contact') }}"
                class="{{ request()->routeIs('contact') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.contact') }}</a>
            <a href="{{ route('pricelist') }}"
                class="{{ request()->routeIs('pricelist') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.pricelist') }}</a>
            <a href="{{ route('booking') }}"
                class="{{ request()->routeIs('booking') ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">{{ __('messages.booking') }}</a>

            @guest('customer')
            <a href="{{ route('customer.login') }}"
                class="flex items-center space-x-2 text-gray-700 hover:text-black transition">
                <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon" class="h-5 w-auto">
                <span class="font-medium">{{ __('messages.login') }}</span>
            </a>
            @endguest

            @auth('customer')
            <a href="{{ route('customer.profile') }}"
                class="text-gray-700 hover:text-black">{{ __('messages.profile') }}</a>
            <a href="{{ route('customer.bookings') }}"
                class="text-gray-700 hover:text-black">{{ __('messages.my_bookings') }}</a>
            <form action="{{ route('customer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-black">{{ __('messages.logout') }}</button>
            </form>
            @endauth
        </nav>

    </header>

    <!-- MAIN -->
    <main class="min-h-[70vh] pt-36">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-gray-100 bg-white mt-10">
        <div class="w-full px-4 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600">
                © 2025 by <span class="font-semibold">anxietive</span>
            </p>

            <!-- Ikon Sosial Media -->
            <div class="flex items-center space-x-3">
                <!-- Instagram -->
                <a href="https://www.instagram.com/anxietive/" target="_blank" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/logo/ig_logo.png') }}" alt="Instagram Logo" class="w-5 h-5" />
                </a>

                <!-- TikTok -->
                <a href="https://www.tiktok.com/@anxietive" target="_blank" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/logo/tiktok_logo.png') }}" alt="TikTok Logo" class="w-5 h-5" />
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/6281234567890" target="_blank" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/logo/wa_logo.png') }}" alt="WhatsApp Logo" class="w-5 h-5" />
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/anxietive" target="_blank" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/logo/fb_logo.png') }}" alt="Facebook Logo" class="w-5 h-5" />
                </a>
            </div>
        </div>
    </footer>


    {{-- SCRIPT MENU --}}
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menuClose = document.getElementById('menu-close');
        const menu = document.getElementById('menu');

        menuToggle.addEventListener('click', () => {
            menu.classList.remove('hidden');
            menu.classList.add('flex');
        });

        menuClose.addEventListener('click', () => {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
        });

    </script>

    @stack('scripts')
</body>

</html>
