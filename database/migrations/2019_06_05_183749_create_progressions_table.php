<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progressions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('level')->default(1);
            $table->integer('lifetime_xp')->default(0);
            $table->integer('current_xp')->default(0);
            $table->integer('redeemed_xp')->default(0);
            $table->integer('next_level')->default(200);
            $table->integer('gifts')->default(0);
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
        Schema::dropIfExists('progressions');
    }
}
