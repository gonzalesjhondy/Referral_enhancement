@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div style="background-color: white;padding: 10px;">
                <form action="{{ asset('admin/report/tat/outgoing') }}" method="GET" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group" style="width: 100%">
                        <span style="font-size: 12pt;"><i>as of </i></span>
                        <?php $date_range = date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)); ?>
                        <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" id="consolidate_date_range">
                        From:
                        <select name="province_from" class="form-control" onchange="onChangeProvinceFrom($(this).val())">
                            <option value="">Select All Province</option>
                            @foreach(\App\Province::get() as $pro)
                                <option value="{{ $pro->id }}" <?php if(isset($province_select_from)){if($pro->id == $province_select_from)echo 'selected';} ?>>{{ $pro->description }}</option>
                            @endforeach
                        </select>
                        <select name="facility_from" id="facility_from" class="from_tat_select2">

                        </select>
                        To:
                        <select name="province_to" class="form-control" onchange="onChangeProvinceTo($(this).val())">
                            <option value="">Select All Province</option>
                            @foreach(\App\Province::get() as $pro)
                                <option value="{{ $pro->id }}" <?php if(isset($province_select_to)){if($pro->id == $province_select_to)echo 'selected';} ?>>{{ $pro->description }}</option>
                            @endforeach
                        </select>
                        <select name="facility_to" id="facility_to" class="to_tat_select2">

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
                <div class="row" style="margin-top: 3%;">
                    <div class="col-sm-2 col-xs-6" style="cursor: pointer;" onclick="referToSeenPeak()">
                        <div class="description-block border-right">
                            <h5 class="description-header refer_to_seen">{{ $refer_to_seen }}</h5>
                            <span class="description-text">Refer to Seen</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $seen_to_accept }}</h5>
                            <span class="description-text">Seen to Accepted</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $seen_to_reject }}</h5>
                            <span class="description-text">Seen to Recommend to Redirect</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $accept_to_arrive }}</h5>
                            <span class="description-text">Accepted to Arrived</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $arrive_to_admit }}</h5>
                            <span class="description-text">Arrived to Admitted</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $admit_to_discharge }}</h5>
                            <span class="description-text">Admitted to Discharge</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
                <div class="row text-danger">
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $redirect_to_seen }}</h5>
                            <span class="description-text">REDIRECTED TO SEEN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $seen_to_accept_redirect }}</h5>
                            <span class="description-text">SEEN TO ACCEPTED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $seen_to_reject_redirect}}</h5>
                            <span class="description-text">Seen to Recommend to Redirect</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $accept_to_arrive_redirect }}</h5>
                            <span class="description-text">ACCEPTED TO ARRIVED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $arrive_to_admit_redirect }}</h5>
                            <span class="description-text">ARRIVED TO ADMITTED</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-2 col-xs-6">
                        <div class="description-block border-right">
                            <h5 class="description-header">{{ $admit_to_discharge_redirect }}</h5>
                            <span class="description-text">ADMITTED TO DISCHARGE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
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
        $(".from_tat_select2").select2({ width: '250px' });
        $(".to_tat_select2").select2({ width: '250px' });

        $('#consolidate_date_range').daterangepicker({
            maxDate: new Date()
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
                    details : data.refer_to_accept_details
                });

                redirected.push({
                    "label" : data.date,
                    "y" : data.redirected
                });
                redirect_to_accept.push({
                    y : data.redirect_to_accept ? data.redirect_to_accept : '',
                    details : data.redirect_to_accept_details
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

            var title = "Turn Around Time - Outgoing";

            @if($facility_select_from && $facility_select_to)
                title += " ("+"<?php echo $facility_name_from; ?>"+" to "+"<?php echo $facility_name_to ?>"+")";
            @elseif($facility_select_from)
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
                    $(".statistics-title").html('STATISTICS');
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
                        tr.append( $('<td />', { text : getMinutesBetweenDates(new Date(value["date_accepted"]),new Date(value["date_"+value["status"]])) } ));
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
                        $('#facility_from').empty()
                            .append($('<option>', {
                                value: '',
                                text : 'Select All Facility'
                            }));
                        var facility_select = "<?php echo $facility_select_from; ?>";
                        jQuery.each(data, function(i,val){
                            $('#facility_from').append($('<option>', {
                                value: val.id,
                                text : val.name
                            }));
                        });
                        $('#facility_from option[value="'+facility_select+'"]').attr("selected", "selected");
                        $('.loading').hide();
                    },
                    error: function(e){
                        console.log(e)
                    }
                });
            } else {
                $('.loading').hide();
                $("#facility_from").select2("val", "");
                $('#facility_from').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select All Facility'
                    }));
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
                        $('#facility_to').empty()
                            .append($('<option>', {
                                value: '',
                                text : 'Select All Facility'
                            }));
                        var facility_select = "<?php echo $facility_select_to; ?>";
                        jQuery.each(data, function(i,val){
                            $('#facility_to').append($('<option>', {
                                value: val.id,
                                text : val.name
                            }));
                        });
                        $('#facility_to option[value="'+facility_select+'"]').attr("selected", "selected");
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
            $("#statistics-modal").modal('show');
            $(".statistics-body").html(loading);
            setTimeout(function(){
                $(".statistics-title").append('Refer to Seen');
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

