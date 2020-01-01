<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
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
                "from",
                "to",
                "amount",
                "created_at"
            ];

            $total = Shipping::where("from", 'LIKE', "%$search%")
                ->where("to", 'LIKE', "%$search%")
                ->where("amount", 'LIKE', "%$search%")
                ->count();

            $data = Shipping::where("from", 'LIKE', "%$search%")
                ->where("to", 'LIKE', "%$search%")
                ->where("amount", 'LIKE', "%$search%")
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
            'sub_district' => SubDistrict::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'to'        => 'required|string|max:191',
            'from'      => 'required|string|max:191',
            'amount'    => 'required|numeric',
        ]);

        $checkShipping  = Shipping::where('to', $request->to)->where('from', $request->from)->first();
        if ($checkShipping != null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Sudah Terdaftar Sebelumnya.'
            ]);
        }

        $shipping           = new Shipping();
        $shipping->to       = $request->to;
        $shipping->from     = $request->from;
        $shipping->amount   = $request->amount;

        if (!$shipping->save()) {
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
            'amount'    => 'required|numeric',
        ]);

        $shipping           = Shipping::find($request->id);
        $shipping->amount   = $request->amount;

        if (!$shipping->save()) {
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
        $shipping = Shipping::find($id);

        if ($shipping->delete()) {
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
