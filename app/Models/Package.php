<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'tb_package';
    public $timestamps = false; // karena kamu punya insert_at sendiri

    protected $fillable = [
        'judul_package',
        'id_office',
        'times',
        'amount',
        'image',
        'detail_duration',
        'insert_at',
        'deleted_at', 
    ];

    protected $casts = [
        'detail_duration' => 'array',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class, 'id_office');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'package_id');
    }
}