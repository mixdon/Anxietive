@extends('layouts.user')

@section('title', 'Login | anxietive')

@section('content')
<section class="flex items-center justify-center py-24 bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 mx-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded p-3">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="text" name="identity"
                       class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
                       placeholder="Masukkan email" required>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="login-password"
                           class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-black"
                           placeholder="Masukkan password" required>
                    <button type="button" onclick="togglePassword('login-password', this)"
                            class="absolute top-1/2 right-3 transform -translate-y-1/2">
                        <img src="{{ asset('images/logo/mata_tertutup.png') }}" alt="Toggle" class="h-5 w-5">
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition duration-200">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('customer.register') }}" class="font-medium text-black hover:underline">Register</a>
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