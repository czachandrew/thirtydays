<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeAndPartialAmountColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usertasks', function (Blueprint $table) {
            $table->string('type')->default('single');
            $table->integer('partial_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usertasks', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('partial_amount');
        });
    }
}
