@extends('layouts.app')

@section('content')
    <style>
        label {
            padding: 0px !important;
        }
    </style>
    <div class="row col-md-12">
        <div class="box box-success">
            <div class="box-body">
                @if(count($data) > 0)
                    <h1 style="color: #676767">{{ $data[0]->province }}</h1>
                    <div class="box-header with-border">
                        <form action="{{ asset('onboard/facility').'/'.$province_id }}" method="GET" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group-lg">
                                <?php $date_range = date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)); ?>
                                <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" id="consolidate_date_range">
                                <button type="submit" class="btn-lg btn-info btn-flat"><i class="fa fa-search"></i> Filter</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-fixed-header">
                            <?php
                                $count = 0;

                                $facility_onboard[1] = 0;
                                $facility_total[1] = 0;
                                $facility_transaction[1]['with_transaction'] = 0;
                                $facility_transaction[1]['no_transaction'] = 0;

                                $facility_onboard[2] = 0;
                                $facility_total[2] = 0;
                                $facility_transaction[2]['with_transaction'] = 0;
                                $facility_transaction[2]['no_transaction'] = 0;

                                $facility_onboard[3] = 0;
                                $facility_total[3] = 0;
                                $facility_transaction[3]['with_transaction'] = 0;
                                $facility_transaction[3]['no_transaction'] = 0;

                                $facility_onboard[4] = 0;
                                $facility_total[4] = 0;
                                $facility_transaction[4]['with_transaction'] = 0;
                                $facility_transaction[4]['no_transaction'] = 0;

                                $hospital_type[1]['government'] = 0;
                                $hospital_type_total[1]['government'] = 0;
                                $government_transaction[1]['with_transaction'] = 0;
                                $government_transaction[1]['no_transaction'] = 0;

                                $hospital_type[2]['government'] = 0;
                                $hospital_type_total[2]['government'] = 0;
                                $government_transaction[2]['with_transaction'] = 0;
                                $government_transaction[2]['no_transaction'] = 0;

                                $hospital_type[3]['government'] = 0;
                                $hospital_type_total[3]['government'] = 0;
                                $government_transaction[3]['with_transaction'] = 0;
                                $government_transaction[3]['no_transaction'] = 0;

                                $hospital_type[4]['government'] = 0;
                                $hospital_type_total[4]['government'] = 0;
                                $government_transaction[4]['with_transaction'] = 0;
                                $government_transaction[4]['no_transaction'] = 0;

                                $hospital_type[1]['private'] = 0;
                                $hospital_type[2]['private'] = 0;
                                $hospital_type[3]['private'] = 0;
                                $hospital_type[4]['private'] = 0;
                                $hospital_type_total[1]['private'] = 0;
                                $hospital_type_total[2]['private'] = 0;
                                $hospital_type_total[3]['private'] = 0;
                                $hospital_type_total[4]['private'] = 0;

                                $hospital_type[1]['RHU'] = 0;
                                $hospital_type[2]['RHU'] = 0;
                                $hospital_type[3]['RHU'] = 0;
                                $hospital_type[4]['RHU'] = 0;
                                $hospital_type_total[1]['RHU'] = 0;
                                $hospital_type_total[2]['RHU'] = 0;
                                $hospital_type_total[3]['RHU'] = 0;
                                $hospital_type_total[4]['RHU'] = 0;

                                $hospital_type[1]['priv_birthing_home'] = 0;
                                $hospital_type[2]['priv_birthing_home'] = 0;
                                $hospital_type[3]['priv_birthing_home'] = 0;
                                $hospital_type[4]['priv_birthing_home'] = 0;
                                $hospital_type_total[1]['priv_birthing_home'] = 0;
                                $hospital_type_total[2]['priv_birthing_home'] = 0;
                                $hospital_type_total[3]['priv_birthing_home'] = 0;
                                $hospital_type_total[4]['priv_birthing_home'] = 0;

                                $hospital_type[1]['gov_birthing_home'] = 0;
                                $hospital_type[2]['gov_birthing_home'] = 0;
                                $hospital_type[3]['gov_birthing_home'] = 0;
                                $hospital_type[4]['gov_birthing_home'] = 0;
                                $hospital_type_total[1]['gov_birthing_home'] = 0;
                                $hospital_type_total[2]['gov_birthing_home'] = 0;
                                $hospital_type_total[3]['gov_birthing_home'] = 0;
                                $hospital_type_total[4]['gov_birthing_home'] = 0;

                                $hospital_type[1]['lgu_owned'] = 0;
                                $hospital_type[2]['lgu_owned'] = 0;
                                $hospital_type[3]['lgu_owned'] = 0;
                                $hospital_type[4]['lgu_owned'] = 0;
                                $hospital_type_total[1]['lgu_owned'] = 0;
                                $hospital_type_total[2]['lgu_owned'] = 0;
                                $hospital_type_total[3]['lgu_owned'] = 0;
                                $hospital_type_total[4]['lgu_owned'] = 0;

                                $hospital_type[1]['doh_hospital'] = 0;
                                $hospital_type[2]['doh_hospital'] = 0;
                                $hospital_type[3]['doh_hospital'] = 0;
                                $hospital_type[4]['doh_hospital'] = 0;
                                $hospital_type_total[1]['doh_hospital'] = 0;
                                $hospital_type_total[2]['doh_hospital'] = 0;
                                $hospital_type_total[3]['doh_hospital'] = 0;
                                $hospital_type_total[4]['doh_hospital'] = 0;

                                $hospital_type[1]['CIU/TTMF'] = 0;
                                $hospital_type[2]['CIU/TTMF'] = 0;
                                $hospital_type[3]['CIU/TTMF'] = 0;
                                $hospital_type[4]['CIU/TTMF'] = 0;
                                $hospital_type_total[1]['CIU/TTMF'] = 0;
                                $hospital_type_total[2]['CIU/TTMF'] = 0;
                                $hospital_type_total[3]['CIU/TTMF'] = 0;
                                $hospital_type_total[4]['CIU/TTMF'] = 0;

                                $hospital_type[1]['EOC'] = 0;
                                $hospital_type[2]['EOC'] = 0;
                                $hospital_type[3]['EOC'] = 0;
                                $hospital_type[4]['EOC'] = 0;
                                $hospital_type_total[1]['EOC'] = 0;
                                $hospital_type_total[2]['EOC'] = 0;
                                $hospital_type_total[3]['EOC'] = 0;
                                $hospital_type_total[4]['EOC'] = 0;

                                $private_transaction[1]['with_transaction'] = 0;
                                $private_transaction[1]['no_transaction'] = 0;
                                $private_transaction[2]['with_transaction'] = 0;
                                $private_transaction[2]['no_transaction'] = 0;
                                $private_transaction[3]['with_transaction'] = 0;
                                $private_transaction[3]['no_transaction'] = 0;
                                $private_transaction[4]['with_transaction'] = 0;
                                $private_transaction[4]['no_transaction'] = 0;

                                $rhu_transaction[1]['with_transaction'] = 0;
                                $rhu_transaction[1]['no_transaction'] = 0;
                                $rhu_transaction[2]['with_transaction'] = 0;
                                $rhu_transaction[2]['no_transaction'] = 0;
                                $rhu_transaction[3]['with_transaction'] = 0;
                                $rhu_transaction[3]['no_transaction'] = 0;
                                $rhu_transaction[4]['with_transaction'] = 0;
                                $rhu_transaction[4]['no_transaction'] = 0;

                                $priv_birthing_transaction[1]['with_transaction'] = 0;
                                $priv_birthing_transaction[1]['no_transaction'] = 0;
                                $priv_birthing_transaction[2]['with_transaction'] = 0;
                                $priv_birthing_transaction[2]['no_transaction'] = 0;
                                $priv_birthing_transaction[3]['with_transaction'] = 0;
                                $priv_birthing_transaction[3]['no_transaction'] = 0;
                                $priv_birthing_transaction[4]['with_transaction'] = 0;
                                $priv_birthing_transaction[4]['no_transaction'] = 0;

                                $gov_birthing_transaction[1]['with_transaction'] = 0;
                                $gov_birthing_transaction[1]['no_transaction'] = 0;
                                $gov_birthing_transaction[2]['with_transaction'] = 0;
                                $gov_birthing_transaction[2]['no_transaction'] = 0;
                                $gov_birthing_transaction[3]['with_transaction'] = 0;
                                $gov_birthing_transaction[3]['no_transaction'] = 0;
                                $gov_birthing_transaction[4]['with_transaction'] = 0;
                                $gov_birthing_transaction[4]['no_transaction'] = 0;

                                $lgu_owned_transaction[1]['with_transaction'] = 0;
                                $lgu_owned_transaction[1]['no_transaction'] = 0;
                                $lgu_owned_transaction[2]['with_transaction'] = 0;
                                $lgu_owned_transaction[2]['no_transaction'] = 0;
                                $lgu_owned_transaction[3]['with_transaction'] = 0;
                                $lgu_owned_transaction[3]['no_transaction'] = 0;
                                $lgu_owned_transaction[4]['with_transaction'] = 0;
                                $lgu_owned_transaction[4]['no_transaction'] = 0;

                                $doh_hospital_transaction[1]['with_transaction'] = 0;
                                $doh_hospital_transaction[1]['no_transaction'] = 0;
                                $doh_hospital_transaction[2]['with_transaction'] = 0;
                                $doh_hospital_transaction[2]['no_transaction'] = 0;
                                $doh_hospital_transaction[3]['with_transaction'] = 0;
                                $doh_hospital_transaction[3]['no_transaction'] = 0;
                                $doh_hospital_transaction[4]['with_transaction'] = 0;
                                $doh_hospital_transaction[4]['no_transaction'] = 0;

                                $ciu_transaction[1]['with_transaction'] = 0;
                                $ciu_transaction[1]['no_transaction'] = 0;
                                $ciu_transaction[2]['with_transaction'] = 0;
                                $ciu_transaction[2]['no_transaction'] = 0;
                                $ciu_transaction[3]['with_transaction'] = 0;
                                $ciu_transaction[3]['no_transaction'] = 0;
                                $ciu_transaction[4]['with_transaction'] = 0;
                                $ciu_transaction[4]['no_transaction'] = 0;

                                $eoc_transaction[1]['with_transaction'] = 0;
                                $eoc_transaction[1]['no_transaction'] = 0;
                                $eoc_transaction[2]['with_transaction'] = 0;
                                $eoc_transaction[2]['no_transaction'] = 0;
                                $eoc_transaction[3]['with_transaction'] = 0;
                                $eoc_transaction[3]['no_transaction'] = 0;
                                $eoc_transaction[4]['with_transaction'] = 0;
                                $eoc_transaction[4]['no_transaction'] = 0;

                                $province = [];
                            ?>
                            @foreach($data as $row)
                                <?php
                                    $transaction = \App\Activity::where("referred_from",$row->facility_id)->orWhere("referred_to",$row->facility_id)->orderBy("id","desc")->first();

                                    if($row->status == 'onboard') {
                                        $facility_onboard[$row->province_id]++;
                                        $hospital_type[$row->province_id][$row->hospital_type]++;
                                        if($transaction){
                                            $facility_transaction[$row->province_id]['with_transaction']++;
                                            if($row->hospital_type == 'government'){
                                                $government_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'private'){
                                                $private_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'RHU'){
                                                $rhu_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'priv_birthing_home'){
                                                $priv_birthing_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'gov_birthing_home'){
                                                $gov_birthing_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'lgu_owned'){
                                                $lgu_owned_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'doh_hospital'){
                                                $doh_hospital_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'EOC'){
                                                $eoc_transaction[$row->province_id]['with_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'CIU/TTMF'){
                                                $ciu_transaction[$row->province_id]['with_transaction']++;
                                            }
                                        } else {
                                            $facility_transaction[$row->province_id]['no_transaction']++;
                                            if($row->hospital_type == 'government'){
                                                $government_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'private'){
                                                $private_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'RHU'){
                                                $rhu_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'priv_birthing_home'){
                                                $priv_birthing_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'gov_birthing_home'){
                                                $gov_birthing_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'lgu_owned'){
                                                $lgu_owned_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'doh_hospital'){
                                                $doh_hospital_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'EOC'){
                                                $eoc_transaction[$row->province_id]['no_transaction']++;
                                            }
                                            elseif($row->hospital_type == 'CIU/TTMF'){
                                                $ciu_transaction[$row->province_id]['no_transaction']++;
                                            }
                                        }
                                    }

                                    $hospital_type_total[$row->province_id][$row->hospital_type]++;
                                    $facility_total[$row->province_id]++;
                                ?>
                            @endforeach
                            @foreach($data as $row)
                                <?php
                                    $count++;
                                    $transaction = \App\Activity::where("referred_from",$row->facility_id)->orWhere("referred_to",$row->facility_id)->orderBy("id","desc")->first();
                                ?>
                                @if(!isset($province[$row->province]))
                                    <?php $province[$row->province] = true; ?>
                                    <tr>
                                        <td colspan="9">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div id="chartOverall{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">Overall - </strong>
                                                    <span class="progress-number"><b class="{{ 'facility_onboard'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'facility_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red facility_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped facility_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                
                                                @if($hospital_type[$row->province_id]['government'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartGovernment{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">Government Hospital - </strong>
                                                    <span class="progress-number"><b class="{{ 'government_hospital'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'government_hospital_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red government_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm" >
                                                        <div class="progress-bar progress-bar-striped government_hospital_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif
                                                    
                                                @if($hospital_type[$row->province_id]['private'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartPrivate{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">Private Hospital - </strong>
                                                    <span class="progress-number"><b class="{{ 'private_hospital'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'private_hospital_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red private_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped private_hospital_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($hospital_type[$row->province_id]['RHU'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartRhu{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">Rural Health Unit Government - </strong>
                                                    <span class="progress-number"><b class="{{ 'rhu_hospital'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'rhu_hospital_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red rhu_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped rhu_hospital_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($hospital_type[$row->province_id]['priv_birthing_home'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartPrivBirthing{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">Private Birthing Home - </strong>
                                                    <span class="progress-number"><b class="{{ 'priv_birthing_hospital'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'priv_birthing_hospital_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red priv_birthing_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped priv_birthing_hospital_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($hospital_type[$row->province_id]['gov_birthing_home'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartGovBirthing{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">Government Birthing Home - </strong>
                                                    <span class="progress-number"><b class="{{ 'gov_birthing_hospital'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'gov_birthing_hospital_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red gov_birthing_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped gov_birthing_hospital_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @if($hospital_type[$row->province_id]['lgu_owned'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartLGUOwned{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">LGU-Owned - </strong>
                                                    <span class="progress-number"><b class="{{ 'lgu_owned'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'lgu_owned_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red lgu_owned_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped lgu_owned_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($hospital_type[$row->province_id]['doh_hospital'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartDOHHospital{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">DOH Hospital - </strong>
                                                    <span class="progress-number"><b class="{{ 'doh_hospital'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'doh_hospital_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red doh_hospital_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped doh_hospital_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($hospital_type[$row->province_id]['CIU/TTMF'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartCIU{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">CIU/TTMF - </strong>
                                                    <span class="progress-number"><b class="{{ 'ciu'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'ciu_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red ciu_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped ciu_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($hospital_type[$row->province_id]['EOC'] != 0)
                                                <div class="col-lg-3">
                                                    <div id="chartEOC{{ $row->province_id }}" style="height: 200px; width: 100%;"></div>
                                                    <strong class="text-green">EOC - </strong>
                                                    <span class="progress-number"><b class="{{ 'eoc'.$row->province_id }}"></b> <small class="text-blue">(ON BOARD)</small> / <b class="{{ 'eoc_total'.$row->province_id }}"></b> <small class="text-blue">(REGISTER)</small></span> = <b class="text-red eoc_percent{{ $row->province_id }}"></b>
                                                    <div class="progress sm">
                                                        <div class="progress-bar progress-bar-striped eoc_progress{{ $row->province_id }}" ></div>
                                                    </div>
                                                </div>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                    <thead class='header'>
                                        <tr class="bg-black">
                                            <th></th>
                                            <th>Facility Name</th>
                                            <th>Chief Hospital</th>
                                            <th>Contact No</th>
                                            <th>Registered On</th>
                                            <th>First Login</th>
                                            <th>Last Login From</th>
                                            <th>Last Logout To</th>
                                            <th>Last Transaction</th>
                                        </tr>
                                    </thead>
                                @endif
                                <tr class="@if($row->status == 'onboard'){{ 'bg-yellow' }}@endif">
                                    <td>{{ $count }}</td>
                                    <td class="@if(!$transaction && $row->status == 'onboard'){{ 'bg-red' }}@endif">
                                        {{ $row->name }}<br>
                                        <span class="
                                        <?php
                                        if($row->hospital_type == 'government'){
                                            echo 'badge bg-green';
                                        }
                                        elseif($row->hospital_type == 'private'){
                                            echo 'badge bg-blue';
                                        }
                                        elseif($row->hospital_type == 'RHU'){
                                            echo 'badge bg-yellow';
                                        }
                                        elseif($row->hospital_type == 'CIU/TTMF'){
                                            echo 'badge bg-purple';
                                        }
                                        elseif($row->hospital_type == 'priv_birthing_home'){
                                            echo 'badge bg-orange';
                                        }
                                        elseif($row->hospital_type == 'gov_birthing_home'){
                                            echo 'badge bg-cornflowerblue';
                                        }
                                        elseif($row->hospital_type == 'doh_hospital'){
                                            echo 'badge bg-blue';
                                        }
                                        elseif($row->hospital_type == 'EOC'){
                                            echo 'badge bg-black';
                                        }
                                        ?>">
                                            @if($row->hospital_type == 'priv_birthing_home')
                                                Private Birthing Home
                                            @elseif($row->hospital_type == 'gov_birthing_home')
                                                Government Birthing Home
                                            @elseif($row->hospital_type == 'lgu_owned')
                                                LGU Owned
                                            @elseif($row->hospital_type == 'doh_hospital')
                                                DOH Hospital
                                            @else
                                                {{ ucfirst($row->hospital_type) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $row->chief_hospital }}</td>
                                    <td width="10%"><small>{{ $row->contact }}</small></td>
                                    <td >
                                        <small>{{ date("F d,Y",strtotime($row->registered_on)) }}</small><br>
                                        <i>(<small>{{ date("g:i a",strtotime($row->registered_on)) }}</small>)</i>
                                    </td>
                                    <td >
                                        @if($row->first_login == 'not_login')
                                            <small>NOT LOGIN</small>
                                        @else
                                            <small>{{ date("F d,Y",strtotime($row->first_login)) }}</small><br>
                                            <i>(<small>{{ date("g:i a",strtotime($row->first_login)) }}</small>)</i>
                                        @endif
                                    </td>
                                    <td >
                                        @if($row->last_login_from == 'not_login')
                                            <small>NOT LOGIN</small>
                                        @else
                                            <small>{{ date("F d,Y",strtotime($row->last_login_from)) }}</small><br>
                                            <i>(<small>{{ date("g:i a",strtotime($row->last_login_from)) }}</small>)</i>
                                        @endif
                                    </td>
                                    <td >
                                        @if($row->last_logout_to == 'not_login')
                                            <small>NOT LOGOUT</small>
                                        @elseif($row->last_logout_to == '0000-00-00 00:00:00')
                                            <small>{{ date("F d,Y",strtotime(explode(" ",$row->last_login_from)[0]." 23:59:59")) }}</small><br>
                                            <i>(<small>{{ date("g:i a",strtotime(explode(" ",$row->last_login_from)[0]." 23:59:59")) }}</small>)</i>
                                        @else
                                            <small>{{ date("F d,Y",strtotime($row->last_logout_to)) }}</small><br>
                                            <i>(<small>{{ date("g:i a",strtotime($row->last_logout_to)) }}</small>)</i>
                                        @endif
                                    </td>
                                    <td >
                                        @if($transaction)
                                            <small>{{ date("F d,Y",strtotime($transaction->created_at)) }}</small><br>
                                            <i>(<small>{{ date("g:i a",strtotime($transaction->created_a)) }}</small>)</i>
                                            <span class="badge bg-green">{{ ucfirst($transaction->status) }}</span>
                                        @else
                                            <small class="badge bg-red">NO TRANSACTION</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <span class="text-warning">
                            <i class="fa fa-warning"></i> No data found!
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('css')

@endsection

@section('js')
    <script type="text/javascript">
        //Date range picker
        $('#consolidate_date_range').daterangepicker();
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });

        window.onload = function() {
            CanvasJS.addColorSet("greenShades",
                [//colorSet Array
                    "#6762ff",
                    "#ff686b"
                ]);

            var with_transaction1 = Math.round("<?php echo $facility_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $facility_onboard[$data[0]->province_id]; ?>" * 100);
            var no_transaction1 = Math.round("<?php echo $facility_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $facility_onboard[$data[0]->province_id]; ?>" * 100);
            var options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Overall"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+with_transaction1+"% in "+"<?php echo $facility_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $facility_onboard[$data[0]->province_id]; ?>",legendText : "With Transaction", y: with_transaction1 },
                        { label: "No Transaction in "+no_transaction1+"% in "+"<?php echo $facility_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $facility_onboard[$data[0]->province_id]; ?>",legendText : "No Transaction", y: no_transaction1 }
                    ]
                }]
            };
            $("#chartOverall{{ $data[0]->province_id }}").CanvasJSChart(options1);


            @if($hospital_type[$data[0]->province_id]['government'] != 0)
            var government_with_transaction1 = Math.round("<?php echo $government_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['government']; ?>" * 100);
            var government_no_transaction1 = Math.round("<?php echo $government_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['government']; ?>" * 100);
            var government_options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Government"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+government_with_transaction1+"% in "+"<?php echo $government_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['government']; ?>",legendText : "With Transaction", y: government_with_transaction1 },
                        { label: "No Transaction in "+government_no_transaction1+"% in "+"<?php echo $government_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['government'] ?>",legendText : "No Transaction", y: government_no_transaction1 }
                    ]
                }]
            };
            $("#chartGovernment{{ $data[0]->province_id }}").CanvasJSChart(government_options1);
            @endif

            @if($hospital_type[$data[0]->province_id]['private'] != 0)
            var private_with_transaction1 = Math.round("<?php echo $private_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['private']; ?>" * 100);
            var private_no_transaction1 = Math.round("<?php echo $private_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['private']; ?>" * 100);
            var private_options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "Private"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+private_with_transaction1+"% in "+"<?php echo $private_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['private']; ?>",legendText : "With Transaction", y: private_with_transaction1 },
                        { label: "No Transaction in "+private_no_transaction1+"% in "+"<?php echo $private_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['private'] ?>",legendText : "No Transaction", y: private_no_transaction1 }
                    ]
                }]
            };
            $("#chartPrivate{{ $data[0]->province_id }}").CanvasJSChart(private_options1);
            @endif

            @if($hospital_type[$data[0]->province_id]['RHU'] != 0)
            var rhu_with_transaction1 = Math.round("<?php echo $rhu_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['RHU']; ?>" * 100);
            var rhu_no_transaction1 = Math.round("<?php echo $rhu_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['RHU']; ?>" * 100);
            var rhu_options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "RHU GOVERNMENT"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+rhu_with_transaction1+"% in "+"<?php echo $rhu_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['RHU']; ?>",legendText : "With Transaction", y: rhu_with_transaction1 },
                        { label: "No Transaction in "+rhu_no_transaction1+"% in "+"<?php echo $rhu_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['RHU'] ?>",legendText : "No Transaction", y: rhu_no_transaction1 }
                    ]
                }]
            };
            $("#chartRhu{{ $data[0]->province_id }}").CanvasJSChart(rhu_options1);
            @endif

            @if($hospital_type[$data[0]->province_id]['priv_birthing_home'] != 0)
            var priv_birthing_with_transaction1 = Math.round("<?php echo $priv_birthing_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['priv_birthing_home']; ?>" * 100);
            var priv_birthing_no_transaction1 = Math.round("<?php echo $priv_birthing_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['priv_birthing_home']; ?>" * 100);
            var priv_birthing_options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "PRIVATE BIRTHING HOME"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+priv_birthing_with_transaction1+"% in "+"<?php echo $priv_birthing_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['priv_birthing_home']; ?>",legendText : "With Transaction", y: priv_birthing_with_transaction1 },
                        { label: "No Transaction in "+priv_birthing_no_transaction1+"% in "+"<?php echo $priv_birthing_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['priv_birthing_home'] ?>",legendText : "No Transaction", y: priv_birthing_no_transaction1 }
                    ]
                }]
            };
            $("#chartPrivBirthing{{ $data[0]->province_id }}").CanvasJSChart(priv_birthing_options1);
            @endif

            @if($hospital_type[$data[0]->province_id]['gov_birthing_home'] != 0)
            var gov_birthing_with_transaction1 = Math.round("<?php echo $gov_birthing_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['gov_birthing_home']; ?>" * 100);
            var gov_birthing_no_transaction1 = Math.round("<?php echo $gov_birthing_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['gov_birthing_home']; ?>" * 100);
            var gov_birthing_options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "GOVERNMENT BIRTHING HOME"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+gov_birthing_with_transaction1+"% in "+"<?php echo $gov_birthing_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['gov_birthing_home']; ?>",legendText : "With Transaction", y: gov_birthing_with_transaction1 },
                        { label: "No Transaction in "+gov_birthing_no_transaction1+"% in "+"<?php echo $gov_birthing_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['gov_birthing_home'] ?>",legendText : "No Transaction", y: gov_birthing_no_transaction1 }
                    ]
                }]
            };
            $("#chartGovBirthing{{ $data[0]->province_id }}").CanvasJSChart(gov_birthing_options1);
            @endif

            @if($hospital_type[$data[0]->province_id]['lgu_owned'] != 0)
            var lgu_owned_with_transaction1 = Math.round("<?php echo $lgu_owned_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['lgu_owned']; ?>" * 100);
            var lgu_owned_no_transaction1 = Math.round("<?php echo $lgu_owned_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['lgu_owned']; ?>" * 100);
            var lgu_owned_options1 = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "LGU-OWNED"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+lgu_owned_with_transaction1+"% in "+"<?php echo $lgu_owned_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['lgu_owned']; ?>",legendText : "With Transaction", y: lgu_owned_with_transaction1 },
                        { label: "No Transaction in "+lgu_owned_no_transaction1+"% in "+"<?php echo $lgu_owned_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['lgu_owned'] ?>",legendText : "No Transaction", y: lgu_owned_no_transaction1 }
                    ]
                }]
            };
            $("#chartLGUOwned{{ $data[0]->province_id }}").CanvasJSChart(lgu_owned_options1);
            @endif

            @if($hospital_type[$data[0]->province_id]['doh_hospital'] != 0)
            var doh_hospital_with_transaction = Math.round("<?php echo $doh_hospital_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['doh_hospital']; ?>" * 100);
            var doh_hospital_no_transaction = Math.round("<?php echo $doh_hospital_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['doh_hospital']; ?>" * 100);
            var doh_hospital_options = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "DOH HOSPITAL"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+doh_hospital_with_transaction+"% in "+"<?php echo $doh_hospital_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['doh_hospital']; ?>",legendText : "With Transaction", y: doh_hospital_with_transaction },
                        { label: "No Transaction in "+doh_hospital_no_transaction+"% in "+"<?php echo $doh_hospital_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['doh_hospital'] ?>",legendText : "No Transaction", y: doh_hospital_no_transaction }
                    ]
                }]
            };
            $("#chartDOHHospital{{ $data[0]->province_id }}").CanvasJSChart(doh_hospital_options);
            @endif

            @if($hospital_type[$data[0]->province_id]['CIU/TTMF'] != 0)
            var ciu_with_transaction = Math.round("<?php echo $ciu_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['CIU/TTMF']; ?>" * 100);
            var ciu_no_transaction = Math.round("<?php echo $ciu_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['CIU/TTMF']; ?>" * 100);
            var ciu_options = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "CIU/TTMF"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+ciu_with_transaction+"% in "+"<?php echo $ciu_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['CIU/TTMF']; ?>",legendText : "With Transaction", y: ciu_with_transaction },
                        { label: "No Transaction in "+ciu_no_transaction+"% in "+"<?php echo $ciu_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['CIU/TTMF'] ?>",legendText : "No Transaction", y: ciu_no_transaction }
                    ]
                }]
            };
            $("#chartCIU{{ $data[0]->province_id }}").CanvasJSChart(ciu_options);
            @endif

            @if($hospital_type[$data[0]->province_id]['EOC'] != 0)
            var eoc_with_transaction = Math.round("<?php echo $eoc_transaction[$data[0]->province_id]['with_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['EOC']; ?>" * 100);
            var eoc_no_transaction = Math.round("<?php echo $eoc_transaction[$data[0]->province_id]['no_transaction']; ?>" / "<?php echo $hospital_type[$data[0]->province_id]['EOC']; ?>" * 100);
            var eoc_options = {
                colorSet: "greenShades",
                exportEnabled: true,
                animationEnabled: true,
                title: {
                    text: "EOC"
                },
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    toolTipContent: "{y}%",
                    legendText: "{label}",
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        { label: "With Transaction in "+eoc_with_transaction+"% in "+"<?php echo $eoc_transaction[$data[0]->province_id]['with_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['EOC']; ?>",legendText : "With Transaction", y: eoc_with_transaction },
                        { label: "No Transaction in "+eoc_no_transaction+"% in "+"<?php echo $eoc_transaction[$data[0]->province_id]['no_transaction']; ?> out of <?php echo $hospital_type[$data[0]->province_id]['EOC'] ?>",legendText : "No Transaction", y: eoc_no_transaction }
                    ]
                }]
            };
            $("#chartEOC{{ $data[0]->province_id }}").CanvasJSChart(eoc_options);
            @endif
        }
    </script>

    <script>
        //Date range picker
        $('#onboard_picker').daterangepicker({
            "singleDatePicker": true
        });

        $(".facility_onboard{{ $data[0]->province_id }}").html("<?php echo $facility_onboard[$data[0]->province_id] ?>");
        $(".facility_total{{ $data[0]->province_id }}").html("<?php echo $facility_total[$data[0]->province_id] ?>");
        var facility_progress1 = Math.round("<?php echo $facility_onboard[$data[0]->province_id] ?>" / "<?php echo $facility_total[$data[0]->province_id] ?>" * 100);
        $('.facility_progress{{ $data[0]->province_id }}').css('width',facility_progress1+"%");
        $('.facility_percent{{ $data[0]->province_id }}').html(facility_progress1+"%");

        /*$(".facility_onboard2").html("<?php echo $facility_onboard[2] ?>");
        $(".facility_total2").html("<?php echo $facility_total[2] ?>");
        var facility_progress2 = Math.round("<?php echo $facility_onboard[2] ?>" / "<?php echo $facility_total[2] ?>" * 100);
        $('.facility_progress2').css('width',facility_progress2+"%");
        $('.facility_percent2').html(facility_progress2+"%");

        $(".facility_onboard3").html("<?php echo $facility_onboard[3] ?>");
        $(".facility_total3").html("<?php echo $facility_total[3] ?>");
        var facility_progress3 = Math.round("<?php echo $facility_onboard[3] ?>" / "<?php echo $facility_total[3] ?>" * 100);
        $('.facility_progress3').css('width',facility_progress3+"%");
        $('.facility_percent3').html(facility_progress3+"%");

        $(".facility_onboard4").html("<?php echo $facility_onboard[4] ?>");
        $(".facility_total4").html("<?php echo $facility_total[4] ?>");
        var facility_progress4 = Math.round("<?php echo $facility_onboard[4] ?>" / "<?php echo $facility_total[4] ?>" * 100);
        $('.facility_progress4').css('width',facility_progress4+"%");
        $('.facility_percent4').html(facility_progress4+"%");
        */

        $(".government_hospital{{ $data[0]->province_id}}").html("<?php echo $hospital_type[$data[0]->province_id]['government']; ?>");
        $(".government_hospital_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['government']; ?>");
        var government_hospital_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['government'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['government'] ?>" * 100);
        $('.government_hospital_progress{{ $data[0]->province_id }}').css('width',government_hospital_progress+"%");
        $('.government_percent{{ $data[0]->province_id }}').html(government_hospital_progress+"%");


        $(".private_hospital{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['private']; ?>");
        $(".private_hospital_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['private']; ?>");
        var private_hospital_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['private'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['private'] ?>" * 100);
        $('.private_hospital_progress{{ $data[0]->province_id }}').css('width',private_hospital_progress+"%");
        $('.private_percent{{ $data[0]->province_id}}').html(private_hospital_progress+"%");


        $(".rhu_hospital{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['RHU']; ?>");
        $(".rhu_hospital_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['RHU']; ?>");
        var rhu_hospital_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['RHU'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['RHU'] ?>" * 100);
        $('.rhu_hospital_progress{{ $data[0]->province_id }}').css('width',rhu_hospital_progress+"%");
        $('.rhu_percent{{ $data[0]->province_id }}').html(rhu_hospital_progress+"%");


        $(".priv_birthing_hospital{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['priv_birthing_home']; ?>");
        $(".priv_birthing_hospital_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['priv_birthing_home']; ?>");
        var priv_birthing_hospital_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['priv_birthing_home'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['priv_birthing_home'] ?>" * 100);
        $('.priv_birthing_hospital_progress{{ $data[0]->province_id }}').css('width',priv_birthing_hospital_progress+"%");
        $('.priv_birthing_percent{{ $data[0]->province_id }}').html(priv_birthing_hospital_progress+"%");


        $(".gov_birthing_hospital{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['gov_birthing_home']; ?>");
        $(".gov_birthing_hospital_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['gov_birthing_home']; ?>");
        var gov_birthing_hospital_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['gov_birthing_home'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['gov_birthing_home'] ?>" * 100);
        $('.gov_birthing_hospital_progress{{ $data[0]->province_id }}').css('width',gov_birthing_hospital_progress+"%");
        $('.gov_birthing_percent{{ $data[0]->province_id }}').html(gov_birthing_hospital_progress+"%");


        $(".lgu_owned{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['lgu_owned']; ?>");
        $(".lgu_owned_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['lgu_owned']; ?>");
        var lgu_owned_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['lgu_owned'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['lgu_owned'] ?>" * 100);
        $('.lgu_owned_progress{{ $data[0]->province_id }}').css('width',lgu_owned_progress+"%");
        $('.lgu_owned_percent{{ $data[0]->province_id }}').html(lgu_owned_progress+"%");       


        $(".doh_hospital{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['doh_hospital']; ?>");
        $(".doh_hospital_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['doh_hospital']; ?>");
        var doh_hospital_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['doh_hospital'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['doh_hospital'] ?>" * 100);
        $('.doh_hospital_progress{{ $data[0]->province_id }}').css('width',doh_hospital_progress+"%");
        $('.doh_hospital_percent{{ $data[0]->province_id }}').html(doh_hospital_progress+"%");    

        $(".ciu{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['CIU/TTMF']; ?>");
        $(".ciu_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['CIU/TTMF']; ?>");
        var ciu_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['CIU/TTMF'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['CIU/TTMF'] ?>" * 100);
        $('.ciu_progress{{ $data[0]->province_id }}').css('width',ciu_progress+"%");
        $('.ciu_percent{{ $data[0]->province_id }}').html(ciu_progress+"%");    

        $(".eoc{{ $data[0]->province_id }}").html("<?php echo $hospital_type[$data[0]->province_id]['EOC']; ?>");
        $(".eoc_total{{ $data[0]->province_id }}").html("<?php echo $hospital_type_total[$data[0]->province_id]['EOC']; ?>");
        var eoc_progress = Math.round("<?php echo $hospital_type[$data[0]->province_id]['EOC'] ?>" / "<?php echo $hospital_type_total[$data[0]->province_id]['EOC'] ?>" * 100);
        $('.eoc_progress{{ $data[0]->province_id }}').css('width',eoc_progress+"%");
        $('.eoc_percent{{ $data[0]->province_id }}').html(eoc_progress+"%");       

    </script>
@endsection

