<?php


namespace App\Http\Controllers;

use App\Models\AttendanceCheck;
use App\Models\CourseRecord;
use App\Models\ScoreAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Throwable;

class CourseRecordController extends Controller
{


    public function update(Request $request, $courseRecordId)
    {
        try {
            $courseRecord =  CourseRecord::find($courseRecordId);

            $updatedData = $request->only($courseRecord->getFillable());


            $courseRecord->fill($updatedData)->save();
            $courseRecord->fresh();

            $courseRecord->period;

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function delete(Request $request, $courseRecordId)
    {
        try {
            CourseRecord::destroy($courseRecordId);

            return response()->json([
                "success" => true,
                "payload" => "Registro eliminado con exito"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function create(Request $request)
    {
        try {
            $courseRecord = CourseRecord::create([
                'career' => $request->career,
                'turn' => $request->turn,
                'group' => $request->group,
                'semester' => $request->semester,
                'instructorId' => $request->instructorId,
                'courseId' => $request->courseId,
                'periodId' => $request->periodId,
            ]);

            $courseRecord->fresh();
            $courseRecord->period;

            return response()->json([
                "success" => true,
                "payload" => $courseRecord
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function getById(Request $request, $courseRecordId)
    {
        try {

            $courseRecordEntity = CourseRecord::with("activities", "attendances", "activities.scores")
                ->find($courseRecordId);
            $courseRecordOject = ["courseRecord" => $courseRecordEntity->attributesToArray()];
            $activitiesArray = $courseRecordEntity->activities->toArray();


            foreach ($activitiesArray as $key => $activityValue) {
                $activitiesArray[$key]["scoresQuantity"] = count($activityValue["scores"]);
            }

            $attendances = $courseRecordEntity->attendances->toArray();
            $activitiesArray2  = (array)clone (object)$activitiesArray;

            foreach ($activitiesArray2 as $key => $activityValue) {
                $activitiesArray2[$key]["scoresAssigned"] = [];
                unset($activitiesArray2[$key]["scores"]);
            }

            $courseRecordOject["activities"] = $activitiesArray;
            $courseRecordOject["attendances"] = $attendances;

            $studentsEntitiesArr = DB::table("student")
                ->where("student.courseRecordId", $courseRecordId)
                ->select(
                    "student.*",
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 1 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as attended"),
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 2 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as late"),
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 3 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as skip"),
                    DB::raw("(SELECT COUNT(attendance.id) FROM attendance WHERE attendance.courseRecordId = student.courseRecordId) as attendancesQuantity")
                )
                ->orderBy('student.lastname')
                ->get();

            $studentsArr = $studentsEntitiesArr->toArray();

            $studentsIds = [];
            foreach ($studentsArr as $key => $studentValue) {
                $attendedAverage = $studentValue->attendancesQuantity ? ((($studentValue->attended + $studentValue->late) / $studentValue->attendancesQuantity) * 100) : 0;
                $attendedAverage = round($attendedAverage, 0, PHP_ROUND_HALF_UP);
                $studentValue->attendances = [
                    "attendancesCheck" => [],
                    "attended" => $studentValue->attended,
                    "late" => $studentValue->late,
                    "skip" => $studentValue->skip,
                    "attendedAverage" => $attendedAverage
                ];

                $studentsArr[$key]->activities = (array)clone (object)$activitiesArray2;

                unset($studentValue->attended);
                unset($studentValue->late);
                unset($studentValue->skip);
                unset($studentValue->attendancesQuantity);

                array_push($studentsIds, $studentValue->id);
            }

            $attendancesCheck = AttendanceCheck::whereIn("attendanceCheck.studentId", $studentsIds)
                ->select(
                    "attendanceCheck.*",
                    DB::raw("(SELECT attendanceStatus.value FROM attendanceStatus WHERE attendanceStatus.id = attendanceCheck.attendanceStatusId) as attendanceStatusValue")
                )
                ->orderBy("attendanceCheck.created_at")
                ->get();

            $scoresAssigned = ScoreAssigned::whereIn("scoreAssigned.studentId", $studentsIds)
                ->select("scoreAssigned.*")
                ->get();


            foreach ($attendancesCheck as $key => $attendanceCheckValue) {
                foreach ($studentsArr as $key => $studentValue) {
                    if ($attendanceCheckValue["studentId"] === $studentValue->id) {
                        array_push($studentValue->attendances["attendancesCheck"], $attendanceCheckValue);
                    }
                }
            }

            foreach ($studentsArr as $studentsArrKey => $studentValue) {
                $finalScore = 0;
                foreach ($studentValue->activities as $activitiesKey => $activityValues) {
                    $average = 0;
                    $scoresQuantity = $studentValue->activities[$activitiesKey]["scoresQuantity"];
                    foreach ($scoresAssigned as $scoreAssignedKey => $scoreAssignedValue) {
                        if (
                            $studentValue->id === $scoreAssignedValue->studentId
                            && $activityValues["id"] === $scoreAssignedValue->activityId
                        ) {
                            $average += $scoreAssignedValue->value;
                            array_push($studentValue->activities[$activitiesKey]["scoresAssigned"], $scoreAssignedValue);
                        }
                    }
                    $average = $average / $scoresQuantity;
                    $studentValue->activities[$activitiesKey]["average"] = round($average, 2);

                    $finalScore += $average * $activityValues["value"] / 100;
                }
                $studentsArr[$studentsArrKey]->finalScore = round($finalScore, 2);
                $studentsArr[$studentsArrKey]->finalScoreRounded = round($finalScore, 0, PHP_ROUND_HALF_UP);
            }

            $courseRecordOject["students"] = $studentsArr;

            return response()->json([
                "success" => true,
                "payload" => $courseRecordOject
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function createExcel(Request $request, $courseRecordId)
    {
        try {

            $courseRecordEntity = CourseRecord::with("activities", "attendances", "activities.scores")->find($courseRecordId);
            $courseRecordOject = ["courseRecord" => $courseRecordEntity->attributesToArray()];
            $activitiesArray = $courseRecordEntity->activities->toArray();


            foreach ($activitiesArray as $key => $activityValue) {
                $activitiesArray[$key]["scoresQuantity"] = count($activityValue["scores"]);
            }

            $attendances = $courseRecordEntity->attendances->toArray();
            $activitiesArray2  = (array)clone (object)$activitiesArray;

            foreach ($activitiesArray2 as $key => $activityValue) {
                $activitiesArray2[$key]["scoresAssigned"] = [];
                unset($activitiesArray2[$key]["scores"]);
            }

            $courseRecordOject["activities"] = $activitiesArray;
            $courseRecordOject["attendances"] = $attendances;

            $studentsEntitiesArr = DB::table("student")
                ->where("student.courseRecordId", $courseRecordId)
                ->select(
                    "student.*",
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 1 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as attended"),
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 2 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as late"),
                    DB::raw("(SELECT COUNT(CASE attendanceCheck.attendanceStatusId WHEN 3 THEN 1 ELSE	NULL END) FROM attendanceCheck WHERE attendanceCheck.studentId = student.id) as skip"),
                    DB::raw("(SELECT COUNT(attendance.id) FROM attendance WHERE attendance.courseRecordId = student.courseRecordId) as attendancesQuantity")
                )
                ->get();

            $studentsArr = $studentsEntitiesArr->toArray();

            $studentsIds = [];
            foreach ($studentsArr as $key => $studentValue) {
                $attendedAverage = $studentValue->attendancesQuantity ? ((($studentValue->attended + $studentValue->late) / $studentValue->attendancesQuantity) * 100) : 0;
                $attendedAverage = round($attendedAverage, 0, PHP_ROUND_HALF_UP);
                $studentValue->attendances = [
                    "attendancesCheck" => [],
                    "attended" => $studentValue->attended,
                    "late" => $studentValue->late,
                    "skip" => $studentValue->skip,
                    "attendedAverage" => $attendedAverage
                ];

                $studentsArr[$key]->activities = (array)clone (object)$activitiesArray2;

                unset($studentValue->attended);
                unset($studentValue->late);
                unset($studentValue->skip);
                unset($studentValue->attendancesQuantity);

                array_push($studentsIds, $studentValue->id);
            }

            $attendancesCheck = AttendanceCheck::whereIn("attendanceCheck.studentId", $studentsIds)
                ->select(
                    "attendanceCheck.*",
                    DB::raw("(SELECT attendanceStatus.value FROM attendanceStatus WHERE attendanceStatus.id = attendanceCheck.attendanceStatusId) as attendanceStatusValue")
                )
                ->orderBy("attendanceCheck.created_at")
                ->get();

            $scoresAssigned = ScoreAssigned::whereIn("scoreAssigned.studentId", $studentsIds)
                ->select("scoreAssigned.*")
                ->get();


            foreach ($attendancesCheck as $key => $attendanceCheckValue) {
                foreach ($studentsArr as $key => $studentValue) {
                    if ($attendanceCheckValue["studentId"] === $studentValue->id) {
                        array_push($studentValue->attendances["attendancesCheck"], $attendanceCheckValue);
                    }
                }
            }

            foreach ($studentsArr as $studentsArrKey => $studentValue) {
                $finalScore = 0;
                foreach ($studentValue->activities as $activitiesKey => $activityValues) {
                    $average = 0;
                    $scoresQuantity = $studentValue->activities[$activitiesKey]["scoresQuantity"];
                    foreach ($scoresAssigned as $scoreAssignedKey => $scoreAssignedValue) {
                        if (
                            $studentValue->id === $scoreAssignedValue->studentId
                            && $activityValues["id"] === $scoreAssignedValue->activityId
                        ) {
                            $average += $scoreAssignedValue->value;
                            array_push($studentValue->activities[$activitiesKey]["scoresAssigned"], $scoreAssignedValue);
                        }
                    }
                    $average = $average / $scoresQuantity;
                    $studentValue->activities[$activitiesKey]["average"] = round($average, 2);

                    $finalScore += $average * $activityValues["value"] / 100;
                }
                $studentsArr[$studentsArrKey]->finalScore = round($finalScore, 2);
                $studentsArr[$studentsArrKey]->finalScoreRounded = round($finalScore, 0, PHP_ROUND_HALF_UP);
            }

            $courseRecordOject["students"] = $studentsArr;


            // CREATE EXCEL
            $spreadsheet = new Spreadsheet();

            $gradeWorksheet = new Worksheet($spreadsheet, "Calificaciones");
            $attendanceWorksheet = new Worksheet($spreadsheet, "Asistencias");

            $startRowHeader = 11;
            $startColumnHeader = 0;

            $rowHeader = $startRowHeader;


            //
            if (count($courseRecordOject["activities"]) > 0) {

                // Header Calificaciones
                $gradeWorksheet
                    ->setCellValue("A{$rowHeader}", "Codigo")
                    ->setCellValue("B{$rowHeader}", "Nombres")
                    ->setCellValue("C{$rowHeader}", "Apellidos");


                $rowHeaderMain = $rowHeader - 1;
                $gradeWorksheet->setCellValue("A" . $rowHeaderMain, "Lista de studiantes")
                    ->mergeCells("A" . $rowHeaderMain  . ":C" . $rowHeaderMain);

                $startColumnHeader = 4;
                $startColumnFinals = 0;
                $finalScoreColumn = "";
                $finalScoreRoundedColumn = "";

                foreach ($courseRecordOject["students"][0]->activities as $key2 => $activityValue) {
                    $column1 = Coordinate::stringFromColumnIndex($startColumnHeader);
                    $column2 = Coordinate::stringFromColumnIndex($startColumnHeader);

                    if ($activityValue["scoresQuantity"] > 1) {
                        $column2 = Coordinate::stringFromColumnIndex($startColumnHeader + $activityValue["scoresQuantity"]);
                    }

                    $gradeWorksheet->setCellValue($column1 . $rowHeaderMain, $activityValue["name"])
                        ->mergeCells($column1 . $rowHeaderMain  . ":" . $column2  . $rowHeaderMain);

                    foreach ($activityValue["scoresAssigned"] as $key3 => $scoreAssignedValue) {
                        $column = Coordinate::stringFromColumnIndex($startColumnHeader++);
                        $gradeWorksheet
                            ->setCellValue("{$column}{$rowHeader}", "N" . $key3 + 1);
                    }

                    if ($activityValue["scoresQuantity"] > 1) {
                        $column = Coordinate::stringFromColumnIndex($startColumnHeader++);
                        $gradeWorksheet
                            ->setCellValue("{$column}{$rowHeader}", "Promedio");
                    }
                }

                $startColumnFinals = $startColumnHeader;
                $finalScoreColumn = Coordinate::stringFromColumnIndex($startColumnFinals);
                $finalScoreRoundedColumn = Coordinate::stringFromColumnIndex($startColumnFinals + 1);

                $gradeWorksheet
                    ->setCellValue("{$finalScoreColumn}{$rowHeader}", "Nota Final")
                    ->setCellValue("{$finalScoreRoundedColumn}{$rowHeader}", "Redondeo");

                $startRow = 12;
                $startColumn = 0;

                $row = $startRow;

                // Body Calificaciones
                foreach ($courseRecordOject["students"] as $key => $studentValue) {
                    $gradeWorksheet
                        ->setCellValue("A{$row}", $studentValue->studentCode)
                        ->setCellValue("B{$row}", $studentValue->firstname)
                        ->setCellValue("C{$row}", $studentValue->lastname);
                    $startColumn = 4;


                    $startColumnFinals = 0;
                    $finalScoreColumn = "";
                    $finalScoreRoundedColumn = "";

                    foreach ($studentValue->activities as $key2 => $activityValue) {
                        foreach ($activityValue["scoresAssigned"] as $key3 => $scoreAssignedValue) {
                            $column = Coordinate::stringFromColumnIndex($startColumn++);
                            $gradeWorksheet
                                ->setCellValue("{$column}{$row}", $scoreAssignedValue->value);
                        }
                        if ($activityValue["scoresQuantity"] > 1) {
                            $column = Coordinate::stringFromColumnIndex($startColumn++);
                            $gradeWorksheet
                                ->setCellValue("{$column}{$row}", $activityValue["average"]);
                        }
                    }

                    $startColumnFinals = $startColumn;
                    $finalScoreColumn = Coordinate::stringFromColumnIndex($startColumnFinals);
                    $finalScoreRoundedColumn = Coordinate::stringFromColumnIndex($startColumnFinals + 1);

                    $gradeWorksheet
                        ->setCellValue("{$finalScoreColumn}{$row}", $studentValue->finalScore)
                        ->setCellValue("{$finalScoreRoundedColumn}{$row}", $studentValue->finalScoreRounded);
                    $row++;
                }
            }
            // 
            //
            if (count($courseRecordOject["attendances"]) > 0) {
                // Header Asistencias
                $startRowHeader = 11;
                $startColumnHeader = 0;

                $rowHeader = $startRowHeader;
                $attendanceWorksheet
                    ->setCellValue("A{$rowHeader}", "Codigo")
                    ->setCellValue("B{$rowHeader}", "Nombres")
                    ->setCellValue("C{$rowHeader}", "Apellidos");

                $attendanceWorksheet->setCellValue("A" . $startRowHeader - 1, "Lista de studiantes")
                    ->mergeCells("A" . $startRowHeader - 1  . ":C" . $startRowHeader - 1);

                $lastColDates = Coordinate::stringFromColumnIndex(3 + count($courseRecordOject["attendances"]));
                $attendanceWorksheet->setCellValue("D" . $startRowHeader - 1, "Fechas")
                    ->mergeCells("D" . $startRowHeader - 1  . ":" . $lastColDates . $startRowHeader - 1);

                $firstColDatesResumen = Coordinate::stringFromColumnIndex(4 + count($courseRecordOject["attendances"]));
                $lastColDatesResumen = Coordinate::stringFromColumnIndex(6 + count($courseRecordOject["attendances"]));
                $attendanceWorksheet->setCellValue($firstColDatesResumen . $startRowHeader - 1, "Resumen")
                    ->mergeCells($firstColDatesResumen . $startRowHeader - 1  . ":" . $lastColDatesResumen . $startRowHeader - 1);



                $startColumnHeader = 4;
                foreach ($courseRecordOject["attendances"] as $key => $attendanceValue) {
                    $headerColumn = Coordinate::stringFromColumnIndex($startColumnHeader++);
                    $attendanceWorksheet
                        ->setCellValue($headerColumn . $rowHeader, $attendanceValue["date"]);
                }

                $attendanceWorksheet
                    ->setCellValue(Coordinate::stringFromColumnIndex($startColumnHeader++) . $rowHeader, "A")
                    ->setCellValue(Coordinate::stringFromColumnIndex($startColumnHeader++) . $rowHeader, "T")
                    ->setCellValue(Coordinate::stringFromColumnIndex($startColumnHeader++) . $rowHeader, "I")
                    ->setCellValue(Coordinate::stringFromColumnIndex($startColumnHeader++) . $rowHeader, "% Asistencias");

                // Body Asistencias
                $startRowHeader = 12;
                $startColumnHeader = 4;
                $rowHeader = $startRowHeader;

                foreach ($courseRecordOject["students"] as $key => $studentValue) {
                    $attendanceWorksheet
                        ->setCellValue("A" . $rowHeader, $studentValue->studentCode)
                        ->setCellValue("B" . $rowHeader, $studentValue->firstname)
                        ->setCellValue("C" . $rowHeader, $studentValue->lastname);
                    $colum = 4;
                    foreach ($studentValue->attendances["attendancesCheck"] as $key => $attendancesCheckValue) {
                        $attendanceWorksheet
                            ->setCellValue(Coordinate::stringFromColumnIndex($colum++) . $rowHeader, strtoupper(substr($attendancesCheckValue->attendanceStatusValue, 0, 1)));
                    }

                    $attendanceWorksheet
                        ->setCellValue(Coordinate::stringFromColumnIndex($colum++) . $rowHeader, $studentValue->attendances["attended"])
                        ->setCellValue(Coordinate::stringFromColumnIndex($colum++) . $rowHeader, $studentValue->attendances["late"])
                        ->setCellValue(Coordinate::stringFromColumnIndex($colum++) . $rowHeader, $studentValue->attendances["skip"])
                        ->setCellValue(Coordinate::stringFromColumnIndex($colum++) . $rowHeader, $studentValue->attendances["attendedAverage"] . "%");
                    $rowHeader++;
                }
            }
            //

            $spreadsheet->addSheet($gradeWorksheet, 0);
            $spreadsheet->addSheet($attendanceWorksheet, 1);
            $spreadsheet->removeSheetByIndex(2);
            $writer = new Xlsx($spreadsheet);
            $writer->save('output.xlsx');

            $headers  = array(
                'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition: attachment;filename="' . "output.xlsx" . '"',
                'Cache-Control: max-age=0'
            );

            $exportFile = storage_path('../public/output.xlsx');
            // return response()->download($exportFile, "output.xlsx", $headers)->deleteFileAfterSend();
            return response()->file($exportFile, $headers);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
