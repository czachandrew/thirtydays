<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workout_id');
            $table->integer('challenge_id'); 
            $table->integer('user_id'); 
            $table->string('image')->nullable();
            $table->string('type');
            $table->string('description')->nullable();
            $table->string('time')->nullable(); 
            $table->string('score')->nullable(); 
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('submissions');
    }
}
