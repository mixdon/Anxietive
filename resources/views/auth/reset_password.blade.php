@extends('layouts.user')

@section('title', 'OTP | anxietive')

@section('content')
<section class="flex items-center justify-center py-24 bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 mx-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>
        <p class="text-center text-gray-500 mb-8">
            Please type your new password
        </p>

        <!-- Input OTP -->
        <form id="form_ajax">

            <input type="hidden" name="token" id="token" value="<?= $_GET['token'] ?>">

            <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" id="customer-password"
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-black"
                    placeholder="Masukkan password" required>
                <button type="button" onclick="togglePassword('customer-password', this)"
                    class="absolute top-1/2 right-3 transform -translate-y-1/2">
                    <img src="{{ asset('images/logo/mata_tertutup.png') }}" alt="Toggle" class="h-5 w-5">
                </button>
            </div>

           
            <div>
                <label class="block text-sm font-medium text-gray-600 mb- mt-3">Konfirmasi Password</label>
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


            <!-- Tombol -->
            <button type="submit" class="w-full py-3 mt-3 bg-black text-white font-semibold rounded-xl hover:bg-gray-900 transition-all duration-200">
                Reset Password
            </button>

            <!-- Keterangan -->

        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Submit form
    $('#form_ajax').on('submit', function(e) {

        e.preventDefault();


        // Data kirim
        const formData = {
            token_get: $('#token').val(),
            _token: '{{ csrf_token() }}',
            password: $('#customer-password').val(),
            password_confirm: $('#register-password-confirm').val(),
        };

        // Tombol loading
        const $btn = $('#form_ajax button[type="submit"]');
        const originalText = $btn.html();
        $btn.prop('disabled', true).html('<span class="loader border-2 border-white border-t-transparent rounded-full w-5 h-5 inline-block align-middle animate-spin mr-2"></span> Please Wait...');

        // Kirim via AJAX
        $.ajax({
            url: "{{ route('confirm_reset_password') }}", // Ganti dengan route yang sesuai
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === true) {
                    toastr.success("Success for reset your password");
                    setTimeout(() => {      
                        window.location.href = "/login";
                    }, 3000);

                } else {
                    toastr.warning(response.message ?? "Failed to send email")
                }
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan, silakan coba lagi.');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });

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