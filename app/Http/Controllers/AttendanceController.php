<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCheck;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class AttendanceController extends Controller
{
    public function create(Request $request)
    {
        try {
            $courseRecordId = $request->courseRecordId;
            $attendanceCheckData = [];
            $students = Student::where('student.courseRecordId', $courseRecordId)->get();

            $attendance = Attendance::create([
                'date' => $request->date,
                'courseRecordId' => $request->courseRecordId,
            ]);
            $attendance->fresh();

            foreach ($students as $key => $studentValue) {
                array_push($attendanceCheckData, [
                    "studentId" => $studentValue["id"],
                    "attendanceId" => $attendance["id"],
                    // "attendanceStatusId" => 1
                ]);
            }

            AttendanceCheck::insert($attendanceCheckData);

            $attendance->attendanceChecks;

            return response()->json([
                "success" => true,
                "payload" =>  $attendance
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
