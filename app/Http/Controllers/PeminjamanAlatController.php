<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPeminjamanAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanAlatController extends Controller
{

    // SECTION pengajuan peminjaman
    public function pengajuanPeminjaman()
    {
        $user = Auth::user();
        $title = 'Peminjaman Alat & Barang';
        $name = $user->name;
        $role = $user->role;

        return view('laboran.pengajuan-peminjaman-alat', compact('title', 'name', 'role',));
    }

    // SECTION peminjaman berlangsung

    public function peminjamanBerlangsung()
    {
        $user = Auth::user();
        $title = 'Peminjaman Alat & Barang Berlansung';
        $name = $user->name;
        $role = $user->role;
        $transaksiPeminjaman = TransaksiPeminjamanAlat::with(['relasiUser', 'relasiDetailPeminjaman'])->withCount('relasiDetailPeminjaman')->get();

        return view('laboran.peminjaman-alat', compact('title', 'name', 'role', 'transaksiPeminjaman'));
    }

    public function detailPeminjamanBerlangsung($id)
    {
        $user = Auth::user();
        $title = 'Peminjaman Alat & Barang';
        $subtitle = "Berlangsung";
        $name = $user->name;
        $role = $user->role;

        $transaksi = TransaksiPeminjamanAlat::where('id', $id)
            ->with(['relasiUser', 'relasiDetailPeminjaman'])
            ->firstOrFail();

        return view('laboran.detail-peminjaman-alat', compact('title', 'subtitle', 'role', 'name', 'transaksi'));
    }
}
