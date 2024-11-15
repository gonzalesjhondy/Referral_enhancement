<?php

namespace App\Http\Controllers\Vaccine;

use App\Facility;
use App\Muncity;
use App\Province;
use App\VaccineAccomplished;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VaccineController extends Controller
{

    public $sinovac_bohol_first, $sinovac_cebu_first, $sinovac_negros_first, $sinovac_siquijor_first, $sinovac_cebu_facility_first, $sinovac_mandaue_facility_first, $sinovac_lapu_facility_first;
    public $sinovac_bohol_second, $sinovac_cebu_second, $sinovac_negros_second, $sinovac_siquijor_second, $sinovac_cebu_facility_second, $sinovac_mandaue_facility_second, $sinovac_lapu_facility_second;
    public $astra_bohol_first, $astra_cebu_first, $astra_negros_first, $astra_siquijor_first, $astra_cebu_facility_first, $astra_mandaue_facility_first, $astra_lapu_facility_first;
    public $astra_bohol_second, $astra_cebu_second, $astra_negros_second, $astra_siquijor_second, $astra_cebu_facility_second, $astra_mandaue_facility_second, $astra_lapu_facility_second;
    public $pfizer_bohol_first, $pfizer_cebu_first, $pfizer_negros_first, $pfizer_siquijor_first, $pfizer_cebu_facility_first, $pfizer_mandaue_facility_first, $pfizer_lapu_facility_first;
    public $pfizer_bohol_second, $pfizer_cebu_second, $pfizer_negros_second, $pfizer_siquijor_second, $pfizer_cebu_facility_second, $pfizer_mandaue_facility_second, $pfizer_lapu_facility_second;
    public $sputnikv_bohol_first, $sputnikv_cebu_first, $sputnikv_negros_first, $sputnikv_siquijor_first, $sputnikv_cebu_facility_first, $sputnikv_mandaue_facility_first, $sputnikv_lapu_facility_first;
    public $sputnikv_bohol_second, $sputnikv_cebu_second, $sputnikv_negros_second, $sputnikv_siquijor_second, $sputnikv_cebu_facility_second, $sputnikv_mandaue_facility_second, $sputnikv_lapu_facility_second;
    public $moderna_bohol_first, $moderna_cebu_first, $moderna_negros_first, $moderna_siquijor_first, $moderna_cebu_facility_first, $moderna_mandaue_facility_first, $moderna_lapu_facility_first;
    public $moderna_bohol_second, $moderna_cebu_second, $moderna_negros_second, $moderna_siquijor_second, $moderna_cebu_facility_second, $moderna_mandaue_facility_second, $moderna_lapu_facility_second;
    public $johnson_bohol_first, $johnson_cebu_first, $johnson_negros_first, $johnson_siquijor_first, $johnson_cebu_facility_first, $johnson_mandaue_facility_first, $johnson_lapu_facility_first;
    public $johnson_bohol_second, $johnson_cebu_second, $johnson_negros_second, $johnson_siquijor_second, $johnson_cebu_facility_second, $johnson_mandaue_facility_second, $johnson_lapu_facility_second;
    public $sinovac_region_first, $sinovac_region_second, $astra_region_first, $astra_region_second, $sputnikv_region_first, $sputnikv_region_second, $pfizer_region_first, $pfizer_region_second,
        $moderna_region_first, $moderna_region_second, $johnson_region_first, $johnson_region_second;
    public $total_bohol_first, $total_cebu_first, $total_negros_first, $total_siquijor_first, $total_cebu_facility_first, $total_mandaue_facility_first, $total_lapu_facility_first, $total_region_first; //TOTAL FIRST
    public $total_bohol_second, $total_cebu_second, $total_negros_second, $total_siquijor_second, $total_cebu_facility_second, $total_mandaue_facility_second, $total_lapu_facility_second, $total_region_second; //TOTAL FIRST
    public $eli_pop_bohol, $eli_pop_cebu, $eli_pop_negros, $eli_pop_siquijor, $eli_pop_cebu_facility, $eli_pop_mandaue_facility, $eli_pop_lapu_facility; //ELIGIBLE POP SINOVAC

    public $vcted_sinovac_bohol_first, $vcted_sinovac_cebu_first, $vcted_sinovac_negros_first, $vcted_sinovac_siquijor_first,
        $vcted_sinovac_cebu_facility_first, $vcted_sinovac_mandaue_facility_first, $vcted_sinovac_lapu_facility_first; //VACCINATED_SINOVAC_FIRST
    public $vcted_sinovac_bohol_second, $vcted_sinovac_cebu_second, $vcted_sinovac_negros_second, $vcted_sinovac_siquijor_second,
        $vcted_sinovac_cebu_facility_second, $vcted_sinovac_mandaue_facility_second, $vcted_sinovac_lapu_facility_second; //VACCINATED_SINOVAC_SECOND
    public $vcted_astra_bohol_first, $vcted_astra_cebu_first, $vcted_astra_negros_first, $vcted_astra_siquijor_first,
        $vcted_astra_cebu_facility_first, $vcted_astra_mandaue_facility_first, $vcted_astra_lapu_facility_first; //VACCINATED_ASTRA_FIRST
    public $vcted_astra_bohol_second, $vcted_astra_cebu_second, $vcted_astra_negros_second, $vcted_astra_siquijor_second,
        $vcted_astra_cebu_facility_second, $vcted_astra_mandaue_facility_second, $vcted_astra_lapu_facility_second; //VACCINATED_SINOVAC_SECOND
    public $vcted_pfizer_bohol_first, $vcted_pfizer_cebu_first, $vcted_pfizer_negros_first, $vcted_pfizer_siquijor_first,
        $vcted_pfizer_cebu_facility_first, $vcted_pfizer_mandaue_facility_first, $vcted_pfizer_lapu_facility_first; //VACCINATED_PFIZER_FIRST
    public $vcted_pfizer_bohol_second, $vcted_pfizer_cebu_second, $vcted_pfizer_negros_second, $vcted_pfizer_siquijor_second,
        $vcted_pfizer_cebu_facility_second, $vcted_pfizer_mandaue_facility_second, $vcted_pfizer_lapu_facility_second;  //VACCINATED_PFIZER_SECOND
    public $vcted_sputnikv_bohol_first, $vcted_sputnikv_cebu_first, $vcted_sputnikv_negros_first, $vcted_sputnikv_siquijor_first,
        $vcted_sputnikv_cebu_facility_first, $vcted_sputnikv_mandaue_facility_first, $vcted_sputnikv_lapu_facility_first; //VACCINATED_SPUTNIKV_FIRST
    public $vcted_sputnikv_bohol_second, $vcted_sputnikv_cebu_second, $vcted_sputnikv_negros_second, $vcted_sputnikv_siquijor_second,
        $vcted_sputnikv_cebu_facility_second, $vcted_sputnikv_mandaue_facility_second, $vcted_sputnikv_lapu_facility_second;  //VACCINATED_SPUTNIKV_SECOND
    public $vcted_moderna_bohol_first, $vcted_moderna_cebu_first, $vcted_moderna_negros_first, $vcted_moderna_siquijor_first,
        $vcted_moderna_cebu_facility_first, $vcted_moderna_mandaue_facility_first, $vcted_moderna_lapu_facility_first; //VACCINATED_MODERNA_FIRST
    public $vcted_moderna_bohol_second, $vcted_moderna_cebu_second, $vcted_moderna_negros_second, $vcted_moderna_siquijor_second,
        $vcted_moderna_cebu_facility_second, $vcted_moderna_mandaue_facility_second, $vcted_moderna_lapu_facility_second;  //VACCINATED_MODERNA_SECOND
    public $vcted_johnson_bohol_first, $vcted_johnson_cebu_first, $vcted_johnson_negros_first, $vcted_johnson_siquijor_first,
        $vcted_johnson_cebu_facility_first, $vcted_johnson_mandaue_facility_first, $vcted_johnson_lapu_facility_first; //VACCINATED_JOHNSON_FIRST
    public $vcted_johnson_bohol_second, $vcted_johnson_cebu_second, $vcted_johnson_negros_second, $vcted_johnson_siquijor_second,
        $vcted_johnson_cebu_facility_second, $vcted_johnson_mandaue_facility_second, $vcted_johnson_lapu_facility_second;  //VACCINATED_JOHNSON_SECOND
    public $total_vcted_first_bohol, $total_vcted_first_cebu, $total_vcted_first_negros, $total_vcted_first_siquijor,
        $total_vcted_cebu_facility_first, $total_vcted_mandaue_facility_first, $total_vcted_lapu_facility_first;   //TOTAL VACCINATED_FIRST
    public $total_vcted_second_bohol, $total_vcted_second_cebu, $total_vcted_second_negros, $total_vcted_second_siquijor,
        $total_vcted_cebu_facility_second, $total_vcted_mandaue_facility_second, $total_vcted_lapu_facility_second;   //TOTAL VACCINATED_SECOND
    public $region_sinovac_first_dose, $region_sinovac_second_dose, $region_astra_first_dose, $region_astra_second_dose,
        $region_pfizer_first_dose, $region_pfizer_second_dose,$region_sputnikv_first_dose, $region_sputnikv_second_dose,
        $region_moderna_first_dose, $region_moderna_second_dose, $region_johnson_first_dose, $region_johnson_second_dose; //REGION VACCINATED
    public $first_dose_total, $second_dose_total;   //TOTAL DOSE
    public $total_elipop_region;  //TOTAL ELI POP
    public $p_cvrge_sinovac_bohol_first, $p_cvrge_sinovac_cebu_first, $p_cvrge_sinovac_negros_first, $p_cvrge_sinovac_siquijor_first,
        $p_cvrge_sinovac_cebu_facility_first, $p_cvrge_sinovac_mandaue_facility_first, $p_cvrge_sinovac_lapu_facility_first;   //PERCENT COVERAGE SINOVAC FIRST
    public $p_cvrge_astra_bohol_first, $p_cvrge_astra_cebu_first, $p_cvrge_astra_negros_first, $p_cvrge_astra_siquijor_first,
        $p_cvrge_astra_cebu_facility_first, $p_cvrge_astra_mandaue_facility_first, $p_cvrge_astra_lapu_facility_first;   //PERCENT COVERAGE ASTRA FIRST
    public $p_cvrge_pfizer_bohol_first, $p_cvrge_pfizer_cebu_first, $p_cvrge_pfizer_negros_first, $p_cvrge_pfizer_siquijor_first,
        $p_cvrge_pfizer_cebu_facility_first, $p_cvrge_pfizer_mandaue_facility_first, $p_cvrge_pfizer_lapu_facility_first;   //PERCENT COVERAGE PFIZER FIRST
    public $p_cvrge_sputnikv_bohol_first, $p_cvrge_sputnikv_cebu_first, $p_cvrge_sputnikv_negros_first, $p_cvrge_sputnikv_siquijor_first,
        $p_cvrge_sputnikv_cebu_facility_first, $p_cvrge_sputnikv_mandaue_facility_first, $p_cvrge_sputnikv_lapu_facility_first;   //PERCENT COVERAGE SPUTNIKV FIRST
    public $p_cvrge_moderna_bohol_first, $p_cvrge_moderna_cebu_first, $p_cvrge_moderna_negros_first, $p_cvrge_moderna_siquijor_first,
        $p_cvrge_moderna_cebu_facility_first, $p_cvrge_moderna_mandaue_facility_first, $p_cvrge_moderna_lapu_facility_first;   //PERCENT COVERAGE MODERNA FIRST
    public $p_cvrge_johnson_bohol_first, $p_cvrge_johnson_cebu_first, $p_cvrge_johnson_negros_first, $p_cvrge_johnson_siquijor_first,
        $p_cvrge_johnson_cebu_facility_first, $p_cvrge_johnson_mandaue_facility_first, $p_cvrge_johnson_lapu_facility_first;   //PERCENT COVERAGE JOHNSON FIRST
    public $total_p_cvrge_bohol_first, $total_p_cvrge_cebu_first, $total_p_cvrge_negros_first, $total_p_cvrge_siquijor_first,
        $total_p_cvrge_cebu_facility_first, $total_p_cvrge_mandaue_facility_first, $total_p_cvrge_lapu_facility_first;  //TOTAL_PERCENT_COVERAGE_FIRST

    public $p_cvrge_sinovac_bohol_second, $p_cvrge_sinovac_cebu_second, $p_cvrge_sinovac_negros_second, $p_cvrge_sinovac_siquijor_second,
        $p_cvrge_sinovac_cebu_facility_second, $p_cvrge_sinovac_mandaue_facility_second, $p_cvrge_sinovac_lapu_facility_second;   //PERCENT COVERAGE SINOVAC SECOND
    public $p_cvrge_astra_bohol_second, $p_cvrge_astra_cebu_second, $p_cvrge_astra_negros_second, $p_cvrge_astra_siquijor_second,
        $p_cvrge_astra_cebu_facility_second, $p_cvrge_astra_mandaue_facility_second, $p_cvrge_astra_lapu_facility_second;   //PERCENT COVERAGE ASTRA SECOND
    public $p_cvrge_pfizer_bohol_second, $p_cvrge_pfizer_cebu_second, $p_cvrge_pfizer_negros_second, $p_cvrge_pfizer_siquijor_second,
        $p_cvrge_pfizer_cebu_facility_second, $p_cvrge_pfizer_mandaue_facility_second, $p_cvrge_pfizer_lapu_facility_second;   //PERCENT COVERAGE PFIZER SECOND
    public $p_cvrge_sputnikv_bohol_second, $p_cvrge_sputnikv_cebu_second, $p_cvrge_sputnikv_negros_second, $p_cvrge_sputnikv_siquijor_second,
        $p_cvrge_sputnikv_cebu_facility_second, $p_cvrge_sputnikv_mandaue_facility_second, $p_cvrge_sputnikv_lapu_facility_second;   //PERCENT COVERAGE SPUTNIKV SECOND
    public $p_cvrge_moderna_bohol_second, $p_cvrge_moderna_cebu_second, $p_cvrge_moderna_negros_second, $p_cvrge_moderna_siquijor_second,
        $p_cvrge_moderna_cebu_facility_second, $p_cvrge_moderna_mandaue_facility_second, $p_cvrge_moderna_lapu_facility_second;   //PERCENT COVERAGE MODERNA SECOND
    public $p_cvrge_johnson_bohol_second, $p_cvrge_johnson_cebu_second, $p_cvrge_johnson_negros_second, $p_cvrge_johnson_siquijor_second,
        $p_cvrge_johnson_cebu_facility_second, $p_cvrge_johnson_mandaue_facility_second, $p_cvrge_johnson_lapu_facility_second;   //PERCENT COVERAGE JOHNSON SECOND

    public $total_p_cvrge_bohol_second, $total_p_cvrge_cebu_second, $total_p_cvrge_negros_second, $total_p_cvrge_siquijor_second,
        $total_p_cvrge_cebu_facility_second, $total_p_cvrge_mandaue_facility_second, $total_p_cvrge_lapu_facility_second;  //TOTAL_PERCENT_COVERAGE_SECOND
    public $total_p_cvrge_sinovac_region_first, $total_p_cvrge_astra_region_first,  $total_p_cvrge_pfizer_region_first, $total_p_cvrge_sputnikv_region_first,
        $total_p_cvrge_moderna_region_first, $total_p_cvrge_johnson_region_first, $total_p_cvrge_region_first; //TOTAL_REGION_COVERAGE_FIRST
    public $total_p_cvrge_sinovac_region_second, $total_p_cvrge_astra_region_second,  $total_p_cvrge_pfizer_region_second, $total_p_cvrge_sputnikv_region_second,
        $total_p_cvrge_moderna_region_second, $total_p_cvrge_johnson_region_second, $total_p_cvrge_region_second; //TOTAL_REGION_COVERAGE_SECOND
    public $wastage_sinovac_bohol_first, $wastage_sinovac_cebu_first, $wastage_sinovac_negros_first, $wastage_sinovac_siquijor_first,
        $wastage_sinovac_cebu_facility_first, $wastage_sinovac_mandaue_facility_first, $wastage_sinovac_lapu_facility_first;  //WASTAGE_SINOVAC
    public $wastage_astra_bohol_first, $wastage_astra_cebu_first, $wastage_astra_negros_first, $wastage_astra_siquijor_first,
        $wastage_astra_cebu_facility_first, $wastage_astra_mandaue_facility_first, $wastage_astra_lapu_facility_first;  //WASTAGE_ASTRA
    public $wastage_pfizer_bohol_first, $wastage_pfizer_cebu_first, $wastage_pfizer_negros_first, $wastage_pfizer_siquijor_first,
        $wastage_pfizer_cebu_facility_first, $wastage_pfizer_mandaue_facility_first, $wastage_pfizer_lapu_facility_first;  //WASTAGE_PFIZER
    public $wastage_sputnikv_bohol_first, $wastage_sputnikv_cebu_first, $wastage_sputnikv_negros_first, $wastage_sputnikv_siquijor_first,
        $wastage_sputnikv_cebu_facility_first, $wastage_sputnikv_mandaue_facility_first, $wastage_sputnikv_lapu_facility_first;  //WASTAGE_SPUTNIKV
    public $wastage_moderna_bohol_first, $wastage_moderna_cebu_first, $wastage_moderna_negros_first, $wastage_moderna_siquijor_first,
        $wastage_moderna_cebu_facility_first, $wastage_moderna_mandaue_facility_first, $wastage_moderna_lapu_facility_first;  //WASTAGE_MODERNA
    public $wastage_johnson_bohol_first, $wastage_johnson_cebu_first, $wastage_johnson_negros_first, $wastage_johnson_siquijor_first,
        $wastage_johnson_cebu_facility_first, $wastage_johnson_mandaue_facility_first, $wastage_johnson_lapu_facility_first;  //WASTAGE_JOHNSON

    public $total_wastage_bohol, $total_wastage_cebu, $total_wastage_negros, $total_wastage_siquijor,
        $total_wastage_cebu_facility, $total_wastage_mandaue_facility, $total_wastage_lapu_facility; //TOTAL_WASTAGE
    public $wastage_sinovac_first, $wastage_astra_first, $wastage_pfizer_first, $wastage_sputnikv_first, $wastage_moderna_first, $wastage_johnson_first , $wastage_region;  //TOTAL_WASTAGE2
    public $refused_first_bohol, $refused_first_cebu, $refused_first_negros, $refused_first_siquijor,
        $refused_cebu_facility_first, $refused_mandaue_facility_first, $refused_lapu_facility_first;  //REFUSED_FIRST
    public $refused_second_bohol, $refused_second_cebu, $refused_second_negros, $refused_second_siquijor,
        $refused_cebu_facility_second, $refused_mandaue_facility_second, $refused_lapu_facility_second;  //REFUSED_SECOND
    public $total_refusal_first, $total_refusal_second;  //TOTAL REFUSAL
    public $deferred_first_bohol, $deferred_first_cebu, $deferred_first_negros, $deferred_first_siquijor,
        $deferred_cebu_facility_first, $deferred_mandaue_facility_first, $deferred_lapu_facility_first; //DEFERRED_FIRST
    public $deferred_second_bohol, $deferred_second_cebu, $deferred_second_negros, $deferred_second_siquijor,
        $deferred_cebu_facility_second, $deferred_mandaue_facility_second, $deferred_lapu_facility_second; //DEFERRED_SECOND
    public $total_deferred_first, $total_deferred_second; //TOTAL DEFERRED
    public $c_rate_sinovac_bohol_first, $c_rate_sinovac_cebu_first, $c_rate_sinovac_negros_first, $c_rate_sinovac_siquijor_first,
        $c_rate_sinovac_cebu_facility_first, $c_rate_sinovac_mandaue_facility_first, $c_rate_sinovac_lapu_facility_first; //CONSUMPTION_RATE_SINOVAC_FIRST
    public $c_rate_astra_bohol_first, $c_rate_astra_cebu_first, $c_rate_astra_negros_first, $c_rate_astra_siquijor_first,
        $c_rate_astra_cebu_facility_first, $c_rate_astra_mandaue_facility_first, $c_rate_astra_lapu_facility_first; //CONSUMPTION_RATE_ASTRA_FIRST
    public $c_rate_pfizer_bohol_first, $c_rate_pfizer_cebu_first, $c_rate_pfizer_negros_first, $c_rate_pfizer_siquijor_first,
        $c_rate_pfizer_cebu_facility_first, $c_rate_pfizer_mandaue_facility_first, $c_rate_pfizer_lapu_facility_first; //CONSUMPTION_RATE_PFIZER_FIRST
    public $c_rate_sputnikv_bohol_first, $c_rate_sputnikv_cebu_first, $c_rate_sputnikv_negros_first, $c_rate_sputnikv_siquijor_first,
        $c_rate_sputnikv_cebu_facility_first, $c_rate_sputnikv_mandaue_facility_first, $c_rate_sputnikv_lapu_facility_first; //CONSUMPTION_RATE_SPUTNIKV_FIRST
    public $c_rate_moderna_bohol_first, $c_rate_moderna_cebu_first, $c_rate_moderna_negros_first, $c_rate_moderna_siquijor_first,
        $c_rate_moderna_cebu_facility_first, $c_rate_moderna_mandaue_facility_first, $c_rate_moderna_lapu_facility_first; //CONSUMPTION_RATE_MODERNA_FIRST
    public $c_rate_johnson_bohol_first, $c_rate_johnson_cebu_first, $c_rate_johnson_negros_first, $c_rate_johnson_siquijor_first,
        $c_rate_johnson_cebu_facility_first, $c_rate_johnson_mandaue_facility_first, $c_rate_johnson_lapu_facility_first; //CONSUMPTION_RATE_JOHNSON_FIRST

    public $total_c_rate_bohol_first, $total_c_rate_cebu_first, $total_c_rate_negros_first, $total_c_rate_siquijor_first,
        $total_c_rate_cebu_facility_first, $total_c_rate_mandaue_facility_first, $total_c_rate_lapu_facility_first; //TOTAL_CONSUMPTION_RATE_FIRST
    public $c_rate_sinovac_bohol_second, $c_rate_sinovac_cebu_second, $c_rate_sinovac_negros_second, $c_rate_sinovac_siquijor_second,
        $c_rate_sinovac_cebu_facility_second, $c_rate_sinovac_mandaue_facility_second, $c_rate_sinovac_lapu_facility_second; //CONSUMPTION_RATE_SINOVAC_SECOND
    public $c_rate_astra_bohol_second, $c_rate_astra_cebu_second, $c_rate_astra_negros_second, $c_rate_astra_siquijor_second,
        $c_rate_astra_cebu_facility_second, $c_rate_astra_mandaue_facility_second, $c_rate_astra_lapu_facility_second; //CONSUMPTION_RATE_ASTRA_SECOND
    public $c_rate_pfizer_bohol_second, $c_rate_pfizer_cebu_second, $c_rate_pfizer_negros_second, $c_rate_pfizer_siquijor_second,
        $c_rate_pfizer_cebu_facility_second, $c_rate_pfizer_mandaue_facility_second, $c_rate_pfizer_lapu_facility_second; //CONSUMPTION_RATE_FPIZER_SECOND
    public $c_rate_sputnikv_bohol_second, $c_rate_sputnikv_cebu_second, $c_rate_sputnikv_negros_second, $c_rate_sputnikv_siquijor_second,
        $c_rate_sputnikv_cebu_facility_second, $c_rate_sputnikv_mandaue_facility_second, $c_rate_sputnikv_lapu_facility_second; //CONSUMPTION_RATE_SPUTNIKV_SECOND
    public $c_rate_moderna_bohol_second, $c_rate_moderna_cebu_second, $c_rate_moderna_negros_second, $c_rate_moderna_siquijor_second,
        $c_rate_moderna_cebu_facility_second, $c_rate_moderna_mandaue_facility_second, $c_rate_moderna_lapu_facility_second; //CONSUMPTION_RATE_MODERNA_SECOND
    public $c_rate_johnson_bohol_second, $c_rate_johnson_cebu_second, $c_rate_johnson_negros_second, $c_rate_johnson_siquijor_second,
        $c_rate_johnson_cebu_facility_second, $c_rate_johnson_mandaue_facility_second, $c_rate_johnson_lapu_facility_second; //CONSUMPTION_RATE_JOHNSON_SECOND

    public $total_c_rate_bohol_second, $total_c_rate_cebu_second, $total_c_rate_negros_second, $total_c_rate_siquijor_second,
        $total_c_rate_cebu_facility_second, $total_c_rate_mandaue_facility_second, $total_c_rate_lapu_facility_second; //TOTAL_CONSUMPTION_RATE_SECOND
    public $c_rate_region_sinovac_first, $c_rate_region_astra_first, $c_rate_region_pfizer_first, $c_rate_region_sputnikv_first , $c_rate_region_moderna_first, $c_rate_region_johnson_first ; //TOTAL_CONSUMPTION_RATE_REGION_FIRST
    public $c_rate_region_sinovac_second, $c_rate_region_astra_second,$c_rate_region_pfizer_second, $c_rate_region_sputnikv_second, $c_rate_region_moderna_second, $c_rate_region_johnson_second; //TOTAL_CONSUMPTION_RATE_REGION_SECOND
    public $total_c_rate_region_first; //TOTAL_CONSUMPTION_RATE_FIRST
    public $total_c_rate_region_second; //TOTAL_CONSUMPTION_RATE_SECOND
    public $priority_set;
    //for grand variable

    public $data_facility;  //DATA FACILITY
    public $a1_target_facility, $a2_target_facility, $a3_target_facility, $a4_target_facility, $a5_target_facility, $b1_target_facility, $b2_target_facility,$b3_target_facility, $b4_target_facility; //TARGET FACILITY
    public $a1_completion_facility, $a2_completion_facility, $a3_completion_facility, $a4_completion_facility, $a5_completion_facility, $b1_completion_facility, $b2_completion_facility, $b3_completion_facility, $b4_completion_facility; //COMPLETION FACILITY
    public $a1_vaccinated_facility ,  $a2_vaccinated_facility, $a3_vaccinated_facility, $a4_vaccinated_facility, $a5_vaccinated_facility, $b1_vaccinated_facility, $b2_vaccinated_facility, $b3_vaccinated_facility, $b4_vaccinated_facility; //VACCINATED FACILITY
    public $sinovac_allocated_facility ,  $astra_allocated_facility, $pfizer_allocated_facility, $sputnikv_allocated_facility, $moderna_allocated_facility, $johnson_allocated_facility ; //VACCINATED FACILITY
    public $sinovac_completion ,  $astra_completion, $pfizer_completion, $sputnikv_completion, $moderna_completion, $johnson_completion ; //VACCINATED FACILITY


    public function index(Request $request)
    {
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = '2021-03-01 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $a1_target = Muncity::select(DB::raw("sum(coalesce(a1,0)) as a1_target"))->first()->a1_target;
        $a2_target = Muncity::select(DB::raw("sum(coalesce(a2,0)) as a2_target"))->first()->a2_target;
        $a3_target = Muncity::select(DB::raw("sum(coalesce(a3,0)) as a3_target"))->first()->a3_target;
        $a4_target = Muncity::select(DB::raw("sum(coalesce(a4,0)) as a4_target"))->first()->a4_target;
        $a5_target = Muncity::select(DB::raw("sum(coalesce(a5,0)) as a5_target"))->first()->a5_target;
        $b1_target = Muncity::select(DB::raw("sum(coalesce(b1,0)) as b1_target"))->first()->b1_target;
        $b2_target = Muncity::select(DB::raw("sum(coalesce(b2,0)) as b2_target"))->first()->b2_target;
        $b3_target = Muncity::select(DB::raw("sum(coalesce(b3,0)) as b3_target"))->first()->b3_target;
        $b4_target = Muncity::select(DB::raw("sum(coalesce(b4,0)) as b4_target"))->first()->b4_target;

        $a1_target_facility = Facility::select(DB::raw("sum(coalesce(a1,0)) as a1_target_facility"))->first()->a1_target_facility;
        $a2_target_facility = Facility::select(DB::raw("sum(coalesce(a2,0)) as a2_target_facility"))->first()->a2_target_facility;
        $a3_target_facility = Facility::select(DB::raw("sum(coalesce(a3,0)) as a3_target_facility"))->first()->a3_target_facility;
        $a4_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as a4_target_facility"))->first()->a4_target_facility;
        $a5_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as a5_target_facility"))->first()->a5_target_facility;
        $b1_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as b1_target_facility"))->first()->b1_target_facility;
        $b2_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as b2_target_facility"))->first()->b2_target_facility;
        $b3_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as b3_target_facility"))->first()->b3_target_facility;
        $b4_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as b4_target_facility"))->first()->b4_target_facility;

        $a1_target = $a1_target + $a1_target_facility;
        $a2_target = $a2_target + $a2_target_facility;
        $a3_target = $a3_target + $a3_target_facility;
        $a4_target = $a4_target + $a4_target_facility;
        $a5_target = $a5_target + $a5_target_facility;
        $b1_target = $b1_target + $b1_target_facility;
        $b2_target = $b2_target + $b2_target_facility;
        $b3_target = $b3_target + $b3_target_facility;
        $b4_target = $b4_target + $b4_target_facility;

        $a1_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a1_completion"))->where("priority","a1")->first()->a1_completion;
        $a2_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a2_completion"))->where("priority","a2")->first()->a2_completion;
        $a3_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a3_completion"))->where("priority","a3")->first()->a3_completion;
        $a4_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a4_completion"))->where("priority","a4")->first()->a4_completion;
        $a5_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a5_completion"))->where("priority","a5")->first()->a5_completion;
        $b1_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b1_completion"))->where("priority","b1")->first()->b1_completion;
        $b2_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b2_completion"))->where("priority","b2")->first()->b2_completion;
        $b3_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b3_completion"))->where("priority","b3")->first()->b3_completion;
        $b4_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b4_completion"))->where("priority","b4")->first()->b4_completion;


        $a1_completion = number_format($a1_completion / $a1_target * 100,2);
        $a2_completion = number_format($a2_completion / $a2_target * 100,2);
        $a3_completion = number_format($a3_completion / $a3_target * 100,2);
        $a4_completion = number_format($a4_completion / $a4_target * 100,2);
        $a5_completion = number_format($a5_completion / $a5_target * 100,2);
        $b1_completion = number_format($b1_completion / $b1_target * 100,2);
        $b2_completion = number_format($b2_completion / $b2_target * 100,2);
        $b3_completion = number_format($b3_completion / $b3_target * 100,2);
        $b4_completion = number_format($b4_completion / $b4_target * 100,2);

        for($i=1; $i<=12; $i++)
        {
            $date = date('Y').'/'.$i.'/01';
            $startdate = Carbon::parse($date)->startOfMonth();
            $enddate = Carbon::parse($date)->endOfMonth();

            $sinovac = VaccineAccomplished::select(DB::raw("COALESCE(sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)),0) as sinovac_count"))
                ->where("typeof_vaccine","Sinovac")
                ->whereBetween('created_at',[$startdate,$enddate])
                ->first()
                ->sinovac_count;
            $data['sinovac'][] = $sinovac;

            $astrazeneca = VaccineAccomplished::select(DB::raw("COALESCE(sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)),0) as astra_count"))
                ->where("typeof_vaccine","Astrazeneca")
                ->whereBetween('created_at',[$startdate,$enddate])
                ->first()
                ->astra_count;
            $data['astrazeneca'][] = $astrazeneca;

            $sputnikv = VaccineAccomplished::select(DB::raw("COALESCE(sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)),0) as sputnikv_count"))
                ->where("typeof_vaccine","SputnikV")
                ->whereBetween('created_at',[$startdate,$enddate])
                ->first()
                ->sputnikv_count;
            $data['sputnikv'][] = $sputnikv;

            $pfizer = VaccineAccomplished::select(DB::raw("COALESCE(sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)),0) as pfizer_count"))
                ->where("typeof_vaccine","Pfizer")
                ->whereBetween('created_at',[$startdate,$enddate])
                ->first()
                ->pfizer_count;
            $data['pfizer'][] = $pfizer;

            $moderna = VaccineAccomplished::select(DB::raw("COALESCE(sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)),0) as moderna_count"))
                ->where("typeof_vaccine","Moderna")
                ->whereBetween('created_at',[$startdate,$enddate])
                ->first()
                ->moderna_count;
            $data['moderna'][] = $moderna;

            $johnson = VaccineAccomplished::select(DB::raw("COALESCE(sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)),0) as johnson_count"))
                ->where("typeof_vaccine","Johnson")
                ->whereBetween('created_at',[$startdate,$enddate])
                ->first()
                ->johnson_count;
            $data['johnson'][] = $johnson;

        }

        $sinovac_count = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as sinovac_count"))->where("typeof_vaccine","Sinovac")->first()->sinovac_count;
        $astrazeneca_count = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as astra_count"))->where("typeof_vaccine","Astrazeneca")->first()->astra_count;
        $pfizer_count = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as pfizer_count"))->where("typeof_vaccine","Pfizer")->first()->pfizer_count;
        $sputnikv_count = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as sputnikv_count"))->where("typeof_vaccine","SputnikV")->first()->sputnikv_count;
        $moderna_count = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as moderna_count"))->where("typeof_vaccine","Moderna")->first()->moderna_count;
        $johnson_count = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as johnson_count"))->where("typeof_vaccine","Johnson")->first()->johnson_count;

        $total_vaccinated_first = VaccineAccomplished::select(DB::raw("sum(vaccinated_first) as total_vaccinated_first"))->first()->total_vaccinated_first;
        $total_vaccinated_second = VaccineAccomplished::select(DB::raw("sum(vaccinated_second) as total_vaccinated_second"))->first()->total_vaccinated_second;

        $elipop_muncity = Muncity::select(DB::raw("sum(COALESCE(a1,0)+COALESCE(a2,0)+COALESCE(a3,0)+COALESCE(a4,0)) as elipop_muncity"))->first()->elipop_muncity;
        $elipop_facility = Facility::select(DB::raw("sum(COALESCE(a1,0)+COALESCE(a2,0)+COALESCE(a3,0)+COALESCE(a4,0)) as elipop_facility"))->first()->elipop_facility;

        $total_eli_pop = $elipop_muncity + $elipop_facility;

        $percent_coverage_first = number_format($total_vaccinated_first / $total_eli_pop * 100,2);
        $percent_coverage_second = number_format($total_vaccinated_second / $total_eli_pop * 100,2);

        $total_vaccine_allocated_first = Muncity::select(DB::raw("sum(COALESCE(sinovac_allocated_first,0) + COALESCE(astrazeneca_allocated_first,0) + COALESCE(astrazeneca_allocated_first,0)
                                                                          + COALESCE(pfizer_allocated_first,0) + COALESCE(sputnikv_allocated_first,0) + COALESCE(moderna_allocated_first,0) 
                                                                          + COALESCE(johnson_allocated_first,0)) as total_vaccine_allocated_first"))->first()->total_vaccine_allocated_first;
        $total_vaccine_allocated_second = Muncity::select(DB::raw("sum(COALESCE(sinovac_allocated_second,0) + COALESCE(astrazeneca_allocated_second,0) + COALESCE(pfizer_allocated_second,0)
                                                                          + COALESCE(pfizer_allocated_second,0) + COALESCE(sputnikv_allocated_second,0) + COALESCE(moderna_allocated_second,0) 
                                                                          + COALESCE(johnson_allocated_second,0) ) as total_vaccine_allocated_second"))->first()->total_vaccine_allocated_second;

        $total_vaccine_allocated_first_facility = Facility::select(DB::raw("sum(COALESCE(sinovac_allocated_first,0)+COALESCE(astrazeneca_allocated_first,0)) as total_vaccine_allocated_first_facility"))->first()->total_vaccine_allocated_first_facility;
        $total_vaccine_allocated_second_facility = Facility::select(DB::raw("sum(COALESCE(sinovac_allocated_second,0)+COALESCE(astrazeneca_allocated_second,0)) as total_vaccine_allocated_second_facility"))->first()->total_vaccine_allocated_second_facility;

        $total_overall_vaccine_allocated_first = $total_vaccine_allocated_first + $total_vaccine_allocated_first_facility;
        $total_overall_vaccine_allocated_second = $total_vaccine_allocated_second + $total_vaccine_allocated_second_facility;


        $consumption_rate_first =  number_format($total_vaccinated_first / $total_overall_vaccine_allocated_first * 100,2);
        $consumption_rate_second =  number_format($total_vaccinated_second / $total_overall_vaccine_allocated_second * 100,2);


        return view("vaccine.dashboard",[
            "data" => $data,
            "sinovac_count" => $sinovac_count,
            "astrazeneca_count" => $astrazeneca_count,
            "pfizer_count" => $pfizer_count,
            "sputnikv_count" => $sputnikv_count,
            "moderna_count" => $moderna_count,
            "johnson_count" => $johnson_count,
            "percent_coverage_first" =>$percent_coverage_first,
            "percent_coverage_second"=>$percent_coverage_second,
            "consumption_rate_first" =>$consumption_rate_first,
            "consumption_rate_second" =>$consumption_rate_second,
            "a1_target" => $a1_target,
            "a2_target" => $a2_target,
            "a3_target" => $a3_target,
            "a4_target" => $a4_target,
            "a5_target" => $a5_target,
            "b1_target" => $b1_target,
            "b2_target" => $b2_target,
            "b3_target" => $b3_target,
            "b4_target" => $b4_target,
            "a1_completion" => $a1_completion,
            "a2_completion" => $a2_completion,
            "a3_completion" => $a3_completion,
            "a4_completion" => $a4_completion,
            "a5_completion" => $a5_completion,
            "b1_completion" => $b1_completion,
            "b2_completion" => $b2_completion,
            "b3_completion" => $b3_completion,
            "b4_completion" => $b4_completion,
            "date_start" => $date_start,
            "date_end" => $date_end
        ]);
    }

    public function vaccineView(Request $request,$province_id)
    {

        $a1_target = Muncity::select(DB::raw("sum(coalesce(a1,0)) as a1_target"))->where("province_id",$province_id)->first()->a1_target;
        $a2_target = Muncity::select(DB::raw("sum(coalesce(a2,0)) as a2_target"))->where("province_id",$province_id)->first()->a2_target;
        $a3_target = Muncity::select(DB::raw("sum(coalesce(a3,0)) as a3_target"))->where("province_id",$province_id)->first()->a3_target;
        $a4_target = Muncity::select(DB::raw("sum(coalesce(a4,0)) as a4_target"))->where("province_id",$province_id)->first()->a4_target;
        $a5_target = Muncity::select(DB::raw("sum(coalesce(a5,0)) as a5_target"))->where("province_id",$province_id)->first()->a5_target;
        $b1_target = Muncity::select(DB::raw("sum(coalesce(b1,0)) as b1_target"))->where("province_id",$province_id)->first()->b1_target;
        $b2_target = Muncity::select(DB::raw("sum(coalesce(b2,0)) as b2_target"))->where("province_id",$province_id)->first()->b2_target;
        $b3_target = Muncity::select(DB::raw("sum(coalesce(b3,0)) as b3_target"))->where("province_id",$province_id)->first()->b3_target;
        $b4_target = Muncity::select(DB::raw("sum(coalesce(b4,0)) as b4_target"))->where("province_id",$province_id)->first()->b4_target;

        $a1_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a1_completion"))->where("province_id",$province_id)->where("priority","a1")->first()->a1_completion;
        $a2_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a2_completion"))->where("province_id",$province_id)->where("priority","a2")->first()->a2_completion;
        $a3_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a3_completion"))->where("province_id",$province_id)->where("priority","a3")->first()->a3_completion;
        $a4_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a4_completion"))->where("province_id",$province_id)->where("priority","a4")->first()->a4_completion;
        $a5_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as a5_completion"))->where("province_id",$province_id)->where("priority","a5")->first()->a5_completion;
        $b1_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b1_completion"))->where("province_id",$province_id)->where("priority","b1")->first()->b1_completion;
        $b2_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b2_completion"))->where("province_id",$province_id)->where("priority","b2")->first()->b2_completion;
        $b3_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b3_completion"))->where("province_id",$province_id)->where("priority","b3")->first()->b3_completion;
        $b4_completion = VaccineAccomplished::select(DB::raw("sum(coalesce(vaccinated_second,0)) as b4_completion"))->where("province_id",$province_id)->where("priority","b4")->first()->b4_completion;

        $a1_completion = number_format($a1_completion / $a1_target * 100,2);
        $a2_completion = number_format($a2_completion / $a2_target * 100,2);
        $a3_completion = number_format($a3_completion / $a3_target * 100,2);
        $a4_completion = number_format($a4_completion / $a4_target * 100,2);
        $a5_completion = number_format($a5_completion / $a5_target * 100,2);
        $b1_completion = number_format($b1_completion / $b1_target * 100,2);
        $b2_completion = number_format($b2_completion / $b2_target * 100,2);
        $b3_completion = number_format($b3_completion / $b3_target * 100,2);
        $b4_completion = number_format($b4_completion / $b4_target * 100,2);

        $sinovac_allocated = Muncity::select(DB::raw("sum(COALESCE(sinovac_allocated_first,0)+COALESCE(sinovac_allocated_second,0)) as sinovac_allocated"))->where("province_id",$province_id)->first()->sinovac_allocated;
        $astra_allocated = Muncity::select(DB::raw("sum(COALESCE(astrazeneca_allocated_first,0)+COALESCE(astrazeneca_allocated_second,0)) as astra_allocated"))->where("province_id",$province_id)->first()->astra_allocated;
        $pfizer_allocated = Muncity::select(DB::raw("sum(COALESCE(pfizer_allocated_first,0)+COALESCE(pfizer_allocated_second,0)) as pfizer_allocated"))->where("province_id",$province_id)->first()->pfizer_allocated;
        $sputnikv_allocated = Muncity::select(DB::raw("sum(COALESCE(sputnikv_allocated_first,0)+COALESCE(sputnikv_allocated_second,0)) as sputnikv_allocated"))->where("province_id",$province_id)->first()->sputnikv_allocated;
        $moderna_allocated = Muncity::select(DB::raw("sum(COALESCE(moderna_allocated_first,0)+COALESCE(moderna_allocated_second,0)) as moderna_allocated"))->where("province_id",$province_id)->first()->moderna_allocated;
        $johnson_allocated = Muncity::select(DB::raw("sum(COALESCE(johnson_allocated_first,0)+COALESCE(johnson_allocated_second,0)) as johnson_allocated"))->where("province_id",$province_id)->first()->johnson_allocated;

        $sinovac_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as sinovac_completion"))->where("typeof_vaccine","Sinovac")->first()->sinovac_completion;
        $astra_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as astra_completion"))->where("typeof_vaccine","Astrazeneca")->first()->astra_completion;
        $pfizer_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as pfizer_completion"))->where("typeof_vaccine","Pfizer")->first()->pfizer_completion;
        $sputnikv_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as sputnikv_completion"))->where("typeof_vaccine","Sputnikv")->first()->sputnikv_completion;
        $moderna_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as moderna_completion"))->where("typeof_vaccine","Moderna")->first()->moderna_completion;
        $johnson_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as johnson_completion"))->where("typeof_vaccine","Johnson")->first()->johnson_completion;


        $sinovac_completion = number_format($sinovac_completion / $sinovac_allocated * 100,2);
        $astra_completion = number_format($astra_completion / $astra_allocated * 100,2);
        $sputnikv_completion = number_format($sputnikv_completion / $sputnikv_allocated * 100,2);
        $pfizer_completion = number_format($pfizer_completion / $pfizer_allocated * 100,2);
        $moderna_completion = number_format($moderna_completion / $moderna_allocated * 100,2);
        $johnson_completion = number_format($johnson_completion / $johnson_allocated * 100,2);

        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = '2021-03-01 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        if($request->view_all == 'view_all')
            $keyword = '';
        else{
            if(Session::get("keyword_muncity")){
                if(!empty($request->keyword_muncity) && Session::get("keyword_muncity") != $request->keyword_muncity)
                    $keyword = $request->keyword_muncity;
                else
                    $keyword = Session::get("keyword_muncity");
            } else {
                $keyword = $request->keyword_muncity;
            }
        }

        Session::put('keyword_muncity',$keyword);

        $data = Muncity::where('description',"like","%$keyword%")
            ->where("province_id",$province_id);
        if($request->muncity_filter)
            $data = $data->where("id",$request->muncity_filter);

        $data = $data->orderBy("description","asc");
        $muncity = $data->get();

        $data = $data->paginate(10); //kay kani nagsugod
        //dire dapita nimo i declare
        //ari ka sugod declare last page


        //imo buhatun like akong filter pagination katong latest nga ako ge tudlo nimo katong pasa'2 sa filter


        return view('vaccine.vaccineview',[
            'title' => 'List of Municipality',
            'province_name' => Province::find($province_id)->description,
            'province_id' => $province_id,
            'data' => $data,
            'muncity' => $muncity,
            'typeof_vaccine_filter' => $request->typeof_vaccine_filter,
            'muncity_filter' => $request->muncity_filter,
            'priority_filter' => $request->priority_filter,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'a1_target' => $a1_target,
            'a2_target' => $a2_target,
            'a3_target' => $a3_target,
            'a4_target' => $a4_target,
            'a5_target' => $a5_target,
            'b1_target' => $b1_target,
            'b2_target' => $b2_target,
            'b3_target' => $b3_target,
            'b4_target' => $b4_target,
            'a1_completion' => $a1_completion,
            'a2_completion' => $a2_completion,
            'a3_completion' => $a3_completion,
            'a4_completion' => $a4_completion,
            'a5_completion' => $a5_completion,
            'b1_completion' => $b1_completion,
            'b2_completion' => $b2_completion,
            'b3_completion' => $b3_completion,
            'b4_completion' => $b4_completion,
            'sinovac_allocated' => $sinovac_allocated,
            'astra_allocated' => $astra_allocated,
            'pfizer_allocated' => $pfizer_allocated,
            'sputnikv_allocated' => $sputnikv_allocated,
            'moderna_allocated' => $moderna_allocated,
            'johnson_allocated' => $johnson_allocated,
            'sinovac_completion' => $sinovac_completion,
            'astra_completion' => $astra_completion,
            'pfizer_completion' => $pfizer_completion,
            'sputnikv_completion' => $sputnikv_completion,
            'moderna_completion' => $moderna_completion,
            'johnson_completion' => $johnson_completion,
        ]);
    }

    public function TargetCompletionFacility($muncity_id){
        $this->data_facility = Facility::where("province",2)
            ->where("vaccine_used","yes")
            ->where("tricity_id",$muncity_id);
        $this->a1_target_facility = Facility::select(DB::raw("sum(coalesce(a1,0)) as a1_target_facility"))->where("tricity_id",63)->first()->a1_target_facility;
        $this->a2_target_facility = Facility::select(DB::raw("sum(coalesce(a2,0)) as a2_target_facility"))->where("tricity_id",63)->first()->a2_target_facility;
        $this->a3_target_facility = Facility::select(DB::raw("sum(coalesce(a3,0)) as a3_target_facility"))->where("tricity_id",63)->first()->a3_target_facility;
        $this->a4_target_facility = Facility::select(DB::raw("sum(coalesce(a4,0)) as a4_target_facility"))->where("tricity_id",63)->first()->a4_target_facility;
        $this->a5_target_facility = Facility::select(DB::raw("sum(coalesce(a5,0)) as a5_target_facility"))->where("tricity_id",63)->first()->a5_target_facility;
        $this->b1_target_facility = Facility::select(DB::raw("sum(coalesce(b1,0)) as b1_target_facility"))->where("tricity_id",63)->first()->b1_target_facility;
        $this->b2_target_facility = Facility::select(DB::raw("sum(coalesce(b2,0)) as b2_target_facility"))->where("tricity_id",63)->first()->b2_target_facility;
        $this->b3_target_facility = Facility::select(DB::raw("sum(coalesce(b3,0)) as b3_target_facility"))->where("tricity_id",63)->first()->b3_target_facility;
        $this->b4_target_facility = Facility::select(DB::raw("sum(coalesce(b4,0)) as b4_target_facility"))->where("tricity_id",63)->first()->b4_target_facility;


        $this->a1_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as a1_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","a1")
            ->first()
            ->a1_vaccinated_facility;

        $this->a2_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as a2_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","a2")
            ->first()
            ->a2_vaccinated_facility;

        $this->a3_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as a3_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","a3")
            ->first()
            ->a3_vaccinated_facility;

        $this->a4_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as a4_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","a4")
            ->first()
            ->a4_vaccinated_facility;

        $this->a5_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as a5_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","a5")
            ->first()
            ->a5_vaccinated_facility;

        $this->b1_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as b1_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","b1")
            ->first()
            ->b1_vaccinated_facility;

        $this->b2_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as b2_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","b2")
            ->first()
            ->b2_vaccinated_facility;

        $this->b3_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as b3_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","b3")
            ->first()
            ->b3_vaccinated_facility;

        $this->b4_vaccinated_facility = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as b4_vaccinated_facility"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",$muncity_id)
            ->where("vaccine_accomplish.priority","b4")
            ->first()
            ->b4_vaccinated_facility;

        $this->a1_completion_facility = number_format($this->a1_vaccinated_facility / $this->a1_target_facility * 100,2);
        $this->a2_completion_facility = number_format($this->a2_vaccinated_facility / $this->a2_target_facility * 100,2);
        $this->a3_completion_facility = number_format($this->a3_vaccinated_facility / $this->a3_target_facility * 100,2);
        $this->a4_completion_facility = number_format($this->a4_vaccinated_facility / $this->a4_target_facility * 100,2);
        $this->a5_completion_facility = number_format($this->a5_vaccinated_facility / $this->a5_target_facility * 100,2);
        $this->b1_completion_facility = number_format($this->b1_vaccinated_facility / $this->b1_target_facility * 100,2);
        $this->b2_completion_facility = number_format($this->b2_vaccinated_facility / $this->b2_target_facility * 100,2);
        $this->b3_completion_facility = number_format($this->b3_vaccinated_facility / $this->b3_target_facility * 100,2);
        $this->b4_completion_facility = number_format($this->b4_vaccinated_facility / $this->b4_target_facility * 100,2);

        $this->sinovac_allocated_facility = Facility::select(DB::raw("sum(COALESCE(sinovac_allocated_first,0)+COALESCE(sinovac_allocated_second,0)) as sinovac_allocated_facility"))->where("tricity_id",$muncity_id)->first()->sinovac_allocated_facility;
        $this->astra_allocated_facility = Facility::select(DB::raw("sum(COALESCE(astrazeneca_allocated_first,0)+COALESCE(astrazeneca_allocated_second,0)) as astra_allocated_facility"))->where("tricity_id",$muncity_id)->first()->astra_allocated_facility;
        $this->pfizer_allocated_facility = Facility::select(DB::raw("sum(COALESCE(pfizer_allocated_first,0)+COALESCE(pfizer_allocated_second,0)) as pfizer_allocated_facility"))->where("tricity_id",$muncity_id)->first()->pfizer_allocated_facility;
        $this->sputnikv_allocated_facility = Facility::select(DB::raw("sum(COALESCE(sputnikv_allocated_first,0)+COALESCE(sputnikv_allocated_second,0)) as sputnikv_allocated_facility"))->where("tricity_id",$muncity_id)->first()->sputnikv_allocated_facility;
        $this->moderna_allocated_facility = Facility::select(DB::raw("sum(COALESCE(moderna_allocated_first,0)+COALESCE(moderna_allocated_second,0)) as moderna_allocated_facility"))->where("tricity_id",$muncity_id)->first()->moderna_allocated_facility;
        $this->johnson_allocated_facility = Facility::select(DB::raw("sum(COALESCE(johnson_allocated_first,0)+COALESCE(johnson_allocated_second,0)) as johnson_allocated_facility"))->where("tricity_id",$muncity_id)->first()->johnson_allocated_facility;

        $this->sinovac_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as sinovac_completion"))->where("typeof_vaccine","Sinovac")->first()->sinovac_completion;
        $this->astra_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as astra_completion"))->where("typeof_vaccine","Astrazeneca")->first()->astra_completion;
        $this->sputnikv_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as sputnikv_completion"))->where("typeof_vaccine","Sputnikv")->first()->sputnikv_completion;
        $this->pfizer_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as pfizer_completion"))->where("typeof_vaccine","Pfizer")->first()->pfizer_completion;
        $this->moderna_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as moderna_completion"))->where("typeof_vaccine","Moderna")->first()->moderna_completion;
        $this->johnson_completion = VaccineAccomplished::select(DB::raw("sum(COALESCE(vaccinated_first,0)+COALESCE(vaccinated_second,0)) as johnson_completion"))->where("typeof_vaccine","Johnson")->first()->johnson_completion;

        $this->sinovac_completion = number_format($this->sinovac_completion / $this->sinovac_allocated_facility * 100,2);
        $this->astra_completion = number_format($this->astra_completion / $this->astra_allocated_facility * 100,2);
        $this->sputnikv_completion = number_format($this->sputnikv_completion / $this->sputnikv_allocated_facility * 100,2);
        $this->pfizer_completion = number_format($this->pfizer_completion / $this->pfizer_allocated_facility * 100,2);
        $this->moderna_completion = number_format($this->moderna_completion / $this->moderna_allocated_facility * 100,2);
        $this->johnson_completion = number_format($this->johnson_completion / $this->johnson_allocated_facility * 100,2);
    }
    public function vaccineFacility($tri_city,Request $request)
    {
        $tricity_id = 0;
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = '2021-03-01 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        if($tri_city == 'cebu'){
            $tricity_id = 63;
            $this->TargetCompletionFacility("63");
        }
        elseif($tri_city == 'mandaue'){
            $this->TargetCompletionFacility("80");
            $tricity_id = 80;
        }
        elseif($tri_city == 'lapu'){
            $this->TargetCompletionFacility("76");
            $tricity_id = 76;
        }

        $facility = $this->data_facility->orderBy("name","asc")
            ->get();

        if($request->muncity_filter)
            $this->data_facility= $this->data_facility->where("id",$request->muncity_filter);


        $this->data_facility = $this->data_facility
            ->orderBy("name","asc")
            ->paginate(10);



        return view('vaccine.vaccine_facility',[
            'title' => 'List of Facility',
            'province_name' => "Cebu",
            'province_id' => 2,
            'data' => $this->data_facility,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'typeof_vaccine_filter' => $request->typeof_vaccine_filter,
            'muncity_filter' => $request->muncity_filter,
            'priority_filter' => $request->priority_filter,
            'tri_city' => $tri_city,
            "facility" => $facility,
            'a1_target_facility'  =>  $this->a1_target_facility,
            'a2_target_facility'  =>  $this->a2_target_facility,
            'a3_target_facility'  =>  $this->a3_target_facility,
            'a4_target_facility'  =>  $this->a4_target_facility,
            'a5_target_facility'  =>  $this->a5_target_facility,
            'b1_target_facility'  =>  $this->b1_target_facility,
            'b2_target_facility'  =>  $this->b2_target_facility,
            'b3_target_facility'  =>  $this->b3_target_facility,
            'b4_target_facility'  =>  $this->b4_target_facility,
            'a1_vaccinated_facility'  =>  $this->a1_vaccinated_facility,
            'a2_vaccinated_facility'  =>  $this->a2_vaccinated_facility,
            'a3_vaccinated_facility'  =>  $this->a3_vaccinated_facility,
            'a4_vaccinated_facility'  =>  $this->a4_vaccinated_facility,
            'a5_vaccinated_facility'  =>  $this->a5_vaccinated_facility,
            'b1_vaccinated_facility'  =>  $this->b1_vaccinated_facility,
            'b2_vaccinated_facility'  =>  $this->b2_vaccinated_facility,
            'b3_vaccinated_facility'  =>  $this->b3_vaccinated_facility,
            'b4_vaccinated_facility'  =>  $this->b4_vaccinated_facility,
            'a1_completion_facility'  =>  $this->a1_completion_facility,
            'a2_completion_facility'  =>  $this->a2_completion_facility,
            'a3_completion_facility'  =>  $this->a3_completion_facility,
            'a4_completion_facility'  =>  $this->a4_completion_facility,
            'a5_completion_facility'  =>  $this->a5_completion_facility,
            'b1_completion_facility'  =>  $this->b1_completion_facility,
            'b2_completion_facility'  =>  $this->b2_completion_facility,
            'b3_completion_facility'  =>  $this->b3_completion_facility,
            'b4_completion_facility'  =>  $this->b4_completion_facility,
            'sinovac_allocated_facility'  => $this->sinovac_allocated_facility,
            'astra_allocated_facility'  => $this->astra_allocated_facility,
            'pfizer_allocated_facility'  => $this->pfizer_allocated_facility,
            'sputnikv_allocated_facility'  => $this->sputnikv_allocated_facility,
            'moderna_allocated_facility'  => $this->moderna_allocated_facility,
            'johnson_allocated_facility'  => $this->johnson_allocated_facility,
            'sinovac_completion' => $this->sinovac_completion,
            'astra_completion' => $this->astra_completion,
            'pfizer_completion' => $this->pfizer_completion,
            'sputnikv_completion' => $this->sputnikv_completion,
            'moderna_completion' => $this->moderna_completion,
            'johnson_completion' => $this->johnson_completion,
            'tricity_id' => $tricity_id,
        ]);
    }

    public function vaccinatedContentMunicipality(Request $request)
    {

        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $vaccine_accomplishment = VaccineAccomplished::where('muncity_id',$request->muncity_id)
            ->where(function($query) use($date_start,$date_end){
                $query->whereBetween("date_first",[$date_start,$date_end])
                    ->orWhereBetween("date_second",[$date_start,$date_end]);
            });


        if($request->typeof_vaccine_filter)
            $vaccine_accomplishment = $vaccine_accomplishment->where("typeof_vaccine",$request->typeof_vaccine_filter);


        if($request->priority_filter)
            $vaccine_accomplishment = $vaccine_accomplishment->where("priority",$request->priority_filter);



        $vaccine_accomplishment = $vaccine_accomplishment->orderBy('id','desc')->paginate(8);

        $request->municipality_content = "true";
        $request->typeof_vaccine = "sinovac";
        $sinovac_data = $this->dataCollapse($request);
        $request->typeof_vaccine = "astrazeneca";
        $astrazeneca_data = $this->dataCollapse($request);
        $request->typeof_vaccine = "pfizer";
        $pfizer_data = $this->dataCollapse($request);
        $request->typeof_vaccine = "sputnikv";
        $sputnikv_data = $this->dataCollapse($request);
        $request->typeof_vaccine = "moderna";
        $moderna_data = $this->dataCollapse($request);
        $request->typeof_vaccine = "johnson";
        $johnson_data = $this->dataCollapse($request);
        $request->typeof_vaccine = "total";
        $total_data = $this->dataCollapse($request);



        $data = [
            "province_id" => $request->province_id,
            "muncity_id" => $request->muncity_id,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "date_range" => $request->date_range,
            "muncity_filter" =>$request->muncity_filter,
            "typeof_vaccine_filter" => $request->typeof_vaccine_filter,
            "priority_filter" => $request->priority_filter,
            "vaccine_accomplishment" => $vaccine_accomplishment,
            //SINOVAC
            "total_epop_svac_a1" => $sinovac_data["total_epop_a1"],
            "total_epop_svac_a2" => $sinovac_data["total_epop_a2"],
            "total_epop_svac_a3" => $sinovac_data["total_epop_a3"],
            "total_epop_svac_a4" => $sinovac_data["total_epop_a4"],
            "total_epop_svac_a5" => $sinovac_data["total_epop_a5"],
            "total_epop_svac_b1" => $sinovac_data["total_epop_b1"],
            "total_epop_svac_b2" => $sinovac_data["total_epop_b2"],
            "total_epop_svac_b3" => $sinovac_data["total_epop_b3"],
            "total_epop_svac_b4" => $sinovac_data["total_epop_b4"],
            "total_epop_svac" =>$sinovac_data["total_epop"],
            "total_vallocated_svac_frst" => $request->sinovac_allocated_first,
            "total_vallocated_svac_scnd" => $request->sinovac_allocated_second,
            "total_vallocated_svac" => $request->sinovac_allocated_first + $request->sinovac_allocated_second,
            "total_svac_a1_frst" => $sinovac_data["total_a1_frst"],
            "total_svac_a2_frst" => $sinovac_data["total_a2_frst"],
            "total_svac_a3_frst" => $sinovac_data["total_a3_frst"],
            "total_svac_a4_frst" => $sinovac_data["total_a4_frst"],
            "total_svac_a5_frst" => $sinovac_data["total_a5_frst"],
            "total_svac_b1_frst" => $sinovac_data["total_b1_frst"],
            "total_svac_b2_frst" => $sinovac_data["total_b2_frst"],
            "total_svac_b3_frst" => $sinovac_data["total_b3_frst"],
            "total_svac_b4_frst" => $sinovac_data["total_b4_frst"],
            "total_vcted_svac_frst" => $sinovac_data["total_vcted_frst"],
            "total_mild_svac_frst" => $sinovac_data["total_mild_frst"],
            "total_srs_svac_frst" => $sinovac_data["total_srs_frst"],
            "total_dfrd_svac_frst" => $sinovac_data["total_dfrd_frst"],
            "total_rfsd_svac_frst" => $sinovac_data["total_rfsd_frst"],
            "total_wstge_svac_frst" => $sinovac_data["total_wstge_frst"],
            "p_cvrge_svac_frst" => $sinovac_data["p_cvrge_frst"],
            "total_c_rate_svac_frst" => $sinovac_data["total_vcted_frst"] /  $request->sinovac_allocated_first * 100,
            "total_r_unvcted_frst_svac" => $sinovac_data["total_r_unvcted_frst"],

            "total_svac_a1_scnd" => $sinovac_data["total_a1_scnd"],
            "total_svac_a2_scnd" => $sinovac_data["total_a2_scnd"],
            "total_svac_a3_scnd" => $sinovac_data["total_a3_scnd"],
            "total_svac_a4_scnd" => $sinovac_data["total_a4_scnd"],
            "total_svac_a5_scnd" => $sinovac_data["total_a5_scnd"],
            "total_svac_b1_scnd" => $sinovac_data["total_b1_scnd"],
            "total_svac_b2_scnd" => $sinovac_data["total_b2_scnd"],
            "total_svac_b3_scnd" => $sinovac_data["total_b3_scnd"],
            "total_svac_b4_scnd" => $sinovac_data["total_b4_scnd"],
            "total_vcted_svac_scnd" => $sinovac_data["total_vcted_scnd"],
            "total_mild_svac_scnd" => $sinovac_data["total_mild_scnd"],
            "total_srs_svac_scnd" => $sinovac_data["total_srs_scnd"],
            "total_dfrd_svac_scnd" => $sinovac_data["total_dfrd_scnd"],
            "total_rfsd_svac_scnd" => $sinovac_data["total_rfsd_scnd"],
            "total_wstge_svac_scnd" => $sinovac_data["total_wstge_scnd"],
            "p_cvrge_svac_scnd" => $sinovac_data["p_cvrge_scnd"],
            "total_c_rate_svac_scnd" => $sinovac_data["total_vcted_scnd"] /  $request->sinovac_allocated_second * 100,
            "total_r_unvcted_scnd_svac" => $sinovac_data["total_r_unvcted_scnd"],
            //END SINOVAC

            //ASTRA
            "total_epop_astra_a1" => $astrazeneca_data["total_epop_a1"],
            "total_epop_astra_a2" => $astrazeneca_data["total_epop_a2"],
            "total_epop_astra_a3" => $astrazeneca_data["total_epop_a3"],
            "total_epop_astra_a4" => $astrazeneca_data["total_epop_a4"],
            "total_epop_astra_a5" => $astrazeneca_data["total_epop_a5"],
            "total_epop_astra_b1" => $astrazeneca_data["total_epop_b1"],
            "total_epop_astra_b2" => $astrazeneca_data["total_epop_b2"],
            "total_epop_astra_b3" => $astrazeneca_data["total_epop_b3"],
            "total_epop_astra_b4" => $astrazeneca_data["total_epop_b4"],
            "total_epop_astra" => $astrazeneca_data["total_epop"],
            "total_vallocated_astra_frst" => $request->astrazeneca_allocated_first,
            "total_vallocated_astra_scnd" => $request->astrazeneca_allocated_second,
            "total_vallocated_astra" => $request->astrazeneca_allocated_first + $request->astrazeneca_allocated_second,
            "total_astra_a1_frst" => $astrazeneca_data["total_a1_frst"],
            "total_astra_a2_frst" => $astrazeneca_data["total_a2_frst"],
            "total_astra_a3_frst" => $astrazeneca_data["total_a3_frst"],
            "total_astra_a4_frst" => $astrazeneca_data["total_a4_frst"],
            "total_astra_a5_frst" => $astrazeneca_data["total_a5_frst"],
            "total_astra_b1_frst" => $astrazeneca_data["total_b1_frst"],
            "total_astra_b2_frst" => $astrazeneca_data["total_b2_frst"],
            "total_astra_b3_frst" => $astrazeneca_data["total_b3_frst"],
            "total_astra_b4_frst" => $astrazeneca_data["total_b4_frst"],
            "total_vcted_astra_frst" => $astrazeneca_data["total_vcted_frst"],
            "total_mild_astra_frst" => $astrazeneca_data["total_mild_frst"],
            "total_srs_astra_frst" => $astrazeneca_data["total_srs_frst"],
            "total_dfrd_astra_frst" => $astrazeneca_data["total_dfrd_frst"],
            "total_rfsd_astra_frst" => $astrazeneca_data["total_rfsd_frst"],
            "total_wstge_astra_frst" => $astrazeneca_data["total_wstge_frst"],
            "p_cvrge_astra_frst" => $astrazeneca_data["p_cvrge_frst"],
            "total_c_rate_astra_frst" => $astrazeneca_data["total_vcted_frst"] / $request->astrazeneca_allocated_first * 100,
            "total_r_unvcted_frst_astra" => $astrazeneca_data["total_r_unvcted_frst"],

            "total_astra_a1_scnd" => $astrazeneca_data["total_a1_scnd"],
            "total_astra_a2_scnd" => $astrazeneca_data["total_a2_scnd"],
            "total_astra_a3_scnd" => $astrazeneca_data["total_a3_scnd"],
            "total_astra_a4_scnd" => $astrazeneca_data["total_a4_scnd"],
            "total_astra_a5_scnd" => $astrazeneca_data["total_a5_scnd"],
            "total_astra_b1_scnd" => $astrazeneca_data["total_b1_scnd"],
            "total_astra_b2_scnd" => $astrazeneca_data["total_b2_scnd"],
            "total_astra_b3_scnd" => $astrazeneca_data["total_b3_scnd"],
            "total_astra_b4_scnd" => $astrazeneca_data["total_b4_scnd"],
            "total_vcted_astra_scnd" => $astrazeneca_data["total_vcted_scnd"],
            "total_mild_astra_scnd" => $astrazeneca_data["total_mild_scnd"],
            "total_srs_astra_scnd" => $astrazeneca_data["total_srs_scnd"],
            "total_dfrd_astra_scnd" => $astrazeneca_data["total_dfrd_scnd"],
            "total_rfsd_astra_scnd" => $astrazeneca_data["total_rfsd_scnd"],
            "total_wstge_astra_scnd" => $astrazeneca_data["total_wstge_scnd"],
            "p_cvrge_astra_scnd" => $astrazeneca_data["p_cvrge_scnd"],
            "total_c_rate_astra_scnd" =>$astrazeneca_data["total_vcted_scnd"] / $request->astrazeneca_allocated_second * 100,
            "total_r_unvcted_scnd_astra" => $astrazeneca_data["total_r_unvcted_scnd"],
            //END ASTRA

            //PFIZER
            "total_epop_pfizer_a1" => $pfizer_data["total_epop_a1"],
            "total_epop_pfizer_a2" => $pfizer_data["total_epop_a2"],
            "total_epop_pfizer_a3" => $pfizer_data["total_epop_a3"],
            "total_epop_pfizer_a4" => $pfizer_data["total_epop_a4"],
            "total_epop_pfizer_a5" => $pfizer_data["total_epop_a5"],
            "total_epop_pfizer_b1" => $pfizer_data["total_epop_b1"],
            "total_epop_pfizer_b2" => $pfizer_data["total_epop_b2"],
            "total_epop_pfizer_b3" => $pfizer_data["total_epop_b3"],
            "total_epop_pfizer_b4" => $pfizer_data["total_epop_b4"],
            "total_epop_pfizer" => $pfizer_data["total_epop"],
            "total_vallocated_pfizer_frst" => $request->pfizer_allocated_first,
            "total_vallocated_pfizer_scnd" =>  $request->pfizer_allocated_first,
            "total_vallocated_pfizer" => $request->pfizer_allocated_first + $request->pfizer_allocated_second,
            "total_pfizer_a1_frst" => $pfizer_data["total_a1_frst"],
            "total_pfizer_a2_frst" => $pfizer_data["total_a2_frst"],
            "total_pfizer_a3_frst" => $pfizer_data["total_a3_frst"],
            "total_pfizer_a4_frst" => $pfizer_data["total_a4_frst"],
            "total_pfizer_a5_frst" => $pfizer_data["total_a5_frst"],
            "total_pfizer_b1_frst" => $pfizer_data["total_b1_frst"],
            "total_pfizer_b2_frst" => $pfizer_data["total_b2_frst"],
            "total_pfizer_b3_frst" => $pfizer_data["total_b3_frst"],
            "total_pfizer_b4_frst" => $pfizer_data["total_b4_frst"],
            "total_vcted_pfizer_frst" => $pfizer_data["total_vcted_frst"],
            "total_mild_pfizer_frst" => $pfizer_data["total_mild_frst"],
            "total_srs_pfizer_frst" => $pfizer_data["total_srs_frst"],
            "total_dfrd_pfizer_frst" => $pfizer_data["total_dfrd_frst"],
            "total_rfsd_pfizer_frst" => $pfizer_data["total_rfsd_frst"],
            "total_wstge_pfizer_frst" => $pfizer_data["total_wstge_frst"],
            "p_cvrge_pfizer_frst" => $pfizer_data["p_cvrge_frst"],
            "total_c_rate_pfizer_frst" => $pfizer_data["total_vcted_frst"] / $request->pfizer_allocated_first * 100,
            "total_r_unvcted_frst_pfizer" => $pfizer_data["total_r_unvcted_frst"],

            "total_pfizer_a1_scnd" => $pfizer_data["total_a1_scnd"],
            "total_pfizer_a2_scnd" => $pfizer_data["total_a2_scnd"],
            "total_pfizer_a3_scnd" => $pfizer_data["total_a3_scnd"],
            "total_pfizer_a4_scnd" => $pfizer_data["total_a4_scnd"],
            "total_pfizer_a5_scnd" => $pfizer_data["total_a5_scnd"],
            "total_pfizer_b1_scnd" => $pfizer_data["total_b1_scnd"],
            "total_pfizer_b2_scnd" => $pfizer_data["total_b2_scnd"],
            "total_pfizer_b3_scnd" => $pfizer_data["total_b3_scnd"],
            "total_pfizer_b4_scnd" => $pfizer_data["total_b4_scnd"],
            "total_vcted_pfizer_scnd" => $pfizer_data["total_vcted_scnd"],
            "total_mild_pfizer_scnd" => $pfizer_data["total_mild_scnd"],
            "total_srs_pfizer_scnd" => $pfizer_data["total_srs_scnd"],
            "total_dfrd_pfizer_scnd" => $pfizer_data["total_dfrd_scnd"],
            "total_rfsd_pfizer_scnd" => $pfizer_data["total_rfsd_scnd"],
            "total_wstge_pfizer_scnd" =>$pfizer_data["total_wstge_scnd"],
            "p_cvrge_pfizer_scnd" => $pfizer_data["p_cvrge_scnd"],
            "total_c_rate_pfizer_scnd" => $pfizer_data["total_vcted_scnd"] / $request->pfizer_allocated_second * 100,
            "total_r_unvcted_scnd_pfizer" => $pfizer_data["total_r_unvcted_scnd"],
            //PFIZER END

            //SPUTNIKV
            "total_epop_sputnikv_a1" => $sputnikv_data["total_epop_a1"],
            "total_epop_sputnikv_a2" => $sputnikv_data["total_epop_a2"],
            "total_epop_sputnikv_a3" => $sputnikv_data["total_epop_a3"],
            "total_epop_sputnikv_a4" => $sputnikv_data["total_epop_a4"],
            "total_epop_sputnikv_a5" => $sputnikv_data["total_epop_a5"],
            "total_epop_sputnikv_b1" => $sputnikv_data["total_epop_b1"],
            "total_epop_sputnikv_b2" => $sputnikv_data["total_epop_b2"],
            "total_epop_sputnikv_b3" => $sputnikv_data["total_epop_b3"],
            "total_epop_sputnikv_b4" => $sputnikv_data["total_epop_b4"],
            "total_epop_sputnikv" =>  $sputnikv_data["total_epop"],
            "total_vallocated_sputnikv_frst" => $request->sputnikv_allocated_first,
            "total_vallocated_sputnikv_scnd" => $request->sputnikv_allocated_first,
            "total_vallocated_sputnikv" => $request->sputnikv_allocated_first + $request->sputnikv_allocated_second,
            "total_sputnikv_a1_frst" => $sputnikv_data["total_a1_frst"],
            "total_sputnikv_a2_frst" => $sputnikv_data["total_a2_frst"],
            "total_sputnikv_a3_frst" => $sputnikv_data["total_a3_frst"],
            "total_sputnikv_a4_frst" => $sputnikv_data["total_a4_frst"],
            "total_sputnikv_a5_frst" => $sputnikv_data["total_a5_frst"],
            "total_sputnikv_b1_frst" => $sputnikv_data["total_b1_frst"],
            "total_sputnikv_b2_frst" => $sputnikv_data["total_b2_frst"],
            "total_sputnikv_b3_frst" => $sputnikv_data["total_b3_frst"],
            "total_sputnikv_b4_frst" => $sputnikv_data["total_b4_frst"],
            "total_vcted_sputnikv_frst" => $sputnikv_data["total_vcted_frst"],
            "total_mild_sputnikv_frst" => $sputnikv_data["total_mild_frst"],
            "total_srs_sputnikv_frst" => $sputnikv_data["total_srs_frst"],
            "total_dfrd_sputnikv_frst" => $sputnikv_data["total_dfrd_frst"],
            "total_rfsd_sputnikv_frst" => $sputnikv_data["total_rfsd_frst"],
            "total_wstge_sputnikv_frst" => $sputnikv_data["total_wstge_frst"],
            "p_cvrge_sputnikv_frst" => $sputnikv_data["p_cvrge_frst"],
            "total_c_rate_sputnikv_frst" => $sputnikv_data["total_vcted_frst"] / $request->sputnikv_allocated_first * 100,
            "total_r_unvcted_frst_sputnikv" => $sputnikv_data["total_r_unvcted_frst"],

            "total_sputnikv_a1_scnd" => $sputnikv_data["total_a1_scnd"],
            "total_sputnikv_a2_scnd" => $sputnikv_data["total_a2_scnd"],
            "total_sputnikv_a3_scnd" => $sputnikv_data["total_a3_scnd"],
            "total_sputnikv_a4_scnd" => $sputnikv_data["total_a4_scnd"],
            "total_sputnikv_a5_scnd" => $sputnikv_data["total_a5_scnd"],
            "total_sputnikv_b1_scnd" => $sputnikv_data["total_b1_scnd"],
            "total_sputnikv_b2_scnd" => $sputnikv_data["total_b2_scnd"],
            "total_sputnikv_b3_scnd" => $sputnikv_data["total_b3_scnd"],
            "total_sputnikv_b4_scnd" => $sputnikv_data["total_b4_scnd"],
            "total_vcted_sputnikv_scnd" => $sputnikv_data["total_vcted_scnd"],
            "total_mild_sputnikv_scnd" => $sputnikv_data["total_mild_scnd"],
            "total_srs_sputnikv_scnd" => $sputnikv_data["total_srs_scnd"],
            "total_dfrd_sputnikv_scnd" => $sputnikv_data["total_dfrd_scnd"],
            "total_rfsd_sputnikv_scnd" => $sputnikv_data["total_rfsd_scnd"],
            "total_wstge_sputnikv_scnd" => $sputnikv_data["total_wstge_scnd"],
            "p_cvrge_sputnikv_scnd" => $sputnikv_data["p_cvrge_scnd"],
            "total_c_rate_sputnikv_scnd" => $sputnikv_data["total_vcted_scnd"] / $request->sputnikv_allocated_second * 100,
            "total_r_unvcted_scnd_sputnikv" => $sputnikv_data["total_r_unvcted_scnd"],
            //END SPUTNIKV


            //MODERNA
            "total_epop_moderna_a1" => $moderna_data["total_epop_a1"],
            "total_epop_moderna_a2" => $moderna_data["total_epop_a2"],
            "total_epop_moderna_a3" => $moderna_data["total_epop_a3"],
            "total_epop_moderna_a4" => $moderna_data["total_epop_a4"],
            "total_epop_moderna_a5" => $moderna_data["total_epop_a5"],
            "total_epop_moderna_b1" => $moderna_data["total_epop_b1"],
            "total_epop_moderna_b2" => $moderna_data["total_epop_b2"],
            "total_epop_moderna_b3" => $moderna_data["total_epop_b3"],
            "total_epop_moderna_b4" => $moderna_data["total_epop_b4"],
            "total_epop_moderna" => $moderna_data["total_epop"],
            "total_vallocated_moderna_frst" => $request->moderna_allocated_first,
            "total_vallocated_moderna_scnd" => $request->moderna_allocated_first,
            "total_vallocated_moderna" => $request->moderna_allocated_first + $request->moderna_allocated_second,
            "total_moderna_a1_frst" => $moderna_data["total_a1_frst"],
            "total_moderna_a2_frst" => $moderna_data["total_a2_frst"],
            "total_moderna_a3_frst" => $moderna_data["total_a3_frst"],
            "total_moderna_a4_frst" => $moderna_data["total_a4_frst"],
            "total_moderna_a5_frst" => $moderna_data["total_a5_frst"],
            "total_moderna_b1_frst" => $moderna_data["total_b1_frst"],
            "total_moderna_b2_frst" => $moderna_data["total_b2_frst"],
            "total_moderna_b3_frst" => $moderna_data["total_b3_frst"],
            "total_moderna_b4_frst" => $moderna_data["total_b4_frst"],
            "total_vcted_moderna_frst" => $moderna_data["total_vcted_frst"],
            "total_mild_moderna_frst" => $moderna_data["total_mild_frst"],
            "total_srs_moderna_frst" => $moderna_data["total_srs_frst"],
            "total_dfrd_moderna_frst" => $moderna_data["total_dfrd_frst"],
            "total_rfsd_moderna_frst" => $moderna_data["total_rfsd_frst"],
            "total_wstge_moderna_frst" => $moderna_data["total_wstge_frst"],
            "p_cvrge_moderna_frst" => $moderna_data["p_cvrge_frst"],
            "total_c_rate_moderna_frst" => $moderna_data["total_vcted_frst"] / $request->moderna_allocated_first * 100,
            "total_r_unvcted_frst_moderna" => $moderna_data["total_r_unvcted_frst"],

            "total_moderna_a1_scnd" => $moderna_data["total_a1_scnd"],
            "total_moderna_a2_scnd" => $moderna_data["total_a2_scnd"],
            "total_moderna_a3_scnd" => $moderna_data["total_a3_scnd"],
            "total_moderna_a4_scnd" => $moderna_data["total_a4_scnd"],
            "total_moderna_a5_scnd" => $moderna_data["total_a5_scnd"],
            "total_moderna_b1_scnd" => $moderna_data["total_b1_scnd"],
            "total_moderna_b2_scnd" => $moderna_data["total_b2_scnd"],
            "total_moderna_b3_scnd" => $moderna_data["total_b3_scnd"],
            "total_moderna_b4_scnd" => $moderna_data["total_b4_scnd"],
            "total_vcted_moderna_scnd" => $moderna_data["total_vcted_scnd"],
            "total_mild_moderna_scnd" => $moderna_data["total_mild_scnd"],
            "total_srs_moderna_scnd" => $moderna_data["total_srs_scnd"],
            "total_dfrd_moderna_scnd" => $moderna_data["total_dfrd_scnd"],
            "total_rfsd_moderna_scnd" => $moderna_data["total_rfsd_scnd"],
            "total_wstge_moderna_scnd" => $moderna_data["total_wstge_scnd"],
            "p_cvrge_moderna_scnd" => $moderna_data["p_cvrge_scnd"],
            "total_c_rate_moderna_scnd" =>  $moderna_data["total_vcted_scnd"] / $request->moderna_allocated_second * 100,
            "total_r_unvcted_scnd_moderna" => $moderna_data["total_r_unvcted_scnd"],
            //MODERNA END


            //JOHNSON
            "total_epop_johnson_a1" => $johnson_data["total_epop_a1"],
            "total_epop_johnson_a2" => $johnson_data["total_epop_a2"],
            "total_epop_johnson_a3" => $johnson_data["total_epop_a3"],
            "total_epop_johnson_a4" => $johnson_data["total_epop_a4"],
            "total_epop_johnson_a5" => $johnson_data["total_epop_a5"],
            "total_epop_johnson_b1" => $johnson_data["total_epop_b1"],
            "total_epop_johnson_b2" => $johnson_data["total_epop_b2"],
            "total_epop_johnson_b3" => $johnson_data["total_epop_b3"],
            "total_epop_johnson_b4" => $johnson_data["total_epop_b4"],
            "total_epop_johnson" => $johnson_data["total_epop"],
            "total_vallocated_johnson_frst" => $request->johnson_allocated_first,
            "total_vallocated_johnson_scnd" => $request->johnson_allocated_first,
            "total_vallocated_johnson" => $request->johnson_allocated_first + $request->johnson_allocated_second,
            "total_johnson_a1_frst" => $johnson_data["total_a1_frst"],
            "total_johnson_a2_frst" => $johnson_data["total_a2_frst"],
            "total_johnson_a3_frst" => $johnson_data["total_a3_frst"],
            "total_johnson_a4_frst" => $johnson_data["total_a4_frst"],
            "total_johnson_a5_frst" => $johnson_data["total_a5_frst"],
            "total_johnson_b1_frst" => $johnson_data["total_b1_frst"],
            "total_johnson_b2_frst" => $johnson_data["total_b2_frst"],
            "total_johnson_b3_frst" => $johnson_data["total_b3_frst"],
            "total_johnson_b4_frst" => $johnson_data["total_b4_frst"],
            "total_vcted_johnson_frst" => $johnson_data["total_vcted_frst"],
            "total_mild_johnson_frst" => $johnson_data["total_mild_frst"],
            "total_srs_johnson_frst" => $johnson_data["total_srs_frst"],
            "total_dfrd_johnson_frst" => $johnson_data["total_dfrd_frst"],
            "total_rfsd_johnson_frst" => $johnson_data["total_rfsd_frst"],
            "total_wstge_johnson_frst" => $johnson_data["total_wstge_frst"],
            "p_cvrge_johnson_frst" => $johnson_data["p_cvrge_frst"],
            "total_c_rate_johnson_frst" => $johnson_data["total_vcted_frst"] / $request->johnson_allocated_first * 100,
            "total_r_unvcted_frst_johnson" => $johnson_data["total_r_unvcted_frst"],

            "total_johnson_a1_scnd" => $johnson_data["total_a1_scnd"],
            "total_johnson_a2_scnd" => $johnson_data["total_a2_scnd"],
            "total_johnson_a3_scnd" => $johnson_data["total_a3_scnd"],
            "total_johnson_a4_scnd" => $johnson_data["total_a4_scnd"],
            "total_johnson_a5_scnd" => $johnson_data["total_a5_scnd"],
            "total_johnson_b1_scnd" => $johnson_data["total_b1_scnd"],
            "total_johnson_b2_scnd" => $johnson_data["total_b2_scnd"],
            "total_johnson_b3_scnd" => $johnson_data["total_b3_scnd"],
            "total_johnson_b4_scnd" => $johnson_data["total_b4_scnd"],
            "total_vcted_johnson_scnd" => $johnson_data["total_vcted_scnd"],
            "total_mild_johnson_scnd" => $johnson_data["total_mild_scnd"],
            "total_srs_johnson_scnd" => $johnson_data["total_srs_scnd"],
            "total_dfrd_johnson_scnd" => $johnson_data["total_dfrd_scnd"],
            "total_rfsd_johnson_scnd" => $johnson_data["total_rfsd_scnd"],
            "total_wstge_johnson_scnd" => $johnson_data["total_wstge_scnd"],
            "p_cvrge_johnson_scnd" => $johnson_data["p_cvrge_scnd"],
            "total_c_rate_johnson_scnd" => $johnson_data["total_vcted_scnd"] / $request->johnson_allocated_second * 100,
            "total_r_unvcted_scnd_johnson" => $johnson_data["total_r_unvcted_scnd"],
            //JOHNSON END



            "total_vallocated_frst" => $total_data["total_vallocated_overall_frst"],
            "total_vallocated_scnd" => $total_data["total_vallocated_overall_scnd"],
            "total_vallocated" => $total_data["total_vallocated_overall"],
            "total_a1" => $total_data["total_overall_a1_frst"],
            "total_a2" => $total_data["total_overall_a2_frst"],
            "total_a3" => $total_data["total_overall_a3_frst"],
            "total_a4" => $total_data["total_overall_a4_frst"],
            "total_a5" => $total_data["total_overall_a5_frst"],
            "total_b1" => $total_data["total_overall_b1_frst"],
            "total_b2" => $total_data["total_overall_b2_frst"],
            "total_b3" => $total_data["total_overall_b3_frst"],
            "total_b4" => $total_data["total_overall_b4_frst"],
            "total_vcted_frst" => $total_data["total_vcted_overall_frst"],
            "total_mild" => $total_data["total_overall_mild_frst"],
            "total_serious" => $total_data["total_overall_srs_frst"],
            "total_deferred" => $total_data["total_overall_dfrd_frst"],
            "total_refused" => $total_data["total_overall_rfsd_frst"],
            "total_wastage" => $total_data["total_overall_wstge_frst"],
            "total_p_cvrge_frst" => $total_data["p_cvrge_overall_frst"],
            "total_c_rate_frst" => $total_data["total_c_rate_overall_frst"],
            "total_r_unvcted_frst" => $total_data["total_r_unvcted_overall_frst"],

            "total_overall_a1" => $total_data["total_overall_a1_scnd"],
            "total_overall_a2" => $total_data["total_overall_a2_scnd"],
            "total_overall_a3" => $total_data["total_overall_a3_scnd"],
            "total_overall_a4" => $total_data["total_overall_a4_scnd"],
            "total_overall_a5" => $total_data["total_overall_a5_scnd"],
            "total_overall_b1" => $total_data["total_overall_b1_scnd"],
            "total_overall_b2" => $total_data["total_overall_b2_scnd"],
            "total_overall_b3" => $total_data["total_overall_b3_scnd"],
            "total_overall_b4" => $total_data["total_overall_b4_scnd"],
            "total_vcted_scnd" => $total_data["total_vcted_overall_scnd"],
            "total_overall_mild" => $total_data["total_overall_mild_scnd"],
            "total_overall_serious" => $total_data["total_overall_srs_scnd"],
            "total_overall_deferred" => $total_data["total_overall_dfrd_scnd"],
            "total_overall_refused" => $total_data["total_overall_rfsd_scnd"],
            "total_overall_wastage" => $total_data["total_overall_wstge_scnd"],
            "total_overall_p_coverage" => $total_data["p_cvrge_overall_scnd"],
            "total_overall_c_rate" => $total_data["total_c_rate_overall_scnd"],
            "total_overall_r_unvcted" => $total_data["total_r_unvcted_overall_scnd"],


        ];

        if($request->pagination_table == "true")
            return view("vaccine.vaccine_table", $data);

        return view("vaccine.vaccine_content_municipality",$data);
    }



    public function vaccinatedFacilityContent(Request $request){


        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $vaccine_accomplishment = VaccineAccomplished::where('facility_id',$request->facility_id)
            ->where(function($query) use($date_start,$date_end){
                $query->whereBetween("date_first",[$date_start,$date_end])
                    ->orWhereBetween("date_second",[$date_start,$date_end]);
            });

        if($request->typeof_vaccine_filter)
            $vaccine_accomplishment = $vaccine_accomplishment->where("typeof_vaccine",$request->typeof_vaccine_filter);


        if($request->priority_filter)
            $vaccine_accomplishment = $vaccine_accomplishment->where("priority",$request->priority_filter);

        $vaccine_accomplishment = $vaccine_accomplishment ->orderBy('id','desc')->paginate(8);

        $request->facility_content = "true";
        $request->typeof_vaccine = "sinovac";
        $sinovac_data = $this->dataCollapseFacility($request);
        $request->typeof_vaccine = "astrazeneca";
        $astrazeneca_data = $this->dataCollapseFacility($request);
        $request->typeof_vaccine = "pfizer";
        $pfizer_data = $this->dataCollapseFacility($request);
        $request->typeof_vaccine = "sputnikv";
        $sputnikv_data = $this->dataCollapseFacility($request);
        $request->typeof_vaccine = "moderna";
        $moderna_data = $this->dataCollapseFacility($request);
        $request->typeof_vaccine = "johnson";
        $johnson_data = $this->dataCollapseFacility($request);
        $request->typeof_vaccine = "total";
        $total_data = $this->dataCollapseFacility($request);

        $data = [
            "vaccine_accomplishment" => $vaccine_accomplishment,
            "facility_id" => $request->facility_id,
            "province_id" => Facility::find($request->facility_id)->province,
            "date_start" => $request->date_start,
            "date_end" => $request->date_end,
            "tri_city" => $request->tri_city,
            "date_range" => $request->date_range,
            "muncity_filter" =>$request->muncity_filter,
            "typeof_vaccine_filter" => $request->typeof_vaccine_filter,
            "priority_filter" => $request->priority_filter,
            //SINOVAC
            "total_epop_svac_a1" => $sinovac_data["total_epop_a1"],
            "total_epop_svac_a2" => $sinovac_data["total_epop_a2"],
            "total_epop_svac_a3" => $sinovac_data["total_epop_a3"],
            "total_epop_svac_a4" => $sinovac_data["total_epop_a4"],
            "total_epop_svac_a5" => $sinovac_data["total_epop_a5"],
            "total_epop_svac_b1" => $sinovac_data["total_epop_b1"],
            "total_epop_svac_b2" => $sinovac_data["total_epop_b2"],
            "total_epop_svac_b3" => $sinovac_data["total_epop_b3"],
            "total_epop_svac_b4" => $sinovac_data["total_epop_b4"],
            "total_epop_svac" => $sinovac_data["total_epop"],
            "total_vallocated_svac_frst" => $request->sinovac_allocated_first,
            "total_vallocated_svac_scnd" =>  $request->sinovac_allocated_second,
            "total_vallocated_svac" => $request->sinovac_allocated_first + $request->sinovac_allocated_second,
            "total_svac_a1_frst" => $sinovac_data["total_a1_frst"],
            "total_svac_a2_frst" => $sinovac_data["total_a2_frst"],
            "total_svac_a3_frst" => $sinovac_data["total_a3_frst"],
            "total_svac_a4_frst" => $sinovac_data["total_a4_frst"],
            "total_svac_a5_frst" => $sinovac_data["total_a5_frst"],
            "total_svac_b1_frst" => $sinovac_data["total_b1_frst"],
            "total_svac_b2_frst" => $sinovac_data["total_b2_frst"],
            "total_svac_b3_frst" => $sinovac_data["total_b3_frst"],
            "total_svac_b4_frst" => $sinovac_data["total_b4_frst"],
            "total_vcted_svac_frst" => $sinovac_data["total_vcted_frst"],
            "total_mild_svac_frst" => $sinovac_data["total_mild_frst"],
            "total_srs_svac_frst" => $sinovac_data["total_srs_frst"],
            "total_dfrd_svac_frst" => $sinovac_data["total_dfrd_frst"],
            "total_rfsd_svac_frst" => $sinovac_data["total_rfsd_frst"],
            "total_wstge_svac_frst" => $sinovac_data["total_wstge_frst"],
            "p_cvrge_svac_frst" => $sinovac_data["p_cvrge_frst"],
            "total_c_rate_svac_frst" => $sinovac_data["total_vcted_frst"] /  $request->sinovac_allocated_first * 100,
            "total_r_unvcted_frst_svac" => $sinovac_data["total_r_unvcted_frst"],

            "total_svac_a1_scnd" => $sinovac_data["total_a1_scnd"],
            "total_svac_a2_scnd" => $sinovac_data["total_a2_scnd"],
            "total_svac_a3_scnd" => $sinovac_data["total_a3_scnd"],
            "total_svac_a4_scnd" => $sinovac_data["total_a4_scnd"],
            "total_svac_a5_scnd" => $sinovac_data["total_a5_scnd"],
            "total_svac_b1_scnd" => $sinovac_data["total_b1_scnd"],
            "total_svac_b2_scnd" => $sinovac_data["total_b2_scnd"],
            "total_svac_b3_scnd" => $sinovac_data["total_b3_scnd"],
            "total_svac_b4_scnd" => $sinovac_data["total_b4_scnd"],
            "total_vcted_svac_scnd" => $sinovac_data["total_vcted_scnd"],
            "total_mild_svac_scnd" => $sinovac_data["total_mild_scnd"],
            "total_srs_svac_scnd" => $sinovac_data["total_srs_scnd"],
            "total_dfrd_svac_scnd" => $sinovac_data["total_dfrd_scnd"],
            "total_rfsd_svac_scnd" => $sinovac_data["total_rfsd_scnd"],
            "total_wstge_svac_scnd" => $sinovac_data["total_wstge_scnd"],
            "p_cvrge_svac_scnd" => $sinovac_data["p_cvrge_scnd"],
            "total_c_rate_svac_scnd" =>  $sinovac_data["total_vcted_scnd"] /  $request->sinovac_allocated_second * 100,
            "total_r_unvcted_scnd_svac" => $sinovac_data["total_r_unvcted_scnd"],
            //END SINOVAC

            //ASTRA
            "total_epop_astra_a1" => $astrazeneca_data["total_epop_a1"],
            "total_epop_astra_a2" => $astrazeneca_data["total_epop_a2"],
            "total_epop_astra_a3" => $astrazeneca_data["total_epop_a3"],
            "total_epop_astra_a4" => $astrazeneca_data["total_epop_a4"],
            "total_epop_astra_a5" => $astrazeneca_data["total_epop_a5"],
            "total_epop_astra_b1" => $astrazeneca_data["total_epop_b1"],
            "total_epop_astra_b2" => $astrazeneca_data["total_epop_b2"],
            "total_epop_astra_b3" => $astrazeneca_data["total_epop_b3"],
            "total_epop_astra_b4" => $astrazeneca_data["total_epop_b4"],
            "total_epop_astra" => $astrazeneca_data["total_epop"],
            "total_vallocated_astra_frst" => $request->astrazeneca_allocated_first,
            "total_vallocated_astra_scnd" =>  $request->astrazeneca_allocated_second,
            "total_vallocated_astra" => $request->astrazeneca_allocated_first + $request->astrazeneca_allocated_second,
            "total_astra_a1_frst" => $astrazeneca_data["total_a1_frst"],
            "total_astra_a2_frst" => $astrazeneca_data["total_a2_frst"],
            "total_astra_a3_frst" => $astrazeneca_data["total_a3_frst"],
            "total_astra_a4_frst" => $astrazeneca_data["total_a4_frst"],
            "total_astra_a5_frst" => $astrazeneca_data["total_a5_frst"],
            "total_astra_b1_frst" => $astrazeneca_data["total_b1_frst"],
            "total_astra_b2_frst" => $astrazeneca_data["total_b2_frst"],
            "total_astra_b3_frst" => $astrazeneca_data["total_b3_frst"],
            "total_astra_b4_frst" => $astrazeneca_data["total_b4_frst"],
            "total_vcted_astra_frst" => $astrazeneca_data["total_vcted_frst"],
            "total_mild_astra_frst" => $astrazeneca_data["total_mild_frst"],
            "total_srs_astra_frst" => $astrazeneca_data["total_srs_frst"],
            "total_dfrd_astra_frst" => $astrazeneca_data["total_dfrd_frst"],
            "total_rfsd_astra_frst" => $astrazeneca_data["total_rfsd_frst"],
            "total_wstge_astra_frst" => $astrazeneca_data["total_wstge_frst"],
            "p_cvrge_astra_frst" => $astrazeneca_data["p_cvrge_frst"],
            "total_c_rate_astra_frst" =>  $astrazeneca_data["total_vcted_frst"] /  $request->astrazeneca_allocated_first * 100,
            "total_r_unvcted_frst_astra" => $astrazeneca_data["total_r_unvcted_frst"],

            "total_astra_a1_scnd" => $astrazeneca_data["total_a1_scnd"],
            "total_astra_a2_scnd" => $astrazeneca_data["total_a2_scnd"],
            "total_astra_a3_scnd" => $astrazeneca_data["total_a3_scnd"],
            "total_astra_a4_scnd" => $astrazeneca_data["total_a4_scnd"],
            "total_astra_a5_scnd" => $astrazeneca_data["total_a5_scnd"],
            "total_astra_b1_scnd" => $astrazeneca_data["total_b1_scnd"],
            "total_astra_b2_scnd" => $astrazeneca_data["total_b2_scnd"],
            "total_astra_b3_scnd" => $astrazeneca_data["total_b3_scnd"],
            "total_astra_b4_scnd" => $astrazeneca_data["total_b4_scnd"],
            "total_vcted_astra_scnd" => $astrazeneca_data["total_vcted_scnd"],
            "total_mild_astra_scnd" => $astrazeneca_data["total_mild_scnd"],
            "total_srs_astra_scnd" => $astrazeneca_data["total_srs_scnd"],
            "total_dfrd_astra_scnd" => $astrazeneca_data["total_dfrd_scnd"],
            "total_rfsd_astra_scnd" => $astrazeneca_data["total_rfsd_scnd"],
            "total_wstge_astra_scnd" => $astrazeneca_data["total_wstge_scnd"],
            "p_cvrge_astra_scnd" => $astrazeneca_data["p_cvrge_scnd"],
            "total_c_rate_astra_scnd" => $astrazeneca_data["total_vcted_scnd"] /  $request->astrazeneca_allocated_second * 100,
            "total_r_unvcted_scnd_astra" => $astrazeneca_data["total_r_unvcted_scnd"],
            //END ASTRA

            //PFIZER
            "total_epop_pfizer_a1" => $pfizer_data["total_epop_a1"],
            "total_epop_pfizer_a2" => $pfizer_data["total_epop_a2"],
            "total_epop_pfizer_a3" => $pfizer_data["total_epop_a3"],
            "total_epop_pfizer_a4" => $pfizer_data["total_epop_a4"],
            "total_epop_pfizer_a5" => $pfizer_data["total_epop_a5"],
            "total_epop_pfizer_b1" => $pfizer_data["total_epop_b1"],
            "total_epop_pfizer_b2" => $pfizer_data["total_epop_b2"],
            "total_epop_pfizer_b3" => $pfizer_data["total_epop_b3"],
            "total_epop_pfizer_b4" => $pfizer_data["total_epop_b4"],
            "total_epop_pfizer" => $pfizer_data["total_epop"],
            "total_vallocated_pfizer_frst" => $request->pfizer_allocated_first,
            "total_vallocated_pfizer_scnd" => $request->pfizer_allocated_second,
            "total_vallocated_pfizer" => $request->pfizer_allocated_first +  $request->pfizer_allocated_second,
            "total_pfizer_a1_frst" => $pfizer_data["total_a1_frst"],
            "total_pfizer_a2_frst" => $pfizer_data["total_a2_frst"],
            "total_pfizer_a3_frst" => $pfizer_data["total_a3_frst"],
            "total_pfizer_a4_frst" => $pfizer_data["total_a4_frst"],
            "total_pfizer_a5_frst" => $pfizer_data["total_a5_frst"],
            "total_pfizer_b1_frst" => $pfizer_data["total_b1_frst"],
            "total_pfizer_b2_frst" => $pfizer_data["total_b2_frst"],
            "total_pfizer_b3_frst" => $pfizer_data["total_b3_frst"],
            "total_pfizer_b4_frst" => $pfizer_data["total_b4_frst"],
            "total_vcted_pfizer_frst" => $pfizer_data["total_vcted_frst"],
            "total_mild_pfizer_frst" => $pfizer_data["total_mild_frst"],
            "total_srs_pfizer_frst" => $pfizer_data["total_srs_frst"],
            "total_dfrd_pfizer_frst" => $pfizer_data["total_dfrd_frst"],
            "total_rfsd_pfizer_frst" => $pfizer_data["total_rfsd_frst"],
            "total_wstge_pfizer_frst" => $pfizer_data["total_wstge_frst"],
            "p_cvrge_pfizer_frst" => $pfizer_data["p_cvrge_frst"],
            "total_c_rate_pfizer_frst" =>  $pfizer_data["total_vcted_frst"] /  $request->pfizer_allocated_first * 100,
            "total_r_unvcted_frst_pfizer" => $pfizer_data["total_r_unvcted_frst"],

            "total_pfizer_a1_scnd" => $pfizer_data["total_a1_scnd"],
            "total_pfizer_a2_scnd" => $pfizer_data["total_a2_scnd"],
            "total_pfizer_a3_scnd" => $pfizer_data["total_a3_scnd"],
            "total_pfizer_a4_scnd" => $pfizer_data["total_a4_scnd"],
            "total_pfizer_a5_scnd" => $pfizer_data["total_a5_scnd"],
            "total_pfizer_b1_scnd" => $pfizer_data["total_b1_scnd"],
            "total_pfizer_b2_scnd" => $pfizer_data["total_b2_scnd"],
            "total_pfizer_b3_scnd" => $pfizer_data["total_b3_scnd"],
            "total_pfizer_b4_scnd" => $pfizer_data["total_b4_scnd"],
            "total_vcted_pfizer_scnd" => $pfizer_data["total_vcted_scnd"],
            "total_mild_pfizer_scnd" => $pfizer_data["total_mild_scnd"],
            "total_srs_pfizer_scnd" => $pfizer_data["total_srs_scnd"],
            "total_dfrd_pfizer_scnd" => $pfizer_data["total_dfrd_scnd"],
            "total_rfsd_pfizer_scnd" => $pfizer_data["total_rfsd_scnd"],
            "total_wstge_pfizer_scnd" => $pfizer_data["total_wstge_scnd"],
            "p_cvrge_pfizer_scnd" => $pfizer_data["p_cvrge_scnd"],
            "total_c_rate_pfizer_scnd" => $pfizer_data["total_vcted_scnd"] /  $request->pfizer_allocated_second * 100,
            "total_r_unvcted_scnd_pfizer" => $pfizer_data["total_r_unvcted_scnd"],
            //END PFIZER


            //SPUTNIKV
            "total_epop_sputnikv_a1" => $sputnikv_data["total_epop_a1"],
            "total_epop_sputnikv_a2" => $sputnikv_data["total_epop_a2"],
            "total_epop_sputnikv_a3" => $sputnikv_data["total_epop_a3"],
            "total_epop_sputnikv_a4" => $sputnikv_data["total_epop_a4"],
            "total_epop_sputnikv_a5" => $sputnikv_data["total_epop_a5"],
            "total_epop_sputnikv_b1" => $sputnikv_data["total_epop_b1"],
            "total_epop_sputnikv_b2" => $sputnikv_data["total_epop_b2"],
            "total_epop_sputnikv_b3" => $sputnikv_data["total_epop_b3"],
            "total_epop_sputnikv_b4" => $sputnikv_data["total_epop_b4"],
            "total_epop_sputnikv" => $sputnikv_data["total_epop"],
            "total_vallocated_sputnikv_frst" =>  $request->sputnikv_allocated_first,
            "total_vallocated_sputnikv_scnd" =>  $request->sputnikv_allocated_second,
            "total_vallocated_sputnikv" => $request->sputnikv_allocated_first + $request->sputnikv_allocated_second,
            "total_sputnikv_a1_frst" => $sputnikv_data["total_a1_frst"],
            "total_sputnikv_a2_frst" => $sputnikv_data["total_a2_frst"],
            "total_sputnikv_a3_frst" => $sputnikv_data["total_a3_frst"],
            "total_sputnikv_a4_frst" => $sputnikv_data["total_a4_frst"],
            "total_sputnikv_a5_frst" => $sputnikv_data["total_a5_frst"],
            "total_sputnikv_b1_frst" => $sputnikv_data["total_b1_frst"],
            "total_sputnikv_b2_frst" => $sputnikv_data["total_b2_frst"],
            "total_sputnikv_b3_frst" => $sputnikv_data["total_b3_frst"],
            "total_sputnikv_b4_frst" => $sputnikv_data["total_b4_frst"],
            "total_vcted_sputnikv_frst" => $sputnikv_data["total_vcted_frst"],
            "total_mild_sputnikv_frst" => $sputnikv_data["total_mild_frst"],
            "total_srs_sputnikv_frst" => $sputnikv_data["total_srs_frst"],
            "total_dfrd_sputnikv_frst" => $sputnikv_data["total_dfrd_frst"],
            "total_rfsd_sputnikv_frst" => $sputnikv_data["total_rfsd_frst"],
            "total_wstge_sputnikv_frst" => $sputnikv_data["total_wstge_frst"],
            "p_cvrge_sputnikv_frst" => $sputnikv_data["p_cvrge_frst"],
            "total_c_rate_sputnikv_frst" =>  $sputnikv_data["total_vcted_frst"] /  $request->sputnikv_allocated_first * 100,
            "total_r_unvcted_frst_sputnikv" => $sputnikv_data["total_r_unvcted_frst"],

            "total_sputnikv_a1_scnd" => $sputnikv_data["total_a1_scnd"],
            "total_sputnikv_a2_scnd" => $sputnikv_data["total_a2_scnd"],
            "total_sputnikv_a3_scnd" => $sputnikv_data["total_a3_scnd"],
            "total_sputnikv_a4_scnd" => $sputnikv_data["total_a4_scnd"],
            "total_sputnikv_a5_scnd" => $sputnikv_data["total_a5_scnd"],
            "total_sputnikv_b1_scnd" => $sputnikv_data["total_b1_scnd"],
            "total_sputnikv_b2_scnd" => $sputnikv_data["total_b2_scnd"],
            "total_sputnikv_b3_scnd" => $sputnikv_data["total_b3_scnd"],
            "total_sputnikv_b4_scnd" => $sputnikv_data["total_b4_scnd"],
            "total_vcted_sputnikv_scnd" => $sputnikv_data["total_vcted_scnd"],
            "total_mild_sputnikv_scnd" => $sputnikv_data["total_mild_scnd"],
            "total_srs_sputnikv_scnd" => $sputnikv_data["total_srs_scnd"],
            "total_dfrd_sputnikv_scnd" => $sputnikv_data["total_dfrd_scnd"],
            "total_rfsd_sputnikv_scnd" => $sputnikv_data["total_rfsd_scnd"],
            "total_wstge_sputnikv_scnd" => $sputnikv_data["total_wstge_scnd"],
            "p_cvrge_sputnikv_scnd" => $sputnikv_data["p_cvrge_scnd"],
            "total_c_rate_sputnikv_scnd" =>   $sputnikv_data["total_vcted_scnd"] /  $request->sputnikv_allocated_second * 100,
            "total_r_unvcted_scnd_sputnikv" => $sputnikv_data["total_r_unvcted_scnd"],
            //END SPUTNIKV

            //MODERNA
            "total_epop_moderna_a1" => $moderna_data["total_epop_a1"],
            "total_epop_moderna_a2" => $moderna_data["total_epop_a2"],
            "total_epop_moderna_a3" => $moderna_data["total_epop_a3"],
            "total_epop_moderna_a4" => $moderna_data["total_epop_a4"],
            "total_epop_moderna_a5" => $moderna_data["total_epop_a5"],
            "total_epop_moderna_b1" => $moderna_data["total_epop_b1"],
            "total_epop_moderna_b2" => $moderna_data["total_epop_b2"],
            "total_epop_moderna_b3" => $moderna_data["total_epop_b3"],
            "total_epop_moderna_b4" => $moderna_data["total_epop_b4"],
            "total_epop_moderna" => $moderna_data["total_epop"],
            "total_vallocated_moderna_frst" => $request->moderna_allocated_first,
            "total_vallocated_moderna_scnd" => $request->moderna_allocated_second,
            "total_vallocated_moderna" => $request->moderna_allocated_first + $request->moderna_allocated_second,
            "total_moderna_a1_frst" => $moderna_data["total_a1_frst"],
            "total_moderna_a2_frst" => $moderna_data["total_a2_frst"],
            "total_moderna_a3_frst" => $moderna_data["total_a3_frst"],
            "total_moderna_a4_frst" => $moderna_data["total_a4_frst"],
            "total_moderna_a5_frst" => $moderna_data["total_a5_frst"],
            "total_moderna_b1_frst" => $moderna_data["total_b1_frst"],
            "total_moderna_b2_frst" => $moderna_data["total_b2_frst"],
            "total_moderna_b3_frst" => $moderna_data["total_b3_frst"],
            "total_moderna_b4_frst" => $moderna_data["total_b4_frst"],
            "total_vcted_moderna_frst" => $moderna_data["total_vcted_frst"],
            "total_mild_moderna_frst" => $moderna_data["total_mild_frst"],
            "total_srs_moderna_frst" => $moderna_data["total_srs_frst"],
            "total_dfrd_moderna_frst" => $moderna_data["total_dfrd_frst"],
            "total_rfsd_moderna_frst" => $moderna_data["total_rfsd_frst"],
            "total_wstge_moderna_frst" => $moderna_data["total_wstge_frst"],
            "p_cvrge_moderna_frst" => $moderna_data["p_cvrge_frst"],
            "total_c_rate_moderna_frst" =>  $moderna_data["total_vcted_frst"] /  $request->moderna_allocated_first * 100,
            "total_r_unvcted_frst_moderna" => $moderna_data["total_r_unvcted_frst"],

            "total_moderna_a1_scnd" => $moderna_data["total_a1_scnd"],
            "total_moderna_a2_scnd" => $moderna_data["total_a2_scnd"],
            "total_moderna_a3_scnd" => $moderna_data["total_a3_scnd"],
            "total_moderna_a4_scnd" => $moderna_data["total_a4_scnd"],
            "total_moderna_a5_scnd" => $moderna_data["total_a5_scnd"],
            "total_moderna_b1_scnd" => $moderna_data["total_b1_scnd"],
            "total_moderna_b2_scnd" => $moderna_data["total_b2_scnd"],
            "total_moderna_b3_scnd" => $moderna_data["total_b3_scnd"],
            "total_moderna_b4_scnd" => $moderna_data["total_b4_scnd"],
            "total_vcted_moderna_scnd" => $moderna_data["total_vcted_scnd"],
            "total_mild_moderna_scnd" => $moderna_data["total_mild_scnd"],
            "total_srs_moderna_scnd" => $moderna_data["total_srs_scnd"],
            "total_dfrd_moderna_scnd" => $moderna_data["total_dfrd_scnd"],
            "total_rfsd_moderna_scnd" => $moderna_data["total_rfsd_scnd"],
            "total_wstge_moderna_scnd" => $moderna_data["total_wstge_scnd"],
            "p_cvrge_moderna_scnd" => $moderna_data["p_cvrge_scnd"],
            "total_c_rate_moderna_scnd" => $moderna_data["total_vcted_scnd"] /  $request->moderna_allocated_second * 100,
            "total_r_unvcted_scnd_moderna" => $moderna_data["total_r_unvcted_scnd"],
            //END MODERNA


            //JOHNSON
            "total_epop_johnson_a1" => $johnson_data["total_epop_a1"],
            "total_epop_johnson_a2" => $johnson_data["total_epop_a2"],
            "total_epop_johnson_a3" => $johnson_data["total_epop_a3"],
            "total_epop_johnson_a4" => $johnson_data["total_epop_a4"],
            "total_epop_johnson_a5" => $johnson_data["total_epop_a5"],
            "total_epop_johnson_b1" => $johnson_data["total_epop_b1"],
            "total_epop_johnson_b2" => $johnson_data["total_epop_b2"],
            "total_epop_johnson_b3" => $johnson_data["total_epop_b3"],
            "total_epop_johnson_b4" => $johnson_data["total_epop_b4"],
            "total_epop_johnson" => $johnson_data["total_epop"],
            "total_vallocated_johnson_frst" => $request->johnson_allocated_first,
            "total_vallocated_johnson_scnd" => $request->johnson_allocated_first,
            "total_vallocated_johnson" => $request->johnson_allocated_first + $request->johnson_allocated_first,
            "total_johnson_a1_frst" => $johnson_data["total_a1_frst"],
            "total_johnson_a2_frst" => $johnson_data["total_a2_frst"],
            "total_johnson_a3_frst" => $johnson_data["total_a3_frst"],
            "total_johnson_a4_frst" => $johnson_data["total_a4_frst"],
            "total_johnson_a5_frst" => $johnson_data["total_a5_frst"],
            "total_johnson_b1_frst" => $johnson_data["total_b1_frst"],
            "total_johnson_b2_frst" => $johnson_data["total_b2_frst"],
            "total_johnson_b3_frst" => $johnson_data["total_b3_frst"],
            "total_johnson_b4_frst" => $johnson_data["total_b4_frst"],
            "total_vcted_johnson_frst" => $johnson_data["total_vcted_frst"],
            "total_mild_johnson_frst" => $johnson_data["total_mild_frst"],
            "total_srs_johnson_frst" => $johnson_data["total_srs_frst"],
            "total_dfrd_johnson_frst" => $johnson_data["total_dfrd_frst"],
            "total_rfsd_johnson_frst" => $johnson_data["total_rfsd_frst"],
            "total_wstge_johnson_frst" => $johnson_data["total_wstge_frst"],
            "p_cvrge_johnson_frst" => $johnson_data["p_cvrge_frst"],
            "total_c_rate_johnson_frst" => $johnson_data["total_vcted_frst"] /  $request->johnson_allocated_first * 100,
            "total_r_unvcted_frst_johnson" => $johnson_data["total_r_unvcted_frst"],

            "total_johnson_a1_scnd" => $johnson_data["total_a1_scnd"],
            "total_johnson_a2_scnd" => $johnson_data["total_a2_scnd"],
            "total_johnson_a3_scnd" => $johnson_data["total_a3_scnd"],
            "total_johnson_a4_scnd" => $johnson_data["total_a4_scnd"],
            "total_johnson_a5_scnd" => $johnson_data["total_a5_scnd"],
            "total_johnson_b1_scnd" => $johnson_data["total_b1_scnd"],
            "total_johnson_b2_scnd" => $johnson_data["total_b2_scnd"],
            "total_johnson_b3_scnd" => $johnson_data["total_b3_scnd"],
            "total_johnson_b4_scnd" => $johnson_data["total_b4_scnd"],
            "total_vcted_johnson_scnd" => $johnson_data["total_vcted_scnd"],
            "total_mild_johnson_scnd" => $johnson_data["total_mild_scnd"],
            "total_srs_johnson_scnd" => $johnson_data["total_srs_scnd"],
            "total_dfrd_johnson_scnd" => $johnson_data["total_dfrd_scnd"],
            "total_rfsd_johnson_scnd" => $johnson_data["total_rfsd_scnd"],
            "total_wstge_johnson_scnd" => $johnson_data["total_wstge_scnd"],
            "p_cvrge_johnson_scnd" => $johnson_data["p_cvrge_scnd"],
            "total_c_rate_johnson_scnd" => $johnson_data["total_vcted_frst"] /  $request->johnson_allocated_second * 100,
            "total_r_unvcted_scnd_johnson" => $johnson_data["total_r_unvcted_scnd"],
            //END JOHNSON

            "total_vallocated_frst" => $total_data["total_vallocated_overall_frst"],
            "total_vallocated_scnd" => $total_data["total_vallocated_overall_scnd"],
            "total_vallocated" => $total_data["total_vallocated_overall"],
            "total_overall_a1_first" => $total_data["total_overall_a1_frst"],
            "total_overall_a2_first" => $total_data["total_overall_a2_frst"],
            "total_overall_a3_first" => $total_data["total_overall_a3_frst"],
            "total_overall_a4_first" => $total_data["total_overall_a4_frst"],
            "total_overall_a5_first" => $total_data["total_overall_a5_frst"],
            "total_overall_b1_first" => $total_data["total_overall_b1_frst"],
            "total_overall_b2_first" => $total_data["total_overall_b2_frst"],
            "total_overall_b3_first" => $total_data["total_overall_b3_frst"],
            "total_overall_b4_first" => $total_data["total_overall_b4_frst"],
            "total_vcted_frst" => $total_data["total_vcted_overall_frst"],
            "total_overall_mild_first" => $total_data["total_overall_mild_frst"],
            "total_overall_serious_first" => $total_data["total_overall_srs_frst"],
            "total_overall_deferred_first" => $total_data["total_overall_dfrd_frst"],
            "total_rfsd_frst" => $total_data["total_overall_rfsd_frst"],
            "total_overall_wastage_first" => $total_data["total_overall_wstge_frst"],
            "total_p_cvrge_frst" => $total_data["p_cvrge_overall_frst"],
            "total_c_rate_frst" => $total_data["total_c_rate_overall_frst"],
            "total_r_unvcted_frst" => $total_data["total_r_unvcted_overall_frst"],

            "total_overall_a1_second" => $total_data["total_overall_a1_scnd"],
            "total_overall_a2_second" => $total_data["total_overall_a2_scnd"],
            "total_overall_a3_second" => $total_data["total_overall_a3_scnd"],
            "total_overall_a4_second" => $total_data["total_overall_a4_scnd"],
            "total_overall_a5_second" => $total_data["total_overall_a5_scnd"],
            "total_overall_b1_second" => $total_data["total_overall_b1_scnd"],
            "total_overall_b2_second" => $total_data["total_overall_b2_scnd"],
            "total_overall_b3_second" => $total_data["total_overall_b3_scnd"],
            "total_overall_b4_second" => $total_data["total_overall_b4_scnd"],
            "total_vcted_scnd" => $total_data["total_vcted_overall_scnd"],
            "total_overall_mild_second" => $total_data["total_overall_mild_scnd"],
            "total_overall_serious_second" => $total_data["total_overall_srs_scnd"],
            "total_overall_deferred_second" => $total_data["total_overall_dfrd_scnd"],
            "total_rfsd_scnd" => $total_data["total_overall_rfsd_scnd"],
            "total_overall_wastage_second" => $total_data["total_overall_wstge_scnd"],
            "total_p_cvrge_scnd" => $total_data["p_cvrge_overall_scnd"],
            "total_c_rate_scnd" => $total_data["total_c_rate_overall_scnd"],
            "total_r_unvcted_scnd" => $total_data["total_r_unvcted_overall_scnd"],



        ];

        if($request->pagination_table == "true"){
            return view("vaccine.vaccine_facility_table",$data);
        }
        return view("vaccine.vaccine_facility_content",$data);
    }

    public function vaccineSaved(Request $request)
    {
        $user_id = Session::get('auth')->id;
        $count = 0;
        foreach ($request->typeof_vaccine as $row){
            VaccineAccomplished::where("id",$request->vaccine_id[$count])->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->delete();
            $vaccine = new VaccineAccomplished();
            $vaccine->encoded_by = $user_id;
            $vaccine->province_id = $request->province_id;
            $vaccine->muncity_id = $request->muncity_id;
            $vaccine->typeof_vaccine = $request->typeof_vaccine[$count];
            $vaccine->priority = $request->priority[$count];
            if($request->date_first[$count])
                $vaccine->date_first = date("Y-m-d H:m:i", strtotime($request->date_first[$count]));
            if($request->date_second[$count])
                $vaccine->date_second = date("Y-m-d H:m:i", strtotime($request->date_second[$count]));
            $vaccine->vaccinated_first = $request->vaccinated_first[$count];
            $vaccine->vaccinated_second = $request->vaccinated_second[$count];
            $vaccine->mild_first = $request->mild_first[$count];
            $vaccine->mild_second = $request->mild_second[$count];
            $vaccine->serious_first = $request->serious_first[$count];
            $vaccine->serious_second = $request->serious_second[$count];
            $vaccine->refused_first = $request->refused_first[$count];
            $vaccine->refused_second = $request->refused_second[$count];
            $vaccine->deferred_first = $request->deferred_first[$count];
            $vaccine->deferred_second = $request->deferred_second[$count];
            $vaccine->wastage_first = $request->wastage_first[$count];
            $vaccine->wastage_second = $request->wastage_second[$count];
            $vaccine->no_eli_pop = $request->no_eli_pop[$count];
            $vaccine->vaccine_allocated_first = $request->vaccine_allocated_first[$count];
            $vaccine->vaccine_allocated_second = $request->vaccine_allocated_second[$count];
            $vaccine->save();
            $count++;
        }


        Session::put('vaccine_saved', true);


        return redirect('vaccine/vaccineview'.'/'.$request->province_id."?muncity_filter=".$request->muncity_filter."&last_page=".$request->last_Page);
    }

    public function vaccineFacilitySaved(Request $request)
    {
        $user_id = Session::get('auth')->id;
        $count = 0;
        foreach ($request->typeof_vaccine as $row){
            $vaccine = new VaccineAccomplished();
            VaccineAccomplished::where("id",$request->vaccine_id[$count])->delete();
            $vaccine->encoded_by = $user_id;
            $vaccine->province_id = $request->province_id;
            $vaccine->facility_id = $request->facility_id;
            $vaccine->typeof_vaccine = $request->typeof_vaccine[$count];
            $vaccine->priority = $request->priority[$count];
            if($request->date_first[$count])
                $vaccine->date_first = date("Y-m-d H:m:i", strtotime($request->date_first[$count]));
            if($request->date_second[$count])
                $vaccine->date_second = date("Y-m-d H:m:i", strtotime($request->date_second[$count]));
            $vaccine->vaccinated_first = $request->vaccinated_first[$count];
            $vaccine->vaccinated_second = $request->vaccinated_second[$count];
            $vaccine->mild_first = $request->mild_first[$count];
            $vaccine->mild_second = $request->mild_second[$count];
            $vaccine->serious_first = $request->serious_first[$count];
            $vaccine->serious_second = $request->serious_second[$count];
            $vaccine->refused_first = $request->refused_first[$count];
            $vaccine->refused_second = $request->refused_second[$count];
            $vaccine->deferred_first = $request->deferred_first[$count];
            $vaccine->deferred_second = $request->deferred_second[$count];
            $vaccine->wastage_first = $request->wastage_first[$count];
            $vaccine->wastage_second = $request->wastage_second[$count];
            $vaccine->no_eli_pop = $request->no_eli_pop[$count];
            $vaccine->vaccine_allocated_first = $request->vaccine_allocated_first[$count];
            $vaccine->vaccine_allocated_second = $request->vaccine_allocated_second[$count];
            $vaccine->save();
            $count++;
        }

        Session::put('vaccine_saved', true);

        return redirect('vaccine/facility'.'/'.$request->tri_city."?muncity_filter=".$request->muncity_filter);



    }

    public function vaccineUpdateView($id)
    {
        $province = Province::get();
        $vaccine = Vaccines::find($id);
        $muncity = Muncity::where('province_id', $vaccine->province_id)->get();
        $facility = Facility::where('province', $vaccine->province_id)->get();

        return view("vaccine.vaccinated_content", [
            "province" => $province,
            "muncity" => $muncity,
            "facility" => $facility,
            "vaccine" => $vaccine,
        ]);
    }

    public function getFacility($province_id)
    {
        return Facility::where('province', $province_id)->get();
    }

    public function exportExcel()
    {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=vaccine.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $vaccine = Session::get("vaccine");
        return view("vaccine.vaccine_excel", [
            "vaccine" => $vaccine,
        ]);
    }

    public function vaccineNewDelivery($id)
    {
        $province = Province::get();
        $vaccine = Vaccines::find($id);
        $muncity = Muncity::where('province_id', $vaccine->province_id)->get();
        $facility = Facility::where('province', $vaccine->province_id)->get();

        return view("vaccine.new_delivery", [
            "province" => $province,
            "muncity" => $muncity,
            "facility" => $facility,
            "vaccine" => $vaccine,
        ]);
    }

    public function getEliPop($muncity_id,$priority){
        $no_eli_pop = Muncity::find($muncity_id);
        if($priority == 'a1')
            return $no_eli_pop->a1;
        elseif($priority == 'a2')
            return $no_eli_pop->a2;
        elseif($priority == 'a3')
            return $no_eli_pop->a3;
        elseif($priority == 'a4')
            return $no_eli_pop->a4;
        elseif($priority == 'a5')
            return $no_eli_pop->a5;
        elseif($priority == 'b1')
            return $no_eli_pop->b1;
        elseif($priority == 'b2')
            return $no_eli_pop->b2;
        elseif($priority == 'b3')
            return $no_eli_pop->b3;
        elseif($priority == 'b4')
            return $no_eli_pop->b4;
    }

    public function getEliPopFacility($facility_id,$priority){
        $no_eli_pop = Facility::find($facility_id);
        if($priority == 'a1')
            return $no_eli_pop->a1;
        elseif($priority == 'a2')
            return $no_eli_pop->a2;
        elseif($priority == 'a3')
            return $no_eli_pop->a3;
        elseif($priority == 'a4')
            return $no_eli_pop->a4;
        elseif($priority == 'a5')
            return $no_eli_pop->a5;
        elseif($priority == 'b1')
            return $no_eli_pop->b1;
        elseif($priority == 'b2')
            return $no_eli_pop->b2;
        elseif($priority == 'b3')
            return $no_eli_pop->b4;
        elseif($priority == 'b4')
            return $no_eli_pop->b4;
    }

    public function getVaccineAllocated($muncity_id,$typeof_vaccine){
        $vaccine_allocated = Muncity::find($muncity_id);
        if($typeof_vaccine == 'Sinovac'){
            $data[0] = $vaccine_allocated->sinovac_allocated_first;
            $data[1] = $vaccine_allocated->sinovac_allocated_second;
        }
        elseif($typeof_vaccine == 'Astrazeneca'){
            $data[0] = $vaccine_allocated->astrazeneca_allocated_first;
            $data[1] = $vaccine_allocated->astrazeneca_allocated_second;
        }
        elseif($typeof_vaccine == 'SputnikV'){
            $data[0] = $vaccine_allocated->sputnikv_allocated_first;
            $data[1] = $vaccine_allocated->sputnikv_allocated_second;
        }
        elseif($typeof_vaccine == 'Pfizer'){
            $data[0] = $vaccine_allocated->pfizer_allocated_first;
            $data[1] = $vaccine_allocated->pfizer_allocated_second;
        }
        elseif($typeof_vaccine == 'Moderna'){
            $data[0] = $vaccine_allocated->moderna_allocated_first;
            $data[1] = $vaccine_allocated->moderna_allocated_second;
        }
        elseif($typeof_vaccine == 'Johnson'){
            $data[0] = $vaccine_allocated->johnson_allocated_first;
            $data[1] = $vaccine_allocated->johnson_allocated_second;
        }
        return $data;
    }
    public function getVaccineAllocatedFacility($facility_id,$typeof_vaccine){
        $vaccine_allocated = Facility::find($facility_id);
        if($typeof_vaccine == 'Sinovac'){
            $data[0] = $vaccine_allocated->sinovac_allocated_first;
            $data[1] = $vaccine_allocated->sinovac_allocated_second;
        }
        elseif($typeof_vaccine == 'Astrazeneca'){
            $data[0] = $vaccine_allocated->astrazeneca_allocated_first;
            $data[1] = $vaccine_allocated->astrazeneca_allocated_second;
        }
        elseif($typeof_vaccine == 'SputnikV'){
            $data[0] = $vaccine_allocated->sputnikv_allocated_first;
            $data[1] = $vaccine_allocated->sputnikv_allocated_second;
        }
        elseif($typeof_vaccine == 'Pfizer'){
            $data[0] = $vaccine_allocated->pfizer_allocated_first;
            $data[1] = $vaccine_allocated->pfizer_allocated_second;
        }
        elseif($typeof_vaccine == 'Moderna'){
            $data[0] = $vaccine_allocated->moderna_allocated_first;
            $data[1] = $vaccine_allocated->moderna_allocated_second;
        }
        elseif($typeof_vaccine == 'Johnson'){
            $data[0] = $vaccine_allocated->johnson_allocated_first;
            $data[1] = $vaccine_allocated->johnson_allocated_second;
        }
        return $data;
    }

    public function getVaccineAllocatedModal(Request $request)
    {
        $muncity = Muncity::where("id", $request->muncity_id)->where("province_id", $request->province_id)->first();
        $province = Province::find($request->province_id);
        return view('vaccine.vaccine_allocated_modal', [
            "muncity" => $muncity,
            "province_name" => $province->description,
            "province_id" => $request->province_id
        ]);
    }

    public function vaccineFacilityAllocated(Request $request)
    {
        $facility = Facility::where("id", $request->facility_id)->where("province", $request->province_id)->first();
        $province = Province::find($request->province_id);
        return view('vaccine.vaccine_facility_allocated', [
            "facility" => $facility,
            "province_name" => $province->description,
            "province_id" => $request->province_id
        ]);
    }

    public function vaccineFacilityEligiblePop(Request $request){
        $facility = Facility::where("id",$request->facility_id)->where("province",$request->province_id)->first();
        $province = Province::find($request->province_id);
        return view('vaccine.vaccine_facility_eligible',[
            "facility" => $facility,
            "province_name" => $province->description,
            "province_id" => $request->province_id
        ]);
    }

    public function vaccineEligiblePop(Request $request){
        $muncity = Muncity::where("id",$request->muncity_id)->where("province_id",$request->province_id)->first();
        $province = Province::find($request->province_id);
        return view('vaccine.vaccine_eligible_pop',[
            "muncity" => $muncity,
            "province_name" => $province->description,
            "province_id" => $request->province_id
        ]);
    }

    public function vaccineMap(){
        return view('vaccine.vaccine_map');
    }

    public function vaccineLineChart(){
        //for past 15 days
        $date_start_1 = date('Y-m-d',strtotime(Carbon::now()->subDays(31))).' 00:00:00';
        $date_end_1 = date('Y-m-d',strtotime(Carbon::now()->subDays(16))).' 23:59:59';
        $first_dose_past_1 = \DB::connection('mysql')->select("call vaccine_past_vaccinated('$date_start_1','$date_end_1','first')");
        $second_dose_past_1 = \DB::connection('mysql')->select("call vaccine_past_vaccinated('$date_start_1','$date_end_1','second')");

        $date_start_2 = date('Y-m-d',strtotime(Carbon::now()->subDays(16))).' 00:00:00';
        $date_end_2 = date('Y-m-d',strtotime(Carbon::now()->subDays(1))).' 23:59:59';
        $first_dose_past_2 = \DB::connection('mysql')->select("call vaccine_past_vaccinated('$date_start_2','$date_end_2','first')");
        $second_dose_past_2 = \DB::connection('mysql')->select("call vaccine_past_vaccinated('$date_start_2','$date_end_2','second')");
        ///
        return view('vaccine.vaccine_line_chart',[
            "first_dose_past_1" =>$first_dose_past_1,
            "second_dose_past_1" =>$second_dose_past_1,
            "first_dose_past_2" =>$first_dose_past_2,
            "second_dose_past_2" =>$second_dose_past_2,
        ]);
    }

    public function tabValueDeclaration(){
        return [
            "sinovac_bohol_first" => $this->sinovac_bohol_first,
            "sinovac_bohol_second" => $this->sinovac_bohol_second,
            "sinovac_cebu_first" => $this->sinovac_cebu_first,
            "sinovac_cebu_second" => $this->sinovac_cebu_second,
            "sinovac_negros_first" => $this->sinovac_negros_first,
            "sinovac_negros_second" => $this->sinovac_negros_second,
            "sinovac_siquijor_first" => $this->sinovac_siquijor_first,
            "sinovac_siquijor_second" => $this->sinovac_siquijor_second,
            "sinovac_cebu_facility_first" => $this->sinovac_cebu_facility_first,
            "sinovac_cebu_facility_second" => $this->sinovac_cebu_facility_second,
            "sinovac_mandaue_facility_first" => $this->sinovac_mandaue_facility_first,
            "sinovac_mandaue_facility_second" => $this->sinovac_mandaue_facility_second,
            "sinovac_lapu_facility_first" => $this->sinovac_lapu_facility_first,
            "sinovac_lapu_facility_second" => $this->sinovac_lapu_facility_second,
            "sinovac_region_first" => $this->sinovac_bohol_first + $this->sinovac_cebu_first + $this->sinovac_negros_first + $this->sinovac_siquijor_first + $this->sinovac_cebu_facility_first + $this->sinovac_mandaue_facility_first + $this->sinovac_lapu_facility_first,
            "sinovac_region_second" => $this->sinovac_bohol_second + $this->sinovac_cebu_second + $this->sinovac_negros_second + $this->sinovac_siquijor_second + $this->sinovac_cebu_facility_second + $this->sinovac_mandaue_facility_second + $this->sinovac_lapu_facility_second,

            "astra_bohol_first" => $this->astra_bohol_first,
            "astra_bohol_second" => $this->astra_bohol_second,
            "astra_cebu_first" => $this->astra_cebu_first,
            "astra_cebu_second" => $this->astra_cebu_second,
            "astra_negros_first" => $this->astra_negros_first,
            "astra_negros_second" => $this->astra_negros_second,
            "astra_siquijor_first" => $this->astra_siquijor_first,
            "astra_siquijor_second" => $this->astra_siquijor_second,
            "astra_cebu_facility_first" => $this->astra_cebu_facility_first,
            "astra_cebu_facility_second" => $this->astra_cebu_facility_second,
            "astra_mandaue_facility_first" => $this->astra_mandaue_facility_first,
            "astra_mandaue_facility_second" => $this->astra_mandaue_facility_second,
            "astra_lapu_facility_first" => $this->astra_lapu_facility_first,
            "astra_lapu_facility_second" => $this->astra_lapu_facility_second,
            "astra_region_first" => $this->astra_bohol_first + $this->astra_cebu_first + $this->astra_negros_first + $this->astra_siquijor_first + $this->astra_cebu_facility_first + $this->astra_mandaue_facility_first + $this->astra_lapu_facility_first,
            "astra_region_second" => $this->astra_bohol_second + $this->astra_cebu_second + $this->astra_negros_second + $this->astra_siquijor_second + $this->astra_cebu_facility_second + $this->astra_mandaue_facility_second + $this->astra_lapu_facility_second,

            "pfizer_bohol_first" => $this->pfizer_bohol_first,
            "pfizer_bohol_second" => $this->pfizer_bohol_second,
            "pfizer_cebu_first" => $this->pfizer_cebu_first,
            "pfizer_cebu_second" => $this->pfizer_cebu_second,
            "pfizer_negros_first" => $this->pfizer_negros_first,
            "pfizer_negros_second" => $this->pfizer_negros_second,
            "pfizer_siquijor_first" => $this->pfizer_siquijor_first,
            "pfizer_siquijor_second" => $this->pfizer_siquijor_second,
            "pfizer_cebu_facility_first" => $this->pfizer_cebu_facility_first,
            "pfizer_cebu_facility_second" => $this->pfizer_cebu_facility_second,
            "pfizer_mandaue_facility_first" => $this->pfizer_mandaue_facility_first,
            "pfizer_mandaue_facility_second" => $this->pfizer_mandaue_facility_second,
            "pfizer_lapu_facility_first" => $this->pfizer_lapu_facility_first,
            "pfizer_lapu_facility_second" => $this->pfizer_lapu_facility_second,
            "pfizer_region_first" => $this->pfizer_bohol_first + $this->pfizer_cebu_first + $this->pfizer_negros_first + $this->pfizer_siquijor_first + $this->pfizer_cebu_facility_first + $this->pfizer_mandaue_facility_first + $this->pfizer_lapu_facility_first,
            "pfizer_region_second" => $this->pfizer_bohol_second + $this->pfizer_cebu_second + $this->pfizer_negros_second + $this->pfizer_siquijor_second + $this->pfizer_cebu_facility_second + $this->pfizer_mandaue_facility_second + $this->pfizer_lapu_facility_second,

            "sputnikv_bohol_first" => $this->sputnikv_bohol_first,
            "sputnikv_bohol_second" => $this->sputnikv_bohol_second,
            "sputnikv_cebu_first" => $this->sputnikv_cebu_first,
            "sputnikv_cebu_second" => $this->sputnikv_cebu_second,
            "sputnikv_negros_first" => $this->sputnikv_negros_first,
            "sputnikv_negros_second" => $this->sputnikv_negros_second,
            "sputnikv_siquijor_first" => $this->sputnikv_siquijor_first,
            "sputnikv_siquijor_second" => $this->sputnikv_siquijor_second,
            "sputnikv_cebu_facility_first" => $this->sputnikv_cebu_facility_first,
            "sputnikv_cebu_facility_second" => $this->sputnikv_cebu_facility_second,
            "sputnikv_mandaue_facility_first" => $this->sputnikv_mandaue_facility_first,
            "sputnikv_mandaue_facility_second" => $this->sputnikv_mandaue_facility_second,
            "sputnikv_lapu_facility_first" => $this->sputnikv_lapu_facility_first,
            "sputnikv_lapu_facility_second" => $this->sputnikv_lapu_facility_second,
            "sputnikv_region_first" => $this->sputnikv_bohol_first + $this->sputnikv_cebu_first + $this->sputnikv_negros_first + $this->sputnikv_siquijor_first + $this->sputnikv_cebu_facility_first + $this->sputnikv_mandaue_facility_first + $this->sputnikv_lapu_facility_first,
            "sputnikv_region_second" => $this->sputnikv_bohol_second + $this->sputnikv_cebu_second + $this->sputnikv_negros_second + $this->sputnikv_siquijor_second + $this->sputnikv_cebu_facility_second + $this->sputnikv_mandaue_facility_second + $this->sputnikv_lapu_facility_second,

            "moderna_bohol_first" => $this->moderna_bohol_first,
            "moderna_bohol_second" => $this->moderna_bohol_second,
            "moderna_cebu_first" => $this->moderna_cebu_first,
            "moderna_cebu_second" => $this->moderna_cebu_second,
            "moderna_negros_first" => $this->moderna_negros_first,
            "moderna_negros_second" => $this->moderna_negros_second,
            "moderna_siquijor_first" => $this->moderna_siquijor_first,
            "moderna_siquijor_second" => $this->moderna_siquijor_second,
            "moderna_cebu_facility_first" => $this->moderna_cebu_facility_first,
            "moderna_cebu_facility_second" => $this->moderna_cebu_facility_second,
            "moderna_mandaue_facility_first" => $this->moderna_mandaue_facility_first,
            "moderna_mandaue_facility_second" => $this->moderna_mandaue_facility_second,
            "moderna_lapu_facility_first" => $this->moderna_lapu_facility_first,
            "moderna_lapu_facility_second" => $this->moderna_lapu_facility_second,
            "moderna_region_first" => $this->moderna_bohol_first + $this->moderna_cebu_first + $this->moderna_negros_first + $this->moderna_siquijor_first + $this->moderna_cebu_facility_first + $this->moderna_mandaue_facility_first + $this->moderna_lapu_facility_first,
            "moderna_region_second" => $this->moderna_bohol_second + $this->moderna_cebu_second + $this->moderna_negros_second + $this->moderna_siquijor_second + $this->moderna_cebu_facility_second + $this->moderna_mandaue_facility_second + $this->moderna_lapu_facility_second,

            "johnson_bohol_first" => $this->johnson_bohol_first,
            "johnson_bohol_second" => $this->johnson_bohol_second,
            "johnson_cebu_first" => $this->johnson_cebu_first,
            "johnson_cebu_second" => $this->johnson_cebu_second,
            "johnson_negros_first" => $this->johnson_negros_first,
            "johnson_negros_second" => $this->johnson_negros_second,
            "johnson_siquijor_first" => $this->johnson_siquijor_first,
            "johnson_siquijor_second" => $this->johnson_siquijor_second,
            "johnson_cebu_facility_first" => $this->johnson_cebu_facility_first,
            "johnson_cebu_facility_second" => $this->johnson_cebu_facility_second,
            "johnson_mandaue_facility_first" => $this->johnson_mandaue_facility_first,
            "johnson_mandaue_facility_second" => $this->johnson_mandaue_facility_second,
            "johnson_lapu_facility_first" => $this->johnson_lapu_facility_first,
            "johnson_lapu_facility_second" => $this->johnson_lapu_facility_second,
            "johnson_region_first" => $this->johnson_bohol_first + $this->johnson_cebu_first + $this->johnson_negros_first + $this->johnson_siquijor_first + $this->johnson_cebu_facility_first + $this->johnson_mandaue_facility_first + $this->johnson_lapu_facility_first,
            "johnson_region_second" => $this->johnson_bohol_second + $this->johnson_cebu_second + $this->johnson_negros_second + $this->johnson_siquijor_second + $this->johnson_cebu_facility_second + $this->johnson_mandaue_facility_second + $this->johnson_lapu_facility_second,


            "total_bohol_first" => $this->total_bohol_first,
            "total_bohol_second" => $this->total_bohol_second,
            "total_cebu_first" => $this->total_cebu_first,
            "total_cebu_second" => $this->total_cebu_second,
            "total_negros_first" =>  $this->total_negros_first,
            "total_negros_second" =>  $this->total_negros_second ,
            "total_siquijor_first" => $this->total_siquijor_first ,
            "total_siquijor_second" => $this->total_siquijor_second ,
            "total_cebu_facility_first" =>  $this->total_cebu_facility_first,
            "total_cebu_facility_second" => $this->total_cebu_facility_second,
            "total_mandaue_facility_first" =>  $this->total_mandaue_facility_first,
            "total_mandaue_facility_second" =>$this->total_mandaue_facility_second,
            "total_lapu_facility_first" => $this->total_lapu_facility_first,
            "total_lapu_facility_second" => $this->total_lapu_facility_second,
            "total_region_first" => $this->total_region_first,
            "total_region_second" => $this->total_region_second,

            //ELIGIBLE POP
            "eli_pop_bohol" => $this->eli_pop_bohol,
            "eli_pop_cebu" => $this->eli_pop_cebu,
            "eli_pop_negros" => $this->eli_pop_negros,
            "eli_pop_siquijor" => $this->eli_pop_siquijor,
            "eli_pop_cebu_facility"=> $this->eli_pop_cebu_facility,
            "eli_pop_mandaue_facility"=> $this->eli_pop_mandaue_facility,
            "eli_pop_lapu_facility"=> $this->eli_pop_lapu_facility,

            //VACCINATED_SINOVAC_FIRST
            "vcted_sinovac_bohol_first" => $this->vcted_sinovac_bohol_first,
            "vcted_sinovac_cebu_first" => $this->vcted_sinovac_cebu_first,
            "vcted_sinovac_negros_first" => $this->vcted_sinovac_negros_first,
            "vcted_sinovac_siquijor_first" => $this->vcted_sinovac_siquijor_first,
            "vcted_sinovac_cebu_facility_first" => $this->vcted_sinovac_cebu_facility_first,
            "vcted_sinovac_mandaue_facility_first" => $this->vcted_sinovac_mandaue_facility_first,
            "vcted_sinovac_lapu_facility_first" => $this->vcted_sinovac_lapu_facility_first,

            //VACCINATED_SINOVAC_SECOND
            "vcted_sinovac_bohol_second" => $this->vcted_sinovac_bohol_second,
            "vcted_sinovac_cebu_second" => $this->vcted_sinovac_cebu_second,
            "vcted_sinovac_negros_second" => $this->vcted_sinovac_negros_second,
            "vcted_sinovac_siquijor_second" => $this->vcted_sinovac_siquijor_second,
            "vcted_sinovac_cebu_facility_second" => $this->vcted_sinovac_cebu_facility_second,
            "vcted_sinovac_mandaue_facility_second" => $this->vcted_sinovac_mandaue_facility_second,
            "vcted_sinovac_lapu_facility_second" => $this->vcted_sinovac_lapu_facility_second,

            //VACCINATED_ASTRAZENECA_FIRST
            "vcted_astra_bohol_first" => $this->vcted_astra_bohol_first,
            "vcted_astra_cebu_first" => $this->vcted_astra_cebu_first,
            "vcted_astra_negros_first" => $this->vcted_astra_negros_first,
            "vcted_astra_siquijor_first" => $this->vcted_astra_siquijor_first,
            "vcted_astra_cebu_facility_first" => $this->vcted_astra_cebu_facility_first,
            "vcted_astra_mandaue_facility_first" => $this->vcted_astra_mandaue_facility_first,
            "vcted_astra_lapu_facility_first" => $this->vcted_astra_lapu_facility_first,

            //VACCINATED_ASTRAZENECA_SECOND
            "vcted_astra_bohol_second" => $this->vcted_astra_bohol_second,
            "vcted_astra_cebu_second" => $this->vcted_astra_cebu_second,
            "vcted_astra_negros_second" => $this->vcted_astra_negros_second,
            "vcted_astra_siquijor_second" => $this->vcted_astra_siquijor_second,
            "vcted_astra_cebu_facility_second" => $this->vcted_astra_cebu_facility_second,
            "vcted_astra_mandaue_facility_second" => $this->vcted_astra_mandaue_facility_second,
            "vcted_astra_lapu_facility_second" => $this->vcted_astra_lapu_facility_second,

            //VACCINATED_PFIZER_FIRST
            "vcted_pfizer_bohol_first" => $this->vcted_pfizer_bohol_first,
            "vcted_pfizer_cebu_first" => $this->vcted_pfizer_cebu_first,
            "vcted_pfizer_negros_first" => $this->vcted_pfizer_negros_first,
            "vcted_pfizer_siquijor_first" => $this->vcted_pfizer_siquijor_first,
            "vcted_pfizer_cebu_facility_first" => $this->vcted_pfizer_cebu_facility_first,
            "vcted_pfizer_mandaue_facility_first" => $this->vcted_pfizer_mandaue_facility_first,
            "vcted_pfizer_lapu_facility_first" => $this->vcted_pfizer_lapu_facility_first,

            //VACCINATED_PFIZER_SECOND
            "vcted_pfizer_bohol_second" => $this->vcted_pfizer_bohol_second,
            "vcted_pfizer_cebu_second" => $this->vcted_pfizer_cebu_second,
            "vcted_pfizer_negros_second" => $this->vcted_pfizer_negros_second,
            "vcted_pfizer_siquijor_second" => $this->vcted_pfizer_siquijor_second,
            "vcted_pfizer_cebu_facility_second" => $this->vcted_pfizer_cebu_facility_second,
            "vcted_pfizer_mandaue_facility_second" => $this->vcted_pfizer_mandaue_facility_second,
            "vcted_pfizer_lapu_facility_second" => $this->vcted_pfizer_lapu_facility_second,

            //VACCINATED_SPUTNIKV_FIRST
            "vcted_sputnikv_bohol_first" => $this->vcted_sputnikv_bohol_first,
            "vcted_sputnikv_cebu_first" => $this->vcted_sputnikv_cebu_first,
            "vcted_sputnikv_negros_first" => $this->vcted_sputnikv_negros_first,
            "vcted_sputnikv_siquijor_first" => $this->vcted_sputnikv_siquijor_first,
            "vcted_sputnikv_cebu_facility_first" => $this->vcted_sputnikv_cebu_facility_first,
            "vcted_sputnikv_mandaue_facility_first" => $this->vcted_sputnikv_mandaue_facility_first,
            "vcted_sputnikv_lapu_facility_first" => $this->vcted_sputnikv_lapu_facility_first,

            //VACCINATED_SPUTNIKV_SECOND
            "vcted_sputnikv_bohol_second" => $this->vcted_sputnikv_bohol_second,
            "vcted_sputnikv_cebu_second" => $this->vcted_sputnikv_cebu_second,
            "vcted_sputnikv_negros_second" => $this->vcted_sputnikv_negros_second,
            "vcted_sputnikv_siquijor_second" => $this->vcted_sputnikv_siquijor_second,
            "vcted_sputnikv_cebu_facility_second" => $this->vcted_sputnikv_cebu_facility_second,
            "vcted_sputnikv_mandaue_facility_second" => $this->vcted_sputnikv_mandaue_facility_second,
            "vcted_sputnikv_lapu_facility_second" => $this->vcted_sputnikv_lapu_facility_second,


            //VACCINATED_MODERNA_FIRST
            "vcted_moderna_bohol_first" => $this->vcted_moderna_bohol_first,
            "vcted_moderna_cebu_first" => $this->vcted_moderna_cebu_first,
            "vcted_moderna_negros_first" => $this->vcted_moderna_negros_first,
            "vcted_moderna_siquijor_first" => $this->vcted_moderna_siquijor_first,
            "vcted_moderna_cebu_facility_first" => $this->vcted_moderna_cebu_facility_first,
            "vcted_moderna_mandaue_facility_first" => $this->vcted_moderna_mandaue_facility_first,
            "vcted_moderna_lapu_facility_first" => $this->vcted_moderna_lapu_facility_first,

            //VACCINATED_MODERNA_SECOND
            "vcted_moderna_bohol_second" => $this->vcted_moderna_bohol_second,
            "vcted_moderna_cebu_second" => $this->vcted_moderna_cebu_second,
            "vcted_moderna_negros_second" => $this->vcted_moderna_negros_second,
            "vcted_moderna_siquijor_second" => $this->vcted_moderna_siquijor_second,
            "vcted_moderna_cebu_facility_second" => $this->vcted_moderna_cebu_facility_second,
            "vcted_moderna_mandaue_facility_second" => $this->vcted_moderna_mandaue_facility_second,
            "vcted_moderna_lapu_facility_second" => $this->vcted_moderna_lapu_facility_second,

            //VACCINATED_JOHNSON_FIRST
            "vcted_johnson_bohol_first" => $this->vcted_johnson_bohol_first,
            "vcted_johnson_cebu_first" => $this->vcted_johnson_cebu_first,
            "vcted_johnson_negros_first" => $this->vcted_johnson_negros_first,
            "vcted_johnson_siquijor_first" => $this->vcted_johnson_siquijor_first,
            "vcted_johnson_cebu_facility_first" => $this->vcted_johnson_cebu_facility_first,
            "vcted_johnson_mandaue_facility_first" => $this->vcted_johnson_mandaue_facility_first,
            "vcted_johnson_lapu_facility_first" => $this->vcted_johnson_lapu_facility_first,

            //VACCINATED_JOHNSON_SECOND
            "vcted_johnson_bohol_second" => $this->vcted_johnson_bohol_second,
            "vcted_johnson_cebu_second" => $this->vcted_johnson_cebu_second,
            "vcted_johnson_negros_second" => $this->vcted_johnson_negros_second,
            "vcted_johnson_siquijor_second" => $this->vcted_johnson_siquijor_second,
            "vcted_johnson_cebu_facility_second" => $this->vcted_johnson_cebu_facility_second,
            "vcted_johnson_mandaue_facility_second" => $this->vcted_johnson_mandaue_facility_second,
            "vcted_johnson_lapu_facility_second" => $this->vcted_johnson_lapu_facility_second,

            //TOTAL VACCINATED_FIRST
            "total_vcted_first_bohol" => $this->total_vcted_first_bohol,
            "total_vcted_first_cebu" => $this->total_vcted_first_cebu,
            "total_vcted_first_negros" => $this->total_vcted_first_negros,
            "total_vcted_first_siquijor" => $this->total_vcted_first_siquijor,
            "total_vcted_cebu_facility_first" => $this->total_vcted_cebu_facility_first,
            "total_vcted_mandaue_facility_first" => $this->total_vcted_mandaue_facility_first,
            "total_vcted_lapu_facility_first" => $this->total_vcted_lapu_facility_first,

            //TOTAL VACCINATED SECOND
            "total_vcted_second_bohol" => $this->total_vcted_second_bohol,
            "total_vcted_second_cebu" => $this->total_vcted_second_cebu,
            "total_vcted_second_negros" => $this->total_vcted_second_negros,
            "total_vcted_second_siquijor" => $this->total_vcted_second_siquijor,
            "total_vcted_cebu_facility_second" => $this->total_vcted_cebu_facility_second,
            "total_vcted_mandaue_facility_second" => $this->total_vcted_mandaue_facility_second,
            "total_vcted_lapu_facility_second" => $this->total_vcted_lapu_facility_second,

            //REGION VACCINATED
            "region_sinovac_first_dose" => $this->region_sinovac_first_dose,
            "region_sinovac_second_dose" => $this->region_sinovac_second_dose,
            "region_astra_first_dose" => $this->region_astra_first_dose,
            "region_astra_second_dose" => $this->region_astra_second_dose,
            "region_pfizer_first_dose" => $this->region_pfizer_first_dose,
            "region_pfizer_second_dose" => $this->region_pfizer_second_dose,
            "region_sputnikv_first_dose" => $this->region_sputnikv_first_dose,
            "region_sputnikv_second_dose" => $this->region_sputnikv_second_dose,
            "region_moderna_first_dose" => $this->region_moderna_first_dose,
            "region_moderna_second_dose" => $this->region_moderna_second_dose,
            "region_johnson_first_dose" => $this->region_johnson_first_dose,
            "region_johnson_second_dose" => $this->region_johnson_second_dose,

            //TOTAL DOSE
            "first_dose_total" => $this->first_dose_total,
            "second_dose_total" => $this->second_dose_total,

            //TOTAL ELI POP
            "total_elipop_region" => $this->total_elipop_region,

            //PERCENT COVERAGE SINOVAC FIRST DOSE
            "p_cvrge_sinovac_bohol_first" => $this->p_cvrge_sinovac_bohol_first,
            "p_cvrge_sinovac_cebu_first" => $this->p_cvrge_sinovac_cebu_first,
            "p_cvrge_sinovac_negros_first" => $this->p_cvrge_sinovac_negros_first,
            "p_cvrge_sinovac_siquijor_first" => $this->p_cvrge_sinovac_siquijor_first,
            "p_cvrge_sinovac_cebu_facility_first" => $this->p_cvrge_sinovac_cebu_facility_first,
            "p_cvrge_sinovac_mandaue_facility_first" => $this->p_cvrge_sinovac_mandaue_facility_first,
            "p_cvrge_sinovac_lapu_facility_first" => $this->p_cvrge_sinovac_lapu_facility_first,

            //PERCENT COVERAGE ASTRA FIRST DOSE
            "p_cvrge_astra_bohol_first" => $this->p_cvrge_astra_bohol_first,
            "p_cvrge_astra_cebu_first" => $this->p_cvrge_astra_cebu_first,
            "p_cvrge_astra_negros_first" => $this->p_cvrge_astra_negros_first,
            "p_cvrge_astra_siquijor_first" => $this->p_cvrge_astra_siquijor_first,
            "p_cvrge_astra_cebu_facility_first" => $this->p_cvrge_astra_cebu_facility_first,
            "p_cvrge_astra_mandaue_facility_first" => $this->p_cvrge_astra_mandaue_facility_first,
            "p_cvrge_astra_lapu_facility_first" => $this->p_cvrge_astra_lapu_facility_first,

            //PERCENT COVERAGE PFIZER FIRST DOSE
            "p_cvrge_pfizer_bohol_first" => $this->p_cvrge_pfizer_bohol_first,
            "p_cvrge_pfizer_cebu_first" => $this->p_cvrge_pfizer_cebu_first,
            "p_cvrge_pfizer_negros_first" => $this->p_cvrge_pfizer_negros_first,
            "p_cvrge_pfizer_siquijor_first" => $this->p_cvrge_pfizer_siquijor_first,
            "p_cvrge_pfizer_cebu_facility_first" => $this->p_cvrge_pfizer_cebu_facility_first,
            "p_cvrge_pfizer_mandaue_facility_first" => $this->p_cvrge_pfizer_mandaue_facility_first,
            "p_cvrge_pfizer_lapu_facility_first" => $this->p_cvrge_pfizer_lapu_facility_first,

            //PERCENT COVERAGE SPUTNIKV FIRST DOSE
            "p_cvrge_sputnikv_bohol_first" => $this->p_cvrge_sputnikv_bohol_first,
            "p_cvrge_sputnikv_cebu_first" => $this->p_cvrge_sputnikv_cebu_first,
            "p_cvrge_sputnikv_negros_first" => $this->p_cvrge_sputnikv_negros_first,
            "p_cvrge_sputnikv_siquijor_first" => $this->p_cvrge_sputnikv_siquijor_first,
            "p_cvrge_sputnikv_cebu_facility_first" => $this->p_cvrge_sputnikv_cebu_facility_first,
            "p_cvrge_sputnikv_mandaue_facility_first" => $this->p_cvrge_sputnikv_mandaue_facility_first,
            "p_cvrge_sputnikv_lapu_facility_first" => $this->p_cvrge_sputnikv_lapu_facility_first,

            //PERCENT COVERAGE MODERNA FIRST DOSE
            "p_cvrge_moderna_bohol_first" => $this->p_cvrge_moderna_bohol_first,
            "p_cvrge_moderna_cebu_first" => $this->p_cvrge_moderna_cebu_first,
            "p_cvrge_moderna_negros_first" => $this->p_cvrge_moderna_negros_first,
            "p_cvrge_moderna_siquijor_first" => $this->p_cvrge_moderna_siquijor_first,
            "p_cvrge_moderna_cebu_facility_first" => $this->p_cvrge_moderna_cebu_facility_first,
            "p_cvrge_moderna_mandaue_facility_first" => $this->p_cvrge_moderna_mandaue_facility_first,
            "p_cvrge_moderna_lapu_facility_first" => $this->p_cvrge_moderna_lapu_facility_first,


            //PERCENT COVERAGE JOHNSON FIRST DOSE
            "p_cvrge_johnson_bohol_first" => $this->p_cvrge_johnson_bohol_first,
            "p_cvrge_johnson_cebu_first" => $this->p_cvrge_johnson_cebu_first,
            "p_cvrge_johnson_negros_first" => $this->p_cvrge_johnson_negros_first,
            "p_cvrge_johnson_siquijor_first" => $this->p_cvrge_johnson_siquijor_first,
            "p_cvrge_johnson_cebu_facility_first" => $this->p_cvrge_johnson_cebu_facility_first,
            "p_cvrge_johnson_mandaue_facility_first" => $this->p_cvrge_johnson_mandaue_facility_first,
            "p_cvrge_johnson_lapu_facility_first" => $this->p_cvrge_johnson_lapu_facility_first,

            //TOTAL_PERCENT_COVERAGE_FIRST
            "total_p_cvrge_bohol_first" => $this->total_p_cvrge_bohol_first,
            "total_p_cvrge_cebu_first" => $this->total_p_cvrge_cebu_first,
            "total_p_cvrge_negros_first" => $this->total_p_cvrge_negros_first,
            "total_p_cvrge_siquijor_first" => $this->total_p_cvrge_siquijor_first,
            "total_p_cvrge_cebu_facility_first" => $this->total_p_cvrge_cebu_facility_first,
            "total_p_cvrge_mandaue_facility_first" => $this->total_p_cvrge_mandaue_facility_first,
            "total_p_cvrge_lapu_facility_first" => $this->total_p_cvrge_lapu_facility_first,

            //PERCENT COVERAGE SINOVAC SECOND DOSE
            "p_cvrge_sinovac_bohol_second" => $this->p_cvrge_sinovac_bohol_second,
            "p_cvrge_sinovac_cebu_second" => $this->p_cvrge_sinovac_cebu_second,
            "p_cvrge_sinovac_negros_second" => $this->p_cvrge_sinovac_negros_second,
            "p_cvrge_sinovac_siquijor_second" => $this->p_cvrge_sinovac_siquijor_second,
            "p_cvrge_sinovac_cebu_facility_second" => $this->p_cvrge_sinovac_cebu_facility_second,
            "p_cvrge_sinovac_mandaue_facility_second" => $this->p_cvrge_sinovac_mandaue_facility_second,
            "p_cvrge_sinovac_lapu_facility_second" => $this->p_cvrge_sinovac_lapu_facility_second,

            //PERCENT COVERAGE ASTRA SECOND DOSE
            "p_cvrge_astra_bohol_second" => $this->p_cvrge_astra_bohol_second,
            "p_cvrge_astra_cebu_second" => $this->p_cvrge_astra_cebu_second,
            "p_cvrge_astra_negros_second" => $this->p_cvrge_astra_negros_second,
            "p_cvrge_astra_siquijor_second" => $this->p_cvrge_astra_siquijor_second,
            "p_cvrge_astra_cebu_facility_second" => $this->p_cvrge_astra_cebu_facility_second,
            "p_cvrge_astra_mandaue_facility_second" => $this->p_cvrge_astra_mandaue_facility_second,
            "p_cvrge_astra_lapu_facility_second" => $this->p_cvrge_astra_lapu_facility_second,

            //PERCENT COVERAGE PFIZER SECOND DOSE
            "p_cvrge_pfizer_bohol_second" => $this->p_cvrge_pfizer_bohol_second,
            "p_cvrge_pfizer_cebu_second" => $this->p_cvrge_pfizer_cebu_second,
            "p_cvrge_pfizer_negros_second" => $this->p_cvrge_pfizer_negros_second,
            "p_cvrge_pfizer_siquijor_second" => $this->p_cvrge_pfizer_siquijor_second,
            "p_cvrge_pfizer_cebu_facility_second" => $this->p_cvrge_pfizer_cebu_facility_second,
            "p_cvrge_pfizer_mandaue_facility_second" => $this->p_cvrge_pfizer_mandaue_facility_second,
            "p_cvrge_pfizer_lapu_facility_second" => $this->p_cvrge_pfizer_lapu_facility_second,

            //PERCENT COVERAGE SPUTNIKV SECOND DOSE
            "p_cvrge_sputnikv_bohol_second" => $this->p_cvrge_sputnikv_bohol_second,
            "p_cvrge_sputnikv_cebu_second" => $this->p_cvrge_sputnikv_cebu_second,
            "p_cvrge_sputnikv_negros_second" => $this->p_cvrge_sputnikv_negros_second,
            "p_cvrge_sputnikv_siquijor_second" => $this->p_cvrge_sputnikv_siquijor_second,
            "p_cvrge_sputnikv_cebu_facility_second" => $this->p_cvrge_sputnikv_cebu_facility_second,
            "p_cvrge_sputnikv_mandaue_facility_second" => $this->p_cvrge_sputnikv_mandaue_facility_second,
            "p_cvrge_sputnikv_lapu_facility_second" => $this->p_cvrge_sputnikv_lapu_facility_second,

            //PERCENT COVERAGE MODERNA SECOND DOSE
            "p_cvrge_moderna_bohol_second" => $this->p_cvrge_moderna_bohol_second,
            "p_cvrge_moderna_cebu_second" => $this->p_cvrge_moderna_cebu_second,
            "p_cvrge_moderna_negros_second" => $this->p_cvrge_moderna_negros_second,
            "p_cvrge_moderna_siquijor_second" => $this->p_cvrge_moderna_siquijor_second,
            "p_cvrge_moderna_cebu_facility_second" => $this->p_cvrge_moderna_cebu_facility_second,
            "p_cvrge_moderna_mandaue_facility_second" => $this->p_cvrge_moderna_mandaue_facility_second,
            "p_cvrge_moderna_lapu_facility_second" => $this->p_cvrge_moderna_lapu_facility_second,

            //PERCENT COVERAGE JOHNSON SECOND DOSE
            "p_cvrge_johnson_bohol_second" => $this->p_cvrge_johnson_bohol_second,
            "p_cvrge_johnson_cebu_second" => $this->p_cvrge_johnson_cebu_second,
            "p_cvrge_johnson_negros_second" => $this->p_cvrge_johnson_negros_second,
            "p_cvrge_johnson_siquijor_second" => $this->p_cvrge_johnson_siquijor_second,
            "p_cvrge_johnson_cebu_facility_second" => $this->p_cvrge_johnson_cebu_facility_second,
            "p_cvrge_johnson_mandaue_facility_second" => $this->p_cvrge_johnson_mandaue_facility_second,
            "p_cvrge_johnson_lapu_facility_second" => $this->p_cvrge_johnson_lapu_facility_second,

            //TOTAL_PERCENT_COVERAGE_SECOND
            "total_p_cvrge_bohol_second" => $this->total_p_cvrge_bohol_second,
            "total_p_cvrge_cebu_second" => $this->total_p_cvrge_cebu_second,
            "total_p_cvrge_negros_second" => $this->total_p_cvrge_negros_second,
            "total_p_cvrge_siquijor_second" => $this->total_p_cvrge_siquijor_second,
            "total_p_cvrge_cebu_facility_second" => $this->total_p_cvrge_cebu_facility_second,
            "total_p_cvrge_mandaue_facility_second" => $this->total_p_cvrge_mandaue_facility_second,
            "total_p_cvrge_lapu_facility_second" => $this->total_p_cvrge_lapu_facility_second,

            //TOTAL_REGION_COVERAGE_FIRST
            "total_p_cvrge_sinovac_region_first" => $this->total_p_cvrge_sinovac_region_first,
            "total_p_cvrge_astra_region_first" => $this->total_p_cvrge_astra_region_first,
            "total_p_cvrge_pfizer_region_first" => $this->total_p_cvrge_pfizer_region_first,
            "total_p_cvrge_sputnikv_region_first" => $this->total_p_cvrge_sputnikv_region_first,
            "total_p_cvrge_moderna_region_first" => $this->total_p_cvrge_moderna_region_first,
            "total_p_cvrge_johnson_region_first" => $this->total_p_cvrge_johnson_region_first,

            "total_p_cvrge_region_first" => $this->total_p_cvrge_region_first,

            //TOTAL_REGION_COVERAGE_SECOND
            "total_p_cvrge_sinovac_region_second" => $this->total_p_cvrge_sinovac_region_second,
            "total_p_cvrge_astra_region_second" => $this->total_p_cvrge_astra_region_second,
            "total_p_cvrge_pfizer_region_second" => $this->total_p_cvrge_pfizer_region_second,
            "total_p_cvrge_sputnikv_region_second" => $this->total_p_cvrge_sputnikv_region_second,
            "total_p_cvrge_moderna_region_second" => $this->total_p_cvrge_moderna_region_second,
            "total_p_cvrge_johnson_region_second" => $this->total_p_cvrge_johnson_region_second,

            "total_p_cvrge_region_second" => $this->total_p_cvrge_region_second,

            //WASTAGE_SINOVAC_FIRST
            "wastage_sinovac_bohol_first" => $this->wastage_sinovac_bohol_first,
            "wastage_sinovac_cebu_first" => $this->wastage_sinovac_cebu_first,
            "wastage_sinovac_negros_first" => $this->wastage_sinovac_negros_first,
            "wastage_sinovac_siquijor_first" => $this->wastage_sinovac_siquijor_first,
            "wastage_sinovac_cebu_facility_first" => $this->wastage_sinovac_cebu_facility_first,
            "wastage_sinovac_mandaue_facility_first" => $this->wastage_sinovac_mandaue_facility_first,
            "wastage_sinovac_lapu_facility_first" => $this->wastage_sinovac_lapu_facility_first,

            //WASTAGE_ASTRA_FIRST
            "wastage_astra_bohol_first" => $this->wastage_astra_bohol_first,
            "wastage_astra_cebu_first" => $this->wastage_astra_cebu_first,
            "wastage_astra_negros_first" => $this->wastage_astra_negros_first,
            "wastage_astra_siquijor_first" => $this->wastage_astra_siquijor_first,
            "wastage_astra_cebu_facility_first" => $this->wastage_astra_cebu_facility_first,
            "wastage_astra_mandaue_facility_first" => $this->wastage_astra_mandaue_facility_first,
            "wastage_astra_lapu_facility_first" => $this->wastage_astra_lapu_facility_first,

            //WASTAGE_PFIZER_FIRST
            "wastage_pfizer_bohol_first" => $this->wastage_pfizer_bohol_first,
            "wastage_pfizer_cebu_first" => $this->wastage_pfizer_cebu_first,
            "wastage_pfizer_negros_first" => $this->wastage_pfizer_negros_first,
            "wastage_pfizer_siquijor_first" => $this->wastage_pfizer_siquijor_first,
            "wastage_pfizer_cebu_facility_first" => $this->wastage_pfizer_cebu_facility_first,
            "wastage_pfizer_mandaue_facility_first" => $this->wastage_pfizer_mandaue_facility_first,
            "wastage_pfizer_lapu_facility_first" => $this->wastage_pfizer_lapu_facility_first,

            //WASTAGE_SPUTNIKV_FIRST
            "wastage_sputnikv_bohol_first" => $this->wastage_sputnikv_bohol_first,
            "wastage_sputnikv_cebu_first" => $this->wastage_sputnikv_cebu_first,
            "wastage_sputnikv_negros_first" => $this->wastage_sputnikv_negros_first,
            "wastage_sputnikv_siquijor_first" => $this->wastage_sputnikv_siquijor_first,
            "wastage_sputnikv_cebu_facility_first" => $this->wastage_sputnikv_cebu_facility_first,
            "wastage_sputnikv_mandaue_facility_first" => $this->wastage_sputnikv_mandaue_facility_first,
            "wastage_sputnikv_lapu_facility_first" => $this->wastage_sputnikv_lapu_facility_first,

            //WASTAGE_MODERNA_FIRST
            "wastage_moderna_bohol_first" => $this->wastage_moderna_bohol_first,
            "wastage_moderna_cebu_first" => $this->wastage_moderna_cebu_first,
            "wastage_moderna_negros_first" => $this->wastage_moderna_negros_first,
            "wastage_moderna_siquijor_first" => $this->wastage_moderna_siquijor_first,
            "wastage_moderna_cebu_facility_first" => $this->wastage_moderna_cebu_facility_first,
            "wastage_moderna_mandaue_facility_first" => $this->wastage_moderna_mandaue_facility_first,
            "wastage_moderna_lapu_facility_first" => $this->wastage_moderna_lapu_facility_first,

            //WASTAGE_JOHNSON_FIRST
            "wastage_johnson_bohol_first" => $this->wastage_johnson_bohol_first,
            "wastage_johnson_cebu_first" => $this->wastage_johnson_cebu_first,
            "wastage_johnson_negros_first" => $this->wastage_johnson_negros_first,
            "wastage_johnson_siquijor_first" => $this->wastage_johnson_siquijor_first,
            "wastage_johnson_cebu_facility_first" => $this->wastage_johnson_cebu_facility_first,
            "wastage_johnson_mandaue_facility_first" => $this->wastage_johnson_mandaue_facility_first,
            "wastage_johnson_lapu_facility_first" => $this->wastage_johnson_lapu_facility_first,


            //REFUSED_FIRST
            "refused_first_bohol" => $this->refused_first_bohol,
            "refused_first_cebu" => $this->refused_first_cebu,
            "refused_first_negros" => $this->refused_first_negros,
            "refused_first_siquijor" => $this->refused_first_siquijor,
            "refused_cebu_facility_first" => $this->refused_cebu_facility_first,
            "refused_mandaue_facility_first" => $this->refused_mandaue_facility_first,
            "refused_lapu_facility_first" => $this->refused_lapu_facility_first,

            //REFUSED_SECOND
            "refused_second_bohol" => $this->refused_second_bohol,
            "refused_second_cebu" => $this->refused_second_cebu,
            "refused_second_negros" => $this->refused_second_negros,
            "refused_second_siquijor" => $this->refused_second_siquijor,
            "refused_cebu_facility_second" => $this->refused_cebu_facility_second,
            "refused_mandaue_facility_second" => $this->refused_mandaue_facility_second,
            "refused_lapu_facility_second" => $this->refused_lapu_facility_second,

            //DEFERRED_FIRST
            "deferred_first_bohol" => $this->deferred_first_bohol,
            "deferred_first_cebu" => $this->deferred_first_cebu,
            "deferred_first_negros" => $this->deferred_first_negros,
            "deferred_first_siquijor" => $this->deferred_first_siquijor,
            "deferred_cebu_facility_first" => $this->deferred_cebu_facility_first,
            "deferred_mandaue_facility_first" => $this->deferred_mandaue_facility_first,
            "deferred_lapu_facility_first" => $this->deferred_lapu_facility_first,

            //DEFERRED_SECOND
            "deferred_second_bohol" => $this->deferred_second_bohol,
            "deferred_second_cebu" => $this->deferred_second_cebu,
            "deferred_second_negros" => $this->deferred_second_negros,
            "deferred_second_siquijor" => $this->deferred_second_siquijor,
            "deferred_cebu_facility_second" => $this->deferred_cebu_facility_second,
            "deferred_mandaue_facility_second" => $this->deferred_mandaue_facility_second,
            "deferred_lapu_facility_second" => $this->deferred_lapu_facility_second,


            //TOTAL_WASTAGE
            "total_wastage_bohol" => $this->total_wastage_bohol,
            "total_wastage_cebu" => $this->total_wastage_cebu,
            "total_wastage_negros" => $this->total_wastage_negros,
            "total_wastage_siquijor" => $this->total_wastage_siquijor,
            "total_wastage_cebu_facility" => $this->total_wastage_cebu_facility,
            "total_wastage_mandaue_facility" => $this->total_wastage_mandaue_facility,
            "total_wastage_lapu_facility" => $this->total_wastage_lapu_facility,

            //TOTAL REFUSAL
            "total_refusal_first" =>$this->total_refusal_first, //REFUSED FIRST REGION
            "total_refusal_second" =>$this->total_refusal_second,

            //TOTAL DEFERRED
            "total_deferred_first" =>$this->total_deferred_first,
            "total_deferred_second" =>$this->total_deferred_second,

            //TOTAL WASTAGE
            "wastage_sinovac_first" => $this->wastage_sinovac_first,
            "wastage_astra_first" => $this->wastage_astra_first,
            "wastage_pfizer_first" => $this->wastage_pfizer_first,
            "wastage_sputnikv_first" => $this->wastage_sputnikv_first,
            "wastage_moderna_first" => $this->wastage_moderna_first,
            "wastage_johnson_first" => $this->wastage_johnson_first,

            "wastage_region" => $this->wastage_region,

            //CONSUMPTION_RATE_SINOVAC
            "c_rate_sinovac_bohol_first" => $this->c_rate_sinovac_bohol_first,
            "c_rate_sinovac_cebu_first" => $this->c_rate_sinovac_cebu_first,
            "c_rate_sinovac_negros_first" => $this->c_rate_sinovac_negros_first,
            "c_rate_sinovac_siquijor_first" => $this->c_rate_sinovac_siquijor_first,
            "c_rate_sinovac_cebu_facility_first" => $this->c_rate_sinovac_cebu_facility_first,
            "c_rate_sinovac_mandaue_facility_first" => $this->c_rate_sinovac_mandaue_facility_first,
            "c_rate_sinovac_lapu_facility_first" => $this->c_rate_sinovac_lapu_facility_first,

            //CONSUMPTION_RATE_ASTRA
            "c_rate_astra_bohol_first" => $this->c_rate_astra_bohol_first,
            "c_rate_astra_cebu_first" => $this->c_rate_astra_cebu_first,
            "c_rate_astra_negros_first" => $this->c_rate_astra_negros_first,
            "c_rate_astra_siquijor_first" => $this->c_rate_astra_siquijor_first,
            "c_rate_astra_cebu_facility_first" => $this->c_rate_astra_cebu_facility_first,
            "c_rate_astra_mandaue_facility_first" => $this->c_rate_astra_mandaue_facility_first,
            "c_rate_astra_lapu_facility_first" => $this->c_rate_astra_lapu_facility_first,

            //CONSUMPTION_RATE_PFIZER
            "c_rate_pfizer_bohol_first" => $this->c_rate_pfizer_bohol_first,
            "c_rate_pfizer_cebu_first" => $this->c_rate_pfizer_cebu_first,
            "c_rate_pfizer_negros_first" => $this->c_rate_pfizer_negros_first,
            "c_rate_pfizer_siquijor_first" => $this->c_rate_pfizer_siquijor_first,
            "c_rate_pfizer_cebu_facility_first" => $this->c_rate_pfizer_cebu_facility_first,
            "c_rate_pfizer_mandaue_facility_first" => $this->c_rate_pfizer_mandaue_facility_first,
            "c_rate_pfizer_lapu_facility_first" => $this->c_rate_pfizer_mandaue_facility_first,

            //CONSUMPTION_RATE_SPUTNIKV
            "c_rate_sputnikv_bohol_first" => $this->c_rate_sputnikv_bohol_first,
            "c_rate_sputnikv_cebu_first" => $this->c_rate_sputnikv_cebu_first,
            "c_rate_sputnikv_negros_first" => $this->c_rate_sputnikv_negros_first,
            "c_rate_sputnikv_siquijor_first" => $this->c_rate_sputnikv_siquijor_first,
            "c_rate_sputnikv_cebu_facility_first" => $this->c_rate_sputnikv_cebu_facility_first,
            "c_rate_sputnikv_mandaue_facility_first" => $this->c_rate_sputnikv_mandaue_facility_first,
            "c_rate_sputnikv_lapu_facility_first" => $this->c_rate_sputnikv_lapu_facility_first,

            //CONSUMPTION_RATE_MODERNA
            "c_rate_moderna_bohol_first" => $this->c_rate_moderna_bohol_first,
            "c_rate_moderna_cebu_first" => $this->c_rate_moderna_cebu_first,
            "c_rate_moderna_negros_first" => $this->c_rate_moderna_negros_first,
            "c_rate_moderna_siquijor_first" => $this->c_rate_moderna_siquijor_first,
            "c_rate_moderna_cebu_facility_first" => $this->c_rate_moderna_cebu_facility_first,
            "c_rate_moderna_mandaue_facility_first" => $this->c_rate_moderna_mandaue_facility_first,
            "c_rate_moderna_lapu_facility_first" => $this->c_rate_moderna_lapu_facility_first,

            //CONSUMPTION_RATE_JOHNSON
            "c_rate_johnson_bohol_first" => $this->c_rate_johnson_bohol_first,
            "c_rate_johnson_cebu_first" => $this->c_rate_johnson_cebu_first,
            "c_rate_johnson_negros_first" => $this->c_rate_johnson_negros_first,
            "c_rate_johnson_siquijor_first" => $this->c_rate_johnson_siquijor_first,
            "c_rate_johnson_cebu_facility_first" => $this->c_rate_johnson_cebu_facility_first,
            "c_rate_johnson_mandaue_facility_first" => $this->c_rate_johnson_mandaue_facility_first,
            "c_rate_johnson_lapu_facility_first" => $this->c_rate_johnson_lapu_facility_first,


            //TOTAL_CONSUMPTION_RATE_FIRST
            "total_c_rate_bohol_first" => $this->total_c_rate_bohol_first,
            "total_c_rate_cebu_first" => $this->total_c_rate_cebu_first,
            "total_c_rate_negros_first" => $this->total_c_rate_negros_first,
            "total_c_rate_siquijor_first" => $this->total_c_rate_siquijor_first,
            "total_c_rate_cebu_facility_first" => $this->total_c_rate_cebu_facility_first,
            "total_c_rate_mandaue_facility_first" => $this->total_c_rate_mandaue_facility_first,
            "total_c_rate_lapu_facility_first" => $this->total_c_rate_lapu_facility_first,

            //CONSUMPTION_RATE_SINOVAC_SECOND
            "c_rate_sinovac_bohol_second" => $this->c_rate_sinovac_bohol_second,
            "c_rate_sinovac_cebu_second" => $this->c_rate_sinovac_cebu_second,
            "c_rate_sinovac_negros_second" => $this->c_rate_sinovac_negros_second,
            "c_rate_sinovac_siquijor_second" => $this->c_rate_sinovac_siquijor_second,
            "c_rate_sinovac_cebu_facility_second" => $this->c_rate_sinovac_cebu_facility_second,
            "c_rate_sinovac_mandaue_facility_second" => $this->c_rate_sinovac_mandaue_facility_second,
            "c_rate_sinovac_lapu_facility_second" => $this->c_rate_sinovac_lapu_facility_second,

            //CONSUMPTION_RATE_ASTRAZENECA_SECOND
            "c_rate_astra_bohol_second" => $this->c_rate_astra_bohol_second,
            "c_rate_astra_cebu_second" => $this->c_rate_astra_cebu_second,
            "c_rate_astra_negros_second" => $this->c_rate_astra_negros_second,
            "c_rate_astra_siquijor_second" => $this->c_rate_astra_siquijor_second,
            "c_rate_astra_cebu_facility_second" => $this->c_rate_astra_cebu_facility_second,
            "c_rate_astra_mandaue_facility_second" => $this->c_rate_astra_mandaue_facility_second,
            "c_rate_astra_lapu_facility_second" => $this->c_rate_astra_lapu_facility_second,

            //CONSUMPTION_RATE_PFIZER_SECOND
            "c_rate_pfizer_bohol_second" => $this->c_rate_pfizer_bohol_second,
            "c_rate_pfizer_cebu_second" => $this->c_rate_pfizer_cebu_second,
            "c_rate_pfizer_negros_second" => $this->c_rate_pfizer_negros_second,
            "c_rate_pfizer_siquijor_second" => $this->c_rate_pfizer_siquijor_second,
            "c_rate_pfizer_cebu_facility_second" => $this->c_rate_pfizer_cebu_facility_second,
            "c_rate_pfizer_mandaue_facility_second" => $this->c_rate_pfizer_mandaue_facility_second,
            "c_rate_pfizer_lapu_facility_second" => $this->c_rate_pfizer_lapu_facility_second,

            //CONSUMPTION_RATE_SPUTNIKV_SECOND
            "c_rate_sputnikv_bohol_second" => $this->c_rate_sputnikv_bohol_second,
            "c_rate_sputnikv_cebu_second" => $this->c_rate_sputnikv_cebu_second,
            "c_rate_sputnikv_negros_second" => $this->c_rate_sputnikv_negros_second,
            "c_rate_sputnikv_siquijor_second" => $this->c_rate_sputnikv_siquijor_second,
            "c_rate_sputnikv_cebu_facility_second" => $this->c_rate_sputnikv_cebu_facility_second,
            "c_rate_sputnikv_mandaue_facility_second" => $this->c_rate_sputnikv_mandaue_facility_second,
            "c_rate_sputnikv_lapu_facility_second" => $this->c_rate_sputnikv_lapu_facility_second,

            //CONSUMPTION_RATE_MODERNA_SECOND
            "c_rate_moderna_bohol_second" => $this->c_rate_moderna_bohol_second,
            "c_rate_moderna_cebu_second" => $this->c_rate_moderna_cebu_second,
            "c_rate_moderna_negros_second" => $this->c_rate_moderna_negros_second,
            "c_rate_moderna_siquijor_second" => $this->c_rate_moderna_siquijor_second,
            "c_rate_moderna_cebu_facility_second" => $this->c_rate_moderna_cebu_facility_second,
            "c_rate_moderna_mandaue_facility_second" => $this->c_rate_moderna_mandaue_facility_second,
            "c_rate_moderna_lapu_facility_second" => $this->c_rate_moderna_lapu_facility_second,

            //CONSUMPTION_RATE_JOHNSON_SECOND
            "c_rate_johnson_bohol_second" => $this->c_rate_johnson_bohol_second,
            "c_rate_johnson_cebu_second" => $this->c_rate_johnson_cebu_second,
            "c_rate_johnson_negros_second" => $this->c_rate_johnson_negros_second,
            "c_rate_johnson_siquijor_second" => $this->c_rate_johnson_siquijor_second,
            "c_rate_johnson_cebu_facility_second" => $this->c_rate_johnson_cebu_facility_second,
            "c_rate_johnson_mandaue_facility_second" => $this->c_rate_johnson_mandaue_facility_second,
            "c_rate_johnson_lapu_facility_second" => $this->c_rate_johnson_lapu_facility_second,


            //TOTAL_CONSUMPTION_RATE_SECOND
            "total_c_rate_bohol_second" => $this->total_c_rate_bohol_second,
            "total_c_rate_cebu_second" => $this->total_c_rate_cebu_second,
            "total_c_rate_negros_second" => $this->total_c_rate_negros_second,
            "total_c_rate_siquijor_second" => $this->total_c_rate_siquijor_second,
            "total_c_rate_cebu_facility_second" => $this->total_c_rate_cebu_facility_second,
            "total_c_rate_mandaue_facility_second" => $this->total_c_rate_mandaue_facility_second,
            "total_c_rate_lapu_facility_second" => $this->total_c_rate_lapu_facility_second,

            //TOTAL_CONSUMPTION_RATE_REGION_FIRST
            "c_rate_region_sinovac_first" => $this->c_rate_region_sinovac_first,
            "c_rate_region_astra_first" => $this->c_rate_region_astra_first,
            "c_rate_region_pfizer_first" => $this->c_rate_region_pfizer_first,
            "c_rate_region_sputnikv_first" => $this->c_rate_region_sputnikv_first,
            "c_rate_region_moderna_first" => $this->c_rate_region_moderna_first,
            "c_rate_region_johnson_first" => $this->c_rate_region_johnson_first,

            //TOTAL_CONSUMPTION_RATE_REGION_SECOND
            "c_rate_region_sinovac_second" => $this->c_rate_region_sinovac_second,
            "c_rate_region_astra_second" => $this->c_rate_region_astra_second,
            "c_rate_region_pfizer_second" => $this->c_rate_region_pfizer_second,
            "c_rate_region_sputnikv_second" => $this->c_rate_region_sputnikv_second,
            "c_rate_region_moderna_second" => $this->c_rate_region_moderna_second,
            "c_rate_region_johnson_second" => $this->c_rate_region_johnson_second,

            //TOTAL_CONSUMPTION_RATE_FIRST
            "total_c_rate_region_first" => $this->total_c_rate_region_first,

            //TOTAL_CONSUMPTION_RATE_SECOND
            "total_c_rate_region_second" => $this->total_c_rate_region_second,

            //priority set
            "priority_set" => $this->priority_set
        ];
    }

    public function setPriority($priority){
        //allocated

        $this->sinovac_bohol_first = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_bohol_first"))->where("province_id",1)->first()->sinovac_bohol_first; //VACCINE ALLOCATED SINOVAC BOHOL_FIRST
        $this->sinovac_bohol_second = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_bohol_second"))->where("province_id",1)->first()->sinovac_bohol_second; //VACCINE ALLOCATED SINOVAC BOHOL_SECOND
        $this->sinovac_cebu_first = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_cebu_first"))->where("province_id",2)->first()->sinovac_cebu_first; //VACCINE ALLOCATED SINOVAC CEBU_FIRST
        $this->sinovac_cebu_second = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_cebu_second"))->where("province_id",2)->first()->sinovac_cebu_second; //VACCINE ALLOCATED SINOVAC CEBU_SECOND
        $this->sinovac_negros_first = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_negros_first"))->where("province_id",3)->first()->sinovac_negros_first; //VACCINE ALLOCATED SINOVAC NEGROS_FIRST
        $this->sinovac_negros_second = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_negros_second"))->where("province_id",3)->first()->sinovac_negros_second; //VACCINE ALLOCATED SINOVAC NEGROS_SECOND
        $this->sinovac_siquijor_first = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_siquijor_first"))->where("province_id",4)->first()->sinovac_siquijor_first; //VACCINE ALLOCATED SINOVAC SIQUIJOR_FIRST
        $this->sinovac_siquijor_second = Muncity::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_siquijor_second"))->where("province_id",4)->first()->sinovac_siquijor_second; //VACCINE ALLOCATED SINOVAC SIQUIJOR_SECOND
        $this->sinovac_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_cebu_facility_first"))->where("tricity_id",63)->first()->sinovac_cebu_facility_first; //VACCINE ALLOCATED SINOVAC CEBU FACILITY_FIRST
        $this->sinovac_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_cebu_facility_second"))->where("tricity_id",63)->first()->sinovac_cebu_facility_second; //VACCINE ALLOCATED SINOVAC CEBU FACILITY_SECOND
        $this->sinovac_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_mandaue_facility_first"))->where("tricity_id",80)->first()->sinovac_mandaue_facility_first; //VACCINE ALLOCATED SINOVAC MANDAUE_FACILITY_FIRST
        $this->sinovac_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_mandaue_facility_second"))->where("tricity_id",80)->first()->sinovac_mandaue_facility_second; //VACCINE ALLOCATED SINOVAC MANDAUE_FACILITY_SECOND
        $this->sinovac_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(sinovac_allocated_first,0)) as sinovac_lapu_facility_first"))->where("tricity_id",76)->first()->sinovac_lapu_facility_first; //VACCINE ALLOCATED SINOVAC LAPU-LAPU FACILITY_FIRST
        $this->sinovac_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(sinovac_allocated_second,0)) as sinovac_lapu_facility_second"))->where("tricity_id",76)->first()->sinovac_lapu_facility_second; //VACCINE ALLOCATED SINOVAC LAPU-LAPU FACILITY_SECOND

        $this->astra_bohol_first = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_bohol_first"))->where("province_id",1)->first()->astra_bohol_first; //VACCINE ALLOCATED ASTRA BOHOL_FIRST
        $this->astra_bohol_second = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_bohol_second"))->where("province_id",1)->first()->astra_bohol_second; //VACCINE ALLOCATED ASTRA BOHOL_SECOND
        $this->astra_cebu_first = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_cebu_first"))->where("province_id",2)->first()->astra_cebu_first; //VACCINE ALLOCATED ASTRA CEBU_FIRST
        $this->astra_cebu_second = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_cebu_second"))->where("province_id",2)->first()->astra_cebu_second; //VACCINE ALLOCATED ASTRA CEBU_SECOND
        $this->astra_negros_first = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_negros_first"))->where("province_id",3)->first()->astra_negros_first; //VACCINE ALLOCATED ASTRA NEGROS_FIRST
        $this->astra_negros_second = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_negros_second"))->where("province_id",3)->first()->astra_negros_second; //VACCINE ALLOCATED ASTRA NEGROS_SECOND
        $this->astra_siquijor_first = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_siquijor_first"))->where("province_id",4)->first()->astra_siquijor_first; //VACCINE ALLOCATED ASTRA SIQUIJOR_FIRST
        $this->astra_siquijor_second = Muncity::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_siquijor_second"))->where("province_id",4)->first()->astra_siquijor_second; //VACCINE ALLOCATED ASTRA SIQUIJOR_SECOND
        $this->astra_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_cebu_facility_first"))->where("tricity_id",63)->first()->astra_cebu_facility_first; //VACCINE ALLOCATED ASTRA CEBU FACILITY_FIRST
        $this->astra_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_cebu_facility_second"))->where("tricity_id",63)->first()->astra_cebu_facility_second; //VACCINE ALLOCATED ASTRA CEBU FACILITY_SECOND
        $this->astra_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_mandaue_facility_first"))->where("tricity_id",80)->first()->astra_mandaue_facility_first; //VACCINE ALLOCATED ASTRA MANDAUE_FACILITY_FIRST
        $this->astra_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_mandaue_facility_second"))->where("tricity_id",80)->first()->astra_mandaue_facility_second; //VACCINE ALLOCATED ASTRA MANDAUE_FACILITY_SECOND
        $this->astra_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(astrazeneca_allocated_first,0)) as astra_lapu_facility_first"))->where("tricity_id",76)->first()->astra_lapu_facility_first; //VACCINE ALLOCATED ASTRA LAPU-LAPU FACILITY_FIRST
        $this->astra_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(astrazeneca_allocated_second,0)) as astra_lapu_facility_second"))->where("tricity_id",76)->first()->astra_lapu_facility_second; //VACCINE ALLOCATED ASTRA LAPU-LAPU FACILITY_SECOND

        $this->pfizer_bohol_first = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_bohol_first"))->where("province_id",1)->first()->pfizer_bohol_first; //VACCINE ALLOCATED PFIZER BOHOL_FIRST
        $this->pfizer_bohol_second = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_bohol_second"))->where("province_id",1)->first()->pfizer_bohol_second; //VACCINE ALLOCATED PFIZER BOHOL_SECOND
        $this->pfizer_cebu_first = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_cebu_first"))->where("province_id",2)->first()->pfizer_cebu_first; //VACCINE ALLOCATED PFIZER CEBU_FIRST
        $this->pfizer_cebu_second = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_cebu_second"))->where("province_id",2)->first()->pfizer_cebu_second; //VACCINE ALLOCATED PFIZER CEBU_SECOND
        $this->pfizer_negros_first = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_negros_first"))->where("province_id",3)->first()->pfizer_negros_first; //VACCINE ALLOCATED PFIZER NEGROS_FIRST
        $this->pfizer_negros_second = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_negros_second"))->where("province_id",3)->first()->pfizer_negros_second; //VACCINE ALLOCATED PFIZER NEGROS_SECOND
        $this->pfizer_siquijor_first = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_siquijor_first"))->where("province_id",4)->first()->pfizer_siquijor_first; //VACCINE ALLOCATED PFIZER SIQUIJOR_FIRST
        $this->pfizer_siquijor_second = Muncity::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_siquijor_second"))->where("province_id",4)->first()->pfizer_siquijor_second; //VACCINE ALLOCATED PFIZER SIQUIJOR_SECOND
        $this->pfizer_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_cebu_facility_first"))->where("tricity_id",63)->first()->pfizer_cebu_facility_first; //VACCINE ALLOCATED PFIZER CEBU FACILITY_FIRST
        $this->pfizer_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_cebu_facility_second"))->where("tricity_id",63)->first()->pfizer_cebu_facility_second; //VACCINE ALLOCATED PFIZER CEBU FACILITY_SECOND
        $this->pfizer_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_mandaue_facility_first"))->where("tricity_id",80)->first()->pfizer_mandaue_facility_first; //VACCINE ALLOCATED PFIZER MANDAUE_FACILITY_FIRST
        $this->pfizer_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_mandaue_facility_second"))->where("tricity_id",80)->first()->pfizer_mandaue_facility_second; //VACCINE ALLOCATED PFIZER MANDAUE_FACILITY_SECOND
        $this->pfizer_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(pfizer_allocated_first,0)) as pfizer_lapu_facility_first"))->where("tricity_id",76)->first()->pfizer_lapu_facility_first; //VACCINE ALLOCATED PFIZER LAPU-LAPU FACILITY_FIRST
        $this->pfizer_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(pfizer_allocated_second,0)) as pfizer_lapu_facility_second"))->where("tricity_id",76)->first()->pfizer_lapu_facility_second; //VACCINE ALLOCATED PFIZER LAPU-LAPU FACILITY_SECOND

        $this->sputnikv_bohol_first = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_bohol_first"))->where("province_id",1)->first()->sputnikv_bohol_first; //VACCINE ALLOCATED SPUTNIKV BOHOL_FIRST
        $this->sputnikv_bohol_second = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_bohol_second"))->where("province_id",1)->first()->sputnikv_bohol_second; //VACCINE ALLOCATED SPUTNIKV BOHOL_SECOND
        $this->sputnikv_cebu_first = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_cebu_first"))->where("province_id",2)->first()->sputnikv_cebu_first; //VACCINE ALLOCATED SPUTNIKV CEBU_FIRST
        $this->sputnikv_cebu_second = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_cebu_second"))->where("province_id",2)->first()->sputnikv_cebu_second; //VACCINE ALLOCATED SPUTNIKV CEBU_SECOND
        $this->sputnikv_negros_first = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_negros_first"))->where("province_id",3)->first()->sputnikv_negros_first; //VACCINE ALLOCATED SPUTNIKV NEGROS_FIRST
        $this->sputnikv_negros_second = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_negros_second"))->where("province_id",3)->first()->sputnikv_negros_second; //VACCINE ALLOCATED SPUTNIKV NEGROS_SECOND
        $this->sputnikv_siquijor_first = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_siquijor_first"))->where("province_id",4)->first()->sputnikv_siquijor_first; //VACCINE ALLOCATED SPUTNIKV SIQUIJOR_FIRST
        $this->sputnikv_siquijor_second = Muncity::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_siquijor_second"))->where("province_id",4)->first()->sputnikv_siquijor_second; //VACCINE ALLOCATED SPUTNIKV SIQUIJOR_SECOND
        $this->sputnikv_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_cebu_facility_first"))->where("tricity_id",63)->first()->sputnikv_cebu_facility_first; //VACCINE ALLOCATED SPUTNIKV CEBU FACILITY_FIRST
        $this->sputnikv_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_cebu_facility_second"))->where("tricity_id",63)->first()->sputnikv_cebu_facility_second; //VACCINE ALLOCATED SPUTNIKV CEBU FACILITY_SECOND
        $this->sputnikv_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_mandaue_facility_first"))->where("tricity_id",80)->first()->sputnikv_mandaue_facility_first; //VACCINE ALLOCATED SPUTNIKV MANDAUE_FACILITY_FIRST
        $this->sputnikv_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_mandaue_facility_second"))->where("tricity_id",80)->first()->sputnikv_mandaue_facility_second; //VACCINE ALLOCATED SPUTNIKV MANDAUE_FACILITY_SECOND
        $this->sputnikv_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(sputnikv_allocated_first,0)) as sputnikv_lapu_facility_first"))->where("tricity_id",76)->first()->sputnikv_lapu_facility_first; //VACCINE ALLOCATED SPUTNIKV LAPU-LAPU FACILITY_FIRST
        $this->sputnikv_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(sputnikv_allocated_second,0)) as sputnikv_lapu_facility_second"))->where("tricity_id",76)->first()->sputnikv_lapu_facility_second; //VACCINE ALLOCATED SPUTNIKV LAPU-LAPU FACILITY_SECOND

        $this->moderna_bohol_first = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_bohol_first"))->where("province_id",1)->first()->moderna_bohol_first; //VACCINE ALLOCATED MODERNA BOHOL_FIRST
        $this->moderna_bohol_second = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_bohol_second"))->where("province_id",1)->first()->moderna_bohol_second; //VACCINE ALLOCATED MODERNA BOHOL_SECOND
        $this->moderna_cebu_first = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_cebu_first"))->where("province_id",2)->first()->moderna_cebu_first; //VACCINE ALLOCATED MODERNA CEBU_FIRST
        $this->moderna_cebu_second = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_cebu_second"))->where("province_id",2)->first()->moderna_cebu_second; //VACCINE ALLOCATED MODERNA CEBU_SECOND
        $this->moderna_negros_first = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_negros_first"))->where("province_id",3)->first()->moderna_negros_first; //VACCINE ALLOCATED MODERNA NEGROS_FIRST
        $this->moderna_negros_second = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_negros_second"))->where("province_id",3)->first()->moderna_negros_second; //VACCINE ALLOCATED MODERNA NEGROS_SECOND
        $this->moderna_siquijor_first = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_siquijor_first"))->where("province_id",4)->first()->moderna_siquijor_first; //VACCINE ALLOCATED MODERNA SIQUIJOR_FIRST
        $this->moderna_siquijor_second = Muncity::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_siquijor_second"))->where("province_id",4)->first()->moderna_siquijor_second; //VACCINE ALLOCATED MODERNA SIQUIJOR_SECOND
        $this->moderna_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_cebu_facility_first"))->where("tricity_id",63)->first()->moderna_cebu_facility_first; //VACCINE ALLOCATED MODERNA CEBU FACILITY_FIRST
        $this->moderna_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_cebu_facility_second"))->where("tricity_id",63)->first()->moderna_cebu_facility_second; //VACCINE ALLOCATED MODERNA CEBU FACILITY_SECOND
        $this->moderna_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_mandaue_facility_first"))->where("tricity_id",80)->first()->moderna_mandaue_facility_first; //VACCINE ALLOCATED MODERNA MANDAUE_FACILITY_FIRST
        $this->moderna_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_mandaue_facility_second"))->where("tricity_id",80)->first()->moderna_mandaue_facility_second; //VACCINE ALLOCATED MODERNA MANDAUE_FACILITY_SECOND
        $this->moderna_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(moderna_allocated_first,0)) as moderna_lapu_facility_first"))->where("tricity_id",76)->first()->moderna_lapu_facility_first; //VACCINE ALLOCATED MODERNA LAPU-LAPU FACILITY_FIRST
        $this->moderna_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(moderna_allocated_second,0)) as moderna_lapu_facility_second"))->where("tricity_id",76)->first()->moderna_lapu_facility_second; //VACCINE ALLOCATED MODERNA LAPU-LAPU FACILITY_SECOND

        $this->johnson_bohol_first = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_bohol_first"))->where("province_id",1)->first()->johnson_bohol_first; //VACCINE ALLOCATED JOHNSON BOHOL_FIRST
        $this->johnson_bohol_second = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_bohol_second"))->where("province_id",1)->first()->johnson_bohol_second; //VACCINE ALLOCATED JOHNSON BOHOL_SECOND
        $this->johnson_cebu_first = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_cebu_first"))->where("province_id",2)->first()->johnson_cebu_first; //VACCINE ALLOCATED JOHNSON CEBU_FIRST
        $this->johnson_cebu_second = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_cebu_second"))->where("province_id",2)->first()->johnson_cebu_second; //VACCINE ALLOCATED JOHNSON CEBU_SECOND
        $this->johnson_negros_first = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_negros_first"))->where("province_id",3)->first()->johnson_negros_first; //VACCINE ALLOCATED JOHNSON NEGROS_FIRST
        $this->johnson_negros_second = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_negros_second"))->where("province_id",3)->first()->johnson_negros_second; //VACCINE ALLOCATED JOHNSON NEGROS_SECOND
        $this->johnson_siquijor_first = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_siquijor_first"))->where("province_id",4)->first()->johnson_siquijor_first; //VACCINE ALLOCATED JOHNSON SIQUIJOR_FIRST
        $this->johnson_siquijor_second = Muncity::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_siquijor_second"))->where("province_id",4)->first()->johnson_siquijor_second; //VACCINE ALLOCATED JOHNSON SIQUIJOR_SECOND
        $this->johnson_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_cebu_facility_first"))->where("tricity_id",63)->first()->johnson_cebu_facility_first; //VACCINE ALLOCATED JOHNSON CEBU FACILITY_FIRST
        $this->johnson_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_cebu_facility_second"))->where("tricity_id",63)->first()->johnson_cebu_facility_second; //VACCINE ALLOCATED JOHNSON CEBU FACILITY_SECOND
        $this->johnson_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_mandaue_facility_first"))->where("tricity_id",80)->first()->johnson_mandaue_facility_first; //VACCINE ALLOCATED JOHNSON MANDAUE_FACILITY_FIRST
        $this->johnson_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_mandaue_facility_second"))->where("tricity_id",80)->first()->johnson_mandaue_facility_second; //VACCINE ALLOCATED JOHNSON MANDAUE_FACILITY_SECOND
        $this->johnson_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(johnson_allocated_first,0)) as johnson_lapu_facility_first"))->where("tricity_id",76)->first()->johnson_lapu_facility_first; //VACCINE ALLOCATED JOHNSON LAPU-LAPU FACILITY_FIRST
        $this->johnson_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(johnson_allocated_second,0)) as johnson_lapu_facility_second"))->where("tricity_id",76)->first()->johnson_lapu_facility_second; //VACCINE ALLOCATED JOHNSON LAPU-LAPU FACILITY_SECOND

        $this->sinovac_region_first = $this->sinovac_bohol_first + $this->sinovac_cebu_first + $this->sinovac_negros_first + $this->sinovac_siquijor_first + $this->sinovac_cebu_facility_first + $this->sinovac_mandaue_facility_first + $this->sinovac_lapu_facility_first; //VACCINE ALLOCATED SINOVAC REGION FIRST
        $this->sinovac_region_second = $this->sinovac_bohol_second + $this->sinovac_cebu_second + $this->sinovac_negros_second + $this->sinovac_siquijor_second + $this->sinovac_cebu_facility_second + $this->sinovac_mandaue_facility_second + $this->sinovac_lapu_facility_second; //VACCINE ALLOCATED SINOVAC REGION SECOND
        $this->astra_region_first = $this->astra_bohol_first + $this->astra_cebu_first + $this->astra_negros_first + $this->astra_siquijor_first + $this->astra_cebu_facility_first + $this->astra_mandaue_facility_first + $this->astra_lapu_facility_first; //VACCINE ALLOCATED ASTRA REGION FIRST
        $this->astra_region_second = $this->astra_bohol_second + $this->astra_cebu_second + $this->astra_negros_second + $this->astra_siquijor_second + $this->astra_cebu_facility_second + $this->astra_mandaue_facility_second + $this->astra_lapu_facility_second; //VACCINE ALLOCATED ASTRA REGION SECOND
        $this->pfizer_region_first = $this->pfizer_bohol_first + $this->pfizer_cebu_first + $this->pfizer_negros_first + $this->pfizer_siquijor_first + $this->pfizer_cebu_facility_first + $this->pfizer_mandaue_facility_first + $this->pfizer_lapu_facility_first; //VACCINE ALLOCATED PFIZER REGION FIRST
        $this->pfizer_region_second = $this->pfizer_bohol_second + $this->pfizer_cebu_second + $this->pfizer_negros_second + $this->pfizer_siquijor_second + $this->pfizer_cebu_facility_second + $this->pfizer_mandaue_facility_second + $this->pfizer_lapu_facility_second; //VACCINE ALLOCATED PFIZER REGION SECOND
        $this->sputnikv_region_first = $this->sputnikv_bohol_first + $this->sputnikv_cebu_first + $this->sputnikv_negros_first + $this->sputnikv_siquijor_first + $this->sputnikv_cebu_facility_first + $this->sputnikv_mandaue_facility_first + $this->sputnikv_lapu_facility_first; //VACCINE ALLOCATED SPUTNIKV REGION FIRST
        $this->sputnikv_region_second = $this->sputnikv_bohol_second + $this->sputnikv_cebu_second + $this->sputnikv_negros_second + $this->sputnikv_siquijor_second + $this->sputnikv_cebu_facility_second + $this->sputnikv_mandaue_facility_second + $this->sputnikv_lapu_facility_second; //VACCINE ALLOCATED SPUTNIKV REGION SECOND
        $this->moderna_region_first = $this->moderna_bohol_first + $this->moderna_cebu_first + $this->moderna_negros_first + $this->moderna_siquijor_first + $this->moderna_cebu_facility_first + $this->moderna_mandaue_facility_first + $this->moderna_lapu_facility_first; //VACCINE ALLOCATED MODERNA REGION FIRST
        $this->moderna_region_second = $this->moderna_bohol_second + $this->moderna_cebu_second + $this->moderna_negros_second + $this->moderna_siquijor_second + $this->moderna_cebu_facility_second + $this->moderna_mandaue_facility_second + $this->moderna_lapu_facility_second; //VACCINE ALLOCATED MODERNA REGION SECOND
        $this->johnson_region_first = $this->johnson_bohol_first + $this->johnson_cebu_first + $this->johnson_negros_first + $this->johnson_siquijor_first + $this->johnson_cebu_facility_first + $this->johnson_mandaue_facility_first + $this->johnson_lapu_facility_first; //VACCINE ALLOCATED JOHNSON REGION FIRST
        $this->johnson_region_second = $this->johnson_bohol_second + $this->johnson_cebu_second + $this->johnson_negros_second + $this->johnson_siquijor_second + $this->johnson_cebu_facility_second + $this->johnson_mandaue_facility_second + $this->johnson_lapu_facility_second; //VACCINE ALLOCATED JOHNSON REGION SECOND


        //ELIGIBLE POP
        $this->eli_pop_bohol = Muncity::select(DB::raw("SUM(coalesce($priority,0)) as eli_pop_bohol"))->where("province_id",1)->first()->eli_pop_bohol; //TOTAL ELIGIBLE POP BOHOL
        $this->eli_pop_cebu = Muncity::select(DB::raw("SUM(coalesce($priority,0)) as eli_pop_cebu"))->where("province_id",2)->first()->eli_pop_cebu; //ELIGIBLE POP CEBU
        $this->eli_pop_negros = Muncity::select(DB::raw("SUM(coalesce($priority,0)) as eli_pop_negros"))->where("province_id",3)->first()->eli_pop_negros;  //ELIGIBLE POP NEGROS
        $this->eli_pop_siquijor = Muncity::select(DB::raw("SUM(coalesce($priority,0)) as eli_pop_siquijor"))->where("province_id",4)->first()->eli_pop_siquijor; //ELIGIBLE POP SIQUIJOR
        $this->eli_pop_cebu_facility = Muncity::select(DB::raw("SUM(coalesce(facility.$priority,0)) as eli_pop_cebu_facility"))
            ->leftJoin("facility","facility.tricity_id","=","muncity.id")
            ->where("muncity.id","=",63)
            ->first()->eli_pop_cebu_facility; //ELIGIBLE POP CEBU FACILITY
        $this->eli_pop_mandaue_facility = Muncity::select(DB::raw("SUM(coalesce(facility.$priority,0)) as eli_pop_mandaue_facility"))
            ->leftJoin("facility","facility.tricity_id","=","muncity.id")
            ->where("muncity.id","=",80)
            ->first()->eli_pop_mandaue_facility; //ELIGIBLE POP MANDAUAE FACILITY
        $this->eli_pop_lapu_facility = Muncity::select(DB::raw("SUM(coalesce(facility.$priority,0)) as eli_pop_lapu_facility"))
            ->leftJoin("facility","facility.tricity_id","=","muncity.id")
            ->where("muncity.id","=",76)
            ->first()->eli_pop_lapu_facility; //ELIGIBLE POP LAPU-LAPU FACILITY


        //VACCINATED SINOVAC FIRST
        $this->vcted_sinovac_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sinovac_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_bohol_first; //VACCINATED SINOVAC_FIRST BOHOL
        $this->vcted_sinovac_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sinovac_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_cebu_first; //VACCINATED SINOVAC_FIRST CEBU
        $this->vcted_sinovac_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sinovac_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_negros_first; //VACCINATED SINOVAC_FIRST NEGROS
        $this->vcted_sinovac_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sinovac_siquijor_first"))->where("province_id",4)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_siquijor_first; //VACCINATED SINOVAC_FIRST SIQUIJOR
        $this->vcted_sinovac_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_sinovac_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Sinovac')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sinovac_cebu_facility_first;  //VACCINATED SINOVAC_FIRST CEBU FACILITY
        $this->vcted_sinovac_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_sinovac_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Sinovac')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sinovac_mandaue_facility_first;  //VACCINATED SINOVAC_FIRST MANDAUE FACILITY
        $this->vcted_sinovac_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_sinovac_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Sinovac')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sinovac_lapu_facility_first;  //VACCINATED SINOVAC_FIRST LAPU-LAPU FACILITY
        //VACCINATED SINOVAC SECOND
        $this->vcted_sinovac_bohol_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sinovac_bohol_second"))->where("province_id",1)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_bohol_second; //VACCINATED SINOVAC_SECOND BOHOL
        $this->vcted_sinovac_cebu_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sinovac_cebu_second"))->where("province_id",2)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_cebu_second; //VACCINATED SINOVAC_SECOND CEBU
        $this->vcted_sinovac_negros_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sinovac_negros_second"))->where("province_id",3)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_negros_second; //VACCINATED SINOVAC_SECOND NEGROS
        $this->vcted_sinovac_siquijor_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sinovac_siquijor_second"))->where("province_id",4)->where("typeof_vaccine",'Sinovac')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sinovac_siquijor_second; //VACCINATED SINOVAC_SECOND SIQUIJOR
        $this->vcted_sinovac_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_sinovac_cebu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Sinovac')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sinovac_cebu_facility_second; //VACCINATED SINOVAC_SECOND CEBU FACILITY
        $this->vcted_sinovac_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_sinovac_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Sinovac')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sinovac_mandaue_facility_second; //VACCINATED SINOVAC_SECOND MANDAUE FACILITY
        $this->vcted_sinovac_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_sinovac_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Sinovac')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sinovac_lapu_facility_second; //VACCINATED SINOVAC_SECOND LAPU-LAPU FACILITY

        //VACCINATED ASTRAZENECA FIRST
        $this->vcted_astra_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_astra_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_bohol_first; //VACCINATED ASTRA_FIRST BOHOL
        $this->vcted_astra_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_astra_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_cebu_first; //VACCINATED ASTRA_FIRST CEBU
        $this->vcted_astra_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_astra_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_negros_first; //VACCINATED ASTRA_FIRST NEGROS
        $this->vcted_astra_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_astra_siquijor_first"))->where("province_id",4)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_siquijor_first; //VACCINATED ASTRA_FIRST SIQUIJOR
        $this->vcted_astra_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_astra_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Astrazeneca')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_astra_cebu_facility_first; //VACCINATED ASTRA_FIRST CEBU FACILITY
        $this->vcted_astra_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_astra_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Astrazeneca')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_astra_mandaue_facility_first; //VACCINATED ASTRA_FIRST MANDAUE FACILITY
        $this->vcted_astra_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_astra_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Astrazeneca')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_astra_lapu_facility_first; //VACCINATED ASTRA_FIRST LAPU-LAPU FACILITY

        //VACCINATED ASTRAZENECA SECOND
        $this->vcted_astra_bohol_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_astra_bohol_second"))->where("province_id",1)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_bohol_second; //VACCINATED ASTRA_SECOND BOHOL
        $this->vcted_astra_cebu_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_astra_cebu_second"))->where("province_id",2)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_cebu_second; //VACCINATED ASTRA_SECOND CEBU
        $this->vcted_astra_negros_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_astra_negros_second"))->where("province_id",3)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_negros_second; //VACCINATED ASTRA_SECOND NEGROS
        $this->vcted_astra_siquijor_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_astra_siquijor_second"))->where("province_id",4)->where("typeof_vaccine",'Astrazeneca')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_astra_siquijor_second; //VACCINATED ASTRA_SECOND SIQUIJOR
        $this->vcted_astra_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_astra_cebu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Astrazeneca')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_astra_cebu_facility_second; //VACCINATED ASTRA_SECOND CEBU FACILITY
        $this->vcted_astra_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_astra_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Astrazeneca')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_astra_mandaue_facility_second; //VACCINATED ASTRA_SECOND MANDAUE FACILITY
        $this->vcted_astra_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_astra_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Astrazeneca')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_astra_lapu_facility_second; //VACCINATED ASTRA_SECOND LAPU-LAPU FACILITY


        //VACCINATED PFIZER FIRST
        $this->vcted_pfizer_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_pfizer_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_bohol_first; //VACCINATED PFIZER_FIRST BOHOL
        $this->vcted_pfizer_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_pfizer_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_cebu_first; //VACCINATED PFIZER_FIRST CEBU
        $this->vcted_pfizer_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_pfizer_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_negros_first; //VACCINATED PFIZER_FIRST NEGROS
        $this->vcted_pfizer_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_pfizer_siquijor_first"))->where("province_id",4)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_siquijor_first; //VACCINATED PFIZER_FIRST SIQUIJOR
        $this->vcted_pfizer_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_pfizer_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Pfizer')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_pfizer_cebu_facility_first; //VACCINATED PFIZER_FIRST CEBU FACILITY
        $this->vcted_pfizer_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_pfizer_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Pfizer')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_pfizer_mandaue_facility_first; //VACCINATED PFIZER_FIRST MANDAUE_FACILITY
        $this->vcted_pfizer_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_pfizer_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Pfizer')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_pfizer_lapu_facility_first; //VACCINATED PFIZER_FIRST LAPU-LAPU FACILITY

        //VACCINATED PFIZER V SECOND
        $this->vcted_pfizer_bohol_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_pfizer_bohol_second"))->where("province_id",1)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_bohol_second; //VACCINATED PFIZER_SECOND BOHOL
        $this->vcted_pfizer_cebu_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_pfizer_cebu_second"))->where("province_id",2)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_cebu_second; //VACCINATED PFIZER_SECOND CEBU
        $this->vcted_pfizer_negros_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_pfizer_negros_second"))->where("province_id",3)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_negros_second; //VACCINATED PFIZER_SECOND NEGROS
        $this->vcted_pfizer_siquijor_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_pfizer_siquijor_second"))->where("province_id",4)->where("typeof_vaccine",'Pfizer')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_pfizer_siquijor_second; //VACCINATED PFIZER_SECOND SIQUIJOR
        $this->vcted_pfizer_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_pfizer_cebu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Pfizer')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_pfizer_cebu_facility_second; //VACCINATED PFIZER_SECOND CEBU FACILITY
        $this->vcted_pfizer_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_pfizer_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Pfizer')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_pfizer_mandaue_facility_second; //VACCINATED PFIZER_SECOND MANDAUE FACILITY
        $this->vcted_pfizer_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_pfizer_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Pfizer')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_pfizer_lapu_facility_second; //VACCINATED PFIZER_SECOND LAPU-LAPU FACILITY

        //VACCINATED SPUTNIKV FIRST
        $this->vcted_sputnikv_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sputnikv_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_bohol_first; //VACCINATED SPUTNIKV_FIRST BOHOL
        $this->vcted_sputnikv_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sputnikv_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_cebu_first; //VACCINATED SPUTNIKV_FIRST CEBU
        $this->vcted_sputnikv_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sputnikv_negros_first"))->where("province_id",3)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_negros_first; //VACCINATED SPUTNIKV_FIRST NEGROS
        $this->vcted_sputnikv_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_sputnikv_siquijor_first"))->where("province_id",4)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_siquijor_first; //VACCINATED SPUTNIKV_FIRST SIQUIJOR
        $this->vcted_sputnikv_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_sputnikv_cebu_facility_first")) //VACCINATED SPUTNIKV_FIRST CEBU FACILITY
        ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'SputnikV')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sputnikv_cebu_facility_first; //VACCINATED SPUTNIKV_FIRST CEBU FACILITY
        $this->vcted_sputnikv_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_sputnikv_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'SputnikV')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sputnikv_mandaue_facility_first; //VACCINATED SPUTNIKV_FIRST MANDAUE FACILITY
        $this->vcted_sputnikv_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_sputnikv_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'SputnikV')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sputnikv_lapu_facility_first; //VACCINATED SPUTNIKV_FIRST LAPU-LAPU FACILITY

        //VACCINATED SPUTNIK V SECOND
        $this->vcted_sputnikv_bohol_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sputnikv_bohol_second"))->where("province_id",1)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_bohol_second; //VACCINATED SPUTNIKV_SECOND BOHOL
        $this->vcted_sputnikv_cebu_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sputnikv_cebu_second"))->where("province_id",2)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_cebu_second; //VACCINATED SPUTNIKV_SECOND CEBU
        $this->vcted_sputnikv_negros_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sputnikv_negros_second"))->where("province_id",3)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_negros_second; //VACCINATED SPUTNIKV_SECOND NEGROS
        $this->vcted_sputnikv_siquijor_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_sputnikv_siquijor_second"))->where("province_id",4)->where("typeof_vaccine",'SputnikV')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_sputnikv_siquijor_second; //VACCINATED SPUTNIKV_SECOND SIQUIJOR
        $this->vcted_sputnikv_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_sputnikv_cebu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'SputnikV')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sputnikv_cebu_facility_second; //VACCINATED SPUTNIKV_SECOND CEBU FACILITY
        $this->vcted_sputnikv_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_sputnikv_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'SputnikV')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sputnikv_mandaue_facility_second; //VACCINATED SPUTNIKV_SECOND MANDAUE FACILITY
        $this->vcted_sputnikv_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_sputnikv_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'SputnikV')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_sputnikv_lapu_facility_second; //VACCINATED SPUTNIKV_SECOND LAPU-LAPU FACILITY

        //VACCINATED MODERNA FIRST
        $this->vcted_moderna_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_moderna_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_bohol_first; //VACCINATED MODERNA_FIRST BOHOL
        $this->vcted_moderna_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_moderna_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_cebu_first; //VACCINATED MODERNA_FIRST CEBU
        $this->vcted_moderna_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_moderna_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_negros_first; //VACCINATED MODERNA_FIRST NEGROS
        $this->vcted_moderna_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_moderna_siquijor_first"))->where("province_id",4)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_siquijor_first; //VACCINATED MODERNA_FIRST SIQUIJOR
        $this->vcted_moderna_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_moderna_cebu_facility_first")) //VACCINATED MODERNA_FIRST CEBU FACILITY
        ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Moderna')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_moderna_cebu_facility_first; //VACCINATED MODERNA_FIRST CEBU FACILITY
        $this->vcted_moderna_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_moderna_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Moderna')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_moderna_mandaue_facility_first; //VACCINATED MODERNA_FIRST MANDAUE FACILITY
        $this->vcted_moderna_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_moderna_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Moderna')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_moderna_lapu_facility_first; //VACCINATED MODERNA_FIRST LAPU-LAPU FACILITY

        //VACCINATED MODERNA SECOND
        $this->vcted_moderna_bohol_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_moderna_bohol_second"))->where("province_id",1)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_bohol_second; //VACCINATED MODERNA_SECOND BOHOL
        $this->vcted_moderna_cebu_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_moderna_cebu_second"))->where("province_id",2)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_cebu_second; //VACCINATED MODERNA_SECOND CEBU
        $this->vcted_moderna_negros_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_moderna_negros_second"))->where("province_id",3)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_negros_second; //VACCINATED MODERNA_SECOND NEGROS
        $this->vcted_moderna_siquijor_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_moderna_siquijor_second"))->where("province_id",4)->where("typeof_vaccine",'Moderna')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_moderna_siquijor_second; //VACCINATED MODERNA_SECOND SIQUIJOR
        $this->vcted_moderna_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_moderna_cebu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Moderna')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_moderna_cebu_facility_second; //VACCINATED MODERNA_SECOND CEBU FACILITY
        $this->vcted_moderna_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_moderna_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Moderna')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_moderna_mandaue_facility_second; //VACCINATED MODERNA_SECOND MANDAUE FACILITY
        $this->vcted_moderna_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_moderna_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Moderna')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_moderna_lapu_facility_second; //VACCINATED MODERNA_SECOND LAPU-LAPU FACILITY


        //VACCINATED JOHNSON FIRST
        $this->vcted_johnson_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_johnson_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_bohol_first; //VACCINATED JOHNSON_FIRST BOHOL
        $this->vcted_johnson_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_johnson_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_cebu_first; //VACCINATED JOHNSON_FIRST CEBU
        $this->vcted_johnson_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_johnson_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_negros_first; //VACCINATED JOHNSON_FIRST NEGROS
        $this->vcted_johnson_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_first,0)) as vcted_johnson_siquijor_first"))->where("province_id",4)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_siquijor_first; //VACCINATED JOHNSON_FIRST SIQUIJOR
        $this->vcted_johnson_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_johnson_cebu_facility_first")) //VACCINATED JOHNSON_FIRST CEBU FACILITY
        ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Johnson')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_johnson_cebu_facility_first; //VACCINATED JOHNSON_FIRST CEBU FACILITY
        $this->vcted_johnson_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_johnson_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Johnson')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_johnson_mandaue_facility_first; //VACCINATED JOHNSON_FIRST MANDAUE FACILITY
        $this->vcted_johnson_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as vcted_johnson_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Johnson')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_johnson_lapu_facility_first; //VACCINATED JOHNSON_FIRST LAPU-LAPU FACILITY

        //VACCINATED JOHNSON SECOND
        $this->vcted_johnson_bohol_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_johnson_bohol_second"))->where("province_id",1)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_bohol_second; //VACCINATED JOHNSON_SECOND BOHOL
        $this->vcted_johnson_cebu_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_johnson_cebu_second"))->where("province_id",2)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_cebu_second; //VACCINATED JOHNSON_SECOND CEBU
        $this->vcted_johnson_negros_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_johnson_negros_second"))->where("province_id",3)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_negros_second; //VACCINATED JOHNSON_SECOND NEGROS
        $this->vcted_johnson_siquijor_second = VaccineAccomplished::select(DB::raw("SUM(coalesce(vaccinated_second,0)) as vcted_johnson_siquijor_second"))->where("province_id",4)->where("typeof_vaccine",'Johnson')->whereNull("facility_id")->where("priority",$priority)->first()->vcted_johnson_siquijor_second; //VACCINATED JOHNSON_SECOND SIQUIJOR
        $this->vcted_johnson_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_johnson_cebu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.typeof_vaccine",'Johnson')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_johnson_cebu_facility_second; //VACCINATED JOHNSON_SECOND CEBU FACILITY
        $this->vcted_johnson_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_johnson_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.typeof_vaccine",'Johnson')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_johnson_mandaue_facility_second; //VACCINATED JOHNSON_SECOND MANDAUE FACILITY
        $this->vcted_johnson_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as vcted_johnson_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.typeof_vaccine",'Johnson')
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->vcted_johnson_lapu_facility_second; //VACCINATED JOHNSON_SECOND LAPU-LAPU FACILITY


        //TOTAL_REFUSED_FIRST
        $this->refused_first_bohol = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_first,0)) as refused_first_bohol"))->where("province_id",1)->where("priority",$priority)->first()->refused_first_bohol; //REFUSED FIRST BOHOL
        $this->refused_first_cebu = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_first,0)) as refused_first_cebu"))->where("province_id",2)->where("priority",$priority)->first()->refused_first_cebu; //REFUSED FIRST CEBU
        $this->refused_first_negros = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_first,0)) as refused_first_negros"))->where("province_id",3)->where("priority",$priority)->first()->refused_first_negros; //REFUSED FIRST NEGROS
        $this->refused_first_siquijor = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_first,0)) as refused_first_siquijor"))->where("province_id",4)->where("priority",$priority)->first()->refused_first_siquijor; //REFUSED FIRST SIQUIJOR
        $this->refused_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.refused_first,0)) as refused_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->refused_cebu_facility_first; //REFUSED FIRST CEBU FACILITY
        $this->refused_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as refused_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->refused_mandaue_facility_first; //REFUSED FIRST MANDAUAE FACILITY
        $this->refused_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_first,0)) as refused_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->refused_lapu_facility_first; //REFUSED FIRST LAPU-LAPU FACILITY

        //TOTAL_REFUSED_SECOND
        $this->refused_second_bohol = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_second,0)) as refused_second_bohol"))->where("province_id",1)->where("priority",$priority)->first()->refused_second_bohol; //REFUSED SECOND BOHOL
        $this->refused_second_cebu = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_second,0)) as refused_second_cebu"))->where("province_id",2)->where("priority",$priority)->first()->refused_second_cebu; //REFUSED SECOND CEBU
        $this->refused_second_negros = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_second,0)) as refused_second_negros"))->where("province_id",3)->where("priority",$priority)->first()->refused_second_negros; //REFUSED SECOND NEGROS
        $this->refused_second_siquijor = VaccineAccomplished::select(DB::raw("SUM(coalesce(refused_second,0)) as refused_second_siquijor"))->where("province_id",4)->where("priority",$priority)->first()->refused_second_siquijor; //REFUSED SECOND SIQUIJOR
        $this->refused_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.refused_second ,0)) as refused_cebu_facility_second "))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->refused_cebu_facility_second; //REFUSED SECOND CEBU FACILITY
        $this->refused_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as refused_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->refused_mandaue_facility_second; //REFUSED SECOND MANDAUAE FACILITY
        $this->refused_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.vaccinated_second,0)) as refused_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->refused_lapu_facility_second; //REFUSED SECOND LAPU-LAPU FACILITY

        //TOTAL_DEFERRED_FIRST
        $this->deferred_first_bohol = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_first,0)) as deferred_first_bohol"))->where("province_id",1)->where("priority",$priority)->first()->deferred_first_bohol; //DEFERRED FIRST BOHOL
        $this->deferred_first_cebu = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_first,0)) as deferred_first_cebu"))->where("province_id",2)->where("priority",$priority)->first()->deferred_first_cebu; //DEFERRED FIRST CEBU
        $this->deferred_first_negros = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_first,0)) as deferred_first_negros"))->where("province_id",3)->where("priority",$priority)->first()->deferred_first_negros; //DEFERRED FIRST NEGROS
        $this->deferred_first_siquijor = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_first,0)) as deferred_first_siquijor"))->where("province_id",4)->where("priority",$priority)->first()->deferred_first_siquijor; //DEFERRED FIRST SIQUIJOR
        $this->deferred_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.deferred_first ,0)) as deferred_cebu_facility_first "))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->deferred_cebu_facility_first; //DEFERRED FIRST CEBU FACILITY
        $this->deferred_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.deferred_first,0)) as deferred_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->deferred_mandaue_facility_first; //DEFERRED FIRST MANDAUE FACILITY
        $this->deferred_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.deferred_first,0)) as deferred_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->deferred_lapu_facility_first; //DEFERRED FIRST LAPU-LAPU FACILITY

        //TOTAL_DEFERRED_SECOND
        $this->deferred_second_bohol = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_second,0)) as deferred_second_bohol"))->where("province_id",1)->where("priority",$priority)->first()->deferred_second_bohol; //DEFERRED SECOND BOHOL
        $this->deferred_second_cebu = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_second,0)) as deferred_second_cebu"))->where("province_id",2)->where("priority",$priority)->first()->deferred_second_cebu; //DEFERRED SECOND CEBU
        $this->deferred_second_negros = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_second,0)) as deferred_second_negros"))->where("province_id",3)->where("priority",$priority)->first()->deferred_second_negros; //DEFERRED SECOND NEGROS
        $this->deferred_second_siquijor = VaccineAccomplished::select(DB::raw("SUM(coalesce(deferred_second,0)) as deferred_second_siquijor"))->where("province_id",4)->where("priority",$priority)->first()->deferred_second_siquijor;  //DEFERRED SECOND SIQUIJOR
        $this->deferred_cebu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.deferred_second ,0)) as deferred_cebu_facility_second "))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->deferred_cebu_facility_second; //DEFERRED SECOND CEBU FACILITY
        $this->deferred_mandaue_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.deferred_second,0)) as deferred_mandaue_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->deferred_mandaue_facility_second; //DEFERRED SECOND MANDAUE FACILITY
        $this->deferred_lapu_facility_second = Facility::select(DB::raw("SUM(coalesce(vaccine_accomplish.deferred_second,0)) as deferred_lapu_facility_second"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->first()
            ->deferred_lapu_facility_second; //DEFERRED SECOND LAPU-LAPU FACILITY

        //WASTAGE_SINOVAC_FIRST
        $this->wastage_sinovac_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Sinovac')->where("priority",$priority)->first()->wastage_sinovac_bohol_first; //WASTAGE SINOVAC FIRST BOHOL
        $this->wastage_sinovac_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Sinovac')->where("priority",$priority)->first()->wastage_sinovac_cebu_first; //WASTAGE SINOVAC FIRST CEBU
        $this->wastage_sinovac_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Sinovac')->where("priority",$priority)->first()->wastage_sinovac_negros_first; //WASTAGE SINOVAC FIRST NEGROS
        $this->wastage_sinovac_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_siquior_first"))->where("province_id",4)->where("typeof_vaccine",'Sinovac')->where("priority",$priority)->first()->wastage_sinovac_siquior_first; //WASTAGE SINOVAC FIRST SIQUIJOR
        $this->wastage_sinovac_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Sinovac')
            ->first()
            ->wastage_sinovac_cebu_facility_first; //WASTAGE SINOVAC FIRST CEBU FACILITY
        $this->wastage_sinovac_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Sinovac')
            ->first()
            ->wastage_sinovac_mandaue_facility_first; //WASTAGE SINOVAC FIRST MANDAUE FACILITY
        $this->wastage_sinovac_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sinovac_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Sinovac')
            ->first()
            ->wastage_sinovac_lapu_facility_first; //WASTAGE SINOVAC FIRST LAPU-LAPU FACILITY
        //WASTAGE_ASTRA
        $this->wastage_astra_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Astrazeneca')->where("priority",$priority)->first()->wastage_astra_bohol_first; //WASTAGE ASTRA FIRST BOHOL
        $this->wastage_astra_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Astrazeneca')->where("priority",$priority)->first()->wastage_astra_cebu_first;  //WASTAGE ASTRA FIRST CEBU
        $this->wastage_astra_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Astrazeneca')->where("priority",$priority)->first()->wastage_astra_negros_first;  //WASTAGE ASTRA FIRST NEGROS
        $this->wastage_astra_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_siquior_first"))->where("province_id",4)->where("typeof_vaccine",'Astrazeneca')->where("priority",$priority)->first()->wastage_astra_siquior_first;  //WASTAGE ASTRA FIRST SIQUIJOR
        $this->wastage_astra_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Astrazeneca')
            ->first()
            ->wastage_astra_cebu_facility_first;  //WASTAGE ASTRA FIRST CEBU FACILITY
        $this->wastage_astra_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Astrazeneca')
            ->first()
            ->wastage_astra_mandaue_facility_first; //WASTAGE ASTRA FIRST MANDAUE FACILITY
        $this->wastage_astra_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_astra_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Astrazeneca')
            ->first()
            ->wastage_astra_lapu_facility_first; //WASTAGE ASTRA FIRST LAPU-LAPU FACILITY


        //WASTAGE_PFIZER
        $this->wastage_pfizer_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Pfizer')->where("priority",$priority)->first()->wastage_pfizer_bohol_first; //WASTAGE PFIZER FIRST BOHOL
        $this->wastage_pfizer_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Pfizer')->where("priority",$priority)->first()->wastage_pfizer_cebu_first; //WASTAGE PFIZER FIRST CEBU
        $this->wastage_pfizer_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Pfizer')->where("priority",$priority)->first()->wastage_pfizer_negros_first; //WASTAGE PFIZER FIRST NEGROS
        $this->wastage_pfizer_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_siquior_first"))->where("province_id",4)->where("typeof_vaccine",'Pfizer')->where("priority",$priority)->first()->wastage_pfizer_siquior_first; //WASTAGE PFIZER FIRST SIQUIJOR
        $this->wastage_pfizer_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Pfizer')
            ->first()
            ->wastage_pfizer_cebu_facility_first; //WASTAGE PFIZER FIRST CEBU FACILITY
        $this->wastage_pfizer_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Pfizer')
            ->first()
            ->wastage_pfizer_mandaue_facility_first; //WASTAGE PFIZER FIRST MANDAUE FACILITY
        $this->wastage_pfizer_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_pfizer_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Pfizer')
            ->first()
            ->wastage_pfizer_lapu_facility_first; //WASTAGE PFIZER FIRST LAPU-LAPU FACILITY

        //WASTAGE_SPUTNIKV
        $this->wastage_sputnikv_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'SputnikV')->where("priority",$priority)->first()->wastage_sputnikv_bohol_first; //WASTAGE SPUTNIKV FIRST BOHOL
        $this->wastage_sputnikv_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'SputnikV')->where("priority",$priority)->first()->wastage_sputnikv_cebu_first; //WASTAGE SPUTNIKV FIRST CEBU
        $this->wastage_sputnikv_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_negros_first"))->where("province_id",3)->where("typeof_vaccine",'SputnikV')->where("priority",$priority)->first()->wastage_sputnikv_negros_first; //WASTAGE SPUTNIKV FIRST NEGROS
        $this->wastage_sputnikv_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_siquior_first"))->where("province_id",4)->where("typeof_vaccine",'SputnikV')->where("priority",$priority)->first()->wastage_sputnikv_siquior_first; //WASTAGE SPUTNIKV FIRST SIQUIJOR
        $this->wastage_sputnikv_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'SputnikV')
            ->first()
            ->wastage_sputnikv_cebu_facility_first; //WASTAGE SPUTNIKV FIRST CEBU FACILITY
        $this->wastage_sputnikv_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'SputnikV')
            ->first()
            ->wastage_sputnikv_mandaue_facility_first; //WASTAGE SPUTNIKV FIRST MANDAUE FACILITY
        $this->wastage_sputnikv_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_sputnikv_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'SputnikV')
            ->first()
            ->wastage_sputnikv_lapu_facility_first; //WASTAGE SPUTNIKV FIRST LAPU-LAPU FACILITY

        //WASTAGE_MODERNA
        $this->wastage_moderna_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Moderna')->where("priority",$priority)->first()->wastage_moderna_bohol_first; //WASTAGE MODERNA FIRST BOHOL
        $this->wastage_moderna_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Moderna')->where("priority",$priority)->first()->wastage_moderna_cebu_first; //WASTAGE MODERNA FIRST CEBU
        $this->wastage_moderna_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Moderna')->where("priority",$priority)->first()->wastage_moderna_negros_first; //WASTAGE MODERNA FIRST NEGROS
        $this->wastage_moderna_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_siquior_first"))->where("province_id",4)->where("typeof_vaccine",'Moderna')->where("priority",$priority)->first()->wastage_moderna_siquior_first; //WASTAGE MODERNA FIRST SIQUIJOR
        $this->wastage_moderna_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Moderna')
            ->first()
            ->wastage_moderna_cebu_facility_first; //WASTAGE MODERNA FIRST CEBU FACILITY
        $this->wastage_moderna_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Moderna')
            ->first()
            ->wastage_moderna_mandaue_facility_first; //WASTAGE MODERNA FIRST MANDAUE FACILITY
        $this->wastage_moderna_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_moderna_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Moderna')
            ->first()
            ->wastage_moderna_lapu_facility_first; //WASTAGE MODERNA FIRST LAPU-LAPU FACILITY


        //WASTAGE_JOHNSON
        $this->wastage_johnson_bohol_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_bohol_first"))->where("province_id",1)->where("typeof_vaccine",'Johnson')->where("priority",$priority)->first()->wastage_johnson_bohol_first; //WASTAGE JOHNSON FIRST BOHOL
        $this->wastage_johnson_cebu_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_cebu_first"))->where("province_id",2)->where("typeof_vaccine",'Johnson')->where("priority",$priority)->first()->wastage_johnson_cebu_first; //WASTAGE JOHNSON FIRST CEBU
        $this->wastage_johnson_negros_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_negros_first"))->where("province_id",3)->where("typeof_vaccine",'Johnson')->where("priority",$priority)->first()->wastage_johnson_negros_first; //WASTAGE JOHNSON FIRST NEGROS
        $this->wastage_johnson_siquijor_first = VaccineAccomplished::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_siquior_first"))->where("province_id",4)->where("typeof_vaccine",'Johnson')->where("priority",$priority)->first()->wastage_johnson_siquior_first; //WASTAGE JOHNSON FIRST SIQUIJOR
        $this->wastage_johnson_cebu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_cebu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",63)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Johnson')
            ->first()
            ->wastage_johnson_cebu_facility_first; //WASTAGE JOHNSON FIRST CEBU FACILITY
        $this->wastage_johnson_mandaue_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_mandaue_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",80)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Johnson')
            ->first()
            ->wastage_johnson_mandaue_facility_first; //WASTAGE JOHNSON FIRST MANDAUE FACILITY
        $this->wastage_johnson_lapu_facility_first = Facility::select(DB::raw("SUM(coalesce(wastage_first,0)+coalesce(wastage_second,0)) as wastage_johnson_lapu_facility_first"))
            ->leftJoin("vaccine_accomplish","vaccine_accomplish.facility_id","=","facility.id")
            ->where("facility.tricity_id","=",76)
            ->where("vaccine_accomplish.priority",$priority)
            ->where("typeof_vaccine",'Johnson')
            ->first()
            ->wastage_johnson_lapu_facility_first; //WASTAGE JOHNSON FIRST LAPU-LAPU FACILITY



        //REGION VACCINATED
        $this->region_sinovac_first_dose = $this->vcted_sinovac_bohol_first + $this->vcted_sinovac_cebu_first + $this->vcted_sinovac_negros_first + $this->vcted_sinovac_siquijor_first +
            $this->vcted_sinovac_cebu_facility_first + $this->vcted_sinovac_mandaue_facility_first + $this->vcted_sinovac_lapu_facility_first ; //VACCINATED SINOVAC_FIRST REGION
        $this->region_sinovac_second_dose = $this->vcted_sinovac_bohol_second + $this->vcted_sinovac_cebu_second + $this->vcted_sinovac_negros_second + $this->vcted_sinovac_siquijor_second +
            $this->vcted_sinovac_cebu_facility_second + $this->vcted_sinovac_mandaue_facility_second + $this->vcted_sinovac_lapu_facility_second; //VACCINATED SINOVAC_SECOND REGION
        $this->region_astra_first_dose = $this->vcted_astra_bohol_first + $this->vcted_astra_cebu_first + $this->vcted_astra_negros_first + $this->vcted_astra_siquijor_first +
            $this->vcted_astra_cebu_facility_first + $this->vcted_astra_mandaue_facility_first + $this->vcted_astra_lapu_facility_first; //VACCINATED ASTRA_FIRST REGION
        $this->region_astra_second_dose = $this->vcted_astra_bohol_second + $this->vcted_astra_cebu_second + $this->vcted_astra_negros_second + $this->vcted_astra_siquijor_second +
            $this->vcted_astra_cebu_facility_second + $this->vcted_astra_mandaue_facility_second + $this->vcted_astra_lapu_facility_second; //VACCINATED ASTRA_SECOND REGION
        $this->region_pfizer_first_dose = $this->vcted_pfizer_bohol_first + $this->vcted_pfizer_cebu_first + $this->vcted_pfizer_negros_first + $this->vcted_pfizer_siquijor_first +
            $this->vcted_pfizer_cebu_facility_first + $this->vcted_pfizer_mandaue_facility_first + $this->vcted_pfizer_lapu_facility_first; //VACCINATED PFIZER_FIRST REGION
        $this->region_pfizer_second_dose = $this->vcted_pfizer_bohol_second + $this->vcted_pfizer_cebu_second + $this->vcted_pfizer_negros_second + $this->vcted_pfizer_siquijor_second +
            $this->vcted_pfizer_cebu_facility_second + $this->vcted_pfizer_mandaue_facility_second + $this->vcted_pfizer_lapu_facility_second; //VACCINATED PFIZER_SECOND REGION
        $this->region_sputnikv_first_dose = $this->vcted_sputnikv_bohol_first + $this->vcted_sputnikv_cebu_first + $this->vcted_sputnikv_negros_first + $this->vcted_sputnikv_siquijor_first +
            $this->vcted_sputnikv_cebu_facility_first + $this->vcted_sputnikv_mandaue_facility_first + $this->vcted_sputnikv_lapu_facility_first; //VACCINATED SPUTNIKV_FIRST REGION
        $this->region_sputnikv_second_dose = $this->vcted_sputnikv_bohol_second + $this->vcted_sputnikv_cebu_second + $this->vcted_sputnikv_negros_second + $this->vcted_sputnikv_siquijor_second +
            $this->vcted_sputnikv_cebu_facility_second + $this->vcted_sputnikv_mandaue_facility_second + $this->vcted_sputnikv_lapu_facility_second; //VACCINATED SPUTNIKV_SECOND REGION
        $this->region_moderna_first_dose = $this->vcted_moderna_bohol_first + $this->vcted_moderna_cebu_first + $this->vcted_moderna_negros_first + $this->vcted_moderna_siquijor_first +
            $this->vcted_moderna_cebu_facility_first + $this->vcted_moderna_mandaue_facility_first + $this->vcted_moderna_lapu_facility_first; //VACCINATED MODERNA_FIRST REGION
        $this->region_moderna_second_dose = $this->vcted_moderna_bohol_second + $this->vcted_moderna_cebu_second + $this->vcted_moderna_negros_second + $this->vcted_moderna_siquijor_second +
            $this->vcted_moderna_cebu_facility_second + $this->vcted_moderna_mandaue_facility_second + $this->vcted_moderna_lapu_facility_second; //VACCINATED MODERNA_SECOND REGION
        $this->region_johnson_first_dose = $this->vcted_johnson_bohol_first + $this->vcted_johnson_cebu_first + $this->vcted_johnson_negros_first + $this->vcted_johnson_siquijor_first +
            $this->vcted_johnson_cebu_facility_first + $this->vcted_johnson_mandaue_facility_first + $this->vcted_johnson_lapu_facility_first; //VACCINATED JOHNSON_FIRST REGION
        $this->region_johnson_second_dose = $this->vcted_johnson_bohol_second + $this->vcted_johnson_cebu_second + $this->vcted_johnson_negros_second + $this->vcted_johnson_siquijor_second +
            $this->vcted_johnson_cebu_facility_second + $this->vcted_johnson_mandaue_facility_second + $this->vcted_johnson_lapu_facility_second; //VACCINATED JOHNSON_SECOND REGION


        $this->total_elipop_region = $this->eli_pop_bohol + $this->eli_pop_cebu + $this->eli_pop_siquijor + $this->eli_pop_cebu_facility + $this->eli_pop_mandaue_facility + $this->eli_pop_lapu_facility; //TOTAL ELIGBLE_POP REGION
        $this->first_dose_total = $this->region_sinovac_first_dose + $this->region_astra_first_dose + $this->region_pfizer_first_dose +
            $this->region_sputnikv_first_dose + $this->region_moderna_first_dose + $this->region_johnson_first_dose; //TOTAL VACCINATED FIRST REGION
        $this->second_dose_total = $this->region_sinovac_second_dose + $this->region_astra_second_dose + $this->region_pfizer_second_dose +
            $this->region_sputnikv_second_dose + $this->region_moderna_second_dose + $this->region_johnson_second_dose; //TOTAL VACCINATED SECOND REGION

        $this->total_bohol_first = $this->sinovac_bohol_first + $this->astra_bohol_first + $this->pfizer_bohol_first + $this->sputnikv_bohol_first + $this->moderna_bohol_first + $this->johnson_bohol_first;
        $this->total_bohol_second = $this->sinovac_bohol_second + $this->astra_bohol_second + $this->pfizer_bohol_second + $this->sputnikv_bohol_second + $this->moderna_bohol_second + $this->johnson_bohol_second;
        $this->total_cebu_first = $this->sinovac_cebu_first + $this->astra_cebu_first + $this->pfizer_cebu_first + $this->sputnikv_cebu_first + $this->moderna_cebu_first + $this->johnson_cebu_first ;
        $this->total_cebu_second = $this->sinovac_cebu_second + $this->astra_cebu_second + $this->pfizer_cebu_second + $this->sputnikv_cebu_second + $this->moderna_cebu_second + $this->johnson_cebu_second;
        $this->total_negros_first =  $this->sinovac_negros_first + $this->astra_negros_first + $this->pfizer_negros_first + $this->sputnikv_negros_first + $this->moderna_negros_first + $this->johnson_negros_first;
        $this->total_negros_second =  $this->sinovac_negros_second + $this->astra_negros_second + $this->pfizer_negros_second + $this->sputnikv_negros_second + $this->moderna_negros_second + $this->johnson_negros_second ;
        $this->total_siquijor_first = $this->sinovac_siquijor_first + $this->astra_siquijor_first + $this->pfizer_siquijor_first + $this->sputnikv_siquijor_first + $this->moderna_siquijor_first + $this->johnson_siquijor_first;
        $this->total_siquijor_second = $this->sinovac_siquijor_second + $this->astra_siquijor_second + $this->pfizer_siquijor_second + $this->sputnikv_siquijor_second  + $this->moderna_siquijor_second + $this->johnson_siquijor_second;
        $this->total_cebu_facility_first =  $this->sinovac_cebu_facility_first + $this->astra_cebu_facility_first + $this->pfizer_cebu_facility_first + $this->sputnikv_cebu_facility_first + $this->moderna_cebu_facility_first + $this->johnson_cebu_facility_first;
        $this->total_cebu_facility_second = $this->sinovac_cebu_facility_second + $this->astra_cebu_facility_second + $this->pfizer_cebu_facility_second + $this->sputnikv_cebu_facility_second + $this->moderna_cebu_facility_second + $this->johnson_cebu_facility_second;
        $this->total_mandaue_facility_first =  $this->sinovac_mandaue_facility_first + $this->astra_mandaue_facility_first + $this->pfizer_mandaue_facility_first + $this->sputnikv_mandaue_facility_first + $this->moderna_mandaue_facility_first + $this->johnson_mandaue_facility_first;
        $this->total_mandaue_facility_second = $this->sinovac_mandaue_facility_second + $this->astra_mandaue_facility_second + $this->pfizer_mandaue_facility_second + $this->sputnikv_mandaue_facility_second + $this->moderna_mandaue_facility_second + $this->johnson_mandaue_facility_second;
        $this->total_lapu_facility_first = $this->sinovac_lapu_facility_first + $this->astra_lapu_facility_first + $this->pfizer_lapu_facility_first + $this->sputnikv_lapu_facility_first + $this->moderna_lapu_facility_first + $this->johnson_lapu_facility_first;
        $this->total_lapu_facility_second = $this->sinovac_lapu_facility_second + $this->astra_lapu_facility_second + $this->pfizer_lapu_facility_second + $this->sputnikv_lapu_facility_second + $this->moderna_lapu_facility_second + $this->johnson_lapu_facility_second;
        $this->total_region_first = $this->sinovac_region_first + $this->astra_region_first + $this->pfizer_region_first + $this->sputnikv_region_first + $this->moderna_region_first + $this->johnson_region_first;
        $this->total_region_second = $this->sinovac_region_second + $this->astra_region_second + $this->pfizer_region_second +  $this->sputnikv_region_second + $this->moderna_region_second +  $this->johnson_region_second;

        //TOTAL VACCINATED_FIRST
        $this->total_vcted_first_bohol = $this->vcted_sinovac_bohol_first + $this->vcted_astra_bohol_first + $this->vcted_pfizer_bohol_first +
            $this->vcted_sputnikv_bohol_first + $this->vcted_moderna_bohol_first + $this->vcted_johnson_bohol_first; //TOTAL VACCINATED FIRST BOHOL
        $this->total_vcted_first_cebu = $this->vcted_sinovac_cebu_first + $this->vcted_astra_cebu_first + $this->vcted_pfizer_cebu_first +
            $this->vcted_sputnikv_cebu_first + $this->vcted_moderna_cebu_first + $this->vcted_johnson_cebu_first; //TOTAL VACCINATED FIRST CEBU
        $this->total_vcted_first_negros = $this->vcted_sinovac_negros_first + $this->vcted_astra_negros_first + $this->vcted_pfizer_negros_first +
            $this->vcted_sputnikv_negros_first + $this->vcted_moderna_negros_first + $this->vcted_johnson_negros_first; //TOTAL VACCINATED FIRST NEGROS
        $this->total_vcted_first_siquijor = $this->vcted_sinovac_siquijor_first + $this->vcted_astra_siquijor_first + $this->vcted_pfizer_siquijor_first +
            $this->vcted_sputnikv_siquijor_first + $this->vcted_moderna_siquijor_first + $this->vcted_johnson_siquijor_first; //TOTAL VACCINATED FIRST SIQUIJOR
        $this->total_vcted_cebu_facility_first = $this->vcted_sinovac_cebu_facility_first + $this->vcted_astra_cebu_facility_first + $this->vcted_pfizer_cebu_facility_first +
            $this->vcted_sputnikv_cebu_facility_first + $this->vcted_moderna_cebu_facility_first + $this->vcted_johnson_cebu_facility_first; //TOTAL VACCINATED FIRST CEBU FACILITY
        $this->total_vcted_mandaue_facility_first = $this->vcted_sinovac_mandaue_facility_first + $this->vcted_astra_mandaue_facility_first + $this->vcted_pfizer_mandaue_facility_first +
            $this->vcted_sputnikv_mandaue_facility_first + $this->vcted_moderna_mandaue_facility_first + $this->vcted_johnson_mandaue_facility_first; //TOTAL VACCINATED MANDAUE FACILITY
        $this->total_vcted_lapu_facility_first = $this->vcted_sinovac_lapu_facility_first + $this->vcted_astra_lapu_facility_first + $this->vcted_pfizer_lapu_facility_first +
            $this->vcted_sputnikv_lapu_facility_first + $this->vcted_moderna_lapu_facility_first + $this->vcted_johnson_lapu_facility_first; //TOTAL VACCINATED FIRST LAPU-LAPU FACILITY*/

        //TOTAL VACCINATED SECOND
        $this->total_vcted_second_bohol = $this->vcted_sinovac_bohol_second + $this->vcted_astra_bohol_second + $this->vcted_pfizer_bohol_second +
            $this->vcted_sputnikv_bohol_second + $this->vcted_moderna_bohol_second +  $this->vcted_johnson_bohol_second; //TOTAL VACCINATED SECOND BOHOL
        $this->total_vcted_second_cebu = $this->vcted_sinovac_cebu_second + $this->vcted_astra_cebu_second + $this->vcted_pfizer_cebu_second +
            $this->vcted_sputnikv_cebu_second + $this->vcted_moderna_cebu_second + $this->vcted_johnson_cebu_second ; //TOTAL VACCINATED SECOND CEBU
        $this->total_vcted_second_negros = $this->vcted_sinovac_negros_second + $this->vcted_astra_negros_second + $this->vcted_pfizer_negros_second +
            $this->vcted_sputnikv_negros_second + $this->vcted_moderna_negros_second + $this->vcted_johnson_negros_second; //TOTAL VACCINATED SECOND NEGROS
        $this->total_vcted_second_siquijor = $this->vcted_sinovac_siquijor_second + $this->vcted_astra_siquijor_second + $this->vcted_pfizer_siquijor_second +
            $this->vcted_sputnikv_siquijor_second + $this->vcted_moderna_siquijor_second + $this->vcted_johnson_siquijor_second ; //TOTAL VACCINATED SECOND SIQUIJOR
        $this->total_vcted_cebu_facility_second = $this->vcted_sinovac_cebu_facility_second + $this->vcted_astra_cebu_facility_second + $this->vcted_pfizer_cebu_facility_second +
            $this->vcted_sputnikv_cebu_facility_second + $this->vcted_moderna_cebu_facility_second + $this->vcted_johnson_cebu_facility_second; //TOTAL VACCINATED SECOND CEBU FACILITY
        $this->total_vcted_mandaue_facility_second = $this->vcted_sinovac_mandaue_facility_second + $this->vcted_astra_mandaue_facility_second + $this->vcted_pfizer_mandaue_facility_second +
            $this->vcted_sputnikv_mandaue_facility_second + $this->vcted_moderna_mandaue_facility_second + $this->vcted_johnson_mandaue_facility_second; //TOTAL VACCINATED SECOND MANDAUE FACILITY
        $this->total_vcted_lapu_facility_second = $this->vcted_sinovac_lapu_facility_second + $this->vcted_astra_lapu_facility_second + $this->vcted_pfizer_lapu_facility_second +
            $this->vcted_sputnikv_lapu_facility_second  + $this->vcted_moderna_lapu_facility_second + $this->vcted_johnson_lapu_facility_second; //TOTAL VACCINATED SECOND LAPU-LAPU FACILITY*/


        //PERCENT_COVERAGE_SINOVAC_FIRST
        $this->p_cvrge_sinovac_bohol_first = number_format($this->vcted_sinovac_bohol_first / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE SINOVAC FIRST BOHOL
        $this->p_cvrge_sinovac_cebu_first = number_format($this->vcted_sinovac_cebu_first / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE SINOVAC FIRST CEBU
        $this->p_cvrge_sinovac_negros_first = number_format($this->vcted_sinovac_negros_first / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE SINOVAC FIRST NEGROS
        $this->p_cvrge_sinovac_siquijor_first = number_format($this->vcted_sinovac_siquijor_first / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE SINOVAC FIRST SIQUIJOR
        $this->p_cvrge_sinovac_cebu_facility_first = number_format($this->vcted_sinovac_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE SINOVAC FIRST CEBU FACILITY
        $this->p_cvrge_sinovac_mandaue_facility_first = number_format($this->vcted_sinovac_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE SINOVAC FIRST MANDAUAE FACILITY
        $this->p_cvrge_sinovac_lapu_facility_first = number_format($this->vcted_sinovac_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE SINOVAC FIRST LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_ASTRA_FIRST
        $this->p_cvrge_astra_bohol_first = number_format($this->vcted_astra_bohol_first / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE ASTRA FIRST BOHOL
        $this->p_cvrge_astra_cebu_first = number_format($this->vcted_astra_cebu_first / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE ASTRA FIRST CEBU
        $this->p_cvrge_astra_negros_first = number_format($this->vcted_astra_negros_first / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE ASTRA FIRST NEGROS
        $this->p_cvrge_astra_siquijor_first = number_format($this->vcted_astra_siquijor_first / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE ASTRA FIRST SIQUIJOR
        $this->p_cvrge_astra_cebu_facility_first = number_format($this->vcted_astra_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE ASTRA FIRST CEBU FACILITY
        $this->p_cvrge_astra_mandaue_facility_first = number_format($this->vcted_astra_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE ASTRA MANDAUE FACILITY
        $this->p_cvrge_astra_lapu_facility_first = number_format($this->vcted_astra_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE ASTRA FIRST LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_PFIZER_FIRST
        $this->p_cvrge_pfizer_bohol_first = number_format($this->vcted_pfizer_bohol_first / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE PFIZER FIRST BOHOL
        $this->p_cvrge_pfizer_cebu_first = number_format($this->vcted_pfizer_cebu_first / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE PFIZER FIRST CEBU
        $this->p_cvrge_pfizer_negros_first = number_format($this->vcted_pfizer_negros_first / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE PFIZER FIRST NEGROS
        $this->p_cvrge_pfizer_siquijor_first = number_format($this->vcted_pfizer_siquijor_first / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE PFIZER FIRST SIQUIJOR
        $this->p_cvrge_pfizer_cebu_facility_first = number_format($this->vcted_pfizer_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE PFIZER FIRST CEBU FACILITY
        $this->p_cvrge_pfizer_mandaue_facility_first = number_format($this->vcted_pfizer_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE PFIZER FIRST MANDAUE FACILITY
        $this->p_cvrge_pfizer_lapu_facility_first = number_format($this->vcted_pfizer_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE PFIZER FIRST LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_SPUTNIKV_FIRST
        $this->p_cvrge_sputnikv_bohol_first = number_format($this->vcted_sputnikv_bohol_first / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST BOHOL
        $this->p_cvrge_sputnikv_cebu_first = number_format($this->vcted_sputnikv_cebu_first / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST CEBU
        $this->p_cvrge_sputnikv_negros_first = number_format($this->vcted_sputnikv_negros_first / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST NEGROS
        $this->p_cvrge_sputnikv_siquijor_first = number_format($this->vcted_sputnikv_siquijor_first / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST SIQUIJOR
        $this->p_cvrge_sputnikv_cebu_facility_first = number_format($this->vcted_sputnikv_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST CEBU FACILITY
        $this->p_cvrge_sputnikv_mandaue_facility_first = number_format($this->vcted_sputnikv_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST MANDAUE FACILITY
        $this->p_cvrge_sputnikv_lapu_facility_first = number_format($this->vcted_sputnikv_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE SPUTNIKV FIRST LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_MODERNA_FIRST
        $this->p_cvrge_moderna_bohol_first = number_format($this->vcted_moderna_bohol_first / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE MODERNA FIRST BOHOL
        $this->p_cvrge_moderna_cebu_first = number_format($this->vcted_moderna_cebu_first / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE MODERNA FIRST CEBU
        $this->p_cvrge_moderna_negros_first = number_format($this->vcted_moderna_negros_first / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE MODERNA FIRST NEGROS
        $this->p_cvrge_moderna_siquijor_first = number_format($this->vcted_moderna_siquijor_first / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE MODERNA FIRST SIQUIJOR
        $this->p_cvrge_moderna_cebu_facility_first = number_format($this->vcted_moderna_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE MODERNA FIRST CEBU FACILITY
        $this->p_cvrge_moderna_mandaue_facility_first = number_format($this->vcted_moderna_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE MODERNA FIRST MANDAUE FACILITY
        $this->p_cvrge_moderna_lapu_facility_first = number_format($this->vcted_moderna_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE MODERNA FIRST LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_JOHNSON_FIRST
        $this->p_cvrge_johnson_bohol_first = number_format($this->vcted_johnson_bohol_first / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE JOHNSON FIRST BOHOL
        $this->p_cvrge_johnson_cebu_first = number_format($this->vcted_johnson_cebu_first / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE JOHNSON FIRST CEBU
        $this->p_cvrge_johnson_negros_first = number_format($this->vcted_johnson_negros_first / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE JOHNSON FIRST NEGROS
        $this->p_cvrge_johnson_siquijor_first = number_format($this->vcted_johnson_siquijor_first / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE JOHNSON FIRST SIQUIJOR
        $this->p_cvrge_johnson_cebu_facility_first = number_format($this->vcted_johnson_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE JOHNSON FIRST CEBU FACILITY
        $this->p_cvrge_johnson_mandaue_facility_first = number_format($this->vcted_johnson_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE JOHNSON FIRST MANDAUE FACILITY
        $this->p_cvrge_johnson_lapu_facility_first = number_format($this->vcted_johnson_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE JOHNSON FIRST LAPU-LAPU FACILITY

        //TOTAL_PERCENT_COVERAGE_FIRST
        $this->total_p_cvrge_bohol_first = number_format($this->total_vcted_first_bohol / $this->eli_pop_bohol * 100,2 ); //TOTAL PERCENT COVERAGE FIRST BOHOL
        $this->total_p_cvrge_cebu_first = number_format($this->total_vcted_first_cebu / $this->eli_pop_cebu * 100,2 ); //TOTAL PERCENT COVERAGE FIRST CEBU
        $this->total_p_cvrge_negros_first = number_format($this->total_vcted_first_negros / $this->eli_pop_negros * 100,2 );  //TOTAL PERCENT COVERAGE FIRST NEGROS
        $this->total_p_cvrge_siquijor_first = number_format($this->total_vcted_first_siquijor / $this->eli_pop_siquijor * 100,2 );  //TOTAL PERCENT COVERAGE FIRST SIQUIJOR
        $this->total_p_cvrge_cebu_facility_first = number_format($this->total_vcted_cebu_facility_first / $this->eli_pop_cebu_facility * 100,2 );  //TOTAL PERCENT COVERAGE FIRST CEBU FACILITY
        $this->total_p_cvrge_mandaue_facility_first = number_format($this->total_vcted_mandaue_facility_first / $this->eli_pop_mandaue_facility * 100,2 ); //TOTAL PERCENT COVERAGE FIRST MANDAUE FACILITY
        $this->total_p_cvrge_lapu_facility_first = number_format($this->total_vcted_lapu_facility_first / $this->eli_pop_lapu_facility * 100,2 );  //TOTAL PERCENT COVERAGE FIRST LAPU-LAPU FACILITY


        //PERCENT_COVERAGE_SINOVAC_SECOND
        $this->p_cvrge_sinovac_bohol_second = number_format($this->vcted_sinovac_bohol_second / $this->eli_pop_bohol * 100,2); //PPERCENT COVERAGE SINOVAC SECOND BOHOL
        $this->p_cvrge_sinovac_cebu_second = number_format($this->vcted_sinovac_cebu_second / $this->eli_pop_cebu * 100,2); //PPERCENT COVERAGE SINOVAC SECOND CEBU
        $this->p_cvrge_sinovac_negros_second = number_format($this->vcted_sinovac_negros_second / $this->eli_pop_negros * 100,2); //PPERCENT COVERAGE SINOVAC SECOND NEGROS
        $this->p_cvrge_sinovac_siquijor_second = number_format($this->vcted_sinovac_siquijor_second / $this->eli_pop_siquijor * 100,2); //PPERCENT COVERAGE SINOVAC SECOND SIQUIJOR
        $this->p_cvrge_sinovac_cebu_facility_second = number_format($this->vcted_sinovac_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2); //PPERCENT COVERAGE SINOVAC SECOND CEBU FACILITY
        $this->p_cvrge_sinovac_mandaue_facility_second = number_format($this->vcted_sinovac_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2); //PPERCENT COVERAGE SINOVAC SECOND MANDAUE FACILITY
        $this->p_cvrge_sinovac_lapu_facility_second = number_format($this->vcted_sinovac_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2); //PPERCENT COVERAGE SINOVAC SECOND LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_ASTRA_SECOND
        $this->p_cvrge_astra_bohol_second = number_format($this->vcted_astra_bohol_second / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE ASTRA SECOND BOHOL
        $this->p_cvrge_astra_cebu_second = number_format($this->vcted_astra_cebu_second / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE ASTRA SECOND CEBU
        $this->p_cvrge_astra_negros_second = number_format($this->vcted_astra_negros_second / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE ASTRA SECOND NEGROS
        $this->p_cvrge_astra_siquijor_second = number_format($this->vcted_astra_siquijor_second / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE ASTRA SECOND SIQUIJOR
        $this->p_cvrge_astra_cebu_facility_second = number_format($this->vcted_astra_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE ASTRA SECOND CEBU FACILITY
        $this->p_cvrge_astra_mandaue_facility_second = number_format($this->vcted_astra_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE ASTRA SECOND MANDAUE FACILITY
        $this->p_cvrge_astra_lapu_facility_second = number_format($this->vcted_astra_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE ASTRA SECOND LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_PFIZER_SECOND
        $this->p_cvrge_pfizer_bohol_second = number_format($this->vcted_pfizer_bohol_second / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE PFIZER SECOND BOHOL
        $this->p_cvrge_pfizer_cebu_second = number_format($this->vcted_pfizer_cebu_second / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE PFIZER SECOND CEBU
        $this->p_cvrge_pfizer_negros_second = number_format($this->vcted_pfizer_negros_second / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE PFIZER SECOND NEGROS
        $this->p_cvrge_pfizer_siquijor_second = number_format($this->vcted_pfizer_siquijor_second / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE PFIZER SECOND SIQUIJOR
        $this->p_cvrge_pfizer_cebu_facility_second = number_format($this->vcted_pfizer_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE PFIZER SECOND CEBU FACILITY
        $this->p_cvrge_pfizer_mandaue_facility_second = number_format($this->vcted_pfizer_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE PFIZER SECOND MANDAUE FACILITY
        $this->p_cvrge_pfizer_lapu_facility_second = number_format($this->vcted_pfizer_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE PFIZER SECOND LAPU-LAPU FACILITY

        //PERCENT_COVERAGE_SPUTNIKV_SECOND
        $this->p_cvrge_sputnikv_bohol_second = number_format($this->vcted_sputnikv_bohol_second / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE SPUTNIKV SECOND BOHOL
        $this->p_cvrge_sputnikv_cebu_second = number_format($this->vcted_sputnikv_cebu_second / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE SPUTNIKV SECOND CEBU
        $this->p_cvrge_sputnikv_negros_second = number_format($this->vcted_sputnikv_negros_second / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE SPUTNIKV SECOND NEGROS
        $this->p_cvrge_sputnikv_siquijor_second = number_format($this->vcted_sputnikv_siquijor_second / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE SPUTNIKV SECOND SIQUIJOR
        $this->p_cvrge_sputnikv_cebu_facility_second = number_format($this->vcted_sputnikv_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE SPUTNIKV SECOND CEBU FACILITY
        $this->p_cvrge_sputnikv_mandaue_facility_second = number_format($this->vcted_sputnikv_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE SPUTNIKV MANDAUE FACILITY
        $this->p_cvrge_sputnikv_lapu_facility_second = number_format($this->vcted_sputnikv_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE SPUTNIKV SECOND LAPU-LAPU FACILIY

        //PERCENT_COVERAGE_MODERNA_SECOND
        $this->p_cvrge_moderna_bohol_second = number_format($this->vcted_moderna_bohol_second / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE MODERNA SECOND BOHOL
        $this->p_cvrge_moderna_cebu_second = number_format($this->vcted_moderna_cebu_second / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE MODERNA SECOND CEBU
        $this->p_cvrge_moderna_negros_second = number_format($this->vcted_moderna_negros_second / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE MODERNA SECOND NEGROS
        $this->p_cvrge_moderna_siquijor_second = number_format($this->vcted_moderna_siquijor_second / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE MODERNA SECOND SIQUIJOR
        $this->p_cvrge_moderna_cebu_facility_second = number_format($this->vcted_moderna_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE MODERNA SECOND CEBU FACILITY
        $this->p_cvrge_moderna_mandaue_facility_second = number_format($this->vcted_moderna_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE MODERNA MANDAUE FACILITY
        $this->p_cvrge_moderna_lapu_facility_second = number_format($this->vcted_moderna_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE MODERNA SECOND LAPU-LAPU FACILIY

        //PERCENT_COVERAGE_JOHNSON_SECOND
        $this->p_cvrge_johnson_bohol_second = number_format($this->vcted_johnson_bohol_second / $this->eli_pop_bohol * 100,2); //PERCENT COVERAGE JOHNSON SECOND BOHOL
        $this->p_cvrge_johnson_cebu_second = number_format($this->vcted_johnson_cebu_second / $this->eli_pop_cebu * 100,2); //PERCENT COVERAGE JOHNSON SECOND CEBU
        $this->p_cvrge_johnson_negros_second = number_format($this->vcted_johnson_negros_second / $this->eli_pop_negros * 100,2); //PERCENT COVERAGE JOHNSON SECOND NEGROS
        $this->p_cvrge_johnson_siquijor_second = number_format($this->vcted_johnson_siquijor_second / $this->eli_pop_siquijor * 100,2); //PERCENT COVERAGE JOHNSON SECOND SIQUIJOR
        $this->p_cvrge_johnson_cebu_facility_second = number_format($this->vcted_johnson_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2); //PERCENT COVERAGE JOHNSON SECOND CEBU FACILITY
        $this->p_cvrge_johnson_mandaue_facility_second = number_format($this->vcted_johnson_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2); //PERCENT COVERAGE JOHNSON MANDAUE FACILITY
        $this->p_cvrge_johnson_lapu_facility_second = number_format($this->vcted_johnson_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2); //PERCENT COVERAGE JOHNSON SECOND LAPU-LAPU FACILIY

        //TOTAL_PERCENT_COVERAGE_SECOND
        $this->total_p_cvrge_bohol_second = number_format($this->total_vcted_second_bohol / $this->eli_pop_bohol * 100,2 ); //TOTAL PERCENT COVERAGE SECOND BOHOL
        $this->total_p_cvrge_cebu_second = number_format($this->total_vcted_second_cebu / $this->eli_pop_cebu * 100,2 ); //TOTAL PERCENT COVERAGE SECOND CEBU
        $this->total_p_cvrge_negros_second = number_format($this->total_vcted_second_negros / $this->eli_pop_negros * 100,2 );  //TOTAL PERCENT COVERAGE SECOND NEGROS
        $this->total_p_cvrge_siquijor_second =  number_format($this->total_vcted_first_siquijor / $this->eli_pop_siquijor * 100,2 ); //TOTAL PERCENT COVERAGE SECOND SIQUIJOR
        $this->total_p_cvrge_cebu_facility_second = number_format($this->total_vcted_cebu_facility_second / $this->eli_pop_cebu_facility * 100,2 );  //TOTAL PERCENT COVERAGE SECOND CEBU FACILITY
        $this->total_p_cvrge_mandaue_facility_second = number_format($this->total_vcted_mandaue_facility_second / $this->eli_pop_mandaue_facility * 100,2 ); //TOTAL PERCENT COVERAGE SECOND MANDAUE FACILITY
        $this->total_p_cvrge_lapu_facility_second = number_format($this->total_vcted_lapu_facility_second / $this->eli_pop_lapu_facility * 100,2 ); //TOTAL PERCENT COVERAGE SECOND LAPU-LAPU FACILITY

        //TOTAL_P_COVERAGE_REGION_FIRST
        $this->total_p_cvrge_sinovac_region_first = number_format($this->region_sinovac_first_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE SINOVAC FIRST REGION
        $this->total_p_cvrge_astra_region_first =  number_format($this->region_astra_first_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE ASTRA FIRST REGION
        $this->total_p_cvrge_pfizer_region_first =  number_format($this->region_pfizer_first_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE PFIZER FIRST REGION
        $this->total_p_cvrge_sputnikv_region_first = number_format($this->region_sputnikv_first_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE SPUTNIKV FIRST REGION
        $this->total_p_cvrge_moderna_region_first = number_format($this->region_moderna_first_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE MODERNA FIRST REGION
        $this->total_p_cvrge_johnson_region_first = number_format($this->region_johnson_first_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE JOHNSON FIRST REGION
        $this->total_p_cvrge_region_first = number_format($this->first_dose_total / $this->total_elipop_region * 100,2) ; //TOTAL PERCENT COVERAGE FIRST REGION

        //TOTAL_P_COVERAGE_REGION_SECOND
        $this->total_p_cvrge_sinovac_region_second =  number_format($this->region_sinovac_second_dose / $this->total_elipop_region * 100,2);; //TOTAL PERCENT COVERAGE SINOVAC SECOND REGION
        $this->total_p_cvrge_astra_region_second = number_format($this->region_astra_second_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE ASTRA SECOND REGION
        $this->total_p_cvrge_pfizer_region_second = number_format($this->region_pfizer_second_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE PFIZER SECOND REGION
        $this->total_p_cvrge_sputnikv_region_second =  number_format($this->region_sputnikv_second_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE SPUTNIKV SECOND REGION
        $this->total_p_cvrge_moderna_region_second =  number_format($this->region_moderna_second_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE MODERNA SECOND REGION
        $this->total_p_cvrge_johnson_region_second =  number_format($this->region_johnson_second_dose / $this->total_elipop_region * 100,2); //TOTAL PERCENT COVERAGE JOHNSON SECOND REGION
        $this->total_p_cvrge_region_second = number_format($this->second_dose_total / $this->total_elipop_region * 100,2) ; //TOTAL PERCENT COVERAGE SECOND REGION

        //TOTAL_WASTAGE
        $this->total_wastage_bohol = $this->wastage_sinovac_bohol_first + $this->wastage_astra_bohol_first + $this->wastage_pfizer_bohol_first +
            $this->wastage_sputnikv_bohol_first + $this->wastage_moderna_bohol_first + $this->wastage_johnson_bohol_first ; //TOTAL WASTAGE FIRST BOHOL
        $this->total_wastage_cebu = $this->wastage_sinovac_cebu_first + $this->wastage_astra_cebu_first + $this->wastage_pfizer_cebu_first +
            $this->wastage_sputnikv_cebu_first + $this->wastage_moderna_cebu_first + $this->wastage_johnson_cebu_first; //TOTAL WASTAGE FIRST CEBU
        $this->total_wastage_negros = $this->wastage_sinovac_negros_first + $this->wastage_astra_negros_first + $this->wastage_pfizer_negros_first +
            $this->wastage_sputnikv_negros_first + $this->wastage_moderna_negros_first + $this->wastage_johnson_negros_first; //TOTAL WASTAGE FIRST NEGROS
        $this->total_wastage_siquijor = $this->wastage_sinovac_siquijor_first + $this->wastage_astra_siquijor_first + $this->wastage_pfizer_siquijor_first +
            $this->wastage_sputnikv_siquijor_first + $this->wastage_moderna_siquijor_first + $this->wastage_johnson_siquijor_first; //TOTAL WASTAGE FIRST SIQUIJOR
        $this->total_wastage_cebu_facility = $this->wastage_sinovac_cebu_facility_first + $this->wastage_astra_cebu_facility_first + $this->wastage_pfizer_cebu_facility_first +
            $this->wastage_sputnikv_cebu_facility_first + $this->wastage_moderna_cebu_facility_first + $this->wastage_johnson_cebu_facility_first; //TOTAL WASTAGE FIRST CEBU FACILITY
        $this->total_wastage_mandaue_facility = $this->wastage_sinovac_mandaue_facility_first + $this->wastage_astra_mandaue_facility_first + $this->wastage_pfizer_mandaue_facility_first +
            $this->wastage_sputnikv_mandaue_facility_first + $this->wastage_moderna_mandaue_facility_first + $this->wastage_johnson_mandaue_facility_first; //TOTAL WASTAGE FIRST MANDAUE FACILITY
        $this->total_wastage_lapu_facility = $this->wastage_sinovac_lapu_facility_first + $this->wastage_astra_lapu_facility_first + $this->wastage_pfizer_lapu_facility_first +
            $this->wastage_sputnikv_lapu_facility_first + + $this->wastage_moderna_lapu_facility_first + $this->wastage_johnson_lapu_facility_first; //TOTAL WASTAGE FIRST LAPU-LAPU FACILITY

        //TOTAL REFUSAL
        $this->total_refusal_first = $this->refused_first_bohol + $this->refused_first_cebu + $this->refused_first_negros + $this->refused_first_siquijor +
            $this->refused_cebu_facility_first + $this->refused_mandaue_facility_first + $this->refused_lapu_facility_first ; //REFUSED FIRST REGION
        $this->total_refusal_second = $this->refused_second_bohol + $this->refused_second_cebu + $this->refused_second_negros + $this->refused_second_siquijor +
            $this->refused_cebu_facility_second + $this->refused_mandaue_facility_second + $this->refused_lapu_facility_second; //REFUSED SECOND REGION

        //TOTAL DEFFERED
        $this->total_deferred_first = $this->deferred_first_bohol + $this->deferred_first_cebu + $this->deferred_first_negros + $this->deferred_first_siquijor +
            $this->deferred_cebu_facility_first + $this->deferred_mandaue_facility_first + $this->deferred_lapu_facility_first; //DEFERRED FIRST REGION
        $this->total_deferred_second = $this->deferred_second_bohol + $this->deferred_second_cebu + $this->deferred_second_negros + $this->deferred_second_siquijor +
            $this->deferred_cebu_facility_second + $this->deferred_mandaue_facility_second + $this->deferred_lapu_facility_second ; //DEFERRED SECOND REGION

        //WASTAGE_SINOVAC_FIRST
        $this->wastage_sinovac_first = $this->wastage_sinovac_bohol_first + $this->wastage_sinovac_cebu_first + $this->wastage_sinovac_negros_first + $this->wastage_sinovac_siquijor_first +
            $this->wastage_sinovac_cebu_facility_first + $this->wastage_sinovac_mandaue_facility_first + $this->wastage_sinovac_lapu_facility_first; //WASTAGE SINOVAC REGION
        $this->wastage_astra_first = $this->wastage_astra_bohol_first + $this->wastage_astra_cebu_first + $this->wastage_astra_negros_first + $this->wastage_astra_siquijor_first +
            $this->wastage_astra_cebu_facility_first + $this->wastage_astra_mandaue_facility_first + $this->wastage_astra_lapu_facility_first ; //WASTAGE ASTRA  REGION
        $this->wastage_pfizer_first = $this->wastage_pfizer_bohol_first + $this->wastage_pfizer_cebu_first + $this->wastage_pfizer_negros_first + $this->wastage_pfizer_siquijor_first +
            $this->wastage_pfizer_cebu_facility_first + $this->wastage_pfizer_mandaue_facility_first + $this->wastage_pfizer_lapu_facility_first; //WASTAGE PFIZER REGION
        $this->wastage_sputnikv_first = $this->wastage_sputnikv_bohol_first + $this->wastage_sputnikv_cebu_first + $this->wastage_sputnikv_negros_first + $this->wastage_sputnikv_siquijor_first +
            $this->wastage_sputnikv_cebu_facility_first + $this->wastage_sputnikv_mandaue_facility_first + $this->wastage_sputnikv_lapu_facility_first; //WASTAGE SPUTNIKV  REGION
        $this->wastage_moderna_first = $this->wastage_moderna_bohol_first + $this->wastage_moderna_cebu_first + $this->wastage_moderna_negros_first + $this->wastage_moderna_siquijor_first +
            $this->wastage_moderna_cebu_facility_first + $this->wastage_moderna_mandaue_facility_first + $this->wastage_moderna_lapu_facility_first; //WASTAGE MODERNA REGION
        $this->wastage_johnson_first = $this->wastage_johnson_bohol_first + $this->wastage_johnson_cebu_first + $this->wastage_johnson_negros_first + $this->wastage_johnson_siquijor_first +
            $this->wastage_johnson_cebu_facility_first + $this->wastage_johnson_mandaue_facility_first + $this->wastage_johnson_lapu_facility_first; //WASTAGE JOHNSON REGION


        //WASTAGE
        $this->wastage_region = $this->wastage_sinovac_first + $this->wastage_astra_first + $this->wastage_pfizer_first +
            $this->wastage_sputnikv_first + $this->wastage_moderna_first + $this->wastage_johnson_first; //TOTAL WASTAGE REGION


        //CONSUMPTION_RATE_SINOVAC_FIRST
        $this->c_rate_sinovac_bohol_first = number_format($this->vcted_sinovac_bohol_first / $this->sinovac_bohol_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST BOHOL
        $this->c_rate_sinovac_cebu_first = number_format($this->vcted_sinovac_cebu_first / $this->sinovac_cebu_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST CEBU
        $this->c_rate_sinovac_negros_first = number_format($this->vcted_sinovac_negros_first / $this->sinovac_negros_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST NEGROS
        $this->c_rate_sinovac_siquijor_first = number_format($this->vcted_sinovac_siquijor_first / $this->sinovac_siquijor_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST SIQUIJOR
        $this->c_rate_sinovac_cebu_facility_first = number_format($this->vcted_sinovac_cebu_facility_first / $this->sinovac_cebu_facility_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST CEBU FACILITY
        $this->c_rate_sinovac_mandaue_facility_first = number_format($this->vcted_sinovac_mandaue_facility_first / $this->sinovac_mandaue_facility_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST MANDAUE FACILITY
        $this->c_rate_sinovac_lapu_facility_first = number_format($this->vcted_sinovac_lapu_facility_first / $this->sinovac_lapu_facility_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST LAPU-LAPU FACILITY

        //CONSUMPTION_RATE_ASTRAZENECA_FIRST
        $this->c_rate_astra_bohol_first = number_format($this->vcted_astra_bohol_first / $this->astra_bohol_first * 100,2); //CONSUMPTION RATE ASTRA FIRST BOHOL
        $this->c_rate_astra_cebu_first = number_format($this->vcted_astra_cebu_first / $this->astra_cebu_first * 100,2); //CONSUMPTION RATE ASTRA FIRST CEBU
        $this->c_rate_astra_negros_first = number_format($this->vcted_astra_negros_first / $this->astra_negros_first * 100,2); //CONSUMPTION RATE ASTRA FIRST NEGROS
        $this->c_rate_astra_siquijor_first = number_format($this->vcted_astra_siquijor_first / $this->astra_siquijor_first * 100,2); //CONSUMPTION RATE ASTRA FIRST SIQUIJOR
        $this->c_rate_astra_cebu_facility_first = number_format($this->vcted_astra_cebu_facility_first / $this->astra_cebu_facility_first * 100,2); //CONSUMPTION RATE ASTRA FIRST CEBU FACILITY
        $this->c_rate_astra_mandaue_facility_first = number_format($this->vcted_astra_mandaue_facility_first / $this->astra_mandaue_facility_first * 100,2); //CONSUMPTION RATE ASTRA FIRST MANDAUE FACILITY
        $this->c_rate_astra_lapu_facility_first = number_format($this->vcted_astra_lapu_facility_first / $this->astra_lapu_facility_first * 100,2); //CONSUMPTION RATE ASTRA FIRST LAPU-LAPU

        //CONSUMPTION_RATE_PFIZER_FIRST
        $this->c_rate_pfizer_bohol_first = number_format($this->vcted_pfizer_bohol_first / $this->pfizer_bohol_first * 100,2); //CONSUMPTION RATE PFIZER FIRST BOHOL
        $this->c_rate_pfizer_cebu_first = number_format($this->vcted_pfizer_cebu_first / $this->pfizer_cebu_first * 100,2); //CONSUMPTION RATE PFIZER FIRST CEBU
        $this->c_rate_pfizer_negros_first = number_format($this->vcted_pfizer_negros_first / $this->pfizer_negros_first * 100,2); //CONSUMPTION RATE PFIZER FIRST NEGROS
        $this->c_rate_pfizer_siquijor_first = number_format($this->vcted_pfizer_siquijor_first / $this->pfizer_siquijor_first * 100,2); //CONSUMPTION RATE PFIZER FIRST SIQUIJOR
        $this->c_rate_pfizer_cebu_facility_first = number_format($this->vcted_pfizer_cebu_facility_first / $this->pfizer_cebu_facility_first * 100,2); //CONSUMPTION RATE PFIZER FIRST CEBU FACILITY
        $this->c_rate_pfizer_mandaue_facility_first = number_format($this->vcted_pfizer_mandaue_facility_first / $this->pfizer_mandaue_facility_first * 100,2); //CONSUMPTION RATE PFIZER FIRST MANDAUE FACILITY
        $this->c_rate_pfizer_lapu_facility_first = number_format($this->vcted_pfizer_lapu_facility_first / $this->pfizer_lapu_facility_first * 100,2); //CONSUMPTION RATE PFIZER FIRST LAPU-LAPU

        //CONSUMPTION_RATE_SPUTNIKV_FIRST
        $this->c_rate_sputnikv_bohol_first = number_format($this->vcted_sputnikv_bohol_first / $this->sputnikv_bohol_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST BOHOL
        $this->c_rate_sputnikv_cebu_first = number_format($this->vcted_sputnikv_cebu_first / $this->sputnikv_cebu_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST CEBU
        $this->c_rate_sputnikv_negros_first = number_format($this->vcted_sputnikv_negros_first / $this->sputnikv_negros_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST NEGROS
        $this->c_rate_sputnikv_siquijor_first = number_format($this->vcted_sputnikv_siquijor_first / $this->sputnikv_siquijor_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST SIQUIJOR
        $this->c_rate_sputnikv_cebu_facility_first = number_format($this->vcted_sputnikv_cebu_facility_first / $this->sputnikv_cebu_facility_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST CEBU FACILITY
        $this->c_rate_sputnikv_mandaue_facility_first = number_format($this->vcted_sputnikv_mandaue_facility_first / $this->sputnikv_mandaue_facility_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST MANDAUE FACILITY
        $this->c_rate_sputnikv_lapu_facility_first = number_format($this->vcted_sputnikv_lapu_facility_first / $this->sputnikv_lapu_facility_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST LAPU-LAPU

        //CONSUMPTION_RATE_MODERNA_FIRST
        $this->c_rate_moderna_bohol_first = number_format($this->vcted_moderna_bohol_first / $this->moderna_bohol_first * 100,2); //CONSUMPTION RATE MODERNA FIRST BOHOL
        $this->c_rate_moderna_cebu_first = number_format($this->vcted_moderna_cebu_first / $this->moderna_cebu_first * 100,2); //CONSUMPTION RATE MODERNA FIRST CEBU
        $this->c_rate_moderna_negros_first = number_format($this->vcted_moderna_negros_first / $this->moderna_negros_first * 100,2); //CONSUMPTION RATE MODERNA FIRST NEGROS
        $this->c_rate_moderna_siquijor_first = number_format($this->vcted_moderna_siquijor_first / $this->moderna_siquijor_first * 100,2); //CONSUMPTION RATE MODERNA FIRST SIQUIJOR
        $this->c_rate_moderna_cebu_facility_first = number_format($this->vcted_moderna_cebu_facility_first / $this->moderna_cebu_facility_first * 100,2); //CONSUMPTION RATE MODERNA FIRST CEBU FACILITY
        $this->c_rate_moderna_mandaue_facility_first = number_format($this->vcted_moderna_mandaue_facility_first / $this->moderna_mandaue_facility_first * 100,2); //CONSUMPTION RATE MODERNA FIRST MANDAUE FACILITY
        $this->c_rate_moderna_lapu_facility_first = number_format($this->vcted_moderna_lapu_facility_first / $this->moderna_lapu_facility_first * 100,2); //CONSUMPTION RATE MODERNA FIRST LAPU-LAPU

        //CONSUMPTION_RATE_JOHNSON_FIRST
        $this->c_rate_johnson_bohol_first = number_format($this->vcted_johnson_bohol_first / $this->johnson_bohol_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST BOHOL
        $this->c_rate_johnson_cebu_first = number_format($this->vcted_johnson_cebu_first / $this->johnson_cebu_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST CEBU
        $this->c_rate_johnson_negros_first = number_format($this->vcted_johnson_negros_first / $this->johnson_negros_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST NEGROS
        $this->c_rate_johnson_siquijor_first = number_format($this->vcted_johnson_siquijor_first / $this->johnson_siquijor_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST SIQUIJOR
        $this->c_rate_johnson_cebu_facility_first = number_format($this->vcted_johnson_cebu_facility_first / $this->johnson_cebu_facility_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST CEBU FACILITY
        $this->c_rate_johnson_mandaue_facility_first = number_format($this->vcted_johnson_mandaue_facility_first / $this->johnson_mandaue_facility_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST MANDAUE FACILITY
        $this->c_rate_johnson_lapu_facility_first = number_format($this->vcted_johnson_lapu_facility_first / $this->johnson_lapu_facility_first * 100,2); //CONSUMPTION RATE JOHNSON FIRST LAPU-LAPU


        //TOTAL_CONSUMPTION_RATE_FIRST
        $this->total_c_rate_bohol_first = number_format($this->total_vcted_first_bohol / $this->total_bohol_first * 100,2); //TOTAL CONSUMPTION RATE FIRST BOHOL
        $this->total_c_rate_cebu_first = number_format($this->total_vcted_first_cebu / $this->total_cebu_first * 100,2); //TOTAL CONSUMPTION RATE FIRST CEBU
        $this->total_c_rate_negros_first = number_format($this->total_vcted_first_negros / $this->total_negros_first * 100,2); //TOTAL CONSUMPTION RATE FIRST NEGROS
        $this->total_c_rate_siquijor_first = number_format($this->total_vcted_first_siquijor / $this->total_siquijor_first * 100,2); //TOTAL CONSUMPTION RATE FIRST SIQUIJOR
        $this->total_c_rate_cebu_facility_first = number_format($this->total_vcted_cebu_facility_first / $this->total_cebu_facility_first * 100,2); //TOTAL CONSUMPTION RATE FIRST CEBU FACILITY
        $this->total_c_rate_mandaue_facility_first = number_format($this->total_vcted_mandaue_facility_first / $this->total_mandaue_facility_first * 100,2); //TOTAL CONSUMPTION RATE FIRST MANDAUE FACILITY
        $this->total_c_rate_lapu_facility_first = number_format($this->total_vcted_lapu_facility_first / $this->total_lapu_facility_first * 100,2); //TOTAL CONSUMPTION RATE FIRST LAPU-LAPU FACILITY

        //CONSUMPTION_RATE_REGION_FIRST
        $this->c_rate_region_sinovac_first = number_format($this->region_sinovac_first_dose / $this->sinovac_region_first * 100,2); //CONSUMPTION RATE SINOVAC FIRST REGION
        $this->c_rate_region_astra_first = number_format($this->region_astra_first_dose / $this->astra_region_first * 100,2); //CONSUMPTION RATE ASTRA FIRST REGION
        $this->c_rate_region_pfizer_first = number_format($this->region_pfizer_first_dose / $this->pfizer_region_first * 100,2); //CONSUMPTION RATE PFIZER FIRST REGION
        $this->c_rate_region_sputnikv_first = number_format($this->region_sputnikv_first_dose / $this->sputnikv_region_first * 100,2); //CONSUMPTION RATE SPUTNIKV FIRST REGION
        $this->c_rate_region_moderna_first = number_format($this->region_moderna_first_dose / $this->moderna_region_first * 100,2); //CONSUMPTION RATE MODERNA FIRST REGION
        $this->c_rate_region_johnson_first = number_format($this->region_johnson_first_dose / $this->johnson_region_first * 100,2); //CONSUMPTION RATE MODERNA FIRST REGION


        //CONSUMPTION_RATE_SINOVAC_SECOND
        $this->c_rate_sinovac_bohol_second = number_format($this->vcted_sinovac_bohol_second / $this->sinovac_bohol_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND BOHOL
        $this->c_rate_sinovac_cebu_second = number_format($this->vcted_sinovac_cebu_second / $this->sinovac_cebu_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND CEBU
        $this->c_rate_sinovac_negros_second = number_format($this->vcted_sinovac_negros_second / $this->sinovac_negros_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND NEGROS
        $this->c_rate_sinovac_siquijor_second = number_format($this->vcted_sinovac_siquijor_second / $this->sinovac_siquijor_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND SIQUIJOR
        $this->c_rate_sinovac_cebu_facility_second = number_format($this->vcted_sinovac_cebu_facility_second / $this->sinovac_cebu_facility_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND CEBU FACILITY
        $this->c_rate_sinovac_mandaue_facility_second = number_format($this->vcted_sinovac_mandaue_facility_second / $this->sinovac_mandaue_facility_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND MANDAUE FACILITY
        $this->c_rate_sinovac_lapu_facility_second = number_format($this->vcted_sinovac_lapu_facility_second / $this->sinovac_lapu_facility_second * 100,2); //CONSUMPTION RATE SINOVAC SECOND LAPU-LAPU

        //CONSUMPTION_RATE_ASTRAZENECA_SECOND
        $this->c_rate_astra_bohol_second = number_format($this->vcted_astra_bohol_second / $this->astra_bohol_second * 100,2); //CONSUMPTION RATE ASTRA SECOND BOHOL
        $this->c_rate_astra_cebu_second = number_format($this->vcted_astra_cebu_second / $this->astra_cebu_second * 100,2); //CONSUMPTION RATE ASTRA SECOND CEBU
        $this->c_rate_astra_negros_second = number_format($this->vcted_astra_negros_second / $this->astra_negros_second * 100,2); //CONSUMPTION RATE ASTRA SECOND NEGROS
        $this->c_rate_astra_siquijor_second = number_format($this->vcted_astra_siquijor_second / $this->astra_siquijor_second * 100,2); //CONSUMPTION RATE ASTRA SECOND SIQUIJOR
        $this->c_rate_astra_cebu_facility_second = number_format($this->vcted_astra_cebu_facility_second / $this->astra_cebu_facility_second * 100,2); //CONSUMPTION RATE ASTRA SECOND CEBU FACILITY
        $this->c_rate_astra_mandaue_facility_second = number_format($this->vcted_astra_mandaue_facility_second / $this->astra_mandaue_facility_second * 100,2); //CONSUMPTION RATE ASTRA SECOND MANDAUE FACILITY
        $this->c_rate_astra_lapu_facility_second = number_format($this->vcted_astra_lapu_facility_second / $this->astra_lapu_facility_second * 100,2); //CONSUMPTION RATE ASTRA SECOND LAPU-LAPU

        //CONSUMPTION_RATE_PFIZER_SECOND
        $this->c_rate_pfizer_bohol_second = number_format($this->vcted_pfizer_bohol_second / $this->pfizer_bohol_second * 100,2); //CONSUMPTION RATE PFIZER SECOND BOHOL
        $this->c_rate_pfizer_cebu_second = number_format($this->vcted_pfizer_cebu_second / $this->pfizer_cebu_second * 100,2); //CONSUMPTION RATE PFIZER SECOND CEBU
        $this->c_rate_pfizer_negros_second = number_format($this->vcted_pfizer_negros_second / $this->pfizer_negros_second * 100,2); //CONSUMPTION RATE PFIZER SECOND NEGROS
        $this->c_rate_pfizer_siquijor_second = number_format($this->vcted_pfizer_siquijor_second / $this->pfizer_siquijor_second * 100,2); //CONSUMPTION RATE PFIZER SECOND SIQUIJOR
        $this->c_rate_pfizer_cebu_facility_second = number_format($this->vcted_pfizer_cebu_facility_second / $this->pfizer_cebu_facility_second * 100,2); //CONSUMPTION RATE PFIZER SECOND CEBU FACILITY
        $this->c_rate_pfizer_mandaue_facility_second = number_format($this->vcted_pfizer_mandaue_facility_second / $this->pfizer_mandaue_facility_second * 100,2); //CONSUMPTION RATE PFIZER SECOND MANDAUE FACILITY
        $this->c_rate_pfizer_lapu_facility_second = number_format($this->vcted_pfizer_lapu_facility_second / $this->pfizer_mandaue_facility_second * 100,2); //CONSUMPTION RATE PFIZER SECOND LAPU-LAPU FACILITY

        //CONSUMPTION_RATE_SPUTNIKV_SECOND
        $this->c_rate_sputnikv_bohol_second = number_format($this->vcted_sputnikv_bohol_second / $this->sputnikv_bohol_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND BOHOL
        $this->c_rate_sputnikv_cebu_second = number_format($this->vcted_sputnikv_cebu_second / $this->sputnikv_cebu_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND CEBU
        $this->c_rate_sputnikv_negros_second = number_format($this->vcted_sputnikv_negros_second / $this->sputnikv_negros_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND NEGROS
        $this->c_rate_sputnikv_siquijor_second = number_format($this->vcted_sputnikv_siquijor_second / $this->sputnikv_siquijor_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND SIQUIJOR
        $this->c_rate_sputnikv_cebu_facility_second = number_format($this->vcted_sputnikv_cebu_facility_second / $this->sputnikv_cebu_facility_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND CEBU FACILITY
        $this->c_rate_sputnikv_mandaue_facility_second = number_format($this->vcted_sputnikv_mandaue_facility_second / $this->sputnikv_mandaue_facility_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND MANDAUE FACILITY
        $this->c_rate_sputnikv_lapu_facility_second = number_format($this->vcted_sputnikv_lapu_facility_second / $this->sputnikv_mandaue_facility_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND LAPU-LAPU FACILITY

        //CONSUMPTION_RATE_MODERNA_SECOND
        $this->c_rate_moderna_bohol_second = number_format($this->vcted_moderna_bohol_second / $this->moderna_bohol_second * 100,2); //CONSUMPTION RATE MODERNA SECOND BOHOL
        $this->c_rate_moderna_cebu_second = number_format($this->vcted_moderna_cebu_second / $this->moderna_cebu_second * 100,2); //CONSUMPTION RATE MODERNA SECOND CEBU
        $this->c_rate_moderna_negros_second = number_format($this->vcted_moderna_negros_second / $this->moderna_negros_second * 100,2); //CONSUMPTION RATE MODERNA SECOND NEGROS
        $this->c_rate_moderna_siquijor_second = number_format($this->vcted_moderna_siquijor_second / $this->moderna_siquijor_second * 100,2); //CONSUMPTION RATE MODERNA SECOND SIQUIJOR
        $this->c_rate_moderna_cebu_facility_second = number_format($this->vcted_moderna_cebu_facility_second / $this->moderna_cebu_facility_second * 100,2); //CONSUMPTION RATE MODERNA SECOND CEBU FACILITY
        $this->c_rate_moderna_mandaue_facility_second = number_format($this->vcted_moderna_mandaue_facility_second / $this->moderna_mandaue_facility_second * 100,2); //CONSUMPTION RATE MODERNA SECOND MANDAUE FACILITY
        $this->c_rate_moderna_lapu_facility_second = number_format($this->vcted_moderna_lapu_facility_second / $this->moderna_mandaue_facility_second * 100,2); //CONSUMPTION RATE MODERNA SECOND LAPU-LAPU FACILITY

        //CONSUMPTION_RATE_JOHNSON_SECOND
        $this->c_rate_johnson_bohol_second = number_format($this->vcted_johnson_bohol_second / $this->johnson_bohol_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND BOHOL
        $this->c_rate_johnson_cebu_second = number_format($this->vcted_johnson_cebu_second / $this->johnson_cebu_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND CEBU
        $this->c_rate_johnson_negros_second = number_format($this->vcted_johnson_negros_second / $this->johnson_negros_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND NEGROS
        $this->c_rate_johnson_siquijor_second = number_format($this->vcted_johnson_siquijor_second / $this->johnson_siquijor_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND SIQUIJOR
        $this->c_rate_johnson_cebu_facility_second = number_format($this->vcted_johnson_cebu_facility_second / $this->johnson_cebu_facility_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND CEBU FACILITY
        $this->c_rate_johnson_mandaue_facility_second = number_format($this->vcted_johnson_mandaue_facility_second / $this->johnson_mandaue_facility_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND MANDAUE FACILITY
        $this->c_rate_johnson_lapu_facility_second = number_format($this->vcted_johnson_lapu_facility_second / $this->johnson_mandaue_facility_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND LAPU-LAPU FACILITY



        //TOTAL_CONSUMPTION_RATE_SECOND
        $this->total_c_rate_bohol_second = number_format($this->total_vcted_second_bohol / $this->total_bohol_second * 100,2); //TOTAL CONSUMPTION RATE SECOND BOHOL
        $this->total_c_rate_cebu_second = number_format($this->total_vcted_second_cebu / $this->total_cebu_second * 100,2); //TOTAL CONSUMPTION RATE SECOND CEBU
        $this->total_c_rate_negros_second = number_format($this->total_vcted_second_negros / $this->total_negros_second * 100,2); //TOTAL CONSUMPTION RATE SECOND NEGROS
        $this->total_c_rate_siquijor_second = number_format($this->total_vcted_second_siquijor / $this->total_siquijor_second * 100,2); //TOTAL CONSUMPTION RATE SECOND SIQUIJOR
        $this->total_c_rate_cebu_facility_second = number_format($this->total_vcted_cebu_facility_second / $this->total_cebu_facility_second * 100,2);  //TOTAL CONSUMPTION RATE SECOND CEBU FACILITY
        $this->total_c_rate_mandaue_facility_second = number_format($this->total_vcted_mandaue_facility_second / $this->total_mandaue_facility_second * 100,2); //TOTAL CONSUMPTION RATE SECOND MANDAUE FACILITY
        $this->total_c_rate_lapu_facility_second =  number_format($this->total_vcted_lapu_facility_second / $this->total_lapu_facility_second * 100,2); //TOTAL CONSUMPTION RATE SECOND LAPU-LAPU FACI

        //CONSUMPTION_RATE_REGION_SECOND
        $this->c_rate_region_sinovac_second = number_format($this->region_sinovac_second_dose / $this->sinovac_region_second * 100,2);  //CONSUMPTION RATE SINOVAC SECOND REGION
        $this->c_rate_region_astra_second = number_format($this->region_astra_second_dose / $this->astra_region_second * 100,2); //CONSUMPTION RATE ASTRA SECOND REGION
        $this->c_rate_region_pfizer_second =  number_format($this->region_pfizer_second_dose / $this->pfizer_region_second * 100,2); //CONSUMPTION RATE PFIZER SECOND REGION
        $this->c_rate_region_sputnikv_second = number_format($this->region_sputnikv_second_dose / $this->sputnikv_region_second * 100,2); //CONSUMPTION RATE SPUTNIKV SECOND REGION
        $this->c_rate_region_moderna_second = number_format($this->region_moderna_second_dose / $this->moderna_region_second * 100,2); //CONSUMPTION RATE MODERNA SECOND REGION
        $this->c_rate_region_johnson_second = number_format($this->region_johnson_second_dose / $this->johnson_region_second * 100,2); //CONSUMPTION RATE JOHNSON SECOND REGION


        //TOTAL_C_RATE_REGION_FIRST
        $this->total_c_rate_region_first = number_format($this->first_dose_total / $this->total_region_first * 100,2 ); //TOTAL CONSUMPTION RATE FIRST REGION

        //TOTAL_C_RATE_REGION_SECOND
        $this->total_c_rate_region_second = number_format($this->second_dose_total / $this->total_region_second * 100,2 ); //TOTAL CONSUMPTION RATE SECOND REGION


        //priority_set
        $this->priority_set = "(".strtoupper($priority).")";
    }

    public function dataCollapse(Request $request)
    {
        $global_elipop_a1 = \App\Muncity::select(DB::raw("sum(COALESCE(a1,0)) as a1"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->a1;
        $global_elipop_a2 = \App\Muncity::select(DB::raw("sum(COALESCE(a2,0)) as a2"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->a2;
        $global_elipop_a3 = \App\Muncity::select(DB::raw("sum(COALESCE(a3,0)) as a3"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->a3;
        $global_elipop_a4 = \App\Muncity::select(DB::raw("sum(COALESCE(a4,0)) as a4"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->a4;
        $global_elipop_a5 = \App\Muncity::select(DB::raw("sum(COALESCE(a5,0)) as a5"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->a5;
        $global_elipop_b1 = \App\Muncity::select(DB::raw("sum(COALESCE(b1,0)) as b1"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->b1;
        $global_elipop_b2 = \App\Muncity::select(DB::raw("sum(COALESCE(b2,0)) as b2"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->b2;
        $global_elipop_b3 = \App\Muncity::select(DB::raw("sum(COALESCE(b3,0)) as b3"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->b3;
        $global_elipop_b4 = \App\Muncity::select(DB::raw("sum(COALESCE(b4,0)) as b4"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->b4;

        if($request->typeof_vaccine == "sinovac")
        {
            $total_epop_a1 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_SINOVAC
            $total_epop_a2 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_SINOVAC
            $total_epop_a3 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_SINOVAC
            $total_epop_a4 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_SINOVAC
            $total_epop_a5 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_SINOVAC
            $total_epop_b1 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_SINOVAC
            $total_epop_b2 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_SINOVAC
            $total_epop_b3 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_SINOVAC
            $total_epop_b4 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_SINOVAC

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_SINOVAC (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_SINOVAC (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_SINOVAC

            $total_a1_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first :0; //A1_SINOVAC
            $total_a2_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first :0; //A2_SINOVAC
            $total_a3_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first :0; //A3_SINOVAC
            $total_a4_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first :0; //A4_SINOVAC
            $total_a5_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first :0; //A5_SINOVAC
            $total_b1_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first :0; //B1_SINOVAC
            $total_b2_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first :0; //B2_SINOVAC
            $total_b3_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first :0; //B3_SINOVAC
            $total_b4_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first :0; //B4_SINOVAC

            $total_a1_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second :0; //A1_SINOVAC 2
            $total_a2_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second :0; //A2_SINOVAC 2
            $total_a3_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second :0; //A3_SINOVAC 2
            $total_a4_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second :0; //A4_SINOVAC 2
            $total_a5_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second :0; //A5_SINOVAC 2
            $total_b1_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second :0; //B1_SINOVAC 2
            $total_b2_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second :0; //B2_SINOVAC 2
            $total_b3_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second :0; //B3_SINOVAC 2
            $total_b4_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second :0; //B4_SINOVAC 2

            $total_mild_frst =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->mild_first :0; //MILD_SINOVAC
            $total_mild_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->mild_second :0; //MILD_SINOVAC 2

            $total_srs_frst =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->serious_first :0; //SERIOUS_SINOVAC
            $total_srs_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->serious_second :0; //SERIOUS_SINOVAC 2

            $total_dfrd_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->deferred_first :0; //DEFERRED_SINOVAC
            $total_dfrd_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->deferred_second :0; //DEFERRED_SINOVAC 2

            $total_rfsd_frst =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->refused_first :0; //REFUSED_SINOVAC
            $total_rfsd_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->refused_second :0; //REFUSED_SINOVAC 2

            $total_wstge_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->wastage_first :0; //WASTAGF_SINOVAC
            $total_wstge_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Sinovac")->whereNull("facility_id")->first()->wastage_second :0; //WASTAGE_SINOVAC 2

            $total_vcted_frst =  $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst +
                $total_b1_frst +  $total_b2_frst + $total_b3_frst + $total_b4_frst; //TOTAL VACCINATED_SINOVAC FIRST
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd +
                $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd; //TOTAL VACCINATED_SINOVAC SECOND

            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_SINOVAC
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_SINOVAC 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_SINOVAC
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE SINOVAC 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_SINOVAC
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_SINOVAC 2

            $view = 'vaccine.collapse.sinovac';
        }
        elseif ($request->typeof_vaccine == "astrazeneca")
        {
            $total_epop_a1 =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_ASTRA
            $total_epop_a2 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_ASTRA
            $total_epop_a3 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_ASTRA
            $total_epop_a4 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_ASTRA
            $total_epop_a5 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_ASTRA
            $total_epop_b1 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_ASTRA
            $total_epop_b2 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_ASTRA
            $total_epop_b3 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_ASTRA
            $total_epop_b4 =$request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_ASTRA

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_ASTRA (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_ASTRA (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;

            $total_a1_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first :0; //A1_ASTRA
            $total_a2_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first :0; //A2_ASTRA
            $total_a3_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first :0; //A3_ASTRA
            $total_a4_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first :0; //A4_ASTRA
            $total_a5_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first :0; //A5_ASTRA
            $total_b1_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first :0; //B1_ASTRA
            $total_b2_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first :0; //B2_ASTRA
            $total_b3_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first :0; //B3_ASTRA
            $total_b4_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first :0; //B4_ASTRA

            $total_a1_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second :0; //A1_ASTRA 2
            $total_a2_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second :0; //A2_ASTRA 2
            $total_a3_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second :0; //A3_ASTRA 2
            $total_a4_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second :0; //A4_ASTRA 2
            $total_a5_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second :0; //A5_ASTRA 2
            $total_b1_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second :0; //B1_ASTRA 2
            $total_b2_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second :0; //B2_ASTRA 2
            $total_b3_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second :0; //B3_ASTRA 2
            $total_b4_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second :0; //B4_ASTRA 2

            $total_mild_frst =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->mild_first :0; //MILD_ASTRA
            $total_mild_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->mild_second :0; //MILD_ASTRA 2

            $total_srs_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->serious_second :0;  //SERIOUS_AZTRAZENECA 2
            $total_srs_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->serious_first :0; //SERIOUS_ASTRA

            $total_dfrd_scnd =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->deferred_second :0; //DEFERRED_ASTRA 2
            $total_dfrd_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->deferred_first :0;  //DEFERRED_ASTRAZENECA

            $total_rfsd_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->refused_first :0; //REFUSED_ASTRA
            $total_rfsd_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->refused_second :0;

            $total_wstge_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->wastage_first :0; //WASTAGE_ASTRA
            $total_wstge_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Astrazeneca")->whereNull("facility_id")->first()->wastage_second :0; //WASTAGE_ASTRA2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst +
                $total_b1_frst + $total_b2_frst + $total_b3_frst + $total_b4_frst; //TOTAL VACCINATED_ASTRA FIRST
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd +
                $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd ; //TOTAL VACCINATED_ASTRA SECOND

            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_ASTRA
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_ASTRA 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE ASTRA
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION_RATE_ASTRA 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINUNG UNVACCINATED_ASTRA
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINUNG_UNVACCIANTED_ASTRA 2

            $view = 'vaccine.collapse.astrazeneca';
        }
        elseif ($request->typeof_vaccine == "pfizer")
        {

            $total_epop_a1 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 : 0; //E_POP_A1_PFIZER
            $total_epop_a2 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 : 0; //E_POP_A2_PFIZER
            $total_epop_a3 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 : 0; //E_POP_A3_PFIZER
            $total_epop_a4 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 : 0; //E_POP_A4_PFIZER
            $total_epop_a5 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 : 0; //E_POP_A5_PFIZER
            $total_epop_b1 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 : 0; //E_POP_B1_PFIZER
            $total_epop_b2 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 : 0; //E_POP_B2_PFIZER
            $total_epop_b3 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 : 0; //E_POP_B3_PFIZER
            $total_epop_b4 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 : 0; //E_POP_B4_PFIZER

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            //VACCINE ALLOCATED
            $total_vallocated_frst  = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0;  //VACCINE ALLOCATED_PFIZER (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_PFIZER (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;

            $total_a1_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first :0; //A1_PFIZER
            $total_a2_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first :0; //A2_PFIZER
            $total_a3_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first :0; //A3_PFIZER
            $total_a4_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first :0; //A4_PFIZER
            $total_a5_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first :0; //A5_PFIZER
            $total_b1_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first :0; //B1_PFIZER
            $total_b2_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first :0; //B2_PFIZER
            $total_b3_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first :0; //B3_PFIZER
            $total_b4_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first :0; //B4_PFIZER

            $total_a1_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second :0; //A1_PFIZER 2
            $total_a2_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second :0; //A2_PFIZER 2
            $total_a3_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second :0; //A3_PFIZER 2
            $total_a4_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second :0; //A4_PFIZER 2
            $total_a5_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second :0; //A5_PFIZER 2
            $total_b1_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second :0; //B1_PFIZER 2
            $total_b2_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second :0; //B2_PFIZER 2
            $total_b3_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second :0; //B3_PFIZER 2
            $total_b4_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second :0; //B4_PFIZER 2

            $total_mild_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->mild_first :0; //MILD_PFIZER
            $total_mild_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->mild_second :0; //MILD_PFIZER 2

            $total_srs_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->serious_first :0; //SERIOUS_PFIZER
            $total_srs_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->serious_second :0; //SERIOUS_PFIZER2

            $total_dfrd_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?\App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->deferred_first :0; //DEFERRED_PFIZER
            $total_dfrd_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->deferred_second :0; //DEFERRED_PFIZER 2

            $total_rfsd_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->refused_first :0; //REFUSED_PFIZER
            $total_rfsd_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->refused_second :0; //REFUSED_PFIZER 2

            $total_wstge_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->wastage_first :0; //WASTAGE_PFIZER
            $total_wstge_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Pfizer")->whereNull("facility_id")->first()->wastage_second :0; //WASTAGE_PFIZER2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst +
                $total_b1_frst + $total_b2_frst + $total_b3_frst + $total_b4_frst ; // TOTAL VACCINATED_PFIZER FIRST
            $total_vcted_scnd =  $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a4_scnd +
                $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd  ; // TOTAL VACCINATED_PFIZER SECOND

            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_PFIZER
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_PFIZER 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE PFIZER
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION_RATE_PFIZER2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINUNG_UNVACCINATED_PFIZER
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINUNG_UNVACCIANTED_S2 PFIZER 2


            $view = 'vaccine.collapse.pfizer';
        }
        elseif ($request->typeof_vaccine == "sputnikv")
        {
            $total_epop_a1 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 : 0; //E_POP_A1_SPUTNIKV
            $total_epop_a2 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 : 0; //E_POP_A2_SPUTNIKV
            $total_epop_a3 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 : 0; //E_POP_A3_SPUTNIKV
            $total_epop_a4 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 : 0; //E_POP_A4_SPUTNIKV
            $total_epop_a5 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 : 0; //E_POP_A5_SPUTNIKV
            $total_epop_b1 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 : 0; //E_POP_B1_SPUTNIKV
            $total_epop_b2 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 : 0; //E_POP_B2_SPUTNIKV
            $total_epop_b3 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 : 0; //E_POP_B3_SPUTNIKV
            $total_epop_b4 =$request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 : 0; //E_POP_B4_SPUTNIKV

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_SPUTNIKV (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_SPUTNIKV (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;

            $total_a1_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first :0; //A1_SPUTNIKV
            $total_a2_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first :0; //A2_SPUTNIKV
            $total_a3_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first :0; //A3_SPUTNIKV
            $total_a4_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first :0; //A4_SPUTNIKV
            $total_a5_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first :0; //A5_SPUTNIKV
            $total_b1_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first :0; //B1_SPUTNIKV
            $total_b2_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first :0; //B2_SPUTNIKV
            $total_b3_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first :0; //B3_SPUTNIKV
            $total_b4_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first :0; //B4_SPUTNIKV

            $total_a1_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second :0; //A1_SPUTNIKV 2
            $total_a2_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second :0; //A2_SPUTNIKV 2
            $total_a3_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second :0; //A3_SPUTNIKV 2
            $total_a4_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second :0; //A4_SPUTNIKV 2
            $total_a5_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second :0; //A5_SPUTNIKV 2
            $total_b1_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second :0; //B1_SPUTNIKV 2
            $total_b2_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second :0; //B2_SPUTNIKV 2
            $total_b3_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second :0; //B3_SPUTNIKV 2
            $total_b4_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second :0; //B4_SPUTNIKV 2

            $total_mild_frst =   $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->mild_first :0; //MILD_SPUTNIKV
            $total_mild_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->mild_second :0; //MILD_SPUTNIK 2

            $total_srs_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->serious_second :0; // SERIOUS SPUTNIK2
            $total_srs_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->serious_first :0; //SERIOUS_SPUTNIKV

            $total_dfrd_scnd =   $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->deferred_second :0; //DEFERRED_SPUTNIKV 2
            $total_dfrd_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->deferred_first :0;  //DEFERRED_SPUTNIKV

            $total_rfsd_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->refused_first :0; //REFUSED_SPUTNIKV
            $total_rfsd_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->refused_second :0; //REFUSED_SPUTNIKV 2

            $total_wstge_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->wastage_first :0; //WASTAGE_SPUTNIKV
            $total_wstge_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","SputnikV")->whereNull("facility_id")->first()->wastage_second :0; //WASTAGE_SPUTNIKV2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst +  $total_a5_frst +
                $total_b1_frst + $total_b2_frst + $total_b3_frst + $total_b4_frst; //TOTAL VACCINATED_SPUTNIKV FIRST
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd +
                $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd; //TOTAL VACCINATED_SPUTNIKV SECOND


            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_SPUTNIKV
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_SPUTNIKV 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE SPUTNIKV
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION_RATE_SPUTNIKV 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINUNG_UNVACCINATED_SPUTNIKV
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINUNG_UNVACCIANTED_SPUTNIKV 2

            $view = 'vaccine.collapse.sputnikv';
        }
        elseif ($request->typeof_vaccine == "moderna")
        {
            $total_epop_a1 =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 : 0; //E_POP_A1_MODERNA
            $total_epop_a2 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 : 0; //E_POP_A2_MODERNA
            $total_epop_a3 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 : 0; //E_POP_A3_MODERNA
            $total_epop_a4 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 : 0; //E_POP_A4_MODERNA
            $total_epop_a5 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 : 0; //E_POP_A5_MODERNA
            $total_epop_b1 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 : 0; //E_POP_B1_MODERNA
            $total_epop_b2 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 : 0; //E_POP_B2_MODERNA
            $total_epop_b3 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 : 0; //E_POP_B3_MODERNA
            $total_epop_b4 = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 : 0; //E_POP_B4_MODERNA

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_MODERNA (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_MODERNA (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;

            $total_a1_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first :0; //A1_MODERNA
            $total_a2_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first :0; //A2_MODERNA
            $total_a3_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first :0; //A3_MODERNA
            $total_a4_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first :0; //A4_MODERNA
            $total_a5_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first :0; //A5_MODERNA
            $total_b1_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first :0; //B1_MODERNA
            $total_b2_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first :0; //B2_MODERNA
            $total_b3_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first :0; //B3_MODERNA
            $total_b4_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first :0; //B4_MODERNA

            $total_a1_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second :0; //A1_MODERNA 2
            $total_a2_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second :0; //A2_MODERNA 2
            $total_a3_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second :0; //A3_MODERNA 2
            $total_a4_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second :0; //A4_MODERNA 2
            $total_a5_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second :0; //A5_MODERNA 2
            $total_b1_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second :0; //B1_MODERNA 2
            $total_b2_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second :0; //B2_MODERNA 2
            $total_b3_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second :0; //B3_MODERNA 2
            $total_b4_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second :0; //B4_MODERNA 2

            $total_mild_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->mild_first :0; //MILD_MODERNA
            $total_mild_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->mild_second :0; //MILD_MODERNA 2

            $total_srs_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->serious_first :0; //SERIOUS_MODERNA
            $total_srs_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->serious_second :0; // SERIOUS MODERNA2

            $total_dfrd_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->deferred_first :0;  //DEFERRED_MODERNA
            $total_dfrd_scnd =  $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->deferred_second :0; //DEFERRED_MODERNA 2

            $total_rfsd_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->refused_first :0; //REFUSED_JOHNSON
            $total_rfsd_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->refused_second :0; //REFUSED_MODERNA 2

            $total_wstge_frst = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->wastage_first :0; //WASTAGE_MODERNA
            $total_wstge_scnd = $request->typeof_vaccine == "moderna"  || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Moderna")->whereNull("facility_id")->first()->wastage_second :0; //WASTAGE_MODERNA 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst +  $total_a5_frst +
                $total_b1_frst + $total_b2_frst + $total_b3_frst + $total_b4_frst; //TOTAL VACCINATED_MODERNA FIRST
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd +
                $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd; //TOTAL VACCINATED_MODERNA SECOND

            $p_cvrge_frst = $total_vcted_frst / $total_epop* 100; //PERCENT_COVERAGE_MODERNA
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_MODERNA 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE MODERNA
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION_RATE_MODERNA 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINUNG_UNVACCNATED_MODERNA
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINUNG_UNVACCIANTED_MODERNA 2

            $view = 'vaccine.collapse.moderna';
        }
        elseif ($request->typeof_vaccine == "johnson")
        {
            $total_epop_a1 = $request->typeof_vaccine == "johnson"  || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 : 0; //E_POP_A1_JOHNSON
            $total_epop_a2 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 : 0; //E_POP_A2_JOHNSON
            $total_epop_a3 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 : 0; //E_POP_A3_JOHNSON
            $total_epop_a4 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 : 0; //E_POP_A4_JOHNSON
            $total_epop_a5 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 : 0; //E_POP_A5_JOHNSON
            $total_epop_b1 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 : 0; //E_POP_B1_JOHNSON
            $total_epop_b2 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 : 0; //E_POP_B2_JOHNSON
            $total_epop_b3 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 : 0; //E_POP_B3_JOHNSON
            $total_epop_b4 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 : 0; //E_POP_B4_JOHNSON

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  $request->allocated_first :0; //VACCINE ALLOCATED_MODERNA (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_MODERNA (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;

            $total_a1_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_first :0; //A1_JOHNSON
            $total_a2_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_first :0; //A2_JOHNSON
            $total_a3_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_first :0; //A3_JOHNSON
            $total_a4_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_first :0; //A4_JOHNSON
            $total_a5_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_first :0; //A5_JOHNSON
            $total_b1_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_first :0; //B1_JOHNSON
            $total_b2_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_first :0; //B2_JOHNSON
            $total_b3_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_first :0; //B3_JOHNSON
            $total_b4_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_first :0; //B4_JOHNSON

            $total_a1_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->whereNull("facility_id")->first()->vaccinated_second :0; //A1_JOHNSON 2
            $total_a2_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->whereNull("facility_id")->first()->vaccinated_second :0; //A2_JOHNSON 2
            $total_a3_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->whereNull("facility_id")->first()->vaccinated_second :0; //A3_JOHNSON 2
            $total_a4_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->whereNull("facility_id")->first()->vaccinated_second :0; //A4_JOHNSON 2
            $total_a5_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->whereNull("facility_id")->first()->vaccinated_second :0; //A5_JOHNSON 2
            $total_b1_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->whereNull("facility_id")->first()->vaccinated_second :0; //B1_JOHNSON 2
            $total_b2_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->whereNull("facility_id")->first()->vaccinated_second :0; //B2_JOHNSON 2
            $total_b3_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->whereNull("facility_id")->first()->vaccinated_second :0; //B3_JOHNSON 2
            $total_b4_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->whereNull("facility_id")->first()->vaccinated_second :0; //B4_JOHNSON 2

            $total_mild_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->mild_first :0; //MILD_JOHNSON
            $total_mild_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->mild_second :0; //MILD_JOHNSON 2

            $total_srs_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->serious_first :0; //SERIOUS_JOHNSON
            $total_srs_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->serious_second :0; // SERIOUS JOHNSON2

            $total_dfrd_scnd =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->deferred_second :0; //DEFERRED_JOHNSON 2
            $total_dfrd_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->deferred_first :0;  //DEFERRED_JOHNSON

            $total_rfsd_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->refused_first :0;   //REFUSED_ASTRA 2
            $total_rfsd_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->refused_second :0; //REFUSED_JOHNSON 2

            $total_wstge_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->wastage_first :0; //WASTAGE_JOHNSON
            $total_wstge_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("typeof_vaccine","Johnson")->whereNull("facility_id")->first()->wastage_second :0; //WASTAGE_JOHNSON 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst +  $total_a5_frst +
                $total_b1_frst + $total_b2_frst + $total_b3_frst + $total_b4_frst; //TOTAL VACCINATED_JOHNSON FIRST
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd +
                $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd; //TOTAL VACCINATED_JOHNSON SECOND


            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE JONHSON
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION_RATE_JOHNSON 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINUNG_UNVACCNATED_JOHNSON
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINUNG_UNVACCIANTED_JOHNSON 2

            $view = 'vaccine.collapse.johnson';
        }

        elseif ($request->typeof_vaccine == "total") {

            $total_epop_a1 = $global_elipop_a1;
            $total_epop_a2 = $global_elipop_a2;
            $total_epop_a3 = $global_elipop_a3;
            $total_epop_a4 = $global_elipop_a4;
            $total_epop_a5 = $global_elipop_a5;
            $total_epop_b1 = $global_elipop_b1;
            $total_epop_b2 = $global_elipop_b2;
            $total_epop_b3 = $global_elipop_b3;
            $total_epop_b4 = $global_elipop_b4;

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_overall_frst = Muncity::select(DB::raw("sum(COALESCE(sinovac_allocated_first,0)+COALESCE(astrazeneca_allocated_first,0)+COALESCE(pfizer_allocated_first,0)+COALESCE(sputnikv_allocated_first,0)+COALESCE(moderna_allocated_first,0)+COALESCE(johnson_allocated_first,0)) as total_vallocated_overall_frst"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->total_vallocated_overall_frst;  //VACCINE ALLOCATED_MODERNA (FD)
            $total_vallocated_overall_scnd = Muncity::select(DB::raw("sum(COALESCE(sinovac_allocated_second,0)+COALESCE(astrazeneca_allocated_second,0)+COALESCE(pfizer_allocated_second,0)+COALESCE(sputnikv_allocated_second,0)+COALESCE(moderna_allocated_second,0)+COALESCE(johnson_allocated_second,0)) as total_vallocated_overall_scnd"))->where("province_id",$request->province_id)->where("id",$request->muncity_id)->first()->total_vallocated_overall_scnd;  //VACCINE ALLOCATED_MODERNA (SD)

            $total_vallocated_overall =  $total_vallocated_overall_frst + $total_vallocated_overall_scnd ;

            $total_overall_a1_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a1_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a1")->whereNull("facility_id")->first()->total_overall_a1_frst; //A1_OVERALL
            $total_overall_a2_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a2_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a2")->whereNull("facility_id")->first()->total_overall_a2_frst; //A2_OVERALL
            $total_overall_a3_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a3_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a3")->whereNull("facility_id")->first()->total_overall_a3_frst; //A3_OVERALL
            $total_overall_a4_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a4_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a4")->whereNull("facility_id")->first()->total_overall_a4_frst; //A4_OVERALL
            $total_overall_a5_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a5_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a5")->whereNull("facility_id")->first()->total_overall_a5_frst; //A5_OVERALL
            $total_overall_b1_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b1_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b1")->whereNull("facility_id")->first()->total_overall_b1_frst; //B1_OVERALL
            $total_overall_b2_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b2_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b2")->whereNull("facility_id")->first()->total_overall_b2_frst; //B2_OVERALL
            $total_overall_b3_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b3_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b3")->whereNull("facility_id")->first()->total_overall_b3_frst; //B3_OVERALL
            $total_overall_b4_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b4_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b4")->whereNull("facility_id")->first()->total_overall_b4_frst; //B4_OVERALL

            $total_overall_a1_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a1_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a1")->whereNull("facility_id")->first()->total_overall_a1_scnd; //A1_OVERALL
            $total_overall_a2_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a2_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a2")->whereNull("facility_id")->first()->total_overall_a2_scnd; //A2_OVERALL
            $total_overall_a3_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a3_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a3")->whereNull("facility_id")->first()->total_overall_a3_scnd; //A3_OVERALL
            $total_overall_a4_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a4_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a4")->whereNull("facility_id")->first()->total_overall_a4_scnd; //A4_OVERALL
            $total_overall_a5_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a5_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","a5")->whereNull("facility_id")->first()->total_overall_a5_scnd; //A5_OVERALL
            $total_overall_b1_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b1_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b1")->whereNull("facility_id")->first()->total_overall_b1_scnd; //B1_OVERALL
            $total_overall_b2_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b2_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b2")->whereNull("facility_id")->first()->total_overall_b2_scnd; //B2_OVERALL
            $total_overall_b3_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b3_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b3")->whereNull("facility_id")->first()->total_overall_b3_scnd; //B3_OVERALL
            $total_overall_b4_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b4_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->where("priority","b4")->whereNull("facility_id")->first()->total_overall_b4_scnd; //B4_OVERALL

            $total_vcted_overall_frst = $total_overall_a1_frst + $total_overall_a2_frst + $total_overall_a3_frst + $total_overall_a4_frst + $total_overall_a5_frst +
                $total_overall_b1_frst + $total_overall_b2_frst + $total_overall_b3_frst + $total_overall_b4_frst ;
            $total_vcted_overall_scnd = $total_overall_a1_scnd + $total_overall_a2_scnd + $total_overall_a3_scnd + $total_overall_a4_scnd + $total_overall_a5_scnd +
                $total_overall_b1_scnd + $total_overall_b2_scnd + $total_overall_b3_scnd + $total_overall_b4_scnd ;

            $total_overall_mild_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as total_overall_mild_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_mild_frst; //MILD_FIRST
            $total_overall_mild_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as total_overall_mild_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_mild_scnd; //MILD_SECOND

            $total_overall_srs_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as total_overall_srs_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_srs_frst; //SERIOUS FIRST
            $total_overall_srs_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as total_overall_srs_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_srs_scnd; //SERIOUS SECOND

            $total_overall_dfrd_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as total_overall_dfrd_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_dfrd_frst; //DEFERRED FIRST
            $total_overall_dfrd_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as total_overall_dfrd_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_dfrd_scnd; //DEFERRED SECOND

            $total_overall_rfsd_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as total_overall_rfsd_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_rfsd_frst; //REFUSED FIRST
            $total_overall_rfsd_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as total_overall_rfsd_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_rfsd_scnd; //REFUSED SECOND

            $total_overall_wstge_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as total_overall_wstge_frst"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_wstge_frst; //WASTAGE FIRST
            $total_overall_wstge_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as total_overall_wstge_scnd"))->where("province_id",$request->province_id)->where("muncity_id",$request->muncity_id)->whereNull("facility_id")->first()->total_overall_wstge_scnd; //WASTAGE SECOND


            $p_cvrge_overall_frst = $total_vcted_overall_frst / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON
            $p_cvrge_overall_scnd = $total_vcted_overall_scnd / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON 2

            $total_c_rate_overall_frst = $total_vcted_overall_frst / $total_vallocated_overall_frst * 100; //CONSUMPTION RATE JONHSON
            $total_c_rate_overall_scnd = $total_vcted_overall_scnd / $total_vallocated_overall_scnd * 100; //CONSUMPTION_RATE_JOHNSON 2

            $total_r_unvcted_overall_frst = $total_epop - $total_vcted_overall_frst - $total_overall_rfsd_frst; //REMAINUNG_UNVACCNATED_JOHNSON
            $total_r_unvcted_overall_scnd = $total_epop - $total_vcted_overall_scnd - $total_overall_rfsd_scnd; //REMAINUNG_UNVACCIANTED_JOHNSON 2

            $view = 'vaccine.collapse.total';
        }

        return view($view,[

            "muncity_id" => $request->muncity_id,
            "total_epop_a1" => $total_epop_a1,
            "total_epop_a2" => $total_epop_a2,
            "total_epop_a3" => $total_epop_a3,
            "total_epop_a4" => $total_epop_a4,
            "total_epop_a5" => $total_epop_a5,
            "total_epop_b1" => $total_epop_b1,
            "total_epop_b2" => $total_epop_b2,
            "total_epop_b3" => $total_epop_b3,
            "total_epop_b4" => $total_epop_b4,
            "total_epop" => $total_epop,
            "allocated_first" => $total_vallocated_frst,
            "allocated_second" => $total_vallocated_scnd,
            "total_vallocated"=> $total_vallocated,

            "total_a1_frst" => $total_a1_frst,
            "total_a2_frst" => $total_a2_frst,
            "total_a3_frst" => $total_a3_frst,
            "total_a4_frst" => $total_a4_frst,
            "total_a5_frst" => $total_a5_frst,
            "total_b1_frst" => $total_b1_frst,
            "total_b2_frst" => $total_b2_frst,
            "total_b3_frst" => $total_b3_frst,
            "total_b4_frst" => $total_b4_frst,
            "total_vcted_frst" => $total_vcted_frst,
            "total_mild_frst" => $total_mild_frst,
            "total_srs_frst" => $total_srs_frst,
            "total_dfrd_frst" => $total_dfrd_frst,
            "total_rfsd_frst" => $total_rfsd_frst,
            "total_wstge_frst" => $total_wstge_frst,
            "p_cvrge_frst" => $p_cvrge_frst,
            "total_c_rate_frst" => $total_c_rate_frst,
            "total_r_unvcted_frst" => $total_r_unvcted_frst,

            "total_a1_scnd" => $total_a1_scnd,
            "total_a2_scnd" => $total_a2_scnd,
            "total_a3_scnd" => $total_a3_scnd,
            "total_a4_scnd" => $total_a4_scnd,
            "total_a5_scnd" => $total_a5_scnd,
            "total_b1_scnd" => $total_b1_scnd,
            "total_b2_scnd" => $total_b2_scnd,
            "total_b3_scnd" => $total_b3_scnd,
            "total_b4_scnd" => $total_b4_scnd,
            "total_vcted_scnd" => $total_vcted_scnd,
            "total_mild_scnd" => $total_mild_scnd,
            "total_srs_scnd" => $total_srs_scnd,
            "total_dfrd_scnd" => $total_dfrd_scnd,
            "total_rfsd_scnd" => $total_rfsd_scnd,
            "total_wstge_scnd" => $total_wstge_scnd,
            "p_cvrge_scnd" => $p_cvrge_scnd,
            "total_c_rate_scnd" => $total_c_rate_scnd,
            "total_r_unvcted_scnd" => $total_r_unvcted_scnd,

            //TOTAL OVER ALL
            "total_vallocated_overall_frst" => $total_vallocated_overall_frst,
            "total_vallocated_overall_scnd" => $total_vallocated_overall_scnd,
            "total_vallocated_overall" => $total_vallocated_overall,
            "total_overall_a1_frst" => $total_overall_a1_frst,
            "total_overall_a2_frst" => $total_overall_a2_frst,
            "total_overall_a3_frst" => $total_overall_a3_frst,
            "total_overall_a4_frst" => $total_overall_a4_frst,
            "total_overall_a5_frst" => $total_overall_a5_frst,
            "total_overall_b1_frst" => $total_overall_b1_frst,
            "total_overall_b2_frst" => $total_overall_b2_frst,
            "total_overall_b3_frst" => $total_overall_b3_frst,
            "total_overall_b4_frst" => $total_overall_b4_frst,
            "total_overall_a1_scnd" => $total_overall_a1_scnd,
            "total_overall_a2_scnd" => $total_overall_a2_scnd,
            "total_overall_a3_scnd" => $total_overall_a3_scnd,
            "total_overall_a4_scnd" => $total_overall_a4_scnd,
            "total_overall_a5_scnd" => $total_overall_a5_scnd,
            "total_overall_b1_scnd" => $total_overall_b1_scnd,
            "total_overall_b2_scnd" => $total_overall_b2_scnd,
            "total_overall_b3_scnd" => $total_overall_b3_scnd,
            "total_overall_b4_scnd" => $total_overall_b4_scnd,
            "total_vcted_overall_frst" => $total_vcted_overall_frst,
            "total_vcted_overall_scnd" => $total_vcted_overall_scnd,
            "total_overall_mild_frst" => $total_overall_mild_frst,
            "total_overall_mild_scnd" => $total_overall_mild_scnd,
            "total_overall_srs_frst" => $total_overall_srs_frst,
            "total_overall_srs_scnd" => $total_overall_srs_scnd,
            "total_overall_dfrd_frst" => $total_overall_dfrd_frst,
            "total_overall_dfrd_scnd" => $total_overall_dfrd_scnd,
            "total_overall_rfsd_frst" => $total_overall_rfsd_frst,
            "total_overall_rfsd_scnd" => $total_overall_rfsd_scnd,
            "total_overall_wstge_frst" => $total_overall_wstge_frst,
            "total_overall_wstge_scnd" => $total_overall_wstge_scnd,
            "p_cvrge_overall_frst" => $p_cvrge_overall_frst,
            "p_cvrge_overall_scnd" => $p_cvrge_overall_scnd,
            "total_c_rate_overall_frst" => $total_c_rate_overall_frst,
            "total_c_rate_overall_scnd" => $total_c_rate_overall_scnd,
            "total_r_unvcted_overall_frst" => $total_r_unvcted_overall_frst,
            "total_r_unvcted_overall_scnd" => $total_r_unvcted_overall_scnd,


        ]);
    }


    public function dataCollapseFacility(Request $request)
    {
        if($request->tricity_id == 'cebu'){
            $request->tricity_id = 63;
        }
        elseif($request->tricity_id == 'mandaue'){
            $request->tricity_id = 80;
        }
        elseif($request->tricity_id == 'lapu'){
            $request->tricity_id = 76;
        }

        $global_elipop_a1 =  \App\Facility::select(DB::raw("sum(COALESCE(a1,0)) as a1"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->a1;
        $global_elipop_a2 =  \App\Facility::select(DB::raw("sum(COALESCE(a2,0)) as a2"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->a2;
        $global_elipop_a3 =  \App\Facility::select(DB::raw("sum(COALESCE(a3,0)) as a3"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->a3;
        $global_elipop_a4 =  \App\Facility::select(DB::raw("sum(COALESCE(a4,0)) as a4"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->a4;
        $global_elipop_a5 =  \App\Facility::select(DB::raw("sum(COALESCE(a5,0)) as a5"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->a5;
        $global_elipop_b1 =  \App\Facility::select(DB::raw("sum(COALESCE(b1,0)) as b1"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->b1;
        $global_elipop_b2 =  \App\Facility::select(DB::raw("sum(COALESCE(b2,0)) as b2"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->b2;
        $global_elipop_b3 =  \App\Facility::select(DB::raw("sum(COALESCE(b3,0)) as b3"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->b3;
        $global_elipop_b4 =  \App\Facility::select(DB::raw("sum(COALESCE(b4,0)) as b4"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->b4;


        if($request->typeof_vaccine == "sinovac")
        {
            $total_epop_a1 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_SINOVAC
            $total_epop_a2 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_SINOVAC
            $total_epop_a3 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_SINOVAC
            $total_epop_a4 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_SINOVAC
            $total_epop_a5 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_SINOVAC
            $total_epop_b1 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_SINOVAC
            $total_epop_b2 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_SINOVAC
            $total_epop_b3 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_SINOVAC
            $total_epop_b4 = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_SINOVAC

            $total_epop = $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 +$total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_SINOVAC (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_SINOVAC (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_SINOVAC

            $total_a1_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->first()->vaccinated_first :0; //A1_SINOVAC
            $total_a2_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->first()->vaccinated_first :0; //A2_SINOVAC
            $total_a3_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->first()->vaccinated_first :0; //A3_SINOVAC
            $total_a4_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->first()->vaccinated_first :0; //A4_SINOVAC
            $total_a5_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->first()->vaccinated_first :0; //A5_SINOVAC
            $total_b1_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->first()->vaccinated_first :0; //B1_SINOVAC
            $total_b2_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->first()->vaccinated_first :0; //B2_SINOVAC
            $total_b3_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->first()->vaccinated_first :0; //B3_SINOVAC
            $total_b4_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->first()->vaccinated_first :0; //B4_SINOVAC


            $total_a1_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a1")->first()->vaccinated_second :0; //A1_SINOVAC 2
            $total_a2_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a2")->first()->vaccinated_second :0; //A2_SINOVAC 2
            $total_a3_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a3")->first()->vaccinated_second :0; //A3_SINOVAC 2
            $total_a4_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a4")->first()->vaccinated_second :0; //A4_SINOVAC 2
            $total_a5_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","a5")->first()->vaccinated_second :0; //A5_SINOVAC 2
            $total_b1_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b1")->first()->vaccinated_second :0; //B1_SINOVAC 2
            $total_b2_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b2")->first()->vaccinated_second :0; //B2_SINOVAC 2
            $total_b3_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b3")->first()->vaccinated_second :0; //B3_SINOVAC 2
            $total_b4_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->where("priority","b4")->first()->vaccinated_second :0; //B4_SINOVAC 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst + $total_b1_frst + $total_b1_frst + $total_b3_frst + $total_b4_frst;
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd + $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd;

            $total_mild_frst =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->mild_first :0; //MILD_SINOVAC
            $total_mild_scnd = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->mild_second :0; //MILD_SINOVAC 2

            $total_srs_frst =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->serious_first :0; //SERIOUS_SINOVAC
            $total_srs_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->serious_second :0; //SERIOUS_SINOVAC 2

            $total_dfrd_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->deferred_first :0; //DEFERRED_SINOVAC
            $total_dfrd_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->deferred_second :0; //DEFERRED_SINOVAC 2

            $total_rfsd_frst =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->refused_first :0; //REFUSED_SINOVAC
            $total_rfsd_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->refused_second :0; //REFUSED_SINOVAC 2

            $total_wstge_frst = $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->wastage_first :0; //WASTAGF_SINOVAC
            $total_wstge_scnd =  $request->typeof_vaccine == "sinovac" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Sinovac")->first()->wastage_second :0; //WASTAGE_SINOVAC 2


            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_SINOVAC
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_SINOVAC 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_SINOVAC
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE SINOVAC 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_SINOVAC
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_SINOVAC 2



            $view = 'vaccine.collapse_facility.sinovac';
        }
        elseif ($request->typeof_vaccine == "astrazeneca")
        {
            $total_epop_a1 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_ASTRAZENECDA
            $total_epop_a2 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_ASTRAZENECDA
            $total_epop_a3 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_ASTRAZENECDA
            $total_epop_a4 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_ASTRAZENECDA
            $total_epop_a5 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_ASTRAZENECDA
            $total_epop_b1 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_ASTRAZENECDA
            $total_epop_b2 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_ASTRAZENECDA
            $total_epop_b3 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_ASTRAZENECDA
            $total_epop_b4 = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_ASTRAZENECDA

            $total_epop = $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 +$total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_ASTRAZENECA (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_ASTRAZENECA (SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_ASTRAZENECA

            $total_a1_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->first()->vaccinated_first :0; //A1_ASTRAZENECA
            $total_a2_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->first()->vaccinated_first :0; //A2_ASTRAZENECA
            $total_a3_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->first()->vaccinated_first :0; //A3_ASTRAZENECA
            $total_a4_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->first()->vaccinated_first :0; //A4_ASTRAZENECA
            $total_a5_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->first()->vaccinated_first :0; //A5_ASTRAZENECA
            $total_b1_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->first()->vaccinated_first :0; //B1_ASTRAZENECA
            $total_b2_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->first()->vaccinated_first :0; //B2_ASTRAZENECA
            $total_b3_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->first()->vaccinated_first :0; //B3_ASTRAZENECA
            $total_b4_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->first()->vaccinated_first :0; //B4_ASTRAZENECA

            $total_a1_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a1")->first()->vaccinated_second :0; //A1_ASTRAZENECA 2
            $total_a2_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a2")->first()->vaccinated_second :0; //A2_ASTRAZENECA 2
            $total_a3_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a3")->first()->vaccinated_second :0; //A3_ASTRAZENECA 2
            $total_a4_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a4")->first()->vaccinated_second :0; //A4_ASTRAZENECA 2
            $total_a5_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","a5")->first()->vaccinated_second :0; //A5_ASTRAZENECA 2
            $total_b1_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b1")->first()->vaccinated_second :0; //B1_ASTRAZENECA 2
            $total_b2_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b2")->first()->vaccinated_second :0; //B2_ASTRAZENECA 2
            $total_b3_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b3")->first()->vaccinated_second :0; //B3_ASTRAZENECA 2
            $total_b4_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->where("priority","b4")->first()->vaccinated_second :0; //B4_ASTRAZENECA 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst + $total_b1_frst + $total_b1_frst + $total_b3_frst + $total_b4_frst;
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd + $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd;

            $total_mild_frst =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->mild_first :0; //MILD_ASTRAZENECA
            $total_mild_scnd = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->mild_second :0; //MILD_ASTRAZENECA 2

            $total_srs_frst =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->serious_first :0; //SERIOUS_ASTRAZENECA
            $total_srs_scnd =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->serious_second :0; //SERIOUS_ASTRAZENECA 2

            $total_dfrd_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->deferred_first :0; //DEFERRED_ASTRAZENECA
            $total_dfrd_scnd =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->deferred_second :0; //DEFERRED_ASTRAZENECA 2

            $total_rfsd_frst =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->refused_first :0; //REFUSED_ASTRAZENECA
            $total_rfsd_scnd =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->refused_second :0; //REFUSED_ASTRAZENECA 2

            $total_wstge_frst = $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->wastage_first :0; //WASTAGF_ASTRAZENECA
            $total_wstge_scnd =  $request->typeof_vaccine == "astrazeneca" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Astrazeneca")->first()->wastage_second :0; //WASTAGE_ASTRAZENECA 2


            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_ASTRAZENECA
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_ASTRAZENECA 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_ASTRAZENECA
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE ASTRAZENECA 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_ASTRAZENECA
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_ASTRAZENECA 2


            $view = 'vaccine.collapse_facility.astrazeneca';
        }
        elseif ($request->typeof_vaccine == "pfizer")
        {

            $total_epop_a1 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_PFIZER
            $total_epop_a2 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_PFIZER
            $total_epop_a3 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_PFIZER
            $total_epop_a4 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_PFIZER
            $total_epop_a5 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_PFIZER
            $total_epop_b1 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_PFIZER
            $total_epop_b2 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_PFIZER
            $total_epop_b3 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_PFIZER
            $total_epop_b4 = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_PFIZER

            $total_epop = $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 +$total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_PFIZER (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_PFIZER(SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_PFIZER

            $total_a1_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->first()->vaccinated_first :0; //A1_PFIZER
            $total_a2_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->first()->vaccinated_first :0; //A2_PFIZER
            $total_a3_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->first()->vaccinated_first :0; //A3_PFIZER
            $total_a4_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->first()->vaccinated_first :0; //A4_PFIZER
            $total_a5_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->first()->vaccinated_first :0; //A5_PFIZER
            $total_b1_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->first()->vaccinated_first :0; //B1_PFIZER
            $total_b2_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->first()->vaccinated_first :0; //B2_PFIZER
            $total_b3_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->first()->vaccinated_first :0; //B3_PFIZER
            $total_b4_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->first()->vaccinated_first :0; //B4_PFIZER

            $total_a1_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a1")->first()->vaccinated_second :0; //A1_PFIZER 2
            $total_a2_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a2")->first()->vaccinated_second :0; //A2_PFIZER 2
            $total_a3_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a3")->first()->vaccinated_second :0; //A3_PFIZER 2
            $total_a4_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a4")->first()->vaccinated_second :0; //A4_PFIZER 2
            $total_a5_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","a5")->first()->vaccinated_second :0; //A5_PFIZER 2
            $total_b1_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b1")->first()->vaccinated_second :0; //B1_PFIZER 2
            $total_b2_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b2")->first()->vaccinated_second :0; //B2_PFIZER 2
            $total_b3_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b3")->first()->vaccinated_second :0; //B3_PFIZER 2
            $total_b4_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->where("priority","b4")->first()->vaccinated_second :0; //B4_PFIZER 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst + $total_b1_frst + $total_b1_frst + $total_b3_frst + $total_b4_frst;
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd + $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd;

            $total_mild_frst =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->mild_first :0; //MILD_PFIZER
            $total_mild_scnd = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->mild_second :0; //MILD_PFIZER 2

            $total_srs_frst =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->serious_first :0; //SERIOUS_PFIZER
            $total_srs_scnd =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->serious_second :0; //SERIOUS_PFIZER 2

            $total_dfrd_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->deferred_first :0; //DEFERRED_PFIZER
            $total_dfrd_scnd =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->deferred_second :0; //DEFERRED_PFIZER 2

            $total_rfsd_frst =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->refused_first :0; //REFUSED_PFIZER
            $total_rfsd_scnd =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->refused_second :0; //REFUSED_PFIZER 2

            $total_wstge_frst = $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->wastage_first :0; //WASTAGF_PFIZER
            $total_wstge_scnd =  $request->typeof_vaccine == "pfizer" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Pfizer")->first()->wastage_second :0; //WASTAGE_PFIZER 2

            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_PFIZER
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_PFIZER 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_PFIZER
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE PFIZER 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_PFIZER
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_PFIZER 2


            $view = 'vaccine.collapse_facility.pfizer';
        }
        elseif ($request->typeof_vaccine == "sputnikv")
        {

            $total_epop_a1 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_SPUTNIKV
            $total_epop_a2 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_SPUTNIKV
            $total_epop_a3 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_SPUTNIKV
            $total_epop_a4 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_SPUTNIKV
            $total_epop_a5 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_SPUTNIKV
            $total_epop_b1 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_SPUTNIKV
            $total_epop_b2 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_SPUTNIKV
            $total_epop_b3 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_SPUTNIKV
            $total_epop_b4 = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_SPUTNIKV

            $total_epop = $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 +$total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_SPUTNIKV(FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_SPUTNIKV((SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_SPUTNIKV

            $total_a1_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->first()->vaccinated_first :0; //A1_SPUTNIKV
            $total_a2_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->first()->vaccinated_first :0; //A2_SPUTNIKV
            $total_a3_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->first()->vaccinated_first :0; //A3_SPUTNIKV
            $total_a4_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->first()->vaccinated_first :0; //A4_SPUTNIKV
            $total_a5_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->first()->vaccinated_first :0; //A5_SPUTNIKV
            $total_b1_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->first()->vaccinated_first :0; //B1_SPUTNIKV
            $total_b2_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->first()->vaccinated_first :0; //B2_SPUTNIKV
            $total_b3_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->first()->vaccinated_first :0; //B3_SPUTNIKV
            $total_b4_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->first()->vaccinated_first :0; //B4_SPUTNIKV

            $total_a1_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a1")->first()->vaccinated_second :0; //A1_SPUTNIKV 2
            $total_a2_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a2")->first()->vaccinated_second :0; //A2_SPUTNIKV 2
            $total_a3_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a3")->first()->vaccinated_second :0; //A3_SPUTNIKV 2
            $total_a4_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a4")->first()->vaccinated_second :0; //A4_SPUTNIKV 2
            $total_a5_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","a5")->first()->vaccinated_second :0; //A5_SPUTNIKV 2
            $total_b1_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b1")->first()->vaccinated_second :0; //B1_SPUTNIKV 2
            $total_b2_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b2")->first()->vaccinated_second :0; //B2_SPUTNIKV 2
            $total_b3_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b3")->first()->vaccinated_second :0; //B3_SPUTNIKV 2
            $total_b4_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->where("priority","b4")->first()->vaccinated_second :0; //B4_SPUTNIKV 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst + $total_b1_frst + $total_b1_frst + $total_b3_frst + $total_b4_frst;
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd + $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd;

            $total_mild_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->mild_first :0; //MILD_SPUTNIKV
            $total_mild_scnd = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->mild_second :0; //MILD_SPUTNIKV 2

            $total_srs_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->serious_first :0; //SERIOUS_SPUTNIKV
            $total_srs_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->serious_second :0; //SERIOUS_SPUTNIKV 2

            $total_dfrd_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->deferred_first :0; //DEFERRED_SPUTNIKV
            $total_dfrd_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->deferred_second :0; //DEFERRED_SPUTNIKV 2

            $total_rfsd_frst =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->refused_first :0; //REFUSED_SPUTNIKV
            $total_rfsd_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->refused_second :0; //REFUSED_SPUTNIKV 2

            $total_wstge_frst = $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->wastage_first :0; //WASTAGF_SPUTNIKV
            $total_wstge_scnd =  $request->typeof_vaccine == "sputnikv" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","SputnikV")->first()->wastage_second :0; //WASTAGE_SPUTNIKV 2

            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_SPUTNIKV
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_SPUTNIKV 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_SPUTNIKV
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE SPUTNIKV 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_SPUTNIKV
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_SPUTNIKV 2


            $view = 'vaccine.collapse_facility.sputnikv';
        }
        elseif ($request->typeof_vaccine == "moderna")
        {

            $total_epop_a1 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_MODERNA
            $total_epop_a2 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_MODERNA
            $total_epop_a3 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_MODERNA
            $total_epop_a4 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_MODERNA
            $total_epop_a5 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_MODERNA
            $total_epop_b1 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_MODERNA
            $total_epop_b2 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_MODERNA
            $total_epop_b3 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_MODERNA
            $total_epop_b4 = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_MODERNA

            $total_epop = $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 +$total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_MODERNA (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_MODERNA((SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_MODERNA

            $total_a1_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->first()->vaccinated_first :0; //A1_MODERNA
            $total_a2_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->first()->vaccinated_first :0; //A2_MODERNA
            $total_a3_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->first()->vaccinated_first :0; //A3_MODERNA
            $total_a4_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->first()->vaccinated_first :0; //A4_MODERNA
            $total_a5_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->first()->vaccinated_first :0; //A5_MODERNA
            $total_b1_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->first()->vaccinated_first :0; //B1_MODERNA
            $total_b2_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->first()->vaccinated_first :0; //B2_MODERNA
            $total_b3_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->first()->vaccinated_first :0; //B3_MODERNA
            $total_b4_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->first()->vaccinated_first :0; //B4_MODERNA

            $total_a1_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a1")->first()->vaccinated_second :0; //A1_MODERNA 2
            $total_a2_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a2")->first()->vaccinated_second :0; //A2_MODERNA 2
            $total_a3_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a3")->first()->vaccinated_second :0; //A3_MODERNA 2
            $total_a4_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a4")->first()->vaccinated_second :0; //A4_MODERNA 2
            $total_a5_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","a5")->first()->vaccinated_second :0; //A5_MODERNA 2
            $total_b1_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b1")->first()->vaccinated_second :0; //B1_MODERNA 2
            $total_b2_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b2")->first()->vaccinated_second :0; //B2_MODERNA 2
            $total_b3_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b3")->first()->vaccinated_second :0; //B3_MODERNA 2
            $total_b4_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->where("priority","b4")->first()->vaccinated_second :0; //B4_MODERNA 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst + $total_b1_frst + $total_b1_frst + $total_b3_frst + $total_b4_frst;
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd + $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd;


            $total_mild_frst =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->mild_first :0; //MILD_MODERNA
            $total_mild_scnd = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->mild_second :0; //MILD_MODERNA 2

            $total_srs_frst =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->serious_first :0; //SERIOUS_MODERNA
            $total_srs_scnd =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->serious_second :0; //SERIOUS_MODERNA 2

            $total_dfrd_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->deferred_first :0; //DEFERRED_MODERNA
            $total_dfrd_scnd =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->deferred_second :0; //DEFERRED_MODERNA 2

            $total_rfsd_frst =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->refused_first :0; //REFUSED_MODERNA
            $total_rfsd_scnd =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->refused_second :0; //REFUSED_MODERNA 2

            $total_wstge_frst = $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->wastage_first :0; //WASTAGF_MODERNA
            $total_wstge_scnd =  $request->typeof_vaccine == "moderna" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Moderna")->first()->wastage_second :0; //WASTAGE_MODERNA 2

            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_MODERNA
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_MODERNA 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_MODERNA
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE MODERNA 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_MODERNA
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_MODERNA2

            $view = 'vaccine.collapse_facility.moderna';
        }
        elseif ($request->typeof_vaccine == "johnson")
        {

            $total_epop_a1 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a1 :0; //E_POP_A1_JOHNSONS
            $total_epop_a2 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a2 :0; //E_POP_A2_JOHNSONS
            $total_epop_a3 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a3 :0; //E_POP_A3_JOHNSONS
            $total_epop_a4 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a4 :0; //E_POP_A4_JOHNSONS
            $total_epop_a5 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_a5 :0; //E_POP_A5_JOHNSONS
            $total_epop_b1 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b1 :0; //E_POP_B1_JOHNSONS
            $total_epop_b2 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b2 :0; //E_POP_B2_JOHNSONS
            $total_epop_b3 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b3 :0; //E_POP_B3_JOHNSONS
            $total_epop_b4 = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $global_elipop_b4 :0; //E_POP_B4_JOHNSONS

            $total_epop = $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 +$total_epop_b3 + $total_epop_b4;

            $total_vallocated_frst  = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? $request->allocated_first : 0; //VACCINE ALLOCATED_JOHNSON (FD)
            $total_vallocated_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  $request->allocated_second :0; //VACCINE ALLOCATED_JOHNSON((SD)
            $total_vallocated =  $total_vallocated_frst  + $total_vallocated_scnd;  //TOTAL VACCINE ALLOCATED_JOHNSON

            $total_a1_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->first()->vaccinated_first :0; //A1_JOHNSON
            $total_a2_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->first()->vaccinated_first :0; //A2_JOHNSON
            $total_a3_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->first()->vaccinated_first :0; //A3_JOHNSON
            $total_a4_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->first()->vaccinated_first :0; //A4_JOHNSON
            $total_a5_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->first()->vaccinated_first :0; //A5_JOHNSON
            $total_b1_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->first()->vaccinated_first :0; //B1_JOHNSON
            $total_b2_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->first()->vaccinated_first :0; //B2_JOHNSON
            $total_b3_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->first()->vaccinated_first :0; //B3_JOHNSON
            $total_b4_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as vaccinated_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->first()->vaccinated_first :0; //B4_JOHNSON

            $total_a1_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a1")->first()->vaccinated_second :0; //A1_JOHNSON 2
            $total_a2_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a2")->first()->vaccinated_second :0; //A2_JOHNSON 2
            $total_a3_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a3")->first()->vaccinated_second :0; //A3_JOHNSON 2
            $total_a4_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a4")->first()->vaccinated_second :0; //A4_JOHNSON 2
            $total_a5_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","a5")->first()->vaccinated_second :0; //A5_JOHNSON 2
            $total_b1_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b1")->first()->vaccinated_second :0; //B1_JOHNSON 2
            $total_b2_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b2")->first()->vaccinated_second :0; //B2_JOHNSON 2
            $total_b3_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b3")->first()->vaccinated_second :0; //B3_JOHNSON 2
            $total_b4_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as vaccinated_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->where("priority","b4")->first()->vaccinated_second :0; //B4_JOHNSON 2

            $total_vcted_frst = $total_a1_frst + $total_a2_frst + $total_a3_frst + $total_a4_frst + $total_a5_frst + $total_b1_frst + $total_b1_frst + $total_b3_frst + $total_b4_frst;
            $total_vcted_scnd = $total_a1_scnd + $total_a2_scnd + $total_a3_scnd + $total_a4_scnd + $total_a5_scnd + $total_b1_scnd + $total_b2_scnd + $total_b3_scnd + $total_b4_scnd;

            $total_mild_frst =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as mild_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->mild_first :0; //MILD_JOHNSON
            $total_mild_scnd = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as mild_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->mild_second :0; //MILD_JOHNSON 2

            $total_srs_frst =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as serious_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->serious_first :0; //SERIOUS_JOHNSON
            $total_srs_scnd =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as serious_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->serious_second :0; //SERIOUS_JOHNSON 2

            $total_dfrd_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as deferred_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->deferred_first :0; //DEFERRED_JOHNSON
            $total_dfrd_scnd =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as deferred_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->deferred_second :0; //DEFERRED_JOHNSON 2

            $total_rfsd_frst =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as refused_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->refused_first :0; //REFUSED_JOHNSON
            $total_rfsd_scnd =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as refused_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->refused_second :0; //REFUSED_JOHNSON 2

            $total_wstge_frst = $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ?  \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as wastage_first"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->wastage_first :0; //WASTAGF_JOHNSON
            $total_wstge_scnd =  $request->typeof_vaccine == "johnson" || empty($request->typeof_vaccine_filter) ? \App\VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as wastage_second"))->where("facility_id",$request->facility_id)->where("typeof_vaccine","Johnson")->first()->wastage_second :0; //WASTAGE_JOHNSON 2


            $p_cvrge_frst = $total_vcted_frst / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON
            $p_cvrge_scnd = $total_vcted_scnd / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON 2

            $total_c_rate_frst = $total_vcted_frst / $total_vallocated_frst * 100; //CONSUMPTION RATE_JOHNSON
            $total_c_rate_scnd = $total_vcted_scnd / $total_vallocated_scnd * 100; //CONSUMPTION RATE JOHNSON 2

            $total_r_unvcted_frst = $total_epop - $total_vcted_frst - $total_rfsd_frst; //REMAINING UNVACCINATED_JOHNSON
            $total_r_unvcted_scnd = $total_epop - $total_vcted_scnd - $total_rfsd_scnd; //REMAINING UNVACCINATED_JOHNSON2

            $view = 'vaccine.collapse_facility.johnson';
        }

        elseif ($request->typeof_vaccine == "total") {

            $total_epop_a1 = $global_elipop_a1;
            $total_epop_a2 = $global_elipop_a2;
            $total_epop_a3 = $global_elipop_a3;
            $total_epop_a4 = $global_elipop_a4;
            $total_epop_a5 = $global_elipop_a5;
            $total_epop_b1 = $global_elipop_b1;
            $total_epop_b2 = $global_elipop_b2;
            $total_epop_b3 = $global_elipop_b3;
            $total_epop_b4 = $global_elipop_b4;

            $total_epop =  $total_epop_a1 + $total_epop_a2 + $total_epop_a3 + $total_epop_a4 + $total_epop_a5 + $total_epop_b1 + $total_epop_b2 + $total_epop_b3 + $total_epop_b4;

            $total_vallocated_overall_frst = Facility::select(DB::raw("sum(COALESCE(sinovac_allocated_first,0)+COALESCE(astrazeneca_allocated_first,0)+COALESCE(pfizer_allocated_first,0)+COALESCE(sputnikv_allocated_first,0)+COALESCE(moderna_allocated_first,0)+COALESCE(johnson_allocated_first,0)) as total_vallocated_overall_frst"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->total_vallocated_overall_frst;  //VACCINE ALLOCATED_MODERNA (FD)
            $total_vallocated_overall_scnd = Facility::select(DB::raw("sum(COALESCE(sinovac_allocated_second,0)+COALESCE(astrazeneca_allocated_second,0)+COALESCE(pfizer_allocated_second,0)+COALESCE(sputnikv_allocated_second,0)+COALESCE(moderna_allocated_second,0)+COALESCE(johnson_allocated_second,0)) as total_vallocated_overall_scnd"))->where("tricity_id",$request->tricity_id)->where("id",$request->facility_id)->first()->total_vallocated_overall_scnd;  //VACCINE ALLOCATED_MODERNA (SD)

            $total_vallocated_overall =  $total_vallocated_overall_frst + $total_vallocated_overall_scnd ;

            $total_overall_a1_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a1_frst"))->where("facility_id",$request->facility_id)->where("priority","a1")->first()->total_overall_a1_frst; //A1_OVERALL
            $total_overall_a2_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a2_frst"))->where("facility_id",$request->facility_id)->where("priority","a2")->first()->total_overall_a2_frst; //A2_OVERALL
            $total_overall_a3_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a3_frst"))->where("facility_id",$request->facility_id)->where("priority","a3")->first()->total_overall_a3_frst; //A3_OVERALL
            $total_overall_a4_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a4_frst"))->where("facility_id",$request->facility_id)->where("priority","a4")->first()->total_overall_a4_frst; //A4_OVERALL
            $total_overall_a5_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_a5_frst"))->where("facility_id",$request->facility_id)->where("priority","a5")->first()->total_overall_a5_frst; //A5_OVERALL
            $total_overall_b1_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b1_frst"))->where("facility_id",$request->facility_id)->where("priority","b1")->first()->total_overall_b1_frst; //B1_OVERALL
            $total_overall_b2_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b2_frst"))->where("facility_id",$request->facility_id)->where("priority","b2")->first()->total_overall_b2_frst; //B2_OVERALL
            $total_overall_b3_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b3_frst"))->where("facility_id",$request->facility_id)->where("priority","b3")->first()->total_overall_b3_frst; //B3_OVERALL
            $total_overall_b4_frst = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_first,0)) as total_overall_b4_frst"))->where("facility_id",$request->facility_id)->where("priority","b4")->first()->total_overall_b4_frst; //B4_OVERALL

            $total_overall_a1_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a1_scnd"))->where("facility_id",$request->facility_id)->where("priority","a1")->first()->total_overall_a1_scnd; //A1_OVERALL
            $total_overall_a2_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a2_scnd"))->where("facility_id",$request->facility_id)->where("priority","a2")->first()->total_overall_a2_scnd; //A2_OVERALL
            $total_overall_a3_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a3_scnd"))->where("facility_id",$request->facility_id)->where("priority","a3")->first()->total_overall_a3_scnd; //A3_OVERALL
            $total_overall_a4_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a4_scnd"))->where("facility_id",$request->facility_id)->where("priority","a4")->first()->total_overall_a4_scnd; //A4_OVERALL
            $total_overall_a5_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_a5_scnd"))->where("facility_id",$request->facility_id)->where("priority","a5")->first()->total_overall_a5_scnd; //A5_OVERALL
            $total_overall_b1_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b1_scnd"))->where("facility_id",$request->facility_id)->where("priority","b1")->first()->total_overall_b1_scnd; //B1_OVERALL
            $total_overall_b2_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b2_scnd"))->where("facility_id",$request->facility_id)->where("priority","b2")->first()->total_overall_b2_scnd; //B2_OVERALL
            $total_overall_b3_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b3_scnd"))->where("facility_id",$request->facility_id)->where("priority","b3")->first()->total_overall_b3_scnd; //B3_OVERALL
            $total_overall_b4_scnd = VaccineAccomplished::select(\DB::raw("SUM(COALESCE(vaccinated_second,0)) as total_overall_b4_scnd"))->where("facility_id",$request->facility_id)->where("priority","b4")->first()->total_overall_b4_scnd; //B4_OVERALL

            $total_vcted_overall_frst = $total_overall_a1_frst + $total_overall_a2_frst + $total_overall_a3_frst + $total_overall_a4_frst + $total_overall_a5_frst +
                $total_overall_b1_frst + $total_overall_b2_frst + $total_overall_b3_frst + $total_overall_b4_frst ;
            $total_vcted_overall_scnd = $total_overall_a1_scnd + $total_overall_a2_scnd + $total_overall_a3_scnd + $total_overall_a4_scnd + $total_overall_a5_scnd +
                $total_overall_b1_scnd + $total_overall_b2_scnd + $total_overall_b3_scnd + $total_overall_b4_scnd ;

            $total_overall_mild_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_first,0)) as total_overall_mild_frst"))->where("facility_id",$request->facility_id)->first()->total_overall_mild_frst; //MILD_FIRST
            $total_overall_mild_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(mild_second,0)) as total_overall_mild_scnd"))->where("facility_id",$request->facility_id)->first()->total_overall_mild_scnd; //MILD_SECOND

            $total_overall_srs_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_first,0)) as total_overall_srs_frst"))->where("facility_id",$request->facility_id)->first()->total_overall_srs_frst; //SERIOUS FIRST
            $total_overall_srs_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(serious_second,0)) as total_overall_srs_scnd"))->where("facility_id",$request->facility_id)->first()->total_overall_srs_scnd; //SERIOUS SECOND

            $total_overall_dfrd_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_first,0)) as total_overall_dfrd_frst"))->where("facility_id",$request->facility_id)->first()->total_overall_dfrd_frst; //DEFERRED FIRST
            $total_overall_dfrd_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(deferred_second,0)) as total_overall_dfrd_scnd"))->where("facility_id",$request->facility_id)->first()->total_overall_dfrd_scnd; //DEFERRED SECOND

            $total_overall_rfsd_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_first,0)) as total_overall_rfsd_frst"))->where("facility_id",$request->facility_id)->first()->total_overall_rfsd_frst; //REFUSED FIRST
            $total_overall_rfsd_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(refused_second,0)) as total_overall_rfsd_scnd"))->where("facility_id",$request->facility_id)->first()->total_overall_rfsd_scnd; //REFUSED SECOND

            $total_overall_wstge_frst =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_first,0)) as total_overall_wstge_frst"))->where("facility_id",$request->facility_id)->first()->total_overall_wstge_frst; //WASTAGE FIRST
            $total_overall_wstge_scnd =  VaccineAccomplished::select(\DB::raw("SUM(COALESCE(wastage_second,0)) as total_overall_wstge_scnd"))->where("facility_id",$request->facility_id)->first()->total_overall_wstge_scnd; //WASTAGE SECOND

            $p_cvrge_overall_frst = $total_vcted_overall_frst / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON
            $p_cvrge_overall_scnd = $total_vcted_overall_scnd / $total_epop * 100; //PERCENT_COVERAGE_JOHNSON 2

            $total_c_rate_overall_frst = $total_vcted_overall_frst / $total_vallocated_overall_frst * 100; //CONSUMPTION RATE JONHSON
            $total_c_rate_overall_scnd = $total_vcted_overall_scnd / $total_vallocated_overall_scnd * 100; //CONSUMPTION_RATE_JOHNSON 2

            $total_r_unvcted_overall_frst = $total_epop - $total_vcted_overall_frst - $total_overall_rfsd_frst; //REMAINUNG_UNVACCNATED_JOHNSON
            $total_r_unvcted_overall_scnd = $total_epop - $total_vcted_overall_scnd - $total_overall_rfsd_scnd; //REMAINUNG_UNVACCIANTED_JOHNSON 2


            $view = 'vaccine.collapse_facility.total';
        }

        $data = [
            "facility_id" => $request->facility_id,
            "tricity_id" => $request->tricity_id,
            "total_epop_a1" => $total_epop_a1,
            "total_epop_a2" => $total_epop_a2,
            "total_epop_a3" => $total_epop_a3,
            "total_epop_a4" => $total_epop_a4,
            "total_epop_a5" => $total_epop_a5,
            "total_epop_b1" => $total_epop_b1,
            "total_epop_b2" => $total_epop_b2,
            "total_epop_b3" => $total_epop_b3,
            "total_epop_b4" => $total_epop_b4,
            "total_epop" => $total_epop,
            "allocated_first" => $total_vallocated_frst,
            "allocated_second" => $total_vallocated_scnd,
            "total_vallocated"=> $total_vallocated,

            "total_a1_frst" => $total_a1_frst,
            "total_a2_frst" => $total_a2_frst,
            "total_a3_frst" => $total_a3_frst,
            "total_a4_frst" => $total_a4_frst,
            "total_a5_frst" => $total_a5_frst,
            "total_b1_frst" => $total_b1_frst,
            "total_b2_frst" => $total_b2_frst,
            "total_b3_frst" => $total_b3_frst,
            "total_b4_frst" => $total_b4_frst,
            "total_vcted_frst" => $total_vcted_frst,
            "total_mild_frst" => $total_mild_frst,
            "total_srs_frst" => $total_srs_frst,
            "total_dfrd_frst" => $total_dfrd_frst,
            "total_rfsd_frst" => $total_rfsd_frst,
            "total_wstge_frst" => $total_wstge_frst,
            "p_cvrge_frst" => $p_cvrge_frst,
            "total_c_rate_frst" => $total_c_rate_frst,
            "total_r_unvcted_frst" => $total_r_unvcted_frst,

            "total_a1_scnd" => $total_a1_scnd,
            "total_a2_scnd" => $total_a2_scnd,
            "total_a3_scnd" => $total_a3_scnd,
            "total_a4_scnd" => $total_a4_scnd,
            "total_a5_scnd" => $total_a5_scnd,
            "total_b1_scnd" => $total_b1_scnd,
            "total_b2_scnd" => $total_b2_scnd,
            "total_b3_scnd" => $total_b3_scnd,
            "total_b4_scnd" => $total_b4_scnd,
            "total_vcted_scnd" => $total_vcted_scnd,
            "total_mild_scnd" => $total_mild_scnd,
            "total_srs_scnd" => $total_srs_scnd,
            "total_dfrd_scnd" => $total_dfrd_scnd,
            "total_rfsd_scnd" => $total_rfsd_scnd,
            "total_wstge_scnd" => $total_wstge_scnd,
            "p_cvrge_scnd" => $p_cvrge_scnd,
            "total_c_rate_scnd" => $total_c_rate_scnd,
            "total_r_unvcted_scnd" => $total_r_unvcted_scnd,

            //TOTAL OVER ALL
            "total_vallocated_overall_frst" => $total_vallocated_overall_frst,
            "total_vallocated_overall_scnd" => $total_vallocated_overall_scnd,
            "total_vallocated_overall" => $total_vallocated_overall,
            "total_overall_a1_frst" => $total_overall_a1_frst,
            "total_overall_a2_frst" => $total_overall_a2_frst,
            "total_overall_a3_frst" => $total_overall_a3_frst,
            "total_overall_a4_frst" => $total_overall_a4_frst,
            "total_overall_a5_frst" => $total_overall_a5_frst,
            "total_overall_b1_frst" => $total_overall_b1_frst,
            "total_overall_b2_frst" => $total_overall_b2_frst,
            "total_overall_b3_frst" => $total_overall_b3_frst,
            "total_overall_b4_frst" => $total_overall_b4_frst,
            "total_overall_a1_scnd" => $total_overall_a1_scnd,
            "total_overall_a2_scnd" => $total_overall_a2_scnd,
            "total_overall_a3_scnd" => $total_overall_a3_scnd,
            "total_overall_a4_scnd" => $total_overall_a4_scnd,
            "total_overall_a5_scnd" => $total_overall_a5_scnd,
            "total_overall_b1_scnd" => $total_overall_b1_scnd,
            "total_overall_b2_scnd" => $total_overall_b2_scnd,
            "total_overall_b3_scnd" => $total_overall_b3_scnd,
            "total_overall_b4_scnd" => $total_overall_b4_scnd,
            "total_vcted_overall_frst" => $total_vcted_overall_frst,
            "total_vcted_overall_scnd" => $total_vcted_overall_scnd,
            "total_overall_mild_frst" => $total_overall_mild_frst,
            "total_overall_mild_scnd" => $total_overall_mild_scnd,
            "total_overall_srs_frst" => $total_overall_srs_frst,
            "total_overall_srs_scnd" => $total_overall_srs_scnd,
            "total_overall_dfrd_frst" => $total_overall_dfrd_frst,
            "total_overall_dfrd_scnd" => $total_overall_dfrd_scnd,
            "total_overall_rfsd_frst" => $total_overall_rfsd_frst,
            "total_overall_rfsd_scnd" => $total_overall_rfsd_scnd,
            "total_overall_wstge_frst" => $total_overall_wstge_frst,
            "total_overall_wstge_scnd" => $total_overall_wstge_scnd,
            "p_cvrge_overall_frst" => $p_cvrge_overall_frst,
            "p_cvrge_overall_scnd" => $p_cvrge_overall_scnd,
            "total_c_rate_overall_frst" => $total_c_rate_overall_frst,
            "total_c_rate_overall_scnd" => $total_c_rate_overall_scnd,
            "total_r_unvcted_overall_frst" => $total_r_unvcted_overall_frst,
            "total_r_unvcted_overall_scnd" => $total_r_unvcted_overall_scnd,
        ];



        if($request->facility_content == "true")
            return $data;


        return view($view,$data);
    }






    public function vaccineSummaryReport()
    {
        $this->setPriority("a1");
        return view('vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }

    public function vaccineTab5Report()
    {
        $this->setPriority("a2");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }

    public function vaccineTab6Report()
    {
        $this->setPriority("a3");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }

    public function vaccineTab7Report()
    {
        $this->setPriority("a4");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }

    public function vaccineTab8Report()
    {
        $this->setPriority("a5");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }
    public function vaccineTab9Report()
    {
        $this->setPriority("b1");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }
    public function vaccineTab10Report()
    {
        $this->setPriority("b2");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }
    public function vaccineTab11Report()
    {
        $this->setPriority("b3");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }
    public function vaccineTab12Report()
    {
        $this->setPriority("b4");
        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }


    public function vaccineTab13Report()
    {
        $this->setPriority("a1");
        $total_elipop_region = $this->total_elipop_region;
        $eli_pop_bohol = $this->eli_pop_bohol;
        $eli_pop_cebu = $this->eli_pop_cebu;
        $eli_pop_negros = $this->eli_pop_negros;
        $eli_pop_siquijor = $this->eli_pop_siquijor;
        $eli_pop_cebu_facility = $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility = $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility = $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose = $this->region_sinovac_first_dose;
        $region_sinovac_second_dose = $this->region_sinovac_second_dose;
        $region_astra_first_dose = $this->region_astra_first_dose;
        $region_astra_second_dose = $this->region_astra_second_dose;
        $region_pfizer_first_dose = $this->region_pfizer_first_dose;
        $region_pfizer_second_dose = $this->region_pfizer_second_dose;
        $region_sputnikv_first_dose = $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose = $this->region_sputnikv_second_dose;
        $region_moderna_first_dose = $this->region_moderna_first_dose;
        $region_moderna_second_dose = $this->region_moderna_second_dose;
        $region_johnson_first_dose = $this->region_johnson_first_dose;
        $region_johnson_second_dose = $this->region_johnson_second_dose;


        //VACCINATED SINOVAC A1
        $vcted_sinovac_bohol_first = $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second = $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first = $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second = $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first = $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second = $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first = $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second = $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first = $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second = $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first = $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second = $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first = $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second = $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA A1
        $vcted_astra_bohol_first = $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second = $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first = $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second = $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first = $this->vcted_astra_negros_first;
        $vcted_astra_negros_second = $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first = $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second = $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first = $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second = $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first = $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second = $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first = $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second = $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER A1
        $vcted_pfizer_bohol_first = $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second = $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first = $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second = $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first = $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second = $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first = $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second = $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first = $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second = $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first = $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second = $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first = $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second = $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV A1
        $vcted_sputnikv_bohol_first = $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second = $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first = $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second = $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first = $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second = $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first = $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second = $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first = $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second = $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first = $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second = $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first = $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second = $this->vcted_sputnikv_lapu_facility_second;

        //VACCINATED MODERNA A1
        $vcted_moderna_bohol_first = $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second = $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first = $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second = $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first = $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second = $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first = $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second = $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first = $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second = $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first = $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second = $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first = $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second = $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON A1
        $vcted_johnson_bohol_first = $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second = $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first = $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second = $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first = $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second = $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first = $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second = $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first = $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second = $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first = $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second = $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first = $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second = $this->vcted_johnson_lapu_facility_second;



        //TOTAL REFUSED FIRST A1
        $total_refusal_first = $this->total_refusal_first;
        $refused_first_bohol = $this->refused_first_bohol;
        $refused_first_cebu = $this->refused_first_cebu;
        $refused_first_negros = $this->refused_first_negros;
        $refused_first_siquijor = $this->refused_first_siquijor;
        $refused_cebu_facility_first = $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first = $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first = $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND A1
        $total_refusal_second = $this->total_refusal_second;
        $refused_second_bohol = $this->refused_second_bohol;
        $refused_second_cebu = $this->refused_second_cebu;
        $refused_second_negros = $this->refused_second_negros;
        $refused_second_siquijor = $this->refused_second_siquijor;
        $refused_cebu_facility_second = $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second = $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second = $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST A1
        $total_deferred_first = $this->total_deferred_first;
        $deferred_first_bohol = $this->deferred_first_bohol;
        $deferred_first_cebu = $this->deferred_first_cebu;
        $deferred_first_negros = $this->deferred_first_negros;
        $deferred_first_siquijor = $this->deferred_first_siquijor;
        $deferred_cebu_facility_first = $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first = $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first = $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND A1
        $total_deferred_second = $this->total_deferred_second;
        $deferred_second_bohol = $this->deferred_second_bohol;
        $deferred_second_cebu = $this->deferred_second_cebu;
        $deferred_second_negros = $this->deferred_second_negros;
        $deferred_second_siquijor = $this->deferred_second_siquijor;
        $deferred_cebu_facility_second = $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second = $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second = $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE
        $wastage_sinovac_first = $this->wastage_sinovac_first;
        $wastage_astra_first = $this->wastage_astra_first;
        $wastage_pfizer_first = $this->wastage_pfizer_first;
        $wastage_sputnikv_first = $this->wastage_sputnikv_first;
        $wastage_moderna_first = $this->wastage_moderna_first;
        $wastage_johnson_first = $this->wastage_johnson_first;


        //WASTAGE SINOVAC A1
        $wastage_sinovac_bohol_first = $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first = $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first = $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first = $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first = $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first = $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first = $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA A1
        $wastage_astra_bohol_first = $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first = $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first = $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first = $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first = $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first = $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first = $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER A1
        $wastage_pfizer_bohol_first = $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first = $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first = $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first = $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first = $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first = $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first = $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV A1
        $wastage_sputnikv_bohol_first = $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first = $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first = $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first = $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first = $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first = $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first = $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE MODERNA A1
        $wastage_moderna_bohol_first = $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first = $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first = $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first = $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first = $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first = $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first = $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON A1
        $wastage_johnson_bohol_first = $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first = $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first = $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first = $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first = $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first = $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first = $this->wastage_johnson_lapu_facility_first;



        $this->setPriority("a2");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC A2
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA A2
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER A2
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV A2
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA A2
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON A2
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;



        //TOTAL REFUSED FIRST A2
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND A2
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_cebu_facility_second;
        $refused_lapu_facility_second += $this->refused_cebu_facility_second;

        //TOTAL DEFERRED FIRST A2
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND A2
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE A2
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC A2
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA A2
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER A2
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV A2
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE MODERNA A2
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON A2
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;


        $this->setPriority("a3");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC A3
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA A3
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER A3
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV A3
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA A3
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON A3
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;


        //TOTAL REFUSED SECOND A3
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST A3
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND A3
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE A3
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;


        //WASTAGE SINOVAC A3
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA A3
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER A3
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV A3
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE MODERNA A3
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON A3
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;

        $this->setPriority("a4");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC A4
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA A4
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER A4
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;


        //VACCINATED SPUTNIKV A4
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA A4
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON A4
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;



        //TOTAL REFUSED FIRST A4
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND A4
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST A4
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND A4
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE A4
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC A4
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA A4
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER A4
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV A4
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE MODERNA A4
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON A4
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;

        $this->setPriority("a5");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC A5
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA A5
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER A5
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV A5
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA A5
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON A5
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;



        //TOTAL REFUSED FIRST A5
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND A5
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST A5
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND A5
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE A5
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC A5
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA A5
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE SPUTNIKV A5
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE PFIZER A5
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE MODERNA A5
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON A5
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;

        $this->setPriority("b1");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC B1
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA B1
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER B1
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV B1
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA A5
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON A5
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;



        //TOTAL REFUSED FIRST B1
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND B1
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST B1
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND B1
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE B1
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC B1
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA B1
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER B1
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV B1
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;


        //WASTAGE MODERNA B1
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON B1
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;


        $this->setPriority("b2");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC B2
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA B2
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER B2
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV B2
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA B2
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON B2
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;


        //TOTAL REFUSED FIRST B2
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND B2
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST B2
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND B2
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE B2
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC B2
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA B2
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE SPUTNIKV B2
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE PFIZER B2
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE MODERNA B2
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON B2
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;


        $this->setPriority("b3");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC B3
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA B3
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER B3
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV B3
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA B3
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON B3
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;



        //TOTAL REFUSED FIRST B3
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND B3
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST B3
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND B3
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE B3
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC B3
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA B3
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER B3
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV B3
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE MODERNA B3
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON B3
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;


        $this->setPriority("b4");
        $total_elipop_region += $this->total_elipop_region;
        $eli_pop_cebu += $this->eli_pop_cebu;
        $eli_pop_bohol += $this->eli_pop_bohol;
        $eli_pop_negros += $this->eli_pop_negros;
        $eli_pop_siquijor += $this->eli_pop_siquijor;
        $eli_pop_cebu_facility += $this->eli_pop_cebu_facility;
        $eli_pop_mandaue_facility += $this->eli_pop_mandaue_facility;
        $eli_pop_lapu_facility += $this->eli_pop_lapu_facility;
        $region_sinovac_first_dose += $this->region_sinovac_first_dose;
        $region_sinovac_second_dose += $this->region_sinovac_second_dose;
        $region_astra_first_dose += $this->region_astra_first_dose;
        $region_astra_second_dose += $this->region_astra_second_dose;
        $region_sputnikv_first_dose += $this->region_sputnikv_first_dose;
        $region_sputnikv_second_dose += $this->region_sputnikv_second_dose;
        $region_pfizer_first_dose += $this->region_pfizer_first_dose;
        $region_pfizer_second_dose += $this->region_pfizer_second_dose;

        //VACCINATED SINOVAC B4
        $vcted_sinovac_bohol_first += $this->vcted_sinovac_bohol_first;
        $vcted_sinovac_bohol_second += $this->vcted_sinovac_bohol_second;
        $vcted_sinovac_cebu_first += $this->vcted_sinovac_cebu_first;
        $vcted_sinovac_cebu_second += $this->vcted_sinovac_cebu_second;
        $vcted_sinovac_negros_first += $this->vcted_sinovac_negros_first;
        $vcted_sinovac_negros_second += $this->vcted_sinovac_negros_second;
        $vcted_sinovac_siquijor_first += $this->vcted_sinovac_siquijor_first;
        $vcted_sinovac_siquijor_second += $this->vcted_sinovac_siquijor_second;
        $vcted_sinovac_cebu_facility_first += $this->vcted_sinovac_cebu_facility_first;
        $vcted_sinovac_cebu_facility_second += $this->vcted_sinovac_cebu_facility_second;
        $vcted_sinovac_mandaue_facility_first += $this->vcted_sinovac_mandaue_facility_first;
        $vcted_sinovac_mandaue_facility_second += $this->vcted_sinovac_mandaue_facility_second;
        $vcted_sinovac_lapu_facility_first += $this->vcted_sinovac_lapu_facility_first;
        $vcted_sinovac_lapu_facility_second += $this->vcted_sinovac_lapu_facility_second;

        //VACCINATED ASTRA B4
        $vcted_astra_bohol_first += $this->vcted_astra_bohol_first;
        $vcted_astra_bohol_second += $this->vcted_astra_bohol_second;
        $vcted_astra_cebu_first += $this->vcted_astra_cebu_first;
        $vcted_astra_cebu_second += $this->vcted_astra_cebu_second;
        $vcted_astra_negros_first += $this->vcted_astra_negros_first;
        $vcted_astra_negros_second += $this->vcted_astra_negros_second;
        $vcted_astra_siquijor_first += $this->vcted_astra_siquijor_first;
        $vcted_astra_siquijor_second += $this->vcted_astra_siquijor_second;
        $vcted_astra_cebu_facility_first += $this->vcted_astra_cebu_facility_first;
        $vcted_astra_cebu_facility_second += $this->vcted_astra_cebu_facility_second;
        $vcted_astra_mandaue_facility_first += $this->vcted_astra_mandaue_facility_first;
        $vcted_astra_mandaue_facility_second += $this->vcted_astra_mandaue_facility_second;
        $vcted_astra_lapu_facility_first += $this->vcted_astra_lapu_facility_first;
        $vcted_astra_lapu_facility_second += $this->vcted_astra_lapu_facility_second;

        //VACCINATED PFIZER B4
        $vcted_pfizer_bohol_first += $this->vcted_pfizer_bohol_first;
        $vcted_pfizer_bohol_second += $this->vcted_pfizer_bohol_second;
        $vcted_pfizer_cebu_first += $this->vcted_pfizer_cebu_first;
        $vcted_pfizer_cebu_second += $this->vcted_pfizer_cebu_second;
        $vcted_pfizer_negros_first += $this->vcted_pfizer_negros_first;
        $vcted_pfizer_negros_second += $this->vcted_pfizer_negros_second;
        $vcted_pfizer_siquijor_first += $this->vcted_pfizer_siquijor_first;
        $vcted_pfizer_siquijor_second += $this->vcted_pfizer_siquijor_second;
        $vcted_pfizer_cebu_facility_first += $this->vcted_pfizer_cebu_facility_first;
        $vcted_pfizer_cebu_facility_second += $this->vcted_pfizer_cebu_facility_second;
        $vcted_pfizer_mandaue_facility_first += $this->vcted_pfizer_mandaue_facility_first;
        $vcted_pfizer_mandaue_facility_second += $this->vcted_pfizer_mandaue_facility_second;
        $vcted_pfizer_lapu_facility_first += $this->vcted_pfizer_lapu_facility_first;
        $vcted_pfizer_lapu_facility_second += $this->vcted_pfizer_lapu_facility_second;

        //VACCINATED SPUTNIKV B4
        $vcted_sputnikv_bohol_first += $this->vcted_sputnikv_bohol_first;
        $vcted_sputnikv_bohol_second += $this->vcted_sputnikv_bohol_second;
        $vcted_sputnikv_cebu_first += $this->vcted_sputnikv_cebu_first;
        $vcted_sputnikv_cebu_second += $this->vcted_sputnikv_cebu_second;
        $vcted_sputnikv_negros_first += $this->vcted_sputnikv_negros_first;
        $vcted_sputnikv_negros_second += $this->vcted_sputnikv_negros_second;
        $vcted_sputnikv_siquijor_first += $this->vcted_sputnikv_siquijor_first;
        $vcted_sputnikv_siquijor_second += $this->vcted_sputnikv_siquijor_second;
        $vcted_sputnikv_cebu_facility_first += $this->vcted_sputnikv_cebu_facility_first;
        $vcted_sputnikv_cebu_facility_second += $this->vcted_sputnikv_cebu_facility_second;
        $vcted_sputnikv_mandaue_facility_first += $this->vcted_sputnikv_mandaue_facility_first;
        $vcted_sputnikv_mandaue_facility_second += $this->vcted_sputnikv_mandaue_facility_second;
        $vcted_sputnikv_lapu_facility_first += $this->vcted_sputnikv_lapu_facility_first;
        $vcted_sputnikv_lapu_facility_second += $this->vcted_sputnikv_lapu_facility_second;


        //VACCINATED MODERNA B4
        $vcted_moderna_bohol_first += $this->vcted_moderna_bohol_first;
        $vcted_moderna_bohol_second += $this->vcted_moderna_bohol_second;
        $vcted_moderna_cebu_first += $this->vcted_moderna_cebu_first;
        $vcted_moderna_cebu_second += $this->vcted_moderna_cebu_second;
        $vcted_moderna_negros_first += $this->vcted_moderna_negros_first;
        $vcted_moderna_negros_second += $this->vcted_moderna_negros_second;
        $vcted_moderna_siquijor_first += $this->vcted_moderna_siquijor_first;
        $vcted_moderna_siquijor_second += $this->vcted_moderna_siquijor_second;
        $vcted_moderna_cebu_facility_first += $this->vcted_moderna_cebu_facility_first;
        $vcted_moderna_cebu_facility_second += $this->vcted_moderna_cebu_facility_second;
        $vcted_moderna_mandaue_facility_first += $this->vcted_moderna_mandaue_facility_first;
        $vcted_moderna_mandaue_facility_second += $this->vcted_moderna_mandaue_facility_second;
        $vcted_moderna_lapu_facility_first += $this->vcted_moderna_lapu_facility_first;
        $vcted_moderna_lapu_facility_second += $this->vcted_moderna_lapu_facility_second;

        //VACCINATED JOHNSON B4
        $vcted_johnson_bohol_first += $this->vcted_johnson_bohol_first;
        $vcted_johnson_bohol_second += $this->vcted_johnson_bohol_second;
        $vcted_johnson_cebu_first += $this->vcted_johnson_cebu_first;
        $vcted_johnson_cebu_second += $this->vcted_johnson_cebu_second;
        $vcted_johnson_negros_first += $this->vcted_johnson_negros_first;
        $vcted_johnson_negros_second += $this->vcted_johnson_negros_second;
        $vcted_johnson_siquijor_first += $this->vcted_johnson_siquijor_first;
        $vcted_johnson_siquijor_second += $this->vcted_johnson_siquijor_second;
        $vcted_johnson_cebu_facility_first += $this->vcted_johnson_cebu_facility_first;
        $vcted_johnson_cebu_facility_second += $this->vcted_johnson_cebu_facility_second;
        $vcted_johnson_mandaue_facility_first += $this->vcted_johnson_mandaue_facility_first;
        $vcted_johnson_mandaue_facility_second += $this->vcted_johnson_mandaue_facility_second;
        $vcted_johnson_lapu_facility_first += $this->vcted_johnson_lapu_facility_first;
        $vcted_johnson_lapu_facility_second += $this->vcted_johnson_lapu_facility_second;


        //TOTAL REFUSED FIRST B4
        $total_refusal_first += $this->total_refusal_first;
        $refused_first_bohol += $this->refused_first_bohol;
        $refused_first_cebu += $this->refused_first_cebu;
        $refused_first_negros += $this->refused_first_negros;
        $refused_first_siquijor += $this->refused_first_siquijor;
        $refused_cebu_facility_first += $this->refused_cebu_facility_first;
        $refused_mandaue_facility_first += $this->refused_mandaue_facility_first;
        $refused_lapu_facility_first += $this->refused_lapu_facility_first;

        //TOTAL REFUSED SECOND B4
        $total_refusal_second += $this->total_refusal_second;
        $refused_second_bohol += $this->refused_second_bohol;
        $refused_second_cebu += $this->refused_second_cebu;
        $refused_second_negros += $this->refused_second_negros;
        $refused_second_siquijor += $this->refused_second_siquijor;
        $refused_cebu_facility_second += $this->refused_cebu_facility_second;
        $refused_mandaue_facility_second += $this->refused_mandaue_facility_second;
        $refused_lapu_facility_second += $this->refused_lapu_facility_second;

        //TOTAL DEFERRED FIRST B4
        $total_deferred_first += $this->total_deferred_first;
        $deferred_first_bohol += $this->deferred_first_bohol;
        $deferred_first_cebu += $this->deferred_first_cebu;
        $deferred_first_negros += $this->deferred_first_negros;
        $deferred_first_siquijor += $this->deferred_first_siquijor;
        $deferred_cebu_facility_first += $this->deferred_cebu_facility_first;
        $deferred_mandaue_facility_first += $this->deferred_mandaue_facility_first;
        $deferred_lapu_facility_first += $this->deferred_lapu_facility_first;

        //TOTAL DEFERRED SECOND B4
        $total_deferred_second += $this->total_deferred_second;
        $deferred_second_bohol += $this->deferred_second_bohol;
        $deferred_second_cebu += $this->deferred_second_cebu;
        $deferred_second_negros += $this->deferred_second_negros;
        $deferred_second_siquijor += $this->deferred_second_siquijor;
        $deferred_cebu_facility_second += $this->deferred_cebu_facility_second;
        $deferred_mandaue_facility_second += $this->deferred_mandaue_facility_second;
        $deferred_lapu_facility_second += $this->deferred_lapu_facility_second;

        //TOTAL WASTAGE B4
        $wastage_sinovac_first += $this->wastage_sinovac_first;
        $wastage_astra_first += $this->wastage_astra_first;
        $wastage_pfizer_first += $this->wastage_pfizer_first;
        $wastage_sputnikv_first += $this->wastage_sputnikv_first;
        $wastage_moderna_first += $this->wastage_moderna_first;
        $wastage_johnson_first += $this->wastage_johnson_first;

        //WASTAGE SINOVAC B4
        $wastage_sinovac_bohol_first += $this->wastage_sinovac_bohol_first;
        $wastage_sinovac_cebu_first += $this->wastage_sinovac_cebu_first;
        $wastage_sinovac_negros_first += $this->wastage_sinovac_negros_first;
        $wastage_sinovac_siquijor_first += $this->wastage_sinovac_siquijor_first;
        $wastage_sinovac_cebu_facility_first += $this->wastage_sinovac_cebu_facility_first;
        $wastage_sinovac_mandaue_facility_first += $this->wastage_sinovac_mandaue_facility_first;
        $wastage_sinovac_lapu_facility_first += $this->wastage_sinovac_lapu_facility_first;

        //WASTAGE ASTRA B4
        $wastage_astra_bohol_first += $this->wastage_astra_bohol_first;
        $wastage_astra_cebu_first += $this->wastage_astra_cebu_first;
        $wastage_astra_negros_first += $this->wastage_astra_negros_first;
        $wastage_astra_siquijor_first += $this->wastage_astra_siquijor_first;
        $wastage_astra_cebu_facility_first += $this->wastage_astra_cebu_facility_first;
        $wastage_astra_mandaue_facility_first += $this->wastage_astra_mandaue_facility_first;
        $wastage_astra_lapu_facility_first += $this->wastage_astra_lapu_facility_first;

        //WASTAGE PFIZER B4
        $wastage_pfizer_bohol_first += $this->wastage_pfizer_bohol_first;
        $wastage_pfizer_cebu_first += $this->wastage_pfizer_cebu_first;
        $wastage_pfizer_negros_first += $this->wastage_pfizer_negros_first;
        $wastage_pfizer_siquijor_first += $this->wastage_pfizer_siquijor_first;
        $wastage_pfizer_cebu_facility_first += $this->wastage_pfizer_cebu_facility_first;
        $wastage_pfizer_mandaue_facility_first += $this->wastage_pfizer_mandaue_facility_first;
        $wastage_pfizer_lapu_facility_first += $this->wastage_pfizer_lapu_facility_first;

        //WASTAGE SPUTNIKV B4
        $wastage_sputnikv_bohol_first += $this->wastage_sputnikv_bohol_first;
        $wastage_sputnikv_cebu_first += $this->wastage_sputnikv_cebu_first;
        $wastage_sputnikv_negros_first += $this->wastage_sputnikv_negros_first;
        $wastage_sputnikv_siquijor_first += $this->wastage_sputnikv_siquijor_first;
        $wastage_sputnikv_cebu_facility_first += $this->wastage_sputnikv_cebu_facility_first;
        $wastage_sputnikv_mandaue_facility_first += $this->wastage_sputnikv_mandaue_facility_first;
        $wastage_sputnikv_lapu_facility_first += $this->wastage_sputnikv_lapu_facility_first;

        //WASTAGE MODERNA B4
        $wastage_moderna_bohol_first += $this->wastage_moderna_bohol_first;
        $wastage_moderna_cebu_first += $this->wastage_moderna_cebu_first;
        $wastage_moderna_negros_first += $this->wastage_moderna_negros_first;
        $wastage_moderna_siquijor_first += $this->wastage_moderna_siquijor_first;
        $wastage_moderna_cebu_facility_first += $this->wastage_moderna_cebu_facility_first;
        $wastage_moderna_mandaue_facility_first += $this->wastage_moderna_mandaue_facility_first;
        $wastage_moderna_lapu_facility_first += $this->wastage_moderna_lapu_facility_first;

        //WASTAGE JOHNSON B4
        $wastage_johnson_bohol_first += $this->wastage_johnson_bohol_first;
        $wastage_johnson_cebu_first += $this->wastage_johnson_cebu_first;
        $wastage_johnson_negros_first += $this->wastage_johnson_negros_first;
        $wastage_johnson_siquijor_first += $this->wastage_johnson_siquijor_first;
        $wastage_johnson_cebu_facility_first += $this->wastage_johnson_cebu_facility_first;
        $wastage_johnson_mandaue_facility_first += $this->wastage_johnson_mandaue_facility_first;
        $wastage_johnson_lapu_facility_first += $this->wastage_johnson_lapu_facility_first;



        //GRAND OVERALL
        $this->total_elipop_region = $total_elipop_region;
        $this->eli_pop_bohol = $eli_pop_bohol;
        $this->eli_pop_cebu = $eli_pop_cebu;
        $this->eli_pop_negros = $eli_pop_negros;
        $this->eli_pop_siquijor = $eli_pop_siquijor;
        $this->eli_pop_cebu_facility = $eli_pop_cebu_facility;
        $this->eli_pop_mandaue_facility = $eli_pop_mandaue_facility;
        $this->eli_pop_lapu_facility = $eli_pop_lapu_facility;
        $this->region_sinovac_first_dose = $region_sinovac_first_dose;
        $this->region_sinovac_second_dose = $region_sinovac_second_dose;
        $this->region_astra_first_dose = $region_astra_first_dose;
        $this->region_astra_second_dose = $region_astra_second_dose;
        $this->region_pfizer_first_dose = $region_pfizer_first_dose;
        $this->region_pfizer_second_dose = $region_pfizer_second_dose;
        $this->region_sputnikv_first_dose = $region_sputnikv_first_dose;
        $this->region_sputnikv_second_dose = $region_sputnikv_second_dose;

        $this->region_moderna_first_dose = $region_moderna_first_dose;
        $this->region_moderna_second_dose = $region_moderna_second_dose;
        $this->region_johnson_first_dose = $region_johnson_first_dose;
        $this->region_johnson_second_dose = $region_johnson_second_dose;


        //GRAND OVERALL VACCINATED SINOVAC
        $this->vcted_sinovac_bohol_first = $vcted_sinovac_bohol_first;
        $this->vcted_sinovac_bohol_second = $vcted_sinovac_bohol_second;
        $this->vcted_sinovac_cebu_first = $vcted_sinovac_cebu_first;
        $this->vcted_sinovac_cebu_second = $vcted_sinovac_cebu_second;
        $this->vcted_sinovac_negros_first = $vcted_sinovac_negros_first;
        $this->vcted_sinovac_negros_second = $vcted_sinovac_negros_second;
        $this->vcted_sinovac_siquijor_first = $vcted_sinovac_siquijor_first;
        $this->vcted_sinovac_siquijor_second = $vcted_sinovac_siquijor_second;
        $this->vcted_sinovac_cebu_facility_first = $vcted_sinovac_cebu_facility_first;
        $this->vcted_sinovac_cebu_facility_second = $vcted_sinovac_cebu_facility_second;
        $this->vcted_sinovac_mandaue_facility_first = $vcted_sinovac_mandaue_facility_first;
        $this->vcted_sinovac_mandaue_facility_second = $vcted_sinovac_mandaue_facility_second;
        $this->vcted_sinovac_lapu_facility_first = $vcted_sinovac_lapu_facility_first;
        $this->vcted_sinovac_lapu_facility_second = $vcted_sinovac_lapu_facility_second;


        //GRAND OVERALL VACCINATED ASTRA
        $this->vcted_astra_bohol_first = $vcted_astra_bohol_first;
        $this->vcted_astra_bohol_second = $vcted_astra_bohol_second;
        $this->vcted_astra_cebu_first = $vcted_astra_cebu_first;
        $this->vcted_astra_cebu_second = $vcted_astra_cebu_second;
        $this->vcted_astra_negros_first = $vcted_astra_negros_first;
        $this->vcted_astra_negros_second = $vcted_astra_negros_second;
        $this->vcted_astra_siquijor_first = $vcted_astra_siquijor_first;
        $this->vcted_astra_siquijor_second = $vcted_astra_siquijor_second;
        $this->vcted_astra_cebu_facility_first = $vcted_astra_cebu_facility_first;
        $this->vcted_astra_cebu_facility_second = $vcted_astra_cebu_facility_second;
        $this->vcted_astra_mandaue_facility_first = $vcted_astra_mandaue_facility_first;
        $this->vcted_astra_mandaue_facility_second = $vcted_astra_mandaue_facility_second;
        $this->vcted_astra_lapu_facility_first = $vcted_astra_lapu_facility_first;
        $this->vcted_astra_lapu_facility_second = $vcted_astra_lapu_facility_second;

        //GRAND OVERALL VACCINATED PFIZER
        $this->vcted_pfizer_bohol_first = $vcted_pfizer_bohol_first;
        $this->vcted_pfizer_bohol_second = $vcted_pfizer_bohol_second;
        $this->vcted_pfizer_cebu_first = $vcted_pfizer_cebu_first;
        $this->vcted_pfizer_cebu_second = $vcted_pfizer_cebu_second;
        $this->vcted_pfizer_negros_first = $vcted_pfizer_negros_first;
        $this->vcted_pfizer_negros_second = $vcted_pfizer_negros_second;
        $this->vcted_pfizer_siquijor_first = $vcted_pfizer_siquijor_first;
        $this->vcted_pfizer_siquijor_second = $vcted_pfizer_siquijor_second;
        $this->vcted_pfizer_cebu_facility_first = $vcted_pfizer_cebu_facility_first;
        $this->vcted_pfizer_cebu_facility_second = $vcted_pfizer_cebu_facility_second;
        $this->vcted_pfizer_mandaue_facility_first = $vcted_pfizer_mandaue_facility_first;
        $this->vcted_pfizer_mandaue_facility_second = $vcted_pfizer_mandaue_facility_second;
        $this->vcted_pfizer_lapu_facility_first = $vcted_pfizer_lapu_facility_first;
        $this->vcted_pfizer_lapu_facility_second = $vcted_pfizer_lapu_facility_second;

        //GRAND OVERALL VACCINATED SPUTNIKV
        $this->vcted_sputnikv_bohol_first = $vcted_sputnikv_bohol_first;
        $this->vcted_sputnikv_bohol_second = $vcted_sputnikv_bohol_second;
        $this->vcted_sputnikv_cebu_first = $vcted_sputnikv_cebu_first;
        $this->vcted_sputnikv_cebu_second = $vcted_sputnikv_cebu_second;
        $this->vcted_sputnikv_negros_first = $vcted_sputnikv_negros_first;
        $this->vcted_sputnikv_negros_second = $vcted_sputnikv_negros_second;
        $this->vcted_sputnikv_siquijor_first = $vcted_sputnikv_siquijor_first;
        $this->vcted_sputnikv_siquijor_second = $vcted_sputnikv_siquijor_second;
        $this->vcted_sputnikv_cebu_facility_first = $vcted_sputnikv_cebu_facility_first;
        $this->vcted_sputnikv_cebu_facility_second = $vcted_sputnikv_cebu_facility_second;
        $this->vcted_sputnikv_mandaue_facility_first = $vcted_sputnikv_mandaue_facility_first;
        $this->vcted_sputnikv_mandaue_facility_second = $vcted_sputnikv_mandaue_facility_second;
        $this->vcted_sputnikv_lapu_facility_first = $vcted_sputnikv_lapu_facility_first;
        $this->vcted_sputnikv_lapu_facility_second = $vcted_sputnikv_lapu_facility_second;

        //GRAND OVERALL VACCINATED MODERNA
        $this->vcted_moderna_bohol_first = $vcted_moderna_bohol_first;
        $this->vcted_moderna_bohol_second = $vcted_moderna_bohol_second;
        $this->vcted_moderna_cebu_first = $vcted_moderna_cebu_first;
        $this->vcted_moderna_cebu_second = $vcted_moderna_cebu_second;
        $this->vcted_moderna_negros_first = $vcted_moderna_negros_first;
        $this->vcted_moderna_negros_second = $vcted_moderna_negros_second;
        $this->vcted_moderna_siquijor_first = $vcted_moderna_siquijor_first;
        $this->vcted_moderna_siquijor_second = $vcted_moderna_siquijor_second;
        $this->vcted_moderna_cebu_facility_first = $vcted_moderna_cebu_facility_first;
        $this->vcted_moderna_cebu_facility_second = $vcted_moderna_cebu_facility_second;
        $this->vcted_moderna_mandaue_facility_first = $vcted_moderna_mandaue_facility_first;
        $this->vcted_moderna_mandaue_facility_second = $vcted_moderna_mandaue_facility_second;
        $this->vcted_moderna_lapu_facility_first = $vcted_moderna_lapu_facility_first;
        $this->vcted_moderna_lapu_facility_second = $vcted_moderna_lapu_facility_second;

        //GRAND OVERALL VACCINATED JOHNSON
        $this->vcted_johnson_bohol_first = $vcted_johnson_bohol_first;
        $this->vcted_johnson_bohol_second = $vcted_johnson_bohol_second;
        $this->vcted_johnson_cebu_first = $vcted_johnson_cebu_first;
        $this->vcted_johnson_cebu_second = $vcted_johnson_cebu_second;
        $this->vcted_johnson_negros_first = $vcted_johnson_negros_first;
        $this->vcted_johnson_negros_second = $vcted_johnson_negros_second;
        $this->vcted_johnson_siquijor_first = $vcted_johnson_siquijor_first;
        $this->vcted_johnson_siquijor_second = $vcted_johnson_siquijor_second;
        $this->vcted_johnson_cebu_facility_first = $vcted_johnson_cebu_facility_first;
        $this->vcted_johnson_cebu_facility_second = $vcted_johnson_cebu_facility_second;
        $this->vcted_johnson_mandaue_facility_first = $vcted_johnson_mandaue_facility_first;
        $this->vcted_johnson_mandaue_facility_second = $vcted_johnson_mandaue_facility_second;
        $this->vcted_johnson_lapu_facility_first = $vcted_johnson_lapu_facility_first;
        $this->vcted_johnson_lapu_facility_second = $vcted_johnson_lapu_facility_second;


        //GRAND VACCINATED FIRST
        $this->total_vcted_first_bohol = $this->vcted_sinovac_bohol_first + $this->vcted_astra_bohol_first + $this->vcted_pfizer_bohol_first +
            $this->vcted_sputnikv_bohol_first + $this->vcted_moderna_bohol_first + $this->vcted_johnson_bohol_first;
        $this->total_vcted_first_cebu = $this->vcted_sinovac_cebu_first + $this->vcted_astra_cebu_first + $this->vcted_pfizer_cebu_first +
            $this->vcted_sputnikv_cebu_first + $this->vcted_moderna_cebu_first + $this->vcted_johnson_cebu_first;
        $this->total_vcted_first_negros = $this->vcted_sinovac_negros_first + $this->vcted_astra_negros_first + $this->vcted_pfizer_negros_first +
            $this->vcted_sputnikv_negros_first + $this->vcted_moderna_negros_first + $this->vcted_johnson_negros_first;
        $this->total_vcted_first_siquijor = $this->vcted_sinovac_siquijor_first + $this->vcted_astra_siquijor_first + $this->vcted_pfizer_siquijor_first +
            $this->vcted_sputnikv_siquijor_first + $this->vcted_moderna_siquijor_first + $this->vcted_johnson_siquijor_first;
        $this->total_vcted_cebu_facility_first = $this->vcted_sinovac_cebu_facility_first + $this->vcted_astra_cebu_facility_first + $this->vcted_pfizer_cebu_facility_first +
            $this->vcted_sputnikv_cebu_facility_first + $this->vcted_moderna_cebu_facility_first + $this->vcted_johnson_cebu_facility_first;
        $this->total_vcted_mandaue_facility_first = $this->vcted_sinovac_mandaue_facility_first + $this->vcted_astra_mandaue_facility_first + $this->vcted_pfizer_mandaue_facility_first +
            $this->vcted_sputnikv_mandaue_facility_first + $this->vcted_moderna_mandaue_facility_first + $this->vcted_johnson_mandaue_facility_first;
        $this->total_vcted_lapu_facility_first = $this->vcted_sinovac_lapu_facility_first + $this->vcted_astra_lapu_facility_first + $this->vcted_pfizer_lapu_facility_first +
            $this->vcted_sputnikv_lapu_facility_first + $this->vcted_moderna_lapu_facility_first + $this->vcted_johnson_lapu_facility_first;


        //GRAND VACCINATED SECOND
        $this->total_vcted_second_bohol = $this->vcted_sinovac_bohol_second + $this->vcted_astra_bohol_second + $this->vcted_pfizer_bohol_second +
            $this->vcted_sputnikv_bohol_second + $this->vcted_moderna_bohol_second + $this->vcted_johnson_bohol_second;
        $this->total_vcted_second_cebu = $this->vcted_sinovac_cebu_second + $this->vcted_astra_cebu_second + $this->vcted_pfizer_cebu_second +
            $this->vcted_sputnikv_cebu_second + $this->vcted_moderna_cebu_second + $this->vcted_johnson_cebu_second;
        $this->total_vcted_second_negros = $this->vcted_sinovac_negros_second + $this->vcted_astra_negros_second + $this->vcted_pfizer_negros_second +
            $this->vcted_sputnikv_negros_second + $this->vcted_moderna_negros_second + $this->vcted_johnson_negros_second;
        $this->total_vcted_second_siquijor = $this->vcted_sinovac_siquijor_second + $this->vcted_astra_siquijor_second + $this->vcted_pfizer_siquijor_second +
            $this->vcted_sputnikv_siquijor_second + $this->vcted_moderna_siquijor_second + $this->vcted_johnson_siquijor_second;
        $this->total_vcted_cebu_facility_second = $this->vcted_sinovac_cebu_facility_second + $this->vcted_astra_cebu_facility_second + $this->vcted_pfizer_cebu_facility_second +
            $this->vcted_sputnikv_cebu_facility_second + $this->vcted_moderna_cebu_facility_second + $this->vcted_johnson_cebu_facility_second;
        $this->total_vcted_mandaue_facility_second = $this->vcted_sinovac_mandaue_facility_second + $this->vcted_astra_mandaue_facility_second + $this->vcted_pfizer_mandaue_facility_second +
            $this->vcted_sputnikv_mandaue_facility_second + $this->vcted_moderna_mandaue_facility_second + $this->vcted_johnson_mandaue_facility_second;
        $this->total_vcted_lapu_facility_second = $this->vcted_sinovac_lapu_facility_second + $this->vcted_astra_lapu_facility_second + $this->vcted_pfizer_lapu_facility_second +
            $this->vcted_sputnikv_lapu_facility_second + $this->vcted_moderna_lapu_facility_second + $this->vcted_johnson_lapu_facility_second;

        //GRAND VACCINATED REGION
        $this->first_dose_total = $this->region_sinovac_first_dose  +  $this->region_astra_first_dose + $this->region_pfizer_first_dose +
            $this->region_sputnikv_first_dose + $this->region_moderna_first_dose + $this->region_johnson_first_dose;
        $this->second_dose_total = $this->region_sinovac_second_dose  +  $this->region_astra_second_dose + $this->region_pfizer_second_dose +
            $this->region_sputnikv_second_dose + $this->region_moderna_second_dose + $this->region_johnson_second_dose;


        //PERCENT COVERAGE SINOVAC FIRST
        $this->total_p_cvrge_sinovac_region_first = number_format($this->region_sinovac_first_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_sinovac_bohol_first = number_format($this->vcted_sinovac_bohol_first / $eli_pop_bohol * 100,2);
        $this->p_cvrge_sinovac_cebu_first = number_format($this->vcted_sinovac_cebu_first / $eli_pop_cebu * 100,2);
        $this->p_cvrge_sinovac_negros_first = number_format($this->vcted_sinovac_negros_first / $eli_pop_negros * 100,2);
        $this->p_cvrge_sinovac_siquijor_first = number_format($this->vcted_sinovac_siquijor_first / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_sinovac_cebu_facility_first = number_format($this->vcted_sinovac_cebu_facility_first / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_sinovac_mandaue_facility_first =  number_format($this->vcted_sinovac_mandaue_facility_first / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_sinovac_lapu_facility_first =  number_format($this->vcted_sinovac_lapu_facility_first / $eli_pop_lapu_facility * 100,2);

        //PERCENT COVERAGE ASTRA FIRST
        $this->total_p_cvrge_astra_region_first = number_format($this->region_astra_first_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_astra_bohol_first =   number_format($this->vcted_astra_bohol_first / $eli_pop_bohol * 100,2);
        $this->p_cvrge_astra_cebu_first = number_format($this->vcted_astra_cebu_first / $eli_pop_cebu * 100,2);
        $this->p_cvrge_astra_negros_first = number_format($this->vcted_astra_negros_first / $eli_pop_negros * 100,2);
        $this->p_cvrge_astra_siquijor_first = number_format($this->vcted_astra_siquijor_first / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_astra_cebu_facility_first = number_format($this->vcted_astra_cebu_facility_first / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_astra_mandaue_facility_first = number_format($this->vcted_astra_mandaue_facility_first / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_astra_lapu_facility_first = number_format($this->vcted_astra_lapu_facility_first / $eli_pop_lapu_facility * 100,2);

        //OVERALL PERCENT COVERAGE PFIZER FIRST
        $this->total_p_cvrge_pfizer_region_first = number_format($this->region_pfizer_first_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_pfizer_bohol_first =  number_format($this->vcted_pfizer_bohol_first / $eli_pop_bohol * 100,2);
        $this->p_cvrge_pfizer_cebu_first = number_format($this->vcted_pfizer_cebu_first / $eli_pop_cebu * 100,2);
        $this->p_cvrge_pfizer_negros_first = number_format($this->vcted_pfizer_negros_first / $eli_pop_negros * 100,2);
        $this->p_cvrge_pfizer_siquijor_first = number_format($this->vcted_pfizer_siquijor_first / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_pfizer_cebu_facility_first =  number_format($this->vcted_pfizer_cebu_facility_first / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_pfizer_mandaue_facility_first = number_format($this->vcted_pfizer_mandaue_facility_first / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_pfizer_lapu_facility_first = number_format($this->vcted_pfizer_lapu_facility_first / $eli_pop_lapu_facility * 100,2);

        //PERCENT COVERAGE SPUTNIKV FIRST
        $this->total_p_cvrge_sputnikv_region_first = number_format($this->region_sputnikv_first_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_sputnikv_bohol_first =  number_format($this->vcted_sputnikv_bohol_first / $eli_pop_bohol * 100,2);
        $this->p_cvrge_sputnikv_cebu_first = number_format($this->vcted_sputnikv_cebu_first / $eli_pop_cebu * 100,2);
        $this->p_cvrge_sputnikv_negros_first = number_format($this->vcted_sputnikv_negros_first / $eli_pop_negros * 100,2);
        $this->p_cvrge_sputnikv_siquijor_first = number_format($this->vcted_sputnikv_siquijor_first / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_sputnikv_cebu_facility_first =  number_format($this->vcted_sputnikv_cebu_facility_first / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_sputnikv_mandaue_facility_first = number_format($this->vcted_sputnikv_mandaue_facility_first / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_sputnikv_lapu_facility_first = number_format($this->vcted_sputnikv_lapu_facility_first / $eli_pop_lapu_facility * 100,2);

        //PERCENT COVERAGE MODERNA FIRST
        $this->total_p_cvrge_moderna_region_first = number_format($this->region_moderna_first_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_moderna_bohol_first =  number_format($this->vcted_moderna_bohol_first / $eli_pop_bohol * 100,2);
        $this->p_cvrge_moderna_cebu_first = number_format($this->vcted_moderna_cebu_first / $eli_pop_cebu * 100,2);
        $this->p_cvrge_moderna_negros_first = number_format($this->vcted_moderna_negros_first / $eli_pop_negros * 100,2);
        $this->p_cvrge_moderna_siquijor_first = number_format($this->vcted_moderna_siquijor_first / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_moderna_cebu_facility_first =  number_format($this->vcted_moderna_cebu_facility_first / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_moderna_mandaue_facility_first = number_format($this->vcted_moderna_mandaue_facility_first / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_moderna_lapu_facility_first = number_format($this->vcted_moderna_lapu_facility_first / $eli_pop_lapu_facility * 100,2);

        //PERCENT COVERAGE JOHNSON FIRST
        $this->total_p_cvrge_johnson_region_first = number_format($this->region_johnson_first_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_johnson_bohol_first =  number_format($this->vcted_johnson_bohol_first / $eli_pop_bohol * 100,2);
        $this->p_cvrge_johnson_cebu_first = number_format($this->vcted_johnson_cebu_first / $eli_pop_cebu * 100,2);
        $this->p_cvrge_johnson_negros_first = number_format($this->vcted_johnson_negros_first / $eli_pop_negros * 100,2);
        $this->p_cvrge_johnson_siquijor_first = number_format($this->vcted_johnson_siquijor_first / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_johnson_cebu_facility_first =  number_format($this->vcted_johnson_cebu_facility_first / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_johnson_mandaue_facility_first = number_format($this->vcted_johnson_mandaue_facility_first / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_johnson_lapu_facility_first = number_format($this->vcted_johnson_lapu_facility_first / $eli_pop_lapu_facility * 100,2);


        //GRAND OVERALL PERCENT COVERAGE SINOVAC SECOND
        $this->total_p_cvrge_sinovac_region_second = number_format($this->region_sinovac_second_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_sinovac_bohol_second = number_format($this->vcted_sinovac_bohol_second / $eli_pop_bohol * 100,2);
        $this->p_cvrge_sinovac_cebu_second = number_format($this->vcted_sinovac_cebu_second / $eli_pop_cebu * 100,2);
        $this->p_cvrge_sinovac_negros_second = number_format($this->vcted_sinovac_negros_second / $eli_pop_negros * 100,2);
        $this->p_cvrge_sinovac_siquijor_second = number_format($this->vcted_sinovac_siquijor_second / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_sinovac_cebu_facility_second = number_format($this->vcted_sinovac_cebu_facility_second / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_sinovac_mandaue_facility_second =  number_format($this->vcted_sinovac_mandaue_facility_second / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_sinovac_lapu_facility_second =  number_format($this->vcted_sinovac_lapu_facility_second / $eli_pop_lapu_facility * 100,2);

        //GRAND OVERALL PERCENT COVERAGE ASTRA SECOND
        $this->total_p_cvrge_astra_region_second = number_format($this->region_astra_second_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_astra_bohol_second = number_format($this->vcted_astra_bohol_second / $eli_pop_bohol * 100,2);
        $this->p_cvrge_astra_cebu_second = number_format($this->vcted_astra_cebu_second / $eli_pop_cebu * 100,2);
        $this->p_cvrge_astra_negros_second = number_format($this->vcted_astra_negros_second / $eli_pop_negros * 100,2);
        $this->p_cvrge_astra_siquijor_second = number_format($this->vcted_astra_siquijor_second / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_astra_cebu_facility_second = number_format($this->vcted_astra_cebu_facility_second / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_astra_mandaue_facility_second =  number_format($this->vcted_astra_mandaue_facility_second / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_astra_lapu_facility_second =  number_format($this->vcted_astra_lapu_facility_second / $eli_pop_lapu_facility * 100,2);

        //GRAND OVERALL PERCENT COVERAGE PFIZER SECOND
        $this->total_p_cvrge_pfizer_region_second = number_format($this->region_pfizer_second_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_pfizer_bohol_second = number_format($this->vcted_pfizer_bohol_second / $eli_pop_bohol * 100,2);
        $this->p_cvrge_pfizer_cebu_second = number_format($this->vcted_pfizer_cebu_second / $eli_pop_cebu * 100,2);
        $this->p_cvrge_pfizer_negros_second = number_format($this->vcted_pfizer_negros_second / $eli_pop_negros * 100,2);
        $this->p_cvrge_pfizer_siquijor_second = number_format($this->vcted_pfizer_siquijor_second / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_pfizer_cebu_facility_second = number_format($this->vcted_pfizer_cebu_facility_second / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_pfizer_mandaue_facility_second =  number_format($this->vcted_pfizer_mandaue_facility_second / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_pfizer_lapu_facility_second =  number_format($this->vcted_pfizer_lapu_facility_second / $eli_pop_lapu_facility * 100,2);

        //GRAND OVERALL PERCENT COVERAGE SPUTNIKV SECOND
        $this->total_p_cvrge_sputnikv_region_second = number_format($this->region_sputnikv_second_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_sputnikv_bohol_second = number_format($this->vcted_sputnikv_bohol_second / $eli_pop_bohol * 100,2);
        $this->p_cvrge_sputnikv_cebu_second = number_format($this->vcted_sputnikv_cebu_second / $eli_pop_cebu * 100,2);
        $this->p_cvrge_sputnikv_negros_second = number_format($this->vcted_sputnikv_negros_second / $eli_pop_negros * 100,2);
        $this->p_cvrge_sputnikv_siquijor_second = number_format($this->vcted_sputnikv_siquijor_second / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_sputnikv_cebu_facility_second = number_format($this->vcted_sputnikv_cebu_facility_second / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_sputnikv_mandaue_facility_second =  number_format($this->vcted_sputnikv_mandaue_facility_second / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_sputnikv_lapu_facility_second =  number_format($this->vcted_sputnikv_lapu_facility_second / $eli_pop_lapu_facility * 100,2);

        //GRAND OVERALL PERCENT COVERAGE MODERNA SECOND
        $this->total_p_cvrge_moderna_region_second = number_format($this->region_moderna_second_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_moderna_bohol_second = number_format($this->vcted_moderna_bohol_second / $eli_pop_bohol * 100,2);
        $this->p_cvrge_moderna_cebu_second = number_format($this->vcted_moderna_cebu_second / $eli_pop_cebu * 100,2);
        $this->p_cvrge_moderna_negros_second = number_format($this->vcted_moderna_negros_second / $eli_pop_negros * 100,2);
        $this->p_cvrge_moderna_siquijor_second = number_format($this->vcted_moderna_siquijor_second / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_moderna_cebu_facility_second = number_format($this->vcted_moderna_cebu_facility_second / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_moderna_mandaue_facility_second =  number_format($this->vcted_moderna_mandaue_facility_second / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_moderna_lapu_facility_second =  number_format($this->vcted_moderna_lapu_facility_second / $eli_pop_lapu_facility * 100,2);

        //GRAND OVERALL PERCENT COVERAGE MODERNA SECOND
        $this->total_p_cvrge_johnson_region_second = number_format($this->region_johnson_second_dose / $total_elipop_region * 100,2);
        $this->p_cvrge_johnson_bohol_second = number_format($this->vcted_johnson_bohol_second / $eli_pop_bohol * 100,2);
        $this->p_cvrge_johnson_cebu_second = number_format($this->vcted_johnson_cebu_second / $eli_pop_cebu * 100,2);
        $this->p_cvrge_johnson_negros_second = number_format($this->vcted_johnson_negros_second / $eli_pop_negros * 100,2);
        $this->p_cvrge_johnson_siquijor_second = number_format($this->vcted_johnson_siquijor_second / $eli_pop_siquijor * 100,2);
        $this->p_cvrge_johnson_cebu_facility_second = number_format($this->vcted_johnson_cebu_facility_second / $eli_pop_cebu_facility * 100,2);
        $this->p_cvrge_johnson_mandaue_facility_second =  number_format($this->vcted_johnson_mandaue_facility_second / $eli_pop_mandaue_facility * 100,2);
        $this->p_cvrge_johnson_lapu_facility_second =  number_format($this->vcted_johnson_lapu_facility_second / $eli_pop_lapu_facility * 100,2);


        //GRAND OVER ALL TOTAL REFUSED FIRST
        $this->total_refusal_first = $total_refusal_first;
        $this->refused_first_bohol = $refused_first_bohol;
        $this->refused_first_cebu = $refused_first_cebu;
        $this->refused_first_negros = $refused_first_negros;
        $this->refused_first_siquijor = $refused_first_siquijor;
        $this->refused_cebu_facility_first = $refused_cebu_facility_first;
        $this->refused_mandaue_facility_first = $refused_mandaue_facility_first;
        $this->refused_lapu_facility_first = $refused_lapu_facility_first;

        //GRAND OVER ALL TOTAL REFUSED SECOND
        $this->total_refusal_second = $total_refusal_second;
        $this->refused_second_bohol = $refused_second_bohol;
        $this->refused_second_cebu = $refused_second_cebu;
        $this->refused_second_negros = $refused_second_negros;
        $this->refused_second_siquijor = $refused_second_siquijor;
        $this->refused_cebu_facility_second = $refused_cebu_facility_second;
        $this->refused_mandaue_facility_second = $refused_mandaue_facility_second;
        $this->refused_lapu_facility_second = $refused_lapu_facility_second;

        //GRAND OVER ALL TOTAL DEFERRED FIRST
        $this->total_deferred_first = $total_deferred_first;
        $this->deferred_first_bohol = $deferred_first_bohol;
        $this->deferred_first_cebu = $deferred_first_cebu;
        $this->deferred_first_negros = $deferred_first_negros;
        $this->deferred_first_siquijor = $deferred_first_siquijor;
        $this->deferred_cebu_facility_first = $deferred_cebu_facility_first;
        $this->deferred_mandaue_facility_first = $deferred_mandaue_facility_first;
        $this->deferred_lapu_facility_first = $deferred_lapu_facility_first;

        //GRAND OVER ALL TOTAL DEFERRED SECOND
        $this->total_deferred_second = $total_deferred_second;
        $this->deferred_second_bohol = $deferred_second_bohol;
        $this->deferred_second_cebu = $deferred_second_cebu;
        $this->deferred_second_negros = $deferred_second_negros;
        $this->deferred_second_siquijor = $deferred_second_siquijor;
        $this->deferred_cebu_facility_second = $deferred_cebu_facility_second;
        $this->deferred_mandaue_facility_second = $deferred_mandaue_facility_second;
        $this->deferred_lapu_facility_second = $deferred_lapu_facility_second;

        //GRAND OVERALL WASTAGE
        $this->wastage_sinovac_first = $wastage_sinovac_first;
        $this->wastage_astra_first = $wastage_astra_first;
        $this->wastage_pfizer_first = $wastage_pfizer_first;
        $this->wastage_sputnikv_first = $wastage_sputnikv_first;
        $this->wastage_moderna_first = $wastage_moderna_first;
        $this->wastage_johnson_first = $wastage_johnson_first;

        //GRAND OVERALL SINOVAC
        $this->wastage_sinovac_bohol_first = $wastage_sinovac_bohol_first;
        $this->wastage_sinovac_cebu_first = $wastage_sinovac_cebu_first;
        $this->wastage_sinovac_negros_first = $wastage_sinovac_negros_first;
        $this->wastage_sinovac_siquijor_first = $wastage_sinovac_siquijor_first;
        $this->wastage_sinovac_cebu_facility_first = $wastage_sinovac_cebu_facility_first;
        $this->wastage_sinovac_mandaue_facility_first = $wastage_sinovac_mandaue_facility_first;
        $this->wastage_sinovac_lapu_facility_first = $wastage_sinovac_lapu_facility_first;

        //GRAND OVERALL ASTRA
        $this->wastage_astra_bohol_first = $wastage_astra_bohol_first;
        $this->wastage_astra_cebu_first = $wastage_astra_cebu_first;
        $this->wastage_astra_negros_first = $wastage_astra_negros_first;
        $this->wastage_astra_siquijor_first = $wastage_astra_siquijor_first;
        $this->wastage_astra_cebu_facility_first = $wastage_astra_cebu_facility_first;
        $this->wastage_astra_mandaue_facility_first = $wastage_astra_mandaue_facility_first;
        $this->wastage_astra_lapu_facility_first = $wastage_astra_lapu_facility_first;

        //GRAND OVERALL PFIZER
        $this->wastage_pfizer_bohol_first = $wastage_pfizer_bohol_first;
        $this->wastage_pfizer_cebu_first = $wastage_pfizer_cebu_first;
        $this->wastage_pfizer_negros_first = $wastage_pfizer_negros_first;
        $this->wastage_pfizer_siquijor_first = $wastage_pfizer_siquijor_first;
        $this->wastage_pfizer_cebu_facility_first = $wastage_pfizer_cebu_facility_first;
        $this->wastage_pfizer_mandaue_facility_first = $wastage_pfizer_mandaue_facility_first;
        $this->wastage_pfizer_lapu_facility_first = $wastage_pfizer_lapu_facility_first;

        //GRAND OVERALL SPUTNIKV
        $this->wastage_sputnikv_bohol_first = $wastage_sputnikv_bohol_first;
        $this->wastage_sputnikv_cebu_first = $wastage_sputnikv_cebu_first;
        $this->wastage_sputnikv_negros_first = $wastage_sputnikv_negros_first;
        $this->wastage_sputnikv_siquijor_first = $wastage_sputnikv_siquijor_first;
        $this->wastage_sputnikv_cebu_facility_first = $wastage_sputnikv_cebu_facility_first;
        $this->wastage_sputnikv_mandaue_facility_first = $wastage_sputnikv_mandaue_facility_first;
        $this->wastage_sputnikv_lapu_facility_first = $wastage_sputnikv_lapu_facility_first;

        //GRAND OVERALL MODERNA
        $this->wastage_moderna_bohol_first = $wastage_moderna_bohol_first;
        $this->wastage_moderna_cebu_first = $wastage_moderna_cebu_first;
        $this->wastage_moderna_negros_first = $wastage_moderna_negros_first;
        $this->wastage_moderna_siquijor_first = $wastage_moderna_siquijor_first;
        $this->wastage_moderna_cebu_facility_first = $wastage_moderna_cebu_facility_first;
        $this->wastage_moderna_mandaue_facility_first = $wastage_moderna_mandaue_facility_first;
        $this->wastage_moderna_lapu_facility_first = $wastage_moderna_lapu_facility_first;

        //GRAND OVERALL JOHNSON
        $this->wastage_johnson_bohol_first = $wastage_johnson_bohol_first;
        $this->wastage_johnson_cebu_first = $wastage_johnson_cebu_first;
        $this->wastage_johnson_negros_first = $wastage_johnson_negros_first;
        $this->wastage_johnson_siquijor_first = $wastage_johnson_siquijor_first;
        $this->wastage_johnson_cebu_facility_first = $wastage_johnson_cebu_facility_first;
        $this->wastage_johnson_mandaue_facility_first = $wastage_johnson_mandaue_facility_first;
        $this->wastage_johnson_lapu_facility_first = $wastage_johnson_lapu_facility_first;

        //TOTAL CONSUMPTION RATE REGION
        $this->c_rate_region_sinovac_first = number_format($this->region_sinovac_first_dose / $this->sinovac_region_first * 100 ,2);
        $this->c_rate_region_astra_first = number_format($this->region_astra_first_dose / $this->astra_region_first * 100 ,2);
        $this->c_rate_region_pfizer_first = number_format($this->region_pfizer_first_dose / $this->pfizer_region_first * 100 ,2);
        $this->c_rate_region_sputnikv_first = number_format($this->region_sputnikv_first_dose / $this->sputnikv_region_first * 100 ,2);
        $this->c_rate_region_moderna_first = number_format($this->region_moderna_first_dose / $this->moderna_region_first * 100 ,2);
        $this->c_rate_region_johnson_first = number_format($this->region_johnson_first_dose / $this->johnson_region_first * 100 ,2);
        $this->total_c_rate_region_first = number_format($this->first_dose_total / $this->total_region_first * 100,2);

        //TOTAL CONSUMPTION RATE BOHOL
        $this->c_rate_sinovac_bohol_first = number_format($this->vcted_sinovac_bohol_first / $this->sinovac_bohol_first * 100,2);
        $this->c_rate_astra_bohol_first = number_format($this->vcted_astra_bohol_first / $this->astra_bohol_first * 100,2);
        $this->c_rate_pfizer_bohol_first = number_format($this->vcted_pfizer_bohol_first / $this->pfizer_bohol_first * 100,2);
        $this->c_rate_sputnikv_bohol_first = number_format($this->vcted_sputnikv_bohol_first / $this->sputnikv_bohol_first * 100,2);
        $this->c_rate_moderna_bohol_first = number_format($this->vcted_moderna_bohol_first / $this->moderna_bohol_first * 100,2);
        $this->c_rate_johnson_bohol_first = number_format($this->vcted_johnson_bohol_first / $this->johnson_bohol_first * 100,2);
        $this->total_c_rate_bohol_first = number_format($this->total_vcted_first_bohol / $this->total_bohol_first,2);

        //TOTAL CONSUMPTION RATE CEBU
        $this->c_rate_sinovac_cebu_first = number_format($this->vcted_sinovac_cebu_first / $this->sinovac_cebu_first * 100,2);
        $this->c_rate_astra_cebu_first = number_format($this->vcted_astra_cebu_first / $this->astra_cebu_first * 100,2);
        $this->c_rate_pfizer_cebu_first = number_format($this->vcted_pfizer_cebu_first / $this->pfizer_cebu_first * 100,2);
        $this->c_rate_sputnikv_cebu_first = number_format($this->vcted_sputnikv_cebu_first / $this->sputnikv_cebu_first * 100,2);
        $this->c_rate_moderna_cebu_first = number_format($this->vcted_moderna_cebu_first / $this->moderna_cebu_first * 100,2);
        $this->c_rate_johnson_cebu_first = number_format($this->vcted_johnson_cebu_first / $this->johnson_cebu_first * 100,2);
        $this->total_c_rate_cebu_first = number_format($this->total_vcted_first_cebu / $this->total_cebu_first,2);

        //TOTAL CONSUMPTION RATE NEGROS
        $this->c_rate_sinovac_negros_first = number_format($this->vcted_sinovac_negros_first / $this->sinovac_negros_first * 100,2);
        $this->c_rate_astra_negros_first = number_format($this->vcted_astra_negros_first / $this->astra_negros_first * 100,2);
        $this->c_rate_pfizer_negros_first = number_format($this->vcted_pfizer_negros_first / $this->pfizer_negros_first * 100,2);
        $this->c_rate_sputnikv_negros_first = number_format($this->vcted_sputnikv_negros_first / $this->sputnikv_negros_first * 100,2);
        $this->c_rate_moderna_negros_first = number_format($this->vcted_moderna_negros_first / $this->moderna_negros_first * 100,2);
        $this->c_rate_johnson_negros_first = number_format($this->vcted_johnson_negros_first / $this->johnson_negros_first * 100,2);
        $this->total_c_rate_negros_first = number_format($this->total_vcted_first_negros / $this->total_negros_first,2);

        //TOTAL CONSUMPTION RATE SIQUIJOR
        $this->c_rate_sinovac_siquijor_first = number_format($this->vcted_sinovac_siquijor_first / $this->sinovac_siquijor_first * 100,2);
        $this->c_rate_astra_siquijor_first = number_format($this->vcted_astra_siquijor_first / $this->astra_siquijor_first * 100,2);
        $this->c_rate_pfizer_siquijor_first = number_format($this->vcted_pfizer_siquijor_first / $this->pfizer_siquijor_first * 100,2);
        $this->c_rate_sputnikv_siquijor_first = number_format($this->vcted_sputnikv_siquijor_first / $this->sputnikv_siquijor_first * 100,2);
        $this->c_rate_moderna_siquijor_first = number_format($this->vcted_moderna_siquijor_first / $this->moderna_siquijor_first * 100,2);
        $this->c_rate_johnson_siquijor_first = number_format($this->vcted_johnson_siquijor_first / $this->johnson_siquijor_first * 100,2);
        $this->total_c_rate_siquijor_first = number_format($this->total_vcted_first_siquijor / $this->total_siquijor_first,2);

        //TOTAL CONSUMPTION RATE CEBU FACILITY
        $this->c_rate_sinovac_cebu_facility_first = number_format($this->vcted_sinovac_cebu_facility_first / $this->sinovac_cebu_facility_first * 100 ,2 );
        $this->c_rate_astra_cebu_facility_first =  number_format($this->vcted_astra_cebu_facility_first / $this->astra_cebu_facility_first * 100  ,2 );
        $this->c_rate_pfizer_cebu_facility_first = number_format($this->vcted_pfizer_cebu_facility_first / $this->pfizer_cebu_facility_first * 100  ,2 );
        $this->c_rate_sputnikv_cebu_facility_first = number_format($this->vcted_sputnikv_cebu_facility_first / $this->sputnikv_cebu_facility_first * 100  ,2 );
        $this->c_rate_moderna_cebu_facility_first = number_format($this->vcted_moderna_cebu_facility_first / $this->moderna_cebu_facility_first * 100  ,2 );
        $this->c_rate_johnson_cebu_facility_first = number_format($this->vcted_johnson_cebu_facility_first / $this->johnson_cebu_facility_first * 100  ,2 );
        $this->total_c_rate_cebu_facility_first = number_format($this->total_vcted_cebu_facility_first / $this->total_cebu_facility_first * 100,2);

        //TOTAL CONSUMPTION RATE MANDAUE FACILITY
        $this->c_rate_sinovac_mandaue_facility_first = number_format($this->vcted_sinovac_mandaue_facility_first / $this->sinovac_mandaue_facility_first * 100 ,2 );
        $this->c_rate_astra_mandaue_facility_first =  number_format($this->vcted_astra_mandaue_facility_first / $this->astra_mandaue_facility_first * 100  ,2 );
        $this->c_rate_pfizer_mandaue_facility_first = number_format($this->vcted_pfizer_mandaue_facility_first / $this->pfizer_mandaue_facility_first * 100  ,2 );
        $this->c_rate_sputnikv_mandaue_facility_first = number_format($this->vcted_sputnikv_mandaue_facility_first / $this->sputnikv_mandaue_facility_first * 100  ,2 );
        $this->c_rate_moderna_mandaue_facility_first = number_format($this->vcted_moderna_mandaue_facility_first / $this->moderna_mandaue_facility_first * 100  ,2 );
        $this->c_rate_johnson_mandaue_facility_first = number_format($this->vcted_johnson_mandaue_facility_first / $this->johnson_mandaue_facility_first * 100  ,2 );
        $this->total_c_rate_mandaue_facility_first = number_format($this->total_vcted_mandaue_facility_first / $this->total_mandaue_facility_first * 100,2);

        //TOTAL CONSUMPTION RATE LAPU-LAPU FACILITY
        $this->c_rate_sinovac_lapu_facility_first = number_format($this->vcted_sinovac_lapu_facility_first / $this->sinovac_lapu_facility_first * 100 ,2 );
        $this->c_rate_astra_lapu_facility_first =  number_format($this->vcted_astra_lapu_facility_first / $this->astra_lapu_facility_first * 100  ,2 );
        $this->c_rate_pfizer_lapu_facility_first = number_format($this->vcted_pfizer_lapu_facility_first / $this->pfizer_lapu_facility_first * 100  ,2 );
        $this->c_rate_sputnikv_lapu_facility_first = number_format($this->vcted_sputnikv_lapu_facility_first / $this->sputnikv_lapu_facility_first * 100  ,2 );
        $this->c_rate_moderna_lapu_facility_first = number_format($this->vcted_moderna_lapu_facility_first / $this->moderna_lapu_facility_first * 100  ,2 );
        $this->c_rate_johnson_lapu_facility_first = number_format($this->vcted_johnson_lapu_facility_first / $this->johnson_lapu_facility_first * 100  ,2 );
        $this->total_c_rate_lapu_facility_first = number_format($this->total_vcted_lapu_facility_first / $this->total_lapu_facility_first * 100,2);


        //TOTAL CONSUMPTION RATE REGION
        $this->c_rate_region_sinovac_second = number_format($this->region_sinovac_second_dose / $this->sinovac_region_second * 100 ,2);
        $this->c_rate_region_astra_second = number_format($this->region_astra_second_dose / $this->astra_region_second * 100 ,2);
        $this->c_rate_region_pfizer_second = number_format($this->region_pfizer_second_dose / $this->pfizer_region_second * 100 ,2);
        $this->c_rate_region_sputnikv_second = number_format($this->region_sputnikv_second_dose / $this->sputnikv_region_second * 100 ,2);
        $this->c_rate_region_moderna_second = number_format($this->region_moderna_second_dose / $this->moderna_region_second * 100 ,2);
        $this->c_rate_region_johnson_second = number_format($this->region_johnson_second_dose / $this->johnson_region_second * 100 ,2);
        $this->total_c_rate_region_second = number_format($this->second_dose_total / $this->total_region_second * 100,2);

        //TOTAL CONSUMPTION RATE BOHOL
        $this->c_rate_sinovac_bohol_second = number_format($this->vcted_sinovac_bohol_second / $this->sinovac_bohol_second * 100,2);
        $this->c_rate_astra_bohol_second = number_format($this->vcted_astra_bohol_second / $this->astra_bohol_second * 100,2);
        $this->c_rate_pfizer_bohol_second = number_format($this->vcted_pfizer_bohol_second / $this->pfizer_bohol_second * 100,2);
        $this->c_rate_sputnikv_bohol_second = number_format($this->vcted_sputnikv_bohol_second / $this->sputnikv_bohol_second * 100,2);
        $this->c_rate_moderna_bohol_second = number_format($this->vcted_moderna_bohol_second / $this->moderna_bohol_second * 100,2);
        $this->c_rate_johnson_bohol_second = number_format($this->vcted_johnson_bohol_second / $this->johnson_bohol_second * 100,2);
        $this->total_c_rate_bohol_second = number_format($this->total_vcted_second_bohol / $this->total_bohol_second,2);

        //TOTAL CONSUMPTION RATE CEBU
        $this->c_rate_sinovac_cebu_second = number_format($this->vcted_sinovac_cebu_second / $this->sinovac_cebu_second * 100,2);
        $this->c_rate_astra_cebu_second = number_format($this->vcted_astra_cebu_second / $this->astra_cebu_second * 100,2);
        $this->c_rate_pfizer_cebu_second = number_format($this->vcted_pfizer_cebu_second / $this->pfizer_cebu_second * 100,2);
        $this->c_rate_sputnikv_cebu_second = number_format($this->vcted_sputnikv_cebu_second / $this->sputnikv_cebu_second * 100,2);
        $this->c_rate_moderna_cebu_second = number_format($this->vcted_moderna_cebu_second / $this->moderna_cebu_second * 100,2);
        $this->c_rate_johnson_cebu_second = number_format($this->vcted_johnson_cebu_second / $this->johnson_cebu_second * 100,2);
        $this->total_c_rate_cebu_second = number_format($this->total_vcted_second_cebu / $this->total_cebu_second,2);

        //TOTAL CONSUMPTION RATE NEGROS
        $this->c_rate_sinovac_negros_second = number_format($this->vcted_sinovac_negros_second / $this->sinovac_negros_second * 100,2);
        $this->c_rate_astra_negros_second = number_format($this->vcted_astra_negros_second / $this->astra_negros_second * 100,2);
        $this->c_rate_pfizer_negros_second = number_format($this->vcted_pfizer_negros_second / $this->pfizer_negros_second * 100,2);
        $this->c_rate_sputnikv_negros_second = number_format($this->vcted_sputnikv_negros_second / $this->sputnikv_negros_second * 100,2);
        $this->c_rate_moderna_negros_second = number_format($this->vcted_moderna_negros_second / $this->moderna_negros_second * 100,2);
        $this->c_rate_johnson_negros_second = number_format($this->vcted_johnson_negros_second / $this->johnson_negros_second * 100,2);
        $this->total_c_rate_negros_second = number_format($this->total_vcted_second_negros / $this->total_negros_second,2);

        //TOTAL CONSUMPTION RATE SIQUIJOR
        $this->c_rate_sinovac_siquijor_second = number_format($this->vcted_sinovac_siquijor_second / $this->sinovac_siquijor_second * 100,2);
        $this->c_rate_astra_siquijor_second = number_format($this->vcted_astra_siquijor_second / $this->astra_siquijor_second * 100,2);
        $this->c_rate_pfizer_siquijor_second = number_format($this->vcted_pfizer_siquijor_second / $this->pfizer_siquijor_second * 100,2);
        $this->c_rate_sputnikv_siquijor_second = number_format($this->vcted_sputnikv_siquijor_second / $this->sputnikv_siquijor_second * 100,2);
        $this->c_rate_moderna_siquijor_second = number_format($this->vcted_moderna_siquijor_second / $this->moderna_siquijor_second * 100,2);
        $this->c_rate_johnson_siquijor_second = number_format($this->vcted_johnson_siquijor_second / $this->johnson_siquijor_second * 100,2);
        $this->total_c_rate_siquijor_second = number_format($this->total_vcted_second_siquijor / $this->total_siquijor_second,2);

        //TOTAL CONSUMPTION RATE CEBU FACILITY
        $this->c_rate_sinovac_cebu_facility_second = number_format($this->vcted_sinovac_cebu_facility_second / $this->sinovac_cebu_facility_second * 100 ,2 );
        $this->c_rate_astra_cebu_facility_second =  number_format($this->vcted_astra_cebu_facility_second / $this->astra_cebu_facility_second * 100  ,2 );
        $this->c_rate_pfizer_cebu_facility_second = number_format($this->vcted_pfizer_cebu_facility_second / $this->pfizer_cebu_facility_second * 100  ,2 );
        $this->c_rate_sputnikv_cebu_facility_second = number_format($this->vcted_sputnikv_cebu_facility_second / $this->sputnikv_cebu_facility_second * 100  ,2 );
        $this->c_rate_moderna_cebu_facility_second = number_format($this->vcted_moderna_cebu_facility_second / $this->moderna_cebu_facility_second * 100  ,2 );
        $this->c_rate_johnson_cebu_facility_second = number_format($this->vcted_johnson_cebu_facility_second / $this->johnson_cebu_facility_second * 100  ,2 );
        $this->total_c_rate_cebu_facility_second = number_format($this->total_vcted_cebu_facility_second / $this->total_cebu_facility_second * 100,2);

        //TOTAL CONSUMPTION RATE MANDAUE FACILITY
        $this->c_rate_sinovac_mandaue_facility_second = number_format($this->vcted_sinovac_mandaue_facility_second / $this->sinovac_mandaue_facility_second * 100 ,2 );
        $this->c_rate_astra_mandaue_facility_second =  number_format($this->vcted_astra_mandaue_facility_second / $this->astra_mandaue_facility_second * 100  ,2 );
        $this->c_rate_pfizer_mandaue_facility_second = number_format($this->vcted_pfizer_mandaue_facility_second / $this->pfizer_mandaue_facility_second * 100  ,2 );
        $this->c_rate_sputnikv_mandaue_facility_second = number_format($this->vcted_sputnikv_mandaue_facility_second / $this->sputnikv_mandaue_facility_second * 100  ,2 );
        $this->c_rate_moderna_mandaue_facility_second = number_format($this->vcted_moderna_mandaue_facility_second / $this->moderna_mandaue_facility_second * 100  ,2 );
        $this->c_rate_johnson_mandaue_facility_second = number_format($this->vcted_johnson_mandaue_facility_second / $this->johnson_mandaue_facility_second * 100  ,2 );
        $this->total_c_rate_mandaue_facility_second = number_format($this->total_vcted_mandaue_facility_second / $this->total_mandaue_facility_second * 100,2);

        //TOTAL CONSUMPTION RATE LAPU-LAPU FACILITY
        $this->c_rate_sinovac_lapu_facility_second = number_format($this->vcted_sinovac_lapu_facility_second / $this->sinovac_lapu_facility_second * 100 ,2 );
        $this->c_rate_astra_lapu_facility_second =  number_format($this->vcted_astra_lapu_facility_second / $this->astra_lapu_facility_second * 100  ,2 );
        $this->c_rate_pfizer_lapu_facility_second = number_format($this->vcted_pfizer_lapu_facility_second / $this->pfizer_lapu_facility_second * 100  ,2 );
        $this->c_rate_sputnikv_lapu_facility_second = number_format($this->vcted_sputnikv_lapu_facility_second / $this->sputnikv_lapu_facility_second * 100  ,2 );
        $this->c_rate_moderna_lapu_facility_second = number_format($this->vcted_moderna_lapu_facility_second / $this->moderna_lapu_facility_second * 100  ,2 );
        $this->c_rate_johnson_lapu_facility_second = number_format($this->vcted_johnson_lapu_facility_second / $this->johnson_lapu_facility_second * 100  ,2 );
        $this->total_c_rate_lapu_facility_second = number_format($this->total_vcted_lapu_facility_second / $this->total_lapu_facility_second * 100,2);

        $this->priority_set = "";

        return view( 'vaccine.vaccine_summary_report',$this->tabValueDeclaration());
    }
}




