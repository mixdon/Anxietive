<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'tb_bookings';

    protected $fillable = [
        'package_id',
        'customer_id',
        'fullname',
        'email',
        'phone',
        'message',
        'date',
        'time',
        'img_bukti_trf',
        'status',
    ];

    // Gunakan cast yang sesuai tipe kolom sebenarnya
    protected $casts = [
        'date' => 'date:Y-m-d',  // hanya tampil tanggal
        'time' => 'string',      // simpan sebagai string (karena kolom di DB tipe TIME, bukan DATETIME)
    ];

    // Relasi ke package
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    // Relasi ke customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function scopeCompleted($query){
    return $query->where('status','completed');
    }

    public function scopePending($query){
        return $query->where('status','pending');
    }
}
