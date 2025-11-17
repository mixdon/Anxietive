@extends('layouts.user')

@section('title', 'OTP | anxietive')

@section('content')
<section class="flex items-center justify-center py-24 bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 mx-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">ENTER OTP CODE</h2>
        <p class="text-center text-gray-500 mb-8">We’ve sent a 5-digit code to your email.</p>

        <!-- Input OTP -->
        <form id="form_ajax">

            <input type="hidden" name="email" id="email" value="<?= $_GET["email"] ?>">

            <div class="flex justify-between mb-8">
                <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" />
                <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" />
                <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" />
                <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" />
                <input type="text" maxlength="1" class="w-12 h-12 text-center text-xl font-semibold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" />
            </div>

            <!-- Tombol -->
            <button type="submit" class="w-full py-3 bg-black text-white font-semibold rounded-xl hover:bg-gray-900 transition-all duration-200">
                VERIFY OTP
            </button>

            <!-- Keterangan -->
            <div class="text-center mt-6 space-y-2">
                <p class="text-gray-500 text-sm">
                    Didn’t receive the code?
                    <a id="resend-link" href="javascript:;" class="text-black hover:underline font-medium">Resend</a>
                    <span id="countdown" class="text-gray-500 ml-2"></span>
                </p>
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
    let $link = $('#resend-link');
    let $countdown = $('#countdown');
    let timer;

    // Fokus otomatis berpindah antar input
    $('input[maxlength="1"]').on('input', function() {
        const $this = $(this);
        if ($this.val().length === 1) {
            $this.next('input').focus();
        }
    }).on('keydown', function(e) {
        if (e.key === 'Backspace' && $(this).val() === '') {
            $(this).prev('input').focus();
        }
    });

    // Submit form
    $('#form_ajax').on('submit', function(e) {
        e.preventDefault();

        // Ambil semua digit
        let otp = '';
        $('#form_ajax input[type="text"]').each(function() {
            otp += $(this).val();
        });

        // Validasi
        if (otp.length !== 5) {
            toastr.warning('Masukkan 5 digit kode OTP dengan benar.');
            return;
        }

        // Data kirim
        const formData = {
            email: $('#email').val(),
            otp_code: otp,
            _token: '{{ csrf_token() }}'
        };

        // Tombol loading
        const $btn = $('#form_ajax button[type="submit"]');
        const originalText = $btn.html();
        $btn.prop('disabled', true).html('<span class="loader border-2 border-white border-t-transparent rounded-full w-5 h-5 inline-block align-middle animate-spin mr-2"></span> Verifying...');

        // Kirim via AJAX
        $.ajax({
            url: "{{ route('verify.otp') }}", // Ganti dengan route yang sesuai
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === true) {
                    toastr.success("Registration successful! You can now log in with your account. Please wait...");
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 3000);

                } else {
                    toastr.warning(response.message ?? "Kode OTP salah atau sudah kedaluwarsa.")
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

    function resend_email() {

        // Bersihkan timer lama (jaga-jaga)
        clearInterval(timer);

        // Simpan waktu expire di localStorage (optional, bisa dihapus kalau tak perlu)
        let expireTime = Math.floor(Date.now() / 1000) + 120;
        localStorage.setItem('resend_expire', expireTime);

        $.ajax({
            url: "{{ route('resend.email.otp') }}", // Ganti dengan route yang sesuai
            type: "POST",
            data: {
                'email': "<?= $_GET['email'] ?>",
                _token: '{{ csrf_token() }}'
            },
            dataType: "json",
            beforeSend: function() {
                // Matikan klik dan ubah tampilan
                $link.css({
                    'pointer-events': 'none',
                    'color': 'gray',
                    'cursor': 'not-allowed'
                });
                $link.text('Sending...');
            },
            success: function(response) {
                toastr.success('Success resend email');
                startCountdown(120);
            },
            error: function(xhr) {
                toastr.error('Terjadi kesalahan, silakan coba lagi.');
                // Jika gagal, aktifkan kembali link
                $link.css({
                    'pointer-events': 'auto',
                    'color': 'black',
                    'cursor': 'pointer'
                });
                $link.text('Resend');
            },
            complete: function() {

            }
        });
    }

    // Fungsi mulai hitung mundur
    function startCountdown(duration) {
        let timeLeft = duration;
        $link.css('pointer-events', 'none').css('color', 'gray');

        timer = setInterval(function() {
            timeLeft--;
            $countdown.text(`(${timeLeft}s)`);

            if (timeLeft <= 0) {
                clearInterval(timer);
                $countdown.text('');
                // $link.css('pointer-events', 'auto').css('color', 'black');
                localStorage.removeItem('resend_expire'); // hapus cache

                $link.css({
                    'pointer-events': 'auto',
                    'color': 'black',
                    'cursor': 'pointer'
                });
                $link.text('Resend');
            }
        }, 1000);
    }

    // Event listener jQuery
    $(document).on('click', '#resend-link', function() {
        resend_email();
    });

    // Hapus cache kalau halaman direfresh
    localStorage.removeItem('resend_expire');
</script>

@endpush