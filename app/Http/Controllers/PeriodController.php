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
            $user = $request->user();

            $periods = User::find($user->id)->periods;

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
            $user = $request->user();

            $period = Period::create([
                "value" => $request->value,
                "instructorId" => $user->id
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
