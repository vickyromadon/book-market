<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\UserVoucher;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderEntryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $search;
            $start = $request->start;
            $length = $request->length;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "number",
                "created_at"
            ];

            $store = Store::where('user_id', '=', Auth::user()->id)->first();

            $total = Invoice::where('store_id', '=', $store->id)
                ->where('status', '=', 'payment')
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%");
                })
                ->count();

            $data = Invoice::where('store_id', '=', $store->id)
                ->where('status', '=', 'payment')
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%");
                })
                ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                ->skip($start)
                ->take($length)
                ->get();

            $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
        }
        return $this->view();
    }

    public function show($id)
    {
        return $this->view(['data' => Invoice::find($id)]);
    }

    public function approve(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "approve";

        if ($invoice->save()) {
            foreach ($invoice->invoice_carts as $item) {
                $product            = Product::find($item->cart->product->id);
                $product->sold      += $item->cart->quantity;
                $product->quantity  -= $item->cart->quantity;
                $product->save();
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Disetujui'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Disetujui'
            ]);
        }
    }

    public function reject(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = "reject";

        if ($invoice->save()) {
            $payment                    = new Payment();
            $payment->nominal           = $invoice->total;
            $payment->beginning_balance = $invoice->user->balance;
            $payment->ending_balance    = $invoice->user->balance + $invoice->total;
            $payment->status            = "refund";
            $payment->user_id           = $invoice->user->id;
            $payment->invoice_id        = $invoice->id;
            $payment->discount          = $invoice->discount;
            $payment->save();

            $user           = User::find($invoice->user->id);
            $user->balance  += ($invoice->total);
            $user->save();

            if ($invoice->voucher_id != null) {
                $userVoucher                = new UserVoucher();
                $userVoucher->voucher_id    = $invoice->voucher_id;
                $userVoucher->user_id       = $invoice->user_id;
                $userVoucher->Save();
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Ditolak'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Ditolak'
            ]);
        }
    }
}
