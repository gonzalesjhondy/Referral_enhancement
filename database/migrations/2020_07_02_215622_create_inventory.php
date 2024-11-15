<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('inventory')){
            return true;
        }
        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_id')->nullable();
            $table->integer('encoded_by')->nullable();
            $table->string('name')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('occupied')->nullable();
            $table->integer('available')->nullable();
            $table->string('status')->nullable();
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
        //
    }
}
