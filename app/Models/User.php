<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import the correct base class

class User extends Authenticatable // Extend the Authenticatable class
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'username',
        'password',
        'role',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
