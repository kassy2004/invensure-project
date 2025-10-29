<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/');
        }


        $topItems = collect([]);
        $categories = ['Dressed Chicken', 'Choice Cut', 'Fillet', 'By Product', 'Value Added Product'];



        if (Auth::check() && Auth::user()->role === 'customer') {
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

            $lowStockItem = DB::table('pcsi_incoming')
                ->where('balance_head', '<=', 10)
                ->count()
                +
                DB::table('jfpc_incoming')
                    ->where('balance_head', '<=', 10)
                    ->count();
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

            $reportsHistory = DB::table('report_histories')
                ->orderBy('generated_at', 'desc')
                ->get();


            $totalProducts = DB::table('pcsi_incoming')
                ->count() + DB::table('jfpc_incoming')
                    ->count();

            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $currentAvg = DB::table('feedback')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->avg('rating');

            // Previous month average
            $previousAvg = DB::table('feedback')
                ->whereMonth('created_at', $previousMonth)
                ->whereYear('created_at', $previousYear)
                ->avg('rating');

            // Calculate the change

            $ratingChange = $previousAvg ? round($currentAvg - $previousAvg, 1) : null;

            $averageRating = round(DB::table('feedback')->avg('rating'), 2);


            $yearlyAverage = round(DB::table('feedback')
                ->whereYear('created_at', Carbon::now()->year)
                ->avg('rating'), 2);

            // --- Monthly average (current month) ---
            $monthlyAverage = round(DB::table('feedback')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->avg('rating'), 2);

            // --- Weekly average (current week) ---
            $weeklyAverage = round(DB::table('feedback')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereRaw('WEEKOFYEAR(created_at) = ?', [Carbon::now()->weekOfYear])
                ->avg('rating'), 2);

            $currentWeek = Carbon::now()->weekOfYear;
            $currentYear = Carbon::now()->year;
            $previousWeek = Carbon::now()->subWeek()->weekOfYear;
            $previousWeekYear = Carbon::now()->subWeek()->year;
            $currentWeekAvg = DB::table('feedback')
                ->whereYear('created_at', $currentYear)
                ->whereRaw('WEEKOFYEAR(created_at) = ?', [$currentWeek])
                ->avg('rating');

            $previousWeekAvg = DB::table('feedback')
                ->whereYear('created_at', $previousWeekYear)
                ->whereRaw('WEEKOFYEAR(created_at) = ?', [$previousWeek])
                ->avg('rating');

            $weeklyChange = $previousWeekAvg ? round($currentWeekAvg - $previousWeekAvg, 1) : null;




            $currentYearAvg = DB::table('feedback')
                ->whereYear('created_at', $currentYear)
                ->avg('rating');

            $previousYearAvg = DB::table('feedback')
                ->whereYear('created_at', $previousYear)
                ->avg('rating');

            $yearlyChange = $previousYearAvg ? round($currentYearAvg - $previousYearAvg, 1) : null;
            $audits = DB::table('audits')
                ->leftJoin('users', function ($join) {
                    $join->on('audits.user_id', '=', 'users.id')
                        ->where('audits.user_type', '=', \App\Models\User::class);
                })
                ->select('audits.*', 'users.name as user_name', 'users.role as user_role')
                ->orderBy('audits.created_at', 'desc')
                ->get();

            $returnCount = DB::table('returns')
                ->where('status', 'pending')
                ->count();
            // dd($returnCount);

            return view('dashboard', compact(
                'topItems',
                'stockSummary',
                'stockKiloSummary',
                'pendingCount',
                'totalProducts',
                'averageRating',
                'audits',
                'lowStockItem',
                'returnCount',
                'ratingChange',
                'weeklyChange',
                'yearlyChange',
                'yearlyAverage',
                'monthlyAverage',
                'weeklyAverage',
                'reportsHistory',
            ));
        } else {
            // For other roles, return the view with an empty topItems
            return view('dashboard', ['topItems' => collect([]), 'stockSummary' => collect([]), 'stockKiloSummary' => collect([]), 'pendingCount' => collect([]), 'totalProducts' => collect([])]);
        }
    }
}
