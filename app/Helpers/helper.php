<?php

if (!function_exists('encrypt_string')) {
    function encrypt_string($string)
    {
        $key = hash('sha256', 'Anxietive2025'); // buat key 32-byte dari string
        $iv = substr(hash('sha256', 'Anxietive2025_iv'), 0, 16); // inisialisasi IV (16 byte)

        $output = openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv);
        return base64_encode($output);
    }
}

if (!function_exists('decrypt_string')) {
    function decrypt_string($encrypted)
    {
        $key = hash('sha256', 'Anxietive2025');
        $iv = substr(hash('sha256', 'Anxietive2025_iv'), 0, 16);

        return openssl_decrypt(base64_decode($encrypted), 'AES-256-CBC', $key, 0, $iv);
    }
}
