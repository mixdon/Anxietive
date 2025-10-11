@extends('layouts.user')

@section('title', 'My Profile | anxietive')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 md:px-12 lg:px-20">
    <div class="container mx-auto flex flex-col md:flex-row gap-8 md:gap-10 items-stretch">

        {{-- Sidebar --}}
        <div class="w-full md:w-1/4 bg-white rounded-2xl shadow-lg p-6 sm:p-8 flex flex-col justify-between h-fit md:h-full">
            @php
                $customer = Auth::guard('customer')->user();
            @endphp

            {{-- User Info --}}
            <div>
                <div class="flex flex-col items-center text-center mb-8">
                    <div
                        class="w-20 h-20 sm:w-24 sm:h-24 bg-teal-600 rounded-full flex items-center justify-center text-white text-3xl sm:text-4xl font-semibold mb-3 shadow-inner">
                        {{ strtoupper(substr($customer->fullname ?? 'U', 0, 1)) }}
                    </div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-1">
                        {{ $customer->fullname ?? 'Unknown User' }}
                    </h2>
                    <p class="text-gray-500 text-xs sm:text-sm">{{ $customer->email ?? '-' }}</p>
                </div>

                {{-- Sidebar Menu --}}
                <nav class="mt-4 sm:mt-6 space-y-1 sm:space-y-2 text-sm border-t pt-4">
                    <a href="{{ route('customer.profile') }}"
                       class="block px-4 py-2 rounded-lg bg-teal-50 text-teal-700 font-medium">
                        Profile
                    </a>
                    <a href="{{ route('customer.bookings') }}"
                       class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        My Bookings
                    </a>
                </nav>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('customer.logout') }}" class="mt-6 sm:mt-8">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 text-white font-semibold py-2 rounded-xl hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>

        {{-- Main Content --}}
        <div class="w-full md:w-3/4 bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 flex flex-col justify-between">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8">My Profile</h2>

            <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Baris 1: Nama & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm sm:text-base">Full Name</label>
                        <input type="text" name="fullname" value="{{ old('fullname', $customer->fullname) }}"
                               class="w-full border border-gray-300 rounded-lg p-2.5 sm:p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm sm:text-base">Email</label>
                        <input type="email" value="{{ $customer->email }}" readonly
                               class="w-full bg-gray-100 border border-gray-200 rounded-lg p-2.5 sm:p-3 text-gray-500 cursor-not-allowed">
                    </div>
                </div>

                {{-- Baris 2: No HP & Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm sm:text-base">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                               class="w-full border border-gray-300 rounded-lg p-2.5 sm:p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2 text-sm sm:text-base">Status Account</label>
                        @php
                            $statusColors = [
                                'pending' => 'text-yellow-800 bg-yellow-100',
                                'verified' => 'text-green-800 bg-green-100',
                                'inactive' => 'text-gray-600 bg-gray-100',
                                'banned' => 'text-red-800 bg-red-100'
                            ];
                            $statusClass = $statusColors[$customer->status_aktif] ?? 'text-gray-500 bg-gray-100';
                        @endphp
                        <span class="inline-block px-3 py-1.5 rounded-lg font-semibold text-sm sm:text-base {{ $statusClass }}">
                            {{ ucfirst($customer->status_aktif) }}
                        </span>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-6 border-t">
                    <button type="reset"
                        class="bg-gray-200 text-gray-700 font-semibold py-2 px-5 sm:px-6 rounded-xl hover:bg-gray-300 transition w-full sm:w-auto">
                        Discard
                    </button>
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold py-2 px-5 sm:px-6 rounded-xl hover:bg-blue-700 transition w-full sm:w-auto">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection