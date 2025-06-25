<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ItemMasterController extends Controller
{
    public function index()
    {
        $item = DB::table('item_master')->get();

        $itemJson = $item->toJson();
        return view('inventory-manager.item-master', compact('itemJson'));
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
            $existingItem = DB::table('item_master')->where('id', $id)->first();
            if (!$existingItem) {
                return response()->json(['success' => false, 'message' => 'Item not found'], 404);
            }

            $result = DB::table('item_master')->where('id', $id)
                ->update([
                    'item' => $request->input('item'),
                    'new_mrp_code' => $request->input('new_mrp_code'),
                    'item_group' => $request->input('item_group'),
                    'abbrev' => $request->input('abbrev'),
                    'category' => $request->input('category'),
                    'category_2' => $request->input('category_2'),
                    'primary_packaging' => $request->input('primary_packaging'),
                    'secondary_packaging' => $request->input('secondary_packaging'),
                    'variant' => $request->input('variant'),
                    'kilogram_tray' => $request->input('kilogram_tray'),
                    'class' => $request->input('class'),
                    'expiration_stage' => $request->input('expiration_stage'),
                    'sku' => $request->input('sku'),
                    'fg' => $request->input('fg'),
                    'fg_packaging' => $request->input('fg_packaging'),
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
