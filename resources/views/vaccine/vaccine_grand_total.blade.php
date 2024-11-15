<hr>
<?php
    function convertToZero($value){
        if($value)
            return $value;

        return 0;
    }

    //ELIGIBLE POP SINOVAC
     $global_elipop_a1 = \App\Muncity::select(DB::raw("sum(COALESCE(a1,0)) as a1"))->where("province_id",$province_id)->first()->a1;
     $global_elipop_a2 = \App\Muncity::select(DB::raw("sum(COALESCE(a2,0)) as a2"))->where("province_id",$province_id)->first()->a2;
     $global_elipop_a3 = \App\Muncity::select(DB::raw("sum(COALESCE(a3,0)) as a3"))->where("province_id",$province_id)->first()->a3;
     $global_elipop_a4 = \App\Muncity::select(DB::raw("sum(COALESCE(a4,0)) as a4"))->where("province_id",$province_id)->first()->a4;
     $global_elipop_a5 = \App\Muncity::select(DB::raw("sum(COALESCE(a5,0)) as a5"))->where("province_id",$province_id)->first()->a5;
     $global_elipop_b1 = \App\Muncity::select(DB::raw("sum(COALESCE(b1,0)) as b1"))->where("province_id",$province_id)->first()->b1;
     $global_elipop_b2 = \App\Muncity::select(DB::raw("sum(COALESCE(b2,0)) as b2"))->where("province_id",$province_id)->first()->b2;
     $global_elipop_b3 = \App\Muncity::select(DB::raw("sum(COALESCE(b3,0)) as b3"))->where("province_id",$province_id)->first()->b3;
     $global_elipop_b4 = \App\Muncity::select(DB::raw("sum(COALESCE(b4,0)) as b4"))->where("province_id",$province_id)->first()->b4;

    $total_e_pop_svac_a1_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_a1 :0;   //A1 SINOVAC_FIRST goods
    $total_e_pop_svac_a2_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_a2 :0;  //A2 SINOVAC_FIRST goods
    $total_e_pop_svac_a3_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_a3 :0;  //A3 SINOVAC_FIRST goods
    $total_e_pop_svac_a4_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_a4 :0;  //A4 SINOVAC_FIRST goods
    $total_e_pop_svac_a5_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_a5 :0;  //A5 SINOVAC_FIRST goods
    $total_e_pop_svac_b1_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_b1 :0;  //B1 SINOVAC_FIRST goods
    $total_e_pop_svac_b2_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_b2 :0;  //B2 SINOVAC_FIRST goods
    $total_e_pop_svac_b3_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_b3 :0;  //B3 SINOVAC_FIRST goods
    $total_e_pop_svac_b4_prov  = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? $global_elipop_b4 :0;  //B4 SINOVAC_FIRST goods
    $total_e_pop_svac_prov = $total_e_pop_svac_a1_prov + $total_e_pop_svac_a2_prov + $total_e_pop_svac_a3_prov + $total_e_pop_svac_a4_prov + $total_e_pop_svac_a5_prov +
                             $total_e_pop_svac_b1_prov + $total_e_pop_svac_b2_prov + $total_e_pop_svac_b3_prov + $total_e_pop_svac_b4_prov ; //TOTAL ELI POP SINOVAC_FIRST goods

    //ELIGIBLE_POP_ASTRAZENECA
    $total_e_pop_astra_a1_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_a1 :0; //A1 ASTRA_FIRST goods
    $total_e_pop_astra_a2_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_a2 :0; //A2 ASTRA_FIRST goods
    $total_e_pop_astra_a3_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_a3 :0; //A3 ASTRA_FIRST goods
    $total_e_pop_astra_a4_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_a4 :0; //A4 ASTRA_FIRST goods
    $total_e_pop_astra_a5_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_a5 :0; //A5 ASTRA_FIRST goods
    $total_e_pop_astra_b1_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_b1 :0; //B1 ASTRA_FIRST goods
    $total_e_pop_astra_b2_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_b2 :0; //B2 ASTRA_FIRST goods
    $total_e_pop_astra_b3_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_b3 :0; //B3 ASTRA_FIRST goods
    $total_e_pop_astra_b4_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  $global_elipop_b4 :0; //B4 ASTRA_FIRST goods
    $total_e_pop_astra_prov = $total_e_pop_astra_a1_prov + $total_e_pop_astra_a2_prov + $total_e_pop_astra_a3_prov + $total_e_pop_astra_a4_prov + $total_e_pop_astra_a5_prov +
                              $total_e_pop_astra_b1_prov + $total_e_pop_astra_b2_prov + $total_e_pop_astra_b3_prov + $total_e_pop_astra_b4_prov; //TOTAL E POP ASTRA_FIRST goods

    //ELIGIBLE_POP_PFIZER
    $total_e_pop_pfizer_a1_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_a1 :0; //A1 PFIZER_FIRST goods
    $total_e_pop_pfizer_a2_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_a2 :0; //A2 PFIZER_FIRST goods
    $total_e_pop_pfizer_a3_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_a3 :0; //A3 PFIZER_FIRST goods
    $total_e_pop_pfizer_a4_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_a4 :0; //A4 PFIZER_FIRST goods
    $total_e_pop_pfizer_a5_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_a5 :0; //A5 PFIZER_FIRST goods
    $total_e_pop_pfizer_b1_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_b1 :0; //B1 PFIZER_FIRST goods
    $total_e_pop_pfizer_b2_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_b2 :0; //B2 PFIZER_FIRST goods
    $total_e_pop_pfizer_b3_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_b3 :0; //B3 PFIZER_FIRST goods
    $total_e_pop_pfizer_b4_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  $global_elipop_b4 :0; //B4 PFIZER_FIRST goods
    $total_e_pop_pfizer_prov = $total_e_pop_pfizer_a1_prov + $total_e_pop_pfizer_a2_prov + $total_e_pop_pfizer_a3_prov + $total_e_pop_pfizer_a4_prov + $total_e_pop_pfizer_a5_prov +
                                 $total_e_pop_pfizer_b1_prov + $total_e_pop_pfizer_b2_prov + $total_e_pop_pfizer_b3_prov + $total_e_pop_pfizer_b4_prov; //TOTAL E POP PFIZER_FIRST goods
    //ELIGIBLE_POP_SPUTNIKV
    $total_e_pop_sputnikv_a1_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_a1 :0; //A1 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_a2_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_a2 :0; //A2 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_a3_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_a3 :0; //A3 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_a4_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_a4 :0; //A4 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_a5_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_a5 :0; //A5 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_b1_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_b1 :0; //B1 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_b2_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_b2 :0; //B2 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_b3_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_b3 :0; //B3 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_b4_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  $global_elipop_b4 :0; //B4 SPUTNIKV_FIRST goods
    $total_e_pop_sputnikv_prov = $total_e_pop_sputnikv_a1_prov + $total_e_pop_sputnikv_a2_prov + $total_e_pop_sputnikv_a3_prov + $total_e_pop_sputnikv_a4_prov + $total_e_pop_sputnikv_a5_prov +
                                 $total_e_pop_sputnikv_b1_prov + $total_e_pop_sputnikv_b2_prov + $total_e_pop_sputnikv_b3_prov + $total_e_pop_sputnikv_b4_prov; //TOTAL E POP SPUTNIKV_FIRST goods

    //ELIGIBLE_POP_MODERNA
    $total_e_pop_moderna_a1_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a1 :0; //A1 MODERNA_FIRST goods
    $total_e_pop_moderna_a2_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a2 :0; //A2 MODERNA_FIRST goods
    $total_e_pop_moderna_a3_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a3 :0; //A3 MODERNA_FIRST goods
    $total_e_pop_moderna_a4_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a4 :0; //A4 MODERNA_FIRST goods
    $total_e_pop_moderna_a5_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a5 :0; //A5 MODERNA_FIRST goods
    $total_e_pop_moderna_b1_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b1 :0; //B1 MODERNA_FIRST goods
    $total_e_pop_moderna_b2_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b2 :0; //B2 MODERNA_FIRST goods
    $total_e_pop_moderna_b3_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b3 :0; //B3 MODERNA_FIRST goods
    $total_e_pop_moderna_b4_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b4 :0; //B4 MODERNA_FIRST goods
    $total_e_pop_moderna_prov = $total_e_pop_moderna_a1_prov + $total_e_pop_moderna_a2_prov + $total_e_pop_moderna_a3_prov + $total_e_pop_moderna_a4_prov + $total_e_pop_moderna_a5_prov +
                                $total_e_pop_moderna_b1_prov + $total_e_pop_moderna_b2_prov + $total_e_pop_moderna_b3_prov + $total_e_pop_moderna_b4_prov; //TOTAL E POP MODERNA_FIRST goods

    //ELIGIBLE_POP_JOHNSON
    $total_e_pop_johnson_a1_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a1 :0; //A1 JOHNSON_FIRST goods
    $total_e_pop_johnson_a2_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a2 :0; //A2 JOHNSON_FIRST goods
    $total_e_pop_johnson_a3_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a3 :0; //A3 JOHNSON_FIRST goods
    $total_e_pop_johnson_a4_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a4 :0; //A4 JOHNSON_FIRST goods
    $total_e_pop_johnson_a5_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_a5 :0; //A5 JOHNSON_FIRST goods
    $total_e_pop_johnson_b1_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b1 :0; //B1 JOHNSON_FIRST goods
    $total_e_pop_johnson_b2_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b2 :0; //B2 JOHNSON_FIRST goods
    $total_e_pop_johnson_b3_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b3 :0; //B3 JOHNSON_FIRST goods
    $total_e_pop_johnson_b4_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  $global_elipop_b4 :0; //B4 JOHNSON_FIRST goods
    $total_e_pop_johnson_prov = $total_e_pop_johnson_a1_prov + $total_e_pop_johnson_a2_prov + $total_e_pop_johnson_a3_prov + $total_e_pop_johnson_a4_prov + $total_e_pop_johnson_a5_prov +
                                $total_e_pop_johnson_b1_prov + $total_e_pop_johnson_b2_prov + $total_e_pop_johnson_b3_prov + $total_e_pop_johnson_b4_prov; //TOTAL E POP JOHNSON_FIRST goods

    //VACCINE_ALLOCATED
    $total_vallocated_svac_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(sinovac_allocated_first,0)) as sinovac_allocated_first"))->where("province_id",$province_id)->first()->sinovac_allocated_first) :0; //VACCINE ALLOCATED (FD) SINOVAC_FIRST goods
    $total_vallocated_svac_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(sinovac_allocated_second,0)) as sinovac_allocated_second"))->where("province_id",$province_id)->first()->sinovac_allocated_second) :0; //VACCINE ALLOCATED (SD) SINOVAC_FIRST goods
    $total_vallocated_astra_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(astrazeneca_allocated_first,0)) as astrazeneca_allocated_first"))->where("province_id",$province_id)->first()->astrazeneca_allocated_first) :0; //VACCINE_ALLOCATED (FD) ASTRA_FIRST goods
    $total_vallocated_astra_scnd_prov= $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(astrazeneca_allocated_second,0)) as astrazeneca_allocated_second"))->where("province_id",$province_id)->first()->astrazeneca_allocated_second) :0; //VACCINE ALLOCATED (SD) ASTRA_FIRST goods
    $total_vallocated_pfizer_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(pfizer_allocated_first,0)) as pfizer_allocated_first"))->where("province_id",$province_id)->first()->pfizer_allocated_first) :0; //VACCINE_ALLOCATED (FD) PFIZER_FIRST goods
    $total_vallocated_pfizer_scnd_prov= $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(pfizer_allocated_second,0)) as pfizer_allocated_second"))->where("province_id",$province_id)->first()->pfizer_allocated_second) :0; //VACCINE ALLOCATED (SD) PFIZER_FIRST goods
    $total_vallocated_sputnikv_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(sputnikv_allocated_first,0)) as sputnikv_allocated_first"))->where("province_id",$province_id)->first()->sputnikv_allocated_first) :0; //VACCINE ALLOCATED (FD) SPUTNIKV_FIRST goods
    $total_vallocated_sputnikv_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(sputnikv_allocated_second,0)) as sputnikv_allocated_second"))->where("province_id",$province_id)->first()->sputnikv_allocated_second) :0; //VACCINE ALLOCATED (SD) SPUTNIKV_FIRST goods
    $total_vallocated_moderna_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(moderna_allocated_first,0)) as moderna_allocated_first"))->where("province_id",$province_id)->first()->moderna_allocated_first) :0; //VACCINE_ALLOCATED (FD) MODERNA_FIRST goods
    $total_vallocated_moderna_scnd_prov= $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(moderna_allocated_second,0)) as moderna_allocated_second"))->where("province_id",$province_id)->first()->moderna_allocated_second) :0; //VACCINE ALLOCATED (SD) MODERNA_FIRST goods
    $total_vallocated_johnson_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(johnson_allocated_first,0)) as johnson_allocated_first"))->where("province_id",$province_id)->first()->johnson_allocated_first) :0; //VACCINE_ALLOCATED (FD) JOHNSON_FIRST goods
    $total_vallocated_johnson_scnd_prov= $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\Muncity::select(\DB::raw("SUM(COALESCE(johnson_allocated_second,0)) as johnson_allocated_second"))->where("province_id",$province_id)->first()->johnson_allocated_second) :0; //VACCINE ALLOCATED (SD) JOHNSON_FIRST goods

    //SINOVAC FIRST
    $total_svac_a1_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero(\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first) :0;  //VACCINATED (A1) SINOVAC_FIRST
    $total_svac_a2_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A2) SINOVAC_FIRST
    $total_svac_a3_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A3) SINOVAC_FIRST
    $total_svac_a4_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A4) SINOVAC_FIRST
    $total_svac_a5_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A5) SINOVAC_FIRST
    $total_svac_b1_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B1) SINOVAC_FIRST
    $total_svac_b2_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B2) SINOVAC_FIRST
    $total_svac_b3_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B3) SINOVAC_FIRST
    $total_svac_b4_frst_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B4) SINOVAC_FIRST

    //SINOVAC SECOND
    $total_svac_a1_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A1) SINOVAC_SECOND
    $total_svac_a2_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A2) SINOVAC_SECOND
    $total_svac_a3_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A3) SINOVAC_SECOND
    $total_svac_a4_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A4) SINOVAC_SECOND
    $total_svac_a5_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A5) SINOVAC_SECOND
    $total_svac_b1_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B1) SINOVAC_SECOND
    $total_svac_b2_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B2) SINOVAC_SECOND
    $total_svac_b3_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B3) SINOVAC_SECOND
    $total_svac_b4_scnd_prov = $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B4) SINOVAC_SECOND

    //ASTRA FIRST
    $total_astra_a1_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A1) ASTRAZENECA_FIRST
    $total_astra_a2_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A2) ASTRAZENECA_FIRST
    $total_astra_a3_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A3) ASTRAZENECA_FIRST
    $total_astra_a4_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A4) ASTRAZENECA_FIRST
    $total_astra_a5_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A5) ASTRAZENECA_FIRST
    $total_astra_b1_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B1) ASTRAZENECA_FIRST
    $total_astra_b2_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B2) ASTRAZENECA_FIRST
    $total_astra_b3_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B3) ASTRAZENECA_FIRST
    $total_astra_b4_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B4) ASTRAZENECA_FIRST

    //ASTRA SECOND
    $total_astra_a1_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A1) ASTRAZENECA_SECOND
    $total_astra_a2_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A2) ASTRAZENECA_SECOND
    $total_astra_a3_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A3) ASTRAZENECA_SECOND
    $total_astra_a4_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A4) ASTRAZENECA_SECOND
    $total_astra_a5_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A5) ASTRAZENECA_SECOND
    $total_astra_b1_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B1) ASTRAZENECA_SECOND
    $total_astra_b2_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B2) ASTRAZENECA_SECOND
    $total_astra_b3_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B3) ASTRAZENECA_SECOND
    $total_astra_b4_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B4) ASTRAZENECA_SECOND

    //PFIZER FIRST
    $total_pfizer_a1_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A1) PFIZER_FIRST
    $total_pfizer_a2_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A2) PFIZER_FIRST
    $total_pfizer_a3_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A3) PFIZER_FIRST
    $total_pfizer_a4_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A4) PFIZER_FIRST
    $total_pfizer_a5_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A5) PFIZER_FIRST
    $total_pfizer_b1_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B1) PFIZER_FIRST
    $total_pfizer_b2_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B2) PFIZER_FIRST
    $total_pfizer_b3_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B3) PFIZER_FIRST
    $total_pfizer_b4_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B4) PFIZER_FIRST

    //PFIZER SECOND
    $total_pfizer_a1_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A1) PFIZER_SECOND
    $total_pfizer_a2_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A2) PFIZER_SECOND
    $total_pfizer_a3_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A3) PFIZER_SECOND
    $total_pfizer_a4_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A4) PFIZER_SECOND
    $total_pfizer_a5_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A5) PFIZER_SECOND
    $total_pfizer_b1_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B1) PFIZER_SECOND
    $total_pfizer_b2_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B2) PFIZER_SECOND
    $total_pfizer_b3_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B3) PFIZER_SECOND
    $total_pfizer_b4_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B4) PFIZER_SECOND

    //SPUTNIKV FIRST
    $total_sputnikv_a1_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A1) SPUTNIKV_FIRST
    $total_sputnikv_a2_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A2) SPUTNIKV_FIRST
    $total_sputnikv_a3_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A3) SPUTNIKV_FIRST
    $total_sputnikv_a4_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A4) SPUTNIKV_FIRST
    $total_sputnikv_a5_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A5) SPUTNIKV_FIRST
    $total_sputnikv_b1_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B1) SPUTNIKV_FIRST
    $total_sputnikv_b2_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B2) SPUTNIKV_FIRST
    $total_sputnikv_b3_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B3) SPUTNIKV_FIRST
    $total_sputnikv_b4_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B4) SPUTNIKV_FIRST

    //SPUTNIKV SECOND
    $total_sputnikv_a1_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A1) SPUTNIKV_SECOND
    $total_sputnikv_a2_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A2) SPUTNIKV_SECOND
    $total_sputnikv_a3_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A3) SPUTNIKV_SECOND
    $total_sputnikv_a4_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A4) SPUTNIKV_SECOND
    $total_sputnikv_a5_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A5) SPUTNIKV_SECOND
    $total_sputnikv_b1_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B1) SPUTNIKV_SECOND
    $total_sputnikv_b2_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B2) SPUTNIKV_SECOND
    $total_sputnikv_b3_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B3) SPUTNIKV_SECOND
    $total_sputnikv_b4_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B4) SPUTNIKV_SECOND

    //MODERNA FIRST
    $total_moderna_a1_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A1) MODERNA_FIRST
    $total_moderna_a2_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A2) MODERNA_FIRST
    $total_moderna_a3_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A3) MODERNA_FIRST
    $total_moderna_a4_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A4) MODERNA_FIRST
    $total_moderna_a5_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A5) MODERNA_FIRST
    $total_moderna_b1_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B1) MODERNA_FIRST
    $total_moderna_b2_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B2) MODERNA_FIRST
    $total_moderna_b3_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B3) MODERNA_FIRST
    $total_moderna_b4_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B4) MODERNA_FIRST

    //MODERNA SECOND
    $total_moderna_a1_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A1) MODERNA_SECOND
    $total_moderna_a2_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A2) MODERNA_SECOND
    $total_moderna_a3_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A3) MODERNA_SECOND
    $total_moderna_a4_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A4) MODERNA_SECOND
    $total_moderna_a5_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A5) MODERNA_SECOND
    $total_moderna_b1_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B1) MODERNA_SECOND
    $total_moderna_b2_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B2) MODERNA_SECOND
    $total_moderna_b3_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B3) MODERNA_SECOND
    $total_moderna_b4_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B4) MODERNA_SECOND

    //JOHNSON FIRST
    $total_johnson_a1_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A1) JOHNSON_FIRST
    $total_johnson_a2_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A2) JOHNSON_FIRST
    $total_johnson_a3_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A3) JOHNSON_FIRST
    $total_johnson_a4_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A4) JOHNSON_FIRST
    $total_johnson_a5_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (A5) JOHNSON_FIRST
    $total_johnson_b1_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B1) JOHNSON_FIRST
    $total_johnson_b2_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B2) JOHNSON_FIRST
    $total_johnson_b3_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B3) JOHNSON_FIRST
    $total_johnson_b4_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first) :0; //VACCINATED (B4) JOHNSON_FIRST

    //JOHNSON SECOND
    $total_johnson_a1_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A1) JOHNSON_SECOND
    $total_johnson_a2_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A2) JOHNSON_SECOND
    $total_johnson_a3_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A3) JOHNSON_SECOND
    $total_johnson_a4_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A4) JOHNSON_SECOND
    $total_johnson_a5_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (A5) JOHNSON_SECOND
    $total_johnson_b1_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B1) JOHNSON_SECOND
    $total_johnson_b2_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B2) JOHNSON_SECOND
    $total_johnson_b3_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B3) JOHNSON_SECOND
    $total_johnson_b4_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second) :0; //VACCINATED (B4) JOHNSON_SECOND

    $total_mild_svac_frst_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->mild_first) :0; //MILD SINOVAC_FIRST goods
    $total_mild_astra_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->mild_first) :0; //MILD ASTRA_FIRST goods
    $total_mild_pfizer_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->mild_first) :0; //MILD PFIZER_FIRST goods
    $total_mild_sputnikv_frst_prov =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->mild_first) :0; //MILD SPUTNIKV_FIRST goods
    $total_mild_moderna_frst_prov =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->mild_first) :0; //MILD MODERNA_FIRST goods
    $total_mild_johnson_frst_prov =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->mild_first) :0; //MILD JOHNSON_FIRST goods

    $total_mild_svac_scnd_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->mild_second) :0; //MILD SINOVAC_SECOND goods
    $total_mild_astra_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->mild_second) :0; //MILD ASTRA_SECOND goods
    $total_mild_pfizer_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->mild_second) :0; //MILD PFIZER _SECOND goods
    $total_mild_sputnikv_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->mild_second) :0; //MILD SPUTNIKV_SECOND goods
    $total_mild_moderna_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->mild_second) :0; //MILD MODERNA_SECOND goods
    $total_mild_johnson_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->mild_second) :0; //MILD JOHNSON_SECOND goods

    $total_srs_svac_frst_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->serious_first) :0; //SERIOUS SINOVAC_FIRST goods
    $total_srs_astra_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->serious_first) :0; //SERIOUS ASTRA_FIRST goods
    $total_srs_pfizer_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->serious_first) :0; //SERIOUS PFIZER_FIRST goods
    $total_srs_sputnikv_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->serious_first) :0; //SERIOUS SPUTNIKV_FIRST goods
    $total_srs_moderna_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->serious_first) :0; //SERIOUS MODERNA_FIRST goods
    $total_srs_johnson_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->serious_first) :0; //SERIOUS JOHNSON_FIRST goods

    $total_srs_svac_scnd_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->serious_second) :0; //SERIOUS  SINOVAC_SECOND goods
    $total_srs_astra_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->serious_second) :0; //SERIOUS ASTRA_SECOND goods
    $total_srs_pfizer_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->serious_second) :0; //SERIOUS PFIZER_SECOND goods
    $total_srs_sputnikv_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sputnikv")->whereNull("facility_id")->first()->serious_second) :0; //SERIOUS SPUTNIKV_SECOND goods
    $total_srs_moderna_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->serious_second) :0; //SERIOUS MODERNA_SECOND goods
    $total_srs_johnson_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->serious_second) :0; //SERIOUS JOHNSON_SECOND goods

    $total_dfrd_svac_frst_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->deferred_first) :0; //DEFERRED SINOVAC_FIRST goods
    $total_dfrd_astra_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->deferred_first) :0; //DEFERRED ASTRA_FIRST goods
    $total_dfrd_pfizer_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->deferred_first) :0; //DEFERRED PFIZER_FIRST goods
    $total_dfrd_sputnikv_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->deferred_first) :0; //DEFERRED SPUTNIKV_FIRST goods
    $total_dfrd_moderna_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->deferred_first) :0; //DEFERRED MODERNA_FIRST goods
    $total_dfrd_johnson_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->deferred_first) :0; //DEFERRED JOHNSON_FIRST goods

    $total_dfrd_svac_scnd_prov =   $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->deferred_second) :0; //DEFERRED  SINOVAC_SECOND goods
    $total_dfrd_astra_scnd_prov =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->deferred_second) :0; //DEFERRED ASTRA_SECOND goods
    $total_dfrd_pfizer_scnd_prov =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->deferred_second) :0; //DEFERRED PFIZER_SECOND goods
    $total_dfrd_sputnikv_scnd_prov =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->deferred_second) :0; //DEFERRED SPUTNIKV_SECOND goods
    $total_dfrd_moderna_scnd_prov =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->deferred_second) :0; //DEFERRED MODERNA_SECOND goods
    $total_dfrd_johnson_scnd_prov =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->deferred_second) :0; //DEFERRED JOHNSON_SECOND goods

    $total_rfsd_svac_frst_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->refused_first) :0; //REFUSED SINOVAC_FIRST goods
    $total_rfsd_astra_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->refused_first) :0; //REFUSED ASTRA_FIRST goods
    $total_rfsd_pfizer_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->refused_first) :0; //REFUSED PFIZER_FIRST goods
    $total_rfsd_sputnikv_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->refused_first) :0; //REFUSED SPUTNIKV_FIRST goods
    $total_rfsd_moderna_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->refused_first) :0; //REFUSED MODERNA_FIRST goods
    $total_rfsd_johnson_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->refused_first) :0; //REFUSED JOHNSON_FIRST goods

    $total_rfsd_svac_scnd_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->refused_second) :0; //REFUSED  SINOVAC_SECOND goods
    $total_rfsd_astra_scnd_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->refused_second) :0; //REFUSED ASTRA_SECOND goods
    $total_rfsd_pfizer_scnd_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->refused_second) :0; //REFUSED PFIZER_SECOND goods
    $total_rfsd_sputnikv_scnd_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->refused_second) :0; //REFUSED SPUTNIKV_SECOND goods
    $total_rfsd_moderna_scnd_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->refused_second) :0; //REFUSED MODERNA_SECOND goods
    $total_rfsd_johnson_scnd_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->refused_second) :0; //REFUSED JOHNSON_SECOND goods

    $total_wstge_svac_frst_prov =  $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->wastage_first) :0; //WASTAGE SINOVAC_FIRST goods
    $total_wstge_astra_frst_prov = $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->wastage_first) :0; //WASTAGE ASTRA_FIRST goods
    $total_wstge_pfizer_frst_prov = $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->wastage_first) :0; //WASTAGE PFIZER_FIRST goods
    $total_wstge_sputnikv_frst_prov = $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->wastage_first) :0; //WASTAGE SPUTNIKV_FIRST goods
    $total_wstge_moderna_frst_prov = $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->wastage_first) :0; //WASTAGE MODERNA_FIRST goods
    $total_wstge_johnson_frst_prov = $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ?  convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->wastage_first) :0; //WASTAGE JOHNSON_FIRST goods

    $total_wstge_svac_scnd_prov =   $typeof_vaccine_filter == "Sinovac" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->wastage_second) :0; //WASTAGE SINOVAC_SECOND goods
    $total_wstge_astra_scnd_prov =  $typeof_vaccine_filter == "Astrazeneca" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->wastage_second) :0; //WASTAGE ASTRA_SECOND goods
    $total_wstge_pfizer_scnd_prov =  $typeof_vaccine_filter == "Pfizer" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->wastage_second) :0; //WASTAGE PFIZER_SECOND goods
    $total_wstge_sputnikv_scnd_prov =  $typeof_vaccine_filter == "SputnikV" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->wastage_second) :0; //WASTAGE SPUTNIKV_SECOND goods
    $total_wstge_moderna_scnd_prov =  $typeof_vaccine_filter == "Moderna" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->wastage_second) :0; //WASTAGE MODERNA_SECOND goods
    $total_wstge_johnson_scnd_prov =  $typeof_vaccine_filter == "Johnson" || empty($typeof_vaccine_filter) ? convertToZero (\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$province_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->wastage_second) :0; //WASTAGE JOHNSON_SECOND goods

    $total_vallocated_frst_svac = $total_vallocated_svac_frst_prov + $total_vallocated_svac_scnd_prov; //TOTAL VACCINE ALLOCATED SINOVAC_FIRST goods
    $total_vallocated_frst_astra = $total_vallocated_astra_frst_prov + $total_vallocated_astra_scnd_prov; //TOTAL VACCINE ALLOCATED ASTRA_FIRST goods
    $total_vallocated_pfizer = $total_vallocated_pfizer_frst_prov + $total_vallocated_pfizer_scnd_prov; //TOTAL VACCINE ALLOCATED PFIZER_FIRST goods
    $total_vallocated_frst_sputnikv = $total_vallocated_sputnikv_frst_prov + $total_vallocated_sputnikv_scnd_prov; //TOTAL VACCINE ALLOCATED SPUTNIK_FIRST goods
    $total_vallocated_frst_moderna = $total_vallocated_moderna_frst_prov + $total_vallocated_moderna_scnd_prov; //TOTAL VACCINE ALLOCATED MODERNA_FIRST goods
    $total_vallocated_frst_johnson = $total_vallocated_johnson_frst_prov + $total_vallocated_johnson_scnd_prov; //TOTAL VACCINE ALLOCATED JOHNSON_FIRST goods

    $total_vallocated_frst_prov = $total_vallocated_svac_frst_prov + $total_vallocated_astra_frst_prov + $total_vallocated_pfizer_frst_prov + $total_vallocated_sputnikv_frst_prov + $total_vallocated_moderna_frst_prov + $total_vallocated_johnson_frst_prov; //TOTAL VACCINE ALLOCATED FIRST goods
    $total_vallocated_scnd_prov = $total_vallocated_svac_scnd_prov + $total_vallocated_astra_scnd_prov + $total_vallocated_pfizer_scnd_prov + $total_vallocated_sputnikv_scnd_prov + $total_vallocated_moderna_scnd_prov + $total_vallocated_johnson_scnd_prov; //TOTAL VACCINE ALLOCATED SECOND goods
    $total_vallocated = $total_vallocated_frst_prov + $total_vallocated_scnd_prov;

    $total_vcted_grand_a1_first = $total_svac_a1_frst_prov + $total_astra_a1_frst_prov + $total_sputnikv_a1_frst_prov + $total_pfizer_a1_frst_prov; //TOTAL VACCINATED GRAND A1 FIRST DOSE
    $total_vcted_grand_a2_first = $total_svac_a2_frst_prov + $total_astra_a2_frst_prov + $total_sputnikv_a2_frst_prov + $total_pfizer_a2_frst_prov; //TOTAL VACCINATED GRAND A2 FIRST DOSE
    $total_vcted_grand_a3_first = $total_svac_a3_frst_prov + $total_astra_a3_frst_prov + $total_sputnikv_a3_frst_prov + $total_pfizer_a3_frst_prov; //TOTAL VACCINATED GRAND A3 FIRST DOSE
    $total_vcted_grand_a4_first = $total_svac_a4_frst_prov + $total_astra_a4_frst_prov + $total_sputnikv_a4_frst_prov + $total_pfizer_a4_frst_prov; //TOTAL VACCINATED GRAND A4 FIRST DOSE
    $total_vcted_grand_a5_first = $total_svac_a5_frst_prov + $total_astra_a5_frst_prov + $total_sputnikv_a5_frst_prov + $total_pfizer_a5_frst_prov; //TOTAL VACCINATED GRAND A5 FIRST DOSE
    $total_vcted_grand_b1_first = $total_svac_b1_frst_prov + $total_astra_b1_frst_prov + $total_sputnikv_b1_frst_prov + $total_pfizer_b1_frst_prov; //TOTAL VACCINATED GRAND B1 FIRST DOSE
    $total_vcted_grand_b2_first = $total_svac_b2_frst_prov + $total_astra_b2_frst_prov + $total_sputnikv_b2_frst_prov + $total_pfizer_b2_frst_prov; //TOTAL VACCINATED GRAND B2 FIRST DOSE
    $total_vcted_grand_b3_first = $total_svac_b3_frst_prov + $total_astra_b3_frst_prov + $total_sputnikv_b3_frst_prov + $total_pfizer_b3_frst_prov; //TOTAL VACCINATED GRAND B3 FIRST DOSE
    $total_vcted_grand_b4_first = $total_svac_b4_frst_prov + $total_astra_b4_frst_prov + $total_sputnikv_b4_frst_prov + $total_pfizer_b4_frst_prov; //TOTAL VACCINATED GRAND B4 FIRST DOSE

    $total_vcted_grand_a1_second = $total_svac_a1_scnd_prov + $total_astra_a1_scnd_prov + $total_sputnikv_a1_scnd_prov + $total_pfizer_a1_scnd_prov; //TOTAL VACCINATED GRAND A1 SECOND DOSE
    $total_vcted_grand_a2_second = $total_svac_a2_scnd_prov + $total_astra_a2_scnd_prov + $total_sputnikv_a2_scnd_prov + $total_pfizer_a2_scnd_prov; //TOTAL VACCINATED GRAND A2 SECOND DOSE
    $total_vcted_grand_a3_second = $total_svac_a3_scnd_prov + $total_astra_a3_scnd_prov + $total_sputnikv_a3_scnd_prov + $total_pfizer_a3_scnd_prov; //TOTAL VACCINATED GRAND A3 SECOND DOSE
    $total_vcted_grand_a4_second = $total_svac_a4_scnd_prov + $total_astra_a4_scnd_prov + $total_sputnikv_a4_scnd_prov + $total_pfizer_a4_scnd_prov; //TOTAL VACCINATED GRAND A4 SECOND DOSE
    $total_vcted_grand_a5_second = $total_svac_a5_scnd_prov + $total_astra_a5_scnd_prov + $total_sputnikv_a5_scnd_prov + $total_pfizer_a5_scnd_prov; //TOTAL VACCINATED GRAND A5 SECOND DOSE
    $total_vcted_grand_b1_second = $total_svac_b1_scnd_prov + $total_astra_b1_scnd_prov + $total_sputnikv_b1_scnd_prov + $total_pfizer_b1_scnd_prov; //TOTAL VACCINATED GRAND B1 SECOND DOSE
    $total_vcted_grand_b2_second = $total_svac_b2_scnd_prov + $total_astra_b2_scnd_prov + $total_sputnikv_b2_scnd_prov + $total_pfizer_b2_scnd_prov; //TOTAL VACCINATED GRAND B2 SECOND DOSE
    $total_vcted_grand_b3_second = $total_svac_b3_scnd_prov + $total_astra_b3_scnd_prov + $total_sputnikv_b3_scnd_prov + $total_pfizer_b3_scnd_prov; //TOTAL VACCINATED GRAND B3 SECOND DOSE
    $total_vcted_grand_b4_second = $total_svac_b4_scnd_prov + $total_astra_b4_scnd_prov + $total_sputnikv_b4_scnd_prov + $total_pfizer_b4_scnd_prov; //TOTAL VACCINATED GRAND B4 SECOND DOSE


    $total_vcted_svac_frst = $total_svac_a1_frst_prov + $total_svac_a2_frst_prov + $total_svac_a3_frst_prov + $total_svac_a4_frst_prov + $total_svac_a5_frst_prov +
                             $total_svac_b1_frst_prov + $total_svac_b2_frst_prov + $total_svac_b3_frst_prov + $total_svac_b4_frst_prov; //TOTAL VACCINATED SINOVAC_FIRST
    $total_vcted_svac_second = $total_svac_a1_scnd_prov + $total_svac_a2_scnd_prov +$total_svac_a3_scnd_prov +$total_svac_a4_scnd_prov + $total_svac_a5_scnd_prov +
                               $total_svac_b1_scnd_prov + $total_svac_b2_scnd_prov +$total_svac_b3_scnd_prov +$total_svac_b4_scnd_prov; //TOTAL VACCINATED SINOVAC_SECOND
    $total_vcted_astra_frst = $total_astra_a1_frst_prov + $total_astra_a2_frst_prov + $total_astra_a3_frst_prov + $total_astra_a4_frst_prov + $total_astra_a5_frst_prov +
                              $total_astra_b1_frst_prov + $total_astra_b2_frst_prov + $total_astra_b3_frst_prov + $total_astra_b4_frst_prov; //TOTAL VACCINATED ASTRA_FIRST
    $total_vcted_astra_second = $total_astra_a1_scnd_prov + $total_astra_a2_scnd_prov +$total_astra_a3_scnd_prov +$total_astra_a4_scnd_prov + $total_astra_a5_scnd_prov +
                                $total_astra_b1_scnd_prov + $total_astra_b2_scnd_prov +$total_astra_b3_scnd_prov +$total_astra_b4_scnd_prov; //TOTAL VACCINATED ASTRA_SECOND

    $total_vcted_pfizer_frst = $total_pfizer_a1_frst_prov + $total_pfizer_a2_frst_prov + $total_pfizer_a3_frst_prov + $total_pfizer_a4_frst_prov + $total_pfizer_a5_frst_prov +
                               $total_pfizer_b1_frst_prov + $total_pfizer_b2_frst_prov + $total_pfizer_b3_frst_prov + $total_pfizer_b4_frst_prov ; //TOTAL VACCINATED PFIZER_FIRST
    $total_vcted_pfizer_second = $total_pfizer_a1_scnd_prov + $total_pfizer_a2_scnd_prov + $total_pfizer_a3_scnd_prov +$total_pfizer_a4_scnd_prov + $total_pfizer_a5_scnd_prov +
                                 $total_pfizer_b1_scnd_prov + $total_pfizer_b2_scnd_prov + $total_pfizer_b3_scnd_prov +$total_pfizer_b4_scnd_prov; //TOTAL VACCINATED PFIZER_SECOND

    $total_vcted_sputnikv_frst = $total_sputnikv_a1_frst_prov + $total_sputnikv_a2_frst_prov + $total_sputnikv_a3_frst_prov + $total_sputnikv_a4_frst_prov + $total_sputnikv_a5_frst_prov +
                                 $total_sputnikv_b1_frst_prov + $total_sputnikv_b2_frst_prov + $total_sputnikv_b3_frst_prov + $total_sputnikv_b4_frst_prov; //TOTAL VACCINATED SPUTNIKV_FIRST
    $total_vcted_sputnikv_second = $total_sputnikv_a1_scnd_prov + $total_sputnikv_a2_scnd_prov +$total_sputnikv_a3_scnd_prov + $total_sputnikv_a4_scnd_prov + $total_sputnikv_a5_scnd_prov +
                                   $total_sputnikv_b1_scnd_prov + $total_sputnikv_b2_scnd_prov +$total_sputnikv_b3_scnd_prov + $total_sputnikv_b4_scnd_prov; //TOTAL VACCINATED SPUTNIKV_SECOND

    $total_vcted_moderna_frst = $total_moderna_a1_frst_prov + $total_moderna_a2_frst_prov + $total_moderna_a3_frst_prov + $total_moderna_a4_frst_prov + $total_moderna_a5_frst_prov +
                                $total_moderna_b1_frst_prov + $total_moderna_b2_frst_prov + $total_moderna_b3_frst_prov + $total_moderna_b4_frst_prov; //TOTAL VACCINATED MODERNA_FIRST
    $total_vcted_moderna_second = $total_moderna_a1_scnd_prov + $total_moderna_a2_scnd_prov +$total_moderna_a3_scnd_prov + $total_moderna_a4_scnd_prov + $total_moderna_a5_scnd_prov +
                                  $total_moderna_b1_scnd_prov + $total_moderna_b2_scnd_prov +$total_moderna_b3_scnd_prov + $total_moderna_b4_scnd_prov; //TOTAL VACCINATED MODERNA_SECOND

    $total_vcted_johnson_frst = $total_johnson_a1_frst_prov + $total_johnson_a2_frst_prov + $total_johnson_a3_frst_prov + $total_johnson_a4_frst_prov + $total_johnson_a5_frst_prov +
                                $total_johnson_b1_frst_prov + $total_johnson_b2_frst_prov + $total_johnson_b3_frst_prov + $total_johnson_b4_frst_prov; //TOTAL VACCINATED JOHNSON_FIRST
    $total_vcted_johnson_second = $total_johnson_a1_scnd_prov + $total_johnson_a2_scnd_prov +$total_johnson_a3_scnd_prov + $total_johnson_a4_scnd_prov + $total_johnson_a5_scnd_prov +
                                  $total_johnson_b1_scnd_prov + $total_johnson_b2_scnd_prov +$total_johnson_b3_scnd_prov + $total_johnson_b4_scnd_prov; //TOTAL VACCINATED JOHNSON_SECOND

    $total_vcted_overall_frst =  $total_vcted_grand_a1_first + $total_vcted_grand_a2_first +  $total_vcted_grand_a3_first + $total_vcted_grand_a4_first + $total_vcted_grand_a5_first +
                                 $total_vcted_grand_b1_first + $total_vcted_grand_b2_first +  $total_vcted_grand_b3_first + $total_vcted_grand_b4_first; //TOTAL VACCINATED OVERALL FIRST
    $total_vcted_overall_second =  $total_vcted_grand_a1_second + $total_vcted_grand_a2_second +  $total_vcted_grand_a3_second + $total_vcted_grand_a4_second + $total_vcted_grand_a5_second +
                                   $total_vcted_grand_b1_second + $total_vcted_grand_b2_second +  $total_vcted_grand_b3_second + $total_vcted_grand_b4_second ; //TOTAL VACCINATED OVERALL SECOND

    $total_mild_overall_frst = $total_mild_svac_frst_prov + $total_mild_astra_frst_prov + $total_mild_pfizer_frst_prov + $total_mild_sputnikv_frst_prov + $total_mild_moderna_frst_prov + $total_mild_johnson_frst_prov; //TOTAL MILD OVERALL FIRST
    $total_mild_overall_scnd = $total_mild_svac_scnd_prov + $total_mild_astra_scnd_prov + $total_mild_pfizer_scnd_prov + $total_mild_sputnikv_scnd_prov + $total_mild_moderna_scnd_prov + $total_mild_johnson_scnd_prov; //TOTAL MILD OVERALL SECOND

    $total_srs_overall_frst = $total_srs_svac_frst_prov + $total_srs_astra_frst_prov + $total_srs_pfizer_frst_prov + $total_srs_sputnikv_frst_prov + $total_srs_moderna_frst_prov + $total_srs_johnson_frst_prov; //TOTAL SERIOUS OVERALL FIRST
    $total_srs_overall_scnd = $total_srs_svac_scnd_prov + $total_srs_astra_scnd_prov + $total_srs_pfizer_scnd_prov + $total_srs_sputnikv_scnd_prov + $total_srs_moderna_scnd_prov + $total_srs_johnson_scnd_prov; //TOTAL SERIOUS OVERALL SECOND

    $total_dfrd_overall_frst = $total_dfrd_svac_frst_prov + $total_dfrd_astra_frst_prov + $total_dfrd_pfizer_frst_prov + $total_dfrd_sputnikv_frst_prov + $total_dfrd_moderna_frst_prov + $total_dfrd_johnson_frst_prov;  //TOTAL DEFERRED OVERALL FIRST
    $total_dfrd_overall_scnd = $total_dfrd_svac_scnd_prov + $total_dfrd_astra_scnd_prov + $total_dfrd_pfizer_scnd_prov + $total_dfrd_sputnikv_scnd_prov + $total_dfrd_moderna_scnd_prov + $total_dfrd_johnson_scnd_prov;  //TOTAOL DEFERRED OVERALL SECOND

    $total_rfsd_overall_frst = $total_rfsd_svac_frst_prov + $total_rfsd_astra_frst_prov + $total_rfsd_pfizer_frst_prov + $total_rfsd_sputnikv_frst_prov + $total_rfsd_moderna_frst_prov + $total_rfsd_johnson_frst_prov; //TOTAL REFUSED OVERALL FIRST
    $total_rfsd_overall_scnd = $total_rfsd_svac_scnd_prov + $total_rfsd_astra_scnd_prov + $total_rfsd_pfizer_scnd_prov + $total_rfsd_sputnikv_scnd_prov + $total_rfsd_moderna_scnd_prov + $total_rfsd_johnson_scnd_prov; //TOTAL REFUSED OVERALL SECOND

    $total_wstge_overall_frst = $total_wstge_svac_frst_prov + $total_wstge_astra_frst_prov + $total_wstge_pfizer_frst_prov + $total_wstge_sputnikv_frst_prov + $total_wstge_moderna_frst_prov + $total_wstge_johnson_frst_prov; //TOTAL WASTAGE OVERALL FIRST
    $total_wstge_overall_scnd = $total_wstge_svac_scnd_prov + $total_wstge_astra_scnd_prov + $total_wstge_pfizer_scnd_prov + $total_wstge_sputnikv_scnd_prov + $total_wstge_moderna_scnd_prov + $total_wstge_johnson_scnd_prov; //TOTAL WASTAGE OVERALL SECOND

    $total_rfsd_frst_prov = $total_rfsd_svac_frst_prov + $total_rfsd_astra_frst_prov + $total_rfsd_pfizer_frst_prov + $total_rfsd_sputnikv_frst_prov + $total_rfsd_moderna_frst_prov + $total_rfsd_johnson_frst_prov; //TOTAL REFUSED goods
    $total_rfsd_scnd_prov = $total_rfsd_svac_scnd_prov + $total_rfsd_astra_scnd_prov + $total_rfsd_pfizer_scnd_prov + $total_rfsd_sputnikv_scnd_prov + $total_rfsd_moderna_scnd_prov + $total_rfsd_johnson_scnd_prov; //TOTAL REFUSED  2 goods

    $total_p_cvrge_frst_prov = $total_vcted_overall_frst / $total_e_pop_astra_prov * 100; //TOTAL PERCENT_COVERAGE goods
    $total_p_cvrge_scnd_prov = $total_vcted_overall_second / $total_e_pop_astra_prov * 100; //TOTAL PERCENT_COVERAGE  2 goods

    $total_c_rate_frst_prov = $total_vcted_overall_frst / $total_vallocated_frst_prov * 100; //TOTAL CONSUMPTION RATE
    $total_c_rate_scnd_prov =  $total_vcted_overall_second / $total_vallocated_scnd_prov * 100; //TOTAL CONSUMPTION RATE  2 goods

    $total_c_rate_svac_frst_prov = $total_vcted_svac_frst / $total_vallocated_svac_frst_prov * 100; //CONSUMPTION RATE SINOVAC_FIRST goods
    $total_c_rate_astra_frst_prov = $total_vcted_astra_frst / $total_vallocated_astra_frst_prov * 100; //CONSUMPTION RATE ASTRA_FIRST goods
    $total_c_rate_sputnikv_frst_prov = $total_vcted_sputnikv_frst / $total_vallocated_sputnikv_frst_prov * 100; //CONSUMPTION RATE SPUTNIKV_FIRST goods
    $total_c_rate_pfizer_frst_prov = $total_vcted_pfizer_frst / $total_vallocated_pfizer_frst_prov * 100; //CONSUMPTION RATE PFIZER_FIRST goods
    $total_c_rate_moderna_frst_prov = $total_vcted_moderna_frst / $total_vallocated_moderna_frst_prov * 100; //CONSUMPTION RATE MODERNA_FIRST goods
    $total_c_rate_johnson_frst_prov = $total_vcted_johnson_frst / $total_vallocated_johnson_frst_prov * 100; //CONSUMPTION RATE JOHNSON_FIRST goods

    $total_c_rate_astra_scnd_prov = $total_vcted_astra_second / $total_vallocated_astra_scnd_prov * 100; //CONSUMPTION RATE ASTRA_SECOND goods
    $total_c_rate_svac_scnd_prov = $total_vcted_svac_second / $total_vallocated_svac_scnd_prov * 100; //CONSUMPTION RATE SINOVAC_SECOND goods
    $total_c_rate_sputnikv_scnd_prov = $total_vcted_sputnikv_second / $total_vallocated_sputnikv_scnd_prov * 100; //CONSUMPTION RATE SPUTNIKV_SECOND goods
    $total_c_rate_pfizer_scnd_prov  = $total_vcted_pfizer_second / $total_vallocated_pfizer_scnd_prov * 100; //CONSUMPTION RATE PFIZER_SECOND goods
    $total_c_rate_moderna_scnd_prov  = $total_vcted_moderna_second / $total_vallocated_moderna_scnd_prov * 100; //CONSUMPTION RATE PFIZER_SECOND goods
    $total_c_rate_johnson_scnd_prov  = $total_vcted_johnson_second / $total_vallocated_johnson_scnd_prov * 100; //CONSUMPTION RATE PFIZER_SECOND goods

    $total_p_cvrge_svac_frst_prov = $total_vcted_svac_frst / $total_e_pop_svac_prov * 100; //PERCENT COVERAGE SINOVAC_FIRST goods
    $total_p_cvrge_astra_frst_prov = $total_vcted_astra_frst / $total_e_pop_astra_prov * 100; //PERCENT_COVERAGE ASTRA_FIRST goods
    $total_p_cvrge_sputnikv_frst_prov = $total_vcted_sputnikv_frst / $total_e_pop_sputnikv_prov * 100; //PERCENT_COVERAGE SPUTNIKV_FIRST goods
    $total_p_cvrge_pfizer_frst_prov = $total_vcted_pfizer_frst / $total_e_pop_pfizer_prov * 100; //PERCENT_COVERAGE PFIZER_FIRST goods
    $total_p_cvrge_moderna_frst_prov = $total_vcted_moderna_frst / $total_e_pop_moderna_prov * 100; //PERCENT_COVERAGE PFIZER_FIRST goods
    $total_p_cvrge_johnson_frst_prov = $total_vcted_johnson_frst / $total_e_pop_johnson_prov * 100; //PERCENT_COVERAGE PFIZER_FIRST goods

    $total_p_cvrge_svac_scnd_prov =  $total_vcted_svac_second / $total_e_pop_svac_prov * 100; //PERCENT COVERAGE  SINOVAC_SECOND goods
    $total_p_cvrge_astra_scnd_prov =  $total_vcted_astra_second / $total_e_pop_astra_prov * 100; //PERCENT_COVERAGE_ASTRA_SECOND goods
    $total_p_cvrge_sputnikv_scnd_prov =  $total_vcted_sputnikv_second / $total_e_pop_sputnikv_prov * 100; //PERCENT_COVERAGE_ASTRA_SECOND goods
    $total_p_cvrge_pfizer_scnd_prov =  $total_vcted_pfizer_second / $total_e_pop_pfizer_prov * 100; //PERCENT_COVERAGE_PFIZER_SECOND goods
    $total_p_cvrge_moderna_scnd_prov =  $total_vcted_moderna_second / $total_e_pop_moderna_prov * 100; //PERCENT_COVERAGE_PFIZER_SECOND goods
    $total_p_cvrge_johnson_scnd_prov =  $total_vcted_johnson_second / $total_e_pop_johnson_prov * 100; //PERCENT_COVERAGE_PFIZER_SECOND goods

    $total_r_unvcted_frst_svac_prov = $total_e_pop_svac_prov - $total_vcted_svac_frst - $total_rfsd_svac_frst_prov; //REMAINING UNVACCINATED SINOVAC_FIRST goods
    $total_r_unvcted_frst_astra_prov = $total_e_pop_astra_prov - $total_vcted_astra_frst - $total_rfsd_astra_frst_prov; //REMAINUNG UNVACCINATED ASTRA_FIRST goods
    $total_r_unvcted_frst_sputnikv_prov = $total_e_pop_sputnikv_prov - $total_vcted_sputnikv_frst - $total_rfsd_sputnikv_frst_prov; //REMAINUNG UNVACCINATED SPUTNIKV_FIRST goods
    $total_r_unvcted_frst_pfizer_prov = $total_e_pop_pfizer_prov - $total_vcted_pfizer_frst - $total_rfsd_pfizer_frst_prov; //REMAINUNG UNVACCINATED PFIZER_FIRST goods
    $total_r_unvcted_frst_moderna_prov = $total_e_pop_moderna_prov - $total_vcted_moderna_frst - $total_rfsd_moderna_frst_prov; //REMAINUNG UNVACCINATED MODERNA_FIRST goods
    $total_r_unvcted_frst_johnson_prov = $total_e_pop_johnson_prov - $total_vcted_johnson_frst - $total_rfsd_johnson_frst_prov; //REMAINUNG UNVACCINATED JOHNSON_FIRST goods

    $total_r_unvcted_scnd_svac_prov = $total_e_pop_svac_prov - $total_vcted_svac_second - $total_rfsd_svac_scnd_prov; //REMAINING UNVACCINATED  SINOVAC_SECOND goods
    $total_r_unvcted_scnd_astra_prov = $total_e_pop_astra_prov - $total_vcted_astra_second - $total_rfsd_astra_scnd_prov;  //REMAINING UNVACCINATED ASTRA_SECOND goods
    $total_r_unvcted_scnd_sputnikv_prov = $total_e_pop_sputnikv_prov - $total_vcted_sputnikv_second - $total_rfsd_sputnikv_scnd_prov;  //REMAINING UNVACCINATED SPUTNIKV_SECOND goods
    $total_r_unvcted_scnd_pfizer_prov = $total_e_pop_pfizer_prov - $total_vcted_pfizer_second - $total_rfsd_pfizer_scnd_prov;  //REMAINING UNVACCINATED PFIZER_SECOND goods
    $total_r_unvcted_scnd_moderna_prov = $total_e_pop_moderna_prov - $total_vcted_moderna_second - $total_rfsd_moderna_scnd_prov;  //REMAINING UNVACCINATED MODERNA_SECOND goods
    $total_r_unvcted_scnd_johnson_prov = $total_e_pop_johnson_prov - $total_vcted_johnson_second - $total_rfsd_johnson_scnd_prov;  //REMAINING UNVACCINATED JOHNSON_SECOND goods

    $total_r_unvcted_all_frst_prov = $total_e_pop_svac_prov - $total_vcted_overall_frst - $total_rfsd_frst_prov; //TOTAL REMAINUNG UNVACCINATED goods //dara
    $total_r_unvcted_all_scnd_prov = $total_e_pop_svac_prov - $total_vcted_overall_second - $total_rfsd_scnd_prov; //TOTAL REMAINING UNVACCIANTED  2 goods

    $sinovac_dashboard = $total_vcted_svac_frst + $total_vcted_svac_second;
    $astra_dashboard = $total_vcted_astra_frst + $total_vcted_astra_second;
    $sputnikv_dashboard = $total_vcted_sputnikv_frst + $total_vcted_sputnikv_second;
    $pfizer_dashboard = $total_vcted_pfizer_frst + $total_vcted_pfizer_second;
    $moderna_dashboard = $total_vcted_moderna_frst + $total_vcted_moderna_second;
    $johnson_dashboard = $total_vcted_johnson_frst + $total_vcted_johnson_second;

    $percent_coverage_firstdose = $total_p_cvrge_frst_prov;
    $percent_coverage_seconddose = $total_p_cvrge_scnd_prov;

    $consumption_rate_firstdose = $total_c_rate_frst_prov;
    $consumption_rate_seconddose = $total_c_rate_scnd_prov;

    $a1_dashboard = $total_vcted_grand_a1_first + $total_vcted_grand_a1_second;
    $a2_dashboard = $total_vcted_grand_a2_first + $total_vcted_grand_a2_second;
    $a3_dashboard = $total_vcted_grand_a3_first + $total_vcted_grand_a3_second;
    $a4_dashboard = $total_vcted_grand_a4_first + $total_vcted_grand_a4_second;
    $a5_dashboard = $total_vcted_grand_a5_first + $total_vcted_grand_a5_second;
    $b1_dashboard = $total_vcted_grand_b1_first + $total_vcted_grand_b1_second;
    $b2_dashboard = $total_vcted_grand_b2_first + $total_vcted_grand_b2_second;
    $b3_dashboard = $total_vcted_grand_b3_first + $total_vcted_grand_b3_second;
    $b4_dashboard = $total_vcted_grand_b4_first + $total_vcted_grand_b4_second;

    Session::put("sinovac_dashboard",$sinovac_dashboard);
    Session::put("astra_dashboard",$astra_dashboard);
    Session::put("sputnikv_dashboard",$sputnikv_dashboard);
    Session::put("pfizer_dashboard",$pfizer_dashboard);
    Session::put("moderna_dashboard",$moderna_dashboard);
    Session::put("johnson_dashboard",$johnson_dashboard);
    Session::put("percent_coverage_firstdose",$percent_coverage_firstdose);
    Session::put("percent_coverage_seconddose",$percent_coverage_seconddose);
    Session::put("consumption_rate_firstdose",$consumption_rate_firstdose);
    Session::put("consumption_rate_seconddose",$consumption_rate_seconddose);
    Session::put("a1_dashboard",$a1_dashboard);
    Session::put("a2_dashboard",$a2_dashboard);
    Session::put("a3_dashboard",$a3_dashboard);
    Session::put("a4_dashboard",$a4_dashboard);
    Session::put("a5_dashboard",$a5_dashboard);
    Session::put("b1_dashboard",$b1_dashboard);
    Session::put("b2_dashboard",$b2_dashboard);
    Session::put("b3_dashboard",$b3_dashboard);
    Session::put("b4_dashboard",$b4_dashboard);

    ?>

