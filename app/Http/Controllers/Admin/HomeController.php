<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Donation;
use App\Models\Invoice;
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
        $donation = Donation::where('status', 'approve')->count();

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
            'product' => $product,
            'donation' => $donation,
            'trx_pending' => Invoice::where('status', 'pending')->count(),
            'trx_cancel' => Invoice::where('status', 'cancel')->count(),
            'trx_reject' => Invoice::where('status', 'reject')->count(),
            'trx_payment' => Invoice::where('status', 'payment')->count(),
            'trx_approve' => Invoice::where('status', 'approve')->count(),
            'trx_done' => Invoice::where('status', 'done')->count(),
        ]);
    }
}
