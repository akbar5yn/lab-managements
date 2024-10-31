<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AlatSeeder::class,
            UnitSeeder::class,
            RoomSeeder::class,
            DetailPeminjamanAlat::class,
            TransaksiPeminjamanAlat::class,
            // Tambahkan seeder lainnya jika ada
        ]);
    }
}
