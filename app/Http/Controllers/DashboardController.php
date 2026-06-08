<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang sedang login saat ini
        $user = Auth::user();

        // 2. Jika dia Admin (id_role = 1), tetap belokkan ke route dashboard admin
        if ($user->id_role == 1) {
            return redirect()->route('admin.dashboard');
        }

        // 3. BAGIAN MENTOR DIHAPUS/DIKOMENTARI AGAR TIDAK DIBELOKKAN
        // if ($user->id_role == 2) {
        //     return redirect()->route('mentor.dashboard');
        // }

        // 4. Sekarang, Student maupun Mentor (id_role = 2) akan sama-sama diizinkan melihat view dashboard utama ini
        return view('dashboard.index');
    }
}