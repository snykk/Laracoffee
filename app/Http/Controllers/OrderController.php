<?php

namespace App\Http\Controllers;

use App\Models\Order;
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


    public function makeOrderPost(Request $request, Product $product)
    {

        $rules = [
            'address' => 'required|max:255',
            'payment_method' => 'required|numeric',
            'quantity' => 'required|numeric|gt:0|lt:' . $product->stock,
            'total_price' => 'required|numeric|gte:0',
            'coupon_used' => 'required|numeric|gte:0',
        ];

        $message = [
            'payment_method.required' => 'Please select the payment method',
            'quantity.lt' . $product->stock => '
            sorry the current available stock is ' . $product->stock,
        ];

        if ($request->payment_method == 1) {
            $rules['bank_id'] = 'required|numeric';
            $message['bank_id.required'] = 'Please select the bank';
        }

        $validatedData = $request->validate($rules, $message);

        try {
            $data = [
                "product_id" => $product->id,
                "user_id" => auth()->user()->id,
                "quantity" => $validatedData["quantity"],
                "address" => $validatedData["address"],
                "total_price" => $validatedData["total_price"],
                "payment_id" => $validatedData["payment_method"],
                "note_id" => ($validatedData["payment_method"] == 1) ? 2 : 1,
                "status_id" => 2,
                "transaction_doc" => ($validatedData["payment_method"] == 1) ? env("IMAGE_PROOF") : null,
                "is_done" => 0,
                "coupon_used" => $validatedData["coupon_used"]
            ];

            if ($validatedData["payment_method"] == 1) {
                $data['bank_id'] = $validatedData["bank_id"];
            }

            Order::create($data);

            $message = "Orders has been created!";

            myFlasherBuilder(message: $message, success: true);

            return redirect("/home");
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }


    public function orderData()
    {
        $title = "Order Data";

        $orders = Order::with("bank", "note", "payment", "user", "status", "product")->latest()->get();


        return view("/order/order_data", compact("title", "orders"));
    }
}
