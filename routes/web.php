<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisAlatController;
use App\Http\Controllers\InventarisRuanganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PeminjamanAlatController;
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
    Route::get('/laboran/peminjaman-alat/pengajuan/{id}', [PeminjamanAlatController::class, 'detailPengajuanRuangan'])->name('detail.pengajuan.ruangan');
    Route::get('/laboran/peminjaman-alat/berlangsung', [PeminjamanAlatController::class, 'peminjamanBerlangsung'])->name('peminjaman.alat.berlangsung');
    Route::get('/laboran/peminjaman-alat/berlangsung/{id}', [PeminjamanAlatController::class, 'detailPeminjamanBerlangsung'])->name('peminjaman.alat.berlangsung.detail');
});

// ANCHOR Mahasiswa
Route::middleware([CheckRole::class . ':mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'indexMahasiswa'])->name('mahasiswa');
    Route::get('/mahasiswa/peminjaman-alat', [DashboardController::class, 'indexMahasiswa'])->name('peminjaman.alat');
    Route::get('/mahasiswa/peminjaman-ruangan', [DashboardController::class, 'indexMahasiswa'])->name('peminjaman.ruangan');
});
