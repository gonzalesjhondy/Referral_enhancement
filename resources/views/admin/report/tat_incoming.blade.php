<?php $user = Session::get('auth'); ?>
@extends('layouts.app')

@section('content')
    <style>
        #myOption{
            flex-wrap: nowrap;
        }
        .legend-container{
            display:flex;
            align-items: center;
        }
        #mySelect{
            white-space: nowrap;
        }
        .legend-item{
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
        .legend-box{
            width: 24px;
            height: 22px;
            margin-right: 7px;
        }
        .legend-box1{
            background-color: #11ffc5;
        }
        .legend-box2{
            background-color: #00008b;
        }
        .legend-box3{
            background-color: #96bd2b;
        }
        .legend-box4{
            background-color: #28a99e;
        }
        .legend-box5{
            background-color: #6b538b;
        }
        .legend-label{
            font-size: 9px;
            font-weight: bold;
            font-family: Arial;
            margin-right: 10px;
        }
        .medium-label{
            font-size: 14px;
            font-weight: bold;
            margin-right: 17px;
            margin-left: 20px;
        }
        .table-data{
            border-collapse: collapse;
            border: 1px solid black;
            width:100%;
        }
        .table-data th{
            width: 5%;
            padding: 5px;
            border: 1px solid black;
        }
        .cell, .table-data td{
            border-bottom: 1px solid black;
        }
        @media only screen and (max-width: 767px) {
            /* For mobile phones: */
            .table-data {
                front-size: 8px;
            }
            .table-data cell,
            .table-data th,
            .table-data td {
                padding: 4px;
                display: block;
                text-align: center;
            }
            .table-data td, table-data th, cell::before{
                content: attr(data-label);
                display: block;
            }
        }
        @media only screen and (max-width: 480px) {
            /* For mobile phones: */
            .special-text{
                display: block;
            }
            .form-control{
                width: 100%;
            }
            .legend-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .medium-label{
                font-size: 10px;
                margin:auto;
            }
            .legend-label{
                font-size: 9px;
                margin:auto;
            }
        }
        /* Media query for iPad screen sizes */
        @media screen and (max-width: 1024px) and (max-height: 1366px) {

            .special-text::before{
                content: attr(data-label);
                display: block;
            }
            #myOption {
                flex-wrap: nowrap;
            }
            .medium-label{
                font-size: 11px;
                font-weight: bold;
                margin: auto;
            }
            .legend-label{
                font-size: 9px;
                font-weight: bold;
                margin: auto;
            }
            .legend-box{
                margin-right: 3px;
            }
        }
        /* Media query for Surface Duo screen sizes */
        @media screen and (max-width: 540px) and (max-height: 720px) {
            .special-text::before{
                content: attr(data-label);
                display: block;
            }
            .legend-container {
                front-size: 8px;
                flex-direction: column;
                align-items: flex-start;
            }
        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <div style="background-color: white;padding: 10px;">
                <form action="{{ asset('admin/report/tat') }}" method="GET" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group" style="width: 100%">
                        <span style="font-size: 12pt;"><i>as of </i></span>
                        <?php $date_range = date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)); ?>
                        <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" id="consolidate_date_range">
                        From:
                        <select name="province_from" class="form-control" onchange="onChangeProvinceFrom($(this).val())">
                            <option id="myOption" value="">Select All Province</option>
                            @foreach(\App\Province::get() as $pro)
                                <option value="{{ $pro->id }}" <?php if(isset($province_select_from)){if($pro->id == $province_select_from)echo 'selected';} ?>>{{ $pro->description }}</option>
                            @endforeach
                        </select>
                        <select name="facility_from" id="facility_from" class="from_tat_select2">

                        </select>
                        <span class="special-text">To:</span>
                        <select id="mySelect" name="province_to" class="form-control" onchange="onChangeProvinceTo($(this).val())">

                            <option value="">Select All Province</option>
                            @foreach(\App\Province::get() as $pro)
                                <option value="{{ $pro->id }}" <?php if(isset($province_select_to)){if($pro->id == $province_select_to)echo 'selected';} ?>>{{ $pro->description }}</option>
                            @endforeach
                        </select>
                        <select name="facility_to" id="facility_to" class="to_tat_select2" onchange="onChangeFacilityTo($(this).val())">

                        </select>
                        <select name="department_to" id="department_to" class="form-control">
                            @if(!$department_select_to)
                                <option value="">Please select department to</option>
                            @endif
                        </select>
                        <button type="submit" class="btn btn-md btn-info"><i class="fa fa-search"></i> Filter</button>
                        <button type="button" class="btn btn-md btn-warning" onClick="window.location.href = '{{ asset('admin/report/tat/incoming') }}'"><i class="fa fa-search"></i> View All</button>
                    </div>
                </form><br>
            </div>
            <div id="chartContainer" style="height: 600px; width: 100%;"></div>
            <div style="width: 20%;height:20px;background-color: white;position: absolute;margin-top: -12px;"></div>
        </div>
        <div class="col-md-12">
            <div class="jim-content">
                <div class="legend-container">
                    <div class="legend-item">
                        <span class="medium-label">BAR CHART LEGEND</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-box1"></div>
                        <span class="legend-label"> TOTAL NUMBER OF <br>PATIENT (REFERRED)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-box2"></div>
                        <span class="legend-label"> TOTAL NUMBER OF <br>PATIENT (REDIRECTED)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-box3"></div>
                        <span class="legend-label"> TOTAL NUMBER OF <br>PATIENT (TRANSFERRED)</span>
                    </div>
                    <div class="legend-item">
                        <span class="medium-label">LINE CHART LEGEND</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-box4"></div>
                        <span class="legend-label"> TOTAL NUMBER OF MINUTES<br> (REFERRED TO ACCEPTED)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-box legend-box5"></div>
                        <span class="legend-label"> TOTAL NUMBER OF MINUTES<br> (REDIRECTED TO ACCEPTED)</span>
                    </div>
                </div>
                <div class="row" style="margin-top: 1.5%;">
                    <table class="table-data">
                        <tr>
                            <td style="font-weight:bold; border: 1px solid black">REFERRED</td>
                            <td class="cell">
                                <div style="cursor: pointer;" onclick="referToSeenPeak()">
                                    <div class="description-block border-right">
                                        <h5 class="description-header refer_to_seen">{{ $refer_to_seen }}</h5>
                                        <span class="description-text">Refer to Seen</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td class="cell">
                                <!-- /.col -->
                                <div>
                                    <div class="description-block border-right">
                                        <h5 class="description-header">{{ $seen_to_accept }}</h5>
                                        <span class="description-text">Seen to Accepted</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td class="cell">
                                <!-- /.col -->
                                <div>
                                    <div class="description-block border-right">
                                        <h5 class="description-header">{{ $seen_to_reject }}</h5>
                                        <span class="description-text">Seen to Recommend to Redirect</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td class="cell">
                                <!-- /.col -->
                                <div>
                                    <div class="description-block border-right">
                                        <h5 class="description-header">{{ $accept_to_arrive }}</h5>
                                        <span class="description-text">Accepted to Arrived</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td class="cell">
                                <!-- /.col -->
                                <div>
                                    <div class="description-block border-right">
                                        <h5 class="description-header">{{ $arrive_to_admit }}</h5>
                                        <span class="description-text">Arrived to Admitted</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td class="cell">
                                <!-- /.col -->
                                <div>
                                    <div class="description-block border-right">
                                        <h5 class="description-header">{{ $admit_to_discharge }}</h5>
                                        <span class="description-text">Admitted to Discharge</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold; border: 1px solid black">REDIRECTED</td>
                            <td>
                                <!-- /.col -->
                                <div >
                                    <div class="description-block border-right row text-danger">
                                        <h5 class="description-header">{{ $redirect_to_seen }}</h5>
                                        <span class="description-text">REDIRECTED TO SEEN</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td>
                                <!-- /.col -->
                                <div >
                                    <div class="description-block border-right row text-danger">
                                        <h5 class="description-header">{{ $seen_to_accept_redirect }}</h5>
                                        <span class="description-text">SEEN TO ACCEPTED</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td>
                                <!-- /.col -->
                                <div >
                                    <div class="description-block border-right row text-danger">
                                        <h5 class="description-header">{{ $seen_to_reject_redirect}}</h5>
                                        <span class="description-text">Seen to Recommend to Redirect</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td>
                                <!-- /.col -->
                                <div class=" row text-danger">
                                    <div class="description-block border-right">
                                        <h5 class="description-header">{{ $accept_to_arrive_redirect }}</h5>
                                        <span class="description-text">ACCEPTED TO ARRIVED</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </td>
                            <td>
                                <!-- /.col -->
                                <div >
                                    <div class="description-block border-right row text-danger">
                                        <h5 class="description-header">{{ $arrive_to_admit_redirect }}</h5>
                                        <span class="description-text">ARRIVED TO ADMITTED</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                            <td>
                                <!-- /.col -->
                                <div >
                                    <div class="description-block border-right row text-danger">
                                        <h5 class="description-header">{{ $admit_to_discharge_redirect }}</h5>
                                        <span class="description-text">ADMITTED TO DISCHARGE </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="statistics-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3 class="modal-title statistics-title"></h3>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="close" style="float: right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body statistics-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @include('script.chart')
    <script>
        var user_level = "<?php echo $user->level; ?>";
        function  handleScreenSize() {
            const viewportWidth =window.innerWidth;
            const viewportHeight =window.innerHeight;
            if (viewportWidth<viewportHeight){/*portrait*/
                if(window.innerWidth<576) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<768) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<992 && window.innerHeight<1366) {
                    $(".from_tat_select2").select2({width: '265'});
                    $(".to_tat_select2").select2({width: '265'});
                }
                else if(window.innerWidth<1024 && window.innerHeight<600) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<912 || window.innerHeight<1368) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<1824 || window.innerHeight<2736) {
                    $(".from_tat_select2").select2({width: '270'});
                    $(".to_tat_select2").select2({width: '270'});
                }
                else if(window.innerWidth<1080) {
                    $(".from_tat_select2").select2({width: '265'});
                    $(".to_tat_select2").select2({width: '265'});
                }
                else if(window.innerWidth<1200) {
                    $(".from_tat_select2").select2({width: '300'});
                    $(".to_tat_select2").select2({width: '300'});
                }
                else {
                    $(".from_tat_select2").select2({width: '250'});
                    $(".to_tat_select2").select2({width: '250'});
                }
            }
            else{ /*landscape*/
                if(window.innerWidth<576) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<768) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<992) {
                    $(".from_tat_select2").select2({width: '200'});
                    $(".to_tat_select2").select2({width: '200'});
                }
                else if(window.innerWidth<1024 && window.innerHeight<1366) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<1024 && window.innerHeight<600) {
                    $(".from_tat_select2").select2({width: '100%'});
                    $(".to_tat_select2").select2({width: '100%'});
                }
                else if(window.innerWidth<1080) {
                    $(".from_tat_select2").select2({width: '200'});
                    $(".to_tat_select2").select2({width: '200'});
                }
                else if(window.innerWidth>1824 && window.innerHeight>2736) {
                    $(".from_tat_select2").select2({width: '250'});
                    $(".to_tat_select2").select2({width: '250'});
                }
                else {
                    $(".from_tat_select2").select2({width: '250'});
                    $(".to_tat_select2").select2({width: '250'});
                }
            }
        }
        handleScreenSize();
        window.addEventListener("resize", handleScreenSize);

        $(document).ready(function() {
            var datePicker = $('#consolidate_date_range');
            var initialOptions={
                maxDate: new Date(),
                opens: 'center'
            };
            datePicker.daterangepicker(initialOptions);

            function adjustCalendarPosition() {
                var container = datePicker.data('daterangepicker').container;
                var calendar = container.find('.calendar');
                if (window.matchMedia('(max-width: 280px) and (max-height: 653px)').matches) { // fold
                    container.css({opens: 'center', width: '250px', display: 'flex',
                        'flex-direction': 'column-reverse', alignItems: 'flex-start'});
                    calendar.css({left: 'initial'});
                    container.hide();
                }else if (window.matchMedia('(max-width: 375px) and (max-height: 667px)').matches) { //se
                    container.css({opens: 'center', width: '330px', display: 'flex',
                        'flex-direction': 'column-reverse', 'align-items': 'flex-start'});
                    calendar.css({width: '100%', left: 'initial', transform: 'translateX(8%)'});
                    container.hide();
                }else if (window.matchMedia('(max-width: 360px) and (max-height: 740px)').matches) { //s8 s20
                    container.css({opens: 'center', width: '310px', display: 'flex', 'flex-direction': 'column-reverse'});
                    calendar.css({width: '100%', left: 'initial', transform: 'translateX(4%)'});
                    container.hide();
                }else if (window.matchMedia('(max-width: 390px) and (max-height: 915px)').matches) { //12pro
                    container.css({opens: 'center', width: '335px', display: 'flex', 'flex-direction': 'column-reverse'});
                    calendar.css({width: '100%', left: 'initial', transform: 'translateX(10%)'});
                    container.hide();
                }else if (window.matchMedia('(max-width: 412px) and (max-height: 915px)').matches) { //pixel5, s8
                    container.css({opens: 'center', width: '350px', display: 'flex', 'flex-direction': 'column-reverse'});
                    calendar.css({width: '100%', left: 'initial', transform: 'translateX(10%)'});
                    container.hide();
                } else if (window.matchMedia('(max-width: 414px) and (max-height: 912px)').matches) {//xr
                    container.css({opens: 'center', width: '360px', display: 'flex', 'flex-direction': 'column-reverse'});
                    calendar.css({width: '100%', left: 'initial', transform: 'translateX(12%)'});
                    container.hide();
                } else if (window.matchMedia('(max-width: 540px) and (max-height: 720px)').matches) {
                    container.css({opens: 'center', width: '500px'});
                    calendar.css({left: 'initial'});
                    container.hide();
                }else {
                    container.css({opens: 'center', width: 'auto'});
                    calendar.css({left: 'initial'});
                }
            }
            adjustCalendarPosition();
            $(window).addEventListener('resize',function(){
                adjustCalendarPosition();
            });
        });


        window.onload = function () {

            var referred = [];
            var redirected = [];
            var transferred = [];
            var refer_to_accept = [];
            var redirect_to_accept = [];
            var transfer_to_accept = [];
            $.each(<?php echo json_encode($data_points); ?>,function(index,data){
                referred.push({
                    "label" : data.date,
                    "y" : data.referred
                });
                refer_to_accept.push({
                    y : data.refer_to_accept ? data.refer_to_accept : '',
                    details : data.refer_to_accept_details,
                    indexLabel : `${data.refer_to_accept_details?.length ?? 0} : ${(data.refer_to_accept ? data.refer_to_accept : '')}`,
                });

                redirected.push({
                    "label" : data.date,
                    "y" : data.redirected
                });
                redirect_to_accept.push({
                    y : data.redirect_to_accept ? data.redirect_to_accept : '',
                    details : data.redirect_to_accept_details,
                    indexLabel: `${data.redirect_to_accept_details?.length ?? 0} : ${(data.redirect_to_accept ? data.redirect_to_accept : '')}`
                });

                transferred.push({
                    "label" : data.date,
                    "y" : data.transferred
                });
                transfer_to_accept.push({
                    y : data.transfer_to_accept ? data.transfer_to_accept : '',
                    details : data.refer_to_accept_details
                });
            });

            var title = "Turn Around Time - Incoming";

            @if($facility_select_from && $facility_select_to)
                title += " ("+"<?php echo $facility_name_from; ?>"+" to "+"<?php echo $facility_name_to ?>"+")";
            @elseif($facility_select_to)
                title += " ("+"<?php echo $facility_name_to; ?>"+")";
            @endif

            var chart = new CanvasJS.Chart("chartContainer", {
                title:{
                    text: title,
                    fontSize: 20,
                },
                axisY: {
                    title: "Number of Referral",
                    lineColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    gridThickness: 0
                },
                axisY2: {
                    title: "Minutes",
                    suffix: "",
                    gridThickness: 0,
                    lineColor: "#C0504E",
                    tickColor: "#C0504E",
                    labelFontColor: "#C0504E"
                },
                data: [
                    {
                        type: "column",
                        color: '#40ffc5',
                        dataPoints: referred
                    },
                    {
                        type: "column",
                        color: '#050ab9',
                        dataPoints: redirected
                    },
                    {
                        type: "column",
                        color: '#98b92c',
                        dataPoints: transferred
                    }
                ]

            });
            chart.render();
            createPareto();

            function createPareto() {
                chart.addTo("data", {
                    type:"line",
                    axisYType: "secondary",
                    yValueFormatString: "0.##\"\"",
                    indexLabel: "{y}",
                    indexLabelFontColor: "#C24642",
                    mouseover: function(e) {
                        e.dataPoint.cursor = "pointer";
                        chart.render();
                    },
                    dataPoints: refer_to_accept,
                    click: handleClick
                });
                chart.addTo("data", {
                    type:"line",
                    axisYType: "secondary",
                    yValueFormatString: "0.##\"\"",
                    indexLabel: "{y}",
                    indexLabelFontColor: "#C24642",
                    mouseover: function(e) {
                        e.dataPoint.cursor = "pointer";
                        chart.render();
                    },
                    dataPoints: redirect_to_accept,
                    click: handleClick
                });
                chart.addTo("data", {
                    type:"line",
                    axisYType: "secondary",
                    yValueFormatString: "0.##\"\"",
                    indexLabel: "{y}",
                    indexLabelFontColor: "#C24642",
                    mouseover: function(e) {
                        e.dataPoint.cursor = "pointer";
                        chart.render();
                    },
                    dataPoints: transfer_to_accept,
                    click: handleClick
                });
            }

            function handleClick(e) {
                //console.log("Data Point: ", e.dataPoint.x, e.dataPoint.y, e.dataPoint.details);
                if(user_level === "mayor" || user_level === "dmo") return;
                $("#statistics-modal").modal('show');
                $(".statistics-body").html(loading);
                setTimeout(function() {
                    $(".statistics-title").html(e.dataPoint.details[0]["status"]);
                    $(".statistics-body").html(
                        "<table id=\"table\" class='table table-hover table-bordered' style='font-size: 9pt;'>\n" +
                        "    <tr class='bg-success'><th></th><th class='text-green'>Code</th><th class='text-green'>TAT</th><th class='text-green'>Date Referred</th><th class='text-green'>Accepted Date</th></tr>\n" +
                        "</table>"
                    );
                    jQuery.each(e.dataPoint.details, function(index, value) {
                        var track_url = "<?php echo asset('doctor/referred?referredCode='); ?>"+value["code"];
                        var tr = $('<tr />');
                        tr.append("<a href='"+track_url+"' class=\"btn btn-xs btn-success\" target=\"_blank\">\n" +
                            "<i class=\"fa fa-stethoscope\"></i> Track\n" +
                            "</a>");
                        tr.append( $('<td />', { text : value["code"] } ));
                        tr.append( $('<td />', { text : timeDiffCalc(new Date(value["date_accepted"]),new Date(value["date_"+value["status"]])) } ));
                        // tr.append( $('<td />', { text : getMinutesBetweenDates(new Date(value["date_accepted"]),new Date(value["date_"+value["status"]])) } ));
                        tr.append( $('<td />', { text : value["date_"+value["status"]+"_format"] } ));
                        tr.append( $('<td />', { text : value["date_accepted_format"] } ));
                        $("#table").append(tr);
                    });
                },500);
            }

            function getMinutesBetweenDates(startDate, endDate) {
                const diff = endDate.getTime() - startDate.getTime();
                const minutes = Math.floor(diff / (1000 * 60));
                return minutes;
            }
        }

        @if($province_select_from)
        onChangeProvinceFrom("<?php echo $province_select_from; ?>");
        @endif
        function onChangeProvinceFrom(province_id) {
            $('.loading').show();
            if(province_id){
                var url = "{{ url('location/select/facility/byprovince') }}";
                $.ajax({
                    url: url+'/'+province_id,
                    type: 'GET',
                    success: function(data){
                        $("#facility").select2("val", "");
                        $('#facility').empty()
                            .append($('<option>', {
                                value: '',
                                text : 'Select All Facility'
                            }));
                        var facility_select = "<?php echo $facility_select; ?>";
                        jQuery.each(data, function(i,val){
                            $('#facility').append($('<option>', {
                                value: val.id,
                                text : val.name
                            }));
                        });
                        $('#facility option[value="'+facility_select+'"]').attr("selected", "selected");
                        $('.loading').hide();
                    },
                    error: function(e){
                        console.log(e)
                    }
                });
            } else {
                $('.loading').hide();
                $("#facility").select2("val", "");
                $('#facility').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select All Facility'
                    }));
            }
        }

        @if($province_select_from)
            onChangeProvinceFrom("<?php echo $province_select_from; ?>");
        @endif
        function onChangeProvinceFrom(province_id) {
            $('.loading').show();
            if(province_id){
                var url = "{{ url('location/select/facility/byprovince') }}";
                $.ajax({
                    url: url+'/'+province_id,
                    type: 'GET',
                    success: function(data){
                        $("#facility_from").select2("val", "");
                        var facility_select_id = "<?php echo $facility_select_from; ?>";
                        var facility_select_text = "<?php echo \App\Facility::find($facility_select_from)->name; ?>";
                        $('#facility_from').empty()
                            .append($('<option>', {
                                value: facility_select_id,
                                text : facility_select_text
                            }));
                        $("#facility_from").next().children().children().children().eq(0).attr("title",facility_select_text).append(facility_select_text);
                        jQuery.each(data, function(i,val){
                            if(facility_select_id != val.id) {
                                $('#facility_from').append($('<option>', {
                                    value: val.id,
                                    text : val.name
                                }));
                            }
                        });
                        $('.loading').hide();
                    },
                    error: function(e){
                        console.log(e)
                    }
                });
            } else {
                $('.loading').hide();
                $("#facility_from").next().children().children().children().eq(0).attr("title","").empty();
            }
        }

        @if($province_select_to)
            onChangeProvinceTo("<?php echo $province_select_to; ?>");
        @endif
        function onChangeProvinceTo(province_id) {
            $('.loading').show();
            if(province_id){
                var url = "{{ url('location/select/facility/byprovince') }}";
                $.ajax({
                    url: url+'/'+province_id,
                    type: 'GET',
                    success: function(data){
                        $("#facility_to").select2("val", "");
                        var facility_select_id = "<?php echo $facility_select_to; ?>";
                        var facility_select_text = "<?php echo \App\Facility::find($facility_select_to)->name; ?>";
                        $('#facility_to').empty()
                            .append($('<option>', {
                                value: facility_select_id,
                                text : facility_select_text
                            }));
                        $("#facility_to").next().children().children().children().eq(0).attr("title",facility_select_text).append(facility_select_text);
                        jQuery.each(data, function(i,val){
                            if(facility_select_id != val.id) {
                                $('#facility_to').append($('<option>', {
                                    value: val.id,
                                    text: val.name
                                }));
                            }
                        });
                        $('.loading').hide();
                    },
                    error: function(e){
                        console.log(e)
                    }
                });
            } else {
                $('.loading').hide();
                $("#facility_to").select2("val", "");
                $('#facility_to').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select All Facility'
                    }));
            }
        }

        @if($facility_select_to)
            onChangeFacilityTo("<?php echo $facility_select_to; ?>");
        @endif
        function onChangeFacilityTo(facility_id) {
            var id = facility_id;
            var url = "{{ url('location/facility/') }}";
            if (id) {
                var department_select_to = "<?php echo $department_select_to; ?>";
                $.ajax({
                    url: url+'/'+id,
                    type: 'GET',
                    success: function(data) {
                        $('#department_to').empty()
                            .append($('<option>', {
                                value: '',
                                text : 'Please select department to'
                            }));
                        jQuery.each(data.departments, function(i,val){
                            $('#department_to').append($('<option>', {
                                value: val.id,
                                text : val.description
                            }));
                        });
                        if(department_select_to)
                            $("#department_to").val(department_select_to);
                    },
                    error: function(e){
                        console.log(e)
                    }
                });
            }
        }

        function timeDiffCalc(dateFuture, dateNow) {
            let diffInMilliSeconds = Math.abs(dateFuture - dateNow) / 1000;

            // calculate days
            const days = Math.floor(diffInMilliSeconds / 86400);
            diffInMilliSeconds -= days * 86400;

            // calculate hours
            const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
            diffInMilliSeconds -= hours * 3600;

            // calculate minutes
            const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
            diffInMilliSeconds -= minutes * 60;

            let difference = '';
            if (days > 0) {
                difference += (days === 1) ? `${days} day, ` : `${days} days, `;
            }

            difference += (hours === 0 || hours === 1) ? `${hours} hour, ` : `${hours} hours, `;

            difference += (minutes === 0 || hours === 1) ? `${minutes} minutes` : `${minutes} minutes`;

            return difference;
        }

        function referToSeenPeak() {
            if(user_level === "mayor" || user_level === "dmo") return;
            $("#statistics-modal").modal('show');
            $(".statistics-body").html(loading);
            setTimeout(function() {
                //$(".statistics-title").html('');
                $(".statistics-title").html('Refer to Seen');
                $(".statistics-body").html(
                    "<table id=\"table\" class='table table-hover table-bordered' style='font-size: 9pt;'>\n" +
                    "    <tr class='bg-success'><th></th><th class='text-green'>Code</th><th class='text-green'>TAT</th><th class='text-green'>Date Referred</th><th class='text-green'>First Seened Date</th></tr>\n" +
                    "</table>"
                );
                jQuery.each(<?php echo json_encode($refer_to_seen_details); ?>, function(index, value) {
                    var track_url = "<?php echo asset('doctor/referred?referredCode='); ?>"+value["code"];
                    var tr = $('<tr />');
                    tr.append("<a href='"+track_url+"' class=\"btn btn-xs btn-success\" target=\"_blank\">\n" +
                        "<i class=\"fa fa-stethoscope\"></i> Track\n" +
                        "</a>");
                    tr.append( $('<td />', { text : value["code"] } ));
                    tr.append( $('<td />', { text : timeDiffCalc(new Date(value["date_referred"]),new Date(value["date_seened"])) } ));
                    tr.append( $('<td />', { text : value["date_referred_format"] } ));
                    tr.append( $('<td />', { text : value["date_seened_format"] } ));
                    $("#table").append(tr);
                });

            },500);
        }
    </script>
@endsection

