@extends('layouts.app')
<style>
    span{
        cursor: pointer;
    }
    .tooltip1 {
        position: relative;
        display: inline-block;
        /*border-bottom: 1px dotted black;*/
        cursor: help;
    }

    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 200px;
        background-color: #00a65a;
        color: white;
        text-align: center;
        border-radius: 6px;
        padding: 10px;
        position: absolute;
        z-index: 1;
        top: 150%;
        left: 50%;
        margin-left: -60px;
        font-weight: normal;
    }

    .tooltip1 .tooltiptext::after {
        content: "";
        position: absolute;
        bottom: 100%;
        left: 50%;
        margin-left: -40px;
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent #00a65a transparent;
    }

    .tooltip1:hover .tooltiptext {
        visibility: visible;
    }
</style>
@section('content')
    <div class="row col-md-12">
        <div class="box box-success">
            <div class="row">
                <div class="col-md-5">
                    <div class="box-header with-border">
                        <h2> WALKIN REPORT <br />
                            <small class="text-success">
                                {{ strtoupper($province_name) }} PROVINCE
                            </small>
                        </h2><br>
                        <form action="{{ asset('report/walkin').'/'.$province }}" method="GET" class="form-inline">
                            {{ csrf_field() }}
                            <div class="form-group-md">
                                <?php $date_range = date("m/d/Y",strtotime($date_range_start)).' - '.date("m/d/Y",strtotime($date_range_end)); ?>
                                <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" placeholder="Filter daterange here..." id="walkin_date_range">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <section class="content" style="height: auto !important; min-height: 0px !important;margin-top: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3 id="walkin_count">0</h3>
                                        <p style="font-size: 15px">Walk-in</p>
                                    </div>
                                    <div class="icon" style="padding-top: 10px">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-md-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 id="walkin_transferred">0</h3>
                                        <p style="font-size: 15px">Transferred</p>
                                    </div>
                                    <div class="icon" style="padding-top: 10px">
                                        <i class="fa fa-ambulance"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                    </section>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-fixed-header">
                        <thead class='header'>
                        <tr>
                            <th></th>
                            <th>Facility Name</th>
                            <th class="text-center">
                                <div class="tooltip1">
                                    Walk-in
                                    <span class="tooltiptext">Number of walk-in patients</span>
                                </div>
                            </th>
                            <th class="text-center"><div class="tooltip1">
                                    Transferred
                                    <span class="tooltiptext">Walk-in patients transferred to another facility</span>
                                </div></th>
                            <th class="text-center" style="font-size: 19px">TOTAL</th>
                        </tr>
                        </thead>
                        <?php
                        $count = 1;
                        ?>
                        @foreach($data as $row)
                            <input type="hidden" id="faci_name{{ $row['faci_id'] }}" value="{{ $row['faci_name'] }}">
                            <tr class="">
                                <td width="2%;">{{ $count }}</td>
                                <td width="37%">
                                    <span style="font-size: 12pt;">
                                        {{ $row['faci_name'] }}
                                    </span><br>
                                    <?php
                                    if($row['hospital_type'] == 'doh_hospital')
                                        $hospital_type = "DOH HOSPITAL";
                                    else if($row['hospital_type'] == 'priv_birthing_home')
                                        $hospital_type = "Private Birthing Home";
                                    else if($row['hospital_type'] == 'gov_birthing_home')
                                        $hospital_type = "Government Birthing Home";
                                    else if($row['hospital_type'] == 'lgu_owned')
                                        $hospital_type = "LGU Owned";
                                    else
                                        $hospital_type = ucfirst($row['hospital_type']);
                                    ?>
                                    <small class="@if($row['hospital_type ']== 'government'){{ 'text-yellow' }}@else{{ 'text-maroon' }}@endif">{{ $hospital_type }}</small>
                                </td>
                                <td class="text-center" style="width:13%;">
                                    <span class="text-blue" style="font-size: 15pt" onclick='reportData($(this),"{{ $row['faci_id'] }}","walkin","{{ $date_range }}")'>
                                        {{ $row['walkin']}}
                                    </span><br><br>
                                </td>
                                <td class="text-center" style="width:13%;">
                                    <span class="text-blue" style="font-size: 15pt" onclick="reportData($(this),'{{ $row['faci_id'] }}','transferred','{{ $date_range }}')">
                                        {{ $row['transferred']}}
                                    </span><br><br>
                                </td>
                                <td class="text-center" style="width:13%; font-size: 19px;">
                                    <?php $total = $row['walkin'] + $row['transferred'];?>
                                    <span style="padding-bottom: 10px;"><b style="font-size: 20px">{{ $total }}</b></span>
                                </td>
                            </tr>
                            <?php $count++;?>
                        @endforeach
                    </table><br>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="walkin_report_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-9">
                            <h4 class="modal-title wrep_title"></h4>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="close" style="float: right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body wrep_body">
                    ...
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('report/exportwalkin') }}" class="btn btn-danger" target="_blank" id="exportBtn">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('css')
@endsection

