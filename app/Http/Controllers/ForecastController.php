<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ForecastController extends Controller
{
    public function index()
    {
        // Fetch all data from monthly_sales table
        $sales = DB::table('sales')->get();


        return response()->json($sales);
    }

}
