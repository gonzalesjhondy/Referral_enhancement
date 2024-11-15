<tr style="background-color: #ffd8d6">
    <td rowspan="2">
        Sinovac
    </td> <!-- 1-3 -->
    <td rowspan ="2" class="total_epop_svac_a1{{ $row->id }}">{{ $total_epop_a1 }}</td> <!-- A1 EPOP SINOVAC  -->
    <td rowspan ="2" class="total_epop_svac_a2{{ $row->id }}">{{ $total_epop_a2 }}</td> <!-- A2 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_a3{{ $row->id }}">{{ $total_epop_a3 }}</td> <!-- A3 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_a4{{ $row->id }}">{{ $total_epop_a4 }}</td> <!-- A4 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_a5{{ $row->id }}">{{ $total_epop_a5 }}</td> <!-- A5 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_b1{{ $row->id }}">{{ $total_epop_b1 }}</td> <!-- B1 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_b2{{ $row->id }}">{{ $total_epop_b2 }}</td> <!-- B2 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_b3{{ $row->id }}">{{ $total_epop_b3 }}</td> <!-- B3 EPOP SINOVAC -->
    <td rowspan ="2" class="total_epop_svac_b4{{ $row->id }}">{{ $total_epop_b4 }}</td> <!-- B4 EPOP SINOVAC -->
    <td rowspan="2" class="total_epop_svac{{ $row->id }}">{{ $total_epop }}</td> <!-- E_POP_SINOVAC FIRST  -->
    <td rowspan="2" class="total_vallocated_svac_frst{{ $row->id }}">{{ $allocated_first }}</td> <!-- VACCINE ALLOCATED_SINOVAC (FD)  -->
    <td rowspan="2" class="total_vallocated_svac_scnd{{ $row->id }}">{{ $allocated_second }}</td> <!-- VACCINE ALLOCATED_SINOVAC (SD)  -->
    <td rowspan="2" class="total_vallocated_svac{{ $row->id }}">{{ $total_vallocated }}</td>  <!-- TOTAL VACCINE ALLOCATED_SINOVAC   -->
    <td>
        <span class="label label-success total_svac_a1_frst{{ $row->id }}">{{ $total_a1_frst }}</span> <!-- A1_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a2_frst{{ $row->id }}">{{ $total_a2_frst }}</span> <!-- A2_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a3_frst{{ $row->id }}">{{ $total_a3_frst }}</span> <!-- A3_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a4_frst{{ $row->id }}">{{ $total_a4_frst }}</span> <!-- A4_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_a5_frst{{ $row->id }}">{{ $total_a5_frst }}</span> <!-- A5_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b1_frst{{ $row->id }}">{{ $total_b1_frst }}</span> <!-- B1_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b2_frst{{ $row->id }}">{{ $total_b2_frst }}</span> <!-- B2_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b3_frst{{ $row->id }}">{{ $total_b3_frst }}</span> <!-- B3_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_svac_b4_frst{{ $row->id }}">{{ $total_b4_frst }}</span> <!-- B4_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_vcted_svac_frst{{ $row->id }}">{{  $total_vcted_frst }}</span><!-- TOTAL VACCINATED_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_mild_svac_frst{{ $row->id }}" >{{ $total_mild_frst }}</span> <!-- MILD_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_srs_svac_frst{{ $row->id }}">{{ $total_srs_frst }}</span>  <!-- SERIOUS_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_dfrd_svac_frst{{ $row->id }}">{{ $total_dfrd_frst }}</span>  <!-- DEFERRED_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_rfsd_svac_frst{{ $row->id }}">{{ $total_rfsd_frst }}</span>  <!-- REFUSED_SINOVAC -->
    </td>
    <td>
        <span class="label label-success total_wstge_svac_frst{{ $row->id }}">{{ $total_wstge_frst }}</span>  <!-- WASTAGF_SINOVAC -->
    </td>
    <td>
        <span class="label label-success p_cvrge_svac_frst{{ $row->id }}">{{ number_format($p_cvrge_frst,2) }}%</span>  <!-- PERCENT_COVERAGE_SINOVAC-->
    </td>
    <td>
        <span class="label label-success total_c_rate_svac_frst{{ $row->id }}">{{ number_format($total_c_rate_frst,2) }}%</span>  <!-- CONSUMPTION RATE_SINOVAC-->
    </td>
    <td>
        <span class="label label-success total_r_unvcted_frst_svac{{ $row->id }}">{{ $total_r_unvcted_frst }}</span>  <!-- REMAINING UNVACCINATED_SINOVAC -->
    </td>
</tr>
<tr style="background-color: #ffd8d6">
    <td>
        <span class="label label-warning total_svac_a1_scnd{{ $row->id }}">{{ $total_a1_scnd }}</span>   <!-- A1_SINOVAC2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a2_scnd{{ $row->id }}">{{ $total_a2_scnd }}</span> <!-- A2_SINOVA 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a3_scnd{{ $row->id }}">{{ $total_a3_scnd }}</span> <!-- A3_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a4_scnd{{ $row->id }}">{{ $total_a4_scnd }}</span> <!-- A4_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_a5_scnd{{ $row->id }}">{{ $total_a5_scnd }}</span> <!-- A5_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b1_scnd{{ $row->id }}">{{ $total_b1_scnd }}</span> <!-- B1_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b2_scnd{{ $row->id }}">{{ $total_b2_scnd }}</span> <!-- B2_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b3_scnd{{ $row->id }}">{{ $total_b3_scnd }}</span> <!-- B3_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_svac_b4_scnd{{ $row->id }}">{{ $total_b4_scnd }}</span> <!-- B4_SINOVAC 2 -->
    </td>
    <td>
        <span class="label label-warning total_vcted_svac_scnd{{ $row->id }}">{{ $total_vcted_scnd }}</span> <!-- TOTAL_VACCINATED_SINOVAC 2-->
    </td> <!-- 1-4 -->
    <td>
        <span class="label label-warning total_mild_svac_scnd{{ $row->id }}">{{ $total_mild_scnd }}</span> <!-- MILD_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_srs_svac_scnd{{ $row->id }}">{{ $total_srs_scnd }}</span> <!-- SERIOUS_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_dfrd_svac_scnd{{ $row->id }}">{{ $total_dfrd_scnd }}</span> <!-- DEFERRED_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_rfsd_svac_scnd{{ $row->id }}">{{ $total_rfsd_scnd }}</span> <!-- REFUSED_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_wstge_svac_scnd{{ $row->id }}">{{ $total_wstge_scnd }}</span> <!--WASTAGE_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning p_cvrge_svac_scnd{{ $row->id }}">{{ number_format($p_cvrge_scnd,2) }}%</span> <!-- PERCENT_COVERAGE_SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_c_rate_svac_scnd{{ $row->id }}">{{ number_format($total_c_rate_scnd,2) }}%</span> <!-- CONSUMPTION RATE SINOVAC 2-->
    </td>
    <td>
        <span class="label label-warning total_r_unvcted_scnd_svac{{ $row->id }}">{{ $total_r_unvcted_scnd }} </span> <!-- REMAINING UNVACCINATED_SINOVAC 2 -->
    </td>
</tr>