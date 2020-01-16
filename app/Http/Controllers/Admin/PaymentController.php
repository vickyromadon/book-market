<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
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
                "beginning_balance",
                "ending_balance",
                "discount",
                "status",
                "created_at"
            ];

            $total = Payment::with(['user', 'invoice'])
                ->where("nominal", 'LIKE', "%$search%")
                ->where("beginning_balance", 'LIKE', "%$search%")
                ->where("ending_balance", 'LIKE', "%$search%")
                ->where("discount", 'LIKE', "%$search%")
                ->where("status", 'LIKE', "%$search%")
                ->count();

            $data = Payment::with(['user', 'invoice'])
                ->where("nominal", 'LIKE', "%$search%")
                ->where("beginning_balance", 'LIKE', "%$search%")
                ->where("ending_balance", 'LIKE', "%$search%")
                ->where("discount", 'LIKE', "%$search%")
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
        return $this->view(['data' => Payment::find($id)]);
    }
}
