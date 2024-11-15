<tr style="background-color: #ffd8d6">
    <td rowspan="2">
        Sinovac
    </td> <!-- 1-3 -->
    <td rowspan="2" class="total_epop_svac_a1{{ $muncity_id }}">{{ $total_epop_a1 }}</td> <!-- TOTAL_E_POP_FRONTLINE_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_a2{{ $muncity_id }}">{{ $total_epop_a2 }}</td> <!-- E_POP_SENIOR_SINOVAC -->
    <td rowspan="2" class="total_epop_svac_a3{{ $muncity_id }}">{{ $total_epop_a3 }}</td>  <!-- E_POP_A3_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_a4{{ $muncity_id }}">{{ $total_epop_a4 }}</td>  <!-- E_POP_A4_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_a5{{ $muncity_id }}">{{ $total_epop_a5 }}</td>  <!-- E_POP_A5_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_b1{{ $muncity_id }}">{{ $total_epop_b1 }}</td>  <!-- E_POP_B1_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_b2{{ $muncity_id }}">{{ $total_epop_b2 }}</td>  <!-- E_POP_B2_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_b3{{ $muncity_id }}">{{ $total_epop_b3 }}</td>  <!-- E_POP_B3_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac_b4{{ $muncity_id }}">{{ $total_epop_b4 }}</td>  <!-- E_POP_B4_SINOVAC   -->
    <td rowspan="2" class="total_epop_svac{{ $muncity_id }}">{{ $total_epop }}</td> <!-- E_POP_SINOVAC FIRST  -->
    <td rowspan="2" class="total_vallocated_svac_frst{{ $muncity_id }}">{{ $allocated_first }}</td> <!-- VACCINE ALLOCATED_SINOVAC (FD)  -->
    <td rowspan="2" class="total_vallocated_svac_scnd{{ $muncity_id }}">{{ $allocated_second }}</td> <!-- VACCINE ALLOCATED_SINOVAC (SD)  -->
    <td rowspan="2" class="total_vallocated_svac{{ $muncity_id }}">{{ $total_vallocated }}</td>  <!-- TOTAL VACCINE ALLOCATED_SINOVAC   -->
    <td>
        <span class="label label-success total_svac_a1_frst{{ $muncity_id }}">{{ $total_a1_frst }}</span> <!-- A1_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a2_frst{{ $muncity_id }}">{{ $total_a2_frst }}</span> <!-- A2_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a3_frst{{ $muncity_id }}">{{ $total_a3_frst }}</span> <!-- A3_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a4_frst{{ $muncity_id }}">{{ $total_a4_frst }}</span> <!-- A4_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a5_frst{{ $muncity_id }}">{{ $total_a5_frst }}</span> <!-- A5_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b1_frst{{ $muncity_id }}">{{ $total_b1_frst }}</span> <!-- B1_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b2_frst{{ $muncity_id }}">{{ $total_b2_frst }}</span> <!-- B2_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b3_frst{{ $muncity_id }}">{{ $total_b3_frst }}</span> <!-- B3_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b4_frst{{ $muncity_id }}">{{ $total_b4_frst }}</span> <!-- B4_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_vcted_svac_frst{{ $muncity_id }}">{{  $total_vcted_frst }}</span><!-- TOTAL VACCINATED_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_mild_svac_frst{{ $muncity_id }}">{{ $total_mild_frst }}</span> <!-- MILD_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_srs_svac_frst{{ $muncity_id }}">{{ $total_srs_frst }}</span>  <!-- SERIOUS_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_dfrd_svac_frst{{ $muncity_id }}">{{ $total_dfrd_frst }}</span>  <!-- DEFERRED_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_rfsd_svac_frst{{ $muncity_id }}">{{ $total_rfsd_frst }}</span>  <!-- REFUSED_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_wstge_svac_frst{{ $muncity_id }}">{{ $total_wstge_frst }}</span>  <!-- WASTAGF_SINOVAC -->
    </td>
    <td>
        <span class="label label-success p_cvrge_svac_frst{{ $muncity_id }}">{{ number_format($p_cvrge_frst,2) }}%</span>  <!-- PERCENT_COVERAGE_SINOVAC-->
    </td>
    <td>
        <span class="label label-success total_c_rate_svac_frst{{ $muncity_id }}">{{ number_format($total_c_rate_frst,2) }}%</span>  <!-- CONSUMPTION RATE_SINOVAC-->
    </td>
    <td>
        <span class="label label-success total_r_unvcted_frst_svac{{ $muncity_id }}">{{ $total_r_unvcted_frst }}</span>  <!-- REMAINING UNVACCINATED_SINOVAC -->
    </td>
</tr>
<tr style="background-color: #ffd8d6">
    <td>
        <span class="label label-warning total_svac_a1_scnd{{ $muncity_id }}">{{ $total_a1_scnd }}</span>   <!-- A1_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a2_scnd{{ $muncity_id }}">{{ $total_a2_scnd }}</span> <!-- A2_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a3_scnd{{ $muncity_id }}">{{ $total_a3_scnd }}</span> <!-- A3_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a4_scnd{{ $muncity_id }}">{{ $total_a4_scnd }}</span> <!-- A4_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a5_scnd{{ $muncity_id }}">{{ $total_a5_scnd }}</span> <!-- A5_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b1_scnd{{ $muncity_id }}">{{ $total_b1_scnd }}</span> <!-- B1_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b2_scnd{{ $muncity_id }}">{{ $total_b2_scnd }}</span> <!-- B2_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b3_scnd{{ $muncity_id }}">{{ $total_b3_scnd }}</span> <!-- B3_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b4_scnd{{ $muncity_id }}">{{ $total_b4_scnd }}</span> <!-- B4_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_vcted_svac_scnd{{ $muncity_id }}">{{ $total_vcted_scnd }}</span> <!-- TOTAL_VACCINATED_SINOVAC 2-->
    </td> <!-- 1-4 -->
    <td>
        <span class="label label-warning total_mild_svac_scnd{{ $muncity_id }}">{{ $total_mild_scnd }}</span> <!-- MILD_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_srs_svac_scnd{{ $muncity_id }}">{{ $total_srs_scnd }}</span> <!-- SERIOUS_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_dfrd_svac_scnd{{ $muncity_id }}">{{ $total_dfrd_scnd }}</span> <!-- DEFERRED_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_rfsd_svac_scnd{{ $muncity_id }}">{{ $total_rfsd_scnd }}</span> <!-- REFUSED_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_wstge_svac_scnd{{ $muncity_id }}">{{ $total_wstge_scnd }}</span> <!--WASTAGE_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning p_cvrge_svac_scnd{{ $muncity_id }}">{{ number_format($p_cvrge_scnd,2) }}%</span> <!-- PERCENT_COVERAGE_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_c_rate_svac_scnd{{ $muncity_id }}">{{ number_format($total_c_rate_scnd,2) }}%</span> <!-- CONSUMPTION RATE SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_r_unvcted_scnd_svac{{ $muncity_id }}">{{ $total_r_unvcted_scnd }} </span> <!-- REMAINING UNVACCINATED_SINOVAC 2 -->
    </td>
</tr>