<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'gender',
        'semester',
        'id_role'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    // RELASI ROLE
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    public function mentorProfile()
    {
        return $this->hasOne(MentorProfile::class, 'id_user', 'id_user');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_student', 'id_user');
    }
}