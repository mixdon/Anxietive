@extends('layouts.user')

@section('title', __('messages.booking_form_title') . ' | anxietive')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6">

    <!-- Tombol Kembali -->
    <a href="{{ route('booking.schedule', $selected->id) }}" class="text-sm text-gray-500 hover:text-gray-700">&larr;
        {{ __('messages.booking_back') }}</a>

    <h1 class="text-3xl md:text-4xl font-bold text-center mt-6">{{ __('messages.booking_form_title') }}</h1>

    {{-- POPUP LOGIN --}}
    @guest('customer')
    <div id="loginModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm z-50">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 text-center relative">
            <button id="closeModal"
                class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>

            <div
                class="flex items-center justify-center w-12 h-12 mx-auto mb-4 rounded-full bg-blue-50 border border-blue-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405M15 17l-1.405-1.405M15 17v-6a2 2 0 10-4 0v6M6 9v2m0 4v6m6-6h.01" />
                </svg>
            </div>

            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ __('messages.booking_login_required') }}</h2>
            <p class="text-sm text-gray-600 mb-6">{{ __('messages.booking_login_message') }}</p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('customer.login', ['redirect' => request()->fullUrl()]) }}"
                    class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    {{ __('messages.booking_login_now') }}
                </a>
                <a href="{{ route('customer.register', ['redirect' => request()->fullUrl()]) }}"
                    class="px-5 py-2.5 bg-gray-100 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                    {{ __('messages.booking_register') }}
                </a>
            </div>
        </div>
    </div>
    @endguest

    {{-- ALERT --}}
    @if(session('success'))
    <div class="mt-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm shadow-sm">
        <ul class="list-disc pl-4 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- FORM -->
    <form id="bookingForm" action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-10">
        @csrf
        <input type="hidden" name="studio" value="{{ $selected->id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="time" value="{{ $time }}">

        <!-- INPUT FORM -->
        <div class="lg:col-span-2 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.booking_fullname') }}</label>
                <input type="text" name="fullname" value="{{ old('fullname', $customer->fullname ?? '') }}"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.booking_email') }}</label>
                <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.booking_phone') }}</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500"
                    required>
            </div>

            <div>
                <label for="img_bukti_trf" class="block text-sm font-medium text-gray-700">
                    {{ __('messages.booking_proof') }} <span class="text-red-500">*</span>
                </label>
                <input type="file" id="img_bukti_trf" name="img_bukti_trf" required accept="image/*"
                    class="mt-2 block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.booking_proof_hint') }}</p>
                <img id="previewBukti" src="#" class="mt-2 hidden w-32 h-32 object-cover rounded-md border" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('messages.booking_message') }}</label>
                <textarea name="message" rows="4"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500">{{ old('message') }}</textarea>
            </div>
        </div>

        <!-- SUMMARY -->
        <div>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="font-semibold text-gray-800 mb-3">{{ __('messages.booking_details') }}</h3>

                @if($selected)
                <p class="text-lg font-medium text-gray-800">{{ $selected->judul_package }}</p>
                <p class="text-sm text-gray-500">{{ $selected->office->office_name }}</p>
                <p class="text-sm text-gray-500">{{ $selected->office->address }}</p>

                @if(!empty($selected->times))
                <p class="text-sm text-gray-600 mt-2">
                    {{ __('messages.booking_duration') }}: {{ $selected->times }} {{ __('messages.booking_minutes') }}
                </p>
                @endif

                <p class="text-sm text-gray-500 mt-3">
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('j F Y') }} {{ __('messages.at') }} {{ $time }}
                </p>

                <div class="mt-4">
                    <h4 class="text-sm text-gray-700">{{ __('messages.booking_payment_details') }}</h4>
                    <p class="text-lg font-semibold mt-2">
                        Rp {{ number_format($selected->amount, 0, ',', '.') }}
                    </p>
                </div>

                <!-- PAYMENT TABS -->
                <div class="mt-6">
                    <div class="flex border-b border-gray-200">
                        <button type="button" id="tabTransfer"
                            class="payment-tab active-tab px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                            {{ __('messages.booking_tab_transfer') }}
                        </button>

                        <button type="button" id="tabQR"
                            class="payment-tab px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                            {{ __('messages.booking_tab_qr') }}
                        </button>
                    </div>

                    <!-- TRANSFER CONTENT -->
                    <div id="contentTransfer" class="py-4">
                        <p class="text-sm text-gray-800 font-semibold">{{ __('messages.booking_rekening_title') }}</p>
                        <div class="mt-3 p-3 bg-gray-50 border rounded-lg text-sm">

                            <p><span class="font-medium">{{ __('messages.booking_rekening_bank') }}</span></p>

                            <p class="mt-1">
                                {{ __('messages.booking_rekening_number_label') }}:
                                <button type="button" id="copyRek"
                                    class="font-semibold text-gray-800 hover:underline">
                                    {{ __('messages.booking_rekening_number') }}
                                </button>
                            </p>

                            <p>{{ __('messages.booking_rekening_name') }}</p>

                            <!-- Notif copied -->
                            <p id="copyNotif" class="text-green-600 text-xs mt-2 hidden">
                                {{ __('messages.booking_copied') }}
                            </p>
                        </div>
                    </div>

                    <!-- QR CONTENT -->
                    <div id="contentQR" class="py-4 hidden">
                        <p class="text-sm text-gray-800 font-semibold">{{ __('messages.booking_qris_title') }}</p>
                        <p class="text-sm text-gray-600 mt-2">{{ __('messages.booking_qris_scan') }}</p>

                        <img src="{{ asset(__('messages.booking_qris_image')) }}"
                            class="w-40 mt-3 rounded-lg shadow border" alt="QRIS">
                    </div>
                </div>

                @else
                <p class="text-sm text-gray-500">{{ __('messages.booking_no_studio') }}</p>
                @endif

                <p class="text-xs text-gray-500 mt-4">{{ __('messages.booking_sms_notice') }}</p>

                @auth('customer')
                <button type="submit"
                    class="w-full mt-6 px-8 py-3 bg-blue-600 text-white rounded-md text-base font-medium hover:bg-blue-700">
                    {{ __('messages.booking_book_now') }}
                </button>
                @else
                <button type="button" id="showLoginModalBtn"
                    class="w-full mt-6 px-8 py-3 bg-gray-300 text-gray-600 rounded-md text-base font-medium">
                    {{ __('messages.booking_login_to_book') }}
                </button>
                @endauth
            </div>
        </div>
    </form>
