<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function index()
    {
        return $this->view([
            'store'         => Store::where('user_id', '=', Auth::user()->id)->first(),
            'user'          => User::find(Auth::user()->id),
            'province'      => Province::all(),
            'district'      => District::all(),
            'sub_district'  => SubDistrict::all(),
        ]);
    }

    public function setting(Request $request)
    {
        $validator = $request->validate([
            'name'          => ['required', 'string', 'max:191', Rule::unique('stores')->ignore(Auth::user()->id, 'user_id')],
            'phone'         => ['required', 'string', Rule::unique('users')->ignore(Auth::user()->id)],
            'description'   => 'required|string',
            'open_time'     => 'required',
            'close_time'    => 'required',
        ]);

        $store = Store::updateOrCreate(
            ['user_id' => Auth::user()->id],
            [
                'name'          => $request->name,
                'description'   => $request->description,
                'open_time'     => $request->open_time,
                'close_time'    => $request->close_time,
            ]
        );

        if($store){
            $user           = User::find(Auth::user()->id);
            $user->phone    = $request->phone;
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

        $store = Store::where('user_id', '=', Auth::user()->id)->first();

        if ($store == null) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Pengaturan Umum Terlebih Dahulu',
            ]);
        }

        if ($request->image != null) {
            if ($request->hasFile('image') != null) {
                if ($store->image != null) {
                    $picture = Store::where('image', '=', $store->image)->first();
                    Storage::delete($picture->image);
                }

                $store->image = $request->file('image')->store('store/'. Auth::user()->id);
            }
        }

        if (!$store->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Store::where('image', '=', $store->image)->first();
                Storage::delete($fileDelete->image);
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

    public function location(Request $request){
        $validator = $request->validate([
            'street'        => 'required|string',
            'province'      => 'required|string',
            'district'      => 'required|string',
            'sub_district'  => 'required|string',
        ]);

        $store      = Store::where('user_id', '=', Auth::user()->id)->first();
        if ($store == null) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Pengaturan Umum Terlebih Dahulu',
            ]);
        }

        $location   = null;

        if ($store->location_id == null) {
            $location               = new Location();
            $location->street       = $request->street;
            $location->province     = Province::find($request->province)->name;
            $location->district     = District::find($request->district)->name;
            $location->sub_district = SubDistrict::find($request->sub_district)->name;
        } else {
            $location               = Location::find($store->location_id);
            $location->street       = $request->street;
            $location->province     = Province::find($request->province)->name;
            $location->district     = District::find($request->district)->name;
            $location->sub_district = SubDistrict::find($request->sub_district)->name;
        }

        if ($location->save()) {
            $store->location_id = $location->id;
            $store->save();

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
}
