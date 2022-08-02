<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data["title"] = "Product";
        $data["product"] = Product::all();

        return view('/product/index', $data);
    }
}
