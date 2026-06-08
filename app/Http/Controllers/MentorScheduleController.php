<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorSchedule; // Model jadwal mentor kamu
use App\Models\MentorProfile;  // Di-import untuk mencari id_mentor asli kamu
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Memanggil DB Facade untuk query table booking

class MentorScheduleController extends Controller
{
    /**
     * Mengambil id_mentor milik user yang sedang login saat ini
     */
    private function getMentorId()
    {
        // Mencari profile mentor berdasarkan id_user dari akun yang login
        $mentorProfile = MentorProfile::where('id_user', Auth::id())->first();

        if (!$mentorProfile) {
            // Jika akun yang login ternyata belum terdaftar atau disetujui sebagai mentor
            abort(403, 'Anda belum terdaftar atau disetujui sebagai Mentor.');
        }

        return $mentorProfile->id_mentor;
    }

    /**
     * Menampilkan jadwal aktif khusus milik mentor yang sedang login
     */
    public function index()
    {
        $id_mentor = $this->getMentorId();

        // 1. 💡 Ambil SEMUA id_schedule yang sudah masuk ke tabel booking (baik ongoing, completed, maupun cancelled)
        $bookedScheduleIds = DB::table('booking')
            ->pluck('id_schedule');

        // 2. 💡 Ambil jadwal yang berstatus 'available' DAN ID-nya TIDAK ADA di dalam list booking
        $schedules = MentorSchedule::where('id_mentor', $id_mentor)
                            ->where('status', 'available') // Memastikan status internal jadwal memang kosong
                            ->whereNotIn('id_schedule', $bookedScheduleIds) // Mengeliminasi total jadwal yang sudah pernah dibooking
                            ->orderBy('tanggal', 'asc')
                            ->orderBy('jam', 'asc')
                            ->get();

        // Mengarah ke file resources/views/mentor/schedule.blade.php
        return view('mentor.schedule', compact('schedules'));
    }

    /**
     * Menampilkan halaman form tambah jadwal baru
     */
    public function create()
    {
        // Mengarah ke file resources/views/mentor/create-schedule.blade.php
        return view('mentor.create-schedule');
    }

    /**
     * Memproses penyimpanan data jadwal baru ke database secara live (Mendukung Jam Selesai)
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date|after_or_equal:today',
            'jam'         => 'required',
            'jam_selesai' => 'required|after:jam', // Validasi agar jam selesai tidak mendahului jam mulai
            'harga'       => 'required|numeric|min:0',
        ]);

        $id_mentor = $this->getMentorId();

        // Menyimpan data jadwal baru terikat dengan id_mentor beserta durasi custom dari mentor
        MentorSchedule::create([
            'id_mentor'   => $id_mentor, 
            'tanggal'     => $request->tanggal,
            'jam'         => $request->jam,          // Bertindak sebagai jam mulai
            'jam_selesai' => $request->jam_selesai,  // Batas akhir sesi pilihan mentor
            'harga'       => $request->harga,
            'status'      => 'available'
        ]);

        return redirect()->route('mentor.schedule')->with('success', 'Jadwal baru berhasil ditambahkan!');
    }

    /**
     * Menghapus jadwal secara aman dari database
     */
    public function destroy($id)
    {
        $id_mentor = $this->getMentorId();

        // Memastikan jadwal yang akan dihapus adalah benar kepemilikan mentor tersebut
        $schedule = MentorSchedule::where('id_schedule', $id)
                            ->where('id_mentor', $id_mentor)
                            ->firstOrFail();
                            
        $schedule->delete();

        return redirect()->route('mentor.schedule')->with('success', 'Jadwal mentoring berhasil dihapus!');
    }
}