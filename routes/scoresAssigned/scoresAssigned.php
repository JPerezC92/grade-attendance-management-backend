<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoresAssignedController;

Route::put('/', [ScoresAssignedController::class, 'updateMany'])->name('score.getById');
Route::put('/{scoreId}', [ScoresAssignedController::class, 'update'])->name('score.update');
