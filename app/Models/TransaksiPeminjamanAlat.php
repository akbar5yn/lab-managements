<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;

class TransaksiPeminjamanAlat extends Model
{
    protected $table = 'transaksi_peminjaman_alat';
    protected $fillable = [
        'no_transaksi',
        'id_user',
        'id_unit',
        'keperluan',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',
        'waktu_kedaluwarsa'
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

    public function relasiRiwayatTransaksi(): HasOne
    {
        return $this->hasOne(RiwayatTransaksiAlat::class, 'no_transaksi', 'no_transaksi');
    }

    public static function createNewTransaksi(array $data, $noTransaksi, $kedaluwarsa)
    {
        return self::create([
            'id_user' => $data['id_user'],
            'id_unit' => $data['id_unit'],
            'keperluan' => $data['keperluan'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'tanggal_kembali' => $data['tanggal_kembali'],
            'status' => 'pending',
            'no_transaksi' => $noTransaksi,
            'waktu_kedaluwarsa' => $kedaluwarsa
        ]);
    }


    public function submitTransaction($status)
    {
        if (!is_string($status)) {
            // Jika status bukan string, bisa log error atau throw exception
            Log::error('Status yang diberikan tidak valid: ' . json_encode($status));
            return false;
        }

        $this->update(['status' => $status]);
    }
}
