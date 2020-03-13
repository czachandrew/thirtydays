<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonegroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //name, description, type, join_method, status, kratezone_id
        Schema::create('zonegroups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); 
            $table->string('description')->nullable(); 
            $table->string('type')->nullable(); 
            $table->string("join_method")->default('approval'); //approval, open, invitation
            $table->string('status')->default('open'); 
            $table->integer('kratespace_id');
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
        Schema::dropIfExists('zonegroups');
    }
}
