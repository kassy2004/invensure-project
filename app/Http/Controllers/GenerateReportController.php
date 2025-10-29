<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GenerateReportController extends Controller
{
    public function index()
    {
        return view('components.dashboard.generated');
    }
    public function generate()
    {


        $totalProducts = DB::table('pcsi_incoming')
            ->count() + DB::table('jfpc_incoming')
            ->count() + DB::table('incoming')
            ->count();

        $lowStockItem = DB::table('pcsi_incoming')
            ->where('balance_head', '<=', 10)
            ->count()
            +
            DB::table('jfpc_incoming')
            ->where('balance_head', '<=', 10)
            ->count()
            +
            DB::table('incoming')
            ->where('balance_head', '<=', 10)
            ->count();

        $pendingCount = DB::table('pcsi_outgoing')
            ->where('approval_status', 'pending')
            ->count()
            +
            DB::table('jfpc_outgoing')
            ->where('approval_status', 'pending')
            ->count()
            +
            DB::table('outgoing')
            ->where('approval_status', 'pending')
            ->count();
        $warehouseStats = DB::table(function ($query) {
            // 🏭 For incoming (has warehouse_id)
            $query->select(
                'warehouses.warehouse',
                'incoming.inventory_head',
                'incoming.inventory_kilo',
                'incoming.qty_head',
                'incoming.qty_kilo',
                'incoming.balance_head',
                'incoming.balance_kilo'
            )
                ->from('incoming')
                ->join('warehouses', 'incoming.warehouse_id', '=', 'warehouses.id')

                // 🏢 PCSI warehouse
                ->unionAll(
                    DB::table('pcsi_incoming')
                        ->selectRaw("
                        'PCSI' as warehouse,
                        inventory_head,
                        inventory_kilo,
                        qty_head,
                        qty_kilo,
                        balance_head,
                        balance_kilo
                    ")
                )

                // 🏢 JFPC warehouse
                ->unionAll(
                    DB::table('jfpc_incoming')
                        ->selectRaw("
                        'JFPC' as warehouse,
                        inventory_head,
                        inventory_kilo,
                        qty_head,
                        qty_kilo,
                        balance_head,
                        balance_kilo
                    ")
                );
        }, 'combined')
            ->select(
                'warehouse',
                DB::raw('SUM(inventory_head) as total_inventory_head'),
                DB::raw('SUM(inventory_kilo) as total_inventory_kilo'),
                DB::raw('SUM(qty_head) as total_qty_head'),
                DB::raw('SUM(qty_kilo) as total_qty_kilo'),
                DB::raw('SUM(balance_head) as total_balance_head'),
                DB::raw('SUM(balance_kilo) as total_balance_kilo')
            )
            ->groupBy('warehouse')
            ->get();



        $totalDeliveredOrders = DB::table('orders')
            ->where('status', 'delivered')
            ->distinct('order_id')
            ->count('order_id');
        $totalInTransitOrders = DB::table('orders')
            ->where('status', 'in transit')
            ->distinct('order_id')
            ->count('order_id');
        $totalPendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->distinct('order_id')
            ->count('order_id');

        // ✅ Start with your static metrics
        $metrics = [
            ['All Warehouse: Total Products', $totalProducts],
            ['Low Stock Items', $lowStockItem],
            ['Pending Orders', $pendingCount],
        ];
        $logistics = [
            ['Total Delivered Orders', $totalDeliveredOrders],
            ['Total In Transit Orders', $totalInTransitOrders],
            ['Total Pending Orders', $totalPendingOrders],
            // You can add more logistics data here later (e.g., Total Pending Deliveries, Total Returns)
        ];

        foreach ($warehouseStats as $item) {
            $metrics[] = ["{$item->warehouse} Warehouse: Total Inventory (Head/Pack)", $item->total_inventory_head];
            $metrics[] = ["{$item->warehouse} Warehouse: Total Inventory (Kilogram)", $item->total_inventory_kilo];
            $metrics[] = ["{$item->warehouse} Warehouse: Total QTY Issued (Head/Pack)", $item->total_qty_head];
            $metrics[] = ["{$item->warehouse} Warehouse: Total QTY Issued (Kilogram)", $item->total_qty_kilo];
            $metrics[] = ["{$item->warehouse} Warehouse: Total Available Balance (Head/Pack)", $item->total_balance_head];
            $metrics[] = ["{$item->warehouse} Warehouse: Total Available Balance (Kilogram)", $item->total_balance_kilo];
        }

        $data = [
            'generated_date' => now()->format('F d, Y'),
            'generated_by' => Auth::user()->name,
            'report_title' => 'Summary Report',
            'metrics' => $metrics,
            'logistics' => $logistics,
        ];

        $pdf = PDF::loadView('reports.summary', $data)->setPaper('a4', 'portrait');

        // 2️⃣ Define the file name and path
        $fileName = 'summary_report_' . now()->format('Ymd_His') . '.pdf';
        $filePath = 'reports/' . $fileName;

        // $disk = Storage::disk('google');
        // dd($disk);
        Storage::disk('google')->put($filePath, $pdf->output());
        // dd($result);

       


        DB::table('report_histories')->insert([
            'report_name' => 'Summary Report',
            'type' => 'PDF',
            'warehouse' => 'All Warehouse',
            'file_url' => Storage::disk('google')->url($filePath),
            'file_size' => round(strlen($pdf->output()) / 1024 / 1024, 2) . ' MB',
            'generated_by' => Auth::user()->name,
            'generated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Summary Report generated and uploaded to Google Drive successfully!');

    }
}
