<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TransaksiReview;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create($id)
    {
        $booking = Booking::findOrFail($id);

        $review = TransaksiReview::where(
            'id_booking',
            $id
        )->first();

        return view(
            'rating.create',
            compact('booking','review')
        );
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string'
        ]);

        TransaksiReview::updateOrCreate(
            [
                'id_booking' => $id
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar
            ]
        );

        return redirect()
            ->route('profile.index')
            ->with('success','Rating berhasil disimpan');
    }
}