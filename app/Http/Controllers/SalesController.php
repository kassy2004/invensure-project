<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = DB::table('sales')
            ->orderBy('year', 'desc')
            ->get();
        return view('sales', compact('sales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $year = $request->year;

        // Loop through all inputs except _token and year
        foreach ($request->except('_token', 'year') as $key => $value) {

            // Skip empty/null values (optional)
            if ($value === null || $value === "") {
                continue;
            }

            // Parse key: product_category_month
            // Example: dressed_chicken_b2c_jan
            $parts = explode('_', $key);

            // Last part = month (jan, feb, ...)
            $month = array_pop($parts);

            if ($parts[0] === 'general') {

                // category = General
                $product = 'General';

                // remove "general"
                array_shift($parts);

                // product = remaining parts
                $category = implode(' ', $parts);
            }
            // CASE 2: Normal format product_category_month
            else {

                // last part before month = category
                $category = array_pop($parts);

                // rest = product
                $product = implode(' ', $parts);
            }

            // Store row into DB
            $existing = DB::table('sales')
                ->where('year', $year)
                ->where('category', ucwords($category))
                ->where('product', $product)
                ->first();

            if ($existing) {
                // Update the month column
                DB::table('sales')
                    ->where('id', $existing->id)
                    ->update([
                        $month => $value,
                        'total' => DB::raw("COALESCE(total, 0) + $value"), // optional: update total
                        'updated_at' => now(),
                    ]);
            } else {
                // Insert new row
                DB::table('sales')->insert([
                    'year' => $year,
                    'product' => $product,
                    'category' => ucwords($category),
                    $month => $value,
                    'total' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Sales saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
