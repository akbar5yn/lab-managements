<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjamanAlat;
use App\Models\InventarisAlat;
use App\Models\TransaksiPeminjamanAlat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PeminjamanAlatController extends Controller
{
    protected $user_id;
    protected $name;
    protected $title;
    protected $role;
    protected $currentTime;
    protected $startOfDay;
    protected $endOfDay;

    public function __construct()
    {
        $user = Auth::user();
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->title = 'Peminjaman Alat & Barang';
        $this->role = $user->role;

        // ANCHOR set rule hours
        $this->currentTime = Carbon::now('Asia/Jakarta');
        $this->startOfDay = $this->currentTime->copy()->setTime(9, 0, 0);
        $this->endOfDay = $this->currentTime->copy()->setTime(15, 0, 0);
    }

    // SECTION pengajuan peminjaman
    public function pengajuanPeminjaman()
    {

        $transaksiPengajuanPeminjaman = TransaksiPeminjamanAlat::with(['relasiUser', 'relasiDetailPeminjaman'])
            ->withCount('relasiDetailPeminjaman')
            ->where('status', 'pending')
            ->get();

        return view('laboran.pengajuan-peminjaman-alat', [
            'title' => $this->title,
            'name' => $this->name,
            'role' => $this->role,
            'transaksiPengajuanPeminjaman' => $transaksiPengajuanPeminjaman
        ]);
    }

    public function detailPengajuanAlat($id)
    {
        $subtitle = 'Pengajuan';

        $transaksi = TransaksiPeminjamanAlat::where('id', $id)
            ->with(['relasiUser', 'relasiDetailPeminjaman'])
            ->firstOrFail();

        return view('laboran.detail-pengajuan-ruangan', [
            'title' => $this->title,
            'subtitle' => $subtitle,
            'role' => $this->role,
            'name' => $this->name,
            'transaksi' => $transaksi
        ]);
    }

    // SECTION peminjaman berlangsung

    public function peminjamanBerlangsung()
    {
        $user = Auth::user();
        $transaksiPeminjaman = TransaksiPeminjamanAlat::with(['relasiUser', 'relasiDetailPeminjaman'])
            ->withCount('relasiDetailPeminjaman')
            ->where('status', 'berlangsung')
            ->get();

        return view('laboran.peminjaman-alat', [
            'title' => $this->title,
            'name' => $this->name,
            'role' => $this->role,
            'transaksiPeminjaman' => $transaksiPeminjaman
        ]);
    }

    public function detailPeminjamanBerlangsung($id)
    {
        $subtitle = "Berlangsung";

        $transaksi = TransaksiPeminjamanAlat::where('id', $id)
            ->with(['relasiUser', 'relasiDetailPeminjaman'])
            ->firstOrFail();

        return view('laboran.detail-peminjaman-alat', [
            'title' => $this->title,
            'subtitle' => $subtitle,
            'role' => $this->role,
            'name' => $this->name,
            'transaksi' => $transaksi
        ]);
    }

    // ANCHOR Index page peminjaman alat [Mahasiswa]
    public function informasiAlat()
    {
        if ($this->currentTime->lessThan($this->startOfDay)) {
            $minDate = $this->startOfDay->toDateString();
        } elseif ($this->currentTime->greaterThanOrEqualTo($this->endOfDay)) {
            $minDate = $this->currentTime->addDay()->setTime(9, 0, 0)->toDateString();
        } else {
            $minDate = $this->currentTime->toDateString();
        }

        $maxDate = $this->currentTime->addDays(5)->toDateString();
        $minReturnDate = $this->currentTime->copy()->addDay()->toDateString();

        $getUnit = InventarisAlat::withCount([
            'alat' => function ($query) {
                $query->where('kondisi', 'Normal')
                    ->whereDoesntHave('detailPeminjaman', function ($query) {
                        $query->whereIn('status', ['dipinjam', 'terlambat_dikembalikan']);
                    })->orderBy('id', 'asc');;
            }
        ])->get();


        return view('mahasiswa.informasi-alat', [
            'name' => $this->name,
            'title' => $this->title,
            'role' => $this->role,
            'user_id' => $this->user_id,
            'getUnit' => $getUnit,
            'minDate' => $minDate,
            'maxDate' => $maxDate,
            'minReturnDate' => $minReturnDate
        ]);
    }

    public function pinjamAlat(Request $request)
    {
        // Validasi data transaksi
        $validatedTransaksi = $request->validate([
            'id_user' => 'required',
            'keperluan' => 'required|string|max:255',
        ]);

        // Validasi data detail transaksi
        $validatedDetail = $request->validate([
            'id_unit' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        Log::info('Request masuk ke metode pinjamAlat', $request->all());

        try {
            // Cek apakah ada pengajuan lain untuk alat yang sama pada rentang tanggal yang diajukan
            $overlappingRequests = DetailPeminjamanAlat::where('id_unit', $validatedDetail['id_unit'])
                ->where(function ($query) use ($validatedDetail) {
                    $query->where('tanggal_kembali', '>=', $validatedDetail['tanggal_pinjam']) // Tidak di luar di kiri
                        ->where('tanggal_pinjam', '<=', $validatedDetail['tanggal_kembali']); // Tidak di luar di kanan
                })
                ->where('status', '!=', 'dikembalikan') // Abaikan pengajuan yang ditolak
                ->get(['tanggal_pinjam', 'tanggal_kembali']);

            // Jika ada pengajuan lain pada tanggal tersebut
            if ($overlappingRequests->isNotEmpty()) {
                $dates = $overlappingRequests->map(function ($item) {
                    return $item->tanggal_pinjam . ' s/d ' . $item->tanggal_kembali;
                })->implode(', ');

                return redirect()->route('informasi.alat')
                    ->with('warning', 'Alat sedang dalam tahap pengajuan oleh mahasiswa lain pada rentang tanggal berikut: ' . $dates);
            }

            // Buat transaksi baru
            $transaksi = TransaksiPeminjamanAlat::createNewTransaksi($validatedTransaksi);
            $detail_transaksi = DetailPeminjamanAlat::createNewDetailTransaksi($validatedDetail, $transaksi->id);

            return redirect()->route('informasi.alat')->with('success', 'Peminjaman Anda berhasil dibuat. Tolong lakukan scan di lab untuk melanjutkan peminjaman pada tanggal peminjaman.');
        } catch (\Throwable $e) {
            Log::error('Error saat melakukan transaksi peminjaman alat: ' . $e->getMessage());
            return redirect()->route('informasi.alat')->with('error', 'Terjadi kesalahan saat melakukan peminjaman.');
        }
    }

    public function aktifitasPeminjaman()
    {
        return view('mahasiswa.aktifitas-peminjaman', [
            'name' => $this->name,
            'title' => $this->title,
            'role' => $this->role,
        ]);
    }
}
