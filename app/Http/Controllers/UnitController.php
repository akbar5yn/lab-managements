<?php

namespace App\Http\Controllers;

use App\Models\InventarisAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function getUnitAlat($slug)
    {
        $user = Auth::user();
        $title = 'Kelola Alat & Barang';
        $subtitle = 'Detail Alat';
        $name = $user->name;
        $role = $user->role;
        $alat = InventarisAlat::with('alat')->where('slug', $slug)->firstOrFail();

        $units = $alat->alat;

        //ANCHOR - Informasi Unit
        $countTersedia = $alat->alat()->where('status', 'Tersedia')->count();
        $countDipinjam = $alat->alat()->where('status', 'Dipinjam')->count();
        $countRusak = $alat->alat()->where('kondisi', 'Rusak')->count();
        $countNormal = $alat->alat()->where('kondisi', 'Normal')->count();
        $countTotal = $alat->alat()->count();

        return view(
            'laboran.unit',
            compact(
                'title',
                'subtitle',
                'name',
                'role',
                'alat',
                'units',
                'countTersedia',
                'countDipinjam',
                'countRusak',
                'countNormal',
                'countTotal'
            )
            // [
            //     'units' => $units,
            //     'countTersedia' => $countTersedia,
            //     'countDipinjam' => $countDipinjam,
            //     'countRusak' => $countRusak,
            //     'countNormal' => $countNormal,
            //     'countTotal' => $countTotal,
            // ]
        );
    }
}