@section('js')
    <script>
        $("#walkin_count").html("{{ $walkin_total }}");
        $("#walkin_transferred").html("{{ $transferred_total }}");

        //Date range picker
        $('#walkin_date_range').daterangepicker();
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });

        function reportData(data,facility_id,status,date_range){
            $(".wrep_title").html("Walk-in Report | " + $('#faci_name'+facility_id).val());
            date_range = date_range.replace(/\//ig, "|");
            $("#walkin_report_modal").modal('show');
            $(".wrep_body").html(loading);
            $("span").css("background-color","");
            data.css("background-color","yellow");
            var url = "{{ asset('report/walkin/info') }}"+"/"+facility_id+"/"+status+"/"+date_range;
            $.ajax({
                url: url,
                type: 'GET',
                success: function(result) {
                    if(result.length === 0) {
                        $('#exportBtn').attr('disabled',true);
                    }else {
                        $('#exportBtn').attr('disabled',false);
                    }
                    $(".wrep_title").append('&nbsp;<span class="badge bg-yellow data_count">'+result.length+'</span>');
                    var table_body = "<table id=\"table\" class='table table-hover table-bordered' style='font-size: 9pt;'>\n" +
                        "    <tr class='bg-success'>" +
                        "       <th></th>" +
                        "       <th class='text-green text-center'>Code</th>" +
                        "       <th class='text-green text-center'>Patient Name</th>" +
                        "       <th class='text-green text-center'>Address</th><th class='text-green'>Age</th>";
                    if(status === 'transferred') {
                        table_body += "       <th class='text-green text-center'>Transferred To</th>" ;
                    }
                    table_body +=
                        "       <!--<th class='text-green'>Referred Facility</th>-->" +
                        "       <th class='text-green text-center'>Status</th></tr>\n" +
                        "</table>";
                    $(".wrep_body").html(table_body);
                    jQuery.each(result, function(index, value) {
                        var track_url = "<?php echo asset('doctor/referred?referredCode='); ?>"+value["code"];
                        var tr = $('<tr />');
                        tr.append("<a href='"+track_url+"' class=\"btn btn-xs btn-success\" target=\"_blank\">\n" +
                            "<i class=\"fa fa-stethoscope\"></i> Track\n" +
                            "</a>");
                        tr.append( $('<td />', { text : value["code"] } ));
                        tr.append( $('<td />', { text : value["name"] } ));
                        tr.append( $('<td />', { text : value["address"] } ));
                        tr.append( $('<td />', { text : value["age"] } ));
                        if(status === 'transferred') {
                            tr.append( $('<td />', { text : value["referred_facility"] } ));
                        }
                        /*tr.append( $('<td />', { text : value["referred_facility"] } ));*/
                        tr.append( $('<td />', { text : value["status"] } ));
                        $("#table").append(tr);
                    });
                }
            });
        }
    </script>
@endsection

