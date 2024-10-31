<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiPeminjamanAlat extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaksi = [
            [
                'id_user' => 2,
                'keperluan' => 'Melakukan peneletian',
            ],
            [
                'id_user' => 3,
                'keperluan' => 'Melakukan riset',
            ],
            [
                'id_user' => 4,
                'keperluan' => 'Melakukan Studi Banding',
            ]
        ];
        DB::table('transaksi_peminjaman_alat')->insert($transaksi);
    }
}
