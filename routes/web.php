<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('authenticate');

Route::get('/laboran/dashboard', [DashboardController::class, 'indexLaboran'])->middleware(CheckRole::class . ':laboran')->name('laboran');

Route::get('/mahasiswa/dashboard', [DashboardController::class, 'indexMahasiswa'])->middleware(CheckRole::class . ':mahasiswa')->name('mahasiswa');
