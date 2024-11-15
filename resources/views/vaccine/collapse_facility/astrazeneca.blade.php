<tr style="background-color: #f2fcac">
    <td rowspan="2" style="color:black;">
        Astrazeneca
    </td>
    <td rowspan="2" style="color:black;" class="total_epop_astra_a1{{ $row->id }}">{{ $total_epop_a1 }}</td>
    <td rowspan="2" style="color:black;" class="total_epop_astra_a2{{ $row->id }}">{{ $total_epop_a2 }}</td>  <!-- A2 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_a3{{ $row->id }}">{{ $total_epop_a3 }}</td>  <!-- A3 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_a4{{ $row->id }}">{{ $total_epop_a4 }}</td>  <!-- A4 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_a5{{ $row->id }}">{{ $total_epop_a5 }}</td>  <!-- A5 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_b1{{ $row->id }}">{{ $total_epop_b1 }}</td>  <!-- B1 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_b2{{ $row->id }}">{{ $total_epop_b2 }}</td>  <!-- B2 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_b3{{ $row->id }}">{{ $total_epop_b3 }}</td>  <!-- B3 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra_b4{{ $row->id }}">{{ $total_epop_b4 }}</td>  <!-- B4 EPOP ASTRA -->
    <td rowspan="2" style="color:black;" class="total_epop_astra{{ $row->id }}">{{ $total_epop }} </td>  <!-- TOTAL_E_POP_ASTRA -->
    <td rowspan="2" style="color:black;" class="total_vallocated_astra_frst{{ $row->id }}">{{ $allocated_first }}</td>  <!-- VACCINE ALLOCATED_ASTRA (FD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_astra_scnd{{ $row->id }}">{{ $allocated_second }}</td>  <!-- VACCINE ALLOCATED_ASTRA (SD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_astra{{ $row->id }}">{{ $total_vallocated }}</td>  <!-- TOTAL VACCINE ALLOCATED_ASTRA -->
    <td style="color:black;">
        <span class="label label-success total_astra_a1_frst{{ $row->id }}">{{ $total_a1_frst }}</span>  <!-- A1_ASTRA  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_astra_a2_frst{{ $row->id }}">{{ $total_a2_frst }}</span>  <!-- A2_ASTRA  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_astra_a3_frst{{ $row->id }}">{{ $total_a3_frst }}</span>  <!-- A3_ASTRA  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_astra_a4_frst{{ $row->id }}">{{ $total_a4_frst }}</span>  <!-- A4_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_astra_a5_frst{{ $row->id }}">{{ $total_a5_frst }}</span>  <!-- A5_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_astra_b1_frst{{ $row->id }}">{{ $total_b1_frst }}</span>  <!-- B1_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_astra_b2_frst{{ $row->id }}">{{ $total_b2_frst }}</span>  <!-- B2_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_astra_b3_frst{{ $row->id }}">{{ $total_b3_frst }}</span>  <!-- B3_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_astra_b4_frst{{ $row->id }}">{{ $total_b4_frst }}</span>  <!-- B4_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_vcted_astra_frst{{ $row->id }}">{{ $total_vcted_frst }}</span>  <!-- TOTAL VACCINATED_ASTRA-->
    </td>
    <td>
        <span class="label label-success total_mild_astra_frst{{ $row->id }}">{{ $total_mild_frst }}</span> <!-- MILD_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_srs_astra_frst{{ $row->id }}">{{ $total_srs_frst }}</span>  <!-- SERIOUS_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_dfrd_astra_frst{{ $row->id }}">{{ $total_dfrd_frst }}</span> <!-- DEFERRED_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_rfsd_astra_frst{{ $row->id }}">{{ $total_rfsd_frst }}</span> <!-- REFUSED_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_wstge_astra_frst{{ $row->id }}">{{ $total_wstge_frst }}</span> <!-- WASTAGE_ASTRA  -->
    </td>
    <td>
        <span class="label label-success p_cvrge_astra_frst{{ $row->id }}">{{ number_format($p_cvrge_astra_frst,2) }}%</span> <!-- PERCENT_COVERAGE_ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_c_rate_astra_frst{{ $row->id }}">{{ number_format($total_c_rate_frst,2) }}%</span> <!-- CONSUMPTION RATE ASTRA  -->
    </td>
    <td>
        <span class="label label-success total_r_unvcted_frst_astra{{ $row->id }}">{{ $total_r_unvcted_frst }}</span> <!-- REMAINUNG UNVACCINATED_ASTRA  -->
    </td>
</tr>
<tr style="background-color: #f2fcac">
    <td style="color: black;">
        <span class="label label-warning total_astra_a1_scnd{{ $row->id }}">{{ $total_a1_scnd }}</span>  <!-- A1_ASTRA2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_astra_a2_scnd{{ $row->id }}">{{ $total_a2_scnd }}</span>  <!-- A2_ASTRA2  -->
    </td>
    <td style="color:black">
        <span class="label label-warning total_astra_a3_scnd{{ $row->id }}">{{ $total_a3_scnd }}</span>  <!-- A3_ASTRA2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_astra_a4_scnd{{ $row->id }}">{{ $total_a4_scnd }}</span>  <!-- A4_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_astra_a5_scnd{{ $row->id }}">{{ $total_a5_scnd }}</span>  <!-- A5_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_astra_b1_scnd{{ $row->id }}">{{ $total_b1_scnd }}</span>  <!-- B1_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_astra_b2_scnd{{ $row->id }}">{{ $total_b2_scnd }}</span>  <!-- B2_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_astra_b3_scnd{{ $row->id }}">{{ $total_b3_scnd }}</span>  <!-- B3_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_astra_b4_scnd{{ $row->id }}">{{ $total_b4_scnd }}</span>  <!-- B4_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_vcted_astra_scnd{{ $row->id }}">{{ $total_vcted_scnd }}</span> <!-- TOTAL VACCINATED_ASTRA 2-->
    </td> <!-- 1-6 -->
    <td>
        <span class="label label-warning total_mild_astra_scnd{{ $row->id }}">{{ $total_mild_scnd }}</span> <!-- MILD_ASTRA 2  -->
    </td>
    <td>
        <span class="label label-warning total_srs_astra_scnd{{ $row->id }}">{{ $total_srs_scnd }}</span> <!-- SERIOUS_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning total_dfrd_astra_scnd{{ $row->id }}">{{ $total_dfrd_scnd }}</span> <!-- DEFERRED_ASTRA 2  -->
    </td>
    <td>
        <span class="label label-warning total_rfsd_astra_scnd{{ $row->id }}">{{ $total_rfsd_scnd }}</span> <!-- REFUSED_ASTRA 2  -->
    </td>
    <td>
        <span class="label label-warning total_wstge_astra_scnd{{ $row->id }}">{{ $total_wstge_scnd }}</span> <!-- WASTAGE_ASTRA2  -->
    </td>
    <td>
        <span class="label label-warning p_cvrge_astra_scnd{{ $row->id }}">{{ number_format($p_cvrge_astra_scnd,2)}}%</span> <!-- PERCENT_COVERAGE_ASTRA 2  -->
    </td>
    <td>
        <span class="label label-warning total_c_rate_astra_scnd{{ $row->id }}">{{ number_format($total_c_rate_astra_scnd,2) }}%</span> <!-- CONSUMPTION_RATE_ASTRA 2  -->
    </td>
    <td>
        <span class="label label-warning total_r_unvcted_scnd_astra{{ $row->id }}">{{ $total_r_unvcted_scnd }}</span> <!-- REMAINUNG_UNVACCIANTED_ASTRA 2  -->
    </td>
</tr>