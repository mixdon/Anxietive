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
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'id_office');
    }
}