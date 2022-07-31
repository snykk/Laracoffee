<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginGet()
    {
        return view('auth.login', [
            "title" => "Login",
        ]);
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $message = "Login success";

            myFlasherBuilder(message: $message, success: true);
            return redirect('/home');
        }

        $message = "Wrong credential";

        myFlasherBuilder(message: $message, failed: true);
        return back();
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
            'password' => 'required|confirmed|min:4',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'role_id' => 'required|numeric',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        try {
            User::create($validated);
            $message = "Congratulations, your account has been created!";

            myFlasherBuilder(message: $message, success: true);

            return redirect('/auth/login');
        } catch (\Illuminate\Database\QueryException $exception) {
            $message = "Internal server error!";

            myFlasherBuilder(message: $message, failed: true);

            return redirect('/auth/register');
        }
    }
}
