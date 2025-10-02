@extends('layouts.app')

@section('title', 'Booking | anxietive')

@section('content')
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 md:px-12">
        <!-- Tambah padding kiri kanan -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 text-center">Capture Your Best Moments ✨</h1>
        <p class="mt-4 text-lg text-gray-600 text-center max-w-2xl mx-auto">
            Come visit <span class="font-semibold text-gray-900">Anxietive</span> in your city,
            pick your favorite studio type, and let’s create memories that last forever. 📸
        </p>

        <!-- Card grid -->
        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($studios as $studio)
            <div class="border rounded-2xl shadow hover:shadow-lg flex flex-col bg-white relative overflow-hidden">
                <!-- Image -->
                <div class="relative w-full h-64">
                    <!-- Kurangi tinggi gambar biar card lebih panjang -->
                    <img src="{{ asset($studio['image']) }}" alt="{{ $studio['title'] }}"
                        class="w-full h-full object-cover rounded-t-2xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-xl md:text-2xl text-center px-2 tracking-wide">
                            {{ $studio['title'] }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <!-- Lokasi -->
                    <h1 class="text-lg md:text-xl font-bold text-gray-800 leading-snug">
                        {{ $studio['location'] }}
                    </h1>
                    <!-- Alamat -->
                    <h3 class="text-sm md:text-base text-gray-600 mt-1">
                        {{ $studio['address'] }}
                    </h3>

                    <!-- Durasi & Harga -->
                    <div class="mt-6 space-y-2 mb-20">
                        <span class="block text-lg md:text-xl text-gray-700">
                            {{ $studio['duration'] }}
                        </span>
                        <span class="block text-lg md:text-xl font-extrabold text-gray-900">
                            Rp {{ number_format($studio['price'],0,',','.') }}
                        </span>
                    </div>

                    <!-- Button pojok kiri bawah -->
                    <a href="{{ route('booking.schedule', ['studio' => $studio['id']]) }}"
                        class="absolute bottom-5 left-5 inline-block px-8 py-3 bg-blue-600 text-white rounded-md text-base font-semibold hover:bg-blue-500 transition shadow">
                        Book Now
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
