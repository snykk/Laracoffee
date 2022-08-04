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


    public function getProductData($id)
    {
        $product = Product::find($id);

        return $product;
    }


    public function addProductGet()
    {
        $data["title"] = "Add Product";

        return view('/product/add_product', $data);
    }


    public function addProductPost(Request $request)
    {
        $validatedData = $request->validate([
            "product_name" => "required",
            "stock" => "required|numeric|gt:0",
            "price" => "required|numeric|gt:0",
            "discount" => "required|numeric|gt:0|lt:100",
            "orientation" => "required",
            "description" => "required",
            "image" => "image|max:2048"
        ]);

        if (!isset($validatedData["image"])) {
            $validatedData["image"] = env("IMAGE_PRODUCT");
        } else {
            $validatedData["image"] = $request->file("image")->store("product");
        }

        try {
            Product::create($validatedData);
            $message = "Product has been added!";

            myFlasherBuilder(message: $message, success: true);

            return redirect('/product');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }
}
