<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ScoreAssigned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoreAssigned', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->float('value', 5, 2);
            $table->timestamps();
            $table->unsignedBigInteger('scoreId');
            $table->foreign('scoreId')->references('id')->on('score')->onDelete('cascade');
            $table->unsignedBigInteger('studentId');
            $table->foreign('studentId')->references('id')->on('student');
            $table->unsignedBigInteger('activityId');
            $table->foreign('activityId')->references('id')->on('activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scoreAssigned');
    }
}
