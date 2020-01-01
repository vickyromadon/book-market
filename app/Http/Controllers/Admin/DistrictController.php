<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
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
                "created_at"
            ];

            $total = District::with(['province'])
                ->where("name", 'LIKE', "%$search%")
                ->count();

            $data = District::with(['province'])
                ->where("name", 'LIKE', "%$search%")
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
            'province' => Province::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'        => 'required|string|max:191|unique:districts',
            'province_id' => 'required'
        ]);

        $district               = new District();
        $district->name         = $request->name;
        $district->province_id  = $request->province_id;

        if (!$district->save()) {
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
            'name'        => 'required', 'string', 'max:191', Rule::unique('districts')->ignore($id),
            'province_id' => 'required'
        ]);

        $district               = District::find($request->id);
        $district->name         = $request->name;
        $district->province_id  = $request->province_id;

        if (!$district->save()) {
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
        $district = District::find($id);

        if ($district->delete()) {
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
