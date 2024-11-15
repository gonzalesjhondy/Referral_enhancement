<hr>
<?php

    function convertToZero($value){
        if($value)
            return $value;

        return 0;
    }
    //ELIGIBLE POP SINOVAC
    $total_e_pop_a1_grand =  \App\Facility::select(DB::raw("sum(COALESCE(a1,0)) as a1"))->where("tricity_id",$tricity_id)->first()->a1;  //TOTAL ELIPOP A1
    $total_e_pop_a2_grand  = \App\Facility::select(DB::raw("sum(COALESCE(a2,0)) as a2"))->where("tricity_id",$tricity_id)->first()->a2; //TOTAL ELIPOP A2
    $total_e_pop_a3_grand  = \App\Facility::select(DB::raw("sum(COALESCE(a3,0)) as a3"))->where("tricity_id",$tricity_id)->first()->a3; //TOTAL ELIPOP A3
    $total_e_pop_a4_grand  = \App\Facility::select(DB::raw("sum(COALESCE(a4,0)) as a4"))->where("tricity_id",$tricity_id)->first()->a4; //TOTAL ELIPOP A4
    $total_e_pop_a5_grand  = \App\Facility::select(DB::raw("sum(COALESCE(a5,0)) as a5"))->where("tricity_id",$tricity_id)->first()->a5; //TOTAL ELIPOP A5
    $total_e_pop_b1_grand  = \App\Facility::select(DB::raw("sum(COALESCE(b1,0)) as b1"))->where("tricity_id",$tricity_id)->first()->b1; //TOTAL ELIPOP B1
    $total_e_pop_b2_grand  = \App\Facility::select(DB::raw("sum(COALESCE(b2,0)) as b2"))->where("tricity_id",$tricity_id)->first()->b2; //TOTAL ELIPOP B2
    $total_e_pop_b3_grand  = \App\Facility::select(DB::raw("sum(COALESCE(b3,0)) as b3"))->where("tricity_id",$tricity_id)->first()->b3; //TOTAL ELIPOP B3
    $total_e_pop_b4_grand  = \App\Facility::select(DB::raw("sum(COALESCE(b4,0)) as b4"))->where("tricity_id",$tricity_id)->first()->b4; //TOTAL ELIPOP B4
    $total_e_pop_grand = $total_e_pop_a1_grand + $total_e_pop_a2_grand + $total_e_pop_a3_grand + $total_e_pop_a4_grand + $total_e_pop_a5_grand +
                         $total_e_pop_b1_grand + $total_e_pop_b2_grand + $total_e_pop_b3_grand + $total_e_pop_b4_grand; //TOTAL ELI POP

    //VACCINE_ALLOCATED
    $total_vallocated_svac_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(sinovac_allocated_first,0)) as sinovac_allocated_first"))->where("tricity_id",$tricity_id)->first()->sinovac_allocated_first :0; //VACCINE ALLOCATED (FD) SINOVAC_FIRST
    $total_vallocated_svac_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(sinovac_allocated_second,0)) as sinovac_allocated_second"))->where("tricity_id",$tricity_id)->first()->sinovac_allocated_second :0; //VACCINE ALLOCATED (SD) SINOVAC_FIRST
    $total_vallocated_astra_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(astrazeneca_allocated_first,0)) as astrazeneca_allocated_first"))->where("tricity_id",$tricity_id)->first()->astrazeneca_allocated_first :0; //VACCINE_ALLOCATED (FD) ASTRA_FIRST
    $total_vallocated_astra_scnd_grand= $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(astrazeneca_allocated_second,0)) as astrazeneca_allocated_second"))->where("tricity_id",$tricity_id)->first()->astrazeneca_allocated_second :0; //VACCINE ALLOCATED (SD) ASTRA_FIRST
    $total_vallocated_pfizer_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(pfizer_allocated_first,0)) as pfizer_allocated_first"))->where("tricity_id",$tricity_id)->first()->pfizer_allocated_first :0; //VACCINE ALLOCATED (FD) PFIZER_FIRST
    $total_vallocated_pfizer_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(pfizer_allocated_second,0)) as pfizer_allocated_second"))->where("tricity_id",$tricity_id)->first()->pfizer_allocated_second :0; //VACCINE ALLOCATED (SD) PFIZER_FIRST
    $total_vallocated_sputnikv_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(sputnikv_allocated_first,0)) as sputnikv_allocated_first"))->where("tricity_id",$tricity_id)->first()->sputnikv_allocated_first :0; //VACCINE ALLOCATED (FD) SPUTNIKV_FIRST
    $total_vallocated_sputnikv_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(sputnikv_allocated_second,0)) as sputnikv_allocated_second"))->where("tricity_id",$tricity_id)->first()->sputnikv_allocated_second :0; //VACCINE ALLOCATED (SD) SPUTNIKV_FIRST
    $total_vallocated_moderna_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(moderna_allocated_first,0)) as moderna_allocated_first"))->where("tricity_id",$tricity_id)->first()->moderna_allocated_first :0; //VACCINE ALLOCATED (FD) MODERNA_FIRST
    $total_vallocated_moderna_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(moderna_allocated_second,0)) as moderna_allocated_second"))->where("tricity_id",$tricity_id)->first()->moderna_allocated_second :0; //VACCINE ALLOCATED (SD) MODERNA_FIRST
    $total_vallocated_johnson_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(johnson_allocated_first,0)) as johnson_allocated_first"))->where("tricity_id",$tricity_id)->first()->johnson_allocated_first :0; //VACCINE ALLOCATED (FD) JOHNSON_FIRST
    $total_vallocated_johnson_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? \App\Facility::select(\DB::raw("SUM(COALESCE(johnson_allocated_second,0)) as johnson_allocated_second"))->where("tricity_id",$tricity_id)->first()->johnson_allocated_second :0; //VACCINE ALLOCATED (SD) JOHNSON_FIRST

    //SINOVAC FIRST
    $total_svac_a1_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A1) SINOVAC_FIRST
    $total_svac_a2_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A2) SINOVAC_FIRST
    $total_svac_a3_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A3) SINOVAC_FIRST
    $total_svac_a4_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A4) SINOVAC_FIRST
    $total_svac_a5_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A5) SINOVAC_FIRST
    $total_svac_b1_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B1) SINOVAC_FIRST
    $total_svac_b2_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B2) SINOVAC_FIRST
    $total_svac_b3_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B3) SINOVAC_FIRST
    $total_svac_b4_frst_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B4) SINOVAC_FIRST

    //SINOVAC SECOND
    $total_svac_a1_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A1) SINOVAC_SECOND
    $total_svac_a2_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A2) SINOVAC_SECOND
    $total_svac_a3_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A3) SINOVAC_SECOND
    $total_svac_a4_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A4) SINOVAC_SECOND
    $total_svac_a5_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A5) SINOVAC_SECOND
    $total_svac_b1_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B1) SINOVAC_SECOND
    $total_svac_b2_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B2) SINOVAC_SECOND
    $total_svac_b3_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B3) SINOVAC_SECOND
    $total_svac_b4_scnd_grand = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B4) SINOVAC_SECOND

    //ASTRAZENECA FIRST
    $total_astra_a1_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A1) ASTRAZENECA_FIRST
    $total_astra_a2_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A2) ASTRAZENECA_FIRST
    $total_astra_a3_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A3) ASTRAZENECA_FIRST
    $total_astra_a4_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A4) ASTRAZENECA_FIRST
    $total_astra_a5_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A5) ASTRAZENECA_FIRST
    $total_astra_b1_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B1) ASTRAZENECA_FIRST
    $total_astra_b2_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B2) ASTRAZENECA_FIRST
    $total_astra_b3_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B3) ASTRAZENECA_FIRST
    $total_astra_b4_frst_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B4) ASTRAZENECA_FIRST

    //ASTRAZENECA SECOND
    $total_astra_a1_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A1) ASTRAZENECA_SECOND
    $total_astra_a2_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A2) ASTRAZENECA_SECOND
    $total_astra_a3_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A3) ASTRAZENECA_SECOND
    $total_astra_a4_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A4) ASTRAZENECA_SECOND
    $total_astra_a5_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A5) ASTRAZENECA_SECOND
    $total_astra_b1_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_second ):0; //VACCINATED (B1) ASTRAZENECA_SECOND
    $total_astra_b2_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B2) ASTRAZENECA_SECOND
    $total_astra_b3_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B3) ASTRAZENECA_SECOND
    $total_astra_b4_scnd_grand = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B4) ASTRAZENECA_SECOND

    //PFIZER FIRST
    $total_pfizer_a1_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A1) PFIZER_FIRST
    $total_pfizer_a2_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A2) PFIZER_FIRST
    $total_pfizer_a3_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A3) PFIZER_FIRST
    $total_pfizer_a4_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A4) PFIZER_FIRST
    $total_pfizer_a5_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A5) PFIZER_FIRST
    $total_pfizer_b1_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B1) PFIZER_FIRST
    $total_pfizer_b2_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B2) PFIZER_FIRST
    $total_pfizer_b3_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B3) PFIZER_FIRST
    $total_pfizer_b4_frst_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B4) PFIZER_FIRST
    //PFIZER SECOND
    $total_pfizer_a1_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A1) PFIZER_SECOND
    $total_pfizer_a2_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A2) PFIZER_SECOND
    $total_pfizer_a3_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A3) PFIZER_SECOND
    $total_pfizer_a4_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A4) PFIZER_SECOND
    $total_pfizer_a5_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A5) PFIZER_SECOND
    $total_pfizer_b1_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B1) PFIZER_SECOND
    $total_pfizer_b2_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B2) PFIZER_SECOND
    $total_pfizer_b3_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B3) PFIZER_SECOND
    $total_pfizer_b4_scnd_grand = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B4) PFIZER_SECOND

    //SPUTNIKV FIRST
    $total_sputnikv_a1_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A1) SPUTNIKV_FIRST
    $total_sputnikv_a2_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A2) SPUTNIKV_FIRST
    $total_sputnikv_a3_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A3) SPUTNIKV_FIRST
    $total_sputnikv_a4_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A4) SPUTNIKV_FIRST
    $total_sputnikv_a5_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A5) SPUTNIKV_FIRST
    $total_sputnikv_b1_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B1) SPUTNIKV_FIRST
    $total_sputnikv_b2_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B2) SPUTNIKV_FIRST
    $total_sputnikv_b3_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B3) SPUTNIKV_FIRST
    $total_sputnikv_b4_frst_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B4) SPUTNIKV_FIRST
   //SPUTNIK SECOND
    $total_sputnikv_a1_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A1) SPUTNIKV_SECOND
    $total_sputnikv_a2_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A2) SPUTNIKV_SECOND
    $total_sputnikv_a3_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A3) SPUTNIKV_SECOND
    $total_sputnikv_a4_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A4) SPUTNIKV_SECOND
    $total_sputnikv_a5_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A5) SPUTNIKV_SECOND
    $total_sputnikv_b1_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B1) SPUTNIKV_SECOND
    $total_sputnikv_b2_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B2) SPUTNIKV_SECOND
    $total_sputnikv_b3_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B3) SPUTNIKV_SECOND
    $total_sputnikv_b4_scnd_grand = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B4) SPUTNIKV_SECOND

    //MODERNA FIRST
    $total_moderna_a1_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A1) MODERNA_FIRST
    $total_moderna_a2_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A2) MODERNA_FIRST
    $total_moderna_a3_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A3) MODERNA_FIRST
    $total_moderna_a4_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A4) MODERNA_FIRST
    $total_moderna_a5_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A5) MODERNA_FIRST
    $total_moderna_b1_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B1) MODERNA_FIRST
    $total_moderna_b2_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B2) MODERNA_FIRST
    $total_moderna_b3_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B3) MODERNA_FIRST
    $total_moderna_b4_frst_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B4) MODERNA_FIRST
   //MODERNA SECOND
    $total_moderna_a1_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A1) MODERNA_SECOND
    $total_moderna_a2_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A2) MODERNA_SECOND
    $total_moderna_a3_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A3) MODERNA_SECOND
    $total_moderna_a4_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A4) MODERNA_SECOND
    $total_moderna_a5_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A5) MODERNA_SECOND
    $total_moderna_b1_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B1) MODERNA_SECOND
    $total_moderna_b2_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B2) MODERNA_SECOND
    $total_moderna_b3_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B3) MODERNA_SECOND
    $total_moderna_b4_scnd_grand = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B4) MODERNA_SECOND

    //JOHNSON FIRST
    $total_johnson_a1_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A1) JOHNSON_FIRST
    $total_johnson_a2_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A2) JOHNSON_FIRST
    $total_johnson_a3_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A3) JOHNSON_FIRST
    $total_johnson_a4_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A4) JOHNSON_FIRST
    $total_johnson_a5_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (A5) JOHNSON_FIRST
    $total_johnson_b1_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B1) JOHNSON_FIRST
    $total_johnson_b2_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B2) JOHNSON_FIRST
    $total_johnson_b3_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B3) JOHNSON_FIRST
    $total_johnson_b4_frst_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_first) :0; //VACCINATED (B4) JOHNSON_FIRST
    //JOHNSON SECOND
    $total_johnson_a1_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A1) JOHNSON_SECOND
    $total_johnson_a2_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A2) JOHNSON_SECOND
    $total_johnson_a3_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A3) JOHNSON_SECOND
    $total_johnson_a4_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A4) JOHNSON_SECOND
    $total_johnson_a5_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (A5) JOHNSON_SECOND
    $total_johnson_b1_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B1) JOHNSON_SECOND
    $total_johnson_b2_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B2) JOHNSON_SECOND
    $total_johnson_b3_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B3) JOHNSON_SECOND
    $total_johnson_b4_scnd_grand = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->where("muncity_id",$muncity_id)->first()->vaccinated_second) :0; //VACCINATED (B4) JOHNSON_SECOND


    $total_mild_svac_frst_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->mild_first) :0; //MILD SINOVAC_FIRST
    $total_mild_astra_frst_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->mild_first) :0; //MILD ASTRA_FIRST
    $total_mild_pfizer_frst_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->mild_first) :0; //MILD PFIZER_FIRST
    $total_mild_sputnikv_frst_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->mild_first) :0; //MILD SPUTNIKV_FIRST
    $total_mild_moderna_frst_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->mild_first) :0; //MILD MODERNA_FIRST
    $total_mild_johnson_frst_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->mild_first) :0; //MILD JOHNSON_FIRST

    $total_mild_svac_scnd_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->mild_second) :0; //MILD SINOVAC_SECOND
    $total_mild_astra_scnd_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->mild_second) :0; //MILD ASTRA_SECOND
    $total_mild_pfizer_scnd_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->mild_second) :0; //MILD PFIZER_SECOND
    $total_mild_sputnikv_scnd_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->mild_second) :0; //MILD SPUTNIKV_SECOND
    $total_mild_moderna_scnd_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->mild_second) :0; //MILD MODERNA_SECOND
    $total_mild_johnson_scnd_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->mild_second) :0; //MILD JOHNSON_SECOND

    $total_srs_svac_frst_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->serious_first) :0; //SERIOUS SINOVAC_FIRST
    $total_srs_astra_frst_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->serious_first) :0; //SERIOUS ASTRA_FIRST
    $total_srs_pfizer_frst_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->serious_first) :0; //SERIOUS PFIZER_FIRST
    $total_srs_sputnikv_frst_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->serious_first) :0; //SERIOUS SPUTNIKV_FIRST
    $total_srs_moderna_frst_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->serious_first) :0; //SERIOUS MODERNA_FIRST
    $total_srs_johnson_frst_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->serious_first) :0; //SERIOUS JOHNSON_FIRST

    $total_srs_svac_scnd_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->serious_second) :0; //SERIOUS  SINOVAC_SECOND
    $total_srs_astra_scnd_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->serious_second) :0; //SERIOUS ASTRA_SECOND
    $total_srs_pfizer_scnd_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->serious_second) :0; //SERIOUS PFIZER_SECOND
    $total_srs_sputnikv_scnd_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->serious_second) :0; //SERIOUS SPUTNIKV_SECOND
    $total_srs_moderna_scnd_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->serious_second) :0; //SERIOUS MODERNA_SECOND
    $total_srs_johnson_scnd_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->serious_second) :0; //SERIOUS JOHNSON_SECOND

    $total_dfrd_svac_frst_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->deferred_first) :0; //DEFERRED SINOVAC_FIRST
    $total_dfrd_astra_frst_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->deferred_first) :0; //DEFERRED ASTRA_FIRS
    $total_dfrd_pfizer_frst_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->deferred_first) :0; //DEFERRED PFIZER_FIRS
    $total_dfrd_sputnikv_frst_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->deferred_first) :0; //DEFERRED SPUTNIKV_FIRS
    $total_dfrd_moderna_frst_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->deferred_first) :0; //DEFERRED MODERNA_FIRS
    $total_dfrd_johnson_frst_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->deferred_first) :0; //DEFERRED JOHNSON_FIRS

    $total_dfrd_svac_scnd_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->deferred_second) :0; //DEFERRED  SINOVAC_SECOND
    $total_dfrd_astra_scnd_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->deferred_second) :0; //DEFERRED ASTRA_SECOND
    $total_dfrd_pfizer_scnd_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->deferred_second) :0; //DEFERRED PFIZER_SECOND
    $total_dfrd_sputnikv_scnd_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->deferred_second) :0; //DEFERRED SPUTNIKV_SECOND
    $total_dfrd_moderna_scnd_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->deferred_second) :0; //DEFERRED MODERNA_SECOND
    $total_dfrd_johnson_scnd_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->deferred_second) :0; //DEFERRED JOHNSON_SECOND

    $total_rfsd_svac_frst_grand =   $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->refused_first) :0; //REFUSED SINOVAC_FIRST
    $total_rfsd_astra_frst_grand =   $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->refused_first) :0; //REFUSED ASTRA_FIRST
    $total_rfsd_pfizer_frst_grand =   $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->refused_first) :0; //REFUSED PFIZER_FIRST
    $total_rfsd_sputnikv_frst_grand =   $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->refused_first) :0; //REFUSED SPUTNIKV_FIRST
    $total_rfsd_moderna_frst_grand =   $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->refused_first) :0; //REFUSED MODERNA_FIRST
    $total_rfsd_johnson_frst_grand =   $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->refused_first) :0; //REFUSED JOHNSON_FIRST

    $total_rfsd_svac_scnd_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->refused_second) :0;//REFUSED  SINOVAC_SECOND
    $total_rfsd_astra_scnd_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->refused_second) :0; //REFUSED ASTRA_SECOND
    $total_rfsd_pfizer_scnd_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->refused_second) :0; //REFUSED PFIZER_SECOND
    $total_rfsd_sputnikv_scnd_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->refused_second) :0; //REFUSED SPUTNIKV_SECOND
    $total_rfsd_moderna_scnd_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->refused_second) :0; //REFUSED MODERNA_SECOND
    $total_rfsd_johnson_scnd_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->refused_second) :0; //REFUSED JOHNSON_SECOND

    $total_wstge_svac_frst_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->wastage_first) :0; //WASTAGE SINOVAC_FIRST
    $total_wstge_astra_frst_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->wastage_first) :0; //WASTAGE ASTRA_FIRST
    $total_wstge_pfizer_frst_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->wastage_first) :0; //WASTAGE PFIZER_FIRST
    $total_wstge_sputnikv_frst_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->wastage_first) :0; //WASTAGE SPUTNIKV
    $total_wstge_moderna_frst_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->wastage_first) :0; //WASTAGE MODERNA
    $total_wstge_johnson_frst_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->wastage_first) :0; //WASTAGE JOHNSON

    $total_wstge_svac_scnd_grand =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("muncity_id",$muncity_id)->first()->wastage_second) :0; //WASTAGE SINOVAC_SECOND
    $total_wstge_astra_scnd_grand =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("muncity_id",$muncity_id)->first()->wastage_second) :0; //WASTAGE ASTRA_SECOND
    $total_wstge_pfizer_scnd_grand =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("muncity_id",$muncity_id)->first()->wastage_second) :0; //WASTAGE PFIZER_SECOND
    $total_wstge_sputnikv_scnd_grand =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("muncity_id",$muncity_id)->first()->wastage_second) :0; //WASTAGE SPUTNIKV_SECOND
    $total_wstge_moderna_scnd_grand =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("muncity_id",$muncity_id)->first()->wastage_second) :0; //WASTAGE MODERNA_SECOND
    $total_wstge_johnson_scnd_grand =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("muncity_id",$muncity_id)->first()->wastage_second) :0; //WASTAGE JOHNSON_SECOND

    $total_vallocated_frst_svac = $total_vallocated_svac_frst_grand + $total_vallocated_svac_scnd_grand; //TOTAL VACCINE ALLOCATED SINOVAC_FIRST
    $total_vallocated_frst_astra = $total_vallocated_astra_frst_grand + $total_vallocated_astra_scnd_grand; //TOTAL VACCINE ALLOCATED ASTRA_FIRS
    $total_vallocated_frst_pfizer = $total_vallocated_pfizer_frst_grand + $total_vallocated_pfizer_scnd_grand; //TOTAL VACCINE ALLOCATED PFIZER_FIRS
    $total_vallocated_frst_sputnikv = $total_vallocated_sputnikv_frst_grand + $total_vallocated_sputnikv_scnd_grand; //TOTAL VACCINE ALLOCATED SPUTNIKV_FIRS
    $total_vallocated_frst_moderna = $total_vallocated_moderna_frst_grand + $total_vallocated_moderna_scnd_grand; //TOTAL VACCINE ALLOCATED MODERNA_FIRS
    $total_vallocated_frst_johnson = $total_vallocated_johnson_frst_grand + $total_vallocated_johnson_scnd_grand; //TOTAL VACCINE ALLOCATED JOHNSON_FIRS
    $total_vallocated = $total_vallocated_frst_svac + $total_vallocated_frst_astra + $total_vallocated_frst_sputnikv + $total_vallocated_frst_pfizer + $total_vallocated_frst_moderna + $total_vallocated_frst_johnson;

    $total_vallocated_frst_grand = $total_vallocated_svac_frst_grand + $total_vallocated_astra_frst_grand + $total_vallocated_pfizer_frst_grand + $total_vallocated_sputnikv_frst_grand + $total_vallocated_moderna_frst_grand + $total_vallocated_johnson_frst_grand; //TOTAL VACCINE ALLOCATED FIRST
    $total_vallocated_scnd_grand = $total_vallocated_svac_scnd_grand + $total_vallocated_astra_scnd_grand + $total_vallocated_pfizer_scnd_grand + $total_vallocated_sputnikv_scnd_grand + $total_vallocated_moderna_scnd_grand + $total_vallocated_johnson_scnd_grand; //TOTAL VACCINE ALLOCATED SECOND
    $total_vallocated = $total_vallocated_frst_grand + $total_vallocated_scnd_grand;

    $total_mild_overall_frst = $total_mild_svac_frst_grand + $total_mild_astra_frst_grand + $total_mild_pfizer_frst_grand + $total_mild_sputnikv_frst_grand + $total_mild_moderna_frst_grand + $total_mild_johnson_frst_grand; // TOTAL MILD OVERALL FIRST
    $total_mild_overall_scnd = $total_mild_svac_scnd_grand + $total_mild_astra_scnd_grand + $total_mild_pfizer_scnd_grand + $total_mild_sputnikv_scnd_grand + $total_mild_moderna_scnd_grand + $total_mild_johnson_scnd_grand; // TOTAL MILD OVERALL SECOND

    $total_dfrd_overall_frst = $total_dfrd_svac_frst_grand + $total_dfrd_astra_frst_grand + $total_dfrd_pfizer_frst_grand + $total_dfrd_sputnikv_frst_grand + $total_dfrd_moderna_frst_grand + $total_dfrd_johnson_frst_grand; // TOTAL DEFERRED FIRST
    $total_dfrd_overall_scnd = $total_dfrd_svac_scnd_grand + $total_dfrd_astra_scnd_grand + $total_dfrd_pfizer_scnd_grand + $total_dfrd_sputnikv_scnd_grand + $total_dfrd_moderna_scnd_grand + $total_dfrd_johnson_scnd_grand; // TOTAL DEFERRED SECOND

    $total_rfsd_overall_frst = $total_rfsd_svac_frst_grand + $total_rfsd_astra_frst_grand + $total_rfsd_pfizer_frst_grand + $total_rfsd_sputnikv_frst_grand + $total_rfsd_moderna_frst_grand + $total_rfsd_johnson_frst_grand; // TOTAL REFUSED FIRST
    $total_rfsd_overall_scnd = $total_rfsd_svac_scnd_grand + $total_rfsd_astra_scnd_grand + $total_rfsd_pfizer_scnd_grand + $total_rfsd_sputnikv_scnd_grand + $total_rfsd_moderna_scnd_grand + $total_rfsd_johnson_scnd_grand; // TOTAL REFUSED SECOND

    $total_wstge_overall_first = $total_wstge_svac_frst_grand + $total_wstge_astra_frst_grand + $total_wstge_pfizer_frst_grand + $total_wstge_sputnikv_frst_grand + $total_wstge_moderna_frst_grand + $total_wstge_johnson_frst_grand; // TOTAL WASTAGE FIRST
    $total_wstge_overall_scnd = $total_wstge_svac_scnd_grand + $total_wstge_astra_scnd_grand + $total_wstge_pfizer_scnd_grand + $total_wstge_sputnikv_scnd_grand + $total_wstge_moderna_scnd_grand + $total_wstge_johnson_scnd_grand; // TOTAL WASTAGE SECOND

    $total_vcted_svac_frst_grand = $total_svac_a1_frst_grand + $total_svac_a2_frst_grand + $total_svac_a3_frst_grand + $total_svac_a4_frst_grand + $total_svac_a5_frst_grand +
                                   $total_svac_b1_frst_grand + $total_svac_b2_frst_grand + $total_svac_b3_frst_grand + $total_svac_b4_frst_grand; //TOTAL VACCINATED SINOVAC_FIRST
    $total_vcted_svac_scnd_grand = $total_svac_a1_scnd_grand + $total_svac_a2_scnd_grand + $total_svac_a3_scnd_grand + $total_svac_a4_scnd_grand + $total_svac_a5_scnd_grand +
                                   $total_svac_b1_scnd_grand + $total_svac_b2_scnd_grand + $total_svac_b3_scnd_grand + $total_svac_b4_scnd_grand; //TOTAL VACCINATED SINOVAC_SECOND
    $total_vcted_astra_frst_grand = $total_astra_a1_frst_grand + $total_astra_a2_frst_grand + $total_astra_a3_frst_grand + $total_astra_a4_frst_grand + $total_astra_a5_frst_grand +
                                    $total_astra_b1_frst_grand + $total_astra_b2_frst_grand + $total_astra_b3_frst_grand + $total_astra_b4_frst_grand; // TOTAL VACCINATED ASTRA_FIRST
    $total_vcted_astra_scnd_grand = $total_astra_a1_scnd_grand + $total_astra_a2_scnd_grand + $total_astra_a3_scnd_grand + $total_astra_a4_scnd_grand + $total_astra_a5_scnd_grand +
                                    $total_astra_b1_scnd_grand + $total_astra_b2_scnd_grand + $total_astra_b3_scnd_grand + $total_astra_b4_scnd_grand; //TOTAL VACCINATED ASTRA_SECOND
    $total_vcted_pfizer_frst_grand = $total_pfizer_a1_frst_grand + $total_pfizer_a2_frst_grand + $total_pfizer_a3_frst_grand + $total_pfizer_a4_frst_grand + $total_pfizer_a5_frst_grand +
                                     $total_pfizer_b1_frst_grand + $total_pfizer_b2_frst_grand + $total_pfizer_b3_frst_grand + $total_pfizer_b4_frst_grand; //TOTAL VACCINATED PFIZER_FIRST
    $total_vcted_pfizer_scnd_grand = $total_pfizer_a1_scnd_grand + $total_pfizer_a2_scnd_grand + $total_pfizer_a3_scnd_grand + $total_pfizer_a4_scnd_grand + $total_pfizer_a5_scnd_grand +
                                     $total_pfizer_b1_scnd_grand + $total_pfizer_b2_scnd_grand + $total_pfizer_b3_scnd_grand + $total_pfizer_b4_scnd_grand; //TOTAL VACCINATED PFIZER_SECOND
    $total_vcted_sputnikv_frst_grand = $total_sputnikv_a1_frst_grand + $total_sputnikv_a2_frst_grand + $total_sputnikv_a3_frst_grand + $total_sputnikv_a4_frst_grand + $total_sputnikv_a5_frst_grand +
                                       $total_sputnikv_b1_frst_grand + $total_sputnikv_b2_frst_grand + $total_sputnikv_b3_frst_grand + $total_sputnikv_b4_frst_grand; //TOTAL VACCINATED SPUTNIKV_FIRST
    $total_vcted_sputnikv_scnd_grand = $total_sputnikv_a1_scnd_grand + $total_sputnikv_a2_scnd_grand + $total_sputnikv_a3_scnd_grand + $total_sputnikv_a4_scnd_grand + $total_sputnikv_a5_scnd_grand +
                                       $total_sputnikv_b1_scnd_grand + $total_sputnikv_b2_scnd_grand + $total_sputnikv_b3_scnd_grand + $total_sputnikv_b4_scnd_grand; //TOTAL VACCINATED SPUTNIKV_SECOND
    $total_vcted_moderna_frst_grand = $total_moderna_a1_frst_grand + $total_moderna_a2_frst_grand + $total_moderna_a3_frst_grand + $total_moderna_a4_frst_grand + $total_moderna_a5_frst_grand +
                                      $total_moderna_b1_frst_grand + $total_moderna_b2_frst_grand + $total_moderna_b3_frst_grand + $total_moderna_b4_frst_grand; //TOTAL VACCINATED MODERNA_FIRST
    $total_vcted_moderna_scnd_grand = $total_moderna_a1_scnd_grand + $total_moderna_a2_scnd_grand + $total_moderna_a3_scnd_grand + $total_moderna_a4_scnd_grand + $total_moderna_a5_scnd_grand +
                                      $total_moderna_b1_scnd_grand + $total_moderna_b2_scnd_grand + $total_moderna_b3_scnd_grand + $total_moderna_b4_scnd_grand; //TOTAL VACCINATED MODERNA_SECOND
    $total_vcted_johnson_frst_grand = $total_johnson_a1_frst_grand + $total_johnson_a2_frst_grand + $total_johnson_a3_frst_grand + $total_johnson_a4_frst_grand + $total_johnson_a5_frst_grand +
                                      $total_johnson_b1_frst_grand + $total_johnson_b2_frst_grand + $total_johnson_b3_frst_grand + $total_johnson_b4_frst_grand; //TOTAL VACCINATED JOHNSON_FIRST
    $total_vcted_johnson_scnd_grand = $total_johnson_a1_scnd_grand + $total_johnson_a2_scnd_grand + $total_johnson_a3_scnd_grand + $total_johnson_a4_scnd_grand + $total_johnson_a5_scnd_grand +
                                      $total_johnson_b1_scnd_grand + $total_johnson_b2_scnd_grand + $total_johnson_b3_scnd_grand + $total_johnson_b4_scnd_grand; //TOTAL VACCINATED JOHNSON_SECOND

    $total_vcted_a1_first_grand = $total_svac_a1_frst_grand + $total_astra_a1_frst_grand + $total_pfizer_a1_frst_grand + $total_sputnikv_a1_frst_grand + $total_moderna_a1_frst_grand + $total_johnson_a1_frst_grand; //TOTAL VACCINATED (A1)
    $total_vcted_a2_first_grand = $total_svac_a2_frst_grand + $total_astra_a2_frst_grand + $total_pfizer_a2_frst_grand + $total_sputnikv_a2_frst_grand + $total_moderna_a2_frst_grand + $total_johnson_a2_frst_grand; //TOTAL VACCINATED (A2)
    $total_vcted_a3_first_grand = $total_svac_a3_frst_grand + $total_astra_a3_frst_grand + $total_pfizer_a3_frst_grand + $total_sputnikv_a3_frst_grand + $total_moderna_a3_frst_grand + $total_johnson_a3_frst_grand; //TOTAL VACCINATED (A3)
    $total_vcted_a4_first_grand = $total_svac_a4_frst_grand + $total_astra_a4_frst_grand + $total_pfizer_a4_frst_grand + $total_sputnikv_a4_frst_grand + $total_moderna_a4_frst_grand + $total_johnson_a4_frst_grand; //TOTAL VACCINATED (A4)
    $total_vcted_a5_first_grand = $total_svac_a5_frst_grand + $total_astra_a5_frst_grand + $total_pfizer_a5_frst_grand + $total_sputnikv_a5_frst_grand + $total_moderna_a5_frst_grand + $total_johnson_a5_frst_grand; //TOTAL VACCINATED (A5)
    $total_vcted_b1_first_grand = $total_svac_b1_frst_grand + $total_astra_b1_frst_grand + $total_pfizer_b1_frst_grand + $total_sputnikv_b1_frst_grand + $total_moderna_b1_frst_grand + $total_johnson_b1_frst_grand; //TOTAL VACCINATED (B1)
    $total_vcted_b2_first_grand = $total_svac_b2_frst_grand + $total_astra_b2_frst_grand + $total_pfizer_b2_frst_grand + $total_sputnikv_b2_frst_grand + $total_moderna_b2_frst_grand + $total_johnson_b2_frst_grand; //TOTAL VACCINATED (B2)
    $total_vcted_b3_first_grand = $total_svac_b3_frst_grand + $total_astra_b3_frst_grand + $total_pfizer_b3_frst_grand + $total_sputnikv_b3_frst_grand + $total_moderna_b3_frst_grand + $total_johnson_b3_frst_grand; //TOTAL VACCINATED (B3)
    $total_vcted_b4_first_grand = $total_svac_b4_frst_grand + $total_astra_b4_frst_grand + $total_pfizer_b4_frst_grand + $total_sputnikv_b4_frst_grand + $total_moderna_b4_frst_grand + $total_johnson_b4_frst_grand; //TOTAL VACCINATED (B4)

    $total_vcted_first_overall =  $total_vcted_a1_first_grand + $total_vcted_a2_first_grand + $total_vcted_a3_first_grand + $total_vcted_a4_first_grand + $total_vcted_a5_first_grand +
        $total_vcted_b1_first_grand + $total_vcted_b2_first_grand + $total_vcted_b3_first_grand + $total_vcted_b4_first_grand; //TOTAL VACCINATED FIRST DOSE OVERALL

    $total_vcted_scnd_a1_grand = $total_svac_a1_scnd_grand + $total_astra_a1_scnd_grand + $total_pfizer_a1_scnd_grand + $total_sputnikv_a1_scnd_grand + $total_moderna_a1_scnd_grand + $total_johnson_a1_scnd_grand; //TOTAL VACCINATED SECOND DOSE A1
    $total_vcted_scnd_a2_grand = $total_svac_a2_scnd_grand + $total_astra_a2_scnd_grand + $total_pfizer_a2_scnd_grand + $total_sputnikv_a2_scnd_grand + $total_moderna_a2_scnd_grand + $total_johnson_a2_scnd_grand; //TOTAL VACCINATED SECOND DOSE A2
    $total_vcted_scnd_a3_grand = $total_svac_a3_scnd_grand + $total_astra_a3_scnd_grand + $total_pfizer_a3_scnd_grand + $total_sputnikv_a3_scnd_grand + $total_moderna_a3_scnd_grand + $total_johnson_a3_scnd_grand; //TOTAL VACCINATED SECOND DOSE A3
    $total_vcted_scnd_a4_grand = $total_svac_a4_scnd_grand + $total_astra_a4_scnd_grand + $total_pfizer_a4_scnd_grand + $total_sputnikv_a4_scnd_grand + $total_moderna_a4_scnd_grand + $total_johnson_a4_scnd_grand; //TOTAL VACCINATED SECOND DOSE A4
    $total_vcted_scnd_a5_grand = $total_svac_a5_scnd_grand + $total_astra_a5_scnd_grand + $total_pfizer_a5_scnd_grand + $total_sputnikv_a5_scnd_grand + $total_moderna_a5_scnd_grand + $total_johnson_a5_scnd_grand; //TOTAL VACCINATED SECOND DOSE A5
    $total_vcted_scnd_b1_grand = $total_svac_b1_scnd_grand + $total_astra_b1_scnd_grand + $total_pfizer_b1_scnd_grand + $total_sputnikv_b1_scnd_grand + $total_moderna_b1_scnd_grand + $total_johnson_b1_scnd_grand ; //TOTAL VACCINATED SECOND DOSE B1
    $total_vcted_scnd_b2_grand = $total_svac_b2_scnd_grand + $total_astra_b2_scnd_grand + $total_pfizer_b2_scnd_grand + $total_sputnikv_b2_scnd_grand + $total_moderna_b2_scnd_grand + $total_johnson_b2_scnd_grand; //TOTAL VACCINATED SECOND DOSE B2
    $total_vcted_scnd_b3_grand = $total_svac_b3_scnd_grand + $total_astra_b3_scnd_grand + $total_pfizer_b3_scnd_grand + $total_sputnikv_b3_scnd_grand + $total_moderna_b3_scnd_grand + $total_johnson_b3_scnd_grand; //TOTAL VACCINATED SECOND DOSE B3
    $total_vcted_scnd_b4_grand = $total_svac_b4_scnd_grand + $total_astra_b4_scnd_grand + $total_pfizer_b4_scnd_grand + $total_sputnikv_b4_scnd_grand + $total_moderna_b4_scnd_grand + $total_johnson_b4_scnd_grand; //TOTAL VACCINATED SECOND DOSE B4

    $total_vcted_scnd_overall = $total_vcted_scnd_a1_grand + $total_vcted_scnd_a2_grand + $total_vcted_scnd_a3_grand + $total_vcted_scnd_a4_grand + $total_vcted_scnd_a5_grand +
                                $total_vcted_scnd_b1_grand + $total_vcted_scnd_b2_grand + $total_vcted_scnd_b3_grand + $total_vcted_scnd_b4_grand; //TOTAL VACCINATED SECOND DOSE OVERALL

    $total_rfsd_frst_grand = $total_rfsd_svac_frst_grand + $total_rfsd_astra_frst_grand + $total_rfsd_pfizer_frst_grand + $total_rfsd_sputnikv_frst_grand + $total_rfsd_moderna_frst_grand + $total_rfsd_johnson_frst_grand; //TOTAL REFUSED
    $total_rfsd_scnd_grand = $total_rfsd_svac_scnd_grand + $total_rfsd_astra_scnd_grand + $total_rfsd_pfizer_scnd_grand + $total_rfsd_sputnikv_scnd_grand + $total_rfsd_moderna_scnd_grand + $total_rfsd_johnson_scnd_grand; //TOTAL REFUSED  2

    //PERCENT COVERAGE
    $total_p_cvrge_svac_frst_grand = $total_vcted_svac_frst_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE SINOVAC_FIRST //DARA
    $total_p_cvrge_svac_scnd_grand = $total_vcted_svac_scnd_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE SINOVAC_SECOND
    $total_p_cvrge_astra_frst_grand = $total_vcted_astra_frst_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE ASTRA_FIRST
    $total_p_cvrge_astra_scnd_grand = $total_vcted_astra_scnd_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE ASTRA_SECOND
    $total_p_cvrge_pfizer_frst_grand = $total_vcted_pfizer_frst_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE PFIZER_FIRST
    $total_p_cvrge_pfizer_scnd_grand = $total_vcted_pfizer_scnd_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE PFIZER_SECOND
    $total_p_cvrge_sputnikv_frst_grand = $total_vcted_sputnikv_frst_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE SPUTNIKV_FIRST
    $total_p_cvrge_sputnikv_scnd_grand = $total_vcted_sputnikv_scnd_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE SPUTNIKV_SECOND
    $total_p_cvrge_moderna_frst_grand = $total_vcted_moderna_frst_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE MODERNA_FIRST
    $total_p_cvrge_moderna_scnd_grand = $total_vcted_moderna_scnd_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE MODERNA_SECOND
    $total_p_cvrge_johnson_frst_grand = $total_vcted_johnson_frst_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE JOHNSON_FIRST
    $total_p_cvrge_johnson_scnd_grand = $total_vcted_johnson_scnd_grand / $total_e_pop_grand * 100; //PERCENT COVERAGE JOHNSON_SECOND
    $total_p_cvrge_overall_frst = $total_vcted_first_overall / $total_e_pop_grand * 100; //PERCENT_COVERAGE_OVERALL_FIRST
    $total_p_cvrge_overall_scnd = $total_vcted_scnd_overall / $total_e_pop_grand * 100; //PERCENT_COVERAGE_OVERALL_FIRST

    //CONSUMPTTION RATE
    $total_c_rate_svac_frst_grand = $total_vcted_svac_frst_grand / $total_vallocated_svac_frst_grand * 100; //CONSUMPTION RATE SINOVAC_FIRST goods
    $total_c_rate_astra_frst_grand = $total_vcted_astra_frst_grand / $total_vallocated_astra_frst_grand * 100; //CONSUMPTION RATE ASTRA_FIRST goods
    $total_c_rate_pfizer_frst_grand = $total_vcted_pfizer_frst_grand / $total_vallocated_pfizer_frst_grand * 100; //CONSUMPTION RATE PFIZER_FIRST goods
    $total_c_rate_sputnikv_frst_grand = $total_vcted_sputnikv_frst_grand / $total_vallocated_sputnikv_frst_grand * 100; //CONSUMPTION RATE SPUTNIKV_FIRST goods
    $total_c_rate_moderna_frst_grand = $total_vcted_moderna_frst_grand / $total_vallocated_moderna_frst_grand * 100; //CONSUMPTION RATE SPUTNIKV_FIRST goods
    $total_c_rate_johnson_frst_grand = $total_vcted_johnson_frst_grand / $total_vallocated_johnson_frst_grand * 100; //CONSUMPTION RATE SPUTNIKV_FIRST goods
    $total_c_rate_svac_scnd_grand = $total_vcted_svac_scnd_grand / $total_vallocated_svac_scnd_grand * 100; //CONSUMPTION RATE SINOVAC_SECOND goods
    $total_c_rate_astra_scnd_grand = $total_vcted_astra_scnd_grand / $total_vallocated_astra_scnd_grand * 100; //CONSUMPTION RATE ASTRA_SECOND goods
    $total_c_rate_pfizer_scnd_grand = $total_vcted_pfizer_scnd_grand / $total_vallocated_pfizer_scnd_grand * 100; //CONSUMPTION RATE PFIZER SECOND goods
    $total_c_rate_sputnikv_scnd_grand = $total_vcted_sputnikv_scnd_grand / $total_vallocated_sputnikv_scnd_grand * 100; //CONSUMPTION RATE SPUTNIKV_SECOND goods
    $total_c_rate_moderna_scnd_grand = $total_vcted_moderna_scnd_grand / $total_vallocated_moderna_scnd_grand * 100; //CONSUMPTION RATE SPUTNIKV_SECOND goods
    $total_c_rate_johnson_scnd_grand = $total_vcted_johnson_scnd_grand / $total_vallocated_johnson_scnd_grand * 100; //CONSUMPTION RATE SPUTNIKV_SECOND goods

    //REMAINING UNVACCINATED
    $total_r_unvcted_frst_svac_grand = $total_e_pop_grand - $total_vcted_svac_frst_grand - $total_rfsd_svac_frst_grand; //REMAINING UNVACCINATED SINOVAC_FIRST goods
    $total_r_unvcted_frst_astra_grand = $total_e_pop_grand - $total_vcted_astra_frst_grand - $total_rfsd_astra_frst_grand; //REMAINUNG UNVACCINATED ASTRA_FIRST goods
    $total_r_unvcted_frst_pfizer_grand = $total_e_pop_grand - $total_vcted_pfizer_frst_grand - $total_rfsd_pfizer_frst_grand; //REMAINUNG UNVACCINATED PFIZER_FIRST goods
    $total_r_unvcted_frst_sputnikv_grand = $total_e_pop_grand - $total_vcted_sputnikv_frst_grand - $total_rfsd_sputnikv_frst_grand; //REMAINUNG UNVACCINATED SPUTNIKV_FIRST goods
    $total_r_unvcted_frst_moderna_grand = $total_e_pop_grand - $total_vcted_moderna_frst_grand - $total_rfsd_moderna_frst_grand; //REMAINUNG UNVACCINATED SPUTNIKV_FIRST goods
    $total_r_unvcted_frst_johnson_grand = $total_e_pop_grand - $total_vcted_johnson_frst_grand - $total_rfsd_johnson_frst_grand; //REMAINUNG UNVACCINATED SPUTNIKV_FIRST goods

    $total_r_unvcted_scnd_svac_grand = $total_e_pop_grand - $total_vcted_svac_scnd_grand - $total_rfsd_svac_scnd_grand; //REMAINING UNVACCINATED  SINOVAC_SECOND goods
    $total_r_unvcted_scnd_astra_grand = $total_e_pop_grand - $total_vcted_astra_scnd_grand - $total_rfsd_astra_scnd_grand;  //REMAINING UNVACCINATED ASTRA_SECOND goods
    $total_r_unvcted_scnd_pfizer_grand = $total_e_pop_grand - $total_vcted_pfizer_scnd_grand - $total_rfsd_pfizer_scnd_grand;  //REMAINING UNVACCINATED PFIZER_SECOND goods
    $total_r_unvcted_scnd_sputnikv_grand = $total_e_pop_grand - $total_vcted_sputnikv_scnd_grand - $total_rfsd_sputnikv_scnd_grand;  //REMAINING UNVACCINATED SPUTNIKV_SECOND goods
    $total_r_unvcted_scnd_moderna_grand = $total_e_pop_grand - $total_vcted_moderna_scnd_grand - $total_rfsd_moderna_scnd_grand;  //REMAINING UNVACCINATED SPUTNIKV_SECOND goods
    $total_r_unvcted_scnd_johnson_grand = $total_e_pop_grand - $total_vcted_johnson_scnd_grand - $total_rfsd_johnson_scnd_grand;  //REMAINING UNVACCINATED SPUTNIKV_SECOND goods
    $total_r_unvcted_all_frst_grand = $total_e_pop_grand - $total_vcted_first_overall - $total_rfsd_frst_grand; //TOTAL REMAINUNG UNVACCINATED goods //
    $total_r_unvcted_all_scnd_grand = $total_e_pop_grand - $total_vcted_scnd_overall - $total_rfsd_scnd_grand; //TOTAL REMAINING UNVACCIANTED  2 goods

    $sinovac_dashboard = $total_vcted_svac_frst_grand + $total_vcted_svac_scnd_grand;
    $astra_dashboard = $total_vcted_astra_frst_grand + $total_vcted_astra_scnd_grand;
    $pfizer_dashboard = $total_vcted_pfizer_frst_grand + $total_vcted_pfizer_scnd_grand;
    $sputnikv_dashboard = $total_vcted_sputnikv_frst_grand + $total_vcted_sputnikv_scnd_grand;
    $moderna_dashboard = $total_vcted_moderna_frst_grand + $total_vcted_moderna_scnd_grand;
    $johnson_dashboard = $total_vcted_johnson_frst_grand + $total_vcted_johnson_scnd_grand;

    $a1_dashboard = $total_vcted_a1_first_grand + $total_vcted_scnd_a1_grand;
    $a2_dashboard = $total_vcted_a2_first_grand + $total_vcted_scnd_a2_grand;
    $a3_dashboard = $total_vcted_a3_first_grand + $total_vcted_scnd_a3_grand;
    $a4_dashboard = $total_vcted_a4_first_grand + $total_vcted_scnd_a4_grand;
    $a5_dashboard = $total_vcted_a5_first_grand + $total_vcted_scnd_a5_grand;
    $b1_dashboard = $total_vcted_b1_first_grand + $total_vcted_scnd_b1_grand;
    $b2_dashboard = $total_vcted_b2_first_grand + $total_vcted_scnd_b2_grand;
    $b3_dashboard = $total_vcted_b3_first_grand + $total_vcted_scnd_b3_grand;
    $b4_dashboard = $total_vcted_b4_first_grand + $total_vcted_scnd_b4_grand;

    $percent_coverage_dashboard_first =  $total_p_cvrge_overall_frst;
    $percent_coverage_dashboard_second = $total_p_cvrge_overall_scnd;

    $total_c_rate_frst_grand = $total_vcted_first_overall / $total_vallocated_frst_grand * 100; //TOTAL CONSUMPTION RATE goods
    $total_c_rate_scnd_grand = $total_vcted_scnd_overall / $total_vallocated_scnd_grand * 100; //TOTAL CONSUMPTION RATE  2 goods

    $consumption_rate_dashboard_first = $total_c_rate_frst_grand;
    $consumption_rate_dashboard_second = $total_c_rate_scnd_grand;

    $total_srs_overall_frst = $total_srs_svac_frst_grand + $total_srs_astra_frst_grand + $total_srs_pfizer_frst_grand + $total_srs_sputnikv_frst_grand + $total_srs_moderna_frst_grand + $total_srs_johnson_frst_grand; // TOTAL SERIOUS FIRST
    $total_srs_overall_scnd = $total_srs_svac_scnd_grand + $total_srs_astra_scnd_grand + $total_srs_pfizer_scnd_grand + $total_srs_sputnikv_scnd_grand + $total_srs_moderna_scnd_grand + $total_srs_johnson_scnd_grand; // TOTAL SERIOUS SECOND

    Session::put("sinovac_dashboard",$sinovac_dashboard);
    Session::put("astra_dashboard",$astra_dashboard);
    Session::put("pfizer_dashboard",$pfizer_dashboard);
    Session::put("sputnikv_dashboard",$sputnikv_dashboard);
    Session::put("moderna_dashboard",$moderna_dashboard);
    Session::put("johnson_dashboard",$johnson_dashboard);
    Session::put("a1_dashboard",$a1_dashboard);
    Session::put("a2_dashboard",$a2_dashboard);
    Session::put("a3_dashboard",$a3_dashboard);
    Session::put("a4_dashboard",$a4_dashboard);
    Session::put("a5_dashboard",$a5_dashboard);
    Session::put("b1_dashboard",$b1_dashboard);
    Session::put("b2_dashboard",$b2_dashboard);
    Session::put("b3_dashboard",$b3_dashboard);
    Session::put("b4_dashboard",$b4_dashboard);
    Session::put("percent_coverage_dashboard_first",$percent_coverage_dashboard_first);
    Session::put("percent_coverage_dashboard_second",$percent_coverage_dashboard_second);
    Session::put("consumption_rate_dashboard_first",$consumption_rate_dashboard_first);
    Session::put("consumption_rate_dashboard_second",$consumption_rate_dashboard_second);
    ?>

