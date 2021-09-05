

<?php

use App\Http\Controllers\CourseRecordController;
use Illuminate\Support\Facades\Route;

Route::post('/', [CourseRecordController::class, 'create'])->name('courseRecord.create');
Route::get('/{courseRecordId}', [CourseRecordController::class, 'getById'])->name('courseRecord.getById');
