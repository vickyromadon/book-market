<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number', 'status', 'shipping', 'subtotal', 'total', 'discount'
    ];

    public function invoice_carts()
    {
        return $this->hasMany('App\Models\InvoiceCart');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function depature_location()
    {
        return $this->belongsTo('App\Models\Location', 'depature_location_id', 'id');
    }

    public function destination_location()
    {
        return $this->belongsTo('App\Models\Location', 'destination_location_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Models\Voucher');
    }

    public function rating()
    {
        return $this->hasOne('App\Models\Rating');
    }
}
