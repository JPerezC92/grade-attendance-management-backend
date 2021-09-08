<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Period;
use Illuminate\Http\Request;
use Throwable;

class PeriodController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $instructorId = $request->query("instructorId");

            $periods = Instructor::find($instructorId)->periods;

            return response()->json([
                "success" => true,
                "payload" => $periods
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function create(Request $request)
    {
        try {
            $period = Period::create([
                "value" => $request->value,
                "status" => "active",
                "instructorId" => $request->instructorId
            ]);

            return response()->json([
                "success" => true,
                "payload" => $period
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
