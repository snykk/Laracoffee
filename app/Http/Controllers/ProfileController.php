<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\ValidatedData;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $data["title"] = "My Profile";
        $data["css"] = "profile";

        return view('/profile/my_profile', $data);
    }

    public function editProfileGet()
    {
        $data["title"] = "Edit Profile";
        $data["css"] = "profile";

        return view("/profile/edit_profile", $data);
    }

    public function editProfilePost(Request $request, User $user)
    {
        $rules = [
            'fullname' => 'required|max:255',
            'phone' => 'required|numeric',
            'address' => 'required',
        ];


        if (auth()->user()->username != $request->username) {
            $rules['username'] = 'required|max:15|unique:users,username';
        } else {
            $rules['username'] = 'required|max:15';
        }

        if ($request->file("image")) {
            $rules["image"] = "image|file|max:2048";
        }

        $validatedData = $request->validate($rules);

        $path = "";
        if ($request->file("image")) {
            $path = Storage::putFile('profile', $request->file('image'));
            $validatedData["image"] = $path;
        }

        try {
            if ($request->file("image")) {
                if ($request->oldImage != env("DEFAULT_IMAGE_PROFILE")) {
                    Storage::delete($request->oldImage);
                }

                $validatedData["image"] = $request->file("image")->store("profile");
            }

            $user->fill($validatedData);

            if ($user->isDirty()) {
                $user->save();

                $message = "Your profile has been updated!";

                myFlasherBuilder(message: $message, success: true);
                return redirect("/home");
            } else {
                $message = "Action <strong>failed</strong>, no changes detected!";

                myFlasherBuilder(message: $message, failed: true);
                return redirect("/profile/edit_profile");
            }
        } catch (Exception $exception) {
            return abort(500);
        }
    }
}
