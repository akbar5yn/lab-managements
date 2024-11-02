<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjamanAlat extends Model
{
    protected $table = 'detail_peminjaman_alat';
    protected $fillable = ['id_transaksi_peminjaman', 'id_unit', 'tanggal_pinjam', 'tanggal_kembali'];

    public function relasiTransaksiPeminjamanAlat(): BelongsTo
    {
        return $this->belongsTo(TransaksiPeminjamanAlat::class, 'id_transaksi_peminjaman');
    }

    public function relasiUnitBarang(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }
}
