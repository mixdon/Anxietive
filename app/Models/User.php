<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_user';

    protected $fillable = [
        'username',
        'password',
        'fullname',
        'office',
        'roles',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles');
    }

    public function officeData()
    {
        return $this->belongsTo(Office::class, 'office');
    }
}