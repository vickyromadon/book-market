<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class SubDistrictController extends Controller
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

            $total = SubDistrict::with(['district'])
                ->where("name", 'LIKE', "%$search%")
                ->count();

            $data = SubDistrict::with(['district'])
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
            'district' => District::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'        => 'required|string|max:191|unique:sub_districts',
            'district_id' => 'required'
        ]);

        $subDistrict               = new SubDistrict();
        $subDistrict->name         = $request->name;
        $subDistrict->district_id  = $request->district_id;

        if (!$subDistrict->save()) {
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
            'name'        => 'required', 'string', 'max:191', Rule::unique('sub_districts')->ignore($id),
            'district_id' => 'required'
        ]);

        $subDistrict               = SubDistrict::find($request->id);
        $subDistrict->name         = $request->name;
        $subDistrict->district_id  = $request->district_id;

        if (!$subDistrict->save()) {
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
        $subDistrict = SubDistrict::find($id);

        if ($subDistrict->delete()) {
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
