<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

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

        $customers = DB::table("users")->where("role_id", ROLE::IS_CUSTOMER)->get();

        return view("home/customers", [
            "title" => "Customers",
            "customers" => $customers,
        ]);
    }
}
