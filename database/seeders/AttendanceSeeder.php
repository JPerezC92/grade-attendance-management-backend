<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendance')->insert([
            'date' => '2021-09-16',
            'courseRecordId' => 1
        ]);
        DB::table('attendance')->insert([
            'date' => '2021-09-17',
            'courseRecordId' => 1
        ]);
        DB::table('attendance')->insert([
            'date' => '2021-09-18',
            'courseRecordId' => 1
        ]);
        DB::table('attendance')->insert([
            'date' => '2021-09-19',
            'courseRecordId' => 1
        ]);
        DB::table('attendance')->insert([
            'date' => '2021-09-20',
            'courseRecordId' => 1
        ]);
    }
}
