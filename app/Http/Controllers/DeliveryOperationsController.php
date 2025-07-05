<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
class DeliveryOperationsController extends Controller
{
    public function index(Request $request)
    {
        $allocations = $this->getFilteredAllocations();

        $perPage = 5;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $paginated = new LengthAwarePaginator(
            array_slice($allocations, $offset, $perPage),
            count($allocations),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        $truck_loading = DB::table('truck_loading')
            ->join('truck', 'truck_loading.truck_id', '=', 'truck.id')
            ->join('allocations', 'truck_loading.allocation_id', '=', 'allocations.allocation_id')
            ->join('customers', 'allocations.customer_id', '=', 'customers.id')
            ->select(
                'truck_loading.truck_id',
                'truck_loading.allocation_id as alloc_id',
                'truck_loading.loaded_weight',
                'truck_loading.status',
                'truck_loading.created_at',
                'truck.plate_number',
                'truck.driver_name',
                'truck.capacity_kg',
                'truck.driver_contact',
                'customers.business_name',
                'customers.address',
                DB::raw('COUNT(DISTINCT allocations.allocation_id) as allocation_count')
            )
            ->groupBy(
                'truck_loading.truck_id',
                'truck_loading.allocation_id',
                'truck_loading.loaded_weight',
                'truck_loading.status',
                'truck_loading.created_at',
                'truck.plate_number',
                'truck.driver_name',
                'truck.capacity_kg',
                'truck.driver_contact',
                'customers.business_name',
                'customers.address',

            )
            ->get();
        if ($request->ajax()) {
            return view('logistic.partials._allocations', ['allocations' => $paginated])->render();
        }

        return view('logistic.delivery-operations', ['allocations' => $paginated, 'truck_loading' => $truck_loading]);
    }

    private function getFilteredAllocations()
    {
        // ... your original logic from index, return array of filtered allocations
        // $transactionDate = date('Y-m-d', strtotime($item->transaction_date));
        $outgoingOrders = DB::table('pcsi_outgoing')
            // ->whereDate('transaction_date', $transactionDate)
            ->get();

        $outgoingJfpcOrders = DB::table('jfpc_outgoing')
            ->get();
        $latest = DB::table('allocations')
            ->orderByDesc('allocation_id')
            ->value('allocation_id');

        $nextNumber = $latest
            ? intval(str_replace('ALLOC-', '', $latest)) + 1
            : 1;
        $groupedOrders = collect($outgoingOrders)->groupBy(function ($item) {
            return $item->customer . '_' . date('Y-m-d', strtotime($item->transaction_date)) . '_pcsi';
        });

        $groupedJfpcOrders = collect($outgoingJfpcOrders)->groupBy(function ($item) {
            return $item->customer . '_' . date('Y-m-d', strtotime($item->transaction_date)) . '_jfpc';
        });


        foreach ($groupedOrders as $key => $orders) {
            $firstOrder = $orders->first();

            $customer = DB::table('customers')->where('business_name', $firstOrder->customer)->first();
            if (!$customer)
                continue;

            // Generate allocation group ID
            $allocationId = 'ALLOC-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $nextNumber++; // Increment for the next group 

            foreach ($orders as $order) {
                $exists = DB::table('allocations')
                    ->where('product_id', $order->id)
                    ->where('warehouse', 'pcsi')
                    ->exists();

                if (!$exists) {
                    DB::table('allocations')->insert([
                        'allocation_id' => $allocationId,
                        'customer_id' => $customer->id,
                        'product_id' => $order->id,
                        'warehouse' => 'pcsi',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $ordersexists = DB::table('orders')
                    ->where('product_id', $order->id)
                    ->where('warehouse', 'pcsi')
                    ->exists();

                if (!$ordersexists) {
                    DB::table('orders')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $order->id,
                        'warehouse' => 'pcsi',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        foreach ($groupedJfpcOrders as $key => $order) {
            $firstOrder = $order->first();

            $customer = DB::table('customers')->where('business_name', $firstOrder->customer)->first();
            if (!$customer)
                continue;
            // Generate allocation group ID
            $allocationId = 'ALLOC-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $nextNumber++; // Increment for the next group 




            foreach ($order as $jfpcorder) {
                $jfpcexists = DB::table('allocations')
                    ->where('product_id', $jfpcorder->id)
                    ->where('warehouse', 'jfpc')
                    ->exists();

                if (!$jfpcexists) {
                    DB::table('allocations')->insert([
                        'allocation_id' => $allocationId,
                        'customer_id' => $customer->id,
                        'product_id' => $jfpcorder->id,
                        'warehouse' => 'jfpc',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $jfpcordersexists = DB::table('orders')
                    ->where('product_id', $jfpcorder->id)
                    ->where('warehouse', 'jfpc')
                    ->exists();

                if (!$jfpcordersexists) {
                    DB::table('orders')->insert([
                        'customer_id' => $customer->id,
                        'product_id' => $jfpcorder->id,
                        'warehouse' => 'jfpc',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        $allocations = DB::table('allocations')
            ->get();
        // dd($allocations);

        $printedKeys = [];
        $filteredAllocations = [];

        foreach ($allocations as $allocation) {

            $customer = DB::table('customers')
                ->where('id', $allocation->customer_id)
                ->first();

            if (!$customer)
                continue;

            $transaction = null;
            if ($allocation->warehouse === 'pcsi') {
                $transaction = DB::table('pcsi_outgoing')->where('id', $allocation->product_id)->select('transaction_date')->first();
            } elseif ($allocation->warehouse === 'jfpc') {
                $transaction = DB::table('jfpc_outgoing')->where('id', $allocation->product_id)->select('transaction_date')->first();
            }
            if (!$transaction)
                continue;

            $transactionDate = date('Y-m-d', strtotime($transaction->transaction_date));

            $key = $allocation->customer_id . '_' . $transactionDate . '_' . $allocation->warehouse;

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


            $allocation->truck = DB::table('truck')->get();


            // $allocation->truck_loading = DB::table('truck_loading')
            //     ->where('allocation_id', $allocation->allocation_id)
            //     ->get();
            // // foreach ($allocation->truck_loading as $loading) {
            // //     $loading->truck_driver = DB::table('truck')
            // //         ->where('id', $loading->truck_id)
            // //         ->first();
            // // }
            // foreach ($allocation->truck_loading as $loading) {
            //     $loading->truck_driver = DB::table('truck')
            //         ->where('id', $loading->truck_id)
            //         ->first();
            // }
            // if ($allocation->truck_loading) {
            //     $allocation->truck_driver = DB::table('truck')
            //         ->where('id', $allocation->truck_loading->truck_id)
            //         ->first();
            // } else {
            //     $allocation->truck_driver = null;
            // }


            $allocation->products = $combinedProducts;
            $allocation->customer_name = $customer->business_name;
            $allocation->address = $customer->address;
            $allocation->numbers = $customer->numbers;
            $allocation->transaction_date = $transactionDate;
            $allocation->total_quantity = $combinedProducts->sum('quantity');
            $allocation->total_kilogram = $combinedProducts->sum('kilogram');
            $allocation->order_count = $combinedProducts->count();

            $filteredAllocations[] = $allocation;
            $printedKeys[] = $key;



        }

        return $filteredAllocations;
    }

    public function load(Request $request)
    {
        $allocationId = $request->input('allocation_id');

        $allocations = DB::table('allocations')->where('allocation_id', $allocationId)->get();

        $totalKg = 0;

        foreach ($allocations as $alloc) {
            $product = null;


            if ($alloc->warehouse === 'pcsi') {
                $product = DB::table('pcsi_outgoing')->where('id', $alloc->product_id)->first();
            } elseif ($alloc->warehouse === 'jfpc') {
                $product = DB::table('jfpc_outgoing')->where('id', $alloc->product_id)->first();
            }

            if ($product && isset($product->kilogram)) {
                $totalKg += $product->kilogram;
            }

            DB::table('orders')
                ->where('product_id', $alloc->product_id)
                ->update(['status' => 'in transit']);

            DB::table('allocations')
                ->where('product_id', $alloc->product_id)
                ->update(['status' => 'in transit']);

        }
        // dd($totalKg);

        $result = DB::table('truck_loading')
            ->insert([
                'truck_id' => $request->input('truck_id'),
                'allocation_id' => $request->input('allocation_id'),
                'loaded_weight' => $totalKg,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


        if ($product && isset($product->kilogram)) {
            $totalKg += $product->kilogram;
        }

        if ($result) {
            return redirect()->back()->with('success', 'Truck loading added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add truck loading.');
        }


    }


}

