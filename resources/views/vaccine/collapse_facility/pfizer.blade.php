<tr style="background-color: #8fe7fd">
    <td rowspan="2" style="color:black;">
        Pfizer
    </td>
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_a1{{ $row->id }}">{{ $total_epop_a1 }}</td>  <!-- A1 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_a2{{ $row->id }}">{{ $total_epop_a2 }}</td>  <!-- A2 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_a3{{ $row->id }}">{{ $total_epop_a3 }}</td>  <!-- A3 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_a4{{ $row->id }}">{{ $total_epop_a4 }}</td>  <!-- A4 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_a5{{ $row->id }}">{{ $total_epop_a5 }}</td>  <!-- A5 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_b1{{ $row->id }}">{{ $total_epop_b1 }}</td>  <!-- B1 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_b2{{ $row->id }}">{{ $total_epop_b2 }}</td>  <!-- B2 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_b3{{ $row->id }}">{{ $total_epop_b3 }}</td>  <!-- B3 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer_b4{{ $row->id }}">{{ $total_epop_b4 }}</td>  <!-- B4 EPOP PFIZER -->
    <td rowspan="2" style="color:black;" class="total_epop_pfizer{{ $row->id }}">{{ $total_epop }} </td>  <!-- TOTAL_E_POP_PFIZER -->
    <td rowspan="2" style="color:black;" class="total_vallocated_pfizer_frst{{ $row->id }}">{{ $allocated_first }}</td>  <!-- VACCINE ALLOCATED_PFIZER (FD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_pfizer_scnd{{ $row->id }}">{{ $allocated_first }}</td>  <!-- VACCINE ALLOCATED_PFIZER(SD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_pfizer{{ $row->id }}">{{ $total_vallocated }}</td>  <!-- TOTAL VACCINE ALLOCATED_PFIZER -->
    <td style="color:black;">
        <span class="label label-success total_pfizer_a1_frst{{ $row->id }}">{{ $total_a1_frst }}</span>  <!-- A1_PFIZER  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_pfizer_a2_frst{{ $row->id }}">{{ $total_a2_frst }}</span>  <!-- A2_PFIZER  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_pfizer_a3_frst{{ $row->id }}">{{ $total_a3_frst }}</span>  <!-- A3_PFIZER  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_pfizer_a4_frst{{ $row->id }}">{{ $total_a4_frst }}</span>  <!-- A4_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_pfizer_a5_frst{{ $row->id }}">{{ $total_a5_frst }}</span>  <!-- A5_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_pfizer_b1_frst{{ $row->id }}">{{ $total_b1_frst }}</span>  <!-- B1_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_pfizer_b2_frst{{ $row->id }}">{{ $total_b2_frst }}</span>  <!-- B2_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_pfizer_b3_frst{{ $row->id }}">{{ $total_b3_frst }}</span>  <!-- B3_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_pfizer_b4_frst{{ $row->id }}">{{ $total_b4_frst }}</span>  <!-- B4_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_vcted_pfizer_frst{{ $row->id }}">{{ $total_vcted_frst }}</span>  <!-- TOTAL VACCINATED_PFIZER-->
    </td>
    <td>
        <span class="label label-success total_mild_pfizer_frst{{ $row->id }}">{{ $total_mild_frst }}</span> <!-- MILD_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_srs_pfizer_frst{{ $row->id }}">{{ $total_srs_frst }}</span>  <!-- SERIOUS_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_dfrd_pfizer_frst{{ $row->id }}">{{ $total_dfrd_frst }}</span> <!-- DEFERRED_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_rfsd_pfizer_frst{{ $row->id }}">{{ $total_rfsd_frst }}</span> <!-- REFUSED_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_wstge_pfizer_frst{{ $row->id }}">{{ $total_wstge_frst }}</span> <!-- WASTAGE_PFIZER  -->
    </td>
    <td>
        <span class="label label-success p_cvrge_pfizer_frst{{ $row->id }}">{{ number_format($p_cvrge_pfizer_frst,2) }}%</span> <!-- PERCENT_COVERAGE_PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_c_rate_pfizer_frst{{ $row->id }}">{{ number_format($total_c_rate_pfizer_frst,2) }}%</span> <!-- CONSUMPTION RATE PFIZER  -->
    </td>
    <td>
        <span class="label label-success total_r_unvcted_frst_pfizer{{ $row->id }}">{{ $total_r_unvcted_frst }}</span> <!-- REMAINUNG UNVACCINATED_PFIZER  -->
    </td>
</tr>
<tr style="background-color: #8fe7fd">
    <td style="color: black;">
        <span class="label label-warning total_pfizer_a1_scnd{{ $row->id }}">{{ $total_a1_scnd }}</span>  <!-- A1_PFIZER 2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_pfizer_a2_scnd{{ $row->id }}">{{ $total_a2_scnd }}</span>  <!-- A2_PFIZER 2  -->
    </td>
    <td style="color:black">
        <span class="label label-warning total_pfizer_a3_scnd{{ $row->id }}">{{ $total_a3_scnd }}</span>  <!-- A3_PFIZER 2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_pfizer_a4_scnd{{ $row->id }}">{{ $total_a4_scnd }}</span>  <!-- A4_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_pfizer_a5_scnd{{ $row->id }}">{{ $total_a5_scnd }}</span>  <!-- A5_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_pfizer_b1_scnd{{ $row->id }}">{{ $total_b1_scnd }}</span>  <!-- B1_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_pfizer_b2_scnd{{ $row->id }}">{{ $total_b2_scnd }}</span>  <!-- B2_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_pfizer_b3_scnd{{ $row->id }}">{{ $total_b3_scnd }}</span>  <!-- B3_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_pfizer_b4_scnd{{ $row->id }}">{{ $total_b4_scnd }}</span>  <!-- B4_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_vcted_pfizer_scnd{{ $row->id }}">{{ $total_vcted_scnd }}</span> <!-- TOTAL VACCINATED_PFIZER 2-->
    </td> <!-- 1-6 -->
    <td>
        <span class="label label-warning total_mild_pfizer_scnd{{ $row->id }}">{{ $total_mild_scnd }}</span> <!-- MILD_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_srs_pfizer_scnd{{ $row->id }}">{{ $total_srs_scnd }}</span> <!-- SERIOUS_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_dfrd_pfizer_scnd{{ $row->id }}">{{ $total_dfrd_scnd }}</span> <!-- DEFERRED_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_rfsd_pfizer_scnd{{ $row->id }}">{{ $total_rfsd_scnd }}</span> <!-- REFUSED_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_wstge_pfizer_scnd{{ $row->id }}">{{ $total_wstge_scnd }}</span> <!-- WASTAGE_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning p_cvrge_pfizer_scnd{{ $row->id }}">{{ number_format($p_cvrge_scnd,2)}}%</span> <!-- PERCENT_COVERAGE_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_c_rate_pfizer_scnd{{ $row->id }}">{{ number_format($total_c_rate_scnd,2) }}%</span> <!-- CONSUMPTION_RATE_PFIZER 2  -->
    </td>
    <td>
        <span class="label label-warning total_r_unvcted_scnd_pfizer{{ $row->id }}">{{ $total_r_unvcted_scnd }}</span> <!-- REMAINUNG_UNVACCIANTED_PFIZER 2  -->
    </td>
</tr>