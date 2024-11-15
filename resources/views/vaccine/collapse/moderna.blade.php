<tr style="background-color: #dad8ff">
    <td rowspan="2">
        Moderna
    </td> <!-- 1-3 -->
    <td rowspan="2" style="color:black;" class="total_epop_moderna_a1{{ $row->id }}">{{ $total_epop_a1 }}</td>  <!-- TOTAL_E_POP_A1_MODERNA -->
    <td rowspan="2" style="color:black;" class="total_epop_moderna_a2{{ $row->id }}">{{ $total_epop_a2 }}</td>  <!-- TOTAL_E_POP_A2_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_a3{{ $row->id }}">{{ $total_epop_a3 }}</td>  <!-- TOTAL_E_POP_A3_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_a4{{ $row->id }}">{{ $total_epop_a4 }}</td>  <!-- TOTAL_E_POP_A4_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_a5{{ $row->id }}">{{ $total_epop_a5 }}</td>  <!-- TOTAL_E_POP_A5_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_b1{{ $row->id }}">{{ $total_epop_b1 }}</td>  <!-- TOTAL_E_POP_B1_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_b2{{ $row->id }}">{{ $total_epop_b2 }}</td>  <!-- TOTAL_E_POP_B2_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_b3{{ $row->id }}">{{ $total_epop_b3 }}</td>  <!-- TOTAL_E_POP_B3_MODERNA -->
    <td rowspan="2" style="color:black" class="total_epop_moderna_b4{{ $row->id }}">{{ $total_epop_b4 }}</td>  <!-- TOTAL_E_POP_B4_MODERNA -->
    <td rowspan="2" style="color:black;" class="total_epop_moderna{{ $row->id }}">{{ $total_epop }} </td>  <!-- TOTAL_E_POP_MODERNA -->
    <td rowspan="2" style="color:black;" class="total_vallocated_moderna_frst{{ $row->id }}">{{ $allocated_first }}</td>  <!-- VACCINE ALLOCATED_MODERNA (FD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_moderna_scnd{{ $row->id }}">{{ $allocated_second }}</td>  <!-- VACCINE ALLOCATED_MODERNA (SD) -->
    <td rowspan="2" style="color:black;" class="total_vallocated_moderna{{ $row->id }}">{{ $total_vallocated }}</td>  <!-- TOTAL VACCINE ALLOCATED_MODERNA -->
    <td style="color:black;">
        <span class="label label-success total_moderna_a1_frst{{ $row->id }}">{{ $total_a1_frst }}</span>  <!-- A1_MODERNA  -->
    </td>
    <td style="color:black">
        <span class="label label-success total_moderna_a2_frst{{ $row->id }}">{{ $total_a2_frst }}</span>  <!-- A2_MODERNA  -->
    </td>
    <td>
        <span class="label label-success total_moderna_a3_frst{{ $row->id }}">{{ $total_a3_frst }}</span>  <!-- A3_MODERNA  -->
    </td>
    <td>
        <span class="label label-success total_moderna_a4_frst{{ $row->id }}">{{ $total_a4_frst }}</span>  <!-- A4_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_moderna_a5_frst{{ $row->id }}">{{ $total_a5_frst }}</span>  <!-- A5_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_moderna_b1_frst{{ $row->id }}">{{ $total_b1_frst }}</span>  <!-- B1_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_moderna_b2_frst{{ $row->id }}">{{ $total_b2_frst }}</span>  <!-- B2_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_moderna_b3_frst{{ $row->id }}">{{ $total_b3_frst }}</span>  <!-- B3_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_moderna_b4_frst{{ $row->id }}">{{ $total_b4_frst }}</span>  <!-- B4_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_vcted_moderna_frst{{ $row->id }}">{{ $total_vcted_frst }}</span> <!-- TOTAL VACCINATED_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_mild_moderna_frst{{ $row->id }}">{{ $total_mild_frst }}</span> <!-- MILD_MODERNA   -->
    </td>
    <td>
        <span class="label label-success total_srs_moderna_frst{{ $row->id }}">{{ $total_srs_frst }}</span> <!-- SERIOUS_MODERNA  -->
    </td>
    <td>
        <span class="label label-success total_dfrd_moderna_frst{{ $row->id }}">{{ $total_dfrd_frst }}</span> <!-- DEFERRED_MODERNA   -->
    </td>
    <td>
        <span class="label label-success total_rfsd_moderna_frst{{ $row->id }}">{{ $total_rfsd_frst }}</span> <!-- REFUSED_MODERNA   -->
    </td>
    <td>
        <span class="label label-success total_wstge_moderna_frst{{ $row->id }}">{{ $total_wstge_frst }}</span> <!-- WASTAGE_MODERNA  -->
    </td>
    <td>
        <span class="label label-success p_cvrge_moderna_frst{{ $row->id }}">{{ number_format($p_cvrge_frst,2)}}%</span> <!-- PERCENT_COVERAGE_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_c_rate_moderna_frst{{ $row->id }}">{{ number_format($total_c_rate_frst,2) }}%</span> <!-- CONSUMPTION_RATE_MODERNA -->
    </td>
    <td>
        <span class="label label-success total_r_unvcted_frst_moderna{{ $row->id }}">{{ $total_r_unvcted_frst }}</span> <!-- REMAINUNG_UNVACCIANTED_MODERNA -->
    </td>
</tr>
<tr style="background-color: #dad8ff">
    <td style="color: black;">
        <span class="label label-warning total_moderna_a1_scnd{{ $row->id }}">{{ $total_a1_scnd }}</span>  <!-- A1_SPUTNIK2  -->
    </td>
    <td style="color:black;">
        <span class="label label-warning total_moderna_a2_scnd{{ $row->id }}">{{ $total_a2_scnd }}</span>  <!-- A2_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_a3_scnd{{ $row->id }}">{{ $total_a3_scnd }}</span>  <!-- A3_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_a4_scnd{{ $row->id }}">{{ $total_a4_scnd }}</span>  <!-- A4_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_a5_scnd{{ $row->id }}">{{ $total_a5_scnd }}</span>  <!-- A5_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_b1_scnd{{ $row->id }}">{{ $total_b1_scnd }}</span>  <!-- B1_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_b2_scnd{{ $row->id }}">{{ $total_b2_scnd }}</span>  <!-- B2_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_b3_scnd{{ $row->id }}">{{ $total_b3_scnd }}</span>  <!-- B3_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_moderna_b4_scnd{{ $row->id }}">{{ $total_b4_scnd }}</span>  <!-- B4_SPUTNIK2   -->
    </td>
    <td>
        <span class="label label-warning total_vcted_moderna_scnd{{ $row->id }}">{{ $total_vcted_scnd }}</span> <!-- TOTAL VACCINATED_MODERNA2-->
    </td>
    <td>
        <span class="label label-warning total_mild_moderna_scnd{{ $row->id }}">{{ $total_mild_scnd }}</span> <!-- MILD_MODERNA2 -->
    </td>
    <td>
        <span class="label label-warning total_srs_moderna_scnd{{ $row->id }}">{{ $total_srs_scnd }}</span> <!-- SERIOUS_MODERNA2 -->
    </td>
    <td>
        <span class="label label-warning total_dfrd_moderna_scnd{{ $row->id }}">{{ $total_dfrd_scnd }}</span> <!-- DEFERRED_MODERNA2  -->
    </td>
    <td>
        <span class="label label-warning total_rfsd_moderna_scnd{{ $row->id }}">{{ $total_rfsd_scnd }}</span> <!-- REFUSED_MODERNA2 -->
    </td>
    <td>
        <span class="label label-warning total_wstge_moderna_scnd{{ $row->id }}">{{ $total_wstge_scnd }}</span> <!-- WASTAGE_MODERNA2  -->
    </td>
    <td>
        <span class="label label-warning p_cvrge_moderna_scnd{{ $row->id }}">{{ number_format($p_cvrge_scnd,2)}}%</span> <!-- PERCENT_COVERAGE_MODERNA2 -->
    </td>
    <td>
        <span class="label label-warning total_c_rate_moderna_scnd{{ $row->id }}">{{ number_format($total_c_rate_scnd,2) }}%</span> <!-- CONSUMPTION_RATE_MODERNA2  -->
    </td>
    <td>
        <span class="label label-warning total_r_unvcted_scnd_moderna{{ $row->id }}">{{ $total_r_unvcted_scnd }}</span> <!-- REMAINUNG_UNVACCIANTED_S2  MODERNA2-->
    </td>
</tr>