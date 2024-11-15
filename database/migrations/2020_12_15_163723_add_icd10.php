<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIcd10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icd10', function (Blueprint $table) {
            $table->string('group',255)->nullable()->after('description');
            $table->string('case_rate',50)->nullable()->after('group');
            $table->string('professional_fee',50)->nullable()->after('case_rate');
            $table->string('health_care_fee',50)->nullable()->after('professional_fee');
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
