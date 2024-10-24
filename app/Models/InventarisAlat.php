<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventarisAlat extends Model
{
    protected $table = 'inventaris_alat';
    protected $fillable = ['slug', 'nama_alat', 'lokasi', 'tahun_pengadaan', 'fungsi', 'jumlah'];

    public function alat(): HasMany
    {
        return $this->hasMany(Unit::class, 'id_alat');
    }

    public static function createNewAlat(array $data)
    {
        // Buat slug dari nama alat
        $slug = str::slug($data['nama_alat']);

        // Simpan data ke EquipmentCategory
        $alat = self::create([
            'slug' => $slug,
            'nama_alat' => $data['nama_alat'],
            'lokasi' => $data['lokasi'],
            'tahun_pengadaan' => $data['tahun_pengadaan'],
            'fungsi' => $data['fungsi'],
            'jumlah' => $data['jumlah']
        ]);

        $namaAlat = $data['nama_alat'];
        $prefix = strtoupper(substr($namaAlat, 0, 2)); // Ambil 2 karakter pertama dan ubah ke huruf besar
        $lastChar = strtoupper(substr($namaAlat, -1, 1));

        for ($i = 1; $i <= $data['jumlah']; $i++) {
            $no_unit = $prefix . $lastChar . $i;
            Unit::create([
                'no_unit' => $no_unit,
                'status' => 'Tersedia',
                'kondisi' => 'Normal',
                'id_alat' => $alat->id,
            ]);
        }

        return $alat;
    }

    public function updateEquipment($data)
    {
        // Update the current instance with the new data
        $this->update($data);
    }

    public function deleteCategoryWithUnits()
    {
        // Hapus semua unit terkait sebelum menghapus kategori
        $this->alat()->delete();
        // Sekarang hapus kategori
        return $this->delete();
    }
}
