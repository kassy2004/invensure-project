<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $customers = DB::table('customers')->get();
        $customersCount = DB::table('customers')->count();



        return view('admin.customer', compact('customers', 'customersCount'));
    }
}
