<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\IncomingExport;
use App\Exports\OutgoingExport;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'inventory_manager') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $warehouses = DB::table('warehouses')->get();
        $warehouseName = $request->query('name');
        $warehouse = DB::table('warehouses')
            ->whereRaw('LOWER(warehouse) = ?', [strtolower($warehouseName)])
            ->first();
        $warehouseId = $warehouse ? $warehouse->id : null;
        $warehouse_name = $warehouse ? $warehouse->warehouse : null;


        $item_master = DB::table('item_master')->get();

        // dd($warehouse);
        $inventory = DB::table('incoming')
            ->leftJoin('outgoing', 'outgoing.incoming_id', '=', 'incoming.id')
            ->leftJoin('returns', 'returns.product_id', '=', 'outgoing.id')
            ->where('incoming.warehouse_id', $warehouseId)

            ->where(function ($query) use ($warehouseName) {
                $query->where('returns.warehouse', $warehouseName)
                    ->orWhereNull('returns.warehouse');
            })

            ->select(
                'incoming.id', // This will be your main id
                'incoming.*',
                'outgoing.id as outgoing_id',
                'returns.id as return_id',
                'returns.reason_for_return',
                'returns.created_at as return_date'
            )

            ->get()
            ->unique('id')->values()
        ;
        $outoging = DB::table('outgoing')->get();
        $item_master = DB::table('item_master')->get();

        $inventoryJson = $inventory->toJson();
        $outogingJson = $outoging->toJson();

        $inventory_head = DB::table('incoming')->where('warehouse_id', $warehouseId)->sum('inventory_head');
        $inventory_kilo = DB::table('incoming')->where('warehouse_id', $warehouseId)->sum('inventory_kilo');
        $qty_head = DB::table('incoming')->where('warehouse_id', $warehouseId)->sum('qty_head');
        $qty_kilo = DB::table('incoming')->where('warehouse_id', $warehouseId)->sum('qty_kilo');
        $balance_head = DB::table('incoming')->where('warehouse_id', $warehouseId)->sum('balance_head');
        $balance_kilo = DB::table('incoming')->where('warehouse_id', $warehouseId)->sum('balance_kilo');


        $today = Carbon::today();

        foreach ($inventory as $item) {
            try {

                $expDate = Carbon::parse($item->exp_date);
                $prodDate = Carbon::parse($item->prod_date);


                // Calculate days left
                $daysLeft = $today->diffInDays($expDate, false);

                $status = "";
                Log::info("🧾 Item ID: {$item->id} | Days Left: {$daysLeft}");

                if ($daysLeft <= 0) {
                    $status = 'EXPIRED';
                } elseif ($daysLeft <= 20) {
                    $status = 'EXPIRE SOON';
                } else {
                    $status = 'FG AVAILABLE';
                }
                // Update row
                $success = DB::table('incoming')
                    ->where('id', $item->id)
                    ->where('warehouse_id', $warehouseId)
                    ->update([
                        'left' => $daysLeft,
                        'status' => $status,
                    ]);


            } catch (\Exception $e) {
                Log::warning("Failed to parse exp_date for ID {$item->id}: {$item->exp_date} - {$e->getMessage()}");
            }
        }
        $soonToExpireItems = DB::table('incoming')
            ->where('warehouse_id', $warehouseId)
            ->whereDate('exp_date', '>', $today)
            ->whereDate('exp_date', '<=', $today->copy()->addDays(20))
            ->get();

        foreach ($soonToExpireItems as $item) {
            // Avoid duplicate notifications (optional, based on your design)
            $existing = DB::table('notifications')
                ->where('message', 'like', "%Item: {$item->id}. {$item->item_code}%")
                // ->whereNull('read_at')
                ->exists();

            if (!$existing) {
                DB::table('notifications')->insert([
                    'title' => 'Item Expiry Warning',
                    'message' => "Item: {$item->id}. {$item->item_code} (SKU: {$item->sku}) will expire on {$item->exp_date}.",
                    'type' => 'warning',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        }

        $expiredItems = DB::table('incoming')
            ->where('warehouse_id', $warehouseId)
            ->where('status', 'EXPIRED')
            ->get();




        foreach ($expiredItems as $item) {
            // Avoid duplicate notifications (optional, based on your design)
            $existing = DB::table('notifications')
                ->where('title', 'Item Expired')
                ->where('message', 'like', "%Item: {$item->id}. {$item->item_code}%")
                // ->whereNull('read_at')
                ->exists();

            if (!$existing) {
                DB::table('notifications')->insert([
                    'user_id' => auth()->id(),
                    'for' => 'inventory_manager',
                    'title' => 'Item Expired on' . $warehouseName . 'Warehouse',
                    'message' => "Item: {$item->id}. {$item->item_code} (SKU: {$item->sku}) has expired",
                    'type' => 'error',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $notifications = DB::table('notifications')->get();
        $expiring = DB::table('incoming')
            ->where('warehouse_id', $warehouseId)
            ->where('status', 'EXPIRE SOON')
            ->count();
        $available = DB::table('incoming')->where('warehouse_id', $warehouseId)
            ->where('status', 'FG AVAILABLE')
            ->count();

        $expiringItem = DB::table('incoming')->where('warehouse_id', $warehouseId)
            ->where('status', 'EXPIRE SOON')
            ->get();
        $availableItem = DB::table('incoming')->where('warehouse_id', $warehouseId)
            ->where('status', 'FG AVAILABLE')
            ->get();

        $customer = DB::table('customers')
            ->get();

        $pod = DB::table('pod')
            ->join('orders', 'pod.order_id', '=', 'orders.order_id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('truck_loading', DB::raw("REPLACE(truck_loading.allocation_id, 'ALLOC-', '')"), '=', 'orders.order_id')
            ->join('truck', 'truck_loading.truck_id', '=', 'truck.id')
            ->where('pod.status', 'completed')
            ->where('pod.warehouse_id', $warehouseId)

            ->selectRaw('
    pod.pod_number,
    pod.id,
    pod.updated_at as date_delivered,
    orders.order_id,
    GROUP_CONCAT(DISTINCT orders.product_id) as product_ids,
    customers.business_name,
    customers.delivery_location,
    customers.numbers,
    customers.email,
    truck_loading.id as loading_id,
    truck.driver_name,
    truck.plate_number,
    truck.id as truck_id
')
            ->groupBy('pod.pod_number', 'customers.delivery_location', 'pod.id', 'orders.order_id', 'date_delivered', 'customers.business_name', 'truck_loading.id', 'truck.driver_name', 'customers.numbers', 'customers.email', 'truck.plate_number', 'truck.id')
            ->get();



        foreach ($pod as $pods) {
            // Convert comma-separated string to array
            $productIdsArray = explode(',', $pods->product_ids);

            // Fetch matching pcsi_outgoing records
            $pods->pcsi_outgoing = DB::table('outgoing')
                ->where('warehouse_id', $warehouseId)
                ->whereIn('id', $productIdsArray)
                ->get();
            $pods->signatures = DB::table('signature')
                ->where('pod_number', $pods->pod_number)
                ->get();
        }

        return view('inventory-manager.warehouses.inventory', compact('inventoryJson', 'warehouse_name', 'item_master', 'warehouseId', 'inventory_head', 'inventory_kilo', 'qty_head', 'qty_kilo', 'balance_head', 'balance_kilo', 'expiring', 'available', 'expiringItem', 'availableItem', 'item_master', 'notifications', 'outoging', 'outogingJson', 'inventory', 'customer', 'pod'));


    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'warehouse' => 'required|string|max:255',
            'location' => 'required|string|max:255',

        ]);

        $success = DB::table('warehouses')
            ->insert([
                'warehouse' => $validated['warehouse'],
                'location' => $validated['location'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        if (!$success) {
            return redirect()->back()->with('error', 'Failed to add warehouse.');
        }


        return redirect()->back()->with('success', 'Warehouse added successfully!');
    }

    public function addInventory(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'warehouse_id' => 'required|numeric',
            'item_master_id' => 'required|numeric',
            'prod_date' => 'required|date',
            'inventory_head' => 'nullable|numeric',
            'inventory_kilo' => 'nullable|numeric',
        ]);
        $warehouse = DB::table('warehouses')
            ->where('id', $validated['warehouse_id'])
            ->value('warehouse');



        $itemMaster = DB::table('item_master')
            ->select('item', 'new_mrp_code', 'item_group', 'variant', 'kilogram_tray', 'class', 'sku', 'fg', 'primary_packaging', 'secondary_packaging')
            ->where('id', $validated['item_master_id'])
            ->first();

        $prodDate = Carbon::parse($validated['prod_date']);
        $expirationStage = (int) DB::table('item_master')
            ->where('id', $request->input('item_master_id'))
            ->value('expiration_stage');
        $today = Carbon::today();

        try {
            $expDate = $prodDate->copy()->addMonths($expirationStage);
            $formattedExpDate = $expDate->format('Y-m-d');
            $daysLeft = (int) $today->diffInDays($formattedExpDate, false);

            $result = DB::table('incoming')
                ->insert([
                    'warehouse_id' => $validated['warehouse_id'],
                    'data_entry' => $itemMaster->item,
                    'item_group' => $itemMaster->item_group,
                    'item_code' => $itemMaster->new_mrp_code,
                    'variant' => $itemMaster->variant ?? null,
                    'kilogram_tray' => $itemMaster->kilogram_tray,
                    'class' => $itemMaster->class,
                    'sku' => $itemMaster->sku ?? null,
                    'fg' => $itemMaster->fg ?? null,
                    'primary_packaging' => $itemMaster->primary_packaging ?? null,
                    'secondary_packaging' => $itemMaster->secondary_packaging ?? null,
                    'prod_date' => $validated['prod_date'],
                    'exp_date' => $formattedExpDate,
                    'left' => $daysLeft,
                    'inventory_head' => $validated['inventory_head'] ?? null,
                    'balance_head' => $validated['inventory_head'] ?? null,
                    'balance_kilo' => $validated['inventory_kilo'] ?? null,
                    'inventory_kilo' => $validated['inventory_kilo'] ?? null,
                    'created_at' => now(),
                ]);
            $user = Auth::user();

            \OwenIt\Auditing\Models\Audit::create([
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'event' => 'Added Item to ' . $warehouse . ' Warehouse',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->id,
                'old_values' => [],
                'new_values' => ['status' => 'Inventory Manager added item to ' . $warehouse . ' Warehouse'],
                'url' => url()->current(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
            if ($result) {
                return redirect()->back()->with('success', 'Item added successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to add item.');
            }


        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding item: ' . $e->getMessage());
        }
    }

    public function ship(Request $request)
    {



        try {
            $validated = $request->validate([
                'item_id' => 'required|numeric',
                'warehouse_id' => 'required|numeric',
                'customer' => 'nullable|string|max:255',
                'cm_code' => 'nullable|string|max:255',
                'production_date' => 'required|date',
                'transaction_date' => 'required|date',
                'description' => 'string|max:255',
                'cm_category' => 'string|max:255',
                'quantity' => 'required|numeric',
                'kilogram' => 'required|numeric',
                'remarks' => 'nullable|string|max:255',


            ]);
            $warehouse = DB::table('warehouses')->where('id', $validated['warehouse_id'])->value('warehouse');

            $incoming = DB::table('incoming')
                ->select('item_code', 'sku', 'primary_packaging', 'secondary_packaging', 'variant', 'item_group')
                ->where('warehouse_id', $validated['warehouse_id'])
                ->where('id', $validated['item_id'])
                ->first();


            if (!$incoming) {
                return back()->withErrors(['item_id' => 'Selected item not found.']);
            }

            DB::table('incoming')
                ->where('warehouse_id', $validated['warehouse_id'])
                ->where('id', $validated['item_id'])
                ->update([
                    'qty_head' => $validated['quantity'],
                    'qty_kilo' => $validated['kilogram'],
                    'balance_head' => DB::raw('inventory_head - ' . $validated['quantity']),
                    'balance_kilo' => DB::raw('inventory_kilo - ' . $validated['kilogram']),
                ]);

            DB::table('outgoing')->insert([
                'warehouse_id' => $validated['warehouse_id'],
                'incoming_id' => $validated['item_id'],

                'transaction_date' => $validated['transaction_date'],
                'customer' => $validated['customer'],
                'cm_code' => $validated['cm_code'],
                'item_code' => $incoming->item_code,
                'description' => $validated['description'],
                'sku_description' => $incoming->sku,
                'primary_packaging' => $incoming->primary_packaging,
                'secondary_packaging' => $incoming->secondary_packaging,
                'cm_category' => $validated['cm_category'],
                'product_category' => $incoming->item_group,
                'variant' => $incoming->variant,
                'production' => $validated['production_date'],
                'quantity' => $validated['quantity'],
                'kilogram' => $validated['kilogram'],
                'remarks' => $validated['remarks'],

            ]);
            $user = Auth::user();

            \OwenIt\Auditing\Models\Audit::create([
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'event' => 'Shipped ' . $incoming->item_code . ' from '. $warehouse.' Warehouse',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->id,
                'old_values' => [],
                'new_values' => ['item' => $incoming->item_code],
                'url' => url()->current(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
            return redirect()->back()->with('success', 'Item successfully shipped.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    public function exportIncoming(Request $request)
    {
        $warehouseId = $request->query('warehouse_id');
        $warehouseName = DB::table('warehouses')
            ->where('id', $warehouseId)
            ->value('warehouse');
        return Excel::download(new IncomingExport($warehouseId), 'incoming_' . $warehouseName . '_warehouse.xlsx');

    }
    public function exportOutgoing(Request $request)
    {
        $warehouseId = $request->query('warehouse_id');
        $warehouseName = DB::table('warehouses')
            ->where('id', $warehouseId)
            ->value('warehouse');
        return Excel::download(new OutgoingExport($warehouseId), 'outgoing_' . $warehouseName .'_warehouse.xlsx');
    }
   


}
