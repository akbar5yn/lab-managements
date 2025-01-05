<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class RiwayatTransaksiAlat extends Model
{
    protected $table = 'riwayat_transaksi_alat';

    protected $fillable = [
        'no_transaksi',
        'kondisi_alat',
        'tanggal_pengembalian'
    ];

    public function relasiTransaksiAlat(): BelongsTo
    {
        return $this->belongsTo(TransaksiPeminjamanAlat::class, 'no_transaksi', 'no_transaksi');
    }

    public static function createRiwayatTransaksiAlat(array $data)
    {
        $riwayat = self::create([
            'no_transaksi' => $data['no_transaksi'],
            'kondisi_alat' => $data['kondisi_alat'],
            'tanggal_pengembalian' => $data['tgl_pengembalian'],
        ]);

        return $riwayat;
    }

    public static function expireTransaction($no_transaksi)
    {
        return self::create([
            'no_transaksi' => $no_transaksi,
            'kondisi_alat' => 'normal',
        ]);
    }
}
