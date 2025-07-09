<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnItemController extends Controller
{
    public function index()
    {
        $returns = DB::table('returns')->get();

        $returnsJson = $returns->toJson();

        return view('inventory-manager.return-item', compact('returns'));
    }
    public function submitRequest(Request $request)
    {
        // dd($request->all());
        $reason = $request->input('reason');
        $email = auth()->user()->email;
        $order_id = $request->input('order_id');
        $comments = $request->input('comments');


        $customer = DB::table('customers')
            ->where('email', $email)
            ->first();

        $warehouse = DB::table('orders')
            ->where('order_id', $order_id)
            ->first();

        // $orders = DB::table('orders')
        //     ->where('order_id', $order_id)
        //     ->get();


        $success = DB::table('returns')
            ->insert([
                'customer' => $customer->business_name,
                'reason_for_return' => $reason,
                'others' => $comments,
                'pod_number' => $order_id,
                'status' => 'pending',
                'warehouse' => $warehouse->warehouse,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        if (!$success) {
            return redirect()->back()->with('error', 'Error: Failed to request a return.');
        }

        return redirect()->back()->with('success', 'Thank you. Your return request for this order has been submitted and is under review.');


    }

    public function approveRequest(Request $request, $id)
    {
        $return = DB::table('returns')->where('id', $id)->first();



        if (!$return) {
            return redirect()->back()->with('error', 'Return request not found.');
        }

       $customer =  DB::table('customers')
        ->where('business_name', $return->customer)
        ->first();

        $user_id = DB::table('users')
            ->where('email', $customer->email)
            ->first();

        DB::table('returns')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'updated_at' => now(),
            ]);

        DB::table('notifications')
            ->insert([
                'user_id' => $user_id->id,
                'title' => 'Return Request Approved for POD #' . $return->pod_number,
                'message' => 'The return request associated with POD #' . $return->pod_number . ' has been successfully approved.',
                'for' => $return->customer,
                'type' => 'success',
            ]);


        return redirect()->back()->with('success', 'Return request approved successfully.');
    }

    public function rejectRequest(Request $request, $id)
    {
        $return = DB::table('returns')->where('id', $id)->first();



        if (!$return) {
            return redirect()->back()->with('error', 'Return request not found.');
        }

        $customer = DB::table('customers')
            ->where('business_name', $return->customer)
            ->first();

        $user_id = DB::table('users')
            ->where('email', $customer->email)
            ->first();

        DB::table('returns')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'updated_at' => now(),
            ]);

        DB::table('notifications')
            ->insert([
                'user_id' => $user_id->id,
                'title' => 'We’re sorry — Return Request Rejected for POD #' . $return->pod_number,
                'message' => 'Unfortunately, your return request for POD #' . $return->pod_number . ' was not approved. Please contact support if you have any questions.',
                'for' => $return->customer,
                'type' => 'error',
            ]);


            return redirect()->back()->with('success', 'You’ve successfully rejected the return request. The customer will be informed accordingly.');

    }
}
