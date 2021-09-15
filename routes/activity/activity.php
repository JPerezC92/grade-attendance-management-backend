<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::post('/', [ActivityController::class, 'create'])->name('activity.create');
Route::put('/{activityId}', [ActivityController::class, 'update'])->name('activity.update');
Route::delete('/{activityId}', [ActivityController::class, 'delete'])->name('activity.delete');


Route::post('/file', [ActivityController::class, 'createFromCSV'])->name('activity.createFromCSV');
Route::post('/csv-file', [ActivityController::class, 'createFromCSVFile'])->name('activity.createFromCSVFile');
Route::get('/', [ActivityController::class, 'getAll'])->name('activity.getAll');
Route::get('/{activityId}', [ActivityController::class, 'getById'])->name('activity.getById');
