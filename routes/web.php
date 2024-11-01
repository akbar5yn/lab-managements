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

Route::get('/laboran/dashboard', [DashboardController::class, 'indexLaboran'])->middleware(CheckRole::class . ':laboran')->name('laboran');
Route::get('/mahasiswa/dashboard', [DashboardController::class, 'indexMahasiswa'])->middleware(CheckRole::class . ':mahasiswa')->name('mahasiswa');

Route::middleware([CheckRole::class  . ':laboran'])->group(function () {
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
    Route::get('/laboran/peminjaman-alat/pengajuan', [PeminjamanAlatController::class, 'pengajuanPeminjaman'])->name('peminjaman.alat.pengajuan');
    Route::get('/laboran/peminjaman-alat/berlangsung', [PeminjamanAlatController::class, 'peminjamanBerlangsung'])->name('peminjaman.alat.berlangsung');
    Route::get('/laboran/peminjaman-alat/berlangsung/{id}', [PeminjamanAlatController::class, 'detailPeminjamanBerlangsung'])->name('peminjaman.alat.berlangsung.detail');
});
