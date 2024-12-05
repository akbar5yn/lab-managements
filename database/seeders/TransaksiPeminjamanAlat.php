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
                'id_unit' => 1,
                'keperluan' => 'Melakukan peneletian',
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
                'status' => 'dipinjam',
            ],
            [
                'id_user' => 3,
                'keperluan' => 'Melakukan riset',
                'status' => 'pending'
            ],
            [
                'id_user' => 4,
                'keperluan' => 'Melakukan Studi Banding',
                'status' => 'pending'
            ]
        ];
        DB::table('transaksi_peminjaman_alat')->insert($transaksi);
    }
}
