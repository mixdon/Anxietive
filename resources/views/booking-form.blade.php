@extends('layouts.app')

@section('title', 'Booking Form | anxietive')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6">
    <a href="{{ route('booking.schedule', request()->query('studio') ?? 'basic-pekanbaru') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back</a>

    <h1 class="text-3xl md:text-4xl font-bold text-center mt-6">Booking Form</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-10">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="bg-gray-50 border p-4 rounded mb-6">
                <h3 class="font-semibold text-gray-800">Please Read Carefully!</h3>
                <ol class="text-sm text-gray-600 list-decimal list-inside mt-2 space-y-1">
                    <li>Each session is for 2 people ONLY. Additional person will be charged IDR 25.000 each.</li>
                    <li>It's non cancellable booking & non refundable.</li>
                    <li>If you want to book 2 sessions or more, you need to book one by one.</li>
                </ol>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 p-3 rounded mb-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
                @csrf
                <input type="hidden" name="studio" value="{{ request()->query('studio') }}">
                <input type="hidden" name="date" value="{{ request()->query('date') }}">
                <input type="hidden" name="time" value="{{ request()->query('time') }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700">Name *</label>
                    <input name="name" value="{{ old('name', optional($user)->name) }}" required
                           class="mt-1 block w-full border-gray-200 rounded-md p-3 focus:ring focus:ring-indigo-200" placeholder="Your name">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email *</label>
                    <input name="email" value="{{ old('email', optional($user)->email) }}" required
                           class="mt-1 block w-full border-gray-200 rounded-md p-3 focus:ring focus:ring-indigo-200" placeholder="you@example.com">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number *</label>
                    <input name="phone" value="{{ old('phone') }}" required
                           class="mt-1 block w-full border-gray-200 rounded-md p-3 focus:ring focus:ring-indigo-200" placeholder="+62...">
                    @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Add Your Message</label>
                    <textarea name="message" rows="4" class="mt-1 block w-full border-gray-200 rounded-md p-3 focus:ring focus:ring-indigo-200" placeholder="Anything we should know?">{{ old('message') }}</textarea>
                </div>

                <div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-md transition">Book Now</button>
                </div>
            </form>
        </div>

        <!-- Summary -->
        <div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-800 mb-3">Booking Details</h3>
                <p class="text-gray-800 font-medium">{{ $selected['location'] ?? 'Studio' }}</p>
                <p class="text-sm text-gray-500 mt-2">
                    @if(request()->query('date'))
                        {{ \Carbon\Carbon::parse(request()->query('date'))->format('j F Y') }} at {{ request()->query('time') }}
                    @else
                        -
                    @endif
                </p>
                <p class="text-sm text-gray-500 mt-2">More details...</p>

                <div class="mt-4">
                    <h4 class="text-sm text-gray-700">Payment Details</h4>
                    <p class="text-lg font-semibold mt-2">Rp {{ number_format($selected['price'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <p class="text-xs text-gray-500 mt-4">
                    By completing your booking, you agree to receive related SMS notifications.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection