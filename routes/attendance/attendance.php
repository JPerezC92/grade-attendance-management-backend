<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::post('/', [AttendanceController::class, "create"])->name("attendance.create");
