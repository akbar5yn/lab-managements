<?php

//!NOTE Doing code on branch features login

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // Memastikan semua metode di controller ini dilindungi
    }

    public function indexLaboran()
    {
        $user = Auth::user();
        $title = 'Dasboard';
        $name = $user->name;
        $role = $user->role;
        $schedules = [
            [
                'nim' => '2000016001',
                'name' => 'Teguh Dwi Cahya Kusuma',
                'log' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsam voluptatem itaque sint maiores voluptas delectus corporis vero quae mollitia!',
                'waktu' => '07:00 - 09:00'
            ],
            [
                'nim' => '2000016003',
                'name' => 'Ansyafarino Arma Wahyudi',
                'log' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsam voluptatem itaque sint maiores voluptas delectus corporis vero quae mollitia!',
                'waktu' => '12:30 - 14:00'
            ],
            [
                'nim' => '2000016004',
                'name' => 'Daffa',
                'log' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsam voluptatem itaque sint maiores voluptas delectus corporis vero quae mollitia!',
                'waktu' => '14:10 - 15:30'
            ],
            [
                'nim' => '2000016005',
                'name' => 'Rifky Ramadhan',
                'log' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsam voluptatem itaque sint maiores voluptas delectus corporis vero quae mollitia!',
                'waktu' => '16:00 - 17:00'
            ],
            [
                'nim' => '2000016006',
                'name' => 'Rifky Ramadhan',
                'log' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsam voluptatem itaque sint maiores voluptas delectus corporis vero quae mollitia!',
                'waktu' => '17:20 - 18:10'
            ],
            [
                'nim' => '2000016002',
                'name' => 'Alfarizi Dwi Putra',
                'log' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsam voluptatem itaque sint maiores voluptas delectus corporis vero quae mollitia!',
                'waktu' => '09:20 - 10:00'
            ],
        ];
        // Konten dashboard
        return view('laboran.dashboard', compact('title', 'name', 'role', 'schedules'));
    }
    public function indexMahasiswa()
    {
        return view('mahasiswa.dashboard');
    }
}
