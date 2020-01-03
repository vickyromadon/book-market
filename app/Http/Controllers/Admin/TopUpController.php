<?php

namespace App\Http\Controllers\Admin;

use App\Models\TopUp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TopUpController extends Controller
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
                "transfer_date",
                "status",
                "user",
                "created_at"
            ];

            $total = TopUp::with(['user'])
                ->where("nominal", 'LIKE', "%$search%")
                ->where("transfer_date", 'LIKE', "%$search%")
                ->where("status", 'LIKE', "%$search%")
                ->count();

            $data = TopUp::with(['user'])
                ->where("nominal", 'LIKE', "%$search%")
                ->where("transfer_date", 'LIKE', "%$search%")
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
        return $this->view(['data' => TopUp::find($id)]);
    }

    public function approve(Request $request)
    {
        $topup = TopUp::find($request->id);
        $topup->status = "approve";

        if ($topup->save()) {
            $user = User::find($topup->user_id);
            $user->balance += $topup->nominal;
            $user->save();

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
        $topup = TopUp::find($request->id);
        $topup->status = "reject";

        if ($topup->save()) {
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
