<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MentorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function show($id)
    {
        $schedule = MentorSchedule::with([
            'mentor.user',
            'mentor.kampus'
        ])->findOrFail($id);
//mentor tidak bisa booking diri sendiri
        $isOwnMentor = false;

        if ($schedule->mentor && $schedule->mentor->id_user == auth()->id()) {
            $isOwnMentor = true;
        }

        $isAlreadyBooked = Booking::where('id_schedule', $id)
            ->where('id_student', auth()->id())
            ->where('status', '!=', 'cancelled')
            ->exists();

        return view('booking.index', compact(
            'schedule',
            'isAlreadyBooked',
            'isOwnMentor'
        ));
    }

    public function store($id)
    {
        $schedule = MentorSchedule::findOrFail($id);
        
        //cek apakah sama dengan dirinya sendiri
        if (
            $schedule->mentor &&
            $schedule->mentor->id_user == Auth::id()
        ) {
            return back()->with(
                'error',
                'Kamu tidak bisa booking mentor milik sendiri'
            );
        }

        // cek sudah dibooking
        $alreadyBooked = Booking::where('id_schedule', $id)
            ->where('id_student', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'Kamu sudah booking jadwal ini');
        }

        // cek availability
        if ($schedule->status != 'available') {
            return back()->with('error', 'Jadwal tidak tersedia');
        }

        DB::transaction(function () use ($schedule) {

            Booking::create([
                'id_schedule' => $schedule->id_schedule,
                'id_student' => Auth::id(),
                'status' => 'ongoing',
            ]);

            $schedule->update([
                'status' => 'booked'
            ]);

        });

        return redirect()
            ->route('booking.show', $schedule->id_schedule)
            ->with('success', 'Booking berhasil');
    }

    public function finish($id)
{
    $booking = Booking::with([
        'schedule.mentor'
    ])->findOrFail($id);

    if (
        $booking->schedule->mentor->id_user
        != auth()->id()
    ) {
        abort(403, 'Unauthorized');
    }

    $booking->status = 'completed';

    $booking->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Session berhasil diselesaikan');
    }

    public function cancel($id)
{
    DB::transaction(function () use ($id) {

        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'cancelled'
        ]);

        if ($booking->schedule) {

            $booking->schedule->update([
                'status' => 'available'
            ]);
        }

    });

    return redirect()
        ->route('profile.index')
        ->with(
            'success',
            'Booking dibatalkan'
        );
}
}