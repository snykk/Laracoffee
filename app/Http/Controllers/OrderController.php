<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function makeOrderGet(Product $product)
    {
        $data["title"] = "Make Order";
        $data["product"] = $product;

        return view("/order/make_order", $data);
    }
}
