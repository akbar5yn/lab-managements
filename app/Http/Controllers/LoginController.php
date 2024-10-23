<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Pastikan ini diimpor

class LoginController extends Controller
{
    public function index()
    {
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

        // Tambahkan log untuk melihat kredensial yang diterima
        Log::info('Login attempt', $credentials);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'laboran') {
                return redirect()->route('laboran');
            } elseif ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa');
            } else {
                return redirect()->route('unauthorized')->with('failed', 'Role tidak dikenali.');
            }
        } else {
            Log::warning('Login failed for username: ' . $credentials['username']); // Tambahkan log untuk kesalahan
            return redirect()->route('unauthorized')->with('failed', 'Username atau password salah');
        }
    }
}
