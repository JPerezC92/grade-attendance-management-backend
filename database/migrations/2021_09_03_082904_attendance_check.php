<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttendanceCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendanceCheck', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->timestamps();

            $table->unsignedBigInteger('attendanceId');
            $table->foreign('attendanceId')->references('id')->on('attendance')->onDelete('cascade');;
            $table->unsignedBigInteger('studentId');
            $table->foreign('studentId')->references('id')->on('student');
            $table->unsignedBigInteger('attendanceStatusId')->nullable();
            $table->foreign('attendanceStatusId')->references('id')->on('attendanceStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendanceCheck');
    }
}
