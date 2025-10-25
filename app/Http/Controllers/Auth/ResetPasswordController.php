<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo = '/';

    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$tokenRecord) {
            return redirect()->route('login')->with('failed', 'Token reset password tidak valid.');
        }

        $createdAt = \Carbon\Carbon::parse($tokenRecord->created_at);
        if ($createdAt->diffInMinutes(now()) > 60) {
            return redirect()->route('login')->with('failed', 'Token reset password telah kadaluwarsa.');
        }

        if (!Hash::check($token, $tokenRecord->token)) {
            return redirect()->route('login')->with('failed', 'Token reset password tidak valid.');
        }

        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }
    public function resetPassword(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // 2. Cek token sekali lagi
        $tokenRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$tokenRecord || !Hash::check($request->token, $tokenRecord->token)) {
            throw ValidationException::withMessages([
                'email' => ['Token reset password tidak valid.'],
            ]);
        }

        // 3. Update Password
        $user = User::where('email', $request->email)->first();
        $user->password = $request->password; // Mutator di Model User akan melakukan Hashing
        $user->save();

        // 4. Hapus token dari database
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // 5. Redirect dan Bersihkan sesi
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login.');
    }
}
