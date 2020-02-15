<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'title', 'quantity', 'status', 'message', 'image',
        'location', 'date', 'reason', 'image_1', 'image_2', 'image_3',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function album_donations()
    {
        return $this->hasMany('App\Models\AlbumDonation');
    }
}
