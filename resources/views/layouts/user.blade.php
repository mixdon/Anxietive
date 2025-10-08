<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'anxietive')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    @stack('styles')

    <style>
        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI",
                "Helvetica Neue", Arial, sans-serif;
        }

    </style>
</head>

<body class="bg-white text-gray-900">
    <!-- NAVBAR -->
    <header class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto flex items-center justify-between px-6 py-6">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-3xl font-extralight tracking-tight flex items-center">
                <img src="{{ asset('images/logo/anxietive_logo.PNG') }}" alt="Logo" class="h-12 max-w-full mr-2">
            </a>

            <!-- Hamburger Button (mobile only) -->
            <button id="menu-toggle" class="md:hidden text-3xl text-gray-700 focus:outline-none">
                ☰
            </button>

            <!-- Menu -->
            <nav id="menu"
                class="hidden fixed inset-0 bg-white z-40 flex-col items-center justify-center space-y-8 text-lg md:static md:flex md:flex-row md:space-y-0 md:space-x-8 md:bg-transparent md:shadow-none font-medium">

                <!-- Tombol Close (mobile only) -->
                <button id="menu-close" class="absolute top-6 right-6 text-3xl text-gray-700 md:hidden">✕</button>

                <!-- Navigation Links -->
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Home</a>
                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">About</a>
                <a href="{{ route('contact') }}"
                    class="{{ request()->routeIs('contact') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Contact</a>
                <a href="{{ route('pricelist') }}"
                    class="{{ request()->routeIs('pricelist') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Pricelist</a>

                {{-- Booking Link - publik, tanpa login --}}
                <a href="{{ route('booking') }}"
                    class="{{ request()->routeIs('booking') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Booking</a>

                {{-- AUTH LINKS --}}
                @guest('customer')
                <a href="{{ route('customer.login') }}"
                    class="flex items-center space-x-2 text-gray-700 hover:text-black transition md:ml-6">
                    <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon" class="h-5 w-auto">
                    <span class="font-medium">Log In</span>
                </a>
                @endguest

                @auth('customer')
                <div class="relative group md:ml-6">
                    <!-- Tombol utama (ikon + dropdown arrow) -->
                    <button
                        class="flex items-center space-x-2 text-gray-700 hover:text-black transition focus:outline-none">
                        <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon" class="h-6 w-auto">
                        <span
                            class="hidden md:inline font-medium">{{ Auth::guard('customer')->user()->fullname ?? 'Account' }}</span>
                        <svg class="w-4 h-4 mt-0.5 text-gray-600 group-hover:text-black transition" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 shadow-lg rounded-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">

                        <a href="{{ route('customer.profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>

                        <a href="{{ route('customer.bookings') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Bookings</a>

                        <div class="border-t my-1"></div>

                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
                @endauth

            </nav>
        </div>
    </header>

    <!-- MAIN -->
    <main class="min-h-[70vh] pt-24">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-gray-100 bg-white">
        <div class="container mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600">
                © 2025 by <span class="font-semibold">anxietive</span>
            </p>

            <div class="flex items-center space-x-1">
                <img src="{{ asset('images/logo/instagram_logo.png') }}" alt="Instagram Logo" class="w-5 h-5" />
                <a href="https://www.instagram.com/anxietive/" target="_blank" class="text-sm text-gray-600">
                    Follow us on Instagram
                </a>
            </div>
        </div>
    </footer>

    {{-- MOBILE MENU SCRIPT --}}
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menuClose = document.getElementById('menu-close');
        const menu = document.getElementById('menu');

        menuToggle.addEventListener('click', () => {
            menu.classList.remove('hidden');
        });

        menuClose.addEventListener('click', () => {
            menu.classList.add('hidden');
        });

    </script>

    @stack('scripts')

</body>

</html>
