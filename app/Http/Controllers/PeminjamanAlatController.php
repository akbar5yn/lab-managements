<?php

namespace App\Http\Controllers;

use App\Jobs\CancelExpiredTransaction;
use App\Jobs\ReturnedLateTransaction;
use App\Models\InventarisAlat;
use App\Models\RiwayatTransaksiAlat;
use App\Models\TransaksiPeminjamanAlat;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class PeminjamanAlatController extends Controller
{
    protected $user_id;
    protected $name;
    protected $title;
    protected $role;
    protected $currentTime;
    protected $startOfDay;
    protected $endOfDay;
    protected $today;

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
        $this->today = Carbon::now('Asia/Jakarta')->toDateString();
    }

    // SECTION Laboran
    // ANCHOR pengajuan peminjaman
    public function pengajuanPeminjaman()
    {
        $transaksiPengajuanPeminjaman = TransaksiPeminjamanAlat::with(['relasiUser', 'relasiUnit'])
            ->withCount('relasiUnit')
            ->where('status', 'pending')
            ->get();

        return view('laboran.pengajuan-peminjaman-alat', [
            'title' => $this->title,
            'name' => $this->name,
            'role' => $this->role,
            'transaksiPengajuanPeminjaman' => $transaksiPengajuanPeminjaman
        ]);
    }


    // ANCHOR peminjaman berlangsung
    public function peminjamanBerlangsung()
    {
        $transaksiPeminjaman = TransaksiPeminjamanAlat::with(['relasiUser', 'relasiUnit'])
            ->withCount('relasiUnit')
            ->whereIn('status', ['dipinjam', 'terlambat_dikembalikan'])
            ->get();

        return view('laboran.peminjaman-alat', [
            'title' => $this->title,
            'name' => $this->name,
            'role' => $this->role,
            'transaksiPeminjaman' => $transaksiPeminjaman
        ]);
    }


    // ANCHOR Halaman qrCode
    public function showQrCodePage(Request $request)
    {
        // Buat nilai acak untuk QR key
        $randomValue = Str::random(32);

        // Tentukan waktu kadaluarsa (misalnya 3 menit)
        $expirationTime = now()->addMinutes(3);

        // Simpan ke Redis dengan TTL (time-to-live) 10 menit
        Redis::setex("qr:$randomValue", 180, json_encode([
            'qr_access_key' => $randomValue,
            'qr_access_time' => $expirationTime,
            'is_scanned' => false,
        ]));

        Log::info('Redis key set', ['key' => "qr:$randomValue", 'value' => Redis::get("qr:$randomValue")]);

        Log::info('QR Key disimpan di Redis', [
            'qr_access_key' => $randomValue,
            'qr_access_time' => $expirationTime,
        ]);

        $url = route('detail.transaksi', ['key' => $randomValue]);

        // Generate QR Code untuk URL ini
        $qrCode = QrCode::size(250)->generate($url);

        return view('laboran.qrcode-transaksi', [
            'name' => $this->name,
            'title' => $this->title,
            'role' => $this->role,
            'qrCode' => $qrCode,
        ]);
    }


    // SECTION [Mahasiswa]
    // ANCHOR informasi alat
    public function informasiAlat()
    {
        $subtitle = 'Informasi Alat';

        $getUnit = InventarisAlat::withCount([
            'alat' => function ($query) {
                $query->where('kondisi', 'Normal');
            }
        ])->get();


        return view('mahasiswa.informasi-alat', [
            'name' => $this->name,
            'title' => $this->title,
            'subtitle' => $subtitle,
            'role' => $this->role,
            'user_id' => $this->user_id,
            'getUnit' => $getUnit,
        ]);
    }

    // ANCHOR detail alat
    public function detailAlat($slug)
    {
        $subtitle = 'Pinjam Alat';

        $alat = InventarisAlat::with('alat')->where('slug', $slug)->firstOrFail();
        $namaAlat = $alat->nama_alat;

        $allUnits = Unit::where('id_alat', $alat->id)
            ->where('kondisi', ['Normal'])
            ->with(['relasiTransaksi' => function ($query) {
                $query->whereIn('status', ['pending', 'dipinjam', 'terlambat_dikembalikan']);
            }])->paginate(15);

        if ($this->currentTime->lessThan($this->startOfDay)) {
            $minDate = $this->startOfDay->toDateString();
        } elseif ($this->currentTime->greaterThanOrEqualTo($this->endOfDay)) {
            $minDate = $this->currentTime->addDay()->setTime(9, 0, 0)->toDateString();
        } else {
            $minDate = $this->currentTime->toDateString();
        }

        $maxDate = $this->currentTime->addDays(5)->toDateString();
        $minReturnDate = $this->currentTime->copy()->addDay()->toDateString();

        return view('mahasiswa.detail-alat', [
            'name' => $this->name,
            'title' => $this->title,
            'subtitle' => $subtitle,
            'role' => $this->role,
            'user_id' => $this->user_id,
            'allUnits' => $allUnits,
            'namaAlat' => $namaAlat,
            'maxDate' => $maxDate,
            'minDate' => $minDate,
            'minReturnDate' => $minReturnDate,
            'alat' => $alat,
        ]);
    }


    public function hitungWaktuKedaluwarsa($tanggalPinjam)
    {

        if ($tanggalPinjam->isToday() && $this->currentTime->lessThan($this->startOfDay)) {
            return $this->startOfDay->addMinutes(1);
        } elseif ($tanggalPinjam->isToday() && $this->currentTime->greaterThan($this->startOfDay)) {
            return $this->currentTime->addMinutes(1);
        } else {
            return $tanggalPinjam->setTime(9, 45)->addMinute();
        }
    }

    public function checkReturnedLate($tanggalKembali)
    {
        $currentTime = Carbon::now('Asia/Jakarta');
        $delay = $currentTime->diffInSeconds($tanggalKembali, false);

        Log::info('tgl returned ' . $tanggalKembali);
        Log::info('currentTime returned ' . $currentTime);

        return $delay;
    }


    // ANCHOR fungsi pinjam alat
    public function pinjamAlat(Request $request, $slug, $unit)
    {
        // Validasi data transaksi
        $validatedTransaksi = $request->validate([
            'id_user' => 'required',
            'id_unit' => 'required',
            'keperluan' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
        ]);

        Log::info('Request masuk ke metode pinjamAlat', $request->all());

        try {
            // ANCHOR Cek data email & no hp

            $user = User::findOrFail($request->input('id_user'));

            if (empty($user->email) || empty($user->phone_number)) {
                return redirect()->route('profile.mhs')->with('error', 'Silakan lengkapi email dan nomor handphone Anda sebelum melakukan peminjaman.');
            }
            // Cek apakah ada pengajuan lain untuk alat yang sama pada rentang tanggal yang diajukan
            $overlappingRequests = TransaksiPeminjamanAlat::where('id_unit', $unit)
                ->where(function ($query) use ($validatedTransaksi) {
                    $query->where('tanggal_kembali', '>=', $validatedTransaksi['tanggal_pinjam']) // Tidak di luar di kiri
                        ->where('tanggal_pinjam', '<=', $validatedTransaksi['tanggal_kembali']); // Tidak di luar di kanan
                })
                ->whereNotIn('status', ['dikembalikan', 'expire', 'dibatalkan']) // Abaikan pengajuan yang ditolak
                ->get(['tanggal_pinjam', 'tanggal_kembali']);

            // Jika ada pengajuan lain pada tanggal tersebut
            if ($overlappingRequests->isNotEmpty()) {
                $dates = $overlappingRequests->map(function ($item) {
                    return $item->tanggal_pinjam . ' s/d ' . $item->tanggal_kembali;
                })->implode(', ');

                return redirect()->route('detail.alat', ['slug' => $slug])
                    ->with('error', 'Alat sedang dalam tahap pengajuan oleh mahasiswa lain pada rentang tanggal berikut: ' . $dates);
            }

            // NOTE Checking waktu kadaluwarsa pada saat pengajuan
            $tanggalPinjam = Carbon::parse($validatedTransaksi['tanggal_pinjam']);
            $waktuKedaluwarsa = $this->hitungWaktuKedaluwarsa($tanggalPinjam);



            $unitData = Unit::find($request->input('id_unit'));
            $namaUnit = strtoupper(substr($unitData->unit->nama_alat ?? 'XX', 0, 2));
            $idUnit = $request->input('id_unit');
            $idUser = $request->input('id_user');
            $salt = config('app.key');
            $hashing = strtoupper(hash('sha256', $idUser . $salt));
            $randomNumber = rand(10000, 99999);
            $noTransaksi = $namaUnit . substr($hashing, 0, 8) . $idUnit . $randomNumber;

            // Buat transaksi baru
            $transaksi = TransaksiPeminjamanAlat::createNewTransaksi($validatedTransaksi, $noTransaksi, $waktuKedaluwarsa);

            CancelExpiredTransaction::dispatch($transaksi->id)->delay($waktuKedaluwarsa);

            // NOTE Checking waktu pengembalian
            $tanggalKembali = Carbon::parse($validatedTransaksi['tanggal_kembali'])->setTime(15, 0, 0);
            $delay = $this->checkReturnedLate($tanggalKembali);
            if ($delay > 0) {
                // Jika belum lewat batas waktu, jalankan job dengan delay
                ReturnedLateTransaction::dispatch($transaksi->id)->delay($delay);
            } else {
                // Jika sudah terlambat, langsung proses
                ReturnedLateTransaction::dispatch($transaksi->id);
            }

            return redirect()->route('aktivitas.peminjaman')->with('success', 'Peminjaman Anda berhasil dibuat. Tolong lakukan scan di lab untuk melanjutkan peminjaman pada tanggal peminjaman.');
        } catch (\Throwable $e) {
            Log::error('Error saat melakukan transaksi peminjaman alat: ' . $e->getMessage());
            return redirect()->route('detail.alat', ['slug' => $slug])->with('error', 'Terjadi kesalahan saat melakukan peminjaman.');
        }
    }

    // ANCHOR aktifitas peminjaman
    public function aktifitasPeminjaman()
    {
        $aktifitasPeminjaman = TransaksiPeminjamanAlat::with(['relasiUnit.unit', 'relasiUser'])->where('id_user', $this->user_id)
            ->whereIn('status', ['pending', 'dipinjam', 'terlambat_dikembalikan'])
            ->get()
            ->sortByDesc('created_at')->values()->toArray();

        return view('mahasiswa.aktifitas-peminjaman', [
            'name' => $this->name,
            'title' => $this->title,
            'role' => $this->role,
            'getTransactions' => $aktifitasPeminjaman
        ]);
    }


    // ANCHOR Scan View
    public function scanView()
    {
        return view('mahasiswa.scan-view', [
            'title' => $this->title,
            'role' => $this->role,
            'name' => $this->name,
        ]);
    }

    // ANCHOR Update scan status
    public function updateScanStatus($key)
    {
        $redisKey = "qr:$key";

        // Ambil data QR dari Redis
        $qrData = Redis::get($redisKey);

        if (!$qrData) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid.',
            ]);
        }

        $qrData = json_decode($qrData, true);

        // Perbarui status pemindaian menjadi 'true'
        $qrData['is_scanned'] = true;

        // Simpan kembali ke Redis dengan status yang sudah diperbarui
        Redis::setex($redisKey, 180, json_encode($qrData));

        return response()->json(['success' => true]);
    }


    // ANCHOR Transaksi User
    public function showUserTransactions(Request $request)
    {
        // Ambil key dari URL parameter
        $randomValue = $request->route('key');

        // Ambil data dari Redis menggunakan key
        $qrData = Redis::get("qr:$randomValue");

        // Debugging: Periksa data yang diterima dari Redis
        Log::info('QR Data dari Redis: ' . $qrData);


        $qrData = json_decode($qrData, true); // Decode JSON menjadi array

        if (!$qrData) {
            return redirect()->route('aktivitas.peminjaman')->with('error', 'QR Code tidak valid atau sudah kedaluwarsa. Mohon untuk hubungi laboran untuk melakukan scan QR Code lagi');
        }

        if (!$qrData['is_scanned']) {
            return redirect()->route('aktivitas.peminjaman')->with('error', 'QR Code belum dipindai.');
        }

        // Tentukan waktu kadaluarsa
        $expirationTime = \Carbon\Carbon::parse($qrData['qr_access_time']);

        // Cek kadaluarsa
        if (now()->greaterThan($expirationTime)) {
            return redirect()->route('aktivitas.peminjaman')->with('error', 'QR Code sudah kedaluwarsa.');
        }

        // Jika key valid, lanjutkan untuk mengambil data transaksi
        $mahasiswaId = $this->user_id; // ID mahasiswa yang sedang login

        $transactions = TransaksiPeminjamanAlat::where('id_user', $mahasiswaId)
            ->where('tanggal_pinjam', $this->today)
            ->where('status', 'pending')
            ->get();

        if ($transactions->isEmpty()) {
            return redirect()->route('aktivitas.peminjaman')->with('warning', 'Tidak ada transaksi yang diajukan pada hari ini');
        }

        return view('mahasiswa.validasi-transaksi', [
            'title' => $this->title,
            'role' => $this->role,
            'name' => $this->name,
            'mahasiswa' => $mahasiswaId,
            'transactions' => $transactions,
        ]);
    }

    // ANCHOR Submit pengajuan peminjaman alat
    public function submitTransaction(Request $request)
    {
        // Validasi input
        $request->validate([
            'transactions' => 'required|array',
            'transactions.*' => 'exists:transaksi_peminjaman_alat,id', // Validasi ID transaksi ada di database
        ]);

        // Ambil transaksi berdasarkan ID yang dikirimkan
        $transactionIds = $request->input('transactions');
        $transactions = TransaksiPeminjamanAlat::whereIn('id', $transactionIds)->get();

        // Proses setiap transaksi
        foreach ($transactions as $transaction) {
            // Pastikan status saat ini adalah "pending"
            if ($transaction->status === 'pending') {
                $updated = $transaction->submitTransaction('dipinjam');
            }
        }

        return redirect()->route('aktivitas.peminjaman')->with('success', 'Semua status transaksi berhasil diubah menjadi dipinjam.');
    }

    public function batalkanPeminjamanAlat($no_transaksi)
    {
        $transaksi = TransaksiPeminjamanAlat::where('no_transaksi', $no_transaksi)->first();

        try {
            if ($transaksi->status === "pending") {
                $update = $transaksi->batalkanTransaksi('dibatalkan');
                $riwayat = RiwayatTransaksiAlat::createRiwayatPembatalan($no_transaksi);
                return back()->with('success', 'Peminjaman dibatalkan.');
            }
        } catch (\Throwable $e) {
            Log::error('Error saat melakukan transaksi peminjaman alat: ' . $e->getMessage());
        }
    }
}
