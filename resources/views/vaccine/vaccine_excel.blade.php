<h4>Grand Total</h4>

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
    <tr>
        <td rowspan="2">
        <p>Sinovac</p>
        </td> <!--SINOVAC -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_a1_excel') }}</td><!-- A1 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_a2_excel') }}</td><!-- A2 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_a3_excel') }}</td><!-- A3 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_a4_excel') }}</td><!-- A4 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_a5_excel') }}</td><!-- A5 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_b1_excel') }}</td><!-- B1 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_b2_excel') }}</td><!-- B2 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_b3_excel') }}</td><!-- B3 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_b4_excel') }}</td><!-- B4 SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_svac_excel') }} </td> <!-- TOTAL ELI POP SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_vallocated_svac_frst_excel') }} </td> <!-- VACCINE ALLOCATED (FD) SINOVAC_FIRST -->
        <td rowspan="2">{{ Session::get('total_vallocated_svac_scnd_excel') }} </td>  <!-- VACCINE ALLOCATED (SD) SINOVAC_FIRST -->
        <td rowspan="2"> {{ Session::get('total_vallocated_frst_svac_excel') }}</td>  <!-- TOTAL VACCINE ALLOCATED SINOVAC_FIRST -->
        <td>
            <span class="label label-success">{{ Session::get('total_svac_a1_frst_excel') }}</span>   <!-- VACCINATED (A1) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_a2_frst_excel') }}</span>  <!-- VACCINATED (A2) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_a3_frst_excel') }}</span>  <!-- VACCINATED (A3) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_a4_frst_excel') }}</span>  <!-- VACCINATED (A4) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_a5_frst_excel') }}</span>  <!-- VACCINATED (A5) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_b1_frst_excel') }}</span>  <!-- VACCINATED (B1) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_b2_frst_excel') }}</span>  <!-- VACCINATED (B2) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_b3_frst_excel') }}</span>  <!-- VACCINATED (B3) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_svac_b4_frst_excel') }}</span>  <!-- VACCINATED (B4) SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success"> {{ Session::get('total_vcted_svac_frst_excel') }}</span>  <!-- TOTAL VACCINATED SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_mild_svac_frst_excel') }}</span>  <!-- MILD SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_srs_svac_frst_excel') }}</span> <!-- SERIOUS SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_dfrd_svac_frst_excel') }}</span> <!-- DEFERRED SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_rfsd_svac_frst_excel') }}</span> <!-- REFUSED SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_wstge_svac_frst_excel') }}</span> <!-- WASTAGE SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_p_cvrge_svac_frst_excel') }}%</span> <!-- PERCENT COVERAGE SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_c_rate_svac_frst_excel') }}%</span> <!-- CONSUMPTION RATE SINOVAC_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_r_unvcted_frst_svac_excel') }}</span> <!-- REMAINING UNVACCINATED SINOVAC_FIRST -->
        </td>
    </tr>
    <tr>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_a1_scnd_excel') }}</span>   <!-- VACCINATED (A1) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_a2_scnd_excel') }}</span> <!-- VACCINATED (A2) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_a3_scnd_excel') }}</span> <!-- VACCINATED (A3) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_a4_scnd_excel') }}</span> <!-- VACCINATED (A4) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_a5_scnd_excel') }}</span> <!-- VACCINATED (A5) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_b1_scnd_excel') }}</span> <!-- VACCINATED (B1) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_b2_scnd_excel') }}</span> <!-- VACCINATED (B2) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_b3_scnd_excel') }}</span> <!-- VACCINATED (B3) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_svac_b4_scnd_excel') }}</span> <!-- VACCINATED (B4) SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_vcted_svac_second_excel') }}</span> <!-- TOTAL VACCINATED SINOVAC_SECOND -->
        </td> <!-- 1-4 -->
        <td>
            <span class="label label-warning">{{ Session::get('total_mild_svac_scnd_excel') }}</span> <!-- MILD SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_srs_svac_scnd_excel') }}</span> <!-- SERIOUS  SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_dfrd_svac_scnd_excel') }}</span> <!-- DEFERRED  SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_rfsd_svac_scnd_excel') }}</span> <!-- REFUSED  SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_wstge_svac_scnd_excel') }}</span> <!-- WASTAGE SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_p_cvrge_svac_scnd_excel')}}%</span> <!-- PERCENT COVERAGE  SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_c_rate_svac_scnd_excel') }}%</span> <!-- CONSUMPTION RATE SINOVAC_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_r_unvcted_scnd_svac_excel') }} </span> <!-- REMAINING UNVACCINATED  SINOVAC_SECOND -->
        </td>
    </tr>
    </tbody>
    <tbody id="collapse_astra_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr >
        <td rowspan="2">
        <p>Astrazeneca</p>
        </td> <!-- 1-5 -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_a1_excel') }}</td>  <!-- A1 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_a2_excel') }}</td>  <!-- A2 ASTRA_FIRST-->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_a3_excel') }}</td>  <!-- A3 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_a4_excel') }}</td>  <!-- A4 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_a5_excel') }}</td>  <!-- A5 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_b1_excel') }}</td>  <!-- B1 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_b2_excel') }}</td>  <!-- B2 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_b3_excel') }}</td>  <!-- B3 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_b4_excel') }}</td>  <!-- B4 ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_e_pop_astra_excel') }} <!-- TOTAL E POP ASTRA_FIRST --></td>
        <td rowspan="2" style="color:black">{{ Session::get('total_vallocated_astra_frst_excel') }}</td> <!-- VACCINE_ALLOCATED (FD) ASTRA_FIRST-->
        <td rowspan="2" style="color:black">{{ Session::get('total_vallocated_astra_scnd_excel') }}</td>  <!-- VACCINE ALLOCATED (SD) ASTRA_FIRST -->
        <td rowspan="2" style="color:black;">{{ Session::get('total_vallocated_frst_astra_excel') }}</td>  <!-- TOTAL VACCINE ALLOCATED ASTRA_FIRST -->
        <td style="color:black;">
            <span class="label label-success">{{ Session::get('total_astra_a1_frst_excel') }}</span>  <!-- VACCINATED (A1) ASTRA_FIRST -->
        </td>
        <td style="color:black">
            <span class="label label-success">{{ Session::get('total_astra_a2_frst_excel') }}</span> <!-- VACCINATED (A2) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_a3_frst_excel') }}</span> <!-- VACCINATED (A3) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_a4_frst_excel') }}</span> <!-- VACCINATED (A4) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_a5_frst_excel') }}</span> <!-- VACCINATED (A5) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_b1_frst_excel') }}</span> <!-- VACCINATED (B1) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_b3_frst_excel') }}</span> <!-- VACCINATED (B2) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_b4_frst_excel') }}</span> <!-- VACCINATED (B3) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_astra_b4_frst_excel') }}</span> <!-- VACCINATED (B4) ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_vcted_astra_frst_excel') }}</span> <!-- TOTAL VACCINATED ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_mild_astra_frst_excel') }}</span> <!-- MILD ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_srs_astra_frst_excel') }}</span> <!-- SERIOUS ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_dfrd_astra_frst_excel') }}</span> <!-- DEFERRED ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_rfsd_astra_frst_excel') }}</span> <!-- REFUSED ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_wstge_astra_frst_excel') }}</span> <!-- WASTAGE ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_p_cvrge_astra_frst_excel') }}%</span> <!-- PERCENT_COVERAGE ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_c_rate_astra_frst_excel') }}%</span> <!-- CONSUMPTION RATE ASTRA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_r_unvcted_frst_astra_excel') }}</span> <!-- REMAINUNG UNVACCINATED ASTRA_FIRST -->
        </td>
    </tr>
    <tr>
        <td style="color: black;">
            <span class="label label-warning">{{ Session::get('total_astra_a1_scnd_excel') }}</span>  <!-- VACCINATED (A1) ASTRA_SECOND -->
        </td>
        <td style="color:black;">
            <span class="label label-warning">{{ Session::get('total_astra_a2_scnd_excel') }}</span>  <!-- VACCINATED (A2) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_a3_scnd_excel') }}</span>  <!-- VACCINATED (A3) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_a4_scnd_excel') }}</span>  <!-- VACCINATED (A4) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_a5_scnd_excel') }}</span>  <!-- VACCINATED (A5) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_b1_scnd_excel') }}</span>  <!-- VACCINATED (B1) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_b2_scnd_excel') }}</span>  <!-- VACCINATED (B2) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_b3_scnd_excel') }}</span>  <!-- VACCINATED (B3) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_astra_b4_scnd_excel') }}</span>  <!-- VACCINATED (B4) ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_vcted_astra_second') }}</span>  <!-- TOTAL VACCINATED ASTRA_SECOND -->
        </td> <!-- 1-6 -->
        <td>
            <span class="label label-warning">{{ Session::get('total_mild_astra_scnd_excel') }}</span>  <!-- MILD ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_srs_astra_scnd_excel') }}</span> <!-- SERIOUS ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_dfrd_astra_scnd_excel') }}</span> <!-- DEFERRED ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_rfsd_astra_scnd_excel') }}</span> <!-- REFUSED ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_wstge_astra_scnd_excel') }}</span> <!-- WASTAGE ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_p_cvrge_astra_scnd_excel') }}%</span> <!-- PERCENT_COVERAGE_ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_c_rate_astra_scnd_excel') }}%</span> <!-- CONSUMPTION RATE ASTRA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_r_unvcted_scnd_astra_excel') }}</span> <!-- REMAINING UNVACCINATED ASTRA_SECOND -->
        </td>
    </tr>
    </tbody>

    <!-- PFIZER -->
    <tbody id="collapse_pfizer_grand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr >
        <td rowspan="2">
        <p>Pfizer</p>
        </td> <!-- 1-5 -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_a1_excel') }}</td><!-- A1 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_a2_excel') }}</td><!-- A2 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_a3_excel') }}</td><!-- A3 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_a4_excel') }}</td><!-- A4 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_a5_excel') }}</td><!-- A5 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_b1_excel') }}</td><!-- B1 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_b2_excel') }}</td><!-- B2 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_b3_excel') }}</td><!-- B3 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_b4_excel') }}</td><!-- B4 PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_pfizer_excel') }} <!-- TOTAL ELI POP PFIZER_FIRST -->
        </td>
        <td rowspan="2">{{ Session::get('total_vallocated_pfizer_frst_excel') }} </td> <!-- VACCINE ALLOCATED (FD) PFIZER_FIRST -->
        <td rowspan="2">{{ Session::get('total_vallocated_pfizer_scnd_excel') }} </td>  <!-- VACCINE ALLOCATED (SD) PFIZER_FIRST -->
        <td rowspan="2"> {{ Session::get('total_vallocated_pfizer_excel') }}</td>  <!-- TOTAL VACCINE ALLOCATED PFIZER_FIRST -->
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_a1_frst_excel') }}</span>   <!-- VACCINATED (A1) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_a2_frst_excel') }}</span>  <!-- VACCINATED (A2) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_a3_frst_excel') }}</span>  <!-- VACCINATED (A3) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_a4_frst_excel') }}</span>  <!-- VACCINATED (A4) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_a5_frst_excel') }}</span>  <!-- VACCINATED (A5) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_b1_frst_excel') }}</span>  <!-- VACCINATED (B1) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_b2_frst_excel') }}</span>  <!-- VACCINATED (B2) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_b3_frst_excel') }}</span>  <!-- VACCINATED (B3) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_pfizer_b4_frst_excel') }}</span>  <!-- VACCINATED (B4) PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_vcted_pfizer_frst_excel') }}</span> <!-- TOTAL VACCINATED PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_mild_pfizer_frst_excel') }}</span> <!-- MILD PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_srs_pfizer_frst_excel') }}</span> <!-- SERIOUS PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_dfrd_pfizer_frst_excel') }}</span> <!-- DEFERRED PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_rfsd_pfizer_frst_excel') }}</span> <!-- REFUSED PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_wstge_pfizer_frst_excel') }}</span> <!-- WASTAGE PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_p_cvrge_pfizer_frst_excel') }}%</span> <!-- PERCENT_COVERAGE PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_c_rate_pfizer_frst_excel') }}%</span> <!-- CONSUMPTION RATE PFIZER_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_r_unvcted_frst_pfizer_excel') }}</span> <!-- REMAINUNG UNVACCINATED PFIZER_FIRST -->
        </td>
    </tr>
    <tr>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_a1_scnd_excel') }}</span>   <!-- VACCINATED (A1) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_a2_scnd_excel') }}</span> <!-- VACCINATED (A2) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_a3_scnd_excel') }}</span> <!-- VACCINATED (A3) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_a4_scnd_excel') }}</span> <!-- VACCINATED (A4) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_a5_scnd_excel') }}</span> <!-- VACCINATED (A4) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_b1_scnd_excel') }}</span> <!-- VACCINATED (A4) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_b2_scnd_excel') }}</span> <!-- VACCINATED (A4) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_b3_scnd_excel') }}</span> <!-- VACCINATED (A4) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_pfizer_b4_scnd_excel') }}</span> <!-- VACCINATED (A4) PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_vcted_pfizer_second_excel') }}</span> <!-- TOTAL VACCINATED PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_mild_pfizer_scnd_excel') }}</span> <!-- MILD PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_srs_pfizer_scnd_excel') }}</span> <!-- SERIOUS  PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_dfrd_pfizer_scnd_excel') }}</span> <!-- DEFERRED  PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_rfsd_pfizer_scnd_excel') }}</span> <!-- REFUSED  PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_wstge_pfizer_scnd_excel') }}</span> <!-- WASTAGE PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_p_cvrge_pfizer_scnd_excel') }}%</span> <!-- PERCENT COVERAGE  PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_c_rate_pfizer_scnd_excel') }}%</span> <!-- CONSUMPTION RATE PFIZER_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_r_unvcted_scnd_pfizer_excel') }} </span> <!-- REMAINING UNVACCINATED  PFIZER_SECOND -->
        </td>
    </tr>
    </tbody>

    <!-- SPUTNIKV -->
    <tbody id="collapse_sputnikv_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr>
        <td rowspan="2">
        <p>SputnikV</p>
        </td> <!-- 1-3 -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_a1_excel') }}</td><!-- A1 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_a2_excel') }}</td><!-- A2 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_a3_excel') }}</td><!-- A3 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_a4_excel') }}</td><!-- A4 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_a5_excel') }}</td><!-- A5 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_b1_excel') }}</td><!-- B1 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_b2_excel') }}</td><!-- B2 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_b3_excel') }}</td><!-- B3 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_b4_excel') }}</td><!-- B4 SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_sputnikv_excel') }} <!-- TOTAL ELI POP SPUTNIKV_FIRST -->
        </td>
        <td rowspan="2">{{ Session::get('total_vallocated_sputnikv_frst_excel') }} </td> <!-- VACCINE ALLOCATED (FD) SPUTNIKV_FIRST -->
        <td rowspan="2">{{ Session::get('total_vallocated_sputnikv_scnd_excel') }} </td>  <!-- VACCINE ALLOCATED (SD) SPUTNIKV_FIRST -->
        <td rowspan="2"> {{ Session::get('total_vallocated_frst_sputnikv_excel') }}</td>  <!-- TOTAL VACCINE ALLOCATED SPUTNIKV_FIRST -->
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_a1_frst_excel') }}</span>   <!-- VACCINATED (A1) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_a2_frst_excel') }}</span>  <!-- VACCINATED (A2) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_a3_frst_excel') }}</span>  <!-- VACCINATED (A3) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_a4_frst_excel') }}</span>  <!-- VACCINATED (A4) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_a5_frst_excel') }}</span>  <!-- VACCINATED (A5) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_b1_frst_excel') }}</span>  <!-- VACCINATED (B1) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_b2_frst_excel') }}</span>  <!-- VACCINATED (B2) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_b3_frst_excel') }}</span>  <!-- VACCINATED (B3) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_sputnikv_b4_frst_excel') }}</span>  <!-- VACCINATED (B4) SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_vcted_sputnikv_frst_excel') }}</span> <!-- TOTAL VACCINATED SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_mild_sputnikv_frst_excel') }}</span> <!-- MILD SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_srs_sputnikv_frst_excel') }}</span> <!-- SERIOUS SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_dfrd_sputnikv_frst_excel') }}</span> <!-- DEFERRED SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_rfsd_sputnikv_frst_excel') }}</span> <!-- REFUSED SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_wstge_sputnikv_frst_excel') }}</span> <!-- WASTAGE SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_p_cvrge_sputnikv_frst_excel') }}%</span> <!-- PERCENT_COVERAGE SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_c_rate_sputnikv_frst_excel') }}%</span> <!-- CONSUMPTION RATE SPUTNIKV_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_r_unvcted_frst_sputnikv_excel') }}</span> <!-- REMAINUNG UNVACCINATED SPUTNIKV_FIRST -->
        </td>
    </tr>
    <tr>
        <td style="color: black;">
            <span class="label label-warning">{{ Session::get('total_sputnikv_a1_scnd_excel') }}</span>  <!-- VACCINATED (A1) SPUTNIKV_SECOND -->
        </td>
        <td style="color:black;">
            <span class="label label-warning">{{ Session::get('total_sputnikv_a2_scnd_excel') }}</span>  <!-- VACCINATED (A2) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_a3_scnd_excel') }}</span>  <!-- VACCINATED (A3) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_a4_scnd_excel') }}</span>  <!-- VACCINATED (A4) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_a5_scnd_excel') }}</span>  <!-- VACCINATED (A5) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_b1_scnd_excel') }}</span>  <!-- VACCINATED (B1) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_b2_scnd_excel') }}</span>  <!-- VACCINATED (B2) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_b3_scnd_excel') }}</span>  <!-- VACCINATED (B3) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_sputnikv_b4_scnd_excel') }}</span>  <!-- VACCINATED (B4) SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_vcted_sputnikv_second_excel') }}</span>  <!-- TOTAL VACCINATED SPUTNIKV_SECOND -->
        </td> <!-- 1-6 -->
        <td>
            <span class="label label-warning">{{ Session::get('total_mild_sputnikv_scnd_excel') }}</span>  <!-- MILD SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_srs_sputnikv_scnd_excel') }}</span> <!-- SERIOUS SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_dfrd_sputnikv_scnd_excel') }}</span> <!-- DEFERRED SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_rfsd_sputnikv_scnd_excel') }}</span> <!-- REFUSED SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_wstge_sputnikv_scnd_excel') }}</span> <!-- WASTAGE SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_p_cvrge_sputnikv_scnd_excel') }}%</span> <!-- PERCENT_COVERAGE_SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_c_rate_sputnikv_scnd_excel') }}%</span> <!-- CONSUMPTION RATE SPUTNIKV_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_r_unvcted_scnd_sputnikv_excel') }}</span> <!-- REMAINING UNVACCINATED SPUTNIKV_SECOND -->
        </td>
    </tr>
    </tbody>
    <!-- MODERNA -->
    <tbody id="collapse_moderna_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr>
        <td rowspan="2">
        <p>Moderna</p>
        </td> <!-- 1-3 -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_a1_excel') }}</td><!-- A1 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_a2_excel') }}</td><!-- A2 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_a3_excel') }}</td><!-- A3 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_a4_excel') }}</td><!-- A4 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_a5_excel') }}</td><!-- A5 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_b1_excel') }}</td><!-- B1 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_b2_excel') }}</td><!-- B2 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_b3_excel') }}</td><!-- B3 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_b4_excel') }}</td><!-- B4 MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_moderna_excel') }} <!-- TOTAL ELI POP MODERNA_FIRST -->
        </td>
        <td rowspan="2">{{ Session::get('total_vallocated_moderna_frst_excel') }} </td> <!-- VACCINE ALLOCATED (FD) MODERNA_FIRST -->
        <td rowspan="2">{{ Session::get('total_vallocated_moderna_scnd_excel') }} </td>  <!-- VACCINE ALLOCATED (SD) MODERNA_FIRST -->
        <td rowspan="2"> {{ Session::get('total_vallocated_frst_moderna_excel') }}</td>  <!-- TOTAL VACCINE ALLOCATED MODERNA_FIRST -->
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_a1_frst_excel') }}</span>   <!-- VACCINATED (A1) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_a2_frst_excel') }}</span>  <!-- VACCINATED (A2) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_a3_frst_excel') }}</span>  <!-- VACCINATED (A3) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_a4_frst_excel') }}</span>  <!-- VACCINATED (A4) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_a5_frst_excel') }}</span>  <!-- VACCINATED (A5) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_b1_frst_excel') }}</span>  <!-- VACCINATED (B1) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_b2_frst_excel') }}</span>  <!-- VACCINATED (B2) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_b3_frst_excel') }}</span>  <!-- VACCINATED (B3) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_moderna_b4_frst_excel') }}</span>  <!-- VACCINATED (B4) MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_vcted_moderna_frst_excel') }}</span> <!-- TOTAL VACCINATED MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_mild_moderna_frst_excel') }}</span> <!-- MILD MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_srs_moderna_frst_excel') }}</span> <!-- SERIOUS MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_dfrd_moderna_frst_excel') }}</span> <!-- DEFERRED MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_rfsd_moderna_frst_excel') }}</span> <!-- REFUSED MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_wstge_moderna_frst_excel') }}</span> <!-- WASTAGE MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_p_cvrge_moderna_frst_excel') }}%</span> <!-- PERCENT_COVERAGE MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_c_rate_moderna_frst_excel') }}%</span> <!-- CONSUMPTION RATE MODERNA_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_r_unvcted_frst_moderna_excel') }}</span> <!-- REMAINUNG UNVACCINATED MODERNA_FIRST -->
        </td>
    </tr>
    <tr>
        <td style="color: black;">
            <span class="label label-warning">{{ Session::get('total_moderna_a1_scnd_excel') }}</span>  <!-- VACCINATED (A1) MODERNA_SECOND -->
        </td>
        <td style="color:black;">
            <span class="label label-warning">{{ Session::get('total_moderna_a2_scnd_excel') }}</span>  <!-- VACCINATED (A2) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_a3_scnd_excel') }}</span>  <!-- VACCINATED (A3) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_a4_scnd_excel') }}</span>  <!-- VACCINATED (A4) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_a5_scnd_excel') }}</span>  <!-- VACCINATED (A5) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_b1_scnd_excel') }}</span>  <!-- VACCINATED (B1) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_b2_scnd_excel') }}</span>  <!-- VACCINATED (B2) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_b3_scnd_excel') }}</span>  <!-- VACCINATED (B3) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_moderna_b4_scnd_excel') }}</span>  <!-- VACCINATED (B4) MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_vcted_moderna_second_excel') }}</span>  <!-- TOTAL VACCINATED MODERNA_SECOND -->
        </td> <!-- 1-6 -->
        <td>
            <span class="label label-warning">{{ Session::get('total_mild_moderna_scnd_excel') }}</span>  <!-- MILD MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_srs_moderna_scnd_excel') }}</span> <!-- SERIOUS MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_dfrd_moderna_scnd_excel') }}</span> <!-- DEFERRED MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_rfsd_moderna_scnd_excel') }}</span> <!-- REFUSED MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_wstge_moderna_scnd_excel') }}</span> <!-- WASTAGE MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_p_cvrge_moderna_scnd_excel') }}%</span> <!-- PERCENT_COVERAGE_MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_c_rate_moderna_scnd_excel') }}%</span> <!-- CONSUMPTION RATE MODERNA_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_r_unvcted_scnd_moderna_excel') }}</span> <!-- REMAINING UNVACCINATED MODERNA_SECOND -->
        </td>
    </tr>
    </tbody>
    <!-- JOHNSON -->
    <tbody id="collapse_johnson_grand" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample">
    <tr >
        <td rowspan="2">
        <p>Jannsen</p>
        </td> <!-- 1-3 -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_a1_excel') }}</td><!-- A1 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_a2_excel') }}</td><!-- A2 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_a3_excel') }}</td><!-- A3 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_a4_excel') }}</td><!-- A4 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_a5_excel') }}</td><!-- A5 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_b1_excel') }}</td><!-- B1 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_b2_excel') }}</td><!-- B2 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_b3_excel') }}</td><!-- B3 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_b4_excel') }}</td><!-- B4 JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_e_pop_johnson_excel') }} <!-- TOTAL ELI POP JOHNSON_FIRST -->
        </td>
        <td rowspan="2">{{ Session::get('total_vallocated_johnson_frst_excel') }} </td> <!-- VACCINE ALLOCATED (FD) JOHNSON_FIRST -->
        <td rowspan="2">{{ Session::get('total_vallocated_johnson_scnd_excel') }} </td>  <!-- VACCINE ALLOCATED (SD) JOHNSON_FIRST -->
        <td rowspan="2"> {{ Session::get('total_vallocated_frst_johnson_excel') }}</td>  <!-- TOTAL VACCINE ALLOCATED JOHNSON_FIRST -->
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_a1_frst_excel') }}</span>   <!-- VACCINATED (A1) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_a2_frst_excel') }}</span>  <!-- VACCINATED (A2) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_a3_frst_excel') }}</span>  <!-- VACCINATED (A3) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_a4_frst_excel') }}</span>  <!-- VACCINATED (A4) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_a5_frst_excel') }}</span>  <!-- VACCINATED (A5) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_b1_frst_excel') }}</span>  <!-- VACCINATED (B1) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_b2_frst_excel') }}</span>  <!-- VACCINATED (B2) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_b3_frst_excel') }}</span>  <!-- VACCINATED (B3) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_johnson_b4_frst_excel') }}</span>  <!-- VACCINATED (B4) JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_vcted_johnson_frst_excel') }}</span> <!-- TOTAL VACCINATED JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_mild_johnson_frst_excel') }}</span> <!-- MILD JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_srs_johnson_frst_excel') }}</span> <!-- SERIOUS JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_dfrd_johnson_frst_excel') }}</span> <!-- DEFERRED JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_rfsd_johnson_frst_excel') }}</span> <!-- REFUSED JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_wstge_johnson_frst_excel') }}</span> <!-- WASTAGE JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_p_cvrge_johnson_frst_excel') }}%</span> <!-- PERCENT_COVERAGE JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_c_rate_johnson_frst_excel') }}%</span> <!-- CONSUMPTION RATE JOHNSON_FIRST -->
        </td>
        <td>
            <span class="label label-success">{{ Session::get('total_r_unvcted_frst_johnson_excel') }}</span> <!-- REMAINUNG UNVACCINATED JOHNSON_FIRST -->
        </td>
    </tr>
    <tr>
        <td style="color: black;">
            <span class="label label-warning">{{ Session::get('total_johnson_a1_scnd_excel') }}</span>  <!-- VACCINATED (A1) JOHNSON_SECOND -->
        </td>
        <td style="color:black;">
            <span class="label label-warning">{{ Session::get('total_johnson_a2_scnd_excel') }}</span>  <!-- VACCINATED (A2) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_a3_scnd_excel') }}</span>  <!-- VACCINATED (A3) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_a4_scnd_excel') }}</span>  <!-- VACCINATED (A4) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_a5_scnd_excel') }}</span>  <!-- VACCINATED (A5) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_b1_scnd_excel') }}</span>  <!-- VACCINATED (B1) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_b2_scnd_excel') }}</span>  <!-- VACCINATED (B2) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_b3_scnd_excel') }}</span>  <!-- VACCINATED (B3) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_johnson_b4_scnd_excel') }}</span>  <!-- VACCINATED (B4) JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_vcted_johnson_second_excel') }}</span>  <!-- TOTAL VACCINATED JOHNSON_SECOND -->
        </td> <!-- 1-6 -->
        <td>
            <span class="label label-warning">{{ Session::get('total_mild_johnson_scnd_excel') }}</span>  <!-- MILD JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_srs_johnson_scnd_excel') }}</span> <!-- SERIOUS JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_dfrd_johnson_scnd_excel') }}</span> <!-- DEFERRED JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_rfsd_johnson_scnd_excel') }}</span> <!-- REFUSED JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_wstge_johnson_scnd_excel') }}</span> <!-- WASTAGE JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_p_cvrge_johnson_scnd_excel') }}%</span> <!-- PERCENT_COVERAGE_JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_c_rate_johnson_scnd_excel') }}%</span> <!-- CONSUMPTION RATE JOHNSON_SECOND -->
        </td>
        <td>
            <span class="label label-warning">{{ Session::get('total_r_unvcted_scnd_johnson_excel') }}</span> <!-- REMAINING UNVACCINATED JOHNSON_SECOND -->
        </td>
    </tr>
    </tbody>

    <tbody>
    <tr>
        <td>Total</td> <!-- 1-7 -->
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
        <td><b>{{ Session::get('total_vallocated_frst_excel') }}</b></td>  <!-- TOTAL VACCINE ALLOCATED FIRST -->
        <td><b>{{ Session::get('total_vallocated_scnd_excel') }}</b></td> <!-- TOTAL VACCINE ALLOCATED SECOND -->
        <td>
            <b>{{ Session::get('total_vallocated_excel') }} </b>  <!-- TOTAL VACCINE ALLOCATED  -->
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a1_first_excel') }}</b> <!-- TOTAL VACCINATED (A1) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a2_first_excel') }}</b>  <!-- TOTAL VACCINATED (A2) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a3_first_excel') }}</b>  <!-- TOTAL VACCINATED (A3) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a4_first_excel') }}</b>  <!-- TOTAL VACCINATED (A4) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a5_first_excel') }}</b>  <!-- TOTAL VACCINATED (A5) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b1_first_excel') }}</b>  <!-- TOTAL VACCINATED (B1) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b2_first_excel') }}</b>  <!-- TOTAL VACCINATED (B2) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b3_first_excel') }}</b>  <!-- TOTAL VACCINATED (B3) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b4_first_excel') }}</b>  <!-- TOTAL VACCINATED (B4) -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_vcted_overall_frst_excel') }}</b>  <!-- TOTAL VACCINATED OVERALL FIRST -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_mild_overall_frst_excel') }}</b>  <!-- TOTAL MILD OVERALL FIRST-->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_srs_overall_frst_excel') }}</b>  <!-- TOTAL SERIOUS OVERALL FIRST -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_dfrd_overall_frst_excel') }}</b>  <!-- TOTAL DEFERRED OVERALL FIRST -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_rfsd_overall_frst_excel') }}</b>  <!-- TOTAL REFUSED OVERALL FIRST-->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_wstge_overall_frst_excel') }}</b>  <!-- TOTAL WASTAGE OVREALL FIRST-->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_p_cvrge_frst_excel') }}%</b>  <!-- TOTAL PERCENT_COVERAGE -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_c_rate_frst_excel') }}% </b>  <!-- TOTAL CONSUMPTION RATE -->
        </td>
        <td>
            <b class="label label-success" style="margin-right: 5%">{{ Session::get('total_r_unvcted_all_frst_excel') }}</b>  <!-- TOTAL REMAINUNG UNVACCINATED  -->
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
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a1_second_excel') }}</b> <!-- TOTAL VACCINATED GRAND A1 SECOND DOSE -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a2_second_excel') }}</b><!-- TOTAL VACCINATED GRAND A2 SECOND DOSE -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a3_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND A3 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a4_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND A4 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_a5_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND A5 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b1_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND B1 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b2_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND B2 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b3_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND B3 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_grand_b4_second_excel') }}</b>  <!-- TOTAL VACCINATED GRAND B4 SECOND DOSE  -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_vcted_overall_second_excel') }}</b> <!-- TOTAL VACCINATED OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_mild_overall_scnd_excel') }}</b> <!-- TOTAL MILD OVERALL SECOND-->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_srs_overall_scnd_excel') }}</b> <!-- TOTAL SERIOUS OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_dfrd_overall_scnd_excel') }}</b> <!-- TOTAL DEFERRED OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_rfsd_overall_frst_excel') }}</b> <!-- TOTAL REFUSED OVERALL SECOND-->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_wstge_overall_scnd_excel') }}</b> <!-- TOTAL WASTAGE OVERALL SECOND-->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_p_cvrge_scnd_excel') }}%</b> <!-- TOTAL PERCENT_COVERAGE OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%"> {{ Session::get('total_c_rate_scnd_excel') }}%</b> <!-- TOTAL CONSUMPTION RATE OVERALL SECOND -->
        </td>
        <td>
            <b class="label label-warning" style="margin-right: 5%">{{ Session::get('total_r_unvcted_all_scnd_excel') }}</b> <!-- TOTAL REMAINING UNVACCIANTED  OVERALL SECOND  -->
        </td>
    </tr>
    </tbody>
</table>