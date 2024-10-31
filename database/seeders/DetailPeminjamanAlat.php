<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPeminjamanAlat extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detail_alat = [
            [
                'id_transaksi_peminjaman' => 1,
                'id_alat' => 1,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
            ],
            [
                'id_transaksi_peminjaman' => 1, // Masih transaksi yang sama
                'id_alat' => 2,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 7),
            ],
            [
                'id_transaksi_peminjaman' => 1, // Masih transaksi yang sama
                'id_alat' => 3,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
            ],
            [
                'id_transaksi_peminjaman' => 2,
                'id_alat' => 2,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
            ],
            [
                'id_transaksi_peminjaman' => 2,
                'id_alat' => 10,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
            ],
            [
                'id_transaksi_peminjaman' => 3,
                'id_alat' => 3,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
            ]
        ];
        DB::table('detail_peminjaman_alat')->insert($detail_alat);
    }
}
