<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Import the correct base class
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable // Extend the Authenticatable class
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone_number',
        'prodi'
    ];
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function updateProfile($email, $phone_number)
    {
        $this->email = $email;
        $this->phone_number = $phone_number;

        // Simpan perubahan pada instance ini
        return $this->save();
    }

    public static function createMahasiswa(array $data)
    {

        return self::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'prodi' => $data['prodi'],
            'password' => $data['username'],
            'role' => 'mahasiswa',
        ]);
    }

    public function updateMahasiswa($data)
    {
        $this->update($data);
    }

    public function updatePassword($data)
    {
        $this->update($data);
    }
}
