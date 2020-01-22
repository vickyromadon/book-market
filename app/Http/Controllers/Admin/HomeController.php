<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::count();
        $user = User::all();
        $totalMember = 0;
        $totalSeller = 0;

        foreach ($user as $item) {
            if ($item->roles[0]->name == 'store') {
                $totalSeller += 1;
            } elseif($item->roles[0]->name == 'member') {
                $totalMember += 1;
            }
        }

        return $this->view([
            'member' => $totalMember,
            'seller' => $totalSeller,
            'product' => $product
        ]);
    }
}
