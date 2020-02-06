<?php

namespace App\Http\Controllers\Admin;

use App\Models\Withdraw;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                "nominal",
                "discount",
                "total",
                "status",
                "created_at"
            ];

            $total = Withdraw::with(['user', 'bank'])
                ->where("nominal", 'LIKE', "%$search%")
                ->where("discount", 'LIKE', "%$search%")
                ->where("total", 'LIKE', "%$search%")
                ->where("status", 'LIKE', "%$search%")
                ->count();

            $data = Withdraw::with(['user', 'bank'])
                ->where("nominal", 'LIKE', "%$search%")
                ->where("discount", 'LIKE', "%$search%")
                ->where("total", 'LIKE', "%$search%")
                ->where("status", 'LIKE', "%$search%")
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
        return $this->view(['data' => Withdraw::find($id)]);
    }

    public function approve(Request $request)
    {
        $withdraw = Withdraw::find($request->id);
        $withdraw->status = "approve";

        $user = User::find($withdraw->user_id);

        if ($user->balance < $withdraw->nominal) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal, Karena Saldo Toko Tidak Cukup'
            ]);
        } else {
            $user->balance -= $withdraw->nominal;
            $user->save();
        }

        if ($withdraw->save()) {

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
        $withdraw = Withdraw::find($request->id);
        $withdraw->status = "reject";

        if ($withdraw->save()) {
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