<b>Grand Total</b>
    <button class="btn btn-sm btn-link collapsed" style="color: red;" type="button" data-toggle="collapse" data-target="#collapse_sinovac_grand" aria-expanded="false" aria-controls="collapse_sinovac_grandtotal">
        <b>Sinovac</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color: darkgoldenrod;" type="button" data-toggle="collapse" data-target="#collapse_astra_grand" aria-expanded="false" aria-controls="collapse_astra_grandtotal">
        <b>Astrazeneca</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color: #00c0ef;" type="button" data-toggle="collapse" data-target="#collapse_pfizer_grand" aria-expanded="false" aria-controls="collapse_pfizer_grandtotal">
        <b>Pfizer</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color: #00a65a;" type="button" data-toggle="collapse" data-target="#collapse_sputnikv_grand" aria-expanded="false" aria-controls="collapse_sputnikv_grandtotal">
        <b>Sputnik V</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color: #605ca8;" type="button" data-toggle="collapse" data-target="#collapse_moderna_grand" aria-expanded="false" aria-controls="collapse_moderna_grandtotal">
         <b>Moderna</b>
    </button>
    <button class="btn btn-sm btn-link collapsed" style="color: #1d94ff;" type="button" data-toggle="collapse" data-target="#collapse_johnson_grand" aria-expanded="false" aria-controls="collapse_johnson_grandtotal">
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
    <tbody id="collapse_sinovac_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <tr style="background-color: #ffd8d6">
            <td rowspan="2">Sinovac</td> <!--SINOVAC -->
            <td rowspan="2">
                {{ $total_e_pop_svac_a1_prov }}
                 <?php Session::put('total_e_pop_svac_a1_excel',$total_e_pop_svac_a1_prov); ?>
            </td><!-- A1 SINOVAC_FIRST -->
            <td rowspan="2">
                 <?php Session::put('total_e_pop_svac_a2_excel',$total_e_pop_svac_a2_prov); ?>
                {{ $total_e_pop_svac_a2_prov }}
            </td><!-- A2 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_a3_prov }}
                 <?php Session::put('total_e_pop_svac_a3_excel',$total_e_pop_svac_a3_prov); ?>
            </td><!-- A3 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_a4_prov }}
                 <?php Session::put('total_e_pop_svac_a4_excel',$total_e_pop_svac_a4_prov); ?>
            </td> <!-- A4 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_a5_prov }}
                <?php Session::put('total_e_pop_svac_a5_excel',$total_e_pop_svac_a5_prov); ?>
            </td>  <!-- A5 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_b1_prov }}
                <?php Session::put('total_e_pop_svac_b1_excel',$total_e_pop_svac_b1_prov); ?>
            </td>  <!-- B1 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_b2_prov }}
                <?php Session::put('total_e_pop_svac_b2_excel',$total_e_pop_svac_b2_prov); ?>
            </td>  <!-- B2 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_b3_prov }}
                <?php Session::put('total_e_pop_svac_b3_excel',$total_e_pop_svac_b3_prov); ?>
            </td>  <!-- B3 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_b4_prov }}
                <?php Session::put('total_e_pop_svac_b4_excel',$total_e_pop_svac_b4_prov); ?>
            </td>  <!-- B4 SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_svac_prov }}
                 <?php session::put('total_e_pop_svac_excel',$total_e_pop_svac_prov);?>
            </td> <!-- TOTAL ELI POP SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_svac_frst_prov }}
                 <?php session::put('total_vallocated_svac_frst_excel',$total_vallocated_svac_frst_prov);?>
            </td> <!-- VACCINE ALLOCATED (FD) SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_svac_scnd_prov }}
                <?php session::put('total_vallocated_svac_scnd_excel',$total_vallocated_svac_scnd_prov);?>
            </td>  <!-- VACCINE ALLOCATED (SD) SINOVAC_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_frst_svac }}
                 <?php session::put('total_vallocated_frst_svac_excel',$total_vallocated_frst_svac);?>
            </td>  <!-- TOTAL VACCINE ALLOCATED SINOVAC_FIRST -->
            <td>
                <span class="label label-success">
                    {{ $total_svac_a1_frst_prov }}
                 <?php session::put('total_svac_a1_frst_excel',$total_svac_a1_frst_prov);?>
                </span>   <!-- VACCINATED (A1) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_a2_frst_prov }}
                 <?php session::put('total_svac_a2_frst_excel',$total_svac_a2_frst_prov);?>
                </span>  <!-- VACCINATED (A2) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_a3_frst_prov }}
                 <?php session::put('total_svac_a3_frst_excel',$total_svac_a3_frst_prov);?>
                </span>  <!-- VACCINATED (A3) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_a4_frst_prov }}
                 <?php session::put('total_svac_a4_frst_excel',$total_svac_a4_frst_prov);?>
                </span>  <!-- VACCINATED (A4) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_a5_frst_prov }}
                    <?php session::put('total_svac_a5_frst_excel',$total_svac_a5_frst_prov);?>
                </span>  <!-- VACCINATED (A5) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_b1_frst_prov }}
                    <?php session::put('total_svac_b1_frst_excel',$total_svac_b1_frst_prov);?>
                </span>  <!-- VACCINATED (B1) SINOVAC_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_svac_b2_frst_prov }}
                     <?php session::put('total_svac_b2_frst_excel',$total_svac_b2_frst_prov);?>
                </span>  <!-- VACCINATED (B2) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_b3_frst_prov }}
                    <?php session::put('total_svac_b3_frst_excel',$total_svac_b3_frst_prov);?>
                </span>  <!-- VACCINATED (B3) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_svac_b4_frst_prov }}
                    <?php session::put('total_svac_b4_frst_excel',$total_svac_b4_frst_prov);?>
                </span>  <!-- VACCINATED (B4) SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_vcted_svac_frst }}
                 <?php session::put('total_vcted_svac_frst_excel',$total_vcted_svac_frst);?>
                </span>  <!-- TOTAL VACCINATED SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_mild_svac_frst_prov }}
                 <?php session::put('total_mild_svac_frst_excel',$total_mild_svac_frst_prov);?>
                </span>  <!-- MILD SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_srs_svac_frst_prov }}
                 <?php session::put('total_srs_svac_frst_excel',$total_srs_svac_frst_prov);?>
                </span> <!-- SERIOUS SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_dfrd_svac_frst_prov }}
                 <?php session::put('total_dfrd_svac_frst_excel',$total_dfrd_svac_frst_prov);?>
                </span> <!-- DEFERRED SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_rfsd_svac_frst_prov }}
                 <?php session::put('total_rfsd_svac_frst_excel',$total_rfsd_svac_frst_prov);?>
                </span> <!-- REFUSED SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_wstge_svac_frst_prov }}
                 <?php session::put('total_wstge_svac_frst_excel',$total_wstge_svac_frst_prov);?>
                </span> <!-- WASTAGE SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_p_cvrge_svac_frst_prov,2) }}%
                    <?php session::put('total_p_cvrge_svac_frst_excel',number_format($total_p_cvrge_svac_frst_prov,2));?>
                </span> <!-- PERCENT COVERAGE SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_c_rate_svac_frst_prov,2) }}%
                    <?php session::put('total_c_rate_svac_frst_excel', number_format($total_c_rate_svac_frst_prov,2));?>
                </span> <!-- CONSUMPTION RATE SINOVAC_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_r_unvcted_frst_svac_prov }}
                   <?php session::put('total_r_unvcted_frst_svac_excel',$total_r_unvcted_frst_svac_prov);?>
                </span> <!-- REMAINING UNVACCINATED SINOVAC_FIRST -->
            </td>
        </tr>
        <tr style="background-color: #ffd8d6">
            <td>
                <span class="label label-warning">
                    {{ $total_svac_a1_scnd_prov }}
                    <?php session::put('total_svac_a1_scnd_excel',$total_svac_a1_scnd_prov);?>
                </span>   <!-- VACCINATED (A1) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_a2_scnd_prov }}
                    <?php session::put('total_svac_a2_scnd_excel',$total_svac_a2_scnd_prov );?>
                </span> <!-- VACCINATED (A2) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_a3_scnd_prov }}
                    <?php session::put('total_svac_a3_scnd_excel',$total_svac_a3_scnd_prov );?>
                </span> <!-- VACCINATED (A3) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_a4_scnd_prov }}
                    <?php session::put('total_svac_a4_scnd_excel',$total_svac_a4_scnd_prov );?>
                </span> <!-- VACCINATED (A4) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_a5_scnd_prov }}
                    <?php session::put('total_svac_a5_scnd_excel',$total_svac_a5_scnd_prov );?>
                </span> <!-- VACCINATED (A5) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_b1_scnd_prov }}
                    <?php session::put('total_svac_b1_scnd_excel',$total_svac_b1_scnd_prov );?>
                </span> <!-- VACCINATED (B1) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_b2_scnd_prov }}
                    <?php session::put('total_svac_b2_scnd_excel',$total_svac_b2_scnd_prov );?>
                </span> <!-- VACCINATED (B2) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_b3_scnd_prov }}
                    <?php session::put('total_svac_b3_scnd_excel',$total_svac_b3_scnd_prov );?>
                </span> <!-- VACCINATED (B3) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_svac_b4_scnd_prov }}
                    <?php session::put('total_svac_b4_scnd_excel',$total_svac_b4_scnd_prov );?>
                </span> <!-- VACCINATED (B4) SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_vcted_svac_second }}
                    <?php session::put('total_vcted_svac_second_excel',$total_vcted_svac_second );?>
                </span> <!-- TOTAL VACCINATED SINOVAC_SECOND -->
            </td> <!-- 1-4 -->
            <td>
                <span class="label label-warning">
                    {{ $total_mild_svac_scnd_prov }}
                    <?php session::put('total_mild_svac_scnd_excel',$total_mild_svac_scnd_prov );?>
                </span> <!-- MILD SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_srs_svac_scnd_prov }}
                    <?php session::put('total_srs_svac_scnd_excel',$total_srs_svac_scnd_prov );?>
                </span> <!-- SERIOUS  SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_dfrd_svac_scnd_prov }}
                    <?php session::put('total_dfrd_svac_scnd_excel',$total_dfrd_svac_scnd_prov );?>
                </span> <!-- DEFERRED  SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_rfsd_svac_scnd_prov }}
                    <?php session::put('total_rfsd_svac_scnd_excel',$total_rfsd_svac_scnd_prov );?>
                </span> <!-- REFUSED  SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_wstge_svac_scnd_prov }}
                    <?php session::put('total_wstge_svac_scnd_excel',$total_wstge_svac_scnd_prov );?>
                </span> <!-- WASTAGE SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_p_cvrge_svac_scnd_prov,2)}}%
                    <?php session::put('total_p_cvrge_svac_scnd_excel',number_format($total_p_cvrge_svac_scnd_prov,2));?>
                </span> <!-- PERCENT COVERAGE  SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_c_rate_svac_scnd_prov,2) }}%
                    <?php session::put('total_c_rate_svac_scnd_excel',number_format($total_c_rate_svac_scnd_prov,2));?>
                </span> <!-- CONSUMPTION RATE SINOVAC_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_r_unvcted_scnd_svac_prov }}
                    <?php session::put('total_r_unvcted_scnd_svac_excel',$total_r_unvcted_scnd_svac_prov);?>
                </span> <!-- REMAINING UNVACCINATED  SINOVAC_SECOND -->
            </td>
        </tr>
    </tbody>
    <tbody id="collapse_astra_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <tr style="background-color: #f2fcac">
            <td rowspan="2">Astrazeneca</td> <!-- 1-5 -->
            <td rowspan="2" style="color:black;">
                {{ $total_e_pop_astra_a1_prov }}
                <?php session::put('total_e_pop_astra_a1_excel',$total_e_pop_astra_a1_prov);?>
            </td>  <!-- A1 ASTRA_FIRST -->
            <td rowspan="2" style="color:black;">
                {{ $total_e_pop_astra_a2_prov }}
                <?php session::put('total_e_pop_astra_a2_excel',$total_e_pop_astra_a2_prov);?>
            </td>  <!-- A2 ASTRA_FIRST-->
            <td rowspan="2">
                {{ $total_e_pop_astra_a3_prov }}
                <?php session::put('total_e_pop_astra_a3_excel',$total_e_pop_astra_a3_prov);?>
            </td>  <!-- A3 ASTRA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_astra_a4_prov }}
                <?php session::put('total_e_pop_astra_a4_excel',$total_e_pop_astra_a4_prov);?>
            </td>  <!-- A4 ASTRA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_astra_a5_prov }}
                <?php session::put('total_e_pop_astra_a5_excel',$total_e_pop_astra_a5_prov);?>
            </td> <!-- A5 ASTRA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_astra_b1_prov }}
                <?php session::put('total_e_pop_astra_b1_excel',$total_e_pop_astra_b1_prov);?>
            </td> <!-- B1 ASTRA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_astra_b2_prov }}
                <?php session::put('total_e_pop_astra_b2_excel',$total_e_pop_astra_b2_prov);?>
            </td> <!-- B2 ASTRA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_astra_b3_prov }}
                <?php session::put('total_e_pop_astra_b3_excel',$total_e_pop_astra_b3_prov);?>
            </td> <!-- B3 ASTRA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_astra_b4_prov }}
                <?php session::put('total_e_pop_astra_b4_excel',$total_e_pop_astra_b4_prov);?>
            </td> <!-- B4 ASTRA_FIRST -->
            <td rowspan="2" style="color:black;">
                {{ $total_e_pop_astra_prov }}
                <?php session::put('total_e_pop_astra_excel',$total_e_pop_astra_prov);?>
            </td><!-- TOTAL E POP ASTRA_FIRST -->
            <td rowspan="2" style="color:black">
                {{ $total_vallocated_astra_frst_prov }}
                <?php session::put('total_vallocated_astra_frst_excel',$total_vallocated_astra_frst_prov);?>
            </td> <!-- VACCINE_ALLOCATED (FD) ASTRA_FIRST-->
            <td rowspan="2" style="color:black">
                {{ $total_vallocated_astra_scnd_prov }}
                <?php session::put('total_vallocated_astra_scnd_excel',$total_vallocated_astra_scnd_prov);?>
            </td>  <!-- VACCINE ALLOCATED (SD) ASTRA_FIRST -->
            <td rowspan="2" style="color:black;">
                {{ $total_vallocated_frst_astra }}
                <?php session::put('total_vallocated_frst_astra_excel',$total_vallocated_frst_astra);?>
            </td>  <!-- TOTAL VACCINE ALLOCATED ASTRA_FIRST -->
            <td style="color:black;">
                <span class="label label-success">
                    {{ $total_astra_a1_frst_prov }}
                    <?php session::put('total_astra_a1_frst_excel',$total_astra_a1_frst_prov);?>
                </span>  <!-- VACCINATED (A1) ASTRA_FIRST -->
            </td>
            <td style="color:black">
                <span class="label label-success">
                    {{ $total_astra_a2_frst_prov }}
                    <?php session::put('total_astra_a2_frst_excel',$total_astra_a2_frst_prov);?>
                </span> <!-- VACCINATED (A2) ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_astra_a3_frst_prov }}
                    <?php session::put('total_astra_a3_frst_excel',$total_astra_a3_frst_prov);?>
                </span> <!-- VACCINATED (A3) ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_astra_a4_frst_prov }}
                    <?php session::put('total_astra_a4_frst_excel',$total_astra_a4_frst_prov);?>
                </span> <!-- VACCINATED (A4) ASTRA_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_astra_a5_frst_prov }}
                     <?php session::put('total_astra_a5_frst_excel',$total_astra_a5_frst_prov);?>
                </span> <!-- VACCINATED (A5) ASTRA_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_astra_b1_frst_prov }}
                     <?php session::put('total_astra_b1_frst_excel',$total_astra_b1_frst_prov);?>
                </span> <!-- VACCINATED (B1) ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_astra_b2_frst_prov }}
                    <?php session::put('total_astra_b2_frst_excel',$total_astra_b2_frst_prov);?>
                </span> <!-- VACCINATED (B2) ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_astra_b3_frst_prov }}
                    <?php session::put('total_astra_b3_frst_excel',$total_astra_b3_frst_prov);?>
                </span> <!-- VACCINATED (B3) ASTRA_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_astra_b4_frst_prov }}
                     <?php session::put('total_astra_b4_frst_excel',$total_astra_b4_frst_prov);?>
                </span> <!-- VACCINATED (B4 ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_vcted_astra_frst }}
                    <?php session::put('total_vcted_astra_frst_excel',$total_vcted_astra_frst);?>
                </span> <!-- TOTAL VACCINATED ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_mild_astra_frst_prov }}
                    <?php session::put('total_mild_astra_frst_excel',$total_mild_astra_frst_prov);?>
                </span> <!-- MILD ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_srs_astra_frst_prov }}
                    <?php session::put('total_srs_astra_frst_excel',$total_srs_astra_frst_prov);?>
                </span> <!-- SERIOUS ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_dfrd_astra_frst_prov }}
                    <?php session::put('total_dfrd_astra_frst_excel',$total_dfrd_astra_frst_prov);?>
                </span> <!-- DEFERRED ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_rfsd_astra_frst_prov }}
                    <?php session::put('total_rfsd_astra_frst_excel',$total_rfsd_astra_frst_prov);?>
                </span> <!-- REFUSED ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_wstge_astra_frst_prov }}
                    <?php session::put('total_wstge_astra_frst_excel',$total_wstge_astra_frst_prov);?>
                </span> <!-- WASTAGE ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_p_cvrge_astra_frst_prov,2) }}%
                    <?php session::put('total_p_cvrge_astra_frst_excel',number_format($total_p_cvrge_astra_frst_prov,2));?>
                </span> <!-- PERCENT_COVERAGE ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_c_rate_astra_frst_prov,2) }}%
                    <?php session::put('total_c_rate_astra_frst_excel',number_format($total_c_rate_astra_frst_prov,2));?>
                </span> <!-- CONSUMPTION RATE ASTRA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_r_unvcted_frst_astra_prov }}
                    <?php session::put('total_r_unvcted_frst_astra_excel',$total_r_unvcted_frst_astra_prov);?>
                </span> <!-- REMAINUNG UNVACCINATED ASTRA_FIRST -->
            </td>
        </tr>
        <tr style="background-color: #f2fcac">
            <td style="color: black;">
                <span class="label label-warning">
                    {{ $total_astra_a1_scnd_prov }}
                    <?php session::put('total_astra_a1_scnd_excel',$total_astra_a1_scnd_prov);?>
                </span>  <!-- VACCINATED (A1) ASTRA_SECOND -->
            </td>
            <td style="color:black;">
                <span class="label label-warning">
                    {{ $total_astra_a2_scnd_prov }}
                    <?php session::put('total_astra_a2_scnd_excel',$total_astra_a2_scnd_prov);?>
                </span>  <!-- VACCINATED (A2) ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_astra_a3_scnd_prov }}
                    <?php session::put('total_astra_a3_scnd_excel',$total_astra_a3_scnd_prov);?>
                </span>  <!-- VACCINATED (A3) ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_astra_a4_scnd_prov }}
                    <?php session::put('total_astra_a4_scnd_excel',$total_astra_a4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) ASTRA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_astra_a5_scnd_prov }}
                     <?php session::put('total_astra_a5_scnd_excel',$total_astra_a5_scnd_prov);?>
                </span>  <!-- VACCINATED (A5) ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_astra_b1_scnd_prov }}
                    <?php session::put('total_astra_b1_scnd_excel',$total_astra_b1_scnd_prov);?>
                </span>  <!-- VACCINATED (B1) ASTRA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_astra_b2_scnd_prov }}
                     <?php session::put('total_astra_b2_scnd_excel',$total_astra_b2_scnd_prov);?>
                </span>  <!-- VACCINATED (B2) ASTRA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_astra_b3_scnd_prov }}
                     <?php session::put('total_astra_b3_scnd_excel',$total_astra_b3_scnd_prov);?>
                </span>  <!-- VACCINATED (B3) ASTRA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_astra_b4_scnd_prov }}
                     <?php session::put('total_astra_b4_scnd_excel',$total_astra_b4_scnd_prov);?>
                </span>  <!-- VACCINATED (B4) ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_vcted_astra_second }}
                    <?php session::put('total_vcted_astra_second',$total_vcted_astra_second);?>
                </span>  <!-- TOTAL VACCINATED ASTRA_SECOND -->
            </td> <!-- 1-6 -->
            <td>
                <span class="label label-warning">
                    {{ $total_mild_astra_scnd_prov }}
                    <?php session::put('total_mild_astra_scnd_excel',$total_mild_astra_scnd_prov);?>
                </span>  <!-- MILD ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_srs_astra_scnd_prov }}
                    <?php session::put('total_srs_astra_scnd_excel',$total_srs_astra_scnd_prov);?>
                </span> <!-- SERIOUS ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_dfrd_astra_scnd_prov }}
                    <?php session::put('total_dfrd_astra_scnd_excel',$total_dfrd_astra_scnd_prov);?>
                </span> <!-- DEFERRED ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_rfsd_astra_scnd_prov }}
                    <?php session::put('total_rfsd_astra_scnd_excel',$total_rfsd_astra_scnd_prov);?>
                </span> <!-- REFUSED ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_wstge_astra_scnd_prov }}
                    <?php session::put('total_wstge_astra_scnd_excel',$total_wstge_astra_scnd_prov);?>
                </span> <!-- WASTAGE ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_p_cvrge_astra_scnd_prov,2) }}%
                    <?php session::put('total_p_cvrge_astra_scnd_excel',number_format($total_p_cvrge_astra_scnd_prov,2));?>
                </span> <!-- PERCENT_COVERAGE_ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_c_rate_astra_scnd_prov,2) }}%
                    <?php session::put('total_c_rate_astra_scnd_excel',number_format($total_c_rate_astra_scnd_prov,2));?>
                </span> <!-- CONSUMPTION RATE ASTRA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_r_unvcted_scnd_astra_prov }}
                    <?php session::put('total_r_unvcted_scnd_astra_excel',$total_r_unvcted_scnd_astra_prov);?>
                </span> <!-- REMAINING UNVACCINATED ASTRA_SECOND -->
            </td>
        </tr>
    </tbody>

        <!-- PFIZER -->
        <tbody id="collapse_pfizer_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <tr style="background-color: #8fe7fd">
            <td rowspan="2">Pfizer</td> <!-- 1-5 -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_a1_prov }}
                <?php session::put('total_e_pop_pfizer_a1_excel',$total_e_pop_pfizer_a1_prov );?>
            </td><!-- A1 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_a2_prov }}
                <?php session::put('total_e_pop_pfizer_a2_excel',$total_e_pop_pfizer_a2_prov );?>
            </td><!-- A2 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_a3_prov }}
                <?php session::put('total_e_pop_pfizer_a3_excel',$total_e_pop_pfizer_a3_prov );?>
            </td><!-- A3 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_a4_prov }}
                <?php session::put('total_e_pop_pfizer_a4_excel',$total_e_pop_pfizer_a4_prov );?>
            </td><!-- A4 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_a5_prov }}
                <?php session::put('total_e_pop_pfizer_a5_excel',$total_e_pop_pfizer_a5_prov );?>
            </td><!-- A5 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_b1_prov }}
                <?php session::put('total_e_pop_pfizer_b1_excel',$total_e_pop_pfizer_b1_prov );?>
            </td><!-- B1 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_b2_prov }}
                <?php session::put('total_e_pop_pfizer_b2_excel',$total_e_pop_pfizer_b2_prov );?>
            </td><!-- B2 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_b3_prov }}
                <?php session::put('total_e_pop_pfizer_b3_excel',$total_e_pop_pfizer_b3_prov );?>
            </td><!-- B3 PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_pfizer_b4_prov }}
                <?php session::put('total_e_pop_pfizer_b4_excel',$total_e_pop_pfizer_b4_prov );?>
            </td><!-- B4 PFIZER_FIRST -->
            <td rowspan="2">
            {{ $total_e_pop_pfizer_prov }}
            <?php session::put('total_e_pop_pfizer_excel',$total_e_pop_pfizer_prov );?>
            </td><!-- TOTAL ELI POP PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_pfizer_frst_prov }}
                <?php session::put('total_vallocated_pfizer_frst_excel',$total_vallocated_pfizer_frst_prov );?>
            </td> <!-- VACCINE ALLOCATED (FD) PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_pfizer_scnd_prov }}
                <?php session::put('total_vallocated_pfizer_scnd_excel',$total_vallocated_pfizer_scnd_prov );?>
            </td>  <!-- VACCINE ALLOCATED (SD) PFIZER_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_pfizer }}
                <?php session::put('total_vallocated_pfizer_excel',$total_vallocated_pfizer );?>
            </td>  <!-- TOTAL VACCINE ALLOCATED PFIZER_FIRST -->
            <td>
                <span class="label label-success">
                    {{ $total_pfizer_a1_frst_prov }}
                    <?php session::put('total_pfizer_a1_frst_excel',$total_pfizer_a1_frst_prov );?>
                </span>   <!-- VACCINATED (A1) PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_pfizer_a2_frst_prov }}
                    <?php session::put('total_pfizer_a2_frst_excel',$total_pfizer_a2_frst_prov );?>
                </span>  <!-- VACCINATED (A2) PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_pfizer_a3_frst_prov }}
                    <?php session::put('total_pfizer_a3_frst_excel',$total_pfizer_a3_frst_prov );?>
                </span>  <!-- VACCINATED (A3) PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_pfizer_a4_frst_prov }}
                    <?php session::put('total_pfizer_a4_frst_excel',$total_pfizer_a4_frst_prov );?>
                </span>  <!-- VACCINATED (A4) PFIZER_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_pfizer_a5_frst_prov }}
                     <?php session::put('total_pfizer_a5_frst_excel',$total_pfizer_a5_frst_prov );?>
                </span>  <!-- VACCINATED (A5) PFIZER_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_pfizer_b1_frst_prov }}
                     <?php session::put('total_pfizer_b1_frst_excel',$total_pfizer_b1_frst_prov );?>
                </span>  <!-- VACCINATED (B1) PFIZER_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_pfizer_b2_frst_prov }}
                     <?php session::put('total_pfizer_b2_frst_excel',$total_pfizer_b2_frst_prov );?>
                </span>  <!-- VACCINATED (B2) PFIZER_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_pfizer_b3_frst_prov }}
                     <?php session::put('total_pfizer_b3_frst_excel',$total_pfizer_b3_frst_prov );?>
                </span>  <!-- VACCINATED (B3) PFIZER_FIRST -->
            </td>
            <td>
                 <span class="label label-success">
                    {{ $total_pfizer_b4_frst_prov }}
                     <?php session::put('total_pfizer_b4_frst_excel',$total_pfizer_b4_frst_prov );?>
                </span>  <!-- VACCINATED (B4) PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_vcted_pfizer_frst }}
                    <?php session::put('total_vcted_pfizer_frst_excel',$total_vcted_pfizer_frst );?>
                </span> <!-- TOTAL VACCINATED PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_mild_pfizer_frst_prov }}
                    <?php session::put('total_mild_pfizer_frst_excel',$total_mild_pfizer_frst_prov );?>
                </span> <!-- MILD PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_srs_pfizer_frst_prov }}
                    <?php session::put('total_srs_pfizer_frst_excel',$total_srs_pfizer_frst_prov );?>
                </span> <!-- SERIOUS PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_dfrd_pfizer_frst_prov }}
                    <?php session::put('total_dfrd_pfizer_frst_excel',$total_dfrd_pfizer_frst_prov );?>
                </span> <!-- DEFERRED PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_rfsd_pfizer_frst_prov }}
                    <?php session::put('total_rfsd_pfizer_frst_excel',$total_rfsd_pfizer_frst_prov );?>
                </span> <!-- REFUSED PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_wstge_pfizer_frst_prov }}
                    <?php session::put('total_wstge_pfizer_frst_excel',$total_wstge_pfizer_frst_prov );?>
                </span> <!-- WASTAGE PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_p_cvrge_pfizer_frst_prov,2)}}%
                    <?php session::put('total_p_cvrge_pfizer_frst_excel',number_format($total_p_cvrge_pfizer_frst_prov,2));?>
                </span> <!-- PERCENT_COVERAGE PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_c_rate_pfizer_frst_prov,2)}}%
                    <?php session::put('total_c_rate_pfizer_frst_excel',number_format($total_c_rate_pfizer_frst_prov,2));?>
                </span> <!-- CONSUMPTION RATE PFIZER_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_r_unvcted_frst_pfizer_prov }}
                    <?php session::put('total_r_unvcted_frst_pfizer_excel',$total_r_unvcted_frst_pfizer_prov );?>
                </span> <!-- REMAINUNG UNVACCINATED PFIZER_FIRST -->
            </td>
        </tr>
        <tr style="background-color: #8fe7fd">
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_a1_scnd_prov }}
                    <?php session::put('total_pfizer_a1_scnd_excel',$total_pfizer_a1_scnd_prov );?>
                </span>   <!-- VACCINATED (A1) PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_a2_scnd_prov }}
                    <?php session::put('total_pfizer_a2_scnd_excel',$total_pfizer_a2_scnd_prov );?>
                </span> <!-- VACCINATED (A2) PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_a3_scnd_prov }}
                    <?php session::put('total_pfizer_a3_scnd_excel',$total_pfizer_a3_scnd_prov );?>
                </span> <!-- VACCINATED (A3) PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_a4_scnd_prov }}
                    <?php session::put('total_pfizer_a4_scnd_excel',$total_pfizer_a4_scnd_prov );?>
                </span> <!-- VACCINATED (A4) PFIZER_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_pfizer_a5_scnd_prov }}
                     <?php session::put('total_pfizer_a5_scnd_excel',$total_pfizer_a5_scnd_prov );?>
                </span> <!-- VACCINATED (A5) PFIZER_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_pfizer_b1_scnd_prov }}
                     <?php session::put('total_pfizer_b1_scnd_excel',$total_pfizer_b1_scnd_prov );?>
                </span> <!-- VACCINATED (B1) PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_b2_scnd_prov }}
                    <?php session::put('total_pfizer_b2_scnd_excel',$total_pfizer_b2_scnd_prov );?>
                </span> <!-- VACCINATED (B2) PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_b3_scnd_prov }}
                    <?php session::put('total_pfizer_b3_scnd_excel',$total_pfizer_b3_scnd_prov );?>
                </span> <!-- VACCINATED (B3) PFIZER_SECOND --></td>
            <td>
                <span class="label label-warning">
                    {{ $total_pfizer_b4_scnd_prov }}
                    <?php session::put('total_pfizer_b4_scnd_excel',$total_pfizer_b4_scnd_prov );?>
                </span> <!-- VACCINATED (B4) PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_vcted_pfizer_second }}
                    <?php session::put('total_vcted_pfizer_second_excel',$total_vcted_pfizer_second );?>
                </span> <!-- TOTAL VACCINATED PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_mild_pfizer_scnd_prov }}
                    <?php session::put('total_mild_pfizer_scnd_excel',$total_mild_pfizer_scnd_prov );?>
                </span> <!-- MILD PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_srs_pfizer_scnd_prov }}
                    <?php session::put('total_srs_pfizer_scnd_excel',$total_srs_pfizer_scnd_prov );?>
                </span> <!-- SERIOUS  PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_dfrd_pfizer_scnd_prov }}
                    <?php session::put('total_dfrd_pfizer_scnd_excel',$total_dfrd_pfizer_scnd_prov );?>
                </span> <!-- DEFERRED  PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_rfsd_pfizer_scnd_prov }}
                    <?php session::put('total_rfsd_pfizer_scnd_excel',$total_rfsd_pfizer_scnd_prov );?>
                </span> <!-- REFUSED  PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_wstge_pfizer_scnd_prov }}
                    <?php session::put('total_wstge_pfizer_scnd_excel',$total_wstge_pfizer_scnd_prov );?>
                </span> <!-- WASTAGE PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_p_cvrge_pfizer_scnd_prov,2)}}%
                    <?php session::put('total_p_cvrge_pfizer_scnd_excel',number_format($total_p_cvrge_pfizer_scnd_prov,2));?>
                </span> <!-- PERCENT COVERAGE  PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_c_rate_pfizer_scnd_prov,2) }}%
                    <?php session::put('total_c_rate_pfizer_scnd_excel',number_format($total_c_rate_pfizer_scnd_prov,2));?>
                </span> <!-- CONSUMPTION RATE PFIZER_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_r_unvcted_scnd_pfizer_prov }}
                    <?php session::put('total_r_unvcted_scnd_pfizer_excel',$total_r_unvcted_scnd_pfizer_prov);?>
                </span> <!-- REMAINING UNVACCINATED  PFIZER_SECOND -->
            </td>
        </tr>
        </tbody>

        <!-- SPUTNIKV -->
        <tbody id="collapse_sputnikv_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <tr style="background-color: #b1ffdb">
            <td rowspan="2">SputnikV</td> <!-- 1-3 -->
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_a1_prov }}
                <?php session::put('total_e_pop_sputnikv_a1_excel',$total_e_pop_sputnikv_a1_prov);?>
            </td><!-- A1 SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_a2_prov }}
                <?php session::put('total_e_pop_sputnikv_a2_excel',$total_e_pop_sputnikv_a2_prov);?>
            </td><!-- A2 SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_a3_prov }}
                <?php session::put('total_e_pop_sputnikv_a3_excel',$total_e_pop_sputnikv_a3_prov);?>
            </td><!-- A3 SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_a4_prov }}
                <?php session::put('total_e_pop_sputnikv_a4_excel',$total_e_pop_sputnikv_a4_prov);?>
            </td><!-- A4 SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_a5_prov }}
                <?php session::put('total_e_pop_sputnikv_a5_excel',$total_e_pop_sputnikv_a5_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_b1_prov }}
                <?php session::put('total_e_pop_sputnikv_b1_excel',$total_e_pop_sputnikv_b1_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_b2_prov }}
                <?php session::put('total_e_pop_sputnikv_b2_excel',$total_e_pop_sputnikv_b2_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_b3_prov }}
                <?php session::put('total_e_pop_sputnikv_b3_excel',$total_e_pop_sputnikv_b3_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_b4_prov }}
                <?php session::put('total_e_pop_sputnikv_b4_excel',$total_e_pop_sputnikv_b4_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_sputnikv_prov }}
                <?php session::put('total_e_pop_sputnikv_excel',$total_e_pop_sputnikv_prov);?>
            </td><!-- TOTAL ELI POP SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_sputnikv_frst_prov }}
                <?php session::put('total_vallocated_sputnikv_frst_excel',$total_vallocated_sputnikv_frst_prov);?>
            </td> <!-- VACCINE ALLOCATED (FD) SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_sputnikv_scnd_prov }}
                <?php session::put('total_vallocated_sputnikv_scnd_excel',$total_vallocated_sputnikv_scnd_prov);?>
            </td>  <!-- VACCINE ALLOCATED (SD) SPUTNIKV_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_frst_sputnikv }}
                <?php session::put('total_vallocated_frst_sputnikv_excel',$total_vallocated_frst_sputnikv);?>
            </td>  <!-- TOTAL VACCINE ALLOCATED SPUTNIKV_FIRST -->
            <td>
                <span class="label label-success">
                    {{ $total_sputnikv_a1_frst_prov }}
                    <?php session::put('total_sputnikv_a1_frst_excel',$total_sputnikv_a1_frst_prov);?>
                </span>   <!-- VACCINATED (A1) SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_sputnikv_a2_frst_prov }}
                    <?php session::put('total_sputnikv_a2_frst_excel',$total_sputnikv_a2_frst_prov);?>
                </span>  <!-- VACCINATED (A2) SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_sputnikv_a3_frst_prov }}
                    <?php session::put('total_sputnikv_a3_frst_excel',$total_sputnikv_a3_frst_prov);?>
                </span>  <!-- VACCINATED (A3) SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_sputnikv_a4_frst_prov }}
                    <?php session::put('total_sputnikv_a4_frst_excel',$total_sputnikv_a4_frst_prov);?>
                </span>  <!-- VACCINATED (A4) SPUTNIKV_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_sputnikv_a5_frst_prov }}
                      <?php session::put('total_sputnikv_a5_frst_excel',$total_sputnikv_a5_frst_prov);?>
                </span>  <!-- VACCINATED (A5) SPUTNIKV_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_sputnikv_b1_frst_prov }}
                      <?php session::put('total_sputnikv_b1_frst_excel',$total_sputnikv_b1_frst_prov);?>
                </span>  <!-- VACCINATED (B1) SPUTNIKV_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_sputnikv_b2_frst_prov }}
                      <?php session::put('total_sputnikv_b2_frst_excel',$total_sputnikv_b2_frst_prov);?>
                </span>  <!-- VACCINATED (B2) SPUTNIKV_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_sputnikv_b3_frst_prov }}
                      <?php session::put('total_sputnikv_b3_frst_excel',$total_sputnikv_b3_frst_prov);?>
                </span>  <!-- VACCINATED (B3) SPUTNIKV_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_sputnikv_b4_frst_prov }}
                      <?php session::put('total_sputnikv_b4_frst_excel',$total_sputnikv_b4_frst_prov);?>
                </span>  <!-- VACCINATED (B4) SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_vcted_sputnikv_frst }}
                    <?php session::put('total_vcted_sputnikv_frst_excel',$total_vcted_sputnikv_frst);?>
                </span> <!-- TOTAL VACCINATED SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_mild_sputnikv_frst_prov }}
                    <?php session::put('total_mild_sputnikv_frst_excel',$total_mild_sputnikv_frst_prov);?>
                </span> <!-- MILD SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_srs_sputnikv_frst_prov }}
                    <?php session::put('total_srs_sputnikv_frst_excel',$total_srs_sputnikv_frst_prov);?>
                </span> <!-- SERIOUS SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_dfrd_sputnikv_frst_prov }}
                    <?php session::put('total_dfrd_sputnikv_frst_excel',$total_dfrd_sputnikv_frst_prov);?>
                </span> <!-- DEFERRED SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_rfsd_sputnikv_frst_prov }}
                    <?php session::put('total_rfsd_sputnikv_frst_excel',$total_rfsd_sputnikv_frst_prov);?>
                </span> <!-- REFUSED SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_wstge_sputnikv_frst_prov }}
                    <?php session::put('total_wstge_sputnikv_frst_excel',$total_wstge_sputnikv_frst_prov);?>
                </span> <!-- WASTAGE SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_p_cvrge_sputnikv_frst_prov,2) }}%
                    <?php session::put('total_p_cvrge_sputnikv_frst_excel',number_format($total_p_cvrge_sputnikv_frst_prov,2));?>
                </span> <!-- PERCENT_COVERAGE SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_c_rate_sputnikv_frst_prov,2) }}%
                    <?php session::put('total_c_rate_sputnikv_frst_excel',number_format($total_c_rate_sputnikv_frst_prov,2));?>
                </span> <!-- CONSUMPTION RATE SPUTNIKV_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_r_unvcted_frst_sputnikv_prov }}
                    <?php session::put('total_r_unvcted_frst_sputnikv_excel',$total_r_unvcted_frst_sputnikv_prov);?>
                </span> <!-- REMAINUNG UNVACCINATED SPUTNIKV_FIRST -->
            </td>
        </tr>
        <tr style="background-color: #b1ffdb">
            <td style="color: black;">
                <span class="label label-warning">
                    {{ $total_sputnikv_a1_scnd_prov }}
                    <?php session::put('total_sputnikv_a1_scnd_excel',$total_sputnikv_a1_scnd_prov);?>
                </span>  <!-- VACCINATED (A1) SPUTNIKV_SECOND -->
            </td>
            <td style="color:black;">
                <span class="label label-warning">
                    {{ $total_sputnikv_a2_scnd_prov }}
                    <?php session::put('total_sputnikv_a2_scnd_excel',$total_sputnikv_a2_scnd_prov);?>
                </span>  <!-- VACCINATED (A2) SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_sputnikv_a3_scnd_prov }}
                    <?php session::put('total_sputnikv_a3_scnd_excel',$total_sputnikv_a3_scnd_prov);?>
                </span>  <!-- VACCINATED (A3) SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_sputnikv_a4_scnd_prov }}
                    <?php session::put('total_sputnikv_a4_scnd_excel',$total_sputnikv_a4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) SPUTNIKV_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_sputnikv_a5_scnd_prov }}
                     <?php session::put('total_sputnikv_a5_scnd_excel',$total_sputnikv_a5_scnd_prov);?>
                </span>  <!-- VACCINATED (A5) SPUTNIKV_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_sputnikv_b1_scnd_prov }}
                     <?php session::put('total_sputnikv_b1_scnd_excel',$total_sputnikv_b1_scnd_prov);?>
                </span>  <!-- VACCINATED (B1) SPUTNIKV_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_sputnikv_b2_scnd_prov }}
                     <?php session::put('total_sputnikv_b2_scnd_excel',$total_sputnikv_b2_scnd_prov);?>
                </span>  <!-- VACCINATED (B2) SPUTNIKV_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_sputnikv_b3_scnd_prov }}
                     <?php session::put('total_sputnikv_b3_scnd_excel',$total_sputnikv_b3_scnd_prov);?>
                </span>  <!-- VACCINATED (B3) SPUTNIKV_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_sputnikv_a4_scnd_prov }}
                     <?php session::put('total_sputnikv_b4_scnd_excel',$total_sputnikv_b4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_vcted_sputnikv_second }}
                    <?php session::put('total_vcted_sputnikv_second_excel',$total_vcted_sputnikv_second);?>
                </span>  <!-- TOTAL VACCINATED SPUTNIKV_SECOND -->
            </td> <!-- 1-6 -->
            <td>
                <span class="label label-warning">
                    {{ $total_mild_sputnikv_scnd_prov }}
                    <?php session::put('total_mild_sputnikv_scnd_excel',$total_mild_sputnikv_scnd_prov);?>
                </span>  <!-- MILD SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_srs_sputnikv_scnd_prov }}
                    <?php session::put('total_srs_sputnikv_scnd_excel',$total_srs_sputnikv_scnd_prov);?>
                </span> <!-- SERIOUS SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_dfrd_sputnikv_scnd_prov }}
                    <?php session::put('total_dfrd_sputnikv_scnd_excel',$total_dfrd_sputnikv_scnd_prov);?>
                </span> <!-- DEFERRED SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_rfsd_sputnikv_scnd_prov }}
                    <?php session::put('total_rfsd_sputnikv_scnd_excel', $total_rfsd_sputnikv_scnd_prov);?>
                </span> <!-- REFUSED SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_wstge_sputnikv_scnd_prov }}
                    <?php session::put('total_wstge_sputnikv_scnd_excel', $total_wstge_sputnikv_scnd_prov);?>
                </span> <!-- WASTAGE SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_p_cvrge_sputnikv_scnd_prov,2)}}%
                    <?php session::put('total_p_cvrge_sputnikv_scnd_excel', number_format($total_p_cvrge_sputnikv_scnd_prov,2));?>
                </span> <!-- PERCENT_COVERAGE_SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_c_rate_sputnikv_scnd_prov,2)}}%
                    <?php session::put('total_c_rate_sputnikv_scnd_excel', number_format($total_c_rate_sputnikv_scnd_prov,2));?>
                </span> <!-- CONSUMPTION RATE SPUTNIKV_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_r_unvcted_scnd_sputnikv_prov }}
                    <?php session::put('total_r_unvcted_scnd_sputnikv_excel',$total_r_unvcted_scnd_sputnikv_prov );?>
                </span> <!-- REMAINING UNVACCINATED SPUTNIKV_SECOND -->
            </td>
        </tr>
        </tbody>

        <!-- MODERNA -->
        <tbody id="collapse_moderna_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <tr style="background-color: #dad8ff">
            <td rowspan="2">Moderna</td> <!-- 1-3 -->
            <td rowspan="2">
                {{ $total_e_pop_moderna_a1_prov }}
                <?php session::put('total_e_pop_moderna_a1_excel',$total_e_pop_moderna_a1_prov);?>
            </td><!-- A1 MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_moderna_a2_prov }}
                <?php session::put('total_e_pop_moderna_a2_excel',$total_e_pop_moderna_a2_prov);?>
            </td><!-- A2 MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_moderna_a3_prov }}
                <?php session::put('total_e_pop_moderna_a3_excel',$total_e_pop_moderna_a3_prov);?>
            </td><!-- A3 MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_moderna_a4_prov }}
                <?php session::put('total_e_pop_moderna_a4_excel',$total_e_pop_moderna_a4_prov);?>
            </td><!-- A4 MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_moderna_a5_prov }}
                <?php session::put('total_e_pop_moderna_a5_excel',$total_e_pop_moderna_a5_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_moderna_b1_prov }}
                <?php session::put('total_e_pop_moderna_b1_excel',$total_e_pop_moderna_b1_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_moderna_b2_prov }}
                <?php session::put('total_e_pop_moderna_b2_excel',$total_e_pop_moderna_b2_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_moderna_b3_prov }}
                <?php session::put('total_e_pop_moderna_b3_excel',$total_e_pop_moderna_b3_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_moderna_b4_prov }}
                <?php session::put('total_e_pop_moderna_b4_excel',$total_e_pop_moderna_b4_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_moderna_prov }}
                <?php session::put('total_e_pop_moderna_excel',$total_e_pop_moderna_prov);?>
            </td><!-- TOTAL ELI POP MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_moderna_frst_prov }}
                <?php session::put('total_vallocated_moderna_frst_excel',$total_vallocated_moderna_frst_prov);?>
            </td> <!-- VACCINE ALLOCATED (FD) MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_moderna_scnd_prov }}
                <?php session::put('total_vallocated_moderna_scnd_excel',$total_vallocated_moderna_scnd_prov);?>
            </td>  <!-- VACCINE ALLOCATED (SD) MODERNA_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_frst_moderna }}
                <?php session::put('total_vallocated_frst_moderna_excel',$total_vallocated_frst_moderna);?>
            </td>  <!-- TOTAL VACCINE ALLOCATED MODERNA_FIRST -->
            <td>
                <span class="label label-success">
                    {{ $total_moderna_a1_frst_prov }}
                    <?php session::put('total_moderna_a1_frst_excel',$total_moderna_a1_frst_prov);?>
                </span>   <!-- VACCINATED (A1) MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_moderna_a2_frst_prov }}
                    <?php session::put('total_moderna_a2_frst_excel',$total_moderna_a2_frst_prov);?>
                </span>  <!-- VACCINATED (A2) MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_moderna_a3_frst_prov }}
                    <?php session::put('total_moderna_a3_frst_excel',$total_moderna_a3_frst_prov);?>
                </span>  <!-- VACCINATED (A3) MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_moderna_a4_frst_prov }}
                    <?php session::put('total_moderna_a4_frst_excel',$total_moderna_a4_frst_prov);?>
                </span>  <!-- VACCINATED (A4) MODERNA_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_moderna_a5_frst_prov }}
                      <?php session::put('total_moderna_a5_frst_excel',$total_moderna_a5_frst_prov);?>
                </span>  <!-- VACCINATED (A5) MODERNA_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_moderna_b1_frst_prov }}
                      <?php session::put('total_moderna_b1_frst_excel',$total_moderna_b1_frst_prov);?>
                </span>  <!-- VACCINATED (B1) MODERNA_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_moderna_b2_frst_prov }}
                      <?php session::put('total_moderna_b2_frst_excel',$total_moderna_b2_frst_prov);?>
                </span>  <!-- VACCINATED (B2) MODERNA_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_moderna_b3_frst_prov }}
                      <?php session::put('total_moderna_b3_frst_excel',$total_moderna_b3_frst_prov);?>
                </span>  <!-- VACCINATED (B3) MODERNA_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_moderna_b4_frst_prov }}
                      <?php session::put('total_moderna_b4_frst_excel',$total_moderna_b4_frst_prov);?>
                </span>  <!-- VACCINATED (B4) MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_vcted_moderna_frst }}
                    <?php session::put('total_vcted_moderna_frst_excel',$total_vcted_moderna_frst);?>
                </span> <!-- TOTAL VACCINATED MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_mild_moderna_frst_prov }}
                    <?php session::put('total_mild_moderna_frst_excel',$total_mild_moderna_frst_prov);?>
                </span> <!-- MILD MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_srs_moderna_frst_prov }}
                    <?php session::put('total_srs_moderna_frst_excel',$total_srs_moderna_frst_prov);?>
                </span> <!-- SERIOUS MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_dfrd_moderna_frst_prov }}
                    <?php session::put('total_dfrd_moderna_frst_excel',$total_dfrd_moderna_frst_prov);?>
                </span> <!-- DEFERRED MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_rfsd_moderna_frst_prov }}
                    <?php session::put('total_rfsd_moderna_frst_excel',$total_rfsd_moderna_frst_prov);?>
                </span> <!-- REFUSED MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_wstge_moderna_frst_prov }}
                    <?php session::put('total_wstge_moderna_frst_excel',$total_wstge_moderna_frst_prov);?>
                </span> <!-- WASTAGE MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_p_cvrge_moderna_frst_prov,2) }}%
                    <?php session::put('total_p_cvrge_moderna_frst_excel',number_format($total_p_cvrge_moderna_frst_prov,2));?>
                </span> <!-- PERCENT_COVERAGE MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_c_rate_moderna_frst_prov,2) }}%
                    <?php session::put('total_c_rate_moderna_frst_excel',number_format($total_c_rate_moderna_frst_prov,2));?>
                </span> <!-- CONSUMPTION RATE MODERNA_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_r_unvcted_frst_moderna_prov }}
                    <?php session::put('total_r_unvcted_frst_moderna_excel',$total_r_unvcted_frst_moderna_prov);?>
                </span> <!-- REMAINUNG UNVACCINATED MODERNA_FIRST -->
            </td>
        </tr>
        <tr style="background-color: #dad8ff">
            <td style="color: black;">
                <span class="label label-warning">
                    {{ $total_moderna_a1_scnd_prov }}
                    <?php session::put('total_moderna_a1_scnd_excel',$total_moderna_a1_scnd_prov);?>
                </span>  <!-- VACCINATED (A1) MODERNA_SECOND -->
            </td>
            <td style="color:black;">
                <span class="label label-warning">
                    {{ $total_moderna_a2_scnd_prov }}
                    <?php session::put('total_moderna_a2_scnd_excel',$total_moderna_a2_scnd_prov);?>
                </span>  <!-- VACCINATED (A2) MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_moderna_a3_scnd_prov }}
                    <?php session::put('total_moderna_a3_scnd_excel',$total_moderna_a3_scnd_prov);?>
                </span>  <!-- VACCINATED (A3) MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_moderna_a4_scnd_prov }}
                    <?php session::put('total_moderna_a4_scnd_excel',$total_moderna_a4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) MODERNA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_moderna_a5_scnd_prov }}
                     <?php session::put('total_moderna_a5_scnd_excel',$total_moderna_a5_scnd_prov);?>
                </span>  <!-- VACCINATED (A5) MODERNA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_moderna_b1_scnd_prov }}
                     <?php session::put('total_moderna_b1_scnd_excel',$total_moderna_b1_scnd_prov);?>
                </span>  <!-- VACCINATED (B1) MODERNA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_moderna_b2_scnd_prov }}
                     <?php session::put('total_moderna_b2_scnd_excel',$total_moderna_b2_scnd_prov);?>
                </span>  <!-- VACCINATED (B2) MODERNA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_moderna_b3_scnd_prov }}
                     <?php session::put('total_moderna_b3_scnd_excel',$total_moderna_b3_scnd_prov);?>
                </span>  <!-- VACCINATED (B3) MODERNA_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_moderna_a4_scnd_prov }}
                     <?php session::put('total_moderna_b4_scnd_excel',$total_moderna_a4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_vcted_moderna_second }}
                    <?php session::put('total_vcted_moderna_second_excel',$total_vcted_moderna_second);?>
                </span>  <!-- TOTAL VACCINATED MODERNA_SECOND -->
            </td> <!-- 1-6 -->
            <td>
                <span class="label label-warning">
                    {{ $total_mild_moderna_scnd_prov }}
                    <?php session::put('total_mild_moderna_scnd_excel',$total_mild_moderna_scnd_prov);?>
                </span>  <!-- MILD MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_srs_moderna_scnd_prov }}
                    <?php session::put('total_srs_moderna_scnd_excel',$total_srs_moderna_scnd_prov);?>
                </span> <!-- SERIOUS MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_dfrd_moderna_scnd_prov }}
                    <?php session::put('total_dfrd_moderna_scnd_excel',$total_dfrd_moderna_scnd_prov);?>
                </span> <!-- DEFERRED MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_rfsd_moderna_scnd_prov }}
                    <?php session::put('total_rfsd_moderna_scnd_excel', $total_rfsd_moderna_scnd_prov);?>
                </span> <!-- REFUSED MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_wstge_moderna_scnd_prov }}
                    <?php session::put('total_wstge_moderna_scnd_excel', $total_wstge_moderna_scnd_prov);?>
                </span> <!-- WASTAGE MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_p_cvrge_moderna_scnd_prov,2)}}%
                    <?php session::put('total_p_cvrge_moderna_scnd_excel', number_format($total_p_cvrge_moderna_scnd_prov,2));?>
                </span> <!-- PERCENT_COVERAGE_MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_c_rate_moderna_scnd_prov,2)}}%
                    <?php session::put('total_c_rate_moderna_scnd_excel', number_format($total_c_rate_moderna_scnd_prov,2));?>
                </span> <!-- CONSUMPTION RATE MODERNA_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_r_unvcted_scnd_moderna_prov }}
                    <?php session::put('total_r_unvcted_scnd_moderna_excel',$total_r_unvcted_scnd_moderna_prov );?>
                </span> <!-- REMAINING UNVACCINATED MODERNA_SECOND -->
            </td>
        </tr>
        </tbody>

        <!-- JOHNSON -->
        <tbody id="collapse_johnson_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
        <tr style="background-color: #9af5ee">
            <td rowspan="2">Janssen</td> <!-- 1-3 -->
            <td rowspan="2">
                {{ $total_e_pop_johnson_a1_prov }}
                <?php session::put('total_e_pop_johnson_a1_excel',$total_e_pop_johnson_a1_prov);?>
            </td><!-- A1 JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_johnson_a2_prov }}
                <?php session::put('total_e_pop_johnson_a2_excel',$total_e_pop_johnson_a2_prov);?>
            </td><!-- A2 JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_johnson_a3_prov }}
                <?php session::put('total_e_pop_johnson_a3_excel',$total_e_pop_johnson_a3_prov);?>
            </td><!-- A3 JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_johnson_a4_prov }}
                <?php session::put('total_e_pop_johnson_a4_excel',$total_e_pop_johnson_a4_prov);?>
            </td><!-- A4 JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_e_pop_johnson_a5_prov }}
                <?php session::put('total_e_pop_johnson_a5_excel',$total_e_pop_johnson_a5_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_johnson_b1_prov }}
                <?php session::put('total_e_pop_johnson_b1_excel',$total_e_pop_johnson_b1_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_johnson_b2_prov }}
                <?php session::put('total_e_pop_johnson_b2_excel',$total_e_pop_johnson_b2_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_johnson_b3_prov }}
                <?php session::put('total_e_pop_johnson_b3_excel',$total_e_pop_johnson_b3_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_johnson_b4_prov }}
                <?php session::put('total_e_pop_johnson_b4_excel',$total_e_pop_johnson_b4_prov);?>
            </td>
            <td rowspan="2">
                {{ $total_e_pop_johnson_prov }}
                <?php session::put('total_e_pop_johnson_excel',$total_e_pop_johnson_prov);?>
            </td><!-- TOTAL ELI POP JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_johnson_frst_prov }}
                <?php session::put('total_vallocated_johnson_frst_excel',$total_vallocated_johnson_frst_prov);?>
            </td> <!-- VACCINE ALLOCATED (FD) JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_johnson_scnd_prov }}
                <?php session::put('total_vallocated_johnson_scnd_excel',$total_vallocated_johnson_scnd_prov);?>
            </td>  <!-- VACCINE ALLOCATED (SD) JOHNSON_FIRST -->
            <td rowspan="2">
                {{ $total_vallocated_frst_johnson }}
                <?php session::put('total_vallocated_frst_johnson_excel',$total_vallocated_frst_johnson);?>
            </td>  <!-- TOTAL VACCINE ALLOCATED JOHNSON_FIRST -->
            <td>
                <span class="label label-success">
                    {{ $total_johnson_a1_frst_prov }}
                    <?php session::put('total_johnson_a1_frst_excel',$total_johnson_a1_frst_prov);?>
                </span>   <!-- VACCINATED (A1) JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_johnson_a2_frst_prov }}
                    <?php session::put('total_johnson_a2_frst_excel',$total_johnson_a2_frst_prov);?>
                </span>  <!-- VACCINATED (A2) JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_johnson_a3_frst_prov }}
                    <?php session::put('total_johnson_a3_frst_excel',$total_johnson_a3_frst_prov);?>
                </span>  <!-- VACCINATED (A3) JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_johnson_a4_frst_prov }}
                    <?php session::put('total_johnson_a4_frst_excel',$total_johnson_a4_frst_prov);?>
                </span>  <!-- VACCINATED (A4) JOHNSON_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_johnson_a5_frst_prov }}
                      <?php session::put('total_johnson_a5_frst_excel',$total_johnson_a5_frst_prov);?>
                </span>  <!-- VACCINATED (A5) JOHNSON_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_johnson_b1_frst_prov }}
                      <?php session::put('total_johnson_b1_frst_excel',$total_johnson_b1_frst_prov);?>
                </span>  <!-- VACCINATED (B1) JOHNSON_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_johnson_b2_frst_prov }}
                      <?php session::put('total_johnson_b2_frst_excel',$total_johnson_b2_frst_prov);?>
                </span>  <!-- VACCINATED (B2) JOHNSON_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_johnson_b3_frst_prov }}
                      <?php session::put('total_johnson_b3_frst_excel',$total_johnson_b3_frst_prov);?>
                </span>  <!-- VACCINATED (B3) JOHNSON_FIRST -->
            </td>
            <td>
                  <span class="label label-success">
                    {{ $total_johnson_b4_frst_prov }}
                      <?php session::put('total_johnson_b4_frst_excel',$total_johnson_b4_frst_prov);?>
                </span>  <!-- VACCINATED (B4) JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_vcted_johnson_frst }}
                    <?php session::put('total_vcted_johnson_frst_excel',$total_vcted_johnson_frst);?>
                </span> <!-- TOTAL VACCINATED JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_mild_johnson_frst_prov }}
                    <?php session::put('total_mild_johnson_frst_excel',$total_mild_johnson_frst_prov);?>
                </span> <!-- MILD JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_srs_johnson_frst_prov }}
                    <?php session::put('total_srs_johnson_frst_excel',$total_srs_johnson_frst_prov);?>
                </span> <!-- SERIOUS JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_dfrd_johnson_frst_prov }}
                    <?php session::put('total_dfrd_johnson_frst_excel',$total_dfrd_johnson_frst_prov);?>
                </span> <!-- DEFERRED JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_rfsd_johnson_frst_prov }}
                    <?php session::put('total_rfsd_johnson_frst_excel',$total_rfsd_johnson_frst_prov);?>
                </span> <!-- REFUSED JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_wstge_johnson_frst_prov }}
                    <?php session::put('total_wstge_johnson_frst_excel',$total_wstge_johnson_frst_prov);?>
                </span> <!-- WASTAGE JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_p_cvrge_johnson_frst_prov,2) }}%
                    <?php session::put('total_p_cvrge_johnson_frst_excel',number_format($total_p_cvrge_johnson_frst_prov,2));?>
                </span> <!-- PERCENT_COVERAGE JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ number_format($total_c_rate_johnson_frst_prov,2) }}%
                    <?php session::put('total_c_rate_johnson_frst_excel',number_format($total_c_rate_johnson_frst_prov,2));?>
                </span> <!-- CONSUMPTION RATE JOHNSON_FIRST -->
            </td>
            <td>
                <span class="label label-success">
                    {{ $total_r_unvcted_frst_johnson_prov }}
                    <?php session::put('total_r_unvcted_frst_johnson_excel',$total_r_unvcted_frst_johnson_prov);?>
                </span> <!-- REMAINUNG UNVACCINATED JOHNSON_FIRST -->
            </td>
        </tr>
        <tr style="background-color: #9af5ee">
            <td style="color: black;">
                <span class="label label-warning">
                    {{ $total_johnson_a1_scnd_prov }}
                    <?php session::put('total_johnson_a1_scnd_excel',$total_johnson_a1_scnd_prov);?>
                </span>  <!-- VACCINATED (A1) JOHNSON_SECOND -->
            </td>
            <td style="color:black;">
                <span class="label label-warning">
                    {{ $total_johnson_a2_scnd_prov }}
                    <?php session::put('total_johnson_a2_scnd_excel',$total_johnson_a2_scnd_prov);?>
                </span>  <!-- VACCINATED (A2) JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_johnson_a3_scnd_prov }}
                    <?php session::put('total_johnson_a3_scnd_excel',$total_johnson_a3_scnd_prov);?>
                </span>  <!-- VACCINATED (A3) JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_johnson_a4_scnd_prov }}
                    <?php session::put('total_johnson_a4_scnd_excel',$total_johnson_a4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) JOHNSON_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_johnson_a5_scnd_prov }}
                     <?php session::put('total_johnson_a5_scnd_excel',$total_johnson_a5_scnd_prov);?>
                </span>  <!-- VACCINATED (A5) JOHNSON_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_johnson_b1_scnd_prov }}
                     <?php session::put('total_johnson_b1_scnd_excel',$total_johnson_b1_scnd_prov);?>
                </span>  <!-- VACCINATED (B1) JOHNSON_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_johnson_b2_scnd_prov }}
                     <?php session::put('total_johnson_b2_scnd_excel',$total_johnson_b2_scnd_prov);?>
                </span>  <!-- VACCINATED (B2) JOHNSON_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_johnson_b3_scnd_prov }}
                     <?php session::put('total_johnson_b3_scnd_excel',$total_johnson_b3_scnd_prov);?>
                </span>  <!-- VACCINATED (B3) JOHNSON_SECOND -->
            </td>
            <td>
                 <span class="label label-warning">
                    {{ $total_johnson_a4_scnd_prov }}
                     <?php session::put('total_johnson_b4_scnd_excel',$total_johnson_b4_scnd_prov);?>
                </span>  <!-- VACCINATED (A4) JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_vcted_johnson_second }}
                    <?php session::put('total_vcted_johnson_second_excel',$total_vcted_johnson_second);?>
                </span>  <!-- TOTAL VACCINATED JOHNSON_SECOND -->
            </td> <!-- 1-6 -->
            <td>
                <span class="label label-warning">
                    {{ $total_mild_johnson_scnd_prov }}
                    <?php session::put('total_mild_johnson_scnd_excel',$total_mild_johnson_scnd_prov);?>
                </span>  <!-- MILD JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_srs_johnson_scnd_prov }}
                    <?php session::put('total_srs_johnson_scnd_excel',$total_srs_johnson_scnd_prov);?>
                </span> <!-- SERIOUS JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_dfrd_johnson_scnd_prov }}
                    <?php session::put('total_dfrd_johnson_scnd_excel',$total_dfrd_johnson_scnd_prov);?>
                </span> <!-- DEFERRED JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_rfsd_johnson_scnd_prov }}
                    <?php session::put('total_rfsd_johnson_scnd_excel', $total_rfsd_johnson_scnd_prov);?>
                </span> <!-- REFUSED JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_wstge_johnson_scnd_prov }}
                    <?php session::put('total_wstge_johnson_scnd_excel', $total_wstge_johnson_scnd_prov);?>
                </span> <!-- WASTAGE JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_p_cvrge_johnson_scnd_prov,2)}}%
                    <?php session::put('total_p_cvrge_johnson_scnd_excel', number_format($total_p_cvrge_johnson_scnd_prov,2));?>
                </span> <!-- PERCENT_COVERAGE_JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ number_format($total_c_rate_johnson_scnd_prov,2)}}%
                    <?php session::put('total_c_rate_johnson_scnd_excel', number_format($total_c_rate_johnson_scnd_prov,2));?>
                </span> <!-- CONSUMPTION RATE JOHNSON_SECOND -->
            </td>
            <td>
                <span class="label label-warning">
                    {{ $total_r_unvcted_scnd_johnson_prov }}
                    <?php session::put('total_r_unvcted_scnd_johnson_excel',$total_r_unvcted_scnd_johnson_prov );?>
                </span> <!-- REMAINING UNVACCINATED JOHNSON_SECOND -->
            </td>
        </tr>
        </tbody>

        <tbody>
    <tr>
        <td>Total</td> <!-- 1-7 -->
        <td>{{ $total_e_pop_pfizer_a1_prov }}</td>
        <td>{{ $total_e_pop_pfizer_a2_prov }}</td>
        <td>{{ $total_e_pop_pfizer_a3_prov }}</td>
        <td>{{ $total_e_pop_pfizer_a4_prov }}</td>
        <td>{{ $total_e_pop_pfizer_a5_prov }}</td>
        <td>{{ $total_e_pop_pfizer_b1_prov }}</td>
        <td>{{ $total_e_pop_pfizer_b2_prov }}</td>
        <td>{{ $total_e_pop_pfizer_b3_prov }}</td>
        <td>{{ $total_e_pop_pfizer_b4_prov }}</td>
        <td>{{ $total_e_pop_pfizer_prov }}</td>
        <td>
           <b> {{ $total_vallocated_frst_prov }}
            <?php session::put('total_vallocated_frst_excel',$total_vallocated_frst_prov);?>
           </b>
        </td>  <!-- TOTAL VACCINE ALLOCATED FIRST -->
        <td>
            <b>
            {{ $total_vallocated_scnd_prov }}
            <?php session::put('total_vallocated_scnd_excel',$total_vallocated_scnd_prov);?>
            </b>
        </td> <!-- TOTAL VACCINE ALLOCATED SECOND -->
        <td>
            <b>
                {{ $total_vallocated }}
                <?php session::put('total_vallocated_excel',$total_vallocated);?>
            </b>  <!-- TOTAL VACCINE ALLOCATED  -->
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_a1_first }}
                <?php session::put('total_vcted_grand_a1_first_excel',$total_vcted_grand_a1_first);?>
            </b> <!-- TOTAL VACCINATED (A1) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_a2_first }}
                <?php session::put('total_vcted_grand_a2_first_excel',$total_vcted_grand_a2_first );?>
            </b>  <!-- TOTAL VACCINATED (A2) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_a3_first }}
                <?php session::put('total_vcted_grand_a3_first_excel',$total_vcted_grand_a3_first);?>
            </b><!-- TOTAL VACCINATED (A3) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_a4_first }}
                <?php session::put('total_vcted_grand_a4_first_excel',$total_vcted_grand_a4_first);?>
            </b>  <!-- TOTAL VACCINATED (A4) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_a5_first }}
                <?php session::put('total_vcted_grand_a5_first_excel',$total_vcted_grand_a5_first);?>
            </b>  <!-- TOTAL VACCINATED (A5) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_b1_first }}
                <?php session::put('total_vcted_grand_b1_first_excel',$total_vcted_grand_b1_first);?>
            </b>  <!-- TOTAL VACCINATED (B1) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_b2_first }}
                <?php session::put('total_vcted_grand_b2_first_excel',$total_vcted_grand_b2_first);?>
            </b>  <!-- TOTAL VACCINATED (B2) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_b3_first }}
                <?php session::put('total_vcted_grand_b3_first_excel',$total_vcted_grand_b3_first);?>
            </b>  <!-- TOTAL VACCINATED (B3) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_grand_b4_first }}
                <?php session::put('total_vcted_grand_b4_first_excel',$total_vcted_grand_b4_first);?>
            </b>  <!-- TOTAL VACCINATED (B4) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_vcted_overall_frst }}
                <?php session::put('total_vcted_overall_frst_excel',$total_vcted_overall_frst);?>
            </b>  <!-- TOTAL VACCINATED OVERALL FIRST -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_mild_overall_frst }}
                <?php session::put('total_mild_overall_frst_excel',$total_mild_overall_frst);?>
            </b>  <!-- TOTAL MILD OVERALL FIRST-->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_srs_overall_frst }}
                <?php session::put('total_srs_overall_frst_excel',$total_srs_overall_frst);?>
            </b>  <!-- TOTAL SERIOUS OVERALL FIRST -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_dfrd_overall_frst }}
                <?php session::put('total_dfrd_overall_frst_excel',$total_dfrd_overall_frst );?>
            </b>  <!-- TOTAL DEFERRED OVERALL FIRST -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_rfsd_overall_frst }}
                <?php session::put('total_rfsd_overall_frst_excel',$total_rfsd_overall_frst);?>
            </b>  <!-- TOTAL REFUSED OVERALL FIRST-->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_wstge_overall_frst }}
                <?php session::put('total_wstge_overall_frst_excel',$total_wstge_overall_frst);?>
            </b>  <!-- TOTAL WASTAGE OVREALL FIRST-->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ number_format($total_p_cvrge_frst_prov,2) }}%
                <?php session::put('total_p_cvrge_frst_excel',number_format($total_p_cvrge_frst_prov,2));?>
            </b>  <!-- TOTAL PERCENT_COVERAGE -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ number_format($total_c_rate_frst_prov,2) }}%
                <?php session::put('total_c_rate_frst_excel',number_format($total_c_rate_frst_prov,2));?>
            </b>  <!-- TOTAL CONSUMPTION RATE -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">
                {{ $total_r_unvcted_all_frst_prov }}
                <?php session::put('total_r_unvcted_all_frst_excel',$total_r_unvcted_all_frst_prov);?>
            </b>  <!-- TOTAL REMAINUNG UNVACCINATED  -->
        </td>
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
                {{ $total_vcted_grand_a1_second }}
                <?php session::put('total_vcted_grand_a1_second_excel',$total_vcted_grand_a1_second);?>
            </b> <!-- TOTAL VACCINATED GRAND A1 SECOND DOSE -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_a2_second }}
                <?php session::put('total_vcted_grand_a2_second_excel',$total_vcted_grand_a2_second);?>
            </b><!-- TOTAL VACCINATED GRAND A2 SECOND DOSE -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_a3_second }}
                <?php session::put('total_vcted_grand_a3_second_excel',$total_vcted_grand_a3_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A3 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_a4_second }}
                <?php session::put('total_vcted_grand_a4_second_excel',$total_vcted_grand_a4_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A4 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_a5_second }}
                <?php session::put('total_vcted_grand_a5_second_excel',$total_vcted_grand_a5_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A5 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_b1_second }}
                <?php session::put('total_vcted_grand_b1_second_excel',$total_vcted_grand_b1_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A1 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_b2_second }}
                <?php session::put('total_vcted_grand_b2_second_excel',$total_vcted_grand_b2_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A2 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_b3_second }}
                <?php session::put('total_vcted_grand_b3_second_excel',$total_vcted_grand_b3_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A3 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_grand_b4_second }}
                <?php session::put('total_vcted_grand_b4_second_excel',$total_vcted_grand_b4_second);?>
            </b>  <!-- TOTAL VACCINATED GRAND A4 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_vcted_overall_second }}
                <?php session::put('total_vcted_overall_second_excel',$total_vcted_overall_second);?>
            </b> <!-- TOTAL VACCINATED OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_mild_overall_scnd }}
                <?php session::put('total_mild_overall_scnd_excel',$total_mild_overall_scnd);?>
            </b> <!-- TOTAL MILD OVERALL SECOND-->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_srs_overall_scnd }}
                <?php session::put('total_srs_overall_scnd_excel',$total_srs_overall_scnd);?>
            </b> <!-- TOTAL SERIOUS OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_dfrd_overall_scnd }}
                <?php session::put('total_dfrd_overall_scnd_excel',$total_dfrd_overall_scnd);?>
            </b> <!-- TOTAL DEFERRED OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_rfsd_overall_frst }}
                <?php session::put('total_rfsd_overall_frst_excel',$total_rfsd_overall_frst);?>
            </b> <!-- TOTAL REFUSED OVERALL SECOND-->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_wstge_overall_scnd }}
                <?php session::put('total_wstge_overall_scnd_excel',$total_wstge_overall_scnd);?>
            </b> <!-- TOTAL WASTAGE OVERALL SECOND-->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ number_format($total_p_cvrge_scnd_prov,2) }}%
                <?php session::put('total_p_cvrge_scnd_excel',number_format($total_p_cvrge_scnd_prov,2));?>
            </b> <!-- TOTAL PERCENT_COVERAGE OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ number_format($total_c_rate_scnd_prov,2) }}%
                <?php session::put('total_c_rate_scnd_excel',number_format($total_c_rate_scnd_prov,2));?>
            </b> <!-- TOTAL CONSUMPTION RATE OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">
                {{ $total_r_unvcted_all_scnd_prov }}
                <?php session::put('total_r_unvcted_all_scnd_excel',$total_r_unvcted_all_scnd_prov);?>
            </b> <!-- TOTAL REMAINING UNVACCIANTED  OVERALL SECOND  -->
        </td>
    </tr>
    </tbody>
</table>
