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
use Illuminate\Support\Facades\Log;

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

    public function indexMahasiswa(Request $request)
    {
        $getUnit = InventarisAlat::withCount([
            'alat' => function ($query) {
                $query->where('kondisi', 'Normal');
            }
        ])->get();

        $cekTanggalRequest = $request->input('cek_tanggal', now()->toDateString());

        // Mencari alat yang tersedia pada tanggal yang diminta
        $alatTersedia = InventarisAlat::whereHas('alat', function ($query) use ($cekTanggalRequest) {
            $query->where('kondisi', '!=', 'Rusak') // Hanya unit yang tidak rusak
                ->whereDoesntHave('relasiTransaksi', function ($query) use ($cekTanggalRequest) {
                    // Menghindari status tertentu
                    $query->whereNotIn('status', ['expire', 'dibatalkan', 'dikembalikan'])
                        ->where(function ($q) use ($cekTanggalRequest) {
                            // Mengecek apakah tanggal yang diminta berada dalam rentang peminjaman
                            $q->whereBetween('tanggal_pinjam', [$cekTanggalRequest, $cekTanggalRequest]) // Cek apakah peminjaman dimulai pada tanggal yang diminta
                                ->orWhereBetween('tanggal_kembali', [$cekTanggalRequest, $cekTanggalRequest]) // Cek apakah peminjaman selesai pada tanggal yang diminta
                                ->orWhereRaw('? BETWEEN tanggal_pinjam AND tanggal_kembali OR ? BETWEEN tanggal_pinjam AND tanggal_kembali', [$cekTanggalRequest, $cekTanggalRequest]); // Cek apakah tanggal yang diminta ada dalam rentang peminjaman
                        });
                });
        })->withCount(['alat' => function ($query) use ($cekTanggalRequest) {
            $query->where('kondisi', '!=', 'Rusak')
                ->whereDoesntHave('relasiTransaksi', function ($query) use ($cekTanggalRequest) {
                    // Menghindari status tertentu
                    $query->whereNotIn('status', ['expire', 'dibatalkan', 'dikembalikan'])
                        ->where(function ($q) use ($cekTanggalRequest) {
                            // Mengecek apakah tanggal yang diminta berada dalam rentang peminjaman
                            $q->whereBetween('tanggal_pinjam', [$cekTanggalRequest, $cekTanggalRequest])
                                ->orWhereBetween('tanggal_kembali', [$cekTanggalRequest, $cekTanggalRequest])
                                ->orWhereRaw('? BETWEEN tanggal_pinjam AND tanggal_kembali OR ? BETWEEN tanggal_pinjam AND tanggal_kembali', [$cekTanggalRequest, $cekTanggalRequest]);
                        });
                });
        }])
            ->get();



        return view('mahasiswa.dashboard', [
            'title' => $this->title,
            'name' => $this->user->name,
            'role' => $this->user->role,
            'prodi' => $this->user->prodi,
            'getUnit' => $getUnit,
            'unitTersedia' => $alatTersedia
        ]);
    }
}
