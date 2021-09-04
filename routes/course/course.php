<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::post('/', [CourseController::class, 'create'])->name('course.create');
