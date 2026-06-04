<?php

namespace App\Http\Controllers;

use App\Models\Kampus;
use App\Models\CalonMentor;
use App\Models\Booking;
use App\Models\MentorProfile;
use App\Models\MentorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MentorController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $kampus = Kampus::orderBy('nama_kampus')->get();

        $pendaftaran = CalonMentor::where(
            'id_user',
            $user->id_user
        )->first();

        return view(
            'mentor.register',
            compact(
                'user',
                'kampus',
                'pendaftaran'
            )
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'transkrip' => 'required|mimes:pdf|max:5120'
        ]);

        $user = Auth::user();

        // Cegah daftar 2x
        $cek = CalonMentor::where(
            'id_user',
            $user->id_user
        )->first();

        if ($cek) {
            return redirect()
                ->route('mentor.register')
                ->with('error', 'Anda sudah pernah mendaftar mentor.');
        }
        //Validasi foto
        $filePath = null;
        if ($request->hasFile('transkrip')) {

            $filePath = $request
                ->file('transkrip')
                ->store('transkrip', 'public');
        }

        CalonMentor::create([
            'id_user'      => $user->id_user,
            'id_kampus'    => $request->kampus,
            'fakultas'     => $request->fakultas,
            'jurusan'      => $request->jurusan,
            'spesialisasi' => $request->spesialisasi,
            'biografi'     => $request->biografi,
            'usia'         => $request->usia,
            'status'       => 'pending',
            'file_transkrip' => $filePath
        ]);

        return redirect()
            ->route('mentor.register')
            ->with('success', 'Pendaftaran mentor berhasil dikirim.');
    }

    public function status()
    {
        $user = Auth::user();

        $pendaftaran = CalonMentor::where(
            'id_user',
            $user->id_user
        )->first();

        return view(
            'mentor.status',
            compact(
                'user',
                'pendaftaran'
            )
        );
    }

    public function bookings()
    {
        $user = Auth::user();

        $mentor = MentorProfile::where(
            'id_user',
            $user->id_user
        )->first();

        $bookings = Booking::with([
            'student',
            'schedule'
        ])
        ->whereHas('schedule', function ($q) use ($mentor) {

            $q->where(
                'id_mentor',
                $mentor->id_mentor
            );

        })
        ->latest('id_booking')
        ->get();

        return view(
            'mentor.bookings',
            compact(
                'mentor',
                'bookings'
            )
        );
    }
    //history booking mentor
    public function history()
    {
        $mentor = MentorProfile::where(
            'id_user',
            auth()->user()->id_user
        )->first();

        $histories = Booking::with([
            'student',
            'schedule'
        ])
        ->whereHas('schedule', function ($q) use ($mentor) {
            $q->where(
                'id_mentor',
                $mentor->id_mentor
            );
        })
        ->whereIn('status', [
            'completed',
            'cancelled'
        ])
        ->latest('id_booking')
        ->get();

        return view(
            'mentor.history',
            compact('histories')
        );
    }
    //untuk dashboard mentor
    public function dashboard()
    {
            $mentor = MentorProfile::where(
                'id_user',
                auth()->user()->id_user
            )->first();

            $totalBooking = Booking::whereHas(
                'schedule',
                function ($q) use ($mentor) {

                    $q->where(
                        'id_mentor',
                        $mentor->id_mentor
                    );

                }
            )->count();

            $completedBooking = Booking::whereHas(
                'schedule',
                function ($q) use ($mentor) {

                    $q->where(
                        'id_mentor',
                        $mentor->id_mentor
                    );

                }
            )
            ->where('status','completed')
            ->count();

            $ongoingBooking = Booking::whereHas(
                'schedule',
                function ($q) use ($mentor) {

                    $q->where(
                        'id_mentor',
                        $mentor->id_mentor
                    );

                }
            )
            ->where('status','ongoing')
            ->count();

            $totalSchedule = MentorSchedule::where(
                'id_mentor',
                $mentor->id_mentor
            )->count();

            $recentBookings = Booking::with([
                'student',
                'schedule'
            ])
            ->whereHas(
                'schedule',
                function ($q) use ($mentor) {

                    $q->where(
                        'id_mentor',
                        $mentor->id_mentor
                    );

                }
            )
            ->latest('id_booking')
            ->take(5)
            ->get();

            return view(
                'mentor.dashboard',
                compact(
                    'totalBooking',
                    'completedBooking',
                    'ongoingBooking',
                    'totalSchedule',
                    'recentBookings'
                )
            );
        }
        //detail mentor
        public function show($id)
    {
        $mentor = MentorProfile::with([
            'user',
            'kampus'
        ])->findOrFail($id);

        $schedules = MentorSchedule::where(
            'id_mentor',
            $mentor->id_mentor
        )
        ->where('status', 'available')
        ->orderBy('tanggal')
        ->orderBy('jam')
        ->get();

        $reviews = \App\Models\TransaksiReview::whereHas(
    'booking.schedule',
    function ($q) use ($mentor) {
        $q->where('id_mentor', $mentor->id_mentor);
    }
)->latest('id_review')->get();

$avgRating = round(
    $reviews->avg('rating') ?? 0,
    1
);

$totalReview = $reviews->count();
        return view(
            'mentor.show',
            compact(
                'mentor',
                'schedules',
                'reviews',
                'avgRating',
                'totalReview'
            )
        );
    }
}