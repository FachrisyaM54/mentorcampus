<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('profile.index', compact(
            'user',
            'total',
            'completed',
            'ongoing',
            'ongoingBookings'
        ));
    }
}