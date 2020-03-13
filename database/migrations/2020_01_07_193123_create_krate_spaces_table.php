<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKrateSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //name, description, visiblity, status, joinable, link, photo_url, space_xp, krate_xp,
        Schema::create('kratespaces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('name');
            $table->string('description');
            $table->string('visibility')->default('private');
            $table->string('status')->default('active');
            $table->boolean('joinable')->default(true);
            $table->string('link')->nullable();
            $table->string('photo_url')->nullable();
            $table->integer('space_xp')->default(1000);
            $table->integer('krate_xp')->default(0);
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
        Schema::dropIfExists('kratespaces');
    }
}
