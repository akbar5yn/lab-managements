<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanAlatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $title = 'Peminjaman Alat & Barang';
        $name = $user->name;
        $role = $user->role;

        return view('laboran.peminjaman-alat', compact('title', 'name', 'role',));
    }
}
