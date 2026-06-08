<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Models\MentorProfile;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman utama profil student, ringkasan sesi,
     * serta daftar tabulasi bimbingan (Ongoing, Completed, Cancelled).
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil id_mentor milik user ini (jika dia terdaftar sebagai mentor)
        $mentorProfile = MentorProfile::where('id_user', $user->id_user)->first();
        $myMentorId = $mentorProfile ? $mentorProfile->id_mentor : null;

        // --- QUERY TOTAL ---
        $totalQuery = Booking::where('id_student', $user->id_user);
        if ($myMentorId) {
            $totalQuery->whereHas('schedule', function($q) use ($myMentorId) {
                $q->where('id_mentor', '!=', $myMentorId);
            });
        }
        $total = $totalQuery->count();

        // --- QUERY COMPLETED ---
        $completedQuery = Booking::where('id_student', $user->id_user)->where('status', 'completed');
        if ($myMentorId) {
            $completedQuery->whereHas('schedule', function($q) use ($myMentorId) {
                $q->where('id_mentor', '!=', $myMentorId);
            });
        }
        $completed = $completedQuery->count();

        // --- QUERY ONGOING ---
        $ongoingQuery = Booking::where('id_student', $user->id_user)->where('status', 'ongoing');
        if ($myMentorId) {
            $ongoingQuery->whereHas('schedule', function($q) use ($myMentorId) {
                $q->where('id_mentor', '!=', $myMentorId);
            });
        }
        $ongoing = $ongoingQuery->count();

        // --- QUERY LIST ONGOING BOOKINGS ---
        $ongoingBookingsQuery = Booking::with([
            'schedule.mentor.user',
            'schedule.mentor.kampus'
        ])
        ->where('id_student', $user->id_user)
        ->where('status', 'ongoing');
        
        if ($myMentorId) {
            $ongoingBookingsQuery->whereHas('schedule', function($q) use ($myMentorId) {
                $q->where('id_mentor', '!=', $myMentorId);
            });
        }
        $ongoingBookings = $ongoingBookingsQuery->orderByDesc('id_booking')->get();

        // --- QUERY LIST COMPLETED BOOKINGS ---
        $completedBookingsQuery = Booking::with([
            'schedule.mentor.user',
            'schedule.mentor.kampus',
            'review'
        ])
        ->where('id_student', $user->id_user)
        ->where('status', 'completed');
        
        if ($myMentorId) {
            $completedBookingsQuery->whereHas('schedule', function($q) use ($myMentorId) {
                $q->where('id_mentor', '!=', $myMentorId);
            });
        }
        $completedBookings = $completedBookingsQuery->orderByDesc('id_booking')->get();

        // --- QUERY LIST CANCELLED BOOKINGS ---
        $cancelledBookingsQuery = Booking::with([
            'schedule.mentor.user',
            'schedule.mentor.kampus'
        ])
        ->where('id_student', $user->id_user)
        ->where('status', 'cancelled');
        
        if ($myMentorId) {
            $cancelledBookingsQuery->whereHas('schedule', function($q) use ($myMentorId) {
                $q->where('id_mentor', '!=', $myMentorId);
            });
        }
        $cancelledBookings = $cancelledBookingsQuery->orderByDesc('id_booking')->get();

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

    /**
     * Memproses pembaruan nama pengguna dan unggahan foto profil baru.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'        => 'required|string|max:100',
            'foto_profil' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ], [
            'nama.required'     => 'Nama pengguna wajib diisi.',
            'nama.max'          => 'Nama pengguna maksimal 100 karakter.',
            'foto_profil.image' => 'Berkas yang diunggah harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar yang diperbolehkan hanya jpeg, jpg, dan png.',
            'foto_profil.max'   => 'Ukuran gambar maksimal adalah 2 MB.'
        ]);

        $user->nama = $request->nama;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profile', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil dan foto Anda berhasil diperbarui.');
    }

    /**
     * Hapus riwayat booking yang dicancel
     */
    public function destroyCancelled($id)
    {
        $user = Auth::user();

        $booking = Booking::where('id_student', $user->id_user)
            ->where('status', 'cancelled')
            ->findOrFail($id);

        $booking->delete();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Riwayat pembatalan jadwal berhasil dihapus dari profil.');
    }
}