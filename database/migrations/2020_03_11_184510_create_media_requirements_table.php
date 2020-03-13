<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->string('type')->default('picture');
            $table->string('example_url')->nullable();
            $table->string('requireable_type');
            $table->integer('requireable_id');
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
        Schema::dropIfExists('media_requirements');
    }
}
