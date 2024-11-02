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
                'id_unit' => 1,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
                'status' => 'dipinjam',
            ],
            [
                'id_transaksi_peminjaman' => 1, // Masih transaksi yang sama
                'id_unit' => 4,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 7),
                'status' => 'dikembalikan',
            ],
            [
                'id_transaksi_peminjaman' => 2,
                'id_unit' => 2,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
                'status' => 'pending',
            ],
            [
                'id_transaksi_peminjaman' => 3,
                'id_unit' => 3,
                'tanggal_pinjam' => Carbon::create(2024, 11, 1),
                'tanggal_kembali' => Carbon::create(2024, 11, 10),
                'status' => 'pending',
            ]
        ];
        DB::table('detail_peminjaman_alat')->insert($detail_alat);
    }
}
