<?php

namespace App\Http\Controllers;

use App\Models\AttendanceCheck;
use Illuminate\Http\Request;
use Throwable;

class AttendanceCheckController extends Controller
{
    public function create(Request $request)
    {
        try {
            $attendanceCheck = AttendanceCheck::create([
                'attendanceId' => $request->attendanceId,
                'studentId' => $request->studentId,
                'attendanceStatusId' => $request->attendanceStatusId,
            ]);

            $attendanceCheck->fresh();

            return response()->json([
                "success" => true,
                "payload" => $attendanceCheck
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function updateMany(Request $request)
    {
        try {
            foreach ($request->all() as $key => $attendanceCheck) {
                AttendanceCheck::where('id', $attendanceCheck["id"])->update(["attendanceStatusId" => $attendanceCheck["attendanceStatusId"]]);
            }

            return response()->json([
                "success" => true,
                "payload" => "asistencias actualizadas"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
