<?php

use App\Http\Controllers\PeriodController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PeriodController::class, "getAll"])->name('period.getAll');
Route::post('/', [PeriodController::class, "create"])->name('period.create');
Route::put('/', [PeriodController::class, "update"])->name('period.update');
