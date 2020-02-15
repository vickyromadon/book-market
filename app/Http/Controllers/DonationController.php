<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
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
                "status",
                "created_at"
            ];

            $total = Donation::with(['user'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("title", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Donation::with(['user'])
                ->where('user_id', '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("title", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
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

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title'     => 'required|string|max:191',
            'message'   => 'required|string',
            'quantity'  => 'required|numeric',
            'image'     => 'nullable|mimes:jpeg,jpg,png|max:5000',
        ]);

        $donation           = new Donation();
        $donation->title    = $request->title;
        $donation->message  = $request->message;
        $donation->quantity = $request->quantity;
        $donation->location = $request->location;
        $donation->date = $request->date;
        $donation->user_id  = Auth::user()->id;

        if ($request->image != null) {
            $donation->image     = $request->file('image')->store('donation/' . Auth::user()->id);
        }
        if ($request->image_1 != null) {
            $donation->image_1     = $request->file('image_1')->store('donation/' . Auth::user()->id);
        }
        if ($request->image_2 != null) {
            $donation->image_2     = $request->file('image_2')->store('donation/' . Auth::user()->id);
        }
        if ($request->image_3 != null) {
            $donation->image_3     = $request->file('image_3')->store('donation/' . Auth::user()->id);
        }

        if (!$donation->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Donation::where('image', '=', $donation->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }
            if ($request->hasFile('image_1')) {
                $fileDelete = Donation::where('image_1', '=', $donation->image_1)->first();
                Storage::delete($fileDelete->image_1);
                $fileDelete->delete();
            }
            if ($request->hasFile('image_2')) {
                $fileDelete = Donation::where('image_2', '=', $donation->image_2)->first();
                Storage::delete($fileDelete->image_2);
                $fileDelete->delete();
            }
            if ($request->hasFile('image_3')) {
                $fileDelete = Donation::where('image_3', '=', $donation->image_3)->first();
                Storage::delete($fileDelete->image_3);
                $fileDelete->delete();
            }

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

    public function update(Request $request)
    {
        $validator = $request->validate([
            'title'         => 'required|string|max:191',
            'message'       => 'required|string',
            'quantity'      => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
        ]);

        $donation                = Donation::find($request->id);
        $donation->title         = $request->title;
        $donation->message       = $request->message;
        $donation->quantity      = $request->quantity;
        $donation->location      = $request->location;
        $donation->date      = $request->date;

        if ($request->image != null) {
            if ($donation->image != null) {
                $picture = Donation::where('image', '=', $donation->image)->first();
                Storage::delete($picture->image);
            }

            $donation->image = $request->file('image')->store('product/' . Auth::user()->id);
        }
        if ($request->image_1 != null) {
            if ($donation->image_1 != null) {
                $picture = Donation::where('image_1', '=', $donation->image_1)->first();
                Storage::delete($picture->image_1);
            }

            $donation->image_1 = $request->file('image_1')->store('product/' . Auth::user()->id);
        }
        if ($request->image_2 != null) {
            if ($donation->image_2 != null) {
                $picture = Donation::where('image_2', '=', $donation->image_2)->first();
                Storage::delete($picture->image_2);
            }

            $donation->image_2 = $request->file('image_2')->store('product/' . Auth::user()->id);
        }
        if ($request->image_3 != null) {
            if ($donation->image_3 != null) {
                $picture = Donation::where('image_3', '=', $donation->image_3)->first();
                Storage::delete($picture->image_3);
            }

            $donation->image_3 = $request->file('image_3')->store('product/' . Auth::user()->id);
        }

        if (!$donation->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Donation::where('image', '=', $donation->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }
            if ($request->hasFile('image_1')) {
                $fileDelete = Donation::where('image_1', '=', $donation->image_1)->first();
                Storage::delete($fileDelete->image_1);
                $fileDelete->delete();
            }
            if ($request->hasFile('image_2')) {
                $fileDelete = Donation::where('image_2', '=', $donation->image_2)->first();
                Storage::delete($fileDelete->image_2);
                $fileDelete->delete();
            }
            if ($request->hasFile('image_3')) {
                $fileDelete = Donation::where('image_3', '=', $donation->image_3)->first();
                Storage::delete($fileDelete->image_3);
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

    public function destroy($id)
    {
        $donation = Donation::find($id);
        Storage::delete($donation->image);
        Storage::delete($donation->image_1);
        Storage::delete($donation->image_2);
        Storage::delete($donation->image_3);

        if ($donation->delete()) {
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
