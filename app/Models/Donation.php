<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'title', 'quantity', 'status', 'message', 'image'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
