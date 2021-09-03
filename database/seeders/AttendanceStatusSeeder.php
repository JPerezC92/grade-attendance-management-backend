<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendanceStatus')->insert(["value" => "asistencia"]);
        DB::table('attendanceStatus')->insert(["value" => "tardanza"]);
        DB::table('attendanceStatus')->insert(["value" => "inasistencia"]);
    }
}
