<?php

namespace App\Http\Controllers;

use App\Models\{Role, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Middleware\Authorize;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";

        return view("/home/index", compact("title"));
    }

    public function customers()
    {
        $this->authorize("is_admin");

        $title = "Customers";
        $customers = User::with("role")->get();

        return view("home/customers",  compact("title", "customers"));
    }
}
