<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MentorProfile;
use App\Models\MentorSchedule;
use Illuminate\Http\Request;

class MentorScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $mentor = MentorProfile::where(
            'id_user',
            $user->id_user
        )->first();

        $schedules = collect();

        if ($mentor) {

            $schedules = MentorSchedule::where(
                'id_mentor',
                $mentor->id_mentor
            )
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();

        }

        return view(
            'mentor.schedule',
            compact(
                'mentor',
                'schedules'
            )
        );
    }

    public function create()
    {
        return view('mentor.create-schedule');
    }
    //SIMPAN SCHEDULE
    public function store(Request $request)
    {
        $user = Auth::user();

        $mentor = MentorProfile::where(
            'id_user',
            $user->id_user
        )->first();

        MentorSchedule::create([
            'id_mentor' => $mentor->id_mentor,
            'tanggal'   => $request->tanggal,
            'jam'       => $request->jam,
            'harga'     => $request->harga,
            'status'    => 'available'
        ]);

        return redirect()
            ->route('mentor.schedule')
            ->with(
                'success',
                'Jadwal berhasil ditambahkan'
            );
    }
}