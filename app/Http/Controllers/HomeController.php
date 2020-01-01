<?php

namespace App\Http\Controllers;

use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view([
            "slider" => Slider::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
