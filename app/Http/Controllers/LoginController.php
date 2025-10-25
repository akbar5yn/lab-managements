<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        return view('Login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials =  $request->only('username', 'password');


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

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'
        ]);

        $user = User::where('email', $request->email)->first();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        Mail::send('emails.reset-password', ['url' => $resetUrl, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)->subject('Reset Kata Sandi Anda');
        });

        return back()->with('status', 'Tautan reset telah dikirim ke email Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
