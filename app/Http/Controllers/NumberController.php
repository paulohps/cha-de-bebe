<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NumberController extends Controller
{
    public function index(): View
    {
        $numberGroups = Number::with('diaper')
            ->get()
            ->groupBy('diaper.name');

        return view('numbers.index', compact('numberGroups'));
    }

    public function sortear(Request $request): View
    {
        $numbers = Number::with('diaper')
            ->whereNotNull('approved_at')
            ->get();

        $winner = $request->boolean('sortear') ? $numbers->random() : null;

        return view('numbers.sortear', compact('numbers', 'winner'));
    }
}
