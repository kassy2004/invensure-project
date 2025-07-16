<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class JFPCController extends Controller
{
    public function index()
    {

        if (auth()->user()->role !== 'inventory_manager') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $inventory = DB::table('jfpc_incoming')->get();
        $item_master = DB::table('item_master')->get();

        // Debug: Log the count of items
        Log::info('Item master count: ' . $item_master->count());
        // dd($item_master);
        $inventoryJson = $inventory;

        $inventory_head = DB::table('jfpc_incoming')->sum('inventory_head');
        $inventory_kilo = DB::table('jfpc_incoming')->sum('inventory_kilo');
        $qty_head = DB::table('jfpc_incoming')->sum('qty_head');
        $qty_kilo = DB::table('jfpc_incoming')->sum('qty_kilo');
        $balance_head = DB::table('jfpc_incoming')->sum('balance_head');
        $balance_kilo = DB::table('jfpc_incoming')->sum('balance_kilo');

        $today = Carbon::today();
        foreach ($inventory as $item) {
            try {


                // Parse using format 'd-M-y'
                $expDate = Carbon::parse($item->exp_date);
                $prodDate = Carbon::parse($item->prod_date);

                // Calculate months left
                $formatted = $expDate->format('Y-m-d');
                $formattedProdDate = $prodDate->format('Y-m-d');

                // Calculate days left
                $daysLeft = $today->diffInDays($expDate, false);

                $status = $daysLeft <= 20 ? 'EXPIRE SOON' : 'FG AVAILABLE';

                // Update row
                $success = DB::table('jfpc_incoming')
                    ->where('id', $item->id)
                    ->update([
                        'left' => $daysLeft,
                        'status' => $status,
                    ]);

              

            } catch (\Exception $e) {
                Log::warning("Failed to parse exp_date for ID {$item->id}: {$item->exp_date} - {$e->getMessage()}");
            }
        }

        $expiring = DB::table('jfpc_incoming')
            ->where('status', 'EXPIRE SOON')
            ->count();
        $available = DB::table('jfpc_incoming')
            ->where('status', 'FG AVAILABLE')
            ->count();

        $expiringItem = DB::table('jfpc_incoming')
            ->where('status', 'EXPIRE SOON')
            ->get();
        $availableItem = DB::table('jfpc_incoming')
            ->where('status', 'FG AVAILABLE')
            ->get();
        $remarks = DB::table('jfpc_incoming')
            ->whereNotNull('remarks')           // Exclude NULLs
            ->where('remarks', '!=', '')        // Exclude empty strings
            ->whereRaw("TRIM(remarks) != ''")   // Exclude spaces-only
            ->get();

        // $remarksJson = $remarks->toJson();
        return view('inventory-manager.jfpc', compact('inventoryJson', 'inventory_head', 'inventory_kilo', 'qty_head', 'qty_kilo', 'balance_head', 'balance_kilo', 'expiring', 'available', 'expiringItem', 'availableItem', 'item_master', 'remarks'));
    
       
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'data_entry' => 'required|string|max:255',
            'item_group' => 'required|string|max:255',
            'item_code' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'kilogram_tray' => 'nullable|numeric',
            'class' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:255',
            'fg' => 'nullable|string|max:255',
            'primary_packaging' => 'nullable|string|max:255',
            'secondary_packaging' => 'nullable|string|max:255',
            'prod_date' => 'required|date',
            'inventory_head' => 'nullable|numeric',
            'inventory_kilo' => 'nullable|numeric',
            'idnum' => 'required|numeric',
            'remarks' => 'required|string|max:255',
        ]);

        $prodDate = Carbon::parse($request->input('prod_date'));
        $expirationStage = (int) DB::table('item_master')
            ->where('id', $request->input('idnum'))
            ->value('expiration_stage');
        $today = Carbon::today();


        try {


            $expDate = $prodDate->copy()->addMonths($expirationStage);
            $formattedExpDate = $expDate->format('Y-m-d');
            $daysLeft = (int) $today->diffInDays($formattedExpDate, false);


            $result = DB::table('jfpc_incoming')->insert([
                'data_entry' => $validated['data_entry'],
                'item_group' => $validated['item_group'],
                'item_code' => $validated['item_code'],
                'variant' => $validated['variant'] ?? null,
                'kilogram_tray' => $validated['kilogram_tray'] ?? null,
                'class' => $validated['class'] ?? null,
                'sku' => $validated['sku'] ?? null,
                'fg' => $validated['fg'] ?? null,
                'primary_packaging' => $validated['primary_packaging'] ?? null,
                'secondary_packaging' => $validated['secondary_packaging'] ?? null,
                'prod_date' => $validated['prod_date'],
                'exp_date' => $formattedExpDate,
                'left' => $daysLeft,
                'inventory_head' => $validated['inventory_head'] ?? null,
                'inventory_kilo' => $validated['inventory_kilo'] ?? null,
                'remarks' => $validated['remarks'],
                'created_at' => now(),
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
}
