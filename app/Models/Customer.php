<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
