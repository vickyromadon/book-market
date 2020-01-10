<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view([
            "slider"    => Slider::orderBy('created_at', 'desc')->get(),
            "product"   => Product::where('status', '=', 'publish')->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
