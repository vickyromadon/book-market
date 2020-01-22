<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $product            = Product::where('store_id', Auth::user()->store->id)->count();
        $invoice_payment    = Invoice::where('store_id', Auth::user()->store->id)->where('status', 'payment')->count();
        $invoice_approve    = Invoice::where('store_id', Auth::user()->store->id)->where('status', 'approve')->count();
        $invoice_done       = Invoice::where('store_id', Auth::user()->store->id)->where('status', 'done')->count();

        return $this->view([
            'product'           => $product,
            'invoice_payment'   => $invoice_payment,
            'invoice_approve'   => $invoice_approve,
            'invoice_done'      => $invoice_done,
        ]);
    }
}
