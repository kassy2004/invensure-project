<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/');
        }

        
        $topItems = collect([]);
        $categories = ['Dressed Chicken', 'Choice Cut', 'Fillet', 'By Product', 'Value Added Product'];

        if (Auth::user()->role === 'customer') {
            return redirect('/orders');
        }
        if (Auth::user()->role === 'logistics_coordinator') {
            return redirect('/operations');
        }


        if (Auth::user()->role === 'inventory_manager' || Auth::user()->role === 'admin') {

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

            $categoriesKiloPcsi = DB::table('pcsi_incoming')
                ->select('item_group', DB::raw('SUM(balance_kilo) as total_kilo'))
                ->whereIn('item_group', $categories)
                ->groupBy('item_group');

            $categoriesKiloJfpc = DB::table('jfpc_incoming')
                ->select('item_group', DB::raw('SUM(balance_kilo) as total_kilo'))
                ->whereIn('item_group', $categories)
                ->groupBy('item_group');

            $stockKiloSummary = DB::query()
                ->fromSub($categoriesKiloPcsi->unionAll($categoriesKiloJfpc), 'combined')
                ->select('item_group', DB::raw('SUM(total_kilo) as total_kilogram'))
                ->groupBy('item_group')
                ->orderByDesc('total_kilogram')
                ->get();

                

            // dd($stockKiloSummary);

            $pendingCount = DB::table('pcsi_outgoing')
                ->where('approval_status', 'pending')
                ->count()
                +
                DB::table('jfpc_outgoing')
                    ->where('approval_status', 'pending')
                    ->count();


            $totalProducts = DB::table('pcsi_incoming')
                ->count() + DB::table('jfpc_incoming')
                    ->count();

            $averageRating = round(DB::table('feedback')->avg('rating'), 2);

            $audits = DB::table('audits')
                ->leftJoin('users', function ($join) {
                    $join->on('audits.user_id', '=', 'users.id')
                        ->where('audits.user_type', '=', \App\Models\User::class);
                })
                ->select('audits.*', 'users.name as user_name', 'users.role as user_role')
                ->orderBy('audits.created_at', 'desc')
                ->get();

            return view('dashboard', compact('topItems', 'stockSummary', 'stockKiloSummary', 'pendingCount', 'totalProducts', 'averageRating', 'audits'));
        } else {
            // For other roles, return the view with an empty topItems
            return view('dashboard', ['topItems' => collect([]), 'stockSummary' => collect([]), 'stockKiloSummary' => collect([]), 'pendingCount' => collect([]), 'totalProducts' => collect([])]);
        }
    }
}
