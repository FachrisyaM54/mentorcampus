<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $total = Booking::where('id_student',$user->id_user)->count();

        $completed = Booking::where('id_student',$user->id_user)
            ->where('status','completed')
            ->count();

        $ongoing = Booking::where('id_student',$user->id_user)
            ->where('status','ongoing')
            ->count();

        $ongoingBookings = Booking::with([
            'schedule.mentor.user',
            'schedule.mentor.kampus'
        ])
        ->where('id_student', $user->id_user)
        ->where('status', 'ongoing')
        ->orderByDesc('id_booking')
        ->get();
        $completedBookings = Booking::with([
            'schedule.mentor.user',
            'schedule.mentor.kampus',
            'review'
        ])
        ->where('id_student', $user->id_user)
        ->where('status', 'completed')
        ->orderByDesc('id_booking')
        ->get();

        $cancelledBookings = Booking::with([
            'schedule.mentor.user',
            'schedule.mentor.kampus'
        ])
        ->where('id_student', $user->id_user)
        ->where('status', 'cancelled')
        ->orderByDesc('id_booking')
        ->get();

        return view('profile.index', compact(
            'user',
            'total',
            'completed',
            'ongoing',
            'ongoingBookings',
            'completedBookings',
            'cancelledBookings'
        ));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|max:100',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user->nama = $request->nama;

        if ($request->hasFile('foto_profil')) {

            $path = $request->file('foto_profil')
                ->store('profile', 'public');

            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}