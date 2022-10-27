<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NumberController;

Route::get('/', [NumberController::class, 'index']);
