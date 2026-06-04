<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MentorSchedule;
use App\Models\TransaksiReview;
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
        $rating = $request->rating;

        $query = MentorSchedule::with([
            'mentor.user',
            'mentor.kampus',
            'bookings.review'
        ])
        ->whereHas('mentor')
        ->where('status', 'available')
        ->where('harga', '>', 0);

        //AVG rating
        

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
            
        foreach ($mentors as $mentorSchedule) {

            if (!$mentorSchedule->mentor) {
                continue;
            }

            $mentor = $mentorSchedule->mentor;

            $reviews = \App\Models\TransaksiReview::whereHas(
                'booking.schedule',
                function ($q) use ($mentor) {
                    $q->where('id_mentor', $mentor->id_mentor);
                }
            );

            $mentor->avg_rating = round(
                $reviews->avg('rating') ?? 0,
                1
            );

            $mentor->total_review = $reviews->count();
        }

        if ($rating) {

            $filtered = $mentors->getCollection()->filter(
                function ($schedule) use ($rating) {

                    return ($schedule->mentor->avg_rating >= $rating);

                }
            );

            $mentors->setCollection($filtered);

        }

        $kampusList = Kampus::orderBy('nama_kampus')->get();

        return view('courses.index', compact(
            'mentors',
            'kampusList',
        ));
    }
}