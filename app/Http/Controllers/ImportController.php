<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Exports\PCSIIncomingExport;
use App\Exports\PCSIOutgingExport;
use Maatwebsite\Excel\Facades\Excel;
class ImportController extends Controller
{
    public function showForm()
    {
        return view('import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        $handle = fopen($file, 'r');
        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            // Skip empty or invalid rows
            if (!isset($row[5]) || trim($row[5]) == '')
                continue;

            DB::table('outgoing')->insert([
                'transaction_date' => $this->parseDate($row[1] ?? null),
                'customer' => trim($row[2] ?? ''),
                'warehouse_id' => 3,
                'transfer' => trim($row[3] ?? ''),
                'cm_code' => trim($row[4] ?? ''),
                'item_code' => trim($row[5] ?? ''),   // your data starts here
                'description' => trim($row[6] ?? ''),
                'sku_description' => trim($row[7] ?? ''),
                'primary_packaging' => trim($row[8] ?? ''),
                'secondary_packaging' => trim($row[9] ?? ''),
                'cm_category' => trim($row[10] ?? ''),
                'product_category' => trim($row[11] ?? ''),
                'variant' => trim($row[12] ?? ''),
                'production' => $this->parseDate($row[13] ?? null),
                'quantity' => isset($row[14]) ? (float) $row[14] : 0,
                'kilogram' => isset($row[15]) ? (float) $row[15] : 0,
                'remarks' => trim($row[17] ?? ''),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        fclose($handle);

        return back()->with('success', 'CSV imported successfully!');
    }
    private function parseDate($value)
    {
        if (empty($value))
            return null;

        // Try to convert multiple formats
        $formats = [
            'F d, Y',   // August 20, 2025
            'j-M-y',    // 9-May-25
            'Y-m-d',    // 2025-08-20
            'm/d/Y',    // 08/20/2025
        ];

        foreach ($formats as $format) {
            $dt = \DateTime::createFromFormat($format, trim($value));
            if ($dt)
                return $dt->format('Y-m-d H:i:s');
        }

        // Last fallback: strtotime
        $timestamp = strtotime($value);
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
    }
}
