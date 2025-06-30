<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    public function index()
    {
        return view('inventory-manager.return-item');
    }
}
