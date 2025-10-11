<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen overflow-x-hidden">

<!-- SIDEBAR -->
<aside id="sidebar"
       class="fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out
              -translate-x-full md:translate-x-0 z-50 flex flex-col justify-between shadow-lg md:shadow-none">

    <div class="flex flex-col h-full justify-between">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo/icon_user.png') }}" alt="Logo" class="h-8">
                <span class="font-semibold text-lg text-gray-800">AdminHub</span>
            </div>

            <!-- Close (Mobile Only) -->
            <button id="menuClose" class="text-gray-600 text-xl md:hidden" aria-label="Close sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="px-4 py-6 flex-1 overflow-y-auto">
            <ul class="space-y-1">
                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition min-w-0
                       {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}"
                       aria-current="{{ request()->routeIs('admin.dashboard') ? 'page' : '' }}">
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-md shrink-0
                                   {{ request()->routeIs('admin.dashboard') ? 'bg-purple-200 text-purple-700' : 'text-gray-400' }}">
                            <i class="fa-solid fa-gauge fa-fw text-lg" aria-hidden="true"></i>
                        </span>
                        <span class="truncate">Dashboard</span>
                    </a>
                </li>

                {{-- Data Office --}}
                <li>
                    <a href="{{ route('admin.data-office.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition min-w-0
                       {{ request()->routeIs('admin.data-office.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}"
                       aria-current="{{ request()->routeIs('admin.data-office.*') ? 'page' : '' }}">
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-md shrink-0
                                   {{ request()->routeIs('admin.data-office.*') ? 'bg-purple-200 text-purple-700' : 'text-gray-400' }}">
                            <i class="fa-solid fa-building fa-fw text-lg" aria-hidden="true"></i>
                        </span>
                        <span class="truncate">Data Office</span>
                    </a>
                </li>

                {{-- Data Package --}}
                <li>
                    <a href="{{ route('admin.data-package') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition min-w-0
                       {{ request()->routeIs('admin.data-package*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}"
                       aria-current="{{ request()->routeIs('admin.data-package*') ? 'page' : '' }}">
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-md shrink-0
                                   {{ request()->routeIs('admin.data-package*') ? 'bg-purple-200 text-purple-700' : 'text-gray-400' }}">
                            <i class="fa-solid fa-box fa-fw text-lg" aria-hidden="true"></i>
                        </span>
                        <span class="truncate">Data Package</span>
                    </a>
                </li>

                {{-- Data Booking --}}
                <li>
                    <a href="{{ route('admin.bookings.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition min-w-0
                       {{ request()->routeIs('admin.bookings.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}"
                       aria-current="{{ request()->routeIs('admin.bookings.*') ? 'page' : '' }}">
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-md shrink-0
                                   {{ request()->routeIs('admin.bookings.*') ? 'bg-purple-200 text-purple-700' : 'text-gray-400' }}">
                            <i class="fa-solid fa-calendar-check fa-fw text-lg" aria-hidden="true"></i>
                        </span>
                        <span class="truncate">Data Booking</span>
                    </a>
                </li>

                {{-- Data Admin --}}
                <li>
                    <a href="{{ route('admin.data-admin') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition min-w-0
                       {{ request()->routeIs('admin.data-admin*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}"
                       aria-current="{{ request()->routeIs('admin.data-admin*') ? 'page' : '' }}">
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-md shrink-0
                                   {{ request()->routeIs('admin.data-admin*') ? 'bg-purple-200 text-purple-700' : 'text-gray-400' }}">
                            <i class="fa-solid fa-user-shield fa-fw text-lg" aria-hidden="true"></i>
                        </span>
                        <span class="truncate">Data Admin</span>
                    </a>
                </li>

                {{-- Data Customer --}}
                <li>
                    <a href="{{ route('admin.data-customer') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition min-w-0
                       {{ request()->routeIs('admin.data-customer*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}"
                       aria-current="{{ request()->routeIs('admin.data-customer*') ? 'page' : '' }}">
                        <span
                            class="w-8 h-8 flex items-center justify-center rounded-md shrink-0
                                   {{ request()->routeIs('admin.data-customer*') ? 'bg-purple-200 text-purple-700' : 'text-gray-400' }}">
                            <i class="fa-solid fa-user fa-fw text-lg" aria-hidden="true"></i>
                        </span>
                        <span class="truncate">Data Customer</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- User Info -->
        <div class="border-t border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon"
                     class="h-9 w-9 rounded-full border border-gray-200 object-cover">
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate">
                        {{ Auth::guard('customer')->check()
                            ? Auth::guard('customer')->user()->fullname
                            : (session('admin_user')->fullname ?? 'Admin') }}
                    </p>
                    <form action="{{ route('logout') }}" method="POST" class="mt-1">
                        @csrf
                        <button type="submit"
                                class="text-xs text-gray-500 hover:text-red-600 transition inline-flex items-center gap-1">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- OVERLAY (Mobile) -->
<div id="overlay" class="fixed inset-0 bg-black/40 hidden z-40 md:hidden"></div>

<!-- MAIN CONTENT -->
<div id="mainContent" class="flex-1 flex flex-col md:ml-64 min-h-screen transition-all duration-300">

    <!-- SIMPLE MOBILE NAVBAR -->
    <header
        class="md:hidden fixed top-0 left-0 w-full bg-white border-b border-gray-200 shadow-sm flex items-center justify-between px-5 py-3 z-40">
        <span class="text-lg font-semibold text-gray-800">AdminHub</span>
        <button id="menuToggle" class="text-gray-700 text-2xl" aria-label="Open sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>
    </header>

    <!-- PAGE CONTENT -->
    <main class="flex-1 p-6 md:p-8 overflow-x-hidden mt-14 md:mt-0">
        @yield('content')
    </main>
</div>

<!-- Sidebar Script -->
<script>
    const htmlEl = document.documentElement;
    const body = document.body;
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('menuToggle');
    const closeBtn = document.getElementById('menuClose');

    const preventTouch = (e) => e.preventDefault();

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        overlay.classList.add('block');
        htmlEl.style.overflow = 'hidden';
        body.style.overflow = 'hidden';
        document.addEventListener('touchmove', preventTouch, { passive: false });
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        htmlEl.style.overflow = '';
        body.style.overflow = '';
        document.removeEventListener('touchmove', preventTouch);
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            htmlEl.style.overflow = '';
            body.style.overflow = '';
            overlay.classList.add('hidden');
            sidebar.classList.remove('-translate-x-full');
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });
</script>

@stack('scripts')

</body>
</html>