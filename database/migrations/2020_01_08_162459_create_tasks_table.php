<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->integer('xp_value');
            $table->integer('zonegroup_id');
            $table->integer('user_id');
            $table->boolean('limited')->default(false);
            $table->integer('limit')->default(0);
            $table->integer('count')->default(0);
            $table->boolean('media_required')->default(false);
            $table->string('media_type')->default('photo');
            $table->string('location')->nullable();
            $table->string('coordinates')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
