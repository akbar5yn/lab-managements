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
            'role' => 'required|in:laboran,mahasiswa',
            'nim' => $request->role == 'mahasiswa' ? 'required|string' : 'nullable',
            'email' => $request->role == 'laboran' ? 'required|email' : 'nullable',
            'password' => 'required',
        ]);

        // Tentukan kredensial berdasarkan role
        $credentials = $request->role == 'laboran'
            ? ['email' => $request->email, 'password' => $request->password]
            : ['nim' => $request->nim, 'password' => $request->password];


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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
