<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'quantity', 'price',
        'image', 'sold', 'view', 'status', 'publisher'
    ];

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\Level');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }
}
