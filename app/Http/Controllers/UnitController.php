<?php

namespace App\Http\Controllers;

use App\Models\InventarisAlat;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        );
    }

    public function handlePost(Request $request, $slug)
    {
        $validate = $request->validate([
            'nama_alat' => 'required|string',
            'id_alat' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        try {
            $jumlahUnit = Unit::addUnit($validate);

            return redirect()->route('alat.unit', ['slug' => $slug])->with('success', "$jumlahUnit Unit berhasil ditambahkan.");
        } catch (\Exception $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Terjadi kesalahan saat menambahkan unit: ' . $e->getMessage());
        }
    }


    public function handleUpdate(Request $request, $slug, $id)
    {
        $request->validate([
            'kondisi' => 'required|string|in:Normal,Rusak', // Pastikan hanya nilai yang diizinkan
        ]);
        try {
            $unit = Unit::findOrFail($id);
            $unit->updateKondisi($request->all());

            return redirect()->route('alat.unit', ['slug' => $slug])->with('success', 'Kondisi alat berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Alat tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Terjadi kesalahan saat memperbarui alat: ' . $e->getMessage());
        }
    }
    public function handleDelete($slug, $id)
    {
        try {
            $unit = Unit::findOrFail($id);
            $unit->deleteUnit($id);
            return redirect()->route('alat.unit', ['slug' => $slug])->with('success', 'Unit berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Unit tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Terjadi kesalahan saat menghapus unit: ' . $e->getMessage());
        }
    }
}
