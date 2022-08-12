<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $title = "Transaction List";
        $transactions = Transaction::with("category")->get();

        return view("/transaction/index", compact("title", "transactions"));
    }


    public function addOutcomeGet()
    {
        $title = "Add Outcome";
        $categories = Category::where("id", "!=", 1)->get();

        return view("/transaction/add_outcome", compact("title", "categories"));
    }


    public function addOutcomePost(Request $request)
    {
        $validatedData = $request->validate(
            [
                "category_id" => "required|numeric|gt:0",
                "outcome" => "required|numeric|gt:0",
                "description" => "required"
            ],
            [
                "category_id.gt" => "Please select the category"
            ]
        );

        Transaction::create($validatedData);

        $message = "Transaction created successfully!";

        myFlasherBuilder(message: $message, success: true);

        return redirect("/transaction");
    }


    public function editOutcomeGet(Transaction $transaction)
    {
        $title = "Edit Outcome";
        $transaction->load("category");
        $categories = Category::where("id", "!=", 1)->get();

        return view("/transaction/edit_outcome", compact("title", "transaction", "categories"));
    }

    public function editOutcomePost(Request $request, Transaction $transaction)
    {
        $validatedData = $request->validate(
            [
                "category_id" => "required|numeric|gt:0",
                "outcome" => "required|numeric|gt:0",
                "description" => "required"
            ],
            [
                "category_id.gt" => "Please select the category"
            ]
        );

        $transaction->fill($validatedData);

        if ($transaction->isDirty()) {
            $transaction->save();


            $message = "Transaction updated successfully!";

            myFlasherBuilder(message: $message, success: true);

            return redirect("/transaction");
        } else {
            $message = "Action failed, no changes detected!";

            myFlasherBuilder(message: $message, failed: true);

            return back();
        }
    }
}
