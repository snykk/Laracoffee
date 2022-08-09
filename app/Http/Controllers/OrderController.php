<?php

namespace App\Http\Controllers;

use App\Models\{Order, Status, Product};
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Auth;

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
            'province' => 'required|numeric|gt:0',
            'city' => 'required|numeric|gt:0',
            'total_price' => 'required|gt:0',
            'shipping_address' => 'required',
            'coupon_used' => 'required|gte:0'
        ];


        $message = [
            'payment_method.required' => 'Please select the payment method',
            'province.gt' => 'Please select the province',
            'city.gt' => 'Please select the city',
            'quantity.lt' => 'sorry the current available stock is ' . $product->stock,
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
                "shipping_address" => $validatedData["shipping_address"],
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
            return redirect("/order/order_data");
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }


    public function orderData()
    {
        $title = "Order Data";
        $orders = Order::with("bank", "note", "payment", "user", "status", "product")->orderBy("id", "ASC")->get();
        $status = Status::all();


        return view("/order/order_data", compact("title", "orders", "status"));
    }


    public function orderDataFilter(Request $request, $status_id)
    {
        $title = "Order Data";
        $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where("status_id", $status_id)->orderBy("id", "ASC")->get();
        $status = Status::all();

        return view("/order/order_data", compact("title", "orders", "status"));
    }


    public function getOrderData($id)
    {
        $order = Order::with("product", "user", "note", "status", "bank", "payment")->find($id);
        return $order;
    }


    public function cancelOrder(Order $order)
    {
        $updated_data = [
            "status_id" => 5,
            "note_id" => 6,
            "refusal_reason" => null,
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            $order->save();

            $this->couponBack($order);

            $message = "Your order has been canceled!";

            myFlasherBuilder(message: $message, success: true);
            return redirect("/order/order_data");
        }
    }


    private function couponBack(Order $order)
    {
        // return the user's coupon if using a coupon
        $user = Auth::user();

        $new_coupon = (int)$user->coupon + (int)$order->coupon_used;

        $user->coupon = $new_coupon;

        if ($user->isDirty()) {
            $user->save();
        }
    }


    public function rejectOrder(Request $request, Order $order, Product $product)
    {
        if ($request->refusal_reason == "") {
            $message = "Refusal reason cannot be empty!";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        if ($order->status_id == 5) {
            $message = "Order status is already canceled by user";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        if ($order->status_id == 3) {
            $message = "Order status is already rejected";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }

        $updated_data = [
            "status_id" => 3,
            "refusal_reason" => $request->refusal_reason
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            if ($order->getOriginal("status_id") == 1) {
                $this->stockReturn($order, $product);
            }

            $order->save();

            $this->couponBack($order);

            $message = "Order rejected successfully!";

            myFlasherBuilder(message: $message, success: true);
            return redirect("/order/order_data");
        }
    }


    private function stockReturn(Order $order, Product $product)
    {
        $product->stock = $product->stock + $order->quantity;

        if ($product->isDirty()) {
            $product->save();
        }
    }


    public function approveOrder(Order $order, Product $product)
    {
        if ($order->status_id == 1) {
            $message = "Order status is already approved by admin";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->status_id == 3) {
            $message = "Can't approve the order that have been rejected by admin";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->transaction_doc == env("IMAGE_PROOF")) {
            $message = "No transfer proof uploaded!";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($product->stock - $order->quantity < 0) {
            $message = "Quantity order is out of stock";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        // Approve order
        $updated_data = [
            "status_id" => 1,
            "refusal_reason" => null,
            "note_id" => ($order->payment_id == 1) ? 4 : 1,
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            $order->save();
        }

        // Reduce product stock
        $product->stock = $product->stock - $order->quantity;

        if ($product->isDirty()) {
            $product->save();
        }

        $message = "Order approved successfully!";
        myFlasherBuilder(message: $message, success: true);

        return redirect("/order/order_data");
    }
}
