<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorProfile extends Model
{
    protected $table = 'mentor_profiles';

    protected $primaryKey = 'id_mentor';

    protected $fillable = [
        'id_user',
        'id_kampus',
        'jurusan',
        'spesialisasi'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION USER
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }
    

    /*
    |--------------------------------------------------------------------------
    | RELATION KAMPUS
    |--------------------------------------------------------------------------
    */
    public function kampus()
    {
        return $this->belongsTo(
            Kampus::class,
            'id_kampus',
            'id_kampus'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION SCHEDULE
    |--------------------------------------------------------------------------
    */
    public function schedules()
    {
        return $this->hasMany(MentorSchedule::class, 'id_mentor');
    }

    public function mentor()
    {
        return $this->belongsTo(MentorProfile::class, 'id_mentor', 'id_mentor');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_schedule', 'id_schedule');
    }
}