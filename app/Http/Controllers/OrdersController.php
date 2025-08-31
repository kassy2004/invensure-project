<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class OrdersController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role !== 'customer') {
            return redirect()->back()->with('error', 'Access denied. Only customers can view orders.');
        }

        $orders = DB::table('orders')

            ->get();
        $printedKeys = [];
        $filteredOrders = [];

        $returnPodNumbers = DB::table('returns')->pluck('pod_number')->toArray();

        foreach ($orders as $order) {
            $customer = DB::table('customers')
                ->where('email', Auth::user()->email)
                ->where('id', $order->customer_id)
                ->first();

            if (!$customer)
                continue;

            $transaction = null;
            if ($order->warehouse === 'pcsi') {
                $transaction = DB::table('pcsi_outgoing')->where('id', $order->product_id)->select('transaction_date')->first();
            } elseif ($order->warehouse === 'jfpc') {
                $transaction = DB::table('jfpc_outgoing')->where('id', $order->product_id)->select('transaction_date')->first();
            }
            if (!$transaction)
                continue;


            $transactionDate = date('Y-m-d', strtotime($transaction->transaction_date));

            $key = $order->customer_id . '_' . $transactionDate . '_' . $order->warehouse;

            // Skip if already printed this customer+date combo
            if (in_array($key, $printedKeys)) {
                continue;
            }

            $combinedProducts = DB::table('pcsi_outgoing')
                ->select('*')
                ->where('customer', $customer->business_name)
                ->whereDate('transaction_date', $transactionDate)
                ->unionAll(
                    DB::table('jfpc_outgoing')
                        ->select('*')
                        ->where('customer', $customer->business_name)
                        ->whereDate('transaction_date', $transactionDate)
                )
                ->get();
            $order->products = $combinedProducts;
            $order->transaction_date = $transactionDate;
            $order->order_count = $combinedProducts->count();
            $order->has_return = in_array($order->order_id, $returnPodNumbers);

            $feedback = DB::table('feedback')
                ->where('order_id', $order->order_id)
                ->first();

            $order->has_feedback = !is_null($feedback);
            $order->feedback_data = $feedback;


            $order->can_request_return = false;
                

            if ($order->status === 'delivered' && $order->updated_at) {
                $deliveredAt = Carbon::parse($order->updated_at);
                $hoursDiff = $deliveredAt->diffInHours(now(), false);
                // dd($hoursDiff);
                $order->can_request_return = $hoursDiff <= 12 && $hoursDiff >= 0;
            }

            $return = DB::table('returns')
            ->where('customer', $customer->business_name)
            ->where('pod_number', $order->order_id)->first();
            $order->return_data = $return;


            // dd( $order->return_data);
            $filteredOrders[] = $order;
            $printedKeys[] = $key;

        }

        // dd($filteredOrders);
        return view('customer.orders', [
            'order' => $filteredOrders,
        ]);
    }
}
