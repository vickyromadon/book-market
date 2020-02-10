<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ManagementMemberController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => User::all()
        ]);
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->status = "block";

        if (!$user->save()) {
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

    public function active($id)
    {
        $user = User::find($id);
        $user->status = "active";

        if (!$user->save()) {
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

    public function resetPassword($id)
    {
        $password       = Hash::make('12345678');

        $user           = User::find($id);
        $user->password = $password;

        if (!$user->save()) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Mereset Password'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Mereset Password'
            ]);
        }
    }
}
