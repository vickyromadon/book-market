<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'quantity', 'price', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
