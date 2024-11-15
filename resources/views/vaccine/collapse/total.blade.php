<tr style="background-color: white;">
    <td>Total</td> <!-- 1-7 -->
    <td>{{ $total_epop_a1 }}</td> <!-- TOTAL_ELIGIBLE_POP_A1 -->
    <td>{{ $total_epop_a2 }}</td> <!-- TOTAL_ELIGIBLE_POP_A2  -->
    <td>{{ $total_epop_a3 }}</td> <!-- TOTAL_ELIGIBLE_POP_A3  -->
    <td>{{ $total_epop_a4 }}</td> <!-- TOTAL_ELIGIBLE_POP_A4  -->
    <td>{{ $total_epop_a5 }}</td> <!-- TOTAL_ELIGIBLE_POP_A5  -->
    <td>{{ $total_epop_b1 }}</td> <!-- TOTAL_ELIGIBLE_POP_B1  -->
    <td>{{ $total_epop_b2 }}</td> <!-- TOTAL_ELIGIBLE_POP_B2  -->
    <td>{{ $total_epop_b3 }}</td> <!-- TOTAL_ELIGIBLE_POP_B3  -->
    <td>{{ $total_epop_b4 }}</td> <!-- TOTAL_ELIGIBLE_POP_B4  -->
    <td>{{ $total_epop }}</td> <!-- TOTAL_ELIGBLE_POP_OVERALL -->
    <td>
        <b class="total_vallocated_frst{{ $row->id }}">{{ $total_vallocated_overall_frst }}</b> <!-- TOTAL_VACCINE_ALLOCATED_FIRST  -->
    </td>
    <td>
        <b class="total_vallocated_scnd{{ $row->id }}">{{ $total_vallocated_overall_scnd}} </b> <!-- TOTAL_VACCINE_ALLOCATED_SECOND  -->
    </td>
    <td>
        <b class="total_vallocated{{ $row->id }}">{{$total_vallocated_overall }}</b> <!-- TOTAL_VACCINE_ALLOCATED  -->
    </td>
    <td>
        <b class="label label-success total_a1{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a1_frst }}</b> <!-- TOTAL_A1  -->
    </td>
    <td>
        <b class="label label-success total_a2{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a2_frst }}</b> <!-- TOTAL_A2  -->
    </td>
    <td>
        <b class="label label-success total_a3{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a3_frst }}</b> <!-- TOTAL_A3  -->
    </td>
    <td>
        <b class="label label-success total_a4{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a4_frst }}</b> <!-- TOTAL_A4  -->
    </td>
    <td>
        <b class="label label-success total_a5{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a5_frst }}</b> <!-- TOTAL_A5  -->
    </td>
    <td>
        <b class="label label-success total_b1{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b1_frst }}</b> <!-- TOTAL_B1  -->
    </td>
    <td>
        <b class="label label-success total_b2{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b2_frst }}</b> <!-- TOTAL_B2  -->
    </td>
    <td>
        <b class="label label-success total_b3{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b3_frst }}</b> <!-- TOTAL_B3  -->
    </td>
    <td>
        <b class="label label-success total_b4{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b4_frst }}</b> <!-- TOTAL_B4  -->
    </td>
    <td>
        <b class="label label-success total_vcted_frst{{ $row->id }}" style="margin-right: 5%">{{ $total_vcted_overall_frst }}</b> <!-- TOTAL_VACCINATED  -->
    </td>
    <td>
        <b class="label label-success total_mild{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_mild_frst }}</b> <!-- TOTAL_MILD -->
    </td>
    <td>
        <b class="label label-success total_serious{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_srs_frst }}</b>  <!-- TOTAL_SERIOUS -->
    </td>
    <td>
        <b class="label label-success total_deferred{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_dfrd_frst }}</b>  <!-- TOTAL_DEFERRED -->
    </td>
    <td>
        <b class="label label-success total_refused{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_rfsd_frst }}</b>  <!-- TOTAL_REFUSED -->
    </td>
    <td>
        <b class="label label-success total_wastage{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_wstge_frst }}</b>  <!-- TOTAL_WASTAGE -->
    </td>
    <td>
        <b class="label label-success total_p_cvrge_frst{{ $row->id }}" style="margin-right: 5%">{{ number_format($p_cvrge_overall_frst,2) }}%</b>  <!-- TOTAL_PERCENT_COVERAGE -->
    </td>
    <td>
        <b class="label label-success total_c_rate_frst{{ $row->id }}" style="margin-right: 5%">{{ number_format($total_c_rate_overall_frst,2) }}%</b>  <!-- TOTAL CONSUMPTION_RATE -->
    </td>
    <td>
        <b class="label label-success total_r_unvcted_frst{{ $row->id }}" style="margin-right: 5%">{{ $total_r_unvcted_overall_frst }}</b>  <!-- REMAINUNG_UNVACCINATED -->
    </td>
</tr>
<tr style="background-color: white;">
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
        <b class="label label-warning total_overall_a1{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a1_scnd }}</b>  <!-- TOTAL_A1 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_a2{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a2_scnd }}</b>  <!-- TOTAL_A2 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_a3{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a3_scnd }}</b>  <!-- TOTAL_A3 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_a4{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a4_scnd }}</b>  <!-- TOTAL_A4 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_a5{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_a5_scnd }}</b>  <!-- TOTAL_A4 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_b1{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b1_scnd }}</b>  <!-- TOTAL_A4 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_b2{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b2_scnd }}</b>  <!-- TOTAL_A4 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_b3{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b3_scnd }}</b>  <!-- TOTAL_A4 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_b4{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_b4_scnd }}</b>  <!-- TOTAL_A4 - 2 -->
    </td>
    <td>
        <b class="label label-warning total_vcted_scnd{{ $row->id }}" style="margin-right: 5%">{{ $total_vcted_overall_scnd }}</b>  <!-- TOTAL_VACCINATED - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_mild{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_mild_scnd }}</b>  <!-- TOTAL_MILD OVERALL SECOND -->
    </td>
    <td>
        <b class="label label-warning total_overall_serious{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_srs_scnd }}</b> <!-- TOTAL_SERIOUS - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_deferred{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_dfrd_scnd }}</b> <!-- TOTAL_DEFERRED - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_refused{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_rfsd_scnd }}</b> <!-- TOTAL_REFUSED - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_wastage{{ $row->id }}" style="margin-right: 5%">{{ $total_overall_wstge_scnd }}</b> <!-- TOTAL_WASTAGE - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_p_coverage{{ $row->id }}" style="margin-right: 5%">{{number_format($p_cvrge_overall_scnd,2)}}%</b> <!-- TOTAL_PERCENT_COVERAGE - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_c_rate{{ $row->id }}" style="margin-right: 5%">{{ number_format($total_c_rate_overall_scnd,2)}}%</b> <!-- TOTAL_CONSUMPTION_RATE - 2 -->
    </td>
    <td>
        <b class="label label-warning total_overall_r_unvcted{{ $row->id }}" style="margin-right: 5%">{{ $total_r_unvcted_overall_scnd }}</b> <!-- REMAINING_UNVACCINATED - 2 -->
    </td>
</tr>