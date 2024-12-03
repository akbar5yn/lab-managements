<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiPeminjamanAlat extends Model
{
    protected $table = 'transaksi_peminjaman_alat';
    protected $fillable = ['id_user', 'keperluan'];
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
            'keperluan' => $data['keperluan'],
            'status' => 'pending',
        ]);
    }
}
