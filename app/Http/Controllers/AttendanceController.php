<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $attendance->attendanceChecks;

            return response()->json([
                "success" => true,
                "payload" => $attendance
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function update(Request $request, $attendanceId)
    {
        try {
            $attendance = Attendance::find($attendanceId);
            $updatedData = $request->only($attendance->getFillable);

            $attendance->fill($updatedData)->save();

            $attendance->fresh();
            $attendance->attendanceChecks;

            return response()->json([
                "success" => true,
                "payload" => $attendance
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function delete(Request $request, $attendanceId)
    {
        try {
            DB::table('attendanceCheck')->where('attendanceId', '=', $attendanceId)->delete();

            $student =  Attendance::destroy($attendanceId);

            return response()->json([
                "success" => true,
                "payload" => "Elimininado con exito"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
