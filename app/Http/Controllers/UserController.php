<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    protected $name;
    protected $role;
    protected $title;



    public function __construct()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->title = 'Mahasiswa';
        $this->role = $user->role;
    }

    public function storeMhs()
    {
        $dataMhs = User::where('role', 'mahasiswa')->get()->toArray();
        return view('laboran.data-mahasiswa', [
            'name' => $this->name,
            'role' => $this->role,
            'title' => $this->title,
            'dataMhs' => $dataMhs
        ]);
    }

    public function postMahasiswa(Request $request)
    {
        $validatedData  = $request->validate([
            'name' => 'required',
            'username' => 'required|string|unique:users,username|max:255',
            'prodi' => 'required'
        ]);

        try {
            Log::info('Validated Data: ', $validatedData);
            $mahasiswa = User::createMahasiswa($validatedData);
            Log::info('Mahasiswa created successfully', ['mahasiswa' => $mahasiswa]);
            return redirect()->route('data.mahasiswa')->with('success', 'Data Mahasiswa berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->route('data.mahasiswa')->with('error', 'Terjadi kesalahan saat melakukan penambahan mahasiswa: ' . $th->getMessage());
        }
    }
}
