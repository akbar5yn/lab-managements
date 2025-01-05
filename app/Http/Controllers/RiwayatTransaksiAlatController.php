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
        $data = RiwayatTransaksiAlat::all();

        return view('laboran.riwayat-peminjaman-alat', [
            'title' => $this->title,
            'name' => $this->name,
            'role' => $this->role,
            'riwayatPeminjamanAlat' => $data
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

    public function detailRiwayatTransaksi($no_transaksi)
    {
        $subtitle = 'Detail Riwayat';

        $transaksi = TransaksiPeminjamanAlat::where('no_transaksi', $no_transaksi)
            ->with(['relasiUser', 'relasiUnit', 'relasiRiwayatTransaksi'])
            ->firstOrFail();

        return view('laboran.detail-riwayat-transaksi-alat', [
            'title' => $this->title,
            'subtitle' => $subtitle,
            'role' => $this->role,
            'name' => $this->name,
            'transaksi' => $transaksi
        ]);
    }
}
