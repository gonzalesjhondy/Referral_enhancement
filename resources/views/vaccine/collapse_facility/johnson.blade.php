<tr style="background-color: #9af5ee">
    <td rowspan="2"  style="color:black;">
        Janssen
    </td>
    <td rowspan="2" style="color:black;" class="total_epop_johnson_a1{{ $row->id }}">{{ $total_epop_a1 }}</td>  <!-- A1 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_a2{{ $row->id }}">{{ $total_epop_a2 }}</td>  <!-- A2 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_a3{{ $row->id }}">{{ $total_epop_a3 }}</td>  <!-- A3 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_a4{{ $row->id }}">{{ $total_epop_a4 }}</td>  <!-- A4 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_a5{{ $row->id }}">{{ $total_epop_a5 }}</td>  <!-- A5 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_b1{{ $row->id }}">{{ $total_epop_b1 }}</td>  <!-- B1 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_b2{{ $row->id }}">{{ $total_epop_b2 }}</td>  <!-- B2 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_b3{{ $row->id }}">{{ $total_epop_b3 }}</td>  <!-- B3 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson_b4{{ $row->id }}">{{ $total_epop_b4 }}</td>  <!-- B4 EPOP JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_epop_johnson{{ $row->id }}">{{ $total_epop }} </td>  <!-- TOTAL_E_POP_JOHNSON -->
    <td rowspan="2" style="color:black;" class="total_vallocated_johnson_frst{{ $row->id }}">{{ $allocated_first }}</td>  <!-- VACCINE ALLOCATED_JOHNSON (FD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_johnson_scnd{{ $row->id }}">{{ $allocated_second }}</td>  <!-- VACCINE ALLOCATED_JOHNSON (SD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_johnson{{ $row->id }}">{{ $total_vallocated }}</td>  <!-- TOTAL VACCINE ALLOCATED_JOHNSON -->
    <td style="color:black;">
        <span class="label label-success total_johnson_a1_frst{{ $row->id }}">{{ $total_a1_frst }}</span>  <!-- A1_JOHNSON  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_johnson_a2_frst{{ $row->id }}">{{ $total_a2_frst }}</span>  <!-- A2_JOHNSON  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_johnson_a3_frst{{ $row->id }}">{{ $total_a3_frst }}</span>  <!-- A3_JOHNSON  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_johnson_a4_frst{{ $row->id }}">{{ $total_a4_frst }}</span>  <!-- A4_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_johnson_a5_frst{{ $row->id }}">{{ $total_a5_frst }}</span>  <!-- A5_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_johnson_b1_frst{{ $row->id }}">{{ $total_b1_frst }}</span>  <!-- B1_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_johnson_b2_frst{{ $row->id }}">{{ $total_b2_frst }}</span>  <!-- B2_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_johnson_b3_frst{{ $row->id }}">{{ $total_b3_frst }}</span>  <!-- B3_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_johnson_b4_frst{{ $row->id }}">{{ $total_b4_frst }}</span>  <!-- B4_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_vcted_johnson_frst{{ $row->id }}">{{ $total_vcted_frst }}</span>  <!-- TOTAL VACCINATED_JOHNSON-->
    </td>
    <td>
        <span class="label label-success total_mild_johnson_frst{{ $row->id }}">{{ $total_mild_frst }}</span> <!-- MILD_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_srs_johnson_frst{{ $row->id }}">{{ $total_srs_frst }}</span>  <!-- SERIOUS_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_dfrd_johnson_frst{{ $row->id }}">{{ $total_dfrd_frst }}</span> <!-- DEFERRED_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_rfsd_johnson_frst{{ $row->id }}">{{ $total_rfsd_frst }}</span> <!-- REFUSED_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_wstge_johnson_frst{{ $row->id }}">{{ $total_wstge_frst }}</span> <!-- WASTAGE_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success p_cvrge_johnson_frst{{ $row->id }}">{{ number_format($p_cvrge_frst,2) }}%</span> <!-- PERCENT_COVERAGE_JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_c_rate_johnson_frst{{ $row->id }}">{{ number_format($total_c_rate_frst,2) }}%</span> <!-- CONSUMPTION RATE JOHNSON  -->
    </td>
    <td>
        <span class="label label-success total_r_unvcted_frst_johnson{{ $row->id }}">{{ $total_r_unvcted_frst }}</span> <!-- REMAINUNG UNVACCINATED_JOHNSON  -->
    </td>
</tr>
<tr style="background-color: #9af5ee">
    <td style="color: black;">
        <span class="label label-warning total_johnson_a1_scnd{{ $row->id }}">{{ $total_a1_scnd }}</span>  <!-- A1_JOHNSON 2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_johnson_a2_scnd{{ $row->id }}">{{ $total_a2_scnd }}</span>  <!-- A2_JOHNSON 2  -->
    </td>
    <td style="color:black">
        <span class="label label-warning total_johnson_a3_scnd{{ $row->id }}">{{ $total_a3_scnd }}</span>  <!-- A3_JOHNSON 2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_johnson_a4_scnd{{ $row->id }}">{{ $total_a4_scnd }}</span>  <!-- A4_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_johnson_a5_scnd{{ $row->id }}">{{ $total_a5_scnd }}</span>  <!-- A5_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_johnson_b1_scnd{{ $row->id }}">{{ $total_b1_scnd }}</span>  <!-- B1_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_johnson_b2_scnd{{ $row->id }}">{{ $total_b2_scnd }}</span>  <!-- B2_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_johnson_b3_scnd{{ $row->id }}">{{ $total_b3_scnd }}</span>  <!-- B3_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_johnson_b4_scnd{{ $row->id }}">{{ $total_b4_scnd }}</span>  <!-- B4_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_vcted_johnson_scnd{{ $row->id }}">{{ $total_vcted_scnd }}</span> <!-- TOTAL VACCINATED_JOHNSON 2-->
    </td> <!-- 1-6 -->
    <td>
        <span class="label label-warning total_mild_johnson_scnd{{ $row->id }}">{{ $total_mild_scnd }}</span> <!-- MILD_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_srs_johnson_scnd{{ $row->id }}">{{ $total_srs_scnd }}</span> <!-- SERIOUS_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_dfrd_johnson_scnd{{ $row->id }}">{{ $total_dfrd_scnd }}</span> <!-- DEFERRED_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_rfsd_johnson_scnd{{ $row->id }}">{{ $total_rfsd_scnd }}</span> <!-- REFUSED_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_wstge_johnson_scnd{{ $row->id }}">{{ $total_wstge_scnd }}</span> <!-- WASTAGE_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning p_cvrge_johnson_scnd{{ $row->id }}">{{ number_format($p_cvrge_scnd,2)}}%</span> <!-- PERCENT_COVERAGE_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_c_rate_johnson_scnd{{ $row->id }}">{{ number_format($total_c_rate_scnd,2) }}%</span> <!-- CONSUMPTION_RATE_JOHNSON 2  -->
    </td>
    <td>
        <span class="label label-warning total_r_unvcted_scnd_johnson{{ $row->id }}">{{ $total_r_unvcted_scnd }}</span> <!-- REMAINUNG_UNVACCIANTED_JOHNSON 2  -->
    </td>
</tr>