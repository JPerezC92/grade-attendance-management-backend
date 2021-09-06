<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Throwable;

class AttendanceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $attendance = Attendance::create([
                'date' => $request->date,
                'courseRecordId' => $request->courseRecordId,
            ]);

            $attendance->fresh();

            return response()->json([
                "success" => true,
                "payload" => $attendance
            ]);
        } catch (Throwable $e) {
            return response(status: "500")->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
