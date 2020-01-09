<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
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
                "title",
                "quantity",
                "price",
                "sold",
                "view",
                "status",
                "created_at"
            ];

            $total = Product::with(['category', 'level'])
                ->where(function ($q) use ($search) {
                    $q->where("title", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("sold", 'LIKE', "%$search%")
                        ->orWhere("view", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Product::with(['category', 'level'])
                ->where(function ($q) use ($search) {
                    $q->where("title", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("sold", 'LIKE', "%$search%")
                        ->orWhere("view", 'LIKE', "%$search%")
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

        return $this->view();
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'status'        => 'required',
        ]);

        $product                = Product::find($request->id);
        $product->status        = $request->status;

        if (!$product->save()) {
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
}
