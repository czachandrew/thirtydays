<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsertasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usertasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('task_id');
            $table->integer('user_id');
            $table->integer('zonegroup_id');
            $table->string('status')->default('needs approval');
            $table->string('location')->nullable();
            $table->string('media_type')->nullable(); 
            $table->string('media_link')->nullable();
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
        Schema::dropIfExists('usertasks');
    }
}
