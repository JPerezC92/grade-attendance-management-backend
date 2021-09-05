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
            return response(status: "500")->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function getById(Request $request, $courseRecordId)
    {
        try {
            $courseRecord = CourseRecord::find($courseRecordId);

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(status: "500")->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
