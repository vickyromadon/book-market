<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->isMethod('post')) {
            if (Auth::user()->store != null) {
                $start_periode      = $request->periode_date != null ? str_replace("/", "-", substr($request->periode_date, 0, 10)) . ' 00:00:00': date('Y-m-d') . ' 00:00:00';
                $end_periode        = $request->periode_date != null ? str_replace("/", "-", substr($request->periode_date, 13, 10)) . ' 00:00:00': date('Y-m-d') . ' 00:00:00';

                // dd($start_periode . ' ' . $end_periode);

                $rates = DB::table('invoices')
                    ->where("store_id", '=', Auth::user()->store->id)
                    ->where("status", '=', "done")
                    ->selectRaw("SUBSTRING(created_at, 1, 10) AS date, COUNT(*) AS total")
                    ->groupBy('date')
                    ->whereBetween("created_at", ["$start_periode", "$end_periode"])
                    ->get();

                return json_encode($rates);
            }
        }

        $product            = 0;
        $invoice_payment    = 0;
        $invoice_approve    = 0;
        $invoice_done       = 0;

        if(Auth::user()->store != null){
            $product            = Product::where('store_id', Auth::user()->store->id)->count();
            $invoice_payment    = Invoice::where('store_id', Auth::user()->store->id)->where('status', 'payment')->count();
            $invoice_approve    = Invoice::where('store_id', Auth::user()->store->id)->where('status', 'approve')->count();
            $invoice_done       = Invoice::where('store_id', Auth::user()->store->id)->where('status', 'done')->count();
        }

        return $this->view([
            'product'           => $product,
            'invoice_payment'   => $invoice_payment,
            'invoice_approve'   => $invoice_approve,
            'invoice_done'      => $invoice_done,
        ]);
    }
}