<b>Grand Total</b>
    <button class="btn btn-sm btn-link collapsed" style="color: red;" type="button" data-toggle="collapse" data-target="#collapse_sinovac_grand" aria-expanded="false" aria-controls="collapse_sinovac_grandtotal">
        <b>Sinovac</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color: darkgoldenrod;" type="button" data-toggle="collapse" data-target="#collapse_astra_grand" aria-expanded="false" aria-controls="collapse_astra_grandtotal">
        <b>Astrazeneca</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color:#00c0ef;" type="button" data-toggle="collapse" data-target="#collapse_pfizer_grand" aria-expanded="false" aria-controls="collapse_pfizer_grandtotal">
        <b>Pfizer</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color:#00a65a;" type="button" data-toggle="collapse" data-target="#collapse_sputnikv_grand" aria-expanded="false" aria-controls="collapse_sputnikv_grandtotal">
         <b>SputnikV</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color:#605ca8;" type="button" data-toggle="collapse" data-target="#collapse_moderna_grand" aria-expanded="false" aria-controls="collapse_moderna_grandtotal">
         <b>Moderna</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color:#1d94ff;" type="button" data-toggle="collapse" data-target="#collapse_johnson_grand" aria-expanded="false" aria-controls="collapse_johnson_grandtotal">
         <b>Janssen</b>
    </button>
