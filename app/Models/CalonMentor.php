<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonMentor extends Model
{
    protected $table = 'calon_mentor';

    protected $primaryKey = 'id_calon';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_kampus',
        'fakultas',
        'jurusan',
        'spesialisasi',
        'biografi',
        'usia',
        'status',
        'file_transkrip'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function kampus()
    {
        return $this->belongsTo(
            Kampus::class,
            'id_kampus',
            'id_kampus'
        );
    }
}