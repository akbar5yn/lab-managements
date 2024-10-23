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
                'role' => 'laboran'
            ],
            [
                'name' => 'Miftahul Rizqha',
                'nim' => '2000016130',
                'username' => 'mifta',
                'password' =>  Hash::make('2000016130'),
                'role' => 'mahasiswa'
            ]
        ];
        DB::table('users')->insert($users);
    }
}
