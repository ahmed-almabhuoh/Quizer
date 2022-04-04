<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();

            // Student foreign key
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreign('student_id')->on('students')->references('id');

            // Room foreign key
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreign('room_id')->on('rooms')->references('id');

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
        Schema::dropIfExists('student_classes');
    }
}
