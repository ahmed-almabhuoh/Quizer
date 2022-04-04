<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->text('description', 100)->nullable();
            $table->float('mark')->unsigned();
            $table->boolean('active')->default(1);

            // Teacher foreign key
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreign('teacher_id')->on('teachers')->references('id');

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
        Schema::dropIfExists('quizzes');
    }
}
