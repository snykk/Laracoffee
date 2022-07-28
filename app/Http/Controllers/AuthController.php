<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginGet()
    {
        return view('auth.login', [
            "title" => "Login",
        ]);
    }

    public function loginPost()
    {
    }

    public function registrationGet()
    {
        return view('auth.register', [
            "title" => "Registration",
        ]);
    }

    public function registrationPost(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|max:255',
            'username' => 'required|max:15',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'role_id' => 'required|numeric',
        ]);

        dd($request->all());
    }
}
