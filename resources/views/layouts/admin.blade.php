<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 text-gray-800 flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-200 transform transition-transform duration-300 ease-in-out
               -translate-x-full md:translate-x-0 z-50 overflow-hidden flex flex-col justify-between">

        <div class="flex flex-col h-full justify-between">

            <!-- Logo -->
            <div class="flex justify-center items-center px-6 py-4 border-b border-gray-100">
                <img src="{{ asset('images/logo/anxietive_logo.PNG') }}" alt="Logo" class="h-10">
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 flex-1 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition 
                    {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-gauge text-lg"></i> Dashboard
                </a>

                <a href="{{ route('admin.data-office.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition 
                    {{ request()->routeIs('admin.data-office.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-building text-lg"></i> Data Office
                </a>

                <a href="{{ route('admin.data-package') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition 
                    {{ request()->routeIs('admin.data-package') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-box text-lg"></i> Data Package
                </a>

                <a href="{{ route('admin.data-user') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition 
                    {{ request()->routeIs('admin.data-user') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-users text-lg"></i> Data User
                </a>

                <a href="{{ route('admin.data-customer') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition 
                    {{ request()->routeIs('admin.data-customer') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-user text-lg"></i> Data Customer
                </a>

                <a href="{{ route('admin.bookings.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition 
                    {{ request()->routeIs('admin.bookings.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-calendar-check text-lg"></i> Data Booking
                </a>
            </nav>

            <!-- Footer (bisa diisi info tambahan) -->
            <div class="border-t border-gray-100 py-4"></div>
        </div>
    </aside>

    <!-- OVERLAY (Mobile) -->
    <div id="overlay" class="fixed inset-0 bg-black/40 hidden z-40 md:hidden"></div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col md:ml-64 min-h-screen">

        <!-- NAVBAR -->
        <header class="flex justify-between items-center bg-white border-b border-gray-200 px-6 py-3 sticky top-0 z-40">
            <!-- Hamburger Button -->
            <button id="menuToggle" class="text-gray-600 text-2xl md:hidden focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- User Dropdown -->
            <div class="relative group md:ml-auto">
                <button class="flex items-center space-x-2 text-gray-700 hover:text-black transition focus:outline-none">
                    <img src="{{ asset('images/logo/icon_user.png') }}" alt="User Icon"
                        class="h-8 w-8 rounded-full border border-gray-200 object-cover">
                    <span class="hidden md:inline font-medium">
                        {{ Auth::guard('customer')->check() 
                            ? Auth::guard('customer')->user()->fullname 
                            : (session('admin_user')->fullname ?? 'Admin') }}
                    </span>
                    <svg class="w-4 h-4 mt-0.5 text-gray-600 group-hover:text-black transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 shadow-lg rounded-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 p-6 md:p-8 overflow-x-hidden">
            @yield('content')
        </main>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('menuToggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>

</body>
</html>