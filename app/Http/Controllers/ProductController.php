<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Level;

class ProductController extends Controller
{
    public function index()
    {
        return $this->view([
            'product' => Product::where('status', '=', 'publish')->orderBy('created_at', 'desc')->paginate(12)
        ]);
    }

    public function category($id)
    {
        return $this->view([
            'category' => Category::find($id),
            'product' => Product::where('status', '=', 'publish')->where('category_id', '=', $id)->orderBy('created_at', 'desc')->paginate(12)
        ]);
    }

    public function level($id)
    {
        return $this->view([
            'level' => Level::find($id),
            'product' => Product::where('status', '=', 'publish')->where('level_id', '=', $id)->orderBy('created_at', 'desc')->paginate(12)
        ]);
    }

    public function detail($id)
    {
        return $this->view([
            'product' => Product::find($id),
        ]);
    }
}
