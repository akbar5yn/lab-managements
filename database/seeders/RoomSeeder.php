<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'nama_ruangan' => 'Lab Fisika Dasar',
                'lokasi_ruangan' => 'Gedung Utama Lantai 1',
                'kapasitas' => '30'
            ],
            [
                'nama_ruangan' => 'Lab Fisika Modern',
                'lokasi_ruangan' => 'Gedung Utama Lantai 2',
                'kapasitas' => '20'
            ],
            [
                'nama_ruangan' => 'Lab Elektronika dan Instrumentasi',
                'lokasi_ruangan' => 'Gedung Utama Lantai 1',
                'kapasitas' => '20'
            ],
            [
                'nama_ruangan' => 'Ruang Material 1 dan Material 5',
                'lokasi_ruangan' => 'Gedung Utama Lantai 2',
                'kapasitas' => '30'
            ],
        ];
        DB::table('ruangan')->insert($rooms);
    }
}
