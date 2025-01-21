<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Unit extends Model
{
    protected $table = 'unit';
    protected $fillable = ['no_unit', 'status', 'kondisi', 'id_alat'];

    public function relasiTransaksi(): HasMany
    {
        return $this->hasMany(TransaksiPeminjamanAlat::class, 'id_unit');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(InventarisAlat::class, 'id_alat');
    }
    public static function addUnit(array $data)
    {
        $id_alat = $data['id_alat'];
        $namaAlat = $data['nama_alat'];
        $prefix = strtoupper(substr($namaAlat, 0, 2));
        $lastChar = strtoupper(substr($namaAlat, -1, 1));
        $lastUnit = Unit::where('id_alat', $id_alat)->max('no_unit');
        $lastNumber = $lastUnit ? (int) filter_var($lastUnit, FILTER_SANITIZE_NUMBER_INT) : 0;

        $jumlahDitambahkan = 0;

        for ($i = 1; $i <= $data['jumlah']; $i++) {
            // Generate no_unit
            $no_unit = $prefix . $lastChar . ($lastNumber + $i);

            // Cek jika no_unit sudah ada
            while (Unit::where('no_unit', $no_unit)->exists()) {
                // Jika sudah ada, tambahkan 1 ke lastNumber untuk menghasilkan no_unit yang baru
                $lastNumber++;
                $no_unit = $prefix . $lastChar . ($lastNumber + $i);
            }

            // Buat unit baru
            Unit::create([
                'no_unit' => $no_unit,
                'kondisi' => 'Normal',
                'id_alat' => $id_alat,
            ]);

            Log::info('No unit yang dihasilkan:', ['no_unit' => $no_unit]);
        }



        return $jumlahDitambahkan; // Mengembalikan total unit yang ditambahkan
    }



    public function updateKondisi($data)
    {
        // Update the current instance with the new data
        $this->update($data);
    }

    public function deleteUnit()
    {
        return $this->delete();
    }
}