</div>

{{-- SCRIPT PREVIEW --}}
<script>
    const buktiInput = document.getElementById('img_bukti_trf');
    const preview = document.getElementById('previewBukti');

    buktiInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    });

</script>

{{-- SCRIPT TAB PEMBAYARAN --}}
<script>
    const tabTransfer = document.getElementById('tabTransfer');
    const tabQR = document.getElementById('tabQR');
    const contentTransfer = document.getElementById('contentTransfer');
    const contentQR = document.getElementById('contentQR');

    tabTransfer.onclick = () => {
        contentTransfer.classList.remove('hidden');
        contentQR.classList.add('hidden');

        tabTransfer.classList.add('text-blue-600', 'border-blue-600', 'border-b-2');
        tabQR.classList.remove('text-blue-600', 'border-blue-600', 'border-b-2');
        tabQR.classList.add('text-gray-500');
    };

    tabQR.onclick = () => {
        contentTransfer.classList.add('hidden');
        contentQR.classList.remove('hidden');

        tabQR.classList.add('text-blue-600', 'border-blue-600', 'border-b-2');
        tabTransfer.classList.remove('text-blue-600', 'border-blue-600', 'border-b-2');
        tabTransfer.classList.add('text-gray-500');
    };

</script>

<script>
    const copyBtn = document.getElementById('copyRek');
    const notif = document.getElementById('copyNotif');

    copyBtn.onclick = () => {
        navigator.clipboard.writeText('{{ __("messages.booking_rekening_number") }}').then(() => {
            notif.classList.remove('hidden');
            setTimeout(() => notif.classList.add('hidden'), 1500);
        });
    };
</script>

{{-- SCRIPT MODAL LOGIN --}}
@guest('customer')
<script>
    const closeModal = document.getElementById('closeModal');
    const loginModal = document.getElementById('loginModal');
    const showLoginBtn = document.getElementById('showLoginModalBtn');

    closeModal.onclick = () => loginModal.classList.add('hidden');
    loginModal.onclick = e => {
        if (e.target === loginModal) loginModal.classList.add('hidden');
    };
    showLoginBtn.onclick = () => loginModal.classList.remove('hidden');

</script>
@endguest

@endsection