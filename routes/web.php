<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisAlatController;
use App\Http\Controllers\InventarisRuanganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanAlatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatTransaksiAlatController;
use App\Http\Controllers\UnitController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ANCHOR Laboran
Route::middleware([CheckRole::class  . ':laboran'])->group(function () {

    Route::get('/laboran/dashboard', [DashboardController::class, 'indexLaboran'])->name('laboran');

    //SECTION - Route Inventory Alat
    Route::get('/laboran/inventaris-alat', [InventarisAlatController::class, 'index'])->name('inventaris-alat');
    Route::post('/laboran/inventaris-alat', [InventarisAlatController::class, 'handleRequest'])->name('post.alat');
    Route::put('/laboran/inventaris-alat/{id}', [InventarisAlatController::class, 'handleUpdate'])->name('edit.alat');
    Route::delete('/laboran/inventaris-alat/{id}', [InventarisAlatController::class, 'handleDelete'])->name('delete.alat');

    // SECTION - Route Unit
    Route::get('/laboran/inventaris-alat/{slug}', [UnitController::class, 'getUnitAlat'])->name('alat.unit');
    Route::post('/laboran/inventaris-alat/{slug}', [UnitController::class, 'handlePost'])->name('tambah.unit');
    Route::put('/laboran/inventaris-alat/{slug}/{id}', [UnitController::class, 'handleUpdate'])->name('edit.unit');
    Route::delete('/laboran/inventaris-alat/{slug}/{id}', [UnitController::class, 'handleDelete'])->name('delete.unit');

    // SECTION - Route Inventaris Ruangan
    Route::get('/laboran/inventaris-ruangan', [InventarisRuanganController::class, 'index'])->name('inventaris-ruangan');
    Route::post('/laboran/inventaris-ruangan', [InventarisRuanganController::class, 'handlePost'])->name('post.ruangan');
    Route::put('/laboran/inventaris-ruangan/{id}', [InventarisRuanganController::class, 'handleEdit'])->name('edit.ruangan');
    Route::delete('/laboran/inventaris-ruangan/{id}', [InventarisRuanganController::class, 'handleDelete'])->name('delete.ruangan');

    // SECTION - Route Peminjaman Alat
    Route::get('/laboran/peminjaman-alat/pengajuan', [PeminjamanAlatController::class, 'pengajuanPeminjaman'])->name('pengajuan.peminjaman.alat');
    Route::get('/laboran/peminjaman-alat/pengajuan/{slug}', [PeminjamanAlatController::class, 'detailPengajuanAlat'])->name('detail.pengajuan.alat');
    Route::get('/laboran/peminjaman-alat/berlangsung', [PeminjamanAlatController::class, 'peminjamanBerlangsung'])->name('peminjaman.alat.berlangsung');
    Route::get('/laboran/peminjaman-alat/berlangsung/{slug}', [PeminjamanAlatController::class, 'detailPeminjamanBerlangsung'])->name('peminjaman.alat.berlangsung.detail');

    // SECTION - Route Qr Code
    Route::get('/laboran/qrcode', [PeminjamanAlatController::class, 'showQrCodePage'])->name('qrcode.page');

    // SECTION - Route Riwayat transaksi
    Route::post('/laboran/riwayat-transaksi-alat', [RiwayatTransaksiAlatController::class, 'createRiwayatTransaksiAlat'])->name('post.riwayat.transaksi.alat');
    Route::get('/laboran/riwayat-peminjaman-alat', [RiwayatTransaksiAlatController::class, 'riwayatPeminjamanAlat'])->name('riwayat.peminjaman.alat');
    Route::get('/laboran/detail-riwayat-peminjaman-alat/{slug}', [RiwayatTransaksiAlatController::class, 'detailRiwayatTransaksi'])->name('detail.riwayat');
});

// ANCHOR Mahasiswa
Route::middleware([CheckRole::class . ':mahasiswa'])->group(function () {
    // SECTION ROUTE Profile
    Route::get('/mahasiswa/profile', [ProfileController::class, 'profileMahasiswa'])->name('profile.mhs');
    Route::put('/mahasiswa/update/profile/{id}', [ProfileController::class, 'updateProfileMhs'])->name('update.profile.mhs');

    // SECTION Route Dashboard
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'indexMahasiswa'])->name('mahasiswa');

    // SECTION Route Halaman informasi alat
    Route::get('/mahasiswa/informasi-alat', [PeminjamanAlatController::class, 'informasiAlat'])->name('informasi.alat');
    Route::get('/mahasiswa/informasi-alat/pinjam-alat/{slug}', [PeminjamanAlatController::class, 'detailAlat'])->name('detail.alat');


    // SECTION Route Peminjaman alat
    Route::post('/mahasiswa/peminjaman-alat/{slug}/{id}', [PeminjamanAlatController::class, 'pinjamAlat'])->name('pinjam.alat');


    // SECTION Route Aktifitas Peminjaman
    Route::get('/mahasiswa/peminjaman-alat/aktifitas', [PeminjamanAlatController::class, 'aktifitasPeminjaman'])->name('aktivitas.peminjaman');
    Route::get('/mahasiswa/peminjaman-alat/aktifitas/{slug}', [PeminjamanAlatController::class, 'detailAktifitasPeminjaman'])->name('detail.aktivitas.peminjaman');
    Route::get('/mahasiswa/scan-view', [PeminjamanAlatController::class, 'scanView'])->name('scan.aktivitas.peminjaman');
    Route::get('/mahasiswa/transaksi/peminjaman-alat/{key}', [PeminjamanAlatController::class, 'showUserTransactions'])->name('detail.transaksi');
    Route::post('/mahasiswa/submit-pengajuan-alat', [PeminjamanAlatController::class, 'submitTransaction'])->name('submit-pengajuan-transaksi');
    Route::get('/mahasiswa/update-scan-status/{key}', [PeminjamanAlatController::class, 'updateScanStatus'])->name('update.scan.status');

    // SECTION Route Aktifitas Peminjaman Ruangan
    Route::get('/mahasiswa/peminjaman-ruangan', [DashboardController::class, 'indexMahasiswa'])->name('peminjaman.ruangan');
});
