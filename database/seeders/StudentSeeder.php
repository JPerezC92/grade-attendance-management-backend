<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student')->insert([
            "studentCode" => "1248166",
            "firstname" => "ANDERSON TOMAS",
            "lastname" => "ADRIAN VIDAL",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248167",
            "firstname" => "JHEANPIER MARUAN",
            "lastname" => "AGUILAR AVILA",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248168",
            "firstname" => "MARCO ANTONIO",
            "lastname" => "ALVAN GIRALDO",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248169",
            "firstname" => "JOSEPH HABACUC",
            "lastname" => "ALVAREZ HUAMAN",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248170",
            "firstname" => "CARLOS DEL PIERO",
            "lastname" => "BANCES VASQUEZ",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248171",
            "firstname" => "PAMELA NICOLE",
            "lastname" => "BRONCANO OLORTEGUI",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248172",
            "firstname" => "ARTHUR SMITH",
            "lastname" => "CALDERON GUEVARA",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248173",
            "firstname" => "MIRKO PAVEL",
            "lastname" => "CAPURRO BUSTAMANTE",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "874254",
            "firstname" => "OLGUI ALEXANDER",
            "lastname" => "CERNA REGALADO",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248200",
            "firstname" => "BRYAN MARTIN",
            "lastname" => "DE LA VIA JULON",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248201",
            "firstname" => "ANTHONY BRAYAN",
            "lastname" => "ECHEVARRIA CONDOR",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248205",
            "firstname" => "MARIA ISABEL",
            "lastname" => "FERNANDEZ PAREDES",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248206",
            "firstname" => "ANGEL ORLANDO",
            "lastname" => "GONZALES ACEVEDO",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248210",
            "firstname" => "LUIS RONALDO",
            "lastname" => "LEON SALDAÑA",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248214",
            "firstname" => "ROBERTO JUNIOR",
            "lastname" => "MATTOS CENTURION",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248215",
            "firstname" => "IRENE BRIGGITH",
            "lastname" => "MAZA LAZARO",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248216",
            "firstname" => "FLAVIO RODRIGO",
            "lastname" => "MENDOZA MENESES",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248220",
            "firstname" => "YARITZA MASIEL",
            "lastname" => "MIRANDA SAAVEDRA",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248223",
            "firstname" => "MARCIAL SANTOS",
            "lastname" => "MONTES GIRALDO",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248225",
            "firstname" => "JHARIXA IRAIDA",
            "lastname" => "SOTO QUEZADA",
            "courseRecordId" => 1
        ]);
        DB::table('student')->insert([
            "studentCode" => "1248229",
            "firstname" => "MARK ANDERSON",
            "lastname" => "VEGA PUMA",
            "courseRecordId" => 1
        ]);

        DB::table('student')->insert([
            "studentCode" => "1248236",
            "firstname" => "DANIEL ESTEBAN",
            "lastname" => "VILLALTA BALCAZAR",
            "courseRecordId" => 1
        ]);
    }
}
