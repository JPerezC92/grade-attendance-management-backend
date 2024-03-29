<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(InstructorSeeder::class);
        // $this->call(CourseSeeder::class);
        // $this->call(PeriodSeeder::class);
        // $this->call(CourseRecordSeeder::class);
        // $this->call(StudentSeeder::class);
        // $this->call(AttendanceSeeder::class);
        // $this->call(ActivitySeeder::class);
        // $this->call(ScoreSeeder::class);
        // $this->call(ScoreAssigned::class);
        $this->call(AttendanceStatusSeeder::class);
    }
}
