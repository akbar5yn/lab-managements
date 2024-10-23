<?php

//!NOTE Doing code on branch features login

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // Memastikan semua metode di controller ini dilindungi
    }

    public function indexLaboran()
    {
        // Konten dashboard
        return view('laboran.dashboard');
    }
    public function indexMahasiswa()
    {
        return view('mahasiswa.dashboard');
    }
}
