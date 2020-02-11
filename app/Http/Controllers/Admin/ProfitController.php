<?php

namespace App\Http\Controllers\Admin;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfitController extends Controller
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
                "discount",
                "created_at"
            ];

            $total = Withdraw::where('status', '=', "approve")
                ->where(function ($q) use ($search) {
                    $q->where("discount", 'LIKE', "%$search%")
                    ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = Withdraw::where('status', '=', "approve")
                ->where(function ($q) use ($search) {
                    $q->where("discount", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
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
}
