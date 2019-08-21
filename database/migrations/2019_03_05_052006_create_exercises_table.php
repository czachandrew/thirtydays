<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //name, description
        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title'); 
            $table->string('gif');
            $table->string('target_muscles')->nullable();
            $table->string('equipment')->default('none'); 
            $table->text('description')->nullable();
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
        Schema::dropIfExists('exercises');
    }
}
