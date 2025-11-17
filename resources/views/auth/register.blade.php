@extends('layouts.user')

@section('title', 'Register | anxietive')

@section('content')
<section class="flex items-center justify-center py-24 bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 mx-4">
        <!-- Judul -->
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Register Account</h2>

        <!-- Alert Error -->
        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded p-3">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Alert Success -->
        @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded p-3">
            {{ session('success') }}
        </div>
        @endif

        <!-- Alert Danger -->
        @if(session('failed'))
        <div class="mb-4 bg-red-200 border border-red-200 text-white-700 text-sm rounded p-3">
            {{ session('failed') }}
        </div>
        @endif



        <!-- Form -->
        <form method="POST" action="{{ route('customer.register.post') }}" class="space-y-5">
            @csrf

            <!-- Redirect -->
            <input type="hidden" name="redirect" value="{{ request('redirect', url()->previous()) }}">

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="fullname" value="{{ old('fullname') }}"
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
                    placeholder="Masukkan nama lengkap" required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
                    placeholder="Masukkan email" required>
            </div>

            <!-- Nomor HP -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nomor HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
                    placeholder="Masukkan nomor HP">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="register-password"
                        class="password-input w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-black"
                        placeholder="Masukkan password" required>
                    <button type="button" onclick="togglePassword('register-password', this)"
                        class="absolute top-1/2 right-3 transform -translate-y-1/2">
                        <img src="{{ asset('images/logo/mata_tertutup.png') }}" alt="Toggle" class="h-5 w-5">
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="register-password-confirm"
                        class="password-input w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-black"
                        placeholder="Ulangi password" required>
                    <button type="button" onclick="togglePassword('register-password-confirm', this)"
                        class="absolute top-1/2 right-3 transform -translate-y-1/2">
                        <img src="{{ asset('images/logo/mata_tertutup.png') }}" alt="Toggle" class="h-5 w-5">
                    </button>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition duration-200">
                Register
            </button>
        </form>

        <!-- Login link -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('customer.login', ['redirect' => request('redirect', url()->previous())]) }}"
                class="font-medium text-black hover:underline">Login</a>
        </p>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const img = button.querySelector("img");

        if (input.type === "password") {
            input.type = "text";
            img.src = "{{ asset('images/logo/mata_terbuka.png') }}";
        } else {
            input.type = "password";
            img.src = "{{ asset('images/logo/mata_tertutup.png') }}";
        }
    }
</script>
@endpush