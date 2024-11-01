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
                'nim' => '2000016129',
                'username' => 'akbar',
                'password' =>  Hash::make('2000016129'),
                'email' => 'akbar@gmail.com',
                'phone_number' => '085266690013',
                'role' => 'laboran'
            ],
            [
                'name' => 'Miftahul Rizqha',
                'nim' => '2000016130',
                'username' => 'mifta',
                'password' =>  Hash::make('2000016130'),
                'email' => 'mifta@gmail.com',
                'phone_number' => '085200110022',
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Alfarizi Dwi Putra Suryamin',
                'nim' => '2000016001',
                'username' => 'farid',
                'password' =>  Hash::make('2000016001'),
                'email' => 'farid@gmail.com',
                'phone_number' => '085200110022',
                'role' => 'mahasiswa'
            ],
            [
                'name' => 'Teguh Dwi Cahya Kusuma',
                'nim' => '2000016003',
                'username' => 'mifta',
                'password' =>  Hash::make('2000016003'),
                'email' => 'teguh@gmail.com',
                'phone_number' => '085200110022',
                'role' => 'mahasiswa'
            ]
        ];
        DB::table('users')->insert($users);
    }
}
