<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'name', 'discount', 'count', 'point_exchange'
    ];

    public function user_vouchers()
    {
        return $this->hasMany('App\Models\UserVoucher');
    }
}
