<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $customers = DB::table("users")->where("id", 2)->get();
        return view("home/customers", [
            "title" => "Customers",
            "customers" => $customers,
        ]);
    }
}
