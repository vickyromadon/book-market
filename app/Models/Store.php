<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name', 'description', 'open_time', 'close_time', 'image', 'user_id', 'location_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }
}
