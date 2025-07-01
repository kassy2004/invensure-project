<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $topItems = collect([]);
        $categories = ['Dressed Chicken', 'Choice Cut', 'Fillet', 'By Product', 'Value Added Product'];

        if (Auth::user()->role === 'inventory_manager') {

            $pcsi = DB::table('pcsi_outgoing')
                ->select('description', DB::raw('quantity as total_qty'));

            // Second query for jfpc_outgoing
            $jfpc = DB::table('jfpc_outgoing')
                ->select('description', DB::raw('quantity as total_qty'));


            $topItems = DB::query()
                ->fromSub(
                    $pcsi->unionAll($jfpc),
                    'combined'
                )
                ->select('description', DB::raw('SUM(total_qty) as total_moved'))
                ->groupBy('description')
                ->orderByDesc('total_moved')
                ->limit(10)
                ->get();


            $categoriesPcsi = DB::table('pcsi_incoming')
                ->select('item_group', DB::raw('SUM(balance_head) as total_qty'))
                ->whereIn('item_group', $categories)
                ->groupBy('item_group');

            $categoriesJfpc = DB::table('jfpc_incoming')
                ->select('item_group', DB::raw('SUM(balance_head) as total_qty'))
                ->whereIn('item_group', $categories)
                ->groupBy('item_group');
            
                $stockSummary = DB::query()
                ->fromSub($categoriesPcsi->unionAll($categoriesJfpc), 'combined')
                ->select('item_group', DB::raw('SUM(total_qty) as total_quantity'))
                ->groupBy('item_group')
                ->orderByDesc('total_quantity')
                ->get();

                // dd($stockSummary);

            $pendingCount = DB::table('pcsi_outgoing')
                ->where('approval_status', 'pending')
                ->count()
                +
                DB::table('jfpc_outgoing')
                    ->where('approval_status', 'pending')
                    ->count();


            $totalProducts =  DB::table('pcsi_incoming')
            ->count() + DB::table('jfpc_incoming')
            ->count();

            return view('dashboard', compact('topItems', 'stockSummary', 'pendingCount', 'totalProducts'));
        } else {
            // For other roles, return the view with an empty topItems
            return view('dashboard', ['topItems' => collect([]), 'stockSummary' => collect([]), 'pendingCount' => collect([]), 'totalProducts' => collect([])] );
        }
    }
}
