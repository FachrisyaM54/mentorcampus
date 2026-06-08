<?php

namespace App\Http\Controllers;

use App\Models\CalonMentor;
use App\Models\User;
use App\Models\MentorProfile;
use App\Models\Booking;
use App\Models\Kampus; // <- KODE BARU: Import Model Kampus
use Illuminate\Http\Request; // <- KODE BARU: Import Request untuk Form CRUD
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function mentorRequests()
    {
        $requests = CalonMentor::with('user')
            ->latest('id_calon')
            ->get();

        return view(
            'admin.mentor-requests',
            compact('requests')
        );
    }

    //METHOD MENOLAK CALON MENTOR
    public function rejectMentor($id)
    {
        $mentor = CalonMentor::findOrFail($id);

        $mentor->status = 'rejected';

        $mentor->save();

        return back()->with(
            'success',
            'Mentor berhasil direject'
        );
    }
    //METHOD APPROVE MENTOR
    public function approveMentor($id)
    {
        DB::transaction(function () use ($id) {

            $calon = CalonMentor::findOrFail($id);

            $calon->status = 'accepted';

            $calon->save();

            MentorProfile::create([
                'id_user'        => $calon->id_user,
                'id_kampus'      => $calon->id_kampus,
                'fakultas'       => $calon->fakultas,
                'jurusan'        => $calon->jurusan,
                'spesialisasi'   => $calon->spesialisasi,
                'biografi'       => $calon->biografi,
                'usia'           => $calon->usia,
                'file_transkrip' => $calon->file_transkrip,
            ]);

            User::where(
                'id_user',
                $calon->id_user
            )->update([
                'id_role' => 2,
                'role'    => 'mentor'
            ]);

    });

        return back()->with(
            'success',
            'Mentor berhasil diapprove'
        );
    }
    
    //dashboard admin
    public function dashboard()
    {
        $totalUser = User::count();

        $totalMentor = MentorProfile::count();

        $totalBooking = Booking::count();

        $pendingMentor = CalonMentor::where(
            'status',
            'pending'
        )->count();

        $latestBookings = Booking::with([
            'student',
            'schedule'
        ])
        ->latest('id_booking')
        ->take(10)
        ->get();

        //Grafik Distribusi User

        $studentCount = User::where(
            'role',
            'student'
        )->count();

        $mentorCount = User::where(
            'role',
            'mentor'
        )->count();

        $adminCount = User::where(
            'role',
            'admin'
        )->count();

        // Grafik Status Booking

        $completedBooking = Booking::where(
            'status',
            'completed'
        )->count();

        $ongoingBooking = Booking::where(
            'status',
            'ongoing'
        )->count();

        $cancelledBooking = Booking::where(
            'status',
            'cancelled'
        )->count();

        // Grafik Booking Per Bulan

        $bookingPerMonth = Booking::selectRaw(
            'MONTH(created_at) as month,
             COUNT(*) as total'
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalUser',
                'totalMentor',
                'totalBooking',
                'pendingMentor',
                'latestBookings',

                'studentCount',
                'mentorCount',
                'adminCount',

                'completedBooking',
                'ongoingBooking',
                'cancelledBooking',

                'bookingPerMonth'
            )
        );
    }

    //Untuk melihat semua user oleh admin
    public function users()
    {
        $users = User::with('roleData')
            ->latest('id_user')
            ->get();

        return view(
            'admin.users',
            compact('users')
        );
    }
    //untuk melihat semua mentor
    public function mentors()
    {
        $mentors = MentorProfile::with([
            'user',
            'kampus'
        ])
        ->latest('id_mentor')
        ->get();

        return view(
            'admin.mentors',
            compact('mentors')
        );
    }
    //untuk melihat detail mentor
    public function mentorDetail($id)
    {
        $mentor = MentorProfile::with([
            'user',
            'kampus',
            'schedules'
        ])->findOrFail($id);

        return view(
            'admin.mentor-detail',
            compact('mentor')
        );
    }
    //untuk menghapus mentor
    public function deleteMentor($id)
    {
        DB::transaction(function () use ($id) {

            $mentor = MentorProfile::findOrFail($id);

            User::where(
                'id_user',
                $mentor->id_user
            )->update([
                'id_role' => 3,
                'role'    => 'student'
            ]);

            CalonMentor::where(
                'id_user',
                $mentor->id_user
            )->delete();

            $mentor->delete();

    });

        return back()->with(
            'success',
            'Mentor berhasil dihapus'
        );
    }
    //EXPORT PDF
    public function exportPdf()
    {
        $totalUser = User::count();

        $totalMentor = MentorProfile::count();

        $totalBooking = Booking::count();

        $pendingMentor = CalonMentor::where(
            'status',
            'pending'
        )->count();

        $studentCount = User::where(
            'role',
            'student'
        )->count();

        $mentorCount = User::where(
            'role',
            'mentor'
        )->count();

        $adminCount = User::where(
            'role',
            'admin'
        )->count();

        $completedBooking = Booking::where(
            'status',
            'completed'
        )->count();

        $ongoingBooking = Booking::where(
            'status',
            'ongoing'
        )->count();

        $cancelledBooking = Booking::where(
            'status',
            'cancelled'
        )->count();

        $bookingPerMonth = Booking::selectRaw(
            'MONTH(created_at) as month,
             COUNT(*) as total'
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $pdf = Pdf::loadView(
            'admin.report-pdf',
            compact(
                'totalUser',
                'totalMentor',
                'totalBooking',
                'pendingMentor',

                'studentCount',
                'mentorCount',
                'adminCount',

                'completedBooking',
                'ongoingBooking',
                'cancelledBooking',

                'bookingPerMonth'
            )
        );

        return $pdf->download(
            'mentorcampus-report.pdf'
        );
    }

    // ==========================================================
    // ==== KODE BARU TAMBAHAN: LOGIKA CRUD KAMPUS MITRA ====
    // ==========================================================
    
    public function storeKampus(Request $request)
    {
        $request->validate([
            'nama_kampus' => 'required|string|max:255',
        ]);

        Kampus::create([
            'nama_kampus' => $request->nama_kampus,
            'id_wilayah' => null
        ]);

        return redirect()->back()->with('success', 'Kampus berhasil ditambahkan ke dalam ekosistem!');
    }

    public function deleteKampus($id)
    {
        $kampus = Kampus::findOrFail($id);
        $kampus->delete();

        return redirect()->back()->with('success', 'Kampus sukses dihapus dari daftar mitra!');
    }
}