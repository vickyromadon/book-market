<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use EntrustUserTrait;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'images', 'balance'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
    }

    public function store()
    {
        return $this->hasOne('App\Models\Store');
    }

    public function top_ups()
    {
        return $this->hasMany('App\Models\TopUp');
    }

    public function donations()
    {
        return $this->hasMany('App\Models\Donation');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function user_vouchers()
    {
        return $this->hasMany('App\Models\UserVoucher');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
