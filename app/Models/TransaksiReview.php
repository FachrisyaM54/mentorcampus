<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiReview extends Model
{
    protected $table = 'transaksi_review';

    protected $primaryKey = 'id_review';
    
    public $timestamps = false;

    protected $fillable = [
        'id_booking',
        'rating',
        'komentar'
    ];

    public function booking()
    {
        return $this->belongsTo(
            Booking::class,
            'id_booking',
            'id_booking'
        );
    }
    
}