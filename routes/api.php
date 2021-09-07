<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('student')->group(__DIR__ . '/student/student.php');
Route::prefix('instructor')->group(__DIR__ . '/instructor/instructor.php');
Route::prefix('{instructorId}/course')->group(__DIR__ . '/course/course.php');
Route::prefix('course-record')->group(__DIR__ . '/courseRecord/courseRecord.php');
Route::prefix('attendance')->group(__DIR__ . '/attendance/attendance.php');
Route::prefix('attendance-check')->group(__DIR__ . '/attendanceCheck/attendanceCheck.php');
