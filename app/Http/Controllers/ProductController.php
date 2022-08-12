<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Product";
        $product = Product::all();

        return view('/product/index', compact("title", "product"));
    }


    public function getProductData($id)
    {
        $product = Product::find($id);

        return $product;
    }


    public function addProductGet()
    {
        $title = "Add Product";

        return view('/product/add_product', compact("title"));
    }


    public function addProductPost(Request $request)
    {
        $validatedData = $request->validate([
            "product_name" => "required|max:25",
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


    public function editProductGet(Product $product)
    {
        $data["title"] = "Edit Product";
        $data["product"] = $product;

        return view("/product/edit_product", $data);
    }


    public function editProductPost(Request $request, Product $product)
    {
        $rules = [
            'orientation' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|numeric|gt:0',
            'discount' => 'required|numeric|gt:0|lt:100',
            'image' => 'image|file|max:2048'
        ];


        if ($product->product_name != $request->product_name) {
            $rules['product_name'] = 'required|max:25|unique:products,product_name';
        } else {
            $rules['product_name'] = 'required|max:25';
        }

        $validatedData = $request->validate($rules);

        try {
            if ($request->file("image")) {
                if ($request->oldImage != env("IMAGE_PRODUCT")) {
                    Storage::delete($request->oldImage);
                }

                $validatedData["image"] = $request->file("image")->store("product");
            }

            $product->fill($validatedData);


            if ($product->isDirty()) {
                $product->save();

                $message = "Product has been updated!";

                myFlasherBuilder(message: $message, success: true);
                return redirect("/product");
            } else {
                $message = "Action <strong>failed</strong>, no changes detected!";

                myFlasherBuilder(message: $message, failed: true);
                return back();
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }
}
