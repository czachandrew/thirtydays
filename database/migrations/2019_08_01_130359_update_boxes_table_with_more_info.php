<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBoxesTableWithMoreInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->string('category')->default('general');
            $table->boolean('opened')->default(false);
            $table->date('opened_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boxes', function (Blueprint $table) {
            $table->dropColumn('category'); 
            $table->dropColumn('opened');
            $table->dropColumn('opened_on');
        });
    }
}
