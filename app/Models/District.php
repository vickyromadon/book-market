<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name'
    ];

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function sub_districts()
    {
        return $this->hasMany('App\Models\SubDistrict');
    }
}
