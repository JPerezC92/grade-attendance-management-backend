<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstructorController;

Route::post('/', [InstructorController::class, 'create'])->name('instructor.create');
Route::get('/', [InstructorController::class, 'getByToken'])->name('instructor.getByToken');
