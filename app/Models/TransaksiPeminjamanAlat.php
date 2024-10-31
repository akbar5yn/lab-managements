<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiPeminjamanAlat extends Model
{
    protected $table = 'transaksi_peminjaman_alat';
    protected $fillable = ['id_user', 'keperluan', 'tanggal_pinjam', 'tanggal_kembali'];
    //

    public function relasiUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function relasiDetailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjamanAlat::class, 'id_alat');
    }
}
