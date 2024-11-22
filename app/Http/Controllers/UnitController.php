<?php

namespace App\Http\Controllers;

use App\Models\InventarisAlat;
use App\Models\Unit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UnitController extends Controller
{

    protected $alat;

    public function __construct()
    {
        $slug = FacadesRequest::route('slug');

        $this->alat = InventarisAlat::with('alat')->where('slug', $slug)->firstOrFail();
    }

    public function getUnitAlat($slug)
    {
        $user = Auth::user();
        $title = 'Kelola Alat & Barang';
        $subtitle = 'Detail Alat';
        $name = $user->name;
        $role = $user->role;

        $allUnits = Unit::where('id_alat', $this->alat->id)
            ->with(['detailPeminjaman' => function ($query) {
                $query->whereIn('status', ['dipinjam', 'terlambat_dikembalikan']);
            }])->get();

        $unitTersedia = Unit::where('id_alat', $this->alat->id)
            ->where('kondisi', '!=', 'Rusak')
            ->whereDoesntHave('detailPeminjaman', function ($query) {

                $query->whereIn('status', ['dipinjam', 'terlambat_dikembalikan']);
            })
            ->count();

        $unitDipinjam = Unit::where('id_alat', $this->alat->id)
            ->withCount(['detailPeminjaman' => function ($query) {
                $query->whereIn('status', ['dipinjam', 'terlambat_dikembalikan']);
            }])->get();

        $totalUnitsDipinjam = $unitDipinjam->where('detail_peminjaman_count', '>', 0)->count();


        //ANCHOR - Informasi Unit
        $countRusak = $this->alat->alat()->where('kondisi', 'Rusak')->count();
        $countNormal = $this->alat->alat()->where('kondisi', 'Normal')->count();
        $countTotal = $this->alat->alat()->count();

        return view(
            'laboran.unit',
            [
                'title' => $title,
                'subtitle' => $subtitle,
                'name' => $name,
                'role' => $role,
                'alat' => $this->alat,
                'allUnits' => $allUnits,
                'unitTersedia' => $unitTersedia,
                'totalUnitsDipinjam' => $totalUnitsDipinjam,
                'countRusak' => $countRusak,
                'countNormal' => $countNormal,
                'countTotal' => $countTotal
            ]
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

            return redirect()->route('alat.unit', ['slug' => $slug])->with('success', "Unit berhasil ditambahkan.");
        } catch (\Exception $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Terjadi kesalahan saat menambahkan unit: ' . $e->getMessage());
        }
    }


    public function handleUpdate(Request $request, $slug, $id)
    {
        // Validasi input
        $request->validate([
            'kondisi' => 'required|string|in:Normal,Rusak', // Pastikan hanya nilai yang diizinkan
        ]);


        try {
            $unit = Unit::where('id', $id)
                ->where('id_alat', $this->alat->id)
                ->with(['detailPeminjaman' => function ($query) {
                    $query->whereIn('status', ['pending', 'dipinjam', 'terlambat_dikembalikan']);
                }])
                ->firstOrFail();

            // Cek jika status unit sedang Dipinjam
            if ($unit->detailPeminjaman->isNotEmpty()) {
                return redirect()->route('alat.unit', ['slug' => $slug])
                    ->with('error', 'Unit sedang dipinjam dan tidak dapat diubah.');
            }

            // Gunakan metode updateKondisi di model
            $unit->updateKondisi($request->all());

            return redirect()->route('alat.unit', ['slug' => $slug])
                ->with('success', 'Kondisi alat berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            // Tangani jika unit tidak ditemukan
            return redirect()->route('alat.unit', ['slug' => $slug])
                ->with('error', 'Unit tidak ditemukan.');
        } catch (\Exception $e) {
            // Tangani kesalahan lain
            return redirect()->route('alat.unit', ['slug' => $slug])
                ->with('error', 'Terjadi kesalahan saat memperbarui alat: ' . $e->getMessage());
        }
    }

    public function handleDelete($slug, $id)
    {
        try {
            $unit = Unit::where('id', $id)
                ->where('id_alat', $this->alat->id)
                ->with(['detailPeminjaman' => function ($query) {
                    $query->whereIn('status', ['pending', 'dipinjam', 'terlambat_dikembalikan']);
                }])
                ->firstOrFail();

            if ($unit->detailPeminjaman->isNotEmpty()) {
                return redirect()->route('alat.unit', ['slug' => $slug])
                    ->with('error', 'Unit sedang dipinjam dan tidak dapat dihapus.');
            }
            $unit->deleteUnit();
            return redirect()->route('alat.unit', ['slug' => $slug])->with('success', 'Unit berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Unit tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('alat.unit', ['slug' => $slug])->with('error', 'Terjadi kesalahan saat menghapus unit: ' . $e->getMessage());
        }
    }
}
