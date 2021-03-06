<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class OrderDeclinedController extends Controller
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
                ->where('status', '=', 'reject')
                ->where(function ($q) use ($search) {
                    $q->where("number", 'LIKE', "%$search%");
                })
                ->count();

            $data = Invoice::where('store_id', '=', $store->id)
                ->where('status', '=', 'reject')
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
}
