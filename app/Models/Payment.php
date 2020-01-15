<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'nominal', 'beginning_balance', 'ending_balance', 'status', 'discount'
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
