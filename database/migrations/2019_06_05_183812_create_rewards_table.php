<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title'); 
            $table->text('description');
            $table->boolean('redeemable')->default(false);
            $table->boolean('redeemed')->default(false);
            $table->string('image')->default('/rewards/default.png');
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
        Schema::dropIfExists('rewards');
    }
}
