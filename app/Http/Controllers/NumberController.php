<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Contracts\View\View;

class NumberController extends Controller
{
    public function index(): View
    {
        $numberGroups = Number::with('diaper')
            ->get()
            ->groupBy('diaper.name');

        return view('numbers.index', compact('numberGroups'));
    }
}
