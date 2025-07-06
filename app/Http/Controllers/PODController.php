<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PODController extends Controller
{
    public function index()
    {
        // Get all PODs with basic information
        $pods = DB::table('pod')
            ->join(DB::raw("
        (SELECT *, LPAD(REPLACE(allocation_id, 'ALLOC-', ''), 4, '0') AS clean_allocation_id
         FROM allocations
        ) AS allocations"), 'pod.order_id', '=', 'allocations.clean_allocation_id')
            ->join('truck_loading', 'allocations.allocation_id', '=', 'truck_loading.allocation_id')
            ->join('truck', 'truck_loading.truck_id', '=', 'truck.id')
            ->join('customers', 'allocations.customer_id', '=', 'customers.id')
            ->leftJoin('signature as sig_driver', function ($join) {
                $join->on('pod.pod_number', '=', 'sig_driver.pod_number')
                    ->where('sig_driver.type', '=', 'driver');
            })
            ->leftJoin('signature as sig_customer', function ($join) {
                $join->on('pod.pod_number', '=', 'sig_customer.pod_number')
                    ->where('sig_customer.type', '=', 'customer');
            })
            ->leftJoin('signature as sig_planner', function ($join) {
                $join->on('pod.pod_number', '=', 'sig_planner.pod_number')
                    ->where('sig_planner.type', '=', 'planner');
            })
            ->leftJoin(DB::raw("
        (SELECT LPAD(REPLACE(allocation_id, 'ALLOC-', ''), 4, '0') AS clean_id, COUNT(*) as allocation_count
         FROM allocations
         GROUP BY clean_id
        ) AS alloc_counts
    "), 'pod.order_id', '=', 'alloc_counts.clean_id')

            ->select(
                'pod.*',
                'allocations.allocation_id',
                'truck.id as truck_id',
                'truck.plate_number',
                'truck.driver_name',
                'truck.capacity_kg',
                'truck_loading.loaded_weight',
                'customers.business_name',
                'customers.address',
                'customers.numbers as phone',
                'customers.email',
                'customers.business_type',
                'customers.delivery_location',
                'allocations.customer_id',
                'alloc_counts.allocation_count',

                'sig_driver.signature as driver_signature',
                'sig_driver.name as driver_name',
                'sig_driver.created_at as driver_signed_at',

                // Customer signature
                'sig_customer.signature as customer_signature',
                'sig_customer.name as customer_name',
                'sig_customer.created_at as customer_signed_at',

                // Planner signature
                'sig_planner.signature as planner_signature',
                'sig_planner.name as planner_name',
                'sig_planner.created_at as planner_signed_at'
            )
            ->orderBy('pod.created_at', 'desc')
            ->get()
            ->unique('pod_number');

        // For each POD, fetch all allocation items
        foreach ($pods as $pod) {
            $allocationItems = DB::table('allocations')
                ->where('allocation_id', $pod->allocation_id)
                ->get();

            $items = [];
            $totalQuantity = 0;
            $totalKilogram = 0;

            foreach ($allocationItems as $allocation) {
                $product = null;

                if ($allocation->warehouse === 'pcsi') {
                    $product = DB::table('pcsi_outgoing')
                        ->where('id', $allocation->product_id)
                        ->first();
                } elseif ($allocation->warehouse === 'jfpc') {
                    $product = DB::table('jfpc_outgoing')
                        ->where('id', $allocation->product_id)
                        ->first();
                }

                if ($product) {
                    $items[] = [
                        'particulars' => $product->item_code ?? 'N/A',
                        'quantity' => $product->quantity ?? 0,
                        'kilogram' => $product->kilogram ?? 0
                    ];

                    $totalQuantity += $product->quantity ?? 0;
                    $totalKilogram += $product->kilogram ?? 0;
                }
            }

            $pod->items = $items;
            $pod->total_quantity = $totalQuantity;
            $pod->total_kilogram = $totalKilogram;
        }

        return view('logistic.pod-automation', compact('pods'));
    }
}
