<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiPeminjamanAlat extends Model
{
    protected $table = 'transaksi_peminjaman_alat';
    protected $fillable = [
        'id_user',
        'id_unit',
        'keperluan',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];
    //

    public function relasiUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function relasiUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }

    public static function createNewTransaksi(array $data)
    {
        return self::create([
            'id_user' => $data['id_user'],
            'id_unit' => $data['id_unit'],
            'keperluan' => $data['keperluan'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'tanggal_kembali' => $data['tanggal_kembali'],
            'status' => 'pending',
        ]);
    }
}
