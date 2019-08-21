<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krates', function (Blueprint $table) {
            $table->bigIncrements('id');
            //title, description, image, cost, branded, location, status, bought, opened
            $table->string('title'); 
            $table->string('description');
            $table->string('image')->default('images/krates/generic.png');
            $table->integer('cost'); 
            $table->string('type')->default('all');
            $table->string('influence')->default(0);
            $table->boolean('branded')->default(false);
            $table->string('location')->nullable();
            $table->string('status')->default('active');
            $table->integer('bought')->default(0);
            $table->integer('opened')->opened(0);
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
        Schema::dropIfExists('krates');
    }
}
