<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workout_id')->nullable(); 
            $table->integer('challenge_id');
            $table->string('type')->default('work');
            $table->integer('order');
            $table->string('status')->default('scheduled');
            $table->text('coach_notes')->nullable();
            $table->date('scheduled_on')->nullable();
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
        Schema::dropIfExists('challenge_days');
    }
}
