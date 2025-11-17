@extends('layouts.user')

@section('title', 'OTP | anxietive')

@section('content')
<section class="flex items-center justify-center py-24 bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 mx-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>
        <p class="text-center text-gray-500 mb-8">
            We’ve sent you a link to reset your password. Please check your email.
        </p>

        <!-- Input OTP -->
        <form id="form_ajax">

            <input
                type="text"
                name="email"
                id="email"
                placeholder="Masukkan email"
                class="w-full mb-3 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />


            <!-- Tombol -->
            <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-xl hover:bg-gray-900 transition-all duration-200">
                Reset Password
            </button>

            <!-- Keterangan -->
            <div class="text-center mt-6 space-y-2">
                <p class="text-gray-400 text-xs italic">
                    If it’s not in your inbox, please check your spam folder.
                </p>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Submit form
    $('#form_ajax').on('submit', function(e) {

        e.preventDefault();

        let email = $('#email').val();

        // Validasi
        if (email == "") {
            toastr.warning('Email is required');
            return;
        }

        // Data kirim
        const formData = {
            email: $('#email').val(),
            _token: '{{ csrf_token() }}'
        };

        // Tombol loading
        const $btn = $('#form_ajax button[type="submit"]');
        const originalText = $btn.html();
        $btn.prop('disabled', true).html('<span class="loader border-2 border-white border-t-transparent rounded-full w-5 h-5 inline-block align-middle animate-spin mr-2"></span> Sending...');

        // Kirim via AJAX
        $.ajax({
            url: "{{ route('send.email.resetPassword') }}", // Ganti dengan route yang sesuai
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === true) {
                    toastr.success("We’ve sent you an email to reset your password.");
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
</script>
@endpush