<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_customer';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'fullname',
        'phone',
        'status_aktif',
        'otp_code',
        'otp_expires_at',
        'insert_at',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'otp_code',
    ];

    public function generate_otp()
    {
        do {
            // generate angka acak 5 digit (misal: 48392)
            $otp = rand(10000, 99999);

            // cek apakah sudah ada di database
            $exists = DB::table('tb_customer')
                ->where('otp_code', $otp)
                ->exists();
        } while ($exists); // ulangi jika sudah ada

        // kembalikan OTP yang unik
        return $otp;
    }

    public function generate_expired_at()
    {
        return date('Y-m-d H:i:s', strtotime('+24 hours'));
    }

    public function generate_token_reset_pass()
    {
        do {
            // generate angka acak 5 digit (misal: 48392)
            $token = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 5);

            // cek apakah sudah ada di database
            $exists = DB::table('tb_riwayat_reset_pass')
                ->where('token', $token)
                ->exists();
        } while ($exists); // ulangi jika sudah ada

        // kembalikan OTP yang unik
        return $token;
    }

    public function get_detail($email){
        $data = array();

        $data = DB::table('tb_customer')
                    ->where("email", $email)
                    ->first();

        return $data;
    }
}
