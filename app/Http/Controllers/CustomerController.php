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

        $customers = DB::table('customers')
            ->get();

        $feedback = DB::table('customers')
            ->join('users', 'customers.email', '=', 'users.email')

            ->join('feedback', 'users.id', '=', 'feedback.user_id')
            ->select('customers.*', 'feedback.user_id', 'feedback.order_id', 'feedback.rating', 'feedback.comment', 'feedback.created_at as feedback_at')
            ->get()
             ->groupBy('email');
    //    dd($feedback);
        $customersCount = DB::table('customers')->count();

        // dd($customers);

        return view('admin.customer', compact('customers', 'customersCount', 'feedback'));
    }
}
