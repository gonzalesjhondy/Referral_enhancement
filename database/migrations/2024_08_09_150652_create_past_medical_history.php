<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastMedicalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_medical_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->nullable();
            $table->string('commordities_selectAll')->nullable();
            $table->string('commordities_hypertension_since')->nullable();
            $table->string('commordities_cancer_specify')->nullable();
            $table->string('commordities_diabetes_mellitus_since')->nullable();
            $table->string('commordities_bronchial_asthma_since')->nullable();
            $table->string('commordities_others')->nullable();
            $table->string('allergies_selectAll')->nullable();
            $table->string('allergies_foods')->nullable();
            $table->string('allergies_drugs')->nullable();
            $table->string('allergies_others')->nullable();
            $table->string('heredofamilial_diseases_selectAll')->nullable();
            $table->string('heredofamilial_diseases_hypertension')->nullable();
            $table->string('heredofamilial_diseases_diabetes_mellitus')->nullable();
            $table->string('heredofamilial_diseases_bronchial_asthma')->nullable();
            $table->string('heredofamilial_diseases_cancer')->nullable();
            $table->string('heredofamilial_diseases_kidney')->nullable();
            $table->string('heredofamilial_diseases_thyroid')->nullable();
            $table->string('heredofamilial_diseases_others')->nullable();
            $table->string('previous_hospitalization')->nullable();
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
        Schema::dropIfExists('past_medical_history');
    }
}
