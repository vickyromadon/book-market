<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'street', 'sub_district', 'district', 'province'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store');
    }

    public function depatures()
    {
        return $this->hasMany('App\Models\Invoice', 'depature_location_id', 'id');
    }

    public function destinations()
    {
        return $this->hasMany('App\Models\Invoice', 'destination_location_id', 'id');
    }
}
