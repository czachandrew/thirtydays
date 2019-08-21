<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //measurement types: For Time, For Reps, For Load, For Distance, For Completion 
        Schema::create('workouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title'); 
            $table->string('gif');
            $table->text('description');
            $table->string('type');
            $table->string('type_label');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('workouts');
    }
}
