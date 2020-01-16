<?php

namespace App\Http\Controllers\Store;

use App\Models\Withdraw;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
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
                "bank",
                "nominal",
                "status",
                "created_at"
            ];

            $total = Withdraw::with('bank')
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("nominal", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Withdraw::with('bank')
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("nominal", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
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

        return $this->view([
            'bank' => Bank::where('user_id', Auth::user()->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'nominal'   => 'required|numeric',
            'bank_id'   => 'required|numeric',
        ]);

        $withdraw           = new Withdraw();
        $withdraw->nominal  = $request->nominal;
        $withdraw->bank_id  = $request->bank_id;
        $withdraw->user_id  = Auth::user()->id;
        $withdraw->status   = "pending";

        if (!$withdraw->save()) {
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

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'nominal'   => 'required|numeric',
            'bank_id'   => 'required|numeric',
        ]);

        $withdraw           = Withdraw::find($request->id);
        $withdraw->nominal  = $request->nominal;
        $withdraw->bank_id  = $request->bank_id;

        if (!$withdraw->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Merubah'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Merubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $withdraw = Withdraw::find($id);

        if ($withdraw->delete()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Menghapus'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menghapus'
            ]);
        }
    }
}
