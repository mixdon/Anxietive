<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = 'tb_offices';
    public $timestamps = false;

    protected $fillable = [
        'office_name',
        'address',
        'email_kantor',
        'no_wa_kantor',
        'latitude',
        'longitude',
        'kode_office',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'id_office');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'office_id');
    }
}