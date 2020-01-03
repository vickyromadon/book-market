<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $fillable = [
        'nominal', 'transfer_date', 'proof', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
