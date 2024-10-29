<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    protected $fillable = ['nama_ruangan', 'lokasi_ruangan', 'kapasitas'];

    public static function tambahRuangan($data)
    {
        $createRuangan = Ruangan::create($data);

        return $createRuangan;
    }
    public function updateRuangan($data)
    {
        // Update the current instance with the new data
        $this->update($data);
    }

    public function deleteRuangan()
    {
        $this->delete();
    }
}
