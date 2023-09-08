<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\{Auth, Storage, Validator};
use App\Models\{Order, Status, Product, Role, Transaction, User};

class OrderController extends Controller
{
    public function makeOrderGet(Product $product)
    {
        $title = "Make Order";
        $product = $product;

        return view("/order/make_order", compact("title", "product"));
    }


    public function makeOrderPost(Request $request, Product $product)
    {
        $rules = [
            'address' => 'required|max:255',
            'payment_method' => 'required|numeric',
            'quantity' => 'required|numeric|gt:0|lte:' . $product->stock,
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
            'quantity.lte' => 'sorry the current available stock is ' . $product->stock,
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
        if (auth()->user()->role_id == Role::ADMIN_ID) {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["is_done" => 0])->orderBy("id", "ASC")->get();
        } else {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["user_id" => auth()->user()->id, "is_done" => 0])->orderBy("id", "ASC")->get();
        }
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


    public function getOrderData(Order $order)
    {
        $order->load("product", "user", "note", "status", "bank", "payment");
        return $order;
    }


    public function cancelOrder(Order $order)
    {
        if ($order->status_id == 5) {
            $message = "Your order is already canceled!";

            myFlasherBuilder(message: $message, failed: true);
            return redirect("/order/order_data");
        }
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

        if ($order->status_id == 4) {
            $message = "Order status is already succeded by admin";

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
            $message = "Can't approve the order that have been rejected before";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->status_id == 5) {
            $message = "Can't approve the order that have been canceled by user";
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


    public function endOrder(Order $order, Product $product)
    {
        if ($order->status->order_status == "done") {
            $message = "The order has already succeded by admin!";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($order->status->order_status != "approve") {
            $message = "Order has not been approved by the admin!";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        // change order status
        $updated_data = [
            "status_id" => 4,
            "note_id" => 5,
            "is_done" => 1,
            "refusal_reason" => null,
        ];

        $order->fill($updated_data);

        if ($order->isDirty()) {
            $order->save();
        }

        $point_rules = [
            "1" => 3,
            "2" => 4,
            "3" => 5
        ];

        // add point to user
        $user = User::find($order->user_id);
        $point_total = ($point_rules[$product->id] * (int)$order->quantity) + $user->point;
        $user->point = $point_total;
        $user->save();

        $transactional_data = [
            "category_id" => 1,
            "description" => "sales of {$order->quantity} unit of product {$product->product_name}",
            "income" => $order->total_price,
            "outcome" => null,
        ];

        // add transactional data
        Transaction::create($transactional_data);

        $message = "Order has been ended by admin";
        myFlasherBuilder(message: $message, success: true);

        return redirect("/order/order_history");
    }


    public function orderHistory()
    {
        $title = "History Data";
        if (auth()->user()->role_id == Role::ADMIN_ID) {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["is_done" => 1])->orderBy("id", "ASC")->get();
        } else {
            $orders = Order::with("bank", "note", "payment", "user", "status", "product")->where(["user_id" => auth()->user()->id, "is_done" => 1])->orderBy("id", "ASC")->get();
        }
        $status = Status::all();

        return view("/order/order_data", compact("title", "orders", "status"));
    }


    public function getProofOrder(Order $order)
    {
        $order->load("status");
        return  $order;
    }


    public function uploadProof(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'old_image_proof' => 'required',
            'image_upload_proof' => 'required|image|file|max:2048',
        ]);

        if ($validator->fails()) {
            $message = "Failed when upload an image";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data");
        }

        if ($request->file("image_upload_proof")) {
            if ($validator->validated()["old_image_proof"] != env("IMAGE_PROOF")) {
                Storage::delete($validator->validated()["old_image_proof"]);
            }

            $new_image = $request->file("image_upload_proof")->store("proof");
        }

        $order->transaction_doc = $new_image;
        $order->note_id = 3;
        $order->save();

        $message = "Proof transfer uploaded successfully";
        myFlasherBuilder(message: $message, success: true);

        return redirect("/order/order_data");
    }


    public function editOrderGet(Order $order)
    {
        if ($order->status_id == 5) {
            $message = "Action failed, order is already canceled by the user";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/order_data/");
        }

        $title = "Edit Order";
        $order->load("product", "user", "note", "status", "bank", "payment");

        return view("/order/edit_order", compact("title", "order"));
    }

    public function editOrderPost(Request $request, Order $order)
    {
        $rules = [
            'address' => 'required|max:255',
            'quantity' => 'required|numeric|gt:0|lte:' . $order->product->stock,
            'province' => 'required|numeric|gt:0',
            'city' => 'required|numeric|gt:0',
            'total_price' => 'required|gt:0',
            'shipping_address' => 'required',
            'coupon_used' => 'required|gte:0'
        ];


        $message = [
            'province.gt' => 'Please select the province',
            'city.gt' => 'Please select the city',
            'quantity.lte' => 'sorry the current available stock is ' . $order->product->stock,
        ];

        if ($request->file("image_proof_edit")) {
            $rules["image_proof_edit"] = "image|file|max:2048";
        }

        $validatedData = $request->validate($rules, $message);

        if ($request->file("image_proof_edit")) {
            if ($order->transaction_doc != env("IMAGE_PROOF")) {
                Storage::delete($order->transaction_doc);
            }

            $validatedData["transaction_doc"] = $request->file("image_proof_edit")->store("proof");
        }

        $order->fill($validatedData);

        if ($order->isDirty()) {

            $order->save();

            $message = "Order has beed updated!";
            myFlasherBuilder(message: $message, success: true);

            return redirect("/order/order_data");
        } else {
            $message = "Action failed, no changes detected";
            myFlasherBuilder(message: $message, failed: true);

            return redirect("/order/edit_order/" . $order->id);
        }
    }


    public function deleteProof(Order $order)
    {
        if ($order->transaction_doc != env("IMAGE_PROOF")) {
            Storage::delete($order->transaction_doc);
        }

        $order->transaction_doc = env("IMAGE_PROOF");

        $order->save();

        $message = "Transfer proof removed successfully!";
        myFlasherBuilder(message: $message, success: true);

        return redirect("/order/edit_order/" . $order->id);
    }
}
