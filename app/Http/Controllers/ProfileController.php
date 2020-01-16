<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Location;
use App\Models\TopUp;
use App\Models\Bank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return $this->view([
            'user'          => User::find(Auth::user()->id),
            'province'      => Province::all(),
            'district'      => District::all(),
            'sub_district'  => SubDistrict::all(),
            'bank'          => Bank::where('user_id', 1)->get(),
        ]);
    }

    public function setting(Request $request)
    {
        $validator = $request->validate([
            'name'          => ['nullable', 'string', 'max:191', Rule::unique('stores')->ignore(Auth::user()->id, 'user_id')],
            'phone'         => ['nullable', 'string', Rule::unique('users')->ignore(Auth::user()->id)],
        ]);

        $user           = User::find(Auth::user()->id);
        $user->name     = $request->name != null ? $request->name : $user->name;
        $user->phone    = $request->phone != null ? $request->phone : $user->phone;

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Merubah',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Merubah',
            ]);
        }
    }

    public function password(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (!(Hash::check($request->current_password, $user->password))) {
            return response()->json([
                'success' => false,
                'message' => 'Kata Sandi Lama Salah, Silahkan Coba Lagi.',
            ]);
        }

        $validator = $request->validate([
            'new_password'         => 'required|min:6',
            'new_password_confirm' => 'required_with:new_password|same:new_password|min:6',
        ]);


        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Berhasil diubah',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kata Sandi Gagal diubah',
            ]);
        }
    }

    public function avatar(Request $request)
    {
        $validator = $request->validate([
            'image'   => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->image != null) {
            if ($request->hasFile('image') != null) {
                if ($user->image != null) {
                    $picture = User::where('image', '=', $user->images)->first();
                    Storage::delete($picture->images);
                }

                $user->images = $request->file('image')->store('user/' . Auth::user()->id);
            }
        }

        if (!$user->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = User::where('image', '=', $user->images)->first();
                Storage::delete($fileDelete->images);
                $fileDelete->delete();
            }

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

    public function location(Request $request)
    {
        $validator = $request->validate([
            'street'        => 'required|string',
            'province'      => 'required|string',
            'district'      => 'required|string',
            'sub_district'  => 'required|string',
        ]);

        $user       = User::find(Auth::user()->id);
        $location   = null;

        if ($user->location_id == null) {
            $location               = new Location();
            $location->street       = $request->street;
            $location->province     = Province::find($request->province)->name;
            $location->district     = District::find($request->district)->name;
            $location->sub_district = SubDistrict::find($request->sub_district)->name;
        } else {
            $location               = Location::find($user->location_id);
            $location->street       = $request->street;
            $location->province     = Province::find($request->province)->name;
            $location->district     = District::find($request->district)->name;
            $location->sub_district = SubDistrict::find($request->sub_district)->name;
        }

        if ($location->save()) {
            $user->location_id  = $location->id;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Merubah',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Merubah',
            ]);
        }
    }

    public function balance(Request $request)
    {
        $validator = $request->validate([
            'nominal'       => 'required|numeric',
            'transfer_date' => 'required|date',
            'proof'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $topup                  = new TopUp();
        $topup->nominal         = $request->nominal;
        $topup->transfer_date   = $request->transfer_date;
        $topup->proof           = $request->file('proof')->store('topup/' . Auth::user()->id);
        $topup->user_id         = Auth::user()->id;

        if ($topup->save()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Top Up Saldo'
            ]);
        } else {
            if ($request->hasFile('proof')) {
                $fileDelete = TopUp::where('proof', '=', $topup->proof)->first();
                Storage::delete($fileDelete->proof);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Top Up Saldo'
            ]);
        }
    }
}
