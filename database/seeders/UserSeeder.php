<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Akbar Pratama Suryamin',
                'username' => '2000016129',
                'prodi' => '',
                'password' =>  Hash::make('2000016129'),
                'email' => 'akbar@gmail.com',
                'phone_number' => '085266690013',
                'role' => 'laboran'
            ],
            [
                'name' => 'Miftahul Rizqha',
                'username' => '2211016031',
                'prodi' => 'sistem informasi',
                'password' =>  Hash::make('2211016031'),
                'email' => '',
                'phone_number' => '',
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Alfarizi Dwi Putra Suryamin',
                'username' => '2000016001',
                'prodi' => 'teknologi informasi',
                'password' =>  Hash::make('2000016001'),
                'email' => '',
                'phone_number' => '',
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Teguh Dwi Cahya Kusuma',
                'username' => '2000016003',
                'prodi' => 'matematika',
                'password' =>  Hash::make('2000016003'),
                'email' => '',
                'phone_number' => '',
                'role' => 'mahasiswa'
            ]
        ];
        DB::table('users')->insert($users);
    }
}
