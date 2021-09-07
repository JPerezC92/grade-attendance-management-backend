<?php

namespace App\Http\Controllers;

use App\Models\CourseRecord;
use Illuminate\Http\Request;
use Throwable;

class CourseRecordController extends Controller
{


    public function create(Request $request)
    {
        try {
            $courseRecord = CourseRecord::create([
                'instructorId' => $request->instructorId,
                'courseId' => $request->courseId,
                'periodId' => $request->periodId,
            ]);

            $courseRecord->fresh();

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function getById(Request $request, $courseRecordId)
    {
        try {
            $courseRecord = CourseRecord::find($courseRecordId);
            $courseRecord->period;
            $courseRecord->students;
            $courseRecord->activities;
            $courseRecord->attendances;

            foreach ($courseRecord->activities as $index => $value) {
                $value->scores;
            }

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
