<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('score')->insert([
            'name' => 'n1',
            'activityId' => 1
        ]);
        DB::table('score')->insert([
            'name' => 'n2',
            'activityId' => 1
        ]);
        DB::table('score')->insert([
            'name' => 'n1',
            'activityId' => 2
        ]);
        DB::table('score')->insert([
            'name' => 'n1',
            'activityId' => 3
        ]);
        DB::table('score')->insert([
            'name' => 'n1',
            'activityId' => 4
        ]);
    }
}
