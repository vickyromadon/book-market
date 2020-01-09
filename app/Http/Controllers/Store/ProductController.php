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
                "quantity",
                "price",
                "sold",
                "view",
                "created_at"
            ];

            $total = Product::where("title", 'LIKE', "%$search%")
                ->where("quantity", 'LIKE', "%$search%")
                ->where("price", 'LIKE', "%$search%")
                ->where("sold", 'LIKE', "%$search%")
                ->where("view", 'LIKE', "%$search%")
                ->count();

            $data = Product::where("title", 'LIKE', "%$search%")
                ->where("quantity", 'LIKE', "%$search%")
                ->where("price", 'LIKE', "%$search%")
                ->where("sold", 'LIKE', "%$search%")
                ->where("view", 'LIKE', "%$search%")
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
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'category_id'   => 'required',
            'level_id'      => 'required',
        ]);

        $store = Store::where('user_id', '=', Auth::user()->id)->first();

        $product                = new Product();
        $product->title         = $request->title;
        $product->description   = $request->description;
        $product->quantity      = $request->quantity;
        $product->price         = $request->price;
        $product->category_id   = $request->category_id;
        $product->level_id      = $request->level_id;
        $product->image         = $request->file('image')->store('product/' . Auth::user()->id);
        $product->store_id      = $store->id;

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
            'quantity'      => 'required|numeric',
            'price'         => 'required|numeric',
            'image'         => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'category_id'   => 'required',
            'level_id'      => 'required',
        ]);

        $product                = Product::find($request->id);
        $product->title         = $request->title;
        $product->description   = $request->description;
        $product->quantity      = $request->quantity;
        $product->price         = $request->price;
        $product->category_id   = $request->category_id;
        $product->level_id      = $request->level_id;

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
