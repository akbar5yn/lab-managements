<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class ProfileController extends Controller
{
    protected $user_id;
    protected $name;
    protected $title;
    protected $role;
    public function __construct()
    {

        $user = Auth::user();
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->title = 'Profile';
        $this->role = $user->role;
    }

    public function profileMahasiswa()
    {
        $dataUser = User::where('id', $this->user_id)->first();
        Log::info('data user' . $dataUser);
        return view('mahasiswa.profile', [
            'title' => $this->title,
            'role' => $this->role,
            'name' => $this->name,
            'dataUsers' => $dataUser
        ]);
    }

    public function updateProfileMhs(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable',
            'phone_number' => 'nullable|string'
        ]);

        Log::error('request update', $request->all());

        $localPart = $request->input('email');
        $emailWithDomain = $localPart . '@webmail.uad.ac.id';
        $phoneNumber = $request->input('phone_number');

        try {
            $user = User::findOrFail($id);

            $update = $user->updateProfile($emailWithDomain, $phoneNumber);

            Log::info('Profile updated successfully for user ID: ' . $id);
            return redirect()->route('profile.mhs')->with('success', 'Profile berhasil diperbaharui');
        } catch (\Exception $e) {
            Log::error('Error saat melakukan pembaharuan profile: ' . $e->getMessage());
            return redirect()->route('profile.mhs')->with('error', 'Profile gagal diperbaharui');
        }
    }


    public function updatePassword(Request $request, $nim)
    {
        $request->validate([
            'password' => 'required',
        ]);


        try {
            $newPassword = $request->input('password');
            $user = User::where('username', $nim)->firstOrFail();
            $user->updatePassword(['password' => $newPassword]);
            return redirect()->route('profile.mhs')->with('success', 'Password berhasil diperbaharui');
        } catch (\Exception $e) {
            Log::error('Error saat melakukan update password: ' . $e->getMessage());
        }
    }
}
