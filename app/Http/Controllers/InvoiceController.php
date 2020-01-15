<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCart;
use App\Models\Cart;
use App\Models\User;
use App\Models\Store;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Location;
use App\Models\Payment;
use App\Models\UserVoucher;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        return $this->view([
            'invoice_pending'   => Invoice::where('user_id', Auth::user()->id)->where('status', "pending")->get(),
            'invoice_payment'   => Invoice::where('user_id', Auth::user()->id)->where('status', "payment")->get(),
            'invoice_cancel'    => Invoice::where('user_id', Auth::user()->id)->where('status', "cancel")->get(),
            'invoice_approve'   => Invoice::where('user_id', Auth::user()->id)->where('status', "approve")->get(),
            'invoice_reject'    => Invoice::where('user_id', Auth::user()->id)->where('status', "reject")->get(),
            'invoice_received'  => Invoice::where('user_id', Auth::user()->id)->where('status', "done")->get(),
        ]);
    }

    public function pending($id)
    {
        $invoice = Invoice::find($id);
        $subTotal = 0;

        foreach ($invoice->invoice_carts as $item) {
            $subTotal += $item->cart->price;
        }

        $invoice->subtotal  = $subTotal;
        $invoice->total     = ($invoice->subtotal + $invoice->shipping) - $invoice->discount;
        $invoice->save();

        return $this->view([
            'invoice'       => $invoice,
            'province'      => Province::all(),
            'district'      => District::all(),
            'sub_district'  => SubDistrict::all(),
        ]);
    }

    public function canceled($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function orderShipped($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function orderReject($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function waitingStore($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function received($id)
    {
        $invoice = Invoice::find($id);
        return $this->view([
            'invoice'       => $invoice
        ]);
    }

    public function destinationLocationNow(Request $request){
        $invoice = Invoice::find($request->id_invoice);
        $shipping = Shipping::where('to', Auth::user()->location->sub_district)->where('from', $invoice->depature_location->sub_district)->first();

        $invoice->destination_location_id = Auth::user()->location_id;
        $invoice->shipping = $shipping->amount;

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }

    public function destinationLocationNew(Request $request){
        $validator = $request->validate([
            'street'        => 'required|string',
            'province'      => 'required|string',
            'district'      => 'required|string',
            'sub_district'  => 'required|string',
        ]);


        $location               = new Location();
        $location->street       = $request->street;
        $location->province     = Province::find($request->province)->name;
        $location->district     = District::find($request->district)->name;
        $location->sub_district = SubDistrict::find($request->sub_district)->name;
        $location->save();

        $invoice    = Invoice::find($request->invoice_id);
        $shipping   = Shipping::where('to', $location->sub_district)->where('from', $invoice->depature_location->sub_district)->first();

        if ( $shipping == null ) {
            return response()->json([
                'success'   => false,
                'message'   => 'Ongkos kirim belum ditentukan, silahkan isi alamat yang lain.'
            ]);
        }

        $invoice->destination_location_id   = $location->id;
        $invoice->shipping                  = $shipping->amount;

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }

    public function payment(Request $request){
        $invoice = Invoice::find($request->id);

        if (Auth::user()->balance < $invoice->total) {
            return response()->json([
                'success'   => false,
                'message'   => 'Maaf Saldo Anda Tidak Cukup.'
            ]);
        }

        $invoice->status = "payment";

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Melakukan Pembayaran'
            ]);
        } else {
            $user                       = User::find(Auth::user()->id);

            $payment                    = new Payment();
            $payment->nominal           = $invoice->total;
            $payment->beginning_balance = $user->balance;
            $payment->ending_balance    = $user->balance - $invoice->total;
            $payment->status            = "out";
            $payment->user_id           = $user->id;
            $payment->invoice_id        = $invoice->id;
            $payment->discount          = $invoice->discount;
            $payment->save();

            $user->balance              -= $invoice->total;
            $user->save();


            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Melakukan Pembayaran'
            ]);
        }
    }

    public function cancel(Request $request){
        $invoice = Invoice::find($request->id);
        $invoice->status = "cancel";

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Melakukan Pembatalan'
            ]);
        } else {
            foreach ($invoice->invoice_carts as $item) {
                $cart = Cart::find($item->cart_id);
                $cart->status = "cancel";
                $cart->save();
            }

            if ($invoice->voucher_id != null) {
                $userVoucher                = new UserVoucher();
                $userVoucher->voucher_id    = $invoice->voucher_id;
                $userVoucher->user_id       = $invoice->user_id;
                $userVoucher->Save();
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Melakukan Pembatalan'
            ]);
        }
    }

    public function confirmShipped(Request $request){
        $invoice = Invoice::find($request->id);
        $invoice->status = "done";

        if (!$invoice->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Konfirmasi'
            ]);
        } else {
            $payment                    = new Payment();
            $payment->nominal           = $invoice->total;
            $payment->beginning_balance = $invoice->store->user->balance;
            $payment->ending_balance    = $invoice->store->user->balance + $invoice->total + $invoice->discount;
            $payment->status            = "in";
            $payment->user_id           = $invoice->store->user_id;
            $payment->invoice_id        = $invoice->id;
            $payment->discount          = $invoice->discount;
            $payment->save();

            $userSell           = User::find($invoice->store->user_id);
            $userSell->balance  += $invoice->total + $invoice->discount;
            $userSell->save();

            $userBuy = User::find($invoice->user_id);
            $userBuy->point += env('POINT_BUY') * ceil($invoice->subtotal / env('MULTIPLE_BUY'));
            $userBuy->save();

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Konfirmasi'
            ]);
        }
    }

    public function useVoucher(Request $request){
        $validator = $request->validate([
            'voucher_id'        => 'required|numeric',
        ]);

        $invoice        = Invoice::find($request->id);
        $userVoucher    = UserVoucher::find($request->voucher_id);

        $voucher    = $userVoucher->voucher->discount;
        $subtotal   = $invoice->subtotal;
        $discount   = $subtotal - ($subtotal * ($voucher/100));

        $invoice->voucher_id    = $userVoucher->voucher->id;
        $invoice->discount      = $discount;

        if ($invoice->save()) {
            $userVoucher->delete();

            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menggunakan Voucher'
            ]);
        } else {
            return response()->json([
                'success'  => false,
                'message'  => 'Gagal Menggunakan Voucher'
            ]);
        }
    }

    public function store()
    {
        $user = User::find(Auth::user()->id);
        $cart = Cart::where('user_id', '=', $user->id)->where('status', '=', 'pending')->get();

        $storeId    = array();
        foreach ($cart as $item) {
            if (!in_array($item->store_id, $storeId)) {
                array_push($storeId, $item->store_id );
            }
        }

        foreach ($storeId as $item) {
            $invoice = new Invoice();
            $invoice->number                = "INV/" . date("Y-m-d_H:i:s") . "/" . $item . "/" . Auth::user()->email . "/" . $this->getInvoiceLast();
            $invoice->status                = "pending";
            $invoice->user_id               = $user->id;
            $invoice->store_id              = $item;
            $invoice->depature_location_id  = $this->getLocationStore($item);
            $invoice->save();
        }

        foreach ($cart as $item) {
            $invoiceCart                = new InvoiceCart();
            $invoiceCart->invoice_id    = $this->getInvoice($item->store_id, $item->user_id);
            $invoiceCart->cart_id       = $this->getCart($item->store_id, $item->user_id, $item->product_id);
            $invoiceCart->save();
        }

        foreach ($cart as $item) {
            $item->status = "done";
            $item->save();
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Berhasil Lanjut Pembayaran'
        ]);
    }

    private function getCart($store, $user, $product){
        $cart = Cart::where('store_id', $store)->where('user_id', $user)->where('product_id', $product)->where('status', 'pending')->first();
        return $cart->id;
    }

    private function getInvoice($store, $user){
        $invoice = Invoice::where('store_id', $store)->where('user_id', $user)->where('status', 'pending')->first();
        return $invoice->id;
    }

    private function getInvoiceLast(){
        $invoice = Invoice::orderBy('created_at', 'desc')->first();
        if ($invoice == null) {
            return "1";
        } else {
            return strval($invoice->id + 1);
        }
    }

    private function getLocationStore($store){
        $store = Store::find($store);
        return $store->location_id;
    }
}
