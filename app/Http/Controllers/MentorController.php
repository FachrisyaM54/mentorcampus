<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    
    // MENAMPILKAN DASHBOARD MENTOR
    public function dashboard()
    {
        // Ambil data user beserta relasi pendaftaran (calonMentor)
        $user = User::with('calonMentor')->findOrFail(Auth::user()->id_user);

        $mentor = MentorProfile::where(
            'id_user',
            $user->id_user
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
                'recentBookings',
                'mentor',
                'user'
            )
        );
    }

    /**
     * 💡 PERBAIKAN FUNGSI SHOW:
     * Kita panggil data biografi dari relasi user->calonMentor jika di mentor_profiles masih kosong,
     * agar data teks pendaftaran awal Anda tetap tampil di halaman depan.
     */
    public function show($id)
    {
        $mentor = MentorProfile::with([
            'user.calonMentor', 
            'kampus'
        ])->findOrFail($id);

        // Pasang fallback otomatis jika kolom biografi di mentor_profiles kosong, ambil dari calon_mentors
        if (empty($mentor->biografi) && isset($mentor->user->calonMentor->biografi)) {
            $mentor->biografi = $mentor->user->calonMentor->biografi;
        }

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

    /**
     * 💡 PERBAIKAN UTAMA FUNGSI UPDATEPROFILE:
     * Menarik data model User dan CalonMentor langsung secara eksplisit dari database 
     * untuk menjamin perintah ->save() berfungsi 100% memperbarui data kolom ke database.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'biografi'   => 'required|string|min:5',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072'
        ]);

        // Ambil instance Model Database secara bersih menggunakan ID user yang sedang login
        $dbUser = User::findOrFail(Auth::user()->id_user);
        
        $mentorProfile = MentorProfile::where('id_user', $dbUser->id_user)->first();
        $calonMentor = CalonMentor::where('id_user', $dbUser->id_user)->first();

        // 1. Simpan Jalur Update ke tabel mentor_profiles
        if ($mentorProfile) {
            $mentorProfile->biografi = $request->biografi;
            $mentorProfile->save();
        }

        // 2. Simpan Jalur Sinkronisasi ke tabel calon_mentors (tempat penyimpanan awal pendaftaran Anda)
        if ($calonMentor) {
            $calonMentor->biografi = $request->biografi;
            $calonMentor->save();
        }

        // 3. Simpan File Sertifikat Baru langsung ke objek model $dbUser (Tabel Users)
        if ($request->hasFile('sertifikat')) {
            
            // Hapus file lama jika sebelumnya sudah ada data di database
            if (!empty($dbUser->file_sertifikat)) {
                Storage::disk('public')->delete($dbUser->file_sertifikat);
            }

            // Simpan file baru ke folder public/storage/sertifikat
            $path = $request->file('sertifikat')->store('sertifikat', 'public');
            
            // Perbarui nilai kolom file_sertifikat di tabel users
            $dbUser->file_sertifikat = $path;
        }

        // Simpan perubahan data User ke database
        $dbUser->save();

        return redirect()->route('mentor.dashboard')->with('success', 'Biografi dan sertifikat kompetensi Anda berhasil diperbarui.');
    }
}