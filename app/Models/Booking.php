<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $primaryKey = 'id_booking';

    public $timestamps = false;

    protected $fillable = [
        'id_schedule',
        'id_student',
        'status'
    ];

    public function schedule()
    {
        return $this->belongsTo(
            MentorSchedule::class,
            'id_schedule',
            'id_schedule'
        );
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'id_student', 'id_user');
    }
    public function review()
{
    return $this->hasOne(
        TransaksiReview::class,
        'id_booking',
        'id_booking'
    );
}
}