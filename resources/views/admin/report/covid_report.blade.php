<?php
$user = Session::get('auth');

$start = \Illuminate\Support\Facades\Session::get('startDateCovidReport');
$end = \Illuminate\Support\Facades\Session::get('endDateCovidReport');

if(!$start)
    $start = \Carbon\Carbon::now()->startOfYear()->format('m/d/Y');

if(!$end)
    $end = \Carbon\Carbon::now()->endOfYear()->format('m/d/Y');

$start = \Carbon\Carbon::parse($start)->format('m/d/Y');
$end = \Carbon\Carbon::parse($end)->format('m/d/Y');

$province_name = \App\Province::select('description')->where('id',$province)->first()->description;
?>
@extends('layouts.app')

@section('content')
    <style>
        label {
            padding: 0px !important;
        }

        .refer {
            background-color: #87cefabd;
        }

        .discharged {
            background: lightgreen;
        }

        .clinic_stat {
            background: #f6edc9;
        }
    </style>

    <div class="row col-md-12">
        <div class="box box-success">
            <div class="row">
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3> COVID REPORT <br />
                            <small class="text-success">
                                {{ strtoupper($province_name) }} PROVINCE
                            </small>
                        </h3><br>
                        <form action="{{ asset('admin/report/covid').'/'.$province }}" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group-sm" style="margin-bottom: 10px;">
                                <input type="text" class="form-control" name="date_range" value="{{ $start.' - '.$end }}" id="date_range">
                                <button type="submit" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <section class="content" style="height: auto !important; min-height: 0px !important;margin-top: 10px;">
                        <div class="row">
                            {{-- change color to reflect number of covid cases --}}
                            <div class="col-md-3">
                                <div class="small-box {{ $bohol_bg }}">
                                    <div class="inner">
                                        <h3 class="text-center">{{ $count_bohol }}</h3>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <h5 class="small-box-footer"> BOHOL </h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box {{ $cebu_bg }}">
                                    <div class="inner">
                                        <h3 class="text-center">{{ $count_cebu }}</h3>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <h5 class="small-box-footer"> CEBU </h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box {{ $negros_bg }}">
                                    <div class="inner">
                                        <h3 class="text-center">{{ $count_negros }}</h3>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <h5 class="small-box-footer"> NEGROS ORIENTAL </h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box {{ $siquijor_bg }}">
                                    <div class="inner">
                                        <h3 class="text-center">{{ $count_siquijor }}</h3>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <h5 class="small-box-footer"> SIQUIJOR </h5>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>&emsp;<b>Legend:</b>&nbsp;&nbsp;
                        <span>
                            (Clinical Status)
                            <span style="border: 1px solid black; background-color: #f6edc9;">&emsp;&nbsp;</span> &emsp;&emsp;&emsp;
                        </span>
                        <span>
                            (Surveillance Category)
                            During Referral: <span style="border: 1px solid black; background-color: #87cefabd;">&emsp;&nbsp;</span>  &emsp;
                            Discharged: <span style="border: 1px solid black; background-color: lightgreen;">&emsp;&nbsp;</span>
                        </span>

                    </h5>
                </div>
            </div>

            @foreach($facilities as $faci)
                <span>{{ $faci }}</span><br>
            @endforeach

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-fixed-header" style="border: ">
                    <thead class="header">
                        <tr class="bg-navy-active text-center">
                            <th></th>
                            <th></th>
                            <th class="text-center" colspan="5">CLINICAL STATUS</th>
                            <th class="text-center" colspan="8">SURVEILLANCE CATEGORY</th>
                        </tr>
                        <tr class="bg-gray-light">
                            <th></th>
                            <th class="text-center"> <b>FACILITY NAME</b> </th>
                            <th class="text-center" colspan="1"> <small><i> Asymptomatic </i></small> </th>
                            <th class="text-center" colspan="1"> <small><i> Mild </i></small> </th>
                            <th class="text-center" colspan="1"> <small><i> Moderate </i></small> </th>
                            <th class="text-center" colspan="1"> <small><i> Severe </i></small> </th>
                            <th class="text-center" colspan="1"> <small><i> Critical </i></small> </th>
                            <th class="text-center" colspan="2"> <small><i> Contact (PUM) </i></small> </th>
                            <th class="text-center" colspan="2"> <small><i> Suspect </i></small> </th>
                            <th class="text-center" colspan="2"> <small><i> Probable </i></small> </th>
                            <th class="text-center" colspan="2"> <small><i> Confirmed </i></small> </th>
                        </tr>
                    </thead>
                    <?php
                        $count = 1;
                    ?>
                    @foreach($data as $row)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td> {{ $row['name'] }}</td>
                            <td class="text-center clinic_stat"> {{ $row['asymp'] }} </td>
                            <td class="text-center clinic_stat"> {{ $row['mild'] }} </td>
                            <td class="text-center clinic_stat"> {{ $row['moderate'] }} </td>
                            <td class="text-center clinic_stat"> {{ $row['severe'] }} </td>
                            <td class="text-center clinic_stat"> {{ $row['critical'] }} </td>
                            <td class="text-center refer"> {{ $row['refer_contact'] }}  </td>
                            <td class="text-center discharged"> {{ $row['dis_contact'] }} </td>
                            <td class="text-center refer"> {{ $row['refer_suspect'] }} </td>
                            <td class="text-center discharged"> {{ $row['dis_suspect'] }} </td>
                            <td class="text-center refer"> {{ $row['refer_probable'] }} </td>
                            <td class="text-center discharged"> {{ $row['dis_probable'] }} </td>
                            <td class="text-center refer"> {{ $row['refer_confirmed'] }} </td>
                            <td class="text-center discharged"> {{ $row['dis_confirmed'] }} </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.table-fixed-header').fixedHeader();
        $('#date_range').daterangepicker();
    </script>
@endsection

