<?php

namespace App\Http\Controllers;

use App\Models\InventarisAlat;
use App\Models\Ruangan;
use App\Models\TransaksiPeminjamanAlat;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $user;
    protected $name;
    protected $title;
    protected $role;
    protected $prodi;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); // Simpan data user ke properti
            return $next($request);
        });

        $this->title = "Dashboard";
    }

    private function getPengajuanPeminjaman()
    {
        $peminjamanAlatController = new PeminjamanAlatController();
        $pengajuanPeminjaman = $peminjamanAlatController->pengajuanPeminjaman();

        if ($pengajuanPeminjaman->transaksiPengajuanPeminjaman->isEmpty()) {
            return null;
        }

        return $pengajuanPeminjaman->transaksiPengajuanPeminjaman->all();
    }

    private function getTransaksiPeminjaman()
    {
        $peminjamanAlatController = new PeminjamanAlatController();
        $peminjamanBerlangsung = $peminjamanAlatController->peminjamanBerlangsung();

        if ($peminjamanBerlangsung->transaksiPeminjaman->isEmpty()) {
            return null;
        }

        return $peminjamanBerlangsung->transaksiPeminjaman->all();
    }

    public function indexLaboran()
    {

        $totalUnit = Unit::count();
        $totalMhs = User::where('role', 'mahasiswa')->count();
        $unitRusak = Unit::where('kondisi', 'Rusak')->count();
        $totalPengajuan = TransaksiPeminjamanAlat::where('status', 'pending')->count();
        $totalPeminjaman = TransaksiPeminjamanAlat::where('status', 'dipinjam')->count();

        $transaksiPengajuanPeminjaman = $this->getPengajuanPeminjaman();
        $transaksiPeminjaman = $this->getTransaksiPeminjaman();

        // Konten dashboard
        return view('laboran.dashboard', [
            'title' => $this->title,
            'name' => $this->user->name,
            'role' => $this->user->role,
            'totalUnit' => $totalUnit,
            'totalMhs' => $totalMhs,
            'unitRusak' => $unitRusak,
            'totalPengajuan' => $totalPengajuan,
            'totalPeminjaman' => $totalPeminjaman,
            'transaksiPengajuanPeminjaman' => $transaksiPengajuanPeminjaman,
            'transaksiPeminjaman' => $transaksiPeminjaman
        ]);
    }

    public function indexMahasiswa()
    {
        $getUnit = InventarisAlat::withCount([
            'alat' => function ($query) {
                $query->where('kondisi', 'Normal');
            }
        ])->get();


        $ruanganTersedia = Ruangan::all();
        return view('mahasiswa.dashboard', [
            'title' => $this->title,
            'name' => $this->user->name,
            'role' => $this->user->role,
            'prodi' => $this->user->prodi,
            'getUnit' => $getUnit,
            'ruanganTersedia' => $ruanganTersedia
        ]);
    }
}
