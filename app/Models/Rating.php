<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rate'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
