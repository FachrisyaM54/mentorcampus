<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorSchedule;
use App\Models\Kampus;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $subject = $request->subject;
        $kampus = $request->kampus;
        $semester = $request->semester;
        $gender = $request->gender;

        $query = MentorSchedule::with([
            'mentor.user',
            'mentor.kampus'
        ])
        ->where('status', 'available')
        ->where('harga', '>', 0);

        // SEARCH
        if ($search) {
            $query->whereHas('mentor.user', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%");
            });
        }

        // SUBJECT
        if ($subject) {
            $query->whereHas('mentor', function ($q) use ($subject) {
                $q->where('spesialisasi', 'like', "%$subject%");
            });
        }

        // KAMPUS
        if ($kampus) {
            $query->whereHas('mentor.kampus', function ($q) use ($kampus) {
                $q->where('nama_kampus', $kampus);
            });
        }

        // GENDER
        if ($gender) {
            $query->whereHas('mentor.user', function ($q) use ($gender) {
                $q->where('gender', $gender);
            });
        }

        // SEMESTER
        if ($semester) {

            [$min, $max] = explode('-', $semester);

            $query->whereHas('mentor.user', function ($q) use ($min, $max) {
                $q->whereBetween('semester', [$min, $max]);
            });
        }

        $mentors = $query
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->paginate(10);

        $kampusList = Kampus::orderBy('nama_kampus')->get();

        return view('courses.index', compact(
            'mentors',
            'kampusList'
        ));
    }
}