<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
                "publisher",
                "quantity",
                "price",
                "sold",
                "view",
                "status",
                "created_at"
            ];

            $store = Store::where('user_id', '=', Auth::user()->id)->first();

            $total = Product::with(['category', 'level'])
                ->where('store_id', '=', $store->id)
                ->where(function ($q) use ($search) {
                    $q->where("title", 'LIKE', "%$search%")
                        ->orWhere("publisher", 'LIKE', "%$search%")
                        ->orWhere("quantity", 'LIKE', "%$search%")
                        ->orWhere("price", 'LIKE', "%$search%")
                        ->orWhere("sold", 'LIKE', "%$search%")
                        ->orWhere("view", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%");
                })
                ->count();

            $data = Product::with(['category', 'level'])
                ->where('store_id', '=', $store->id)
                ->where(function ($q) use ($search) {
                    $q->where("title", 'LIKE', "%$search%")
                        ->orWhere("publisher", 'LIKE', "%$search%")
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

        return $this->view([
            'category' => Category::all(),
            'level' => Level::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title'         => 'required|string|max:191',
            'description'   => 'required|string',
            'publisher'     => 'required|string',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'category_id'   => 'required',
            'level_id'      => 'required',
            'status'        => 'required',
        ]);

        $store = Store::where('user_id', '=', Auth::user()->id)->first();

        $product                = new Product();
        $product->title         = $request->title;
        $product->description   = $request->description;
        $product->publisher     = $request->publisher;
        $product->quantity      = $request->quantity;
        $product->price         = $request->price;
        $product->category_id   = $request->category_id;
        $product->level_id      = $request->level_id;
        $product->store_id      = $store->id;
        $product->status        = $request->status;

        if ($request->image != null) {
            $product->image     = $request->file('image')->store('product/' . Auth::user()->id);
        }

        if (!$product->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Product::where('image', '=', $product->image)->first();
                Storage::delete($fileDelete->image);
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
            'description'   => 'required|string',
            'publisher'     => 'required|string',
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'category_id'   => 'required',
            'level_id'      => 'required',
            'status'        => 'required',

        ]);

        $product                = Product::find($request->id);
        $product->title         = $request->title;
        $product->description   = $request->description;
        $product->publisher     = $request->publisher;
        $product->quantity      = $request->quantity;
        $product->price         = $request->price;
        $product->category_id   = $request->category_id;
        $product->level_id      = $request->level_id;
        $product->status        = $request->status;


        if ($request->image != null) {
            if ($product->image != null) {
                $picture = Product::where('image', '=', $product->image)->first();
                Storage::delete($picture->image);
            }

            $product->image = $request->file('image')->store('product/' . Auth::user()->id);
        }

        if (!$product->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Product::where('image', '=', $product->image)->first();
                Product::delete($fileDelete->image);
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
        $product = Product::find($id);
        Storage::delete($product->image);

        if ($product->delete()) {
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
