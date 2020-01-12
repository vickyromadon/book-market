<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Models\Voucher');
    }
}
