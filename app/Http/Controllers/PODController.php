<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PODController extends Controller
{
    public function index()
    {
        return view('logistic.pod-automation');
    }
}
