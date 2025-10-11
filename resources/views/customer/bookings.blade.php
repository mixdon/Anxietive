@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 md:px-12 lg:px-20">
    <div class="container mx-auto flex flex-col md:flex-row gap-8 md:gap-10 items-start">

        {{-- Sidebar --}}
        <div
            class="w-full md:w-1/4 bg-white rounded-2xl shadow-lg p-6 sm:p-8 flex flex-col justify-between self-start">
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
                        class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        Profile
                    </a>
                    <a href="{{ route('customer.bookings') }}"
                        class="block px-4 py-2 rounded-lg bg-teal-50 text-teal-700 font-medium">
                        My Bookings
                    </a>
                </nav>
            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('customer.logout') }}" class="mt-8">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 text-white font-semibold py-2 rounded-xl hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>

        {{-- Main Content --}}
        <div class="w-full md:w-3/4 bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 flex flex-col">

            {{-- Header --}}
            <div class="border-b pb-4 sm:pb-5 mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Bookings</h1>
                <p class="text-gray-600 text-xs sm:text-sm mt-1">View, track, or manage your bookings here.</p>
            </div>

            {{-- Alert Sukses --}}
            @if (session('success'))
            <div class="mb-6 p-3 sm:p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif

            {{-- Tabs --}}
            <div class="flex border-b mb-6 text-sm sm:text-base">
                <button id="tab-upcoming"
                    class="tab-btn px-3 sm:px-4 py-2 text-teal-600 border-b-2 border-teal-600 font-medium">
                    Upcoming
                </button>
                <button id="tab-past" class="tab-btn px-3 sm:px-4 py-2 text-gray-600 hover:text-gray-900">
                    Past
                </button>
            </div>

            {{-- Upcoming (Pending) --}}
            <div id="upcoming-list" class="flex flex-col gap-3 sm:gap-4 flex-grow">
                @php
                $upcoming = $bookings->where('status', 'pending')->sortByDesc('created_at');
                @endphp

                @forelse ($upcoming as $booking)
                <div
                    class="border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center hover:shadow-md transition bg-white">
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                            {{ $booking->package->judul_package ?? '-' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }} at {{ $booking->time }}
                        </p>
                        <p class="text-xs sm:text-sm text-gray-500 capitalize mt-1">
                            Status:
                            <span class="font-medium text-yellow-600">{{ ucfirst($booking->status) }}</span>
                        </p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 sm:py-12 text-gray-500">
                    <p>No upcoming (pending) bookings found.</p>
                </div>
                @endforelse
            </div>

            {{-- Past (Completed, Cancelled, Refund) --}}
            <div id="past-list" class="hidden flex flex-col gap-3 sm:gap-4 flex-grow">
                @php
                $past = $bookings->whereIn('status', ['completed', 'cancelled', 'refund'])->sortByDesc('created_at');
                @endphp

                @forelse ($past as $booking)
                <div
                    class="border border-gray-200 rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center hover:shadow-md transition bg-white">
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                            {{ $booking->package->judul_package ?? '-' }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }} at {{ $booking->time }}
                        </p>
                        <p class="text-xs sm:text-sm text-gray-500 capitalize mt-1">
                            Status:
                            @if ($booking->status === 'completed')
                            <span class="font-medium text-green-600">{{ ucfirst($booking->status) }}</span>
                            @elseif ($booking->status === 'cancelled')
                            <span class="font-medium text-red-600">{{ ucfirst($booking->status) }}</span>
                            @else
                            <span class="font-medium text-blue-600">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 sm:py-12 text-gray-500">
                    <p>No past bookings found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Tabs Script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const upcomingBtn = document.getElementById('tab-upcoming');
        const pastBtn = document.getElementById('tab-past');
        const upcomingList = document.getElementById('upcoming-list');
        const pastList = document.getElementById('past-list');

        upcomingBtn.addEventListener('click', () => {
            upcomingList.classList.remove('hidden');
            pastList.classList.add('hidden');
            upcomingBtn.classList.add('text-teal-600', 'border-b-2', 'border-teal-600', 'font-medium');
            pastBtn.classList.remove('text-teal-600', 'border-b-2', 'border-teal-600', 'font-medium');
            pastBtn.classList.add('text-gray-600');
        });

        pastBtn.addEventListener('click', () => {
            pastList.classList.remove('hidden');
            upcomingList.classList.add('hidden');
            pastBtn.classList.add('text-teal-600', 'border-b-2', 'border-teal-600', 'font-medium');
            upcomingBtn.classList.remove('text-teal-600', 'border-b-2', 'border-teal-600', 'font-medium');
            upcomingBtn.classList.add('text-gray-600');
        });
    });
</script>
@endsection