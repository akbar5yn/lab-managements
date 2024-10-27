<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InventarisRuanganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $title = 'Kelola Ruangan';
        $name = $user->name;
        $role = $user->role;
        $dataRuangan = Ruangan::all();

        return view('laboran.inventaris-ruangan', compact('title', 'name', 'role', 'dataRuangan'));
    }

    public function handlePost(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:100',
            "lokasi_ruangan" => 'required|string|max:100',
            "kapasitas" => 'required|integer|max:100'
        ]);

        try {
            // Simpan data kategori dan unit
            $ruangan = Ruangan::tambahRuangan($validated);

            return redirect()->route('inventaris-ruangan')->with('success', "Ruangan berhasil di tambahkan");
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan ruangan: ' . $e->getMessage());
            return redirect()->route('inventaris-ruangan')->with('error', 'Terjadi kesalahan saat menambahkan ruangan.');
        }
    }

    public function handleEdit(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:100',
            "lokasi_ruangan" => 'required|string|max:100',
            "kapasitas" => 'required|integer|max:100'
        ]);

        try {
            $ruangan = Ruangan::findOrFail($id);

            $ruangan->updateRuangan($request->all());

            return redirect()->route('inventaris-ruangan')->with('success', 'Ruangan berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('inventaris-ruangan')->with('error', 'Ruangan tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('inventaris-ruangan')->with('error', 'Terjadi kesalahan saat memperbarui ruangan: ' . $e->getMessage());
        }
    }
}
