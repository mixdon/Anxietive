@extends('layouts.app')

@section('title', 'Booking | anxietive')

@section('content')
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 text-center">Capture Your Best Moments ✨</h1>
        <p class="mt-4 text-lg text-gray-600 text-center">
            Come visit <span class="font-semibold text-gray-900">Anxietive</span> in your city,
            pick your favorite studio type, and let’s create memories that last forever. 📸
        </p>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($studios as $studio)
            <div class="border rounded-xl shadow hover:shadow-lg flex flex-col bg-white relative">
                <div class="relative w-full h-80">
                    <img src="{{ asset($studio['image']) }}" alt="{{ $studio['title'] }}"
                         class="w-full h-full object-cover rounded-t-xl">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="text-white font-bold text-lg text-center px-2">{{ $studio['title'] }}</span>
                    </div>
                </div>

                <div class="p-4 flex flex-col flex-grow">
                    <h1 class="text-base font-semibold text-gray-700">{{ $studio['location'] }}</h1>
                    <h3 class="text-sm text-gray-500">{{ $studio['address'] }}</h3>

                    <div class="mt-4 space-y-1 mb-10">
                        <span class="block text-sm text-gray-700">{{ $studio['duration'] }}</span>
                        <span class="block text-sm font-bold text-gray-800">Rp {{ number_format($studio['price'],0,',','.') }}</span>
                    </div>

                    <a href="{{ route('booking.schedule', ['studio' => $studio['id']]) }}"
                       class="absolute bottom-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-700 transition">
                       Book Now
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection