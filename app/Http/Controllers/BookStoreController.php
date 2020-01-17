<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;

class BookStoreController extends Controller
{
    public function index()
    {
        return $this->view([
            'store' => Store::orderBy('created_at', 'desc')->paginate(12)
        ]);
    }

    public function detail($id)
    {
        return $this->view([
            'store' => Store::find($id),
            'product' => Product::where('store_id', $id)->paginate(12)
        ]);
    }
}
