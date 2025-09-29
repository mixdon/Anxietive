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

    {{-- allow views to push styles (Swiper CSS, custom CSS etc) --}}
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

                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Home</a>
                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">About</a>
                <a href="{{ route('contact') }}"
                    class="{{ request()->routeIs('contact') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Contact</a>
                <a href="{{ route('pricelist') }}"
                    class="{{ request()->routeIs('pricelist') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Pricelist</a>
                <a href="{{ route('booking') }}"
                    class="{{ request()->routeIs('booking') ? 'text-black font-medium' : 'text-gray-700 hover:text-black' }}">Booking</a>
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
            <!-- Kiri -->
            <p class="text-sm text-gray-600">
                © 2025 by
                <span class="font-semibold">anxietive</span>
            </p>

            <!-- Kanan -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo/instagram_logo.png') }}" alt="Instagram Logo" class="w-5 h-5" />
                <a href="https://www.instagram.com/anxietive/" target="_blank" class="text-sm text-gray-600">
                    Follow us on Instagram
                </a>
            </div>
        </div>
    </footer>

    <!-- LIGHTBOX MARKUP (initially hidden) -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-white transition-opacity">
        <button id="lb-close" class="absolute top-6 right-6 text-black text-3xl p-2" aria-label="Close">✕</button>
        <button id="lb-prev" class="absolute left-6 text-black text-3xl p-2" aria-label="Previous">‹</button>
        <div class="max-w-[90%] max-h-[80vh] overflow-hidden">
            <img id="lb-image" src="" alt="" class="block max-w-full max-h-[80vh] object-contain" />
        </div>
        <button id="lb-next" class="absolute right-6 text-black text-3xl p-2" aria-label="Next">›</button>
    </div>

    <!-- --- Place for page-specific scripts --- -->
    @stack('scripts')

    <!-- Script: navbar + lightbox behaviour -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Navbar toggle
            const menuToggle = document.getElementById('menu-toggle');
            const menu = document.getElementById('menu');
            const menuClose = document.getElementById('menu-close');

            if (menuToggle) {
                menuToggle.addEventListener('click', () => {
                    menu.classList.remove('hidden');
                    menu.classList.add('flex');
                });
            }

            if (menuClose) {
                menuClose.addEventListener('click', () => {
                    menu.classList.remove('flex');
                    menu.classList.add('hidden');
                });
            }

            // Lightbox
            (function () {
                const lightbox = document.getElementById('lightbox');
                const lbImage = document.getElementById('lb-image');
                const lbClose = document.getElementById('lb-close');
                const lbPrev = document.getElementById('lb-prev');
                const lbNext = document.getElementById('lb-next');

                function getGalleryImages() {
                    return Array.from(document.querySelectorAll('.gallery-item img'))
                        .map(img => img.dataset.full || img.src);
                }

                let images = getGalleryImages();
                let current = 0;

                function open(index) {
                    images = getGalleryImages();
                    current = index;
                    lbImage.src = images[current];
                    lightbox.classList.remove('hidden');
                    lightbox.classList.add('flex', 'opacity-100');
                }

                function close() {
                    lightbox.classList.remove('opacity-100', 'flex');
                    lightbox.classList.add('hidden');
                    lbImage.src = '';
                }

                document.addEventListener('click', function (e) {
                    const galleryImg = e.target.closest('.gallery-item img');
                    if (galleryImg) {
                        e.preventDefault();
                        const imgs = Array.from(document.querySelectorAll('.gallery-item img'));
                        const idx = imgs.indexOf(galleryImg);
                        if (idx !== -1) open(idx);
                        return;
                    }
                });

                lbClose.addEventListener('click', close);
                lbPrev.addEventListener('click', () => {
                    images = getGalleryImages();
                    current = (current - 1 + images.length) % images.length;
                    lbImage.src = images[current];
                });
                lbNext.addEventListener('click', () => {
                    images = getGalleryImages();
                    current = (current + 1) % images.length;
                    lbImage.src = images[current];
                });

                document.addEventListener('keydown', function (e) {
                    if (!lightbox.classList.contains('flex')) return;
                    if (e.key === 'Escape') close();
                    if (e.key === 'ArrowLeft') lbPrev.click();
                    if (e.key === 'ArrowRight') lbNext.click();
                });

                lightbox.addEventListener('click', function (e) {
                    if (e.target === lightbox) close();
                });
            })();
        });
    </script>
</body>
</html>