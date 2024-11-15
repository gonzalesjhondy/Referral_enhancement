@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 0px) {
            .modal_w {
                width: 80%;
            }
        }

    </style>

    <div class="box box-success">
        <div class="box-header">
            <form action="{{ asset('vaccine/facility').'/'.$tri_city }}" method="GET">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="typeof_vaccine_filter" id="typeof_vaccine_filter" class="select2">
                                <option value="">Select Type of Vaccine</option>
                                <option value="Sinovac" <?php if(isset($typeof_vaccine_filter)){if($typeof_vaccine_filter == 'Sinovac')echo 'selected';} ?>>Sinovac</option>
                                <option value="Astrazeneca" <?php if(isset($typeof_vaccine_filter)){if($typeof_vaccine_filter == 'Astrazeneca')echo 'selected';} ?>>Astrazeneca</option>
                                <option value="Pfizer" <?php if(isset($typeof_vaccine_filter)){if($typeof_vaccine_filter == 'Pfizer')echo 'selected';} ?>>Pfizer</option>
                                <option value="Sputnikv" <?php if(isset($typeof_vaccine_filter)){if($typeof_vaccine_filter == 'Sputnikv')echo 'selected';} ?>>Sputnikv</option>
                                <option value="Moderna" <?php if(isset($typeof_vaccine_filter)){if($typeof_vaccine_filter == 'Moderna')echo 'selected';} ?>>Moderna</option>
                                <option value="Johnson" <?php if(isset($typeof_vaccine_filter)){if($typeof_vaccine_filter == 'Johnson')echo 'selected';} ?>>Janssen</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="muncity_filter" id="muncity_filter" class="select2">
                                <option value="">Select Tricity</option>
                                @foreach($facility as $row)
                                    <option value="{{ $row->id }}" <?php if(isset($muncity_filter)){if($muncity_filter == $row->id)echo 'selected';} ?> >{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="priority_filter" id="priority_filter" class="select2">
                                <option value="">Select Priority</option>
                                <option value="a1" <?php if(isset($priority_filter)){if($priority_filter == 'a1')echo 'selected';} ?> >A1</option>
                                <option value="a2" <?php if(isset($priority_filter)){if($priority_filter == 'a2')echo 'selected';} ?> >A2</option>
                                <option value="a3" <?php if(isset($priority_filter)){if($priority_filter == 'a3')echo 'selected';} ?> >A3</option>
                                <option value="a4" <?php if(isset($priority_filter)){if($priority_filter == 'a4')echo 'selected';} ?> >A4</option>
                                <option value="a5" <?php if(isset($priority_filter)){if($priority_filter == 'a5')echo 'selected';} ?> >A5</option>
                                <option value="b1" <?php if(isset($priority_filter)){if($priority_filter == 'b1')echo 'selected';} ?> >B1</option>
                                <option value="b2" <?php if(isset($priority_filter)){if($priority_filter == 'b2')echo 'selected';} ?> >B2</option>
                                <option value="b3" <?php if(isset($priority_filter)){if($priority_filter == 'b3')echo 'selected';} ?> >B3</option>
                                <option value="b4" <?php if(isset($priority_filter)){if($priority_filter == 'b4')echo 'selected';} ?> >B4</option>
                                <option value="b5" <?php if(isset($priority_filter)){if($priority_filter == 'b5')echo 'selected';} ?> disabled >B5</option>
                                <option value="b6" <?php if(isset($priority_filter)){if($priority_filter == 'b6')echo 'selected';} ?> disabled >B6</option>
                                <option value="c" <?php if(isset($priority_filter)){if($priority_filter == 'c')echo 'selected';} ?> disabled >C</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="date_range" placeholder="Enter date range.." name="date_range" value="{{ date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)) }}">
                        </div>
                        <div class="col-md-9">
                         <span class="input-group-btn">
                            <button type="submit" class="btn btn-success" onclick="loadPage()"><i class="fa fa-filter"></i> Filter</button>
                            <a href="{{ asset('vaccine/export/excel') }}" type="button" class="btn btn-danger"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            <a href="{{ asset('vaccine/facility').'/'.$tri_city }}" type="button" class="btn btn-warning" onclick="loadPage()"><i class="fa fa-eye"></i> View All</a>
                        </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row" style="padding-left: 1%;padding-right: 1%">
            <div class="col-lg-2 col-xs-6">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="ion ion-erlenmeyer-flask-bubbles"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SINOVAC</span>
                        <span class="info-box-number">+{{$sinovac_allocated_facility}}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                   {{ $sinovac_completion }}% Goal Completion
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="ion ion-erlenmeyer-flask-bubbles"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">ASTRAZENECA</span>
                        <span class="info-box-number">+{{ $astra_allocated_facility }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                    {{ $astra_completion }}% Goal Completion
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="ion ion-erlenmeyer-flask-bubbles"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">PFIZER</span>
                        <span class="info-box-number">+{{ $pfizer_allocated_facility }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                   {{ $pfizer_completion }}% Goal Completion
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="ion ion-erlenmeyer-flask-bubbles"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">SPUTNIKV</span>
                        <span class="info-box-number">+{{ $sputnikv_allocated_facility }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                   {{ $sputnikv_completion }}% Goal Completion
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="info-box bg-purple">
                    <span class="info-box-icon"><i class="ion ion-erlenmeyer-flask-bubbles"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">MODERNA</span>
                        <span class="info-box-number">+{{ $moderna_allocated_facility }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description">
                   {{ $moderna_completion }}% Goal Completion
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="info-box"  style="background: #1d94ff;">
                    <span class="info-box-icon"><i class="ion ion-erlenmeyer-flask-bubbles" style="color:white;"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="color:white;">JANSSEN</span>
                        <span class="info-box-number" style="color:white;">+{{ $johnson_allocated_facility }}</span>
                        <div class="progress">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <span class="progress-description" style="color:white;">
                   {{ $johnson_completion }}% Goal Completion
                  </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
          {{--  <div class="row" style="padding-left: 1%;padding-right: 1%">
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #d0fffe">
                        <span class="info-box-icon" style="background-color: #d0fffe" ><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(A1)</b> </span>
                            <span class="info-box-number">+{{ number_format($a1_target_facility) }}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a1_completion }}%; background-color: #514f4f;"></div>
                            </div>
                            <span class="progress-description">
                    {{ $a1_completion_facility }}% Goal Completion
                </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #e4ffde" >
                        <span class="info-box-icon" style="background-color: #e4ffde" ><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(A2)</b> </span>
                            <span class="info-box-number">+{{ number_format($a2_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a2_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $a2_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #d0fffe">
                        <span class="info-box-icon" style="background-color: #d0fffe"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(A3)</b> </span>
                            <span class="info-box-number">+{{ number_format($a3_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a3_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $a3_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #e4ffde">
                        <span class="info-box-icon" style="background-color: #e4ffde"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(A4)</b> </span>
                            <span class="info-box-number">+{{ number_format($a4_target_facility) }}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $a4_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #d0fffe">
                        <span class="info-box-icon" style="background-color: #d0fffe"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(A5)</b> </span>
                            <span class="info-box-number">+{{ number_format($a5_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $a5_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #e4ffde">
                        <span class="info-box-icon" style="background-color: #e4ffde"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(B1)</b> </span>
                            <span class="info-box-number">+{{ number_format($b1_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $b1_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #d0fffe">
                        <span class="info-box-icon" style="background-color: #d0fffe"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(B2)</b> </span>
                            <span class="info-box-number">+{{ number_format($b2_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $b2_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #e4ffde">
                        <span class="info-box-icon" style="background-color: #e4ffde"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(B3)</b> </span>
                            <span class="info-box-number">+{{ number_format($b3_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $b3_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #d0fffe">
                        <span class="info-box-icon" style="background-color: #d0fffe"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(B4)</b> </span>
                            <span class="info-box-number">+{{ number_format($b4_target_facility) }}</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        {{ $b4_completion_facility }}% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #e4ffde">
                        <span class="info-box-icon" style="background-color: #e4ffde"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(B5)</b> </span>
                            <span class="info-box-number">+0</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        0% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #d0fffe">
                        <span class="info-box-icon" style="background-color: #d0fffe"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(B6)</b> </span>
                            <span class="info-box-number">+0</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        0% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="info-box" style="background-color: #e4ffde">
                        <span class="info-box-icon" style="background-color: #e4ffde"><i class="ion ion-ios-medkit-outline"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text" style="font-size: 9.5pt;">Target vaccination  <b>(C)</b> </span>
                            <span class="info-box-number">+0</span>

                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $a4_completion }}%; background-color: #514f4f"></div>
                            </div>
                            <span class="progress-description">
                        0% Goal Completion
                    </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
            </div>--}}

        <div class="box-body">
            @if(count($data)>0)
                <div class="row">
                    <div class="col-md-9">
                        <table>
                            @foreach($data as $row)
                                <?php

                                ?>
                                <br>
                                <tr>
                                    <td style="white-space: nowrap;" colspan="12">
                                        <b>
                                            <a class="text-green" style= "font-size:14pt;cursor: pointer; " onclick="facilityVaccinated('<?php echo $row->id; ?>','<?php echo $tri_city?>','<?php echo $date_start; ?>','<?php echo $date_end; ?>',$(this),
                                                    '<?php echo $row->sinovac_allocated_first ?>','<?php echo $row->sinovac_allocated_second?>','<?php echo $row->astrazeneca_allocated_first?>','<?php echo $row->astrazeneca_allocated_second?>',
                                                    '<?php echo $row->pfizer_allocated_first ?>','<?php echo $row->pfizer_allocated_second?>','<?php echo $row->sputnikv_allocated_first?>','<?php echo $row->sputnikv_allocated_second?>',
                                                    '<?php echo $row->moderna_allocated_first ?>','<?php echo $row->moderna_allocated_second?>','<?php echo $row->johnson_allocated_first?>','<?php echo $row->johnson_allocated_second?>')">
                                                {{ $row->name }}
                                            </a>
                                        </b>
                                            <button class="btn btn-sm btn-link collapsed" style="color: red;" type="button" data-toggle="collapse" data-target="#collapse_sinovac{{ $row->id }}" aria-expanded="false" aria-controls="collapse_sinovac{{ $tricity_id }}"   onclick="dataCollapseFac('sinovac','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id; ?>','<?php echo $typeof_vaccine_filter?>','<?php echo $row->sinovac_allocated_first?>','<?php echo $row->sinovac_allocated_second?>')">
                                                <b>Sinovac</b>
                                            </button>
                                            <button class="btn btn-sm btn-link collapsed" style="color: darkgoldenrod;" type="button" data-toggle="collapse" data-target="#collapse_astrazeneca{{ $row->id }}" aria-expanded="false" aria-controls="collapse_astrazeneca{{ $tricity_id }}" onclick="dataCollapseFac('astrazeneca','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id; ?>','<?php echo $typeof_vaccine_filter?>','<?php echo $row->astrazeneca_allocated_first?>','<?php echo $row->astrazeneca_allocated_second?>')">
                                                <b>Astrazeneca</b>
                                            </button>
                                            <button class="btn btn-sm btn-link collapsed" style="color: #00c0ef;" type="button" data-toggle="collapse" data-target="#collapse_pfizer{{ $row->id }}" aria-expanded="false" aria-controls="collapse_pfizer{{ $tricity_id }}" onclick="dataCollapseFac('pfizer','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id; ?>','<?php echo $typeof_vaccine_filter?>','<?php echo $row->pfizer_allocated_first?>','<?php echo $row->pfizer_allocated_second?>')">
                                                 <b>Pfizer</b>
                                            </button>
                                            <button class="btn btn-sm btn-link collapsed" style="color: #00a65a;" type="button" data-toggle="collapse" data-target="#collapse_sputnikv{{ $row->id }}" aria-expanded="false" aria-controls="collapse_sputnikv{{ $tricity_id }}" onclick="dataCollapseFac('sputnikv','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id;?>','<?php echo $typeof_vaccine_filter?>','<?php echo $row->sputnikv_allocated_first?>','<?php echo $row->sputnikv_allocated_second?>')">
                                                <b>SputnikV</b>
                                            </button>
                                            <button class="btn btn-sm btn-link collapsed" style="color: #605ca8;" type="button" data-toggle="collapse" data-target="#collapse_moderna{{ $row->id }}" aria-expanded="false" aria-controls="collapse_moderna{{ $tricity_id }}" onclick="dataCollapseFac('moderna','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id; ?>','<?php echo $typeof_vaccine_filter?>','<?php echo $row->moderna_allocated_first?>','<?php echo $row->moderna_allocated_second?>')">
                                                <b>Moderna</b>
                                            </button>
                                            <button class="btn btn-sm btn-link collapsed" style="color: #1d94ff;" type="button" data-toggle="collapse" data-target="#collapse_johnson{{ $row->id }}" aria-expanded="false" aria-controls="collapse_johnson{{ $tricity_id }}" onclick="dataCollapseFac('johnson','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id; ?>','<?php echo $typeof_vaccine_filter?>','<?php echo $row->johnson_allocated_first?>','<?php echo $row->johnson_allocated_second?>')" >
                                                 <b>Janssen</b>
                                            </button>
                                            <button class="btn btn-xs btn-link collapsed" style="color: black;" type="button" data-toggle="collapse" data-target="#collapse_total{{ $row->id }}" aria-expanded="false" aria-controls="collapse_total{{ $tricity_id }}" onclick="dataCollapseFac('total','<?php echo $province_id?>','<?php echo $row->id ?>','<?php echo $tricity_id; ?>','<?php echo $typeof_vaccine_filter?>')">
                                                <b>Overall Total</b>
                                            </button>
                                          {{-- <button class="btn btn-xs" style="color: black;" >
                                                <h8>TOTAL ALLOCATED: <b style="font-size: 15px; color: #137fb1" class="individual_allocated{{ $row->id }}"> {{ $total_vallocated }}</b></h8>
                                            </button>
                                            <button class="btn btn-xs" style="color: black;" type="button">
                                                <h8>GOAL COMPLETION: <b style="font-size: 15px; color:#00a65a;" class="goal_completion {{ $row->id }}"><i class="fa fa-thumbs-up " style="color:#00a65a;"> </i>  {{ number_format($total_vcted_overall_scnd / $total_vallocated * 100 ),2 }}%   </b></h8>
                                            </button>--}}
                                        <br>
                                        <!--
                                        @foreach(\App\VaccineAccomplished::where("facility_id",$row->id)->whereBetween("date_first",[$date_start,$date_end])->orderBy("date_first","asc")->get() as $x)
                                            <span class="badge bg-blue">
                                                {{ date("F d,Y",strtotime($x->date_first)) }}
                                            </span>
                                            <?php $count++; ?>
                                            @if($count == 12)
                                                <br>
                                                <?php $count = 0; ?>
                                            @endif
                                        @endforeach -->
                                    </td>
                                </tr>
                        </table>
                        <div class="table-responsive">
                            <table>
                                <tr>
                                    <td colspan="14">
                                        <table style="font-size: 8pt;" class="table" border="2">
                                            <br>
                                            <tbody><tr>
                                                <th>Type of Vaccine</th> <!-- Type of Vaccine 1-1 -->
                                                <th colspan="10">
                                                    <center><a
                                                                href="#facility_modal"
                                                                data-toggle="modal"
                                                                onclick="facilityBody('<?php echo $province_id; ?>','<?php echo $row->id; ?>')"
                                                        >
                                                            Eligible Population
                                                        </a></center>
                                                </th>
                                                <th colspan="3">
                                                    <center><a
                                                                href="#vaccine_facility_allocated"
                                                                data-toggle="modal"
                                                                onclick="vaccineFacilityAllocated('<?php echo $row->province; ?>','<?php echo $row->id; ?>')"
                                                        >
                                                            Vaccine Allocated
                                                        </a></center>
                                                </th>
                                                <th colspan="10"><center>Total Vaccinated</center></th>
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
                                            <tbody id="collapse_sinovac{{ $row->id }}" class="collapse bg-danger" aria-labelledby="headingTwo" data-parent="#accordionExample"></tbody>
                                            <tbody id="collapse_astrazeneca{{ $row->id }}" class="collapse bg-primary" aria-labelledby="headingTwo" data-parent="#accordionExample"></tbody>
                                            <tbody id="collapse_pfizer{{ $row->id }}" class="collapse bg-primary" aria-labelledby="headingTwo" data-parent="#accordionExample"></tbody>
                                            <tbody id="collapse_sputnikv{{ $row->id }}" class="collapse bg-primary" aria-labelledby="headingTwo" data-parent="#accordionExample"></tbody>
                                            <tbody id="collapse_moderna{{ $row->id }}" class="collapse bg-primary" aria-labelledby="headingTwo" data-parent="#accordionExample"></tbody>
                                            <tbody id="collapse_johnson{{ $row->id }}" class="collapse bg-primary" aria-labelledby="headingTwo" data-parent="#accordionExample"></tbody >
                                            <tbody id="collapse_total{{ $row->id }}" class="collapse bg-primary" aria-labelledby="headingTwo" data-parent="#accordionExample" style="color:black;"></tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @endforeach
                        <div>
                            {{ $data->links() }}
                        </div>
                        <div class="table-responsive">
                        @include('vaccine.vaccine_facility_overall')
                        </div>
                    </div>
                    <div class="col-md-3" style="padding-right: 2%">
                        <div id="chartContainer1" style="height: 370px; width: 100%;"></div><br><br><br>
                        <div id="chartContainer2" style="height: 370px; width: 100%;"></div><br><br><br>
                        <div id="chartPercentCoverage" style="height: 370px; width: 100%;"></div><br><br><br>
                        <div id="chartConsumptionRate" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                @else
                    <div class="alert alert-warning">
                    <span class="text-warning">
                        <i class="fa fa-warning"></i> No Facility Found!
                    </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade"  role="dialog" data-backdrop="static" data-keyboard="false" id="vaccine_modal_facility" style="min-width: 100%">
        <div class="modal-dialog modal-lg modal_w" role="document">
            <div class="modal-content">
                <div class="modal-body vaccinated_content_facility">

                </div><!-- /.modal-content -->
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" role="dialog" id="vaccine_facility_allocated">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body vaccine_facility_allocated">
                    <center>
                        <img src="{{ asset('resources/img/loading.gif') }}" alt="">
                    </center>
                </div><!-- /.modal-content -->
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    @include('admin.modal.facility_modal')
@endsection
@section('js')
    @include('script.chart')
    <script>
        $('#date_range').daterangepicker();
        $(".sinovac_dashboard").text({{ Session::get("sinovac_dashboard") }});
        $(".astra_dashboard").text({{ Session::get("astra_dashboard") }});
        $(".pfizer_dashboard").text({{ Session::get("pfizer_dashboard") }});
        $(".sputnikv_dashboard").text({{ Session::get("sputnikv_dashboard") }});
        $(".moderna_dashboard").text({{ Session::get("moderna_dashboard") }});
        $(".johnson_dashboard").text({{ Session::get("johnson_dashboard") }});


        <?php $user = Session::get('auth'); ?>


        function dataCollapseFac(typeof_vaccine,province_id,facility_id,tricity_id,typeof_vaccine_filter,allocated_first,allocated_second){
            var path_gif = "<?php echo asset('resources/img/spin.gif'); ?>";
            var loading = '<center><img src="'+path_gif+'" alt="" style="height: 60px;"></center>';
            $("#collapse_"+typeof_vaccine+facility_id).html("<tr><td colspan='40' style='background: #f4f4f4;' >"+loading+"</td></tr>");
            var url = "<?php echo asset('vaccine/collapse_facility'); ?>";
            var json = {
                "_token" : "<?php echo csrf_token()?>",
                "typeof_vaccine": typeof_vaccine,
                "province_id" : province_id,
                "facility_id" : facility_id,
                "tricity_id" : tricity_id,
                "typeof_vaccine_filter" : typeof_vaccine_filter,
                "allocated_first": allocated_first,
                "allocated_second": allocated_second,
            };
            console.log(json);
            $.post(url,json,function(data){
                setTimeout(function(){
                    $("#collapse_"+typeof_vaccine+facility_id).html(data);

                },500);
            });
        }



        function facilityVaccinated(facility_id,tri_city,date_start,date_end,data,sinovac_allocated_first,sinovac_allocated_second,astrazeneca_allocated_first,astrazeneca_allocated_second,
                                    pfizer_allocated_first,pfizer_allocated_second,sputnikv_allocated_first,sputnikv_allocated_second,moderna_allocated_first,moderna_allocated_second,
                                    johnson_allocated_first,johnson_allocated_second){
            event.preventDefault();
            $("#vaccine_modal_facility").modal('show');
            $(".vaccinated_content_facility").html(loading);
            $("a").css("background-color","");
            data.css("background-color","yellow");

            json = {
                "_token" : "<?php echo csrf_token()?>",
                "facility_id" : facility_id,
                "tri_city" : tri_city,
                "date_start": date_start,
                "date_end" : date_end,
                "sinovac_allocated_first": sinovac_allocated_first,
                "sinovac_allocated_second": sinovac_allocated_second,
                "astrazeneca_allocated_first": astrazeneca_allocated_first,
                "astrazeneca_allocated_second": astrazeneca_allocated_second,
                "pfizer_allocated_first": pfizer_allocated_first,
                "pfizer_allocated_second": pfizer_allocated_second,
                "sputnikv_allocated_first": sputnikv_allocated_first,
                "sputnikv_allocated_second": sputnikv_allocated_second,
                "moderna_allocated_first": moderna_allocated_first,
                "moderna_allocated_second": moderna_allocated_second,
                "johnson_allocated_first": johnson_allocated_first,
                "johnson_allocated_second": johnson_allocated_second,
                "tricity_id": "<?php echo $tri_city; ?>",
                "typeof_vaccine_filter": "<?php echo $typeof_vaccine_filter; ?>",
                "priority_filter" : "<?php echo $priority_filter; ?>",
                "muncity_filter" : "<?php echo $muncity_filter; ?>",
                "pagination_table" : "false",
            };
            var url = "<?php echo asset('vaccine/facility_content'); ?>";
            $.post(url,json,function(data){
                setTimeout(function(){
                    $(".vaccinated_content_facility").html(data);
                    $(".select2").select2({ width: '100%' });
                },500);
            });
        }

        function facilityBody(province_id,facility_id){
            var json;
            if(facility_id == 'empty'){
                json = {
                    "province_id" : province_id,
                    "_token" : "<?php echo csrf_token()?>"
                };
            } else {
                json = {
                    "province_id" : province_id,
                    "facility_id" : facility_id ,
                    "_token" : "<?php echo csrf_token()?>"
                };
            }
            var url = "<?php echo asset('vaccine/facility_eligible_pop') ?>";
            $.post(url,json,function(result){
                $(".facility_body").html(result);
            })
        }

        function vaccineFacilityAllocated(province_id,facility_id){
            var url = "<?php echo asset('vaccine/facility_allocated'); ?>";
            json = {
                "province_id" : province_id,
                "facility_id" : facility_id ,
                "_token" : "<?php echo csrf_token()?>"
            };
            $.post(url,json,function(result){
                console.log(result);
                $(".vaccine_facility_allocated").html(result);
            })
        }

        function MunicipalityDelete(muncity_id){
            $(".muncity_id").val(muncity_id);
        }

        @if(Session::get('municipality'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("municipality_message"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("municipality",false);
        Session::put("municipality_message",false)
        ?>
        @endif

        @if(Session::get("vaccine_saved"))
        <?php
        Session::put('vaccine_saved',false);
        ?>
        Lobibox.notify('success', {
            size: 'mini',
            rounded: true,
            msg: 'Your vaccination record is successfully saved!'
        });
        @endif

        window.onload = function() {

            var sinovac_dashboard = <?php if(Session::get('sinovac_dashboard')) echo Session::get('sinovac_dashboard'); else echo 0; ?>;
            var astra_dashboard = <?php if(Session::get('astra_dashboard')) echo Session::get('astra_dashboard'); else echo 0; ?>;
            var pfizer_dashboard = <?php if(Session::get('pfizer_dashboard')) echo Session::get('pfizer_dashboard'); else echo 0; ?>;
            var sputnikv_dashboard = <?php if(Session::get('sputnikv_dashboard')) echo Session::get('sputnikv_dashboard'); else echo 0; ?>;
            var moderna_dashboard = <?php if(Session::get('moderna_dashboard')) echo Session::get('moderna_dashboard'); else echo 0; ?>;
            var johnson_dashboard = <?php if(Session::get('johnson_dashboard')) echo Session::get('johnson_dashboard'); else echo 0; ?>;

            var options1 = {
                title: {
                    text: "Type of Vaccine"
                },
                animationEnabled: true,
                data: [
                    {
                        // Change type to "doughnut", "line", "splineArea", etc.
                        type: "column",
                        dataPoints: [
                            { label: "Sinovac",  y: sinovac_dashboard, color: "#dd4b39" },
                            { label: "AstraZeneca", y: astra_dashboard, color: "#f39c12" },
                            { label: "Pfizer",  y: pfizer_dashboard, color:"#00c0ef"  },
                            { label: "Sputnik V", y: sputnikv_dashboard, color:"#00a65a"  },
                            { label: "Moderna", y: moderna_dashboard, color:"#605ca8"  },
                            { label: "Johnson", y: johnson_dashboard, color:"#1d94ff"  }
                        ]

                    }
                ]

            };

            $("#chartContainer1").CanvasJSChart(options1);

            var a1_dashboard = <?php if(Session::get('a1_dashboard')) echo Session::get('a1_dashboard'); else echo 0; ?>;
            var a2_dashboard = <?php if(Session::get('a2_dashboard')) echo Session::get('a2_dashboard'); else echo 0; ?>;
            var a3_dashboard = <?php if(Session::get('a3_dashboard')) echo Session::get('a3_dashboard'); else echo 0; ?>;
            var a4_dashboard = <?php if(Session::get('a4_dashboard')) echo Session::get('a4_dashboard'); else echo 0; ?>;
            var a5_dashboard = <?php if(Session::get('a5_dashboard')) echo Session::get('a5_dashboard'); else echo 0; ?>;
            var b1_dashboard = <?php if(Session::get('b1_dashboard')) echo Session::get('b1_dashboard'); else echo 0; ?>;
            var b2_dashboard = <?php if(Session::get('b2_dashboard')) echo Session::get('b2_dashboard'); else echo 0; ?>;
            var b3_dashboard = <?php if(Session::get('b3_dashboard')) echo Session::get('b3_dashboard'); else echo 0; ?>;
            var b4_dashboard = <?php if(Session::get('b4_dashboard')) echo Session::get('b4_dashboard'); else echo 0; ?>;

            var options2 = {
                title: {
                    text: "Priority"
                },
                animationEnabled: true,
                data: [
                    {
                        // Change type to "doughnut", "line", "splineArea", etc.
                        type: "column",
                        dataPoints: [
                            { label: "(A1)",  y: a1_dashboard },
                            { label: "(A2)",  y: a2_dashboard },
                            { label: "(A3)",  y: a3_dashboard },
                            { label: "(A4)",  y: a4_dashboard },
                            { label: "(A5)",  y: a5_dashboard },
                            { label: "(B1)",  y: b1_dashboard },
                            { label: "(B2)",  y: b2_dashboard },
                            { label: "(B3)",  y: b3_dashboard },
                            { label: "(B4)",  y: b4_dashboard }

                        ]
                    }
                ]
            };
            $("#chartContainer2").CanvasJSChart(options2);


            var percent_coverage_dashboard_first = <?php if(Session::get('percent_coverage_dashboard_first')) echo Session::get('percent_coverage_dashboard_first'); else echo 0; ?>;
            var percent_coverage_dashboard_second = <?php if(Session::get('percent_coverage_dashboard_second')) echo Session::get('percent_coverage_dashboard_second'); else echo 0; ?>;
            var options3 = {
                title: {
                    text: "Percentage Coverage",
                    fontSize: 23,
                },
                animationEnabled: true,
                data: [{
                    type: "doughnut",
                    startAngle: 45,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabel: "{label} ({y}%)",
                    yValueFormatString:"##0.00\"\"",
                    dataPoints: [
                        { label: "First Dose", y: percent_coverage_dashboard_first, color:"#00a65a" },
                        { label: "Second Dose", y: percent_coverage_dashboard_second, color:"#f39c12" },

                    ]
                }]
            };
            $("#chartPercentCoverage").CanvasJSChart(options3);

            var consumption_rate_dashboard_first = <?php if(Session::get('consumption_rate_dashboard_first')) echo Session::get('consumption_rate_dashboard_first'); else echo 0; ?>;
            var consumption_rate_dashboard_second = <?php if(Session::get('consumption_rate_dashboard_second')) echo Session::get('consumption_rate_dashboard_second'); else echo 0; ?>;

            console.log(consumption_rate_dashboard_first);
            console.log(consumption_rate_dashboard_second);

            var options4 = {
                title: {
                    text: "Consumption Rate",
                    fontSize: 23,
                },
                animationEnabled: true,
                data: [{
                    type: "doughnut",
                    startAngle: 45,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabel: "{label} ({y}%)",
                    yValueFormatString:"##0.00\"\"",
                    dataPoints: [
                        { label: "First Dose", y: consumption_rate_dashboard_first, color:"#00a65a" },
                        { label: "Second Dose", y: consumption_rate_dashboard_second, color:"#f39c12" },

                    ]
                }]
            };
            $("#chartConsumptionRate").CanvasJSChart(options4);
        };

    </script>

@endsection
