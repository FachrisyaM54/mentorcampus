<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorSchedule extends Model
{
    protected $table = 'mentor_schedule';

    protected $primaryKey = 'id_schedule';

    public $timestamps = false;

    protected $fillable = [
        'id_mentor',
        'tanggal',
        'jam',
        'harga',
        'status'
    ];

    public function mentor()
    {
        return $this->belongsTo(
            MentorProfile::class,
            'id_mentor',
            'id_mentor'
        );
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_schedule', 'id_schedule');
    }
}