<table style="font-size: 8pt;" class="table" border="2">
    <tbody>
    <tr>
        <th>Type of Vaccine</th> <!-- Type of Vaccine 1-1 -->
        <th colspan="10">
            <center>
                <a style="color:black"> Eligible Population</a>
            </center>
        </th>
        <th colspan="3">
            <center>
                <a style="color:black"> Vaccine Allocated</a>
            </center>
        </th>
        <th colspan="10"><center>Total Vaccinated </center></th>
        <th>Mild</th>
        <th>Serious</th>
        <th>Deferred</th>
        <th>Refused</th>
        <th>Wastage</th>
        <th>Percent Coverage</th>
        <th>Consumption Rate</th>
        <th>Remaining Unvaccinated</th>
    </tr>
    <tr>
        <td></td> <!-- 1-2 -->
        <th>A1</th>
        <th>A2</th>
        <th>A3</th>
        <th>A4</th>
        <th>A5</th>
        <th>B1</th>
        <th>B2</th>
        <th>B3</th>
        <th>B4</th>
        <th>Total</th>
        <th>1st</th>
        <th>2nd</th>
        <th>Total</th>
        <th>A1</th>
        <th>A2</th>
        <th>A3</th>
        <th>A4</th>
        <th>A5</th>
        <th>B1</th>
        <th>B2</th>
        <th>B3</th>
        <th>B4</th>
        <th>Total</th>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
    </tr>
    </tbody>
    <!-- SINOVAC -->
    <tbody id="collapse_sinovac_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr style="background-color: #ffd8d6">
        <td rowspan="2">Sinovac</td> <!-- 1-3 -->
        <td rowspan="2">
            {{ $total_e_pop_a1_grand }}
            <?php Session::put('total_e_pop_svac_a1_excel',$total_e_pop_a1_grand);?>
        </td> <!--TOTAL ELIPOP A1-->
        <td rowspan="2">
            {{ $total_e_pop_a2_grand }}
            <?php  Session::put('total_e_pop_svac_a2_excel',$total_e_pop_a2_grand);?>
        </td> <!--TOTAL ELIPOP A2-->
        <td rowspan="2">
            {{ $total_e_pop_a3_grand }}
            <?php  Session::put('total_e_pop_svac_a3_excel',$total_e_pop_a3_grand);?>
        </td> <!--TOTAL ELIPOP A3-->
        <td rowspan="2">
            {{ $total_e_pop_a4_grand }}
            <?php  Session::put('total_e_pop_svac_a4_excel',$total_e_pop_a4_grand);?>
        </td> <!--TOTAL ELIPOP A4-->
        <td rowspan="2">
            {{ $total_e_pop_a5_grand }}
            <?php  Session::put('total_e_pop_svac_a5_excel',$total_e_pop_a5_grand);?>
        </td>  <!--TOTAL ELIPOP A5-->
        <td rowspan="2">
            {{ $total_e_pop_b1_grand }}
            <?php  Session::put('total_e_pop_svac_b1_excel',$total_e_pop_b1_grand);?>
        </td>  <!--TOTAL ELIPOP B1-->
        <td rowspan="2">
            {{ $total_e_pop_b2_grand }}
            <?php  Session::put('total_e_pop_svac_b2_excel',$total_e_pop_b2_grand);?>
        </td>
        <td rowspan="2">
            {{ $total_e_pop_b3_grand }}
            <?php  Session::put('total_e_pop_svac_b3_excel',$total_e_pop_b3_grand);?>
        </td>
        <td rowspan="2">
            {{ $total_e_pop_b4_grand }}
            <?php  Session::put('total_e_pop_svac_b4_excel',$total_e_pop_b4_grand);?>
        </td>
        <td rowspan="2">
            {{ $total_e_pop_grand}}
            <?php  Session::put('total_e_pop_svac_excel',$total_e_pop_grand);?>
        </td> <!--TOTAL ELI POP-->
        <td rowspan="2">
            {{ $total_vallocated_svac_frst_grand }}
            <?php  Session::put('total_vallocated_svac_frst_excel',$total_vallocated_svac_frst_grand);?>
        </td> <!-- VACCINE ALLOCATED (FD) SINOVAC_FIRST -->
        <td rowspan="2">
            {{ $total_vallocated_svac_scnd_grand }}
            <?php  Session::put('total_vallocated_svac_scnd_excel',$total_vallocated_svac_scnd_grand);?>
        </td>  <!-- VACCINE ALLOCATED (SD) SINOVAC_FIRST -->
        <td rowspan="2">
            {{ $total_vallocated_frst_svac }}
            <?php  Session::put('total_vallocated_frst_svac_excel',$total_vallocated_frst_svac);?>
        </td> <!-- TOTAL VACCINE ALLOCATED SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_svac_a1_frst_grand }}
                <?php Session::put('total_svac_a1_frst_excel',$total_svac_a1_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A1) SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                 {{ $total_svac_a2_frst_grand }}
                <?php Session::put('total_svac_a2_frst_excel',$total_svac_a2_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A2) SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_svac_a3_frst_grand }}
                <?php Session::put('total_svac_a3_frst_excel',$total_svac_a3_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_svac_a4_frst_grand }}
                <?php Session::put('total_svac_a4_frst_excel',$total_svac_a4_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A4) SINOVAC_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_svac_a5_frst_grand }}
                 <?php Session::put('total_svac_a5_frst_excel',$total_svac_a5_frst_grand);?>
            </span>
        </td>   <!-- VACCINATED (A5) SINOVAC_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_svac_b1_frst_grand }}
                 <?php Session::put('total_svac_b1_frst_excel',$total_svac_b1_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (B1) SINOVAC_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_svac_b2_frst_grand }}
                 <?php Session::put('total_svac_b2_frst_excel',$total_svac_b2_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) SINOVAC_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_svac_b3_frst_grand }}
                 <?php Session::put('total_svac_b2_frst_excel',$total_svac_b3_frst_grand);?>
            </span> <!-- VACCINATED (B3) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_svac_b4_frst_grand }}
                <?php Session::put('total_svac_b4_frst_excel',$total_svac_b4_frst_grand);?>
            </span> <!-- VACCINATED (B4) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_vcted_svac_frst_grand }}
                <?php Session::put('total_vcted_svac_frst_excel',$total_vcted_svac_frst_grand);?>
            </span>
        </td> <!-- TOTAL VACCINATED SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_mild_svac_frst_grand }}
                <?php Session::put('total_mild_svac_frst_excel',$total_mild_svac_frst_grand);?>
            </span>
        </td> <!-- MILD SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_srs_svac_frst_grand }}
                <?php Session::put('total_srs_svac_frst_excel',$total_srs_svac_frst_grand);?>
            </span>
        </td> <!-- SERIOUS SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_dfrd_svac_frst_grand }}
                <?php Session::put('total_dfrd_svac_frst_excel',$total_dfrd_svac_frst_grand);?>
            </span>
        </td> <!-- DEFERRED SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_rfsd_svac_frst_grand }}
                <?php Session::put('total_rfsd_svac_frst_excel',$total_rfsd_svac_frst_grand);?>
            </span>
        </td>  <!-- REFUSED SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_wstge_svac_frst_grand }}
                <?php Session::put('total_wstge_svac_frst_excel',$total_wstge_svac_frst_grand);?>
            </span>
        </td>  <!-- WASTAGE SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_p_cvrge_svac_frst_grand,2) }}%
                <?php Session::put('total_p_cvrge_svac_frst_excel',$total_p_cvrge_svac_frst_grand);?>
            </span>
        </td>  <!-- PERCENT COVERAGE SINOVAC_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_c_rate_svac_frst_grand,2) }}%
                <?php Session::put('total_c_rate_svac_frst_excel',$total_c_rate_svac_frst_grand);?>
            </span> <!-- CONSUMPTION RATE SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_r_unvcted_frst_svac_grand }}
                <?php Session::put('total_r_unvcted_frst_svac_excel',$total_r_unvcted_frst_svac_grand);?>
            </span>
        </td>  <!-- REMAINING UNVACCINATED SINOVAC_FIRST -->
    </tr>

    <tr style="background-color: #ffd8d6">
        <td>
            <span class="label label-warning">
                {{ $total_svac_a1_scnd_grand }}
                <?php Session::put('total_svac_a1_scnd_excel',$total_svac_a1_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_svac_a2_scnd_grand }}
                <?php Session::put('total_svac_a2_scnd_excel',$total_svac_a2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A2) SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_svac_a3_scnd_grand }}
                <?php Session::put('total_svac_a3_scnd_excel',$total_svac_a3_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A3) SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_svac_a4_scnd_grand }}
                <?php Session::put('total_svac_a4_scnd_excel',$total_svac_a4_scnd_grand);?>
            </span>
        </td>   <!-- VACCINATED (A4) SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_svac_a5_scnd_grand }}
                <?php Session::put('total_svac_a5_scnd_excel',$total_svac_a5_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_svac_b1_scnd_grand }}
                <?php Session::put('total_svac_b1_scnd_excel',$total_svac_b1_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) SINOVAC_SECOND -->
        <td>
             <span class="label label-warning">
                {{ $total_svac_b2_scnd_grand }}
                 <?php Session::put('total_svac_b2_scnd_excel',$total_svac_b2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) SINOVAC_SECOND -->
        <td>
             <span class="label label-warning">
                {{ $total_svac_b3_scnd_grand }}
                 <?php Session::put('total_svac_b3_scnd_excel',$total_svac_b3_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (B3) SINOVAC_SECOND -->
        <td>
             <span class="label label-warning">
                {{ $total_svac_b3_scnd_grand }}
                 <?php Session::put('total_svac_b3_scnd_excel',$total_svac_b3_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_vcted_svac_scnd_grand }}
                <?php Session::put('total_vcted_svac_second_excel',$total_vcted_svac_scnd_grand);?>
            </span>
        </td> <!-- TOTAL VACCINATED SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_mild_svac_scnd_grand }}
                <?php Session::put('total_mild_svac_scnd_excel',$total_mild_svac_scnd_grand);?>
            </span>
        </td>  <!-- MILD SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_srs_svac_scnd_grand }}
                <?php Session::put('total_srs_svac_scnd_excel',$total_srs_svac_scnd_grand);?>
            </span>
        </td> <!-- SERIOUS  SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_dfrd_svac_scnd_grand }}
                <?php Session::put('total_dfrd_svac_scnd_excel',$total_dfrd_svac_scnd_grand);?>
            </span>
        </td>  <!-- DEFERRED  SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_rfsd_svac_scnd_grand }}
                <?php Session::put('total_rfsd_svac_scnd_excel',$total_rfsd_svac_scnd_grand);?>
            </span>
        </td> <!-- REFUSED  SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_wstge_svac_scnd_grand }}
                <?php Session::put('total_wstge_svac_scnd_excel',$total_wstge_svac_scnd_grand);?>
            </span> <!-- WASTAGE SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">
                {{ number_format($total_p_cvrge_svac_scnd_grand,2) }}%
                <?php Session::put('total_p_cvrge_svac_scnd_excel',$total_p_cvrge_svac_scnd_grand);?>
            </span>
        </td>  <!-- PERCENT COVERAGE  SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_c_rate_svac_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_svac_scnd_excel',$total_c_rate_svac_scnd_grand);?>
            </span>
        </td> <!-- CONSUMPTION RATE SINOVAC_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_r_unvcted_scnd_svac_grand }}
                <?php Session::put('total_r_unvcted_scnd_svac_excel',$total_r_unvcted_scnd_svac_grand);?>
            </span>
        </td> <!-- REMAINING UNVACCINATED  SINOVAC_SECOND -->
    </tr>
    </tbody>
    <!-- ASTRAZENECA -->
    <tbody id="collapse_astra_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr style="background-color: #f2fcac">
        <td rowspan="2">Astrazeneca</td> <!-- 1-5 -->
        <td rowspan="2">
            {{ $total_e_pop_a1_grand }}
            <?php Session::put('total_e_pop_astra_a1_excel',$total_e_pop_a1_grand);?>
        </td>  <!--TOTAL ELIPOP ASTRA A1-->
        <td rowspan="2">
            {{ $total_e_pop_a2_grand }}
            <?php Session::put('total_e_pop_astra_a2_excel',$total_e_pop_a2_grand);?>
        </td>   <!--TOTAL ELIPOP ASTRA A2-->
        <td rowspan="2">
            {{ $total_e_pop_a3_grand }}
            <?php Session::put('total_e_pop_astra_a3_excel',$total_e_pop_a3_grand);?>
        </td>  <!--TOTAL ELIPOP ASTRA A3-->
        <td rowspan="2">
            {{ $total_e_pop_a4_grand }}
            <?php Session::put('total_e_pop_astra_a4_excel',$total_e_pop_a4_grand);?>
        </td>  <!--TOTAL ELIPOP ASTRA A4-->
        <td rowspan="2">
            {{ $total_e_pop_a5_grand }}
            <?php Session::put('total_e_pop_astra_a5_excel',$total_e_pop_a5_grand);?>
        </td> <!--TOTAL ELIPOP ASTRA A5-->
        <td rowspan="2">
            {{ $total_e_pop_b1_grand }}
            <?php Session::put('total_e_pop_astra_b1_excel',$total_e_pop_b1_grand);?>
        </td> <!--TOTAL ELIPOP ASTRA B1-->
        <td rowspan="2">
            {{ $total_e_pop_b2_grand }}
            <?php Session::put('total_e_pop_astra_b2_excel',$total_e_pop_b2_grand);?>
        </td> <!--TOTAL ELIPOP ASTRA B2-->
        <td rowspan="2">
            {{ $total_e_pop_b3_grand }}
            <?php Session::put('total_e_pop_astra_b3_excel',$total_e_pop_b3_grand);?>
        </td> <!--TOTAL ELIPOP ASTRA B3-->
        <td rowspan="2">
            {{ $total_e_pop_b4_grand }}
            <?php Session::put('total_e_pop_astra_b4_excel',$total_e_pop_b4_grand);?>
        </td>  <!--TOTAL ELIPOP ASTRA B4-->
        <td rowspan="2">
            {{ $total_e_pop_grand }}
            <?php Session::put('total_e_pop_astra_excel',$total_e_pop_grand);?>
        </td> <!--TOTAL ELI POP ASTRA-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_astra_frst_grand }}
            <?php Session::put('total_vallocated_astra_frst_excel',$total_vallocated_astra_frst_grand);?>
        </td> <!-- VACCINE_ALLOCATED (FD) ASTRA_FIRST-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_astra_scnd_grand }}
            <?php Session::put('total_vallocated_astra_scnd_excel',$total_vallocated_astra_scnd_grand);?>
        </td>  <!-- VACCINE ALLOCATED (SD) ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">
            {{ $total_vallocated_frst_astra }}
            <?php Session::put('total_vallocated_frst_astra_excel',$total_vallocated_frst_astra);?>
        </td>  <!-- TOTAL VACCINE ALLOCATED ASTRA_FIRST -->
        <td style="color:black;">
            <span class="label label-success">
                {{ $total_astra_a1_frst_grand }}
                <?php Session::put('total_astra_a1_frst_excel',$total_astra_a1_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) ASTRA_FIRST -->
        <td style="color:black">
            <span class="label label-success">
                {{ $total_astra_a2_frst_grand }}
                <?php Session::put('total_astra_a2_frst_excel',$total_astra_a2_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A2) ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_astra_a3_frst_grand }}
                <?php Session::put('total_astra_a3_frst_excel',$total_astra_a3_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A3) ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_astra_a4_frst_grand }}
                <?php Session::put('total_astra_a4_frst_excel',$total_astra_a4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A4) ASTRA_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_astra_a5_frst_grand }}
                 <?php Session::put('total_astra_a5_frst_excel',$total_astra_a5_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A5) ASTRA_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_astra_b1_frst_grand }}
                 <?php Session::put('total_astra_b1_frst_excel',$total_astra_b1_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) ASTRA_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_astra_b2_frst_grand }}
                 <?php Session::put('total_astra_b2_frst_excel',$total_astra_b2_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) ASTRA_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_astra_b3_frst_grand }}
                 <?php Session::put('total_astra_b3_frst_excel',$total_astra_b3_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) ASTRA_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_astra_b4_frst_grand }}
                 <?php Session::put('total_astra_b4_frst_excel',$total_astra_b4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_vcted_astra_frst_grand }}
                <?php Session::put('total_vcted_astra_frst_excel',$total_vcted_astra_frst_grand);?>
            </span>
        </td> <!-- TOTAL VACCINATED ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_mild_astra_frst_grand }}
                <?php Session::put('total_mild_astra_frst_excel',$total_mild_astra_frst_grand);?>
            </span> <!-- MILD ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_srs_astra_frst_grand }}
                <?php Session::put('total_srs_astra_frst_excel',$total_srs_astra_frst_grand);?>
            </span>
        </td> <!-- SERIOUS ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_dfrd_astra_frst_grand }}
                <?php Session::put('total_dfrd_astra_frst_excel',$total_dfrd_astra_frst_grand);?>
            </span>
        </td>  <!-- DEFERRED ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_rfsd_astra_frst_grand }}
                <?php Session::put('total_rfsd_astra_frst_excel',$total_rfsd_astra_frst_grand);?>
            </span>
        </td>  <!-- REFUSED ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_wstge_astra_frst_grand }}
                <?php Session::put('total_wstge_astra_frst_excel',$total_wstge_astra_frst_grand);?>
            </span> <!-- WASTAGE ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ number_format($total_p_cvrge_astra_frst_grand,2) }}%
                <?php Session::put('total_p_cvrge_astra_frst_excel',$total_p_cvrge_astra_frst_grand);?>
            </span>
        </td> <!-- PERCENT_COVERAGE ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_c_rate_astra_frst_grand,2) }}%
                <?php Session::put('total_c_rate_astra_frst_excel',$total_c_rate_astra_frst_grand);?>
            </span>
        </td>  <!-- CONSUMPTION RATE ASTRA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_r_unvcted_frst_astra_grand }}
                <?php Session::put('total_r_unvcted_frst_astra_excel',$total_r_unvcted_frst_astra_grand);?>
            </span>
        </td> <!-- REMAINUNG UNVACCINATED ASTRA_FIRST -->
    </tr>
    <tr style="background-color: #f2fcac">
        <td style="color: black;">
            <span class="label label-warning">
                {{ $total_astra_a1_scnd_grand }}
                <?php Session::put('total_astra_a1_scnd_excel',$total_astra_a1_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) ASTRA_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_astra_a2_scnd_grand }}
                <?php Session::put('total_astra_a2_scnd_excel',$total_astra_a2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A2) ASTRA_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_astra_a3_scnd_grand }}
                <?php Session::put('total_astra_a3_scnd_excel',$total_astra_a3_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A3) ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_astra_a4_scnd_grand }}
                <?php Session::put('total_astra_a4_scnd_excel',$total_astra_a4_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A4) ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_astra_a5_scnd_grand }}
                <?php Session::put('total_astra_a5_scnd_excel',$total_astra_a5_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A5) ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_astra_b1_scnd_grand }}
                <?php Session::put('total_astra_b1_scnd_excel',$total_astra_b1_scnd_grand);?>
            </span> <!-- VACCINATED (B1) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">
                {{ $total_astra_b2_scnd_grand }}
                <?php Session::put('total_astra_b2_scnd_excel',$total_astra_b2_scnd_grand);?>
            </span> <!-- VACCINATED (B2) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">
                {{ $total_astra_b3_scnd_grand }}
                <?php Session::put('total_astra_b3_scnd_excel',$total_astra_b3_scnd_grand);?>
            </span> <!-- VACCINATED (B3) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">
                {{ $total_astra_b4_scnd_grand }}
                <?php Session::put('total_astra_b4_scnd_excel',$total_astra_b4_scnd_grand);?>
            </span> <!-- VACCINATED (B4) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">
                {{ $total_vcted_astra_scnd_grand }}
                <?php Session::put('total_vcted_astra_second',$total_vcted_astra_scnd_grand);?>
            </span>
        </td>  <!-- TOTAL VACCINATED ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_mild_astra_scnd_grand }}
                <?php Session::put('total_mild_astra_scnd_excel',$total_mild_astra_scnd_grand);?>
            </span>
        </td>  <!-- MILD ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_srs_astra_scnd_grand }}
                <?php Session::put('total_srs_astra_scnd_excel',$total_srs_astra_scnd_grand);?>
            </span>
        </td> <!-- SERIOUS ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_dfrd_astra_scnd_grand }}
                <?php Session::put('total_dfrd_astra_scnd_excel',$total_dfrd_astra_scnd_grand);?>
            </span>
        </td>  <!-- DEFERRED ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_rfsd_astra_scnd_grand }}
                <?php Session::put('total_rfsd_astra_scnd_excel',$total_rfsd_astra_scnd_grand);?>
            </span>
        </td>  <!-- REFUSED ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_wstge_astra_scnd_grand }}
                <?php Session::put('total_wstge_astra_scnd_excel',$total_wstge_astra_scnd_grand);?>
            </span> <!-- WASTAGE ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">
                {{ number_format($total_p_cvrge_astra_scnd_grand,2) }}%
                <?php Session::put('total_p_cvrge_astra_scnd_excel',$total_p_cvrge_astra_scnd_grand);?>
            </span>
        </td> <!-- PERCENT COVERAGE ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_c_rate_astra_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_astra_scnd_excel',$total_c_rate_astra_scnd_grand);?>
            </span>
        </td> <!-- CONSUMPTION RATE ASTRA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_r_unvcted_scnd_astra_grand }}
                <?php Session::put('total_r_unvcted_scnd_astra_excel',$total_r_unvcted_scnd_astra_grand);?>
            </span>
        </td> <!-- REMAINING UNVACCINATED ASTRA_SECOND -->
    </tr>
    </tbody>

    <!-- PFIZER -->
    <tbody id="collapse_pfizer_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr style="background-color: #8fe7fd">
        <td rowspan="2">Pfizer</td> <!-- 1-5 -->
        <td rowspan="2">
            {{ $total_e_pop_a1_grand }}
            <?php Session::put('total_e_pop_pfizer_a1_excel',$total_e_pop_a1_grand );?>
        </td>  <!--TOTAL ELIPOP A1-->
        <td rowspan="2">
            {{ $total_e_pop_a2_grand }}
            <?php Session::put('total_e_pop_pfizer_a2_excel',$total_e_pop_a2_grand );?>
        </td>   <!--TOTAL ELIPOP A2-->
        <td rowspan="2">
            {{ $total_e_pop_a3_grand }}
            <?php Session::put('total_e_pop_pfizer_a3_excel',$total_e_pop_a3_grand );?>
        </td>  <!--TOTAL ELIPOP A3-->
        <td rowspan="2">
            {{ $total_e_pop_a4_grand }}
            <?php Session::put('total_e_pop_pfizer_a4_excel',$total_e_pop_a4_grand );?>
        </td> <!--TOTAL ELIPOP A4-->
        <td rowspan="2">
            {{ $total_e_pop_a5_grand }}
            <?php Session::put('total_e_pop_pfizer_a5_excel',$total_e_pop_a5_grand );?>
        </td> <!--TOTAL ELIPOP A5-->
        <td rowspan="2">
            {{ $total_e_pop_b1_grand }}
            <?php Session::put('total_e_pop_pfizer_b1_excel',$total_e_pop_b1_grand );?>
        </td> <!--TOTAL ELIPOP B1-->
        <td rowspan="2">
            {{ $total_e_pop_b2_grand }}
            <?php Session::put('total_e_pop_pfizer_b2_excel',$total_e_pop_b2_grand );?>
        </td> <!--TOTAL ELIPOP B2-->
        <td rowspan="2">
            {{ $total_e_pop_b3_grand }}
            <?php Session::put('total_e_pop_pfizer_b3_excel',$total_e_pop_b3_grand );?>
        </td> <!--TOTAL ELIPOP B3-->
        <td rowspan="2">
            {{ $total_e_pop_b4_grand }}
            <?php Session::put('total_e_pop_pfizer_b4_excel',$total_e_pop_b4_grand );?>
        </td> <!--TOTAL ELIPOP B4-->
        <td rowspan="2">
            {{ $total_e_pop_grand }}
             <?php Session::put('total_e_pop_pfizer_excel',$total_e_pop_grand );?>
        </td><!--//TOTAL ELI POP-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_pfizer_frst_grand }}
            <?php Session::put('total_vallocated_pfizer_frst_excel',$total_vallocated_pfizer_frst_grand );?>
        </td> <!-- VACCINE_ALLOCATED (FD) PFIZER_FIRST-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_pfizer_scnd_grand }}
            <?php Session::put('total_vallocated_pfizer_scnd_excel',$total_vallocated_pfizer_scnd_grand );?>
        </td>  <!-- VACCINE ALLOCATED (SD) PFIZER_FIRST -->
        <td rowspan="2" style="color:black;">
            {{ $total_vallocated_frst_pfizer }}
            <?php Session::put('total_vallocated_pfizer_excel',$total_vallocated_frst_pfizer );?>
        </td>  <!-- TOTAL VACCINE ALLOCATED PFIZER_FIRST -->
        <td style="color:black;">
            <span class="label label-success">
                {{ $total_pfizer_a1_frst_grand }}
                <?php Session::put('total_pfizer_a1_frst_excel',$total_pfizer_a1_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (A1) PFIZER_FIRST -->
        <td style="color:black">
            <span class="label label-success">
                {{ $total_pfizer_a2_frst_grand }}
                <?php Session::put('total_pfizer_a2_frst_excel',$total_pfizer_a2_frst_grand );?>
            </span>
        </td>  <!-- VACCINATED (A2) PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_pfizer_a3_frst_grand }}
                <?php Session::put('total_pfizer_a3_frst_excel',$total_pfizer_a3_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (A3) PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_pfizer_a4_frst_grand }}
                <?php Session::put('total_pfizer_a4_frst_excel',$total_pfizer_a4_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (A4) PFIZER_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_pfizer_a5_frst_grand }}
                 <?php Session::put('total_pfizer_a5_frst_excel',$total_pfizer_a5_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (A5) PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_pfizer_b1_frst_grand }}
                <?php Session::put('total_pfizer_b1_frst_excel',$total_pfizer_b1_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (B1) PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_pfizer_b2_frst_grand }}
                <?php Session::put('total_pfizer_b2_frst_excel',$total_pfizer_b2_frst_grand );?>
            </span>
        </td>  <!-- VACCINATED (B2) PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_pfizer_b3_frst_grand }}
                <?php Session::put('total_pfizer_b3_frst_excel',$total_pfizer_b3_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (B3) PFIZER_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_pfizer_b4_frst_grand }}
                 <?php Session::put('total_pfizer_b4_frst_excel',$total_pfizer_b4_frst_grand );?>
            </span>
        </td> <!-- VACCINATED (B4) PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_vcted_pfizer_frst_grand }}
                <?php Session::put('total_vcted_pfizer_frst_excel',$total_vcted_pfizer_frst_grand );?>
            </span>
        </td> <!-- TOTAL VACCINATED PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_mild_pfizer_frst_grand }}
                <?php Session::put('total_mild_pfizer_frst_excel',$total_mild_pfizer_frst_grand );?>
            </span>
        </td> <!-- MILD PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_srs_pfizer_frst_grand }}
                <?php Session::put('total_srs_pfizer_frst_excel',$total_srs_pfizer_frst_grand );?>
            </span>
        </td> <!-- SERIOUS PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_dfrd_pfizer_frst_grand }}
                <?php Session::put('total_dfrd_pfizer_frst_excel',$total_dfrd_pfizer_frst_grand );?>
            </span>
        </td> <!-- DEFERRED PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_rfsd_pfizer_frst_grand }}
                <?php Session::put('total_rfsd_pfizer_frst_excel',$total_rfsd_pfizer_frst_grand );?>
            </span>
        </td> <!-- REFUSED PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_wstge_pfizer_frst_grand }}
                <?php Session::put('total_wstge_pfizer_frst_excel',$total_wstge_pfizer_frst_grand );?>
            </span>
        </td> <!-- WASTAGE PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_p_cvrge_pfizer_frst_grand,2) }}%
                <?php Session::put('total_p_cvrge_pfizer_frst_excel',number_format($total_p_cvrge_pfizer_frst_grand,2));?>
            </span>
        </td> <!-- PERCENT_COVERAGE PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_c_rate_pfizer_frst_grand,2) }}%
                <?php Session::put('total_c_rate_pfizer_frst_excel',number_format($total_c_rate_pfizer_frst_grand,2));?>
            </span>
        </td> <!-- CONSUMPTION RATE PFIZER_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_r_unvcted_frst_pfizer_grand }}
                <?php Session::put('total_r_unvcted_frst_pfizer_excel',$total_r_unvcted_frst_pfizer_grand );?>
            </span>
        </td> <!-- REMAINUNG UNVACCINATED PFIZER_FIRST -->
    </tr>
    <tr style="background-color: #8fe7fd">
        <td style="color: black;">
            <span class="label label-warning">
                {{ $total_pfizer_a1_scnd_grand }}
                <?php Session::put('total_pfizer_a1_scnd_excel',$total_pfizer_a1_scnd_grand );?>
            </span>
        </td> <!-- VACCINATED (A1) PFIZER_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_pfizer_a2_scnd_grand }}
                <?php Session::put('total_pfizer_a2_scnd_excel',$total_pfizer_a2_scnd_grand );?>
            </span>
        </td> <!-- VACCINATED (A2) PFIZER_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_pfizer_a3_scnd_grand }}
                <?php Session::put('total_pfizer_a3_scnd_excel',$total_pfizer_a3_scnd_grand );?>
            </span>
        </td> <!-- VACCINATED (A3) PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_pfizer_a4_scnd_grand }}
                <?php Session::put('total_pfizer_a4_scnd_excel',$total_pfizer_a4_scnd_grand );?>
            </span>
        </td> <!-- VACCINATED (A4) PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_pfizer_a5_scnd_grand }}
                <?php Session::put('total_pfizer_a5_scnd_excel',$total_pfizer_a5_scnd_grand );?>
            </span>
        </td> <!-- VACCINATED (A5) PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_pfizer_b1_scnd_grand }}
                <?php Session::put('total_pfizer_b1_scnd_excel',$total_pfizer_b1_scnd_grand );?>
            </span>
        </td>  <!-- VACCINATED (B1) PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_pfizer_b2_scnd_grand }}
                <?php Session::put('total_pfizer_b2_scnd_excel',$total_pfizer_b2_scnd_grand );?>
            </span>
        </td>  <!-- VACCINATED (B2) PFIZER_SECOND -->
        <td>
             <span class="label label-warning">
                {{ $total_pfizer_b3_scnd_grand }}
                 <?php Session::put('total_pfizer_b3_scnd_excel',$total_pfizer_b3_scnd_grand );?>
            </span>
        </td>  <!-- VACCINATED (B3) PFIZER_SECOND -->
        <td>
             <span class="label label-warning">
                {{ $total_pfizer_b4_scnd_grand }}
                 <?php Session::put('total_pfizer_b4_scnd_excel',$total_pfizer_b4_scnd_grand );?>
            </span>
        </td>  <!-- VACCINATED (B4) PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_vcted_pfizer_scnd_grand }}
                <?php Session::put('total_vcted_pfizer_second_excel',$total_vcted_pfizer_scnd_grand );?>
            </span>
        </td> <!-- TOTAL VACCINATED PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_mild_pfizer_scnd_grand }}
                <?php Session::put('total_mild_pfizer_scnd_excel',$total_mild_pfizer_scnd_grand );?>
            </span>
        </td>  <!-- MILD PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_srs_pfizer_scnd_grand }}
                <?php Session::put('total_srs_pfizer_scnd_excel',$total_srs_pfizer_scnd_grand );?>
            </span>
        </td> <!-- SERIOUS PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_dfrd_pfizer_scnd_grand }}
                <?php Session::put('total_dfrd_pfizer_scnd_excel',$total_dfrd_pfizer_scnd_grand );?>
            </span>
        </td> <!-- DEFERRED PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_rfsd_pfizer_scnd_grand }}
                <?php Session::put('total_rfsd_pfizer_scnd_excel',$total_rfsd_pfizer_scnd_grand );?>
            </span>
        </td>  <!-- REFUSED PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_wstge_pfizer_scnd_grand }}
                <?php Session::put('total_wstge_pfizer_scnd_excel',$total_wstge_pfizer_scnd_grand );?>
            </span>
        </td>  <!-- WASTAGE PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_p_cvrge_pfizer_scnd_grand,2) }}%
                <?php Session::put('total_p_cvrge_pfizer_scnd_excel',number_format($total_p_cvrge_pfizer_scnd_grand,2) );?>
            </span>
        </td> <!-- PERCENT COVERAGE PFIZER_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_c_rate_pfizer_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_pfizer_scnd_excel',number_format($total_c_rate_pfizer_scnd_grand,2) );?>
            </span>
        </td> <!-- CONSUMPTION RATE PFIZER SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_r_unvcted_scnd_pfizer_grand }}
                <?php Session::put('total_r_unvcted_scnd_pfizer_excel',$total_r_unvcted_scnd_pfizer_grand );?>
            </span>
        </td> <!-- CONSUMPTION RATE PFIZER SECOND -->
    </tr>
    </tbody>


    <!-- SPUTNIKV -->
    <tbody id="collapse_sputnikv_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr style="background-color: #b1ffdb">
        <td rowspan="2">SputnikV</td> <!-- 1-5 -->
        <td rowspan="2">
            {{ $total_e_pop_a1_grand }}
            <?php Session::put('total_e_pop_sputnikv_a1_excel',$total_e_pop_a1_grand);?>
        </td>  <!--TOTAL ELIPOP A1 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_a2_grand }}
            <?php Session::put('total_e_pop_sputnikv_a2_excel',$total_e_pop_a2_grand);?>
        </td>   <!--TOTAL ELIPOP A2 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_a3_grand }}
            <?php Session::put('total_e_pop_sputnikv_a3_excel',$total_e_pop_a3_grand);?>
        </td>  <!--TOTAL ELIPOP A3 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_a4_grand }}
            <?php Session::put('total_e_pop_sputnikv_a4_excel',$total_e_pop_a4_grand);?>
        </td>  <!--TOTAL ELIPOP A4  SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_a5_grand }}
            <?php Session::put('total_e_pop_sputnikv_a5_excel',$total_e_pop_a5_grand);?>
        </td>  <!--TOTAL ELIPOP A5  SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_b1_grand }}
            <?php Session::put('total_e_pop_sputnikv_b1_excel',$total_e_pop_b1_grand);?>
        </td> <!--TOTAL ELIPOP B1 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_b2_grand }}
            <?php Session::put('total_e_pop_sputnikv_b2_excel',$total_e_pop_b2_grand);?>
        </td>  <!--TOTAL ELIPOP B2 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_b3_grand }}
            <?php Session::put('total_e_pop_sputnikv_b3_excel',$total_e_pop_b3_grand);?>
        </td> <!--TOTAL ELIPOP B3 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_b4_grand }}
            <?php Session::put('total_e_pop_sputnikv_b4_excel',$total_e_pop_b4_grand);?>
        </td> <!--TOTAL ELIPOP B4 SPUTNIKV-->
        <td rowspan="2">
            {{ $total_e_pop_grand }}
            <?php Session::put('total_e_pop_sputnikv_excel',$total_e_pop_grand);?>
        </td> <!--TOTAL ELI POP  SPUTNIKV-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_sputnikv_frst_grand }}
            <?php Session::put('total_vallocated_sputnikv_frst_excel',$total_vallocated_sputnikv_frst_grand);?>
        </td> <!-- VACCINE_ALLOCATED (FD) SPUTNIKV_FIRST-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_sputnikv_scnd_grand }}
            <?php Session::put('total_vallocated_sputnikv_scnd_excel',$total_vallocated_sputnikv_scnd_grand);?>
        </td>  <!-- VACCINE ALLOCATED (SD) SPUTNIKV_FIRST -->
        <td rowspan="2" style="color:black;">
            {{ $total_vallocated_frst_sputnikv }}
            <?php Session::put('total_vallocated_frst_sputnikv_excel',$total_vallocated_frst_sputnikv);?>
        </td>  <!-- TOTAL VACCINE ALLOCATED SPUTNIKV_FIRST -->
        <td style="color:black;">
            <span class="label label-success">
                {{ $total_sputnikv_a1_frst_grand }}
                <?php Session::put('total_sputnikv_a1_frst_excel',$total_sputnikv_a1_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) SPUTNIKV_FIRST -->
        <td style="color:black">
            <span class="label label-success">
                {{ $total_sputnikv_a2_frst_grand }}
                <?php Session::put('total_sputnikv_a2_frst_excel',$total_sputnikv_a2_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A2) SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_sputnikv_a3_frst_grand }}
                <?php Session::put('total_sputnikv_a3_frst_excel',$total_sputnikv_a3_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_sputnikv_a4_frst_grand }}
                <?php Session::put('total_sputnikv_a4_frst_excel',$total_sputnikv_a4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A4) SPUTNIKV_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_sputnikv_a5_frst_grand }}
                  <?php Session::put('total_sputnikv_a5_frst_excel',$total_sputnikv_a5_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) SPUTNIKV_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_sputnikv_b1_frst_grand }}
                  <?php Session::put('total_sputnikv_b1_frst_excel',$total_sputnikv_b1_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) SPUTNIKV_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_sputnikv_b2_frst_grand }}
                  <?php Session::put('total_sputnikv_b2_frst_excel',$total_sputnikv_b2_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) SPUTNIKV_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_sputnikv_b3_frst_grand }}
                  <?php Session::put('total_sputnikv_b3_frst_excel',$total_sputnikv_b3_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) SPUTNIKV_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_sputnikv_b4_frst_grand }}
                 <?php Session::put('total_sputnikv_b4_frst_excel',$total_sputnikv_b4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_vcted_sputnikv_frst_grand }}
                <?php Session::put('total_vcted_sputnikv_frst_excel',$total_vcted_sputnikv_frst_grand);?>
            </span>
        </td> <!-- TOTAL VACCINATED SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_mild_sputnikv_frst_grand }}
                <?php Session::put('total_mild_sputnikv_frst_excel',$total_mild_sputnikv_frst_grand);?>
            </span>
        </td> <!-- MILD SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_srs_sputnikv_frst_grand }}
                <?php Session::put('total_srs_sputnikv_frst_excel',$total_srs_sputnikv_frst_grand);?>
            </span> <!-- SERIOUS SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_dfrd_sputnikv_frst_grand }}
                <?php Session::put('total_dfrd_sputnikv_frst_excel',$total_dfrd_sputnikv_frst_grand);?>
            </span>
        </td>  <!-- DEFERRED SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_rfsd_sputnikv_frst_grand }}
                <?php Session::put('total_rfsd_sputnikv_frst_excel',$total_rfsd_sputnikv_frst_grand);?>
            </span>
        </td>  <!-- REFUSED SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_wstge_sputnikv_frst_grand }}
                <?php Session::put('total_wstge_sputnikv_frst_excel',$total_wstge_sputnikv_frst_grand);?>
            </span>
        </td>  <!-- WASTAGE SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_p_cvrge_sputnikv_frst_grand,2) }}%
                <?php Session::put('total_p_cvrge_sputnikv_frst_excel',$total_p_cvrge_sputnikv_frst_grand);?>
            </span>
        </td>  <!-- PERCENT_COVERAGE SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_c_rate_sputnikv_frst_grand,2) }}%
                <?php Session::put('total_c_rate_sputnikv_frst_excel',$total_c_rate_sputnikv_frst_grand);?>
            </span>
        </td>  <!-- CONSUMPTION RATE SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_r_unvcted_frst_sputnikv_grand }}
                <?php Session::put('total_r_unvcted_frst_sputnikv_excel',$total_r_unvcted_frst_sputnikv_grand);?>
            </span> <!-- REMAINUNG UNVACCINATED SPUTNIKV_FIRST -->
        </td>
    </tr>
    <tr style="background-color: #b1ffdb">
        <td style="color: black;">
            <span class="label label-warning">
                {{ $total_sputnikv_a1_scnd_grand }}
                <?php Session::put('total_sputnikv_a1_scnd_excel',$total_sputnikv_a1_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) SPUTNIKV_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_sputnikv_a2_scnd_grand }}
                <?php Session::put('total_sputnikv_a2_scnd_excel',$total_sputnikv_a2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A2) SPUTNIKV_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_sputnikv_a3_scnd_grand }}
                <?php Session::put('total_sputnikv_a3_scnd_excel',$total_sputnikv_a3_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_sputnikv_a4_scnd_grand }}
                <?php Session::put('total_sputnikv_a4_scnd_excel',$total_sputnikv_a4_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A4) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_sputnikv_a5_scnd_grand }}
                <?php Session::put('total_sputnikv_a5_scnd_excel',$total_sputnikv_a5_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_sputnikv_b1_scnd_grand }}
                <?php Session::put('total_sputnikv_b1_scnd_excel',$total_sputnikv_b1_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_sputnikv_b2_scnd_grand }}
                <?php Session::put('total_sputnikv_b2_scnd_excel',$total_sputnikv_b2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_sputnikv_b3_scnd_grand }}
                <?php Session::put('total_sputnikv_b3_scnd_excel',$total_sputnikv_b3_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_sputnikv_b4_scnd_grand }}
                <?php Session::put('total_sputnikv_b4_scnd_excel',$total_sputnikv_b4_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_vcted_sputnikv_scnd_grand }}
                <?php Session::put('total_vcted_sputnikv_second_excel',$total_vcted_sputnikv_scnd_grand);?>
            </span>
        </td>  <!-- TOTAL VACCINATED SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_mild_sputnikv_scnd_grand }}
                <?php Session::put('total_mild_sputnikv_scnd_excel',$total_mild_sputnikv_scnd_grand);?>
            </span>
        </td> <!-- MILD SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_srs_sputnikv_scnd_grand }}
                <?php Session::put('total_srs_sputnikv_scnd_excel',$total_srs_sputnikv_scnd_grand);?>
            </span>
        </td> <!-- SERIOUS SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_dfrd_sputnikv_scnd_grand }}
                <?php Session::put('total_dfrd_sputnikv_scnd_excel',$total_dfrd_sputnikv_scnd_grand);?>
            </span>
        </td>  <!-- DEFERRED SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_rfsd_sputnikv_scnd_grand }}
                <?php Session::put('total_rfsd_sputnikv_scnd_excel',$total_rfsd_sputnikv_scnd_grand);?>
            </span>
        </td> <!-- REFUSED SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_wstge_sputnikv_scnd_grand }}
                <?php Session::put('total_wstge_sputnikv_scnd_excel',$total_wstge_sputnikv_scnd_grand);?>
            </span>
        </td>  <!-- WASTAGE SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_p_cvrge_sputnikv_scnd_grand,2) }}%
                <?php Session::put('total_p_cvrge_sputnikv_scnd_excel',$total_p_cvrge_sputnikv_scnd_grand);?>
            </span>
        </td>  <!-- PERCENT COVERAGE SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_c_rate_sputnikv_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_sputnikv_scnd_excel',$total_c_rate_sputnikv_scnd_grand);?>
            </span>
        </td> <!-- CONSUMPTION RATE SPUTNIKV_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_r_unvcted_scnd_sputnikv_grand }}
                <?php Session::put('total_r_unvcted_scnd_sputnikv_excel',$total_r_unvcted_scnd_sputnikv_grand);?>
            </span>
        </td>  <!-- REMAINING UNVACCINATED SPUTNIKV_SECOND -->
    </tr>
    </tbody>
    <!-- MODERNA -->
    <tbody id="collapse_moderna_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr style="background-color: #dad8ff">
        <td rowspan="2">Moderna</td> <!-- 1-5 -->
        <td rowspan="2">
            {{ $total_e_pop_a1_grand }}
            <?php Session::put('total_e_pop_moderna_a1_excel',$total_e_pop_a1_grand);?>
        </td>  <!--TOTAL ELIPOP A1 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_a2_grand }}
            <?php Session::put('total_e_pop_moderna_a2_excel',$total_e_pop_a2_grand);?>
        </td>   <!--TOTAL ELIPOP A2 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_a3_grand }}
            <?php Session::put('total_e_pop_moderna_a3_excel',$total_e_pop_a3_grand);?>
        </td>  <!--TOTAL ELIPOP A3 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_a4_grand }}
            <?php Session::put('total_e_pop_moderna_a4_excel',$total_e_pop_a4_grand);?>
        </td>  <!--TOTAL ELIPOP A4  MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_a5_grand }}
            <?php Session::put('total_e_pop_moderna_a5_excel',$total_e_pop_a5_grand);?>
        </td>  <!--TOTAL ELIPOP A5  MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_b1_grand }}
            <?php Session::put('total_e_pop_moderna_b1_excel',$total_e_pop_b1_grand);?>
        </td> <!--TOTAL ELIPOP B1 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_b2_grand }}
            <?php Session::put('total_e_pop_moderna_b2_excel',$total_e_pop_b2_grand);?>
        </td>  <!--TOTAL ELIPOP B2 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_b3_grand }}
            <?php Session::put('total_e_pop_moderna_b3_excel',$total_e_pop_b3_grand);?>
        </td> <!--TOTAL ELIPOP B3 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_b4_grand }}
            <?php Session::put('total_e_pop_moderna_b4_excel',$total_e_pop_b4_grand);?>
        </td> <!--TOTAL ELIPOP B4 MODERNA-->
        <td rowspan="2">
            {{ $total_e_pop_grand }}
            <?php Session::put('total_e_pop_moderna_excel',$total_e_pop_grand);?>
        </td> <!--TOTAL ELI POP  MODERNA-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_moderna_frst_grand }}
            <?php Session::put('total_vallocated_moderna_frst_excel',$total_vallocated_moderna_frst_grand);?>
        </td> <!-- VACCINE_ALLOCATED (FD) MODERNA_FIRST-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_moderna_scnd_grand }}
            <?php Session::put('total_vallocated_moderna_scnd_excel',$total_vallocated_moderna_scnd_grand);?>
        </td>  <!-- VACCINE ALLOCATED (SD) MODERNA_FIRST -->
        <td rowspan="2" style="color:black;">
            {{ $total_vallocated_frst_moderna }}
            <?php Session::put('total_vallocated_frst_moderna_excel',$total_vallocated_frst_moderna);?>
        </td>  <!-- TOTAL VACCINE ALLOCATED MODERNA_FIRST -->
        <td style="color:black;">
            <span class="label label-success">
                {{ $total_moderna_a1_frst_grand }}
                <?php Session::put('total_moderna_a1_frst_excel',$total_moderna_a1_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) MODERNA_FIRST -->
        <td style="color:black">
            <span class="label label-success">
                {{ $total_moderna_a2_frst_grand }}
                <?php Session::put('total_moderna_a2_frst_excel',$total_moderna_a2_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A2) MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_moderna_a3_frst_grand }}
                <?php Session::put('total_moderna_a3_frst_excel',$total_moderna_a3_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_moderna_a4_frst_grand }}
                <?php Session::put('total_moderna_a4_frst_excel',$total_moderna_a4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A4) MODERNA_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_moderna_a5_frst_grand }}
                  <?php Session::put('total_moderna_a5_frst_excel',$total_moderna_a5_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) MODERNA_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_moderna_b1_frst_grand }}
                  <?php Session::put('total_moderna_b1_frst_excel',$total_moderna_b1_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) MODERNA_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_moderna_b2_frst_grand }}
                  <?php Session::put('total_moderna_b2_frst_excel',$total_moderna_b2_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) MODERNA_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_moderna_b3_frst_grand }}
                  <?php Session::put('total_moderna_b3_frst_excel',$total_moderna_b3_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) MODERNA_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_moderna_b4_frst_grand }}
                 <?php Session::put('total_moderna_b4_frst_excel',$total_moderna_b4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_vcted_moderna_frst_grand }}
                <?php Session::put('total_vcted_moderna_frst_excel',$total_vcted_moderna_frst_grand);?>
            </span>
        </td> <!-- TOTAL VACCINATED MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_mild_moderna_frst_grand }}
                <?php Session::put('total_mild_moderna_frst_excel',$total_mild_moderna_frst_grand);?>
            </span>
        </td> <!-- MILD MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_srs_moderna_frst_grand }}
                <?php Session::put('total_srs_moderna_frst_excel',$total_srs_moderna_frst_grand);?>
            </span> <!-- SERIOUS MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_dfrd_moderna_frst_grand }}
                <?php Session::put('total_dfrd_moderna_frst_excel',$total_dfrd_moderna_frst_grand);?>
            </span>
        </td>  <!-- DEFERRED MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_rfsd_moderna_frst_grand }}
                <?php Session::put('total_rfsd_moderna_frst_excel',$total_rfsd_moderna_frst_grand);?>
            </span>
        </td>  <!-- REFUSED MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_wstge_moderna_frst_grand }}
                <?php Session::put('total_wstge_moderna_frst_excel',$total_wstge_moderna_frst_grand);?>
            </span>
        </td>  <!-- WASTAGE MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_p_cvrge_moderna_frst_grand,2) }}%
                <?php Session::put('total_p_cvrge_moderna_frst_excel',$total_p_cvrge_moderna_frst_grand);?>
            </span>
        </td>  <!-- PERCENT_COVERAGE MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_c_rate_moderna_frst_grand,2) }}%
                <?php Session::put('total_c_rate_moderna_frst_excel',$total_c_rate_moderna_frst_grand);?>
            </span>
        </td>  <!-- CONSUMPTION RATE MODERNA_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_r_unvcted_frst_moderna_grand }}
                <?php Session::put('total_r_unvcted_frst_moderna_excel',$total_r_unvcted_frst_moderna_grand);?>
            </span> <!-- REMAINUNG UNVACCINATED MODERNA_FIRST -->
        </td>
    </tr>
    <tr style="background-color: #dad8ff">
        <td style="color: black;">
            <span class="label label-warning">
                {{ $total_moderna_a1_scnd_grand }}
                <?php Session::put('total_moderna_a1_scnd_excel',$total_moderna_a1_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) MODERNA_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_moderna_a2_scnd_grand }}
                <?php Session::put('total_moderna_a2_scnd_excel',$total_moderna_a2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A2) MODERNA_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_moderna_a3_scnd_grand }}
                <?php Session::put('total_moderna_a3_scnd_excel',$total_moderna_a3_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_moderna_a4_scnd_grand }}
                <?php Session::put('total_moderna_a4_scnd_excel',$total_moderna_a4_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A4) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_moderna_a5_scnd_grand }}
                <?php Session::put('total_moderna_a5_scnd_excel',$total_moderna_a5_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_moderna_b1_scnd_grand }}
                <?php Session::put('total_moderna_b1_scnd_excel',$total_moderna_b1_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_moderna_b2_scnd_grand }}
                <?php Session::put('total_moderna_b2_scnd_excel',$total_moderna_b2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_moderna_b3_scnd_grand }}
                <?php Session::put('total_moderna_b3_scnd_excel',$total_moderna_b3_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_moderna_b4_scnd_grand }}
                <?php Session::put('total_moderna_b4_scnd_excel',$total_moderna_b4_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_vcted_moderna_scnd_grand }}
                <?php Session::put('total_vcted_moderna_second_excel',$total_vcted_moderna_scnd_grand);?>
            </span>
        </td>  <!-- TOTAL VACCINATED MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_mild_moderna_scnd_grand }}
                <?php Session::put('total_mild_moderna_scnd_excel',$total_mild_moderna_scnd_grand);?>
            </span>
        </td> <!-- MILD MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_srs_moderna_scnd_grand }}
                <?php Session::put('total_srs_moderna_scnd_excel',$total_srs_moderna_scnd_grand);?>
            </span>
        </td> <!-- SERIOUS MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_dfrd_moderna_scnd_grand }}
                <?php Session::put('total_dfrd_moderna_scnd_excel',$total_dfrd_moderna_scnd_grand);?>
            </span>
        </td>  <!-- DEFERRED MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_rfsd_moderna_scnd_grand }}
                <?php Session::put('total_rfsd_moderna_scnd_excel',$total_rfsd_moderna_scnd_grand);?>
            </span>
        </td> <!-- REFUSED MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_wstge_moderna_scnd_grand }}
                <?php Session::put('total_wstge_moderna_scnd_excel',$total_wstge_moderna_scnd_grand);?>
            </span>
        </td>  <!-- WASTAGE MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_p_cvrge_moderna_scnd_grand,2) }}%
                <?php Session::put('total_p_cvrge_moderna_scnd_excel',$total_p_cvrge_moderna_scnd_grand);?>
            </span>
        </td>  <!-- PERCENT COVERAGE MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_c_rate_moderna_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_moderna_scnd_excel',$total_c_rate_moderna_scnd_grand);?>
            </span>
        </td> <!-- CONSUMPTION RATE MODERNA_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_r_unvcted_scnd_moderna_grand }}
                <?php Session::put('total_r_unvcted_scnd_moderna_excel',$total_r_unvcted_scnd_moderna_grand);?>
            </span>
        </td>  <!-- REMAINING UNVACCINATED MODERNA_SECOND -->
    </tr>
    </tbody>

    <!-- JOHNSON -->
    <tbody id="collapse_johnson_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr style="background-color: #9af5ee">
        <td rowspan="2">Janssen</td> <!-- 1-5 -->
        <td rowspan="2">
            {{ $total_e_pop_a1_grand }}
            <?php Session::put('total_e_pop_johnson_a1_excel',$total_e_pop_a1_grand);?>
        </td>  <!--TOTAL ELIPOP A1 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_a2_grand }}
            <?php Session::put('total_e_pop_johnson_a2_excel',$total_e_pop_a2_grand);?>
        </td>   <!--TOTAL ELIPOP A2 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_a3_grand }}
            <?php Session::put('total_e_pop_johnson_a3_excel',$total_e_pop_a3_grand);?>
        </td>  <!--TOTAL ELIPOP A3 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_a4_grand }}
            <?php Session::put('total_e_pop_johnson_a4_excel',$total_e_pop_a4_grand);?>
        </td>  <!--TOTAL ELIPOP A4  JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_a5_grand }}
            <?php Session::put('total_e_pop_johnson_a5_excel',$total_e_pop_a5_grand);?>
        </td>  <!--TOTAL ELIPOP A5  JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_b1_grand }}
            <?php Session::put('total_e_pop_johnson_b1_excel',$total_e_pop_b1_grand);?>
        </td> <!--TOTAL ELIPOP B1 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_b2_grand }}
            <?php Session::put('total_e_pop_johnson_b2_excel',$total_e_pop_b2_grand);?>
        </td>  <!--TOTAL ELIPOP B2 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_b3_grand }}
            <?php Session::put('total_e_pop_johnson_b3_excel',$total_e_pop_b3_grand);?>
        </td> <!--TOTAL ELIPOP B3 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_b4_grand }}
            <?php Session::put('total_e_pop_johnson_b4_excel',$total_e_pop_b4_grand);?>
        </td> <!--TOTAL ELIPOP B4 JOHNSON-->
        <td rowspan="2">
            {{ $total_e_pop_grand }}
            <?php Session::put('total_e_pop_johnson_excel',$total_e_pop_grand);?>
        </td> <!--TOTAL ELI POP  JOHNSON-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_johnson_frst_grand }}
            <?php Session::put('total_vallocated_johnson_frst_excel',$total_vallocated_johnson_frst_grand);?>
        </td> <!-- VACCINE_ALLOCATED (FD) JOHNSON_FIRST-->
        <td rowspan="2" style="color:black">
            {{ $total_vallocated_johnson_scnd_grand }}
            <?php Session::put('total_vallocated_johnson_scnd_excel',$total_vallocated_johnson_scnd_grand);?>
        </td>  <!-- VACCINE ALLOCATED (SD) JOHNSON_FIRST -->
        <td rowspan="2" style="color:black;">
            {{ $total_vallocated_frst_johnson }}
            <?php Session::put('total_vallocated_frst_johnson_excel',$total_vallocated_frst_johnson);?>
        </td>  <!-- TOTAL VACCINE ALLOCATED JOHNSON_FIRST -->
        <td style="color:black;">
            <span class="label label-success">
                {{ $total_johnson_a1_frst_grand }}
                <?php Session::put('total_johnson_a1_frst_excel',$total_johnson_a1_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) JOHNSON_FIRST -->
        <td style="color:black">
            <span class="label label-success">
                {{ $total_johnson_a2_frst_grand }}
                <?php Session::put('total_johnson_a2_frst_excel',$total_johnson_a2_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A2) JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_johnson_a3_frst_grand }}
                <?php Session::put('total_johnson_a3_frst_excel',$total_johnson_a3_frst_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_johnson_a4_frst_grand }}
                <?php Session::put('total_johnson_a4_frst_excel',$total_johnson_a4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A4) JOHNSON_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_johnson_a5_frst_grand }}
                  <?php Session::put('total_johnson_a5_frst_excel',$total_johnson_a5_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) JOHNSON_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_johnson_b1_frst_grand }}
                  <?php Session::put('total_johnson_b1_frst_excel',$total_johnson_b1_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) JOHNSON_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_johnson_b2_frst_grand }}
                  <?php Session::put('total_johnson_b2_frst_excel',$total_johnson_b2_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) JOHNSON_FIRST -->
        <td>
              <span class="label label-success">
                {{ $total_johnson_b3_frst_grand }}
                  <?php Session::put('total_johnson_b3_frst_excel',$total_johnson_b3_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) JOHNSON_FIRST -->
        <td>
             <span class="label label-success">
                {{ $total_johnson_b4_frst_grand }}
                 <?php Session::put('total_johnson_b4_frst_excel',$total_johnson_b4_frst_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_vcted_johnson_frst_grand }}
                <?php Session::put('total_vcted_johnson_frst_excel',$total_vcted_johnson_frst_grand);?>
            </span>
        </td> <!-- TOTAL VACCINATED JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_mild_johnson_frst_grand }}
                <?php Session::put('total_mild_johnson_frst_excel',$total_mild_johnson_frst_grand);?>
            </span>
        </td> <!-- MILD JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_srs_johnson_frst_grand }}
                <?php Session::put('total_srs_johnson_frst_excel',$total_srs_johnson_frst_grand);?>
            </span> <!-- SERIOUS JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">
                {{ $total_dfrd_johnson_frst_grand }}
                <?php Session::put('total_dfrd_johnson_frst_excel',$total_dfrd_johnson_frst_grand);?>
            </span>
        </td>  <!-- DEFERRED JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_rfsd_johnson_frst_grand }}
                <?php Session::put('total_rfsd_johnson_frst_excel',$total_rfsd_johnson_frst_grand);?>
            </span>
        </td>  <!-- REFUSED JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_wstge_johnson_frst_grand }}
                <?php Session::put('total_wstge_johnson_frst_excel',$total_wstge_johnson_frst_grand);?>
            </span>
        </td>  <!-- WASTAGE JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_p_cvrge_johnson_frst_grand,2) }}%
                <?php Session::put('total_p_cvrge_johnson_frst_excel',$total_p_cvrge_johnson_frst_grand);?>
            </span>
        </td>  <!-- PERCENT_COVERAGE JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ number_format($total_c_rate_johnson_frst_grand,2) }}%
                <?php Session::put('total_c_rate_johnson_frst_excel',$total_c_rate_johnson_frst_grand);?>
            </span>
        </td>  <!-- CONSUMPTION RATE JOHNSON_FIRST -->
        <td>
            <span class="label label-success">
                {{ $total_r_unvcted_frst_johnson_grand }}
                <?php Session::put('total_r_unvcted_frst_johnson_excel',$total_r_unvcted_frst_johnson_grand);?>
            </span> <!-- REMAINUNG UNVACCINATED JOHNSON_FIRST -->
        </td>
    </tr>
    <tr style="background-color: #9af5ee">
        <td style="color: black;">
            <span class="label label-warning">
                {{ $total_johnson_a1_scnd_grand }}
                <?php Session::put('total_johnson_a1_scnd_excel',$total_johnson_a1_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A1) JOHNSON_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_johnson_a2_scnd_grand }}
                <?php Session::put('total_johnson_a2_scnd_excel',$total_johnson_a2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A2) JOHNSON_SECOND -->
        <td style="color:black;">
            <span class="label label-warning">
                {{ $total_johnson_a3_scnd_grand }}
                <?php Session::put('total_johnson_a3_scnd_excel',$total_johnson_a3_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A3) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_johnson_a4_scnd_grand }}
                <?php Session::put('total_johnson_a4_scnd_excel',$total_johnson_a4_scnd_grand);?>
            </span>
        </td>  <!-- VACCINATED (A4) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_johnson_a5_scnd_grand }}
                <?php Session::put('total_johnson_a5_scnd_excel',$total_johnson_a5_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (A5) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_johnson_b1_scnd_grand }}
                <?php Session::put('total_johnson_b1_scnd_excel',$total_johnson_b1_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B1) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_johnson_b2_scnd_grand }}
                <?php Session::put('total_johnson_b2_scnd_excel',$total_johnson_b2_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B2) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_johnson_b3_scnd_grand }}
                <?php Session::put('total_johnson_b3_scnd_excel',$total_johnson_b3_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B3) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_johnson_b4_scnd_grand }}
                <?php Session::put('total_johnson_b4_scnd_excel',$total_johnson_b4_scnd_grand);?>
            </span>
        </td> <!-- VACCINATED (B4) JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_vcted_johnson_scnd_grand }}
                <?php Session::put('total_vcted_johnson_second_excel',$total_vcted_johnson_scnd_grand);?>
            </span>
        </td>  <!-- TOTAL VACCINATED JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_mild_johnson_scnd_grand }}
                <?php Session::put('total_mild_johnson_scnd_excel',$total_mild_johnson_scnd_grand);?>
            </span>
        </td> <!-- MILD JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_srs_johnson_scnd_grand }}
                <?php Session::put('total_srs_johnson_scnd_excel',$total_srs_johnson_scnd_grand);?>
            </span>
        </td> <!-- SERIOUS JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_dfrd_johnson_scnd_grand }}
                <?php Session::put('total_dfrd_johnson_scnd_excel',$total_dfrd_johnson_scnd_grand);?>
            </span>
        </td>  <!-- DEFERRED JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_rfsd_johnson_scnd_grand }}
                <?php Session::put('total_rfsd_johnson_scnd_excel',$total_rfsd_johnson_scnd_grand);?>
            </span>
        </td> <!-- REFUSED JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_wstge_johnson_scnd_grand }}
                <?php Session::put('total_wstge_johnson_scnd_excel',$total_wstge_johnson_scnd_grand);?>
            </span>
        </td>  <!-- WASTAGE JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_p_cvrge_johnson_scnd_grand,2) }}%
                <?php Session::put('total_p_cvrge_johnson_scnd_excel',$total_p_cvrge_johnson_scnd_grand);?>
            </span>
        </td>  <!-- PERCENT COVERAGE JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ number_format($total_c_rate_johnson_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_johnson_scnd_excel',$total_c_rate_johnson_scnd_grand);?>
            </span>
        </td> <!-- CONSUMPTION RATE JOHNSON_SECOND -->
        <td>
            <span class="label label-warning">
                {{ $total_r_unvcted_scnd_johnson_grand }}
                <?php Session::put('total_r_unvcted_scnd_johnson_excel',$total_r_unvcted_scnd_johnson_grand);?>
            </span>
        </td>  <!-- REMAINING UNVACCINATED JOHNSON_SECOND -->
    </tr>
    </tbody>

    <tbody>
    <tr>
        <td>Total</td> <!-- 1-7 -->
        <td>{{ $total_e_pop_a1_grand }}</td> <!-- TOTAL A1  -->
        <td>{{ $total_e_pop_a2_grand }}</td> <!-- TOTAL A2 -->
        <td>{{ $total_e_pop_a3_grand }}</td> <!-- TOTAL A3 -->
        <td>{{ $total_e_pop_a4_grand }}</td> <!-- TOTAL A4 -->
        <td>{{ $total_e_pop_a5_grand }}</td> <!-- TOTAL A5 -->
        <td>{{ $total_e_pop_b1_grand }}</td> <!-- TOTAL B1 -->
        <td>{{ $total_e_pop_b2_grand }}</td> <!-- TOTAL B2 -->
        <td>{{ $total_e_pop_b3_grand }}</td> <!-- TOTAL B3 -->
        <td>{{ $total_e_pop_b4_grand }}</td> <!-- TOTAL B4 -->
        <td>{{ $total_e_pop_grand }}</td> <!-- TOTAL E POP  -->
        <td>
            {{ $total_vallocated_frst_grand }}
            <?php Session::put('total_vallocated_frst_excel',$total_vallocated_frst_grand );?>
        </td> <!-- TOTAL VACCINE ALLOCATED FIRST -->
        <td>
            {{ $total_vallocated_scnd_grand }}
            <?php Session::put('total_vallocated_scnd_excel',$total_vallocated_scnd_grand );?>
        </td> <!-- TOTAL VACCINE ALLOCATED SECOND -->
        <td><b>
            {{ $total_vallocated }}
            <?php Session::put('total_vallocated_excel',$total_vallocated );?>
            </b></td>  <!-- TOTAL VACCINE ALLOCATED  -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_a1_first_grand }}
            <?php Session::put('total_vcted_grand_a1_first_excel',$total_vcted_a1_first_grand );?>
            </b> <!-- TOTAL VACCINATED (A1) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_a2_first_grand }}
             <?php Session::put('total_vcted_grand_a2_first_excel',$total_vcted_a2_first_grand );?>
            </b>  <!-- TOTAL VACCINATED (A2) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_a3_first_grand }}
                <?php Session::put('total_vcted_grand_a3_first_excel',$total_vcted_a3_first_grand );?>
            </b> <!-- TOTAL VACCINATED (A3) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_a4_first_grand }}
                <?php Session::put('total_vcted_grand_a4_first_excel',$total_vcted_a4_first_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED (A4) -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_a5_first_grand }}
                <?php Session::put('total_vcted_grand_a5_first_excel',$total_vcted_a5_first_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED (A5) -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_b1_first_grand }}
                <?php Session::put('total_vcted_grand_b1_first_excel',$total_vcted_b1_first_grand );?>
            </b>
        </td>  <!-- TOTAL VACCINATED (B1) -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_b2_first_grand }}
                <?php Session::put('total_vcted_grand_b2_first_excel',$total_vcted_b2_first_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED (B2) -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_b3_first_grand }}
                <?php Session::put('total_vcted_grand_b3_first_excel',$total_vcted_b3_first_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED (B3) -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{$total_vcted_b4_first_grand }}
                <?php Session::put('total_vcted_grand_b4_first_excel',$total_vcted_b4_first_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED (B4) -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_first_overall }}
                <?php Session::put('total_vcted_overall_frst_excel',$total_vcted_first_overall );?>
            </b>
        </td> <!-- TOTAL VACCINATED FIRST DOSE OVERALL-->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_mild_overall_frst }}
                <?php Session::put('total_mild_overall_frst_excel',$total_mild_overall_frst );?>
            </b>
        </td> <!--  TOTAL MILD-->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_srs_overall_frst }}
                <?php Session::put('total_srs_overall_frst_excel',$total_srs_overall_frst );?>
            </b>
        </td>  <!-- TOTAL SERIOUS -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_dfrd_overall_frst }}
                <?php Session::put('total_dfrd_overall_frst_excel',$total_dfrd_overall_frst );?>
            </b>
        </td> <!-- TOTAL DEFERRED -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_rfsd_overall_frst }}
                <?php Session::put('total_rfsd_overall_frst_excel',$total_rfsd_overall_frst );?>
            </b>
        </td> <!-- TOTAL REFUSED -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_wstge_overall_first }}
                <?php Session::put('total_wstge_overall_frst_excel',$total_wstge_overall_first );?>
            </b>
        </td>  <!-- TOTAL WASTAGE -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ number_format($total_p_cvrge_overall_frst,2) }}%
                <?php Session::put('total_p_cvrge_frst_excel',number_format($total_p_cvrge_overall_frst,2) );?>
            </b>
        </td> <!-- PERCENT_COVERAGE_OVERALL_FIRST -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ number_format($total_c_rate_frst_grand,2) }}%
                <?php Session::put('total_c_rate_frst_excel',$total_c_rate_frst_grand );?>
            </b>
        </td>  <!-- TOTAL CONSUMPTION RATE -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_r_unvcted_all_frst_grand }}
                <?php Session::put('total_r_unvcted_all_frst_excel',$total_r_unvcted_all_frst_grand );?>
            </b>
        </td>  <!-- TOTAL REMAINUNG UNVACCINATED  -->
    </tr>
    <tr>
        <td></td> <!-- 1-7 -->
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_a1_grand }}
                <?php Session::put('total_vcted_grand_a1_second_excel',$total_vcted_scnd_a1_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE A1 -->
        <td>

            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_a2_grand }}
                <?php Session::put('total_vcted_grand_a2_second_excel',$total_vcted_scnd_a2_grand );?>
            </b>
        </td>  <!-- TOTAL VACCINATED SECOND DOSE A2 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_a3_grand }}
                <?php Session::put('total_vcted_grand_a3_second_excel',$total_vcted_scnd_a3_grand );?>
            </b>
        </td>  <!-- TOTAL VACCINATED SECOND DOSE A3 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_a4_grand }}
                <?php Session::put('total_vcted_grand_a4_second_excel',$total_vcted_scnd_a4_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE A4-->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_a5_grand }}
                <?php Session::put('total_vcted_grand_a5_second_excel',$total_vcted_scnd_a5_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE A5 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_b1_grand }}
                <?php Session::put('total_vcted_grand_b1_second_excel',$total_vcted_scnd_b1_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE B1 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_b2_grand }}
                <?php Session::put('total_vcted_grand_b2_second_excel',$total_vcted_scnd_b2_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE B2 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_b3_grand }}
                <?php Session::put('total_vcted_grand_b3_second_excel',$total_vcted_scnd_b3_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE B3 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_b4_grand }}
                <?php Session::put('total_vcted_grand_b4_second_excel',$total_vcted_scnd_b4_grand );?>
            </b>
        </td> <!-- TOTAL VACCINATED SECOND DOSE B4 -->
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_scnd_overall }}</b>
                 <?php Session::put('total_vcted_overall_second_excel',$total_vcted_scnd_overall );?>
            <!-- //TOTAL VACCINATED SECOND DOSE OVERALL -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_mild_overall_scnd }}
                <?php Session::put('total_mild_overall_scnd_excel',$total_mild_overall_scnd );?>
            </b> <!-- TOTAL MILD 2 -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_srs_overall_scnd }}
                <?php Session::put('total_srs_overall_scnd_excel',$total_srs_overall_scnd );?>
            </b> <!-- TOTAL SERIOUS  2 -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_dfrd_overall_scnd }}
                <?php Session::put('total_dfrd_overall_scnd_excel',$total_dfrd_overall_scnd );?>
            </b> <!-- TOTAL DEFERRED  2 -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_rfsd_overall_scnd }}
                <?php Session::put('total_rfsd_overall_frst_excel',$total_rfsd_overall_scnd );?>
            </b> <!-- TOTAL REFUSED  2 -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_wstge_overall_scnd }}
                <?php Session::put('total_wstge_overall_scnd_excel',$total_wstge_overall_scnd );?>
            </b> <!-- TOTAL WASTAGE  2 -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ number_format($total_p_cvrge_overall_scnd,2) }}%
                <?php Session::put('total_p_cvrge_scnd_excel',number_format($total_p_cvrge_overall_scnd,2) );?>
            </b> <!-- PERCENT_COVERAGE_OVERALL_FIRST -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ number_format($total_c_rate_scnd_grand,2) }}%
                <?php Session::put('total_c_rate_scnd_excel',number_format($total_c_rate_scnd_grand,2) );?>
            </b> <!-- TOTAL CONSUMPTION RATE  2 -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_r_unvcted_all_scnd_grand }}
                <?php Session::put('total_r_unvcted_all_scnd_excel',$total_r_unvcted_all_scnd_grand );?>
            </b> <!-- TOTAL REMAINING UNVACCIANTED  2 -->
        </td>
    </tr>
    </tbody>
</table>
