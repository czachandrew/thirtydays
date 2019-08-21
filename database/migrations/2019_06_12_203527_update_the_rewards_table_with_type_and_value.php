<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTheRewardsTableWithTypeAndValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->integer('rank')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('rank');
        });
    }
}
