<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoresAssignedController;

Route::put('/', [ScoresAssignedController::class, 'updateMany'])->name('score.getById');
// Route::get('/{scoreId}', [ScoreController::class, 'getById'])->name('score.getById');
