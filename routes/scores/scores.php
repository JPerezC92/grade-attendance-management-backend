<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScoreController;

Route::post('/', [ScoreController::class, 'create'])->name('score.create');
Route::get('/{scoreId}', [ScoreController::class, 'getById'])->name('score.getById');
Route::delete('/{scoreId}', [ScoreController::class, 'delete'])->name('score.delete');
