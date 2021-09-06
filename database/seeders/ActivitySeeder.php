<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity')->insert([
            'name' => 'Actividades entregables',
            'value' => '20',
            'courseRecordId' => 1,
        ]);
        DB::table('activity')->insert([
            'name' => 'Foro tematico',
            'value' => '20',
            'courseRecordId' => 1,
        ]);
        DB::table('activity')->insert([
            'name' => 'Test de autoevaluacion',
            'value' => '20',
            'courseRecordId' => 1,
        ]);
        DB::table('activity')->insert([
            'name' => 'Examen final',
            'value' => '20',
            'courseRecordId' => 1,
        ]);
    }
}
