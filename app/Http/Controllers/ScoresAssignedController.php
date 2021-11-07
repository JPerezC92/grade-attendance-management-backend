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
            // $value = $request->value;
            // ScoreAssigned::where('id', $scoreId)->update(["value" => $value]);

            $scoreAssigned = ScoreAssigned::find($scoreId);
            $updatedData = $request->only($scoreAssigned->getFillable());
            $scoreAssigned->fill($updatedData)->save();


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
            foreach ($request->all() as $key => $scoreAssignedValue) {
                $scoreAssigned = ScoreAssigned::find($scoreAssignedValue["id"]);

                if ($scoreAssigned->value !== round($scoreAssignedValue["value"], 2)) {
                    $scoreAssigned->value = $scoreAssignedValue["value"];
                    $scoreAssigned->save();
                }
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
