<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserKratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_krates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('krate_id'); 
            $table->integer('user_id');
            $table->string('hash');
            $table->string('status')->default('unopened');
            $table->date('opened_on')->nullable();
            $table->date('expiration')->nullable();
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
        Schema::dropIfExists('user_krates');
    }
}
