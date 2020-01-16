<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'nominal', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
}
