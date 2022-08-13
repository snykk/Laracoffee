<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function user_point(User $user)
    {
        $title = "User Point";

        return view("/point/user_point", compact("title"));
    }

    public function convert_point(User $user)
    {
        $user = auth()->user();
        if ($user->point >= 50) {
            $user->coupon = $user->coupon + 1;
            $user->point = $user->point - 50;
            $user->save();

            $message = "Point converted successfully";

            myFlasherBuilder(message: $message, success: true);
            return back();
        } else {
            $message = "Action <strong>failed</strong>, point is not enough";

            myFlasherBuilder(message: $message, failed: true);
            return back();
        }
    }
}
