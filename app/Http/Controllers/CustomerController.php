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
            ->leftJoin(DB::raw('
        (
            SELECT customer_id, COUNT(DISTINCT order_id) AS total_orders
            FROM orders
            WHERE status = "delivered"
            GROUP BY customer_id
        ) AS delivered_orders
    '), 'customers.id', '=', 'delivered_orders.customer_id')
            ->select('customers.*', DB::raw('COALESCE(delivered_orders.total_orders, 0) as total_orders'))
            ->get();

        // dd($customers  );

        $feedback = DB::table('customers')
            ->join('users', 'customers.email', '=', 'users.email')

            ->join('feedback', 'users.id', '=', 'feedback.user_id')
            ->select('customers.*', 'feedback.user_id', 'feedback.order_id', 'feedback.rating', 'feedback.comment', 'feedback.created_at as feedback_at')
            ->get()
            ->groupBy('email');
        //    dd($feedback);

        // $orders = DB::table('orders')
        //     ->join('users', 'orders.id', '=', 'users.email')

        //     ->get();

        $customersCount = DB::table('customers')->count();

        // dd($customers);

        return view('admin.customer', compact('customers', 'customersCount', 'feedback'));
    }
    public function addCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:customers,email',
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'delivery_location' => 'required|string|max:255',
            'numbers' => 'required|numeric|digits_between:10,15',
        ]);
        $success = DB::table('customers')->insert([
            'email' => $request->email,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'address' => $request->address,
            'delivery_location' => $request->delivery_location,
            'numbers' => $request->numbers,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if ($success) {
            return redirect()->back()->with('success', 'Customer added successfully.');

        }
        return redirect()->back()->with('error', 'Error adding customer. Please try again.');

    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'delivery_location' => 'required|string|max:255',
            'numbers' => 'required|numeric|digits_between:10,15',
        ]);
        // dd($request->all());
        $success = DB::table('customers')
            ->where('id', $id)
            ->update([
                'email' => $request->email,
                'business_name' => $request->business_name,
                'business_type' => $request->business_type,
                'address' => $request->address,
                'delivery_location' => $request->delivery_location,
                'numbers' => $request->numbers,
                'updated_at' => now(),
            ]);
        if ($success) {
            return redirect()->back()->with('success', 'Customer updated successfully.');
        }
        return redirect()->back()->with('error', 'Error updating customer. Please try again.');
    }
    public function destroy($id)
    {
        $customer = DB::table('customers')->where('id', $id)->delete();

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }


        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }
}
