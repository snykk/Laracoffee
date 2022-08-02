<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Middleware\Authorize;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            "title" => "Home",
        ]);
    }

    public function customers()
    {
        $this->authorize("is_admin");

        // $customers = DB::table("users")->where("role_id", ROLE::IS_CUSTOMER)->get();
        $customers = User::with("role")->get();

        return view("home/customers", [
            "title" => "Customers",
            "customers" => $customers,
        ]);
    }
}
