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
                'career' => $request->career,
                'turn' => $request->turn,
                'group' => $request->group,
                'semester' => $request->semester,
                'instructorId' => $request->instructorId,
                'courseId' => $request->courseId,
                'periodId' => $request->periodId,
            ]);

            $courseRecord->fresh();
            $courseRecord->period;

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

            foreach ($courseRecord->activities as $index => $activitiesValue) {
                $activitiesValue->scores;

                foreach ($activitiesValue->scores as $index => $scoresValue) {
                    $scoresValue->scoresAssigned;
                }
            }

            foreach ($courseRecord->attendances as $index => $value) {
                $value->attendanceChecks;
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
