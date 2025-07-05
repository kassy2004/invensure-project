<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {

        $orders = DB::table('orders')
          
            ->get();
        $printedKeys = [];
        $filteredOrders = [];


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
            $filteredOrders[] = $order;
            $printedKeys[] = $key;
        }

        return view('customer.orders', ['order' => $filteredOrders]);
    }
}
