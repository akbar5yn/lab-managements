<?php

namespace App\Http\Controllers;

use App\Models\InventarisAlat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InventarisAlatController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // Memastikan semua metode di controller ini dilindungi
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $title = 'Kelola Alat & Barang';
        $name = $user->name;
        $role = $user->role;

        $lokasi = $request->input('lokasi');
        $search = $request->input('search');
        $query = InventarisAlat::query();

        if ($lokasi) {
            $query->where('lokasi', $lokasi);
        }

        if ($search) {
            $query->where('nama_alat', 'like', '%' . $search . '%');
        }

        $getSortedTools = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $getLokasi = InventarisAlat::select('lokasi')->distinct()->get();

        return view('laboran.inventaris-alat', compact('title', 'name', 'role', 'lokasi', 'getLokasi', 'getSortedTools'));
    }

    public function handleRequest(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tahun_pengadaan' => 'required|integer',
            'fungsi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
        ]);

        try {
            // Simpan data kategori dan unit
            $category = InventarisAlat::createNewAlat($validated);

            return redirect()->route('inventaris-alat')->with('success', 'Kategori dan Unit berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan kategori dan unit: ' . $e->getMessage());
            return redirect()->route('inventaris-alat')->with('error', 'Terjadi kesalahan saat menambahkan kategori dan unit.');
        }
    }

    public function handleUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tahun_pengadaan' => 'required|integer',
            'fungsi' => 'required|string|max:255',
        ]);

        try {
            $tool = InventarisAlat::findOrFail($id);

            $tool->updateEquipment($request->all());

            return redirect()->route('inventaris-alat')->with('success', 'Alat berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('inventaris-alat')->with('error', 'Alat tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('inventaris-alat')->with('error', 'Terjadi kesalahan saat memperbarui alat: ' . $e->getMessage());
        }
    }

    public function handleDelete($id)
    {
        try {
            $category = InventarisAlat::findOrFail($id);
            $category->deleteCategoryWithUnits(); // Memanggil metode di model

            return redirect()->route('inventaris-alat')->with('success', 'Kategori dan semua unit berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('inventaris-alat')->with('error', 'Kategori tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus kategori: ' . $e->getMessage());
            return redirect()->route('inventaris-alat')->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
