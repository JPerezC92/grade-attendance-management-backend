<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Throwable;

class CourseController extends Controller
{
    public function create(Request $request)
    {
        try {
            $course =  Course::create([
                "name" => $request->name,
                "campus" => $request->campus,
                "career" => $request->career,
                "instructorId" => $request->instructorId,
            ]);

            $course->fresh();

            return response()->json([
                "success" => true,
                "payload" => $course
            ]);
        } catch (Throwable $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
