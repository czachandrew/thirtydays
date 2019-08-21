<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRewardsTableWithProviderAndStockInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rewards', function (Blueprint $table) {
            $table->integer('stock')->nullable(); 
            $table->integer('provider_id')->default(1);

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
            $table->dropColumn('stock'); 
            $table->dropColumn('provider_id');
        });
    }
}
