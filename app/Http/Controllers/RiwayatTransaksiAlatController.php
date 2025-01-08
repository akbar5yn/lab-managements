<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTransaksiAlat;
use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RiwayatTransaksiAlatController extends Controller
{
    protected $user_id;
    protected $name;
    protected $title;
    protected $role;

    public function __construct()
    {
        $user = Auth::user();
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->title = 'Riwayat Peminjaman Alat & Barang';
        $this->role = $user->role;
    }

    public function riwayatPeminjamanAlat()
    {
        $data = null;
        $riwayatMahasiswa = null;

        if (Auth::user()->role == 'laboran') {
            $data = RiwayatTransaksiAlat::all();
        }

        if (Auth::user()->role == 'mahasiswa') {
            $riwayatMahasiswa = RiwayatTransaksiAlat::with(['relasiTransaksiAlat'])
                ->whereHas('relasiTransaksiAlat', function ($query) {
                    $query->where('id_user', Auth::id());
                })
                ->get();
        }

        return view('riwayat-peminjaman-alat', [
            'title' => $this->title,
            'name' => $this->name,
            'role' => $this->role,
            'riwayatPeminjamanAlat' => $data,
            'riwayatMahasiswa' => $riwayatMahasiswa
        ]);
    }
    public function createRiwayatTransaksiAlat(Request $request)
    {
        $validate = $request->validate([
            'no_transaksi' => 'required|unique:riwayat_transaksi_alat,no_transaksi',
            'kondisi_alat' => 'required',
            'tgl_pengembalian' => 'required|date',

        ]);

        try {
            $riwayat = RiwayatTransaksiAlat::createRiwayatTransaksiAlat($validate);

            // Update Status di Transaksi Peminjaman
            $transaksi = TransaksiPeminjamanAlat::where('no_transaksi', $validate['no_transaksi'])->first();
            if ($transaksi) {
                $transaksi->update(['status' => 'dikembalikan']);
            }

            return redirect()->route('riwayat.peminjaman.alat')->with('success', "Verifikasi pengembalian berhasil di buat. Anda dapat mengecek transaksi di dalam halaman riwayat");
        } catch (\Exception $e) {
            return redirect()->route('riwayat.peminjaman.alat')->with('error', 'Terjadi kesalahan saat melakukan verifikasi pengembalian: ' . $e->getMessage());
        }
    }
}
