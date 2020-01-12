<?php

namespace App\Http\Controllers\Admin;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
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
                "discount",
                "count",
                "point_exchange",
                "created_at"
            ];

            $total = Voucher::where("name", 'LIKE', "%$search%")
                ->where("discount", 'LIKE', "%$search%")
                ->where("count", 'LIKE', "%$search%")
                ->where("point_exchange", 'LIKE', "%$search%")
                ->count();

            $data = Voucher::where("name", 'LIKE', "%$search%")
                ->where("discount", 'LIKE', "%$search%")
                ->where("count", 'LIKE', "%$search%")
                ->where("point_exchange", 'LIKE', "%$search%")
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

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'          => 'required|string|max:191|unique:vouchers',
            'discount'      => 'required|numeric',
            'count'         => 'required|numeric',
            'point_exchange'=> 'required|numeric',
        ]);

        $voucher                = new Voucher();
        $voucher->name          = $request->name;
        $voucher->discount      = $request->discount;
        $voucher->count         = $request->count;
        $voucher->point_exchange= $request->point_exchange;

        if (!$voucher->save()) {
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
            'name'          => 'required', 'string', 'max:191', Rule::unique('vouchers')->ignore($id),
            'discount'      => 'required|numeric',
            'count'         => 'required|numeric',
            'point_exchange'=> 'required|numeric',
        ]);

        $voucher                = Voucher::find($request->id);
        $voucher->name          = $request->name;
        $voucher->discount      = $request->discount;
        $voucher->count         = $request->count;
        $voucher->point_exchange= $request->point_exchange;

        if (!$voucher->save()) {
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
        $voucher = Voucher::find($id);

        if ($voucher->delete()) {
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
