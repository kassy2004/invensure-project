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
        if (auth()->user()->role !== 'inventory_manager') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $item = DB::table('item_master')->get();
        $count = DB::table('item_index')
            ->get();
        $itemJson = $item->toJson();
        return view('inventory-manager.item-master', compact('itemJson', 'count'));
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
    public function add(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|string|max:255',
            'new_mrp_code' => 'required|string|max:255',
            'item_group' => 'required|string|max:255',
            'abbrev' => 'nullable|string|max:255',
            'variant' => 'nullable|string|max:255',
            'kilogram_tray' => 'nullable|numeric',
            'category' => 'nullable|string|max:255',
            'category_2' => 'nullable|string|max:255',
            'class' => 'nullable|string|max:255',
            'primary_packaging' => 'nullable|string|max:255',
            'secondary_packaging' => 'nullable|string|max:255',
            'fg_packaging' => 'nullable|string|max:255',
            'sku' => 'required|string|max:255',
            'fg' => 'required|string|max:255',
            'expiration_stage' => 'nullable|numeric',
        ]);

        DB::table('item_index')
        ->where('item_group', $validated['abbrev'])
            ->increment('count');


        $result = DB::table('item_master')->insert([
            'item' => $validated['item'],
            'new_mrp_code' => $validated['new_mrp_code'],
            'item_group' => $validated['item_group'],
            'abbrev' => $validated['abbrev'] ?? null,
            'variant' => $validated['variant'] ?? null,
            'kilogram_tray' => $validated['kilogram_tray'] ?? null,
            'category' => $validated['category'] ?? null,
            'category_2' => $validated['category_2'] ?? null,
            'class' => $validated['class'] ?? null,
            'primary_packaging' => $validated['primary_packaging'] ?? null,
            'secondary_packaging' => $validated['secondary_packaging'] ?? null,
            'fg_packaging' => $validated['fg_packaging'] ?? null,
            'sku' => $validated['sku'],
            'fg' => $validated['fg'],
            'expiration_stage' => $validated['expiration_stage'] ?? null,
            'created_at' => now(), 
        ]);

        if ($result) {
            return redirect()->back()->with('success', 'Item added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add item.');
        }
    }
}
