<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssignedScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignededScore', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer('value');
            $table->timestamps();
            $table->unsignedBigInteger('scoreId');
            $table->foreign('scoreId')->references('id')->on('score');
            $table->unsignedBigInteger('studentId');
            $table->foreign('studentId')->references('id')->on('student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignededScore');
    }
}
