<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->float('degree')->unsigned();
            
            // Quiz foreign id
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            $table->foreign('quiz_id')->on('quizzes')->references('id');

            // Student foreign id
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreign('student_id')->on('students')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
