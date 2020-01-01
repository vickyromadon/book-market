<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'street', 'sub-district', 'district', 'province'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
