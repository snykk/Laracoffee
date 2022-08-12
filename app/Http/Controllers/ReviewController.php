<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\{User, Product, Review};

class ReviewController extends Controller
{
    public function productReview(User $user, Product $product)
    {
        $title = "Product Review";
        $reviews = $product->review;

        $user = auth()->user();

        if (count($reviews) == 0) {
            $rate = 0;
        } else {
            $rate = $reviews->sum("rating") / count($reviews);
        }

        $isPurchased = $this->isPurchased($user, $product);
        $isReviewed = $this->isReviewed($user, $product);

        $starCounter = [];
        $sum = 0;
        for ($i = 1; $i <= 5; $i++) {
            $total = count(Review::where(["rating" => $i, "product_id" => $product->id])->get());
            array_push($starCounter,  $total);
            $sum += $total;
        }

        return view("/review/product_review", compact("title", "reviews", "product", "rate", "isPurchased", "isReviewed", "starCounter", "sum"));
    }


    public function addReview(Request $request)
    {
        $validatedData = $request->validate([
            "rating" => "required",
            "review" => "required"
        ]);

        $validatedData["user_id"] = auth()->user()->id;
        $validatedData["product_id"] = $request->product_id;
        $validatedData["is_edit"] = 0;

        Review::create($validatedData);

        $message = "Your review has been created!";

        myFlasherBuilder(message: $message, success: true);
        return back();
    }


    public function getDataReview(Review $review)
    {
        return $review;
    }


    public function editReview(Request $request, Review $review)
    {
        $review->fill([
            'rating' => $request->rating,
            'review' => $request->review_edit,
            'is_edit' => 1,
        ]);

        if ($review->isDirty()) {
            $review->save();

            $message = "Your review has been updated!";

            myFlasherBuilder(message: $message, success: true);
            return back();
        } else {
            $message = "Action failed, no changes detected!";

            myFlasherBuilder(message: $message, failed: true);
            return back();
        }
    }


    public function deleteReview(Review $review)
    {
        $review->delete();

        $message = "Your review has been deleted!";

        myFlasherBuilder(message: $message, success: true);
        return back();
    }

    private function isPurchased($user, $product)
    {
        $orders = Order::where(["user_id" => $user->id, "product_id" => $product->id, "is_done" => 1])->get();

        if (count($orders) > 0) {
            return 1;
        }

        return 0;
    }


    private function isReviewed($user, $product)
    {
        $review = Review::where(["user_id" => $user->id, "product_id" => $product->id])->get();

        if (count($review) > 0) {
            return 1;
        }

        return 0;
    }
}
