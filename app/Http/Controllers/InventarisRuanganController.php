<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventarisRuanganController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $title = 'Kelola Ruangan';
        $name = $user->name;
        $role = $user->role;
        $dataRuangan = Ruangan::all();

        return view('laboran.inventaris-ruangan', compact('title', 'name', 'role', 'dataRuangan'));
    }
}
