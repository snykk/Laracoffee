<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash, Storage};
use Illuminate\Contracts\Support\ValidatedData;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $title = "My Profile";

        return view('/profile/my_profile', compact("title"));
    }


    public function editProfileGet()
    {
        $title = "Edit Profile";

        return view("/profile/edit_profile", compact("title"));
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

        try {
            if ($request->file("image")) {
                if ($request->oldImage != env("IMAGE_PROFILE")) {
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


    public function changePasswordGet()
    {
        $title = "Change Password";

        return view("/profile/change_password", compact("title"));
    }


    public function changePasswordPost(Request $request)
    {
        $validated = $request->validate([
            "current_password" => "required|min:4",
            "password" => "required|confirmed|min:4",
            "password_confirmation" => "required|min:4",
        ]);

        if (!(Hash::check($request->current_password, auth()->user()->password))) {
            $message = "Current password is wrong!";

            myFlasherBuilder(message: $message, failed: true);
            return back();
        } else if ($request->current_password == $request->password) {
            $message = "Current password cannot be the same as new password!";

            myFlasherBuilder(message: $message, failed: true);
            return back();
        }

        User::where('id', auth()->user()->id)
            ->update(['password' => Hash::make($validated['password'])]);

        $message = "Password has been updated";

        myFlasherBuilder(message: $message, success: true);
        return redirect("/home");
    }
}
