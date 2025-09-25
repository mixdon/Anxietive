@extends('layouts.app')

@section('title', 'Booking | anxietive')

@section('content')

<!-- HERO -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto text-center px-6">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900">
            Capture Your Best Moments ✨
        </h1>
        <p class="mt-4 text-lg text-gray-600">
            Come visit <span class="font-semibold text-gray-900">Anxietive</span> in your city,
            pick your favorite studio type, and let’s create memories that last forever. 📸
        </p>
    </div>
</section>

<!-- CARD LIST -->
<section class="py-12">
    <div class="container mx-auto px-12">

        <!-- Row 1: Card 1–3 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

            <!-- Card 1 -->
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/BasicStudio001.jpeg') }}" alt="Basic Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Basic Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Pekanbaru | Cempedak I</h1>
                    <h3 class="text-sm text-gray-500">Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 30 minutes</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/LargeStudio001.PNG') }}" alt="Large Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Large Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Pekanbaru | Cempedak I</h1>
                    <h3 class="text-sm text-gray-500">Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 1 hour</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/RedStudio001.JPEG') }}" alt="Red Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Red Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Pekanbaru | Cempedak I</h1>
                    <h3 class="text-sm text-gray-500">Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 15 minutes</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Row 2: Card 4 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/BasicStudio002.jpeg') }}" alt="Basic Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Basic Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Pekanbaru | Delima</h1>
                    <h3 class="text-sm text-gray-500">Jl. Delima, Kec. Tampan, Kota Pekanbaru</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 30 minutes</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Row 3: Card 5–7 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card 5 -->
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/BasicStudio003.jpeg') }}" alt="Basic Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Basic Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Lampung | KS Tubun</h1>
                    <h3 class="text-sm text-gray-500">Jl. KS. Tubun No.10, Tanjungkarang Timur</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 30 minutes</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/LargeStudio002.PNG') }}" alt="Large Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Large Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Lampung | KS Tubun</h1>
                    <h3 class="text-sm text-gray-500">Jl. KS. Tubun No.10, Tanjungkarang Timur</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 1 hour</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset('images/booking/RedStudio002.JPEG') }}" alt="Red Studio"
                        class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">Red Studio</span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">Lampung | KS Tubun</h1>
                    <h3 class="text-sm text-gray-500">Jl. KS. Tubun No.10, Tanjungkarang Timur</h3>
                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">⏱ 15 minutes</span>
                        <span class="block text-sm font-bold text-gray-800">💰 —</span>
                    </div>
                    <a href="#"
                        class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                        Book Now
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection