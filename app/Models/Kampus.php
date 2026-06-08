<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    public $timestamps = false;
    protected $table = 'kampus';

    protected $primaryKey = 'id_kampus';

    protected $fillable = [
        'nama_kampus'
    ];

    public function mentors()
    {
        return $this->hasMany(MentorProfile::class, 'id_kampus');
    }
}