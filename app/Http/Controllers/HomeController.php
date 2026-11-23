<?php

namespace App\Http\Controllers;

use App\Models\PsUnit;

class HomeController extends Controller
{
    public function index()
    {
        $units = PsUnit::orderBy('price_per_hour', 'asc')->get();

        return view('landing', compact('units'));
    }
}
