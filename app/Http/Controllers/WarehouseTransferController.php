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
        ->where('balance_head', '!=' , 0)
        ->paginate(10);
        $jfpc = DB::table('jfpc_incoming')
        ->where('balance_head', '!=' , 0)
        ->paginate(10);
        // Logic to display warehouse transfer page
        return view('inventory-manager.warehouse-transfer', compact('pcsi', 'jfpc'));
    }

}
