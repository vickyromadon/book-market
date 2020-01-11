<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
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
                "name",
                "email",
                "category",
                "created_at"
            ];

            $total = Message::where("name", 'LIKE', "%$search%")
                ->orWhere("email", 'LIKE', "%$search%")
                ->orWhere("category", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Message::where("name", 'LIKE', "%$search%")
                ->orWhere("email", 'LIKE', "%$search%")
                ->orWhere("category", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
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
