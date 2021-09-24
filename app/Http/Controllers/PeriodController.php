<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class PeriodController extends Controller
{
    public function getAll(Request $request)
    {
        try {
            $instructorId = $request->query("instructorId");

            $periods = User::find($instructorId)->periods;

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
                "instructorId" => $request->instructorId
            ]);

            $period = Period::find($period->id);

            return response()->json([
                "success" => true,
                "payload" => $period
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function update(Request $request)
    {
        try {
            $period = Period::find($request->id);
            $updatedData = $request->only($period->getFillable);

            $period->fill($updatedData)->save();

            $period->fresh();
            return response()->json([
                "success" => true,
                "payload" => $period
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
