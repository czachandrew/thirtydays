<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->string('status')->default('active');
            $table->integer('total_redeemed')->default(0);
            $table->integer('total_awarded')->default(0);
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
            $table->dropColumn('status');
            $table->dropColumn('total_redeemed');
            $table->dropColumn('total_awarded');
        });
    }
}
