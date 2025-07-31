<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Exports\PCSIIncomingExport;
use App\Exports\PCSIOutgingExport;
use Maatwebsite\Excel\Facades\Excel;
class InventoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'inventory_manager') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $inventory = DB::table('pcsi_incoming')->get();


        $outoging = DB::table('pcsi_outgoing')->get();
        $item_master = DB::table('item_master')->get();

        // Debug: Log the count of items
        Log::info('Item master count: ' . $item_master->count());
        // dd($item_master);
        $inventoryJson = $inventory->toJson();
        $outogingJson = $outoging->toJson();

        $inventory_head = DB::table('pcsi_incoming')->sum('inventory_head');
        $inventory_kilo = DB::table('pcsi_incoming')->sum('inventory_kilo');
        $qty_head = DB::table('pcsi_incoming')->sum('qty_head');
        $qty_kilo = DB::table('pcsi_incoming')->sum('qty_kilo');
        $balance_head = DB::table('pcsi_incoming')->sum('balance_head');
        $balance_kilo = DB::table('pcsi_incoming')->sum('balance_kilo');

        $today = Carbon::today();
        foreach ($inventory as $item) {
            try {


                // Parse using format 'd-M-y'
                $expDate = Carbon::parse($item->exp_date);
                $prodDate = Carbon::parse($item->prod_date);


                // Calculate days left
                $daysLeft = $today->diffInDays($expDate, false);

                // $status = $daysLeft <= 20 ? 'EXPIRE SOON' : 'FG AVAILABLE';

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
                $success = DB::table('pcsi_incoming')
                    ->where('id', $item->id)
                    ->update([
                        'left' => $daysLeft,
                        'status' => $status,
                    ]);




            } catch (\Exception $e) {
                Log::warning("Failed to parse exp_date for ID {$item->id}: {$item->exp_date} - {$e->getMessage()}");
            }
        }
        $soonToExpireItems = DB::table('pcsi_incoming')
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


        $expiredItems = DB::table('pcsi_incoming')
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
                    'title' => 'Item Expired',
                    'message' => "Item: {$item->id}. {$item->item_code} (SKU: {$item->sku}) has expired",
                    'type' => 'error',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $notifications = DB::table('notifications')->get();
        // dd($notifications);

        $expiring = DB::table('pcsi_incoming')
            ->where('status', 'EXPIRE SOON')
            ->count();
        $available = DB::table('pcsi_incoming')
            ->where('status', 'FG AVAILABLE')
            ->count();

        $expiringItem = DB::table('pcsi_incoming')
            ->where('status', 'EXPIRE SOON')
            ->get();
        $availableItem = DB::table('pcsi_incoming')
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
            ->groupBy('pod.pod_number', 'customers.delivery_location', 'pod.id', 'orders.order_id', 'date_delivered', 'customers.business_name', 'truck_loading.id', 'truck.driver_name' , 'customers.numbers', 'customers.email', 'truck.plate_number', 'truck.id')
            ->get();
        foreach ($pod as $pods) {
            // Convert comma-separated string to array
            $productIdsArray = explode(',', $pods->product_ids);

            // Fetch matching pcsi_outgoing records
            $pods->pcsi_outgoing = DB::table('pcsi_outgoing')
                ->whereIn('id', $productIdsArray)
                ->get();
            $pods->signatures = DB::table('signature')
                ->where('pod_number', $pods->pod_number)
                ->get();
        }
        // dd($pod);


        return view('inventory-manager.pcsi', compact('inventoryJson', 'inventory_head', 'inventory_kilo', 'qty_head', 'qty_kilo', 'balance_head', 'balance_kilo', 'expiring', 'available', 'expiringItem', 'availableItem', 'item_master', 'notifications', 'outoging', 'outogingJson', 'inventory', 'customer', 'pod'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'item_master_id' => 'required|numeric',
            'prod_date' => 'required|date',
            'inventory_head' => 'nullable|numeric',
            'inventory_kilo' => 'nullable|numeric',
        ]);

        $itemMaster = DB::table('item_master')
            ->select('item', 'new_mrp_code', 'item_group', 'variant', 'kilogram_tray', 'class', 'sku', 'fg', 'primary_packaging', 'secondary_packaging')
            ->first();

        $prodDate = Carbon::parse($request->input('prod_date'));
        $expirationStage = (int) DB::table('item_master')
            ->where('id', $request->input('item_master_id'))
            ->value('expiration_stage');
        $today = Carbon::today();


        try {


            $expDate = $prodDate->copy()->addMonths($expirationStage);
            $formattedExpDate = $expDate->format('Y-m-d');
            $daysLeft = (int) $today->diffInDays($formattedExpDate, false);


            $result = DB::table('pcsi_incoming')->insert([
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
                'inventory_kilo' => $validated['inventory_kilo'] ?? null,
                'created_at' => now(),
            ]);
            $user = Auth::user();

            \OwenIt\Auditing\Models\Audit::create([
                'user_type' => get_class($user),
                'user_id' => $user->id,
                'event' => 'Added Item to  PCSI Warehouse',
                'auditable_type' => get_class($user),
                'auditable_id' => $user->id,
                'old_values' => [],
                'new_values' => ['status' => 'Inventory Manager added item to PCSI Warehouse'],
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
            Log::error('Error adding item to PCSI: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error adding item: ' . $e->getMessage());
        }
    }
    public function ship(Request $request)
    {
        try {


            $validated = $request->validate([
                'item_id' => 'required|numeric',
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

            $incoming = DB::table('pcsi_incoming')
                ->select('item_code', 'sku', 'primary_packaging', 'secondary_packaging', 'variant', 'item_group')
                ->where('id', $validated['item_id'])
                ->first();
            if (!$incoming) {
                return back()->withErrors(['item_id' => 'Selected item not found.']);
            }

            $updateInventory = DB::table('pcsi_incoming')
                ->where('id', $validated['item_id'])
                ->update([
                    'qty_head' => $validated['quantity'],
                    'qty_kilo' => $validated['kilogram'],
                    'balance_head' => DB::raw('inventory_head - ' . $validated['quantity']),
                    'balance_kilo' => DB::raw('inventory_kilo - ' . $validated['kilogram']),
                ]);


            DB::table('pcsi_outgoing')->insert([
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
                'event' => 'Shipped '. $incoming->item_code. ' from PCSI Warehouse',
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
    public function exportIncoming()
    {
        return Excel::download(new PCSIIncomingExport, 'pcsi-incoming.xlsx');
    }
    public function exportOutgoing()
    {
        return Excel::download(new PCSIOutgingExport, 'pcsi-outgoing.xlsx');
    }

    public function update(Request $request, $id)
    {
        try {
            // Log the incoming data for debugging
            Log::info('Update request received', [
                'id' => $id,
                'data' => $request->all()
            ]);

            // Check if the item exists first
            $existingItem = DB::table('pcsi_incoming')->where('id', $id)->first();
            if (!$existingItem) {
                return response()->json(['success' => false, 'message' => 'Item not found'], 404);
            }

            $result = DB::table('pcsi_incoming')->where('id', $id)
                ->update([
                    'data_entry' => $request->input('data_entry'),
                    'item_group' => $request->input('item_group'),
                    'item_code' => $request->input('item_code'),
                    'variant' => $request->input('variant'),
                    'kilogram_tray' => $request->input('kilogram_tray'),
                    'class' => $request->input('class'),
                    'sku' => $request->input('sku'),
                    'fg' => $request->input('fg'),
                    'primary_packaging' => $request->input('primary_packaging'),
                    'secondary_packaging' => $request->input('secondary_packaging'),
                    'prod_date' => $request->input('prod_date'),
                    'exp_date' => $request->input('exp_date'),
                    'left' => $request->input('left'),
                    'inventory_head' => $request->input('inventory_head'),
                    'inventory_kilo' => $request->input('inventory_kilo'),
                    'updated_at' => now(),

                ]);

            Log::info('Update result', ['result' => $result]);

            if ($result) {
                return response()->json(['success' => true, 'message' => 'Item updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'No changes were made to the item'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error updating item', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error updating item: ' . $e->getMessage()], 500);
        }
    }
}
