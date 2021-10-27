<?php

namespace App\Http\Controllers;

use App\Models\ScoreAssigned;
use Illuminate\Http\Request;
use Throwable;

class ScoresAssignedController extends Controller
{
    public function update(Request $request, $scoreId)
    {
        try {
            $value = $request->value;
            ScoreAssigned::where('id', $scoreId)->update(["value" => $value]);

            return response()->json([
                "success" => true,
                "payload" => "Nota actualizada correctamente",
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function updateMany(Request $request)
    {
        try {
            foreach ($request->all() as $key => $scoreAssigned) {
                ScoreAssigned::where('id', $scoreAssigned["id"])->update(["value" => $scoreAssigned["value"]]);
            }

            return response()->json([
                "success" => true,
                "payload" => "Actualizado correctamente",
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
