<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumberController;

Route::get('/', [NumberController::class, 'index'])->name('numbers.index');
Route::get('/sortear', [NumberController::class, 'sortear'])->name('numbers.sortear');
