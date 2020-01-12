<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\User;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Auth;


class VoucherController extends Controller
{
    public function index()
    {
        return $this->view([
            'voucher' => Voucher::where('count', '>', 0)->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $voucher    = Voucher::find($request->voucher_id);
        $user       = User::find(Auth::user()->id);

        if ( $voucher->count < 1 ) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher Sudah Tidak Tersedia.',
            ]);
        }

        if ( $user->point < $voucher->point_exchange ) {
            return response()->json([
                'success' => false,
                'message' => 'Poin Anda Tidak Cukup.',
            ]);
        }

        $userVoucher = new UserVoucher();
        $userVoucher->user_id = $user->id;
        $userVoucher->voucher_id = $voucher->id;

        if ($userVoucher->save()) {
            $user->point -= $voucher->point_exchange;
            $user->save();

            $voucher->count -= 1;
            $voucher->save();

            return response()->json([
                'success' => true,
                'message' => 'Tukar Poin Berhasil',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tukar Poin Gagal',
            ]);
        }
    }

    public function me()
    {
        return $this->view([
            'user_voucher' => UserVoucher::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get()
        ]);
    }
}
