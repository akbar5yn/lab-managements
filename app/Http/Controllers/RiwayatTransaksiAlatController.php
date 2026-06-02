<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTransaksiAlat;
use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

    public function riwayatPeminjamanAlat(Request $request)
    {
        $data = null;
        $riwayatMahasiswa = null;

        if (Auth::user()->role == 'laboran') {
            $search = $request->input('search');

            $query = RiwayatTransaksiAlat::query();

            if ($search) {
                $query->whereHas('relasiTransaksiAlat.relasiUser', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('relasiTransaksiAlat', function ($q) use ($search) {
                        $q->where('no_transaksi', 'like', "%{$search}%");
                    });
            }

            $data = $query->with(['relasiTransaksiAlat.relasiUser'])->get();
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

            DB::transaction(function () use ($validate) {

                RiwayatTransaksiAlat::createRiwayatTransaksiAlat($validate);

                $transaksi = TransaksiPeminjamanAlat::with('relasiUnit')
                    ->where('no_transaksi', $validate['no_transaksi'])
                    ->firstOrFail();

                $transaksi->update([
                    'status' => 'dikembalikan'
                ]);

                if ($transaksi->relasiUnit) {
                    $transaksi->relasiUnit->update([
                        'kondisi' => $validate['kondisi_alat'],
                        'status'  => 'tersedia'
                    ]);
                }
            });

            return redirect()
                ->route('riwayat.peminjaman.alat')
                ->with(
                    'success',
                    'Verifikasi pengembalian berhasil dibuat. Anda dapat mengecek transaksi di halaman riwayat.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->route('riwayat.peminjaman.alat')
                ->with(
                    'error',
                    'Terjadi kesalahan saat melakukan verifikasi pengembalian: ' . $e->getMessage()
                );
        }
    }
}
