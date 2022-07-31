<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function my_profile()
    {
        $data["title"] = "My Profile";
        $data["css"] = "profile";

        return view('/profile/my_profile', $data);
    }
}
