<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceCheckController;

Route::post('/', [AttendanceCheckController::class, 'create'])->name('attendanceCheck.create');
Route::put('/', [AttendanceCheckController::class, 'updateMany'])->name('attendanceCheck.updateMany');
