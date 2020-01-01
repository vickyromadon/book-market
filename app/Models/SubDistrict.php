<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    protected $fillable = [
        'name'
    ];

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }
}
