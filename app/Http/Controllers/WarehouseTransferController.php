<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class WarehouseTransferController extends Controller
{
    public function index()
    {
        $pcsi = DB::table('pcsi_incoming')
            ->where('balance_head', '>', 0)
            ->where('balance_kilo', '>', 0)
            ->get();
        $jfpc = DB::table('jfpc_incoming')
            ->where('balance_head', '>', 0)
            ->where('balance_kilo', '>', 0)

            ->get();


        $transferHistory = DB::table('transfer')
            ->leftJoin('pcsi_incoming', function ($join) {
                $join->on('transfer.item_id', '=', 'pcsi_incoming.id')
                    ->where('transfer.source_warehouse', '=', 'pcsi');
            })
            ->leftJoin('jfpc_incoming', function ($join) {
                $join->on('transfer.item_id', '=', 'jfpc_incoming.id')
                    ->where('transfer.source_warehouse', '=', 'jfpc');
            })
            ->select(
                'transfer.*',
                DB::raw('COALESCE(pcsi_incoming.item_code, jfpc_incoming.item_code) as item_code'),
                DB::raw('COALESCE(pcsi_incoming.data_entry, jfpc_incoming.data_entry) as data_entry'),
                DB::raw('COALESCE(pcsi_incoming.qty_head, jfpc_incoming.qty_head) as qty_head'),
                DB::raw('COALESCE(pcsi_incoming.qty_kilo, jfpc_incoming.qty_kilo) as qty_kilo'),
            )
            ->orderBy('transfer.created_at', 'desc')
            ->paginate(10);



        // dd($transferHistory);
        // Logic to display warehouse transfer page
        return view('inventory-manager.warehouse-transfer', compact('pcsi', 'jfpc', 'transferHistory'));
    }
    public function submit(Request $request)
    {
        // Logic to handle warehouse transfer submission
        // This could include validation, updating database records, etc.
        // Debugging line to see the request data
        // Example: Validate the request data
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'string',
            'source_warehouse' => 'required|string',
            'destination_warehouse' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $source = $request->input('source_warehouse');
            $destination = $request->input('destination_warehouse');

            foreach ($request->items as $itemJson) {
                $item = json_decode($itemJson, true);
                // dd($item);
                // Basic validation
                if (!isset($item['id']) || !isset($item['qty']) || !isset($item['kilo'])) {
                    throw new \Exception('Invalid item format.');
                }

                $itemId = $item['id'];
                $qty = (int) ($item['qty'] / 10);
                $kilo = floor(($item['kilo']) * 10) / 10;
                // dd($kilo, $itemId, $qty, $source, $destination);

                // Optional: check stock in source warehouse
                $sourceQty = DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->value('balance_head');

                $sourceKilo = DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->value('balance_kilo');

                // dd($qty);
                if ($sourceQty === null || $sourceKilo === null || $sourceQty < $qty || $sourceKilo < $kilo) {
                    throw new \Exception("Insufficient stock in {$source} for item ID {$itemId}");
                }

                // Transfer record
                DB::table('transfer')->insert([
                    'item_id' => $itemId,
                    'source_warehouse' => $source,
                    'destination_warehouse' => $destination,
                    // 'quantity' => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Get Item details
                $itemDetails = DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->first();
                // dd($itemDetails);
                // Increment destination
                DB::table("{$destination}_incoming")

                    ->insert([
                        'data_entry' => $itemDetails->data_entry,
                        'item_code' => $itemDetails->item_code,
                        'item_group' => $itemDetails->item_group,
                        'variant' => $itemDetails->variant,
                        'kilogram_tray' => $itemDetails->kilogram_tray,
                        'class' => $itemDetails->class,
                        'sku' => $itemDetails->sku,
                        'fg' => $itemDetails->fg,
                        'primary_packaging' => $itemDetails->primary_packaging,
                        'secondary_packaging' => $itemDetails->secondary_packaging,
                        'prod_date' => $itemDetails->prod_date,
                        'left' => $itemDetails->left,
                        'exp_date' => $itemDetails->exp_date,
                        'status' => $itemDetails->status,
                        'inventory_head' => $qty,
                        'inventory_kilo' => $kilo,
                        'received_by' => $itemDetails->received_by,
                        'qty_head' => $itemDetails->qty_head,
                        'qty_kilo' => $itemDetails->qty_kilo,
                        'balance_head' => $qty,
                        'balance_kilo' => $kilo,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);



                // Decrement source incoming quantities and kilo
                DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->decrement('balance_head', $qty);

                DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->decrement('balance_kilo', $kilo);

                // Increment source incoming issued quantities and kilo
                DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->increment('qty_head', $qty);

                DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->increment('qty_kilo', $kilo);

                DB::table("{$source}_incoming")
                    ->where('id', $itemId)
                    ->update([
                        'updated_at' => now(),
                    ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Items transferred successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Item transfer failed: ' . $e->getMessage());

        }
    }
}
