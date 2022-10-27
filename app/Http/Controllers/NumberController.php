<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class NumberController extends Controller
{
    public function index(): View
    {
        return view('numbers.index');
    }
}
