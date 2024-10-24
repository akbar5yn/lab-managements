<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Pastikan ini diimpor

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'laboran') {
                return redirect()->route('laboran');
            } elseif ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa');
            } else {
                return redirect()->route('unauthorized')->with('failed', 'Role tidak dikenali.');
            }
        }

        // Jika belum login, tampilkan halaman login
        return view('Login');
    }

    public function authenticate(Request $request)
    {
        // Validasi input berdasarkan tabel users
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('username', 'password');


        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'laboran') {
                return redirect()->route('laboran');
            } elseif ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Username atau password salah');
        }
    }
}
