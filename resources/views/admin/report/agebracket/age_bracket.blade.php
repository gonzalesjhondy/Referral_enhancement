<?php
$error = \Illuminate\Support\Facades\Input::get('error');
$overall_count = 0;
foreach($data as $row) {
    $type = $row['type'];
    $male = count($row['male']);
    $female = count($row['female']);
    $overall_count += ($male + $female);
    $data2 = "";
    if($male > 0 || $female > 0) {
        $data2 = [
            [
                'label' => 'Male',
                'y' => $male
            ],
            [
                'label' => 'Female',
                'y' => $female
            ]
        ];
    }

    if($type == 'infant')
        $infant_data = $data2;
    else if($type == 'teen')
        $teen_data = $data2;
    else if($type == 'adult')
        $adult_data = $data2;
    else if($type == 'senior')
        $senior_data = $data2;
}

$facilities = \App\Facility::where('status', 1)->where('referral_used','yes')->orderBy('name','asc')->get();
$provinces = \App\Province::all();
?>
@extends('layouts.app')

<style>
    .center {
        text-align: center;
        border: 3px solid green;
    }
    label, span {
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
    <div class="box box-success">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ asset('admin/report/agebracket') }}" method="GET" class="form-inline">
                    {{ csrf_field() }}
                    <span class="text-green" style="font-size: 17pt;">Report by Age Bracket </span>&ensp;&ensp;&ensp;&ensp;
                    <div class="row">
                        <?php $date_range = date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)); ?>
                        <div class="col-md-3">
                            <select name="facility" class="select2" style="width:100%;">
                                <option value="">Select facility...</option>
                                @foreach($facilities as $faci)
                                    <option value="{{ $faci->id }}" @if($facility == $faci->id) selected @endif>{{ $faci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-9">
                            <select name="province" class="form-control">
                                <option value="">Select province...</option>
                                @foreach($provinces as $pro)
                                    <option value="{{ $pro->id }}" @if($province == $pro->id) selected @endif>{{ $pro->description }}</option>
                                @endforeach
                            </select>
                            <select name="request_type" id="request_type" class="form-control" style="width: 200px;">
                                <option value="incoming" @if(empty($request_type) || $request_type == 'incoming') selected @endif>Incoming</option>
                                <option value="outgoing" @if($request_type == 'outgoing') selected @endif>Outgoing</option>
                            </select>
                            <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" id="date_range">

                            <button type="submit" class="btn btn-md btn-info"><i class="fa fa-search"></i> Filter</button>
                            <button type="button" class="btn btn-md btn-warning" onClick="window.location.href = '{{ asset('admin/report/agebracket') }}'"><i class="fa fa-eye"></i> View All</button>
                        </div>
                    </div>
                </form><br>
                <div class="row" id="overall_col">
                    <div class="col-lg-6 text-center">
                        <div id="overall_chart" style="height: 300px; width: 100%;"></div>
                    </div>
                    <div class="col-lg-6 text-center" id="infant_col">
                        <div id="infant_chart" style="height: 300px; width: 100%;"></div><br>
                    </div>
                    <div class="col-lg-6" id="teen_col">
                        <div id="teen_chart" style="height: 300px; width: 100%;"></div>
                    </div>
                    <div class="col-lg-6" id="adult_col">
                        <div id="adult_chart" style="height: 300px; width: 100%;"></div><br>
                    </div>
                    <div class="col-lg-6" id="senior_col">
                        <div id="senior_chart" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered table-fixed-header">
                        <thead class='header'>
                        <tr class="bg-success" style="font-size: 17px;">
                            <th>Age Bracket</th>
                            <th class="text-center">
                                <div class="tooltip1">Male
                                    <span class="tooltiptext">Number of male patients</span>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="tooltip1">Female
                                    <span class="tooltiptext">Number of female patients</span>
                                </div>
                            </th>
                            <th class="text-center">Total Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($data as $row)
                            <?php
                            $overall_data[] = [
                                "label" => $row['description'],
                                "y" => count($row['male']) + count($row['female'])
                            ];
                            ?>
                            <tr @if($counter % 2 == 0) style="background-color: #f1f2f3;" @endif>
                                <td width="40%">{{ $row['description'] }}</td>
                                <td width="20%" class="text-center">
                                    <span class="text-blue" style="font-size: 18px" onclick="showAgeModal($(this),'{{ $date_start }}','{{ $date_end }}','{{ $row['type'] }}','Male','{{ $row['description'] }}')"> {{ count($row['male']) }} </span>
                                </td>
                                <td width="20%" class="text-center">
                                    <span class="text-blue" style="font-size: 18px" onclick="showAgeModal($(this),'{{ $date_start }}','{{ $date_end }}','{{ $row['type'] }}','Female','{{ $row['description'] }}')"> {{ count($row['female']) }} </span>
                                </td>
                                <td class="text-center">
                                    <label class="text-blue" style="font-size: 18px" onclick="showAgeModal($(this),'{{ $date_start }}','{{ $date_end }}','{{ $row['type'] }}','all','{{ $row['description'] }}')"> {{ count($row['male']) + count($row['female']) }} </label>
                                </td>
                            </tr>
                            <?php $counter++;?>
                        @endforeach
                        </tbody>
                    </table><br>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="age_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-10">
                            <h3 class="modal-title age_bracket_title"></h3>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="close closeModalBtn" style="float: right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body age_bracket_body">
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('excel/export/age_bracket') }}" class="btn btn-danger" target="_blank">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>
                    <button type="button" class="btn btn-secondary closeModalBtn"  data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @include('script.chart')
    <script>
        $('#date_range').daterangepicker();

        window.onload = function() {
            var overall_data = {{ $overall_count }};
            if(overall_data > 0) {
                var overall = {
                    title: {
                        text: "Overall",
                        fontFamily: "Calibri"
                    },
                    legend: {
                        horizontalAlign: "center", // "center" , "right"
                        verticalAlign: "top"  // "top" , "bottom"
                    },
                    animationEnabled: true,
                    data: [{
                        type: "pie",
                        startAngle: 45,
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabel: "{label} ({y})",
                        yValueFormatString: "#,##0.#" % "",
                        dataPoints: <?php echo json_encode($overall_data); ?>
                    }]
                };
                $("#overall_chart").CanvasJSChart(overall);
            } else {
                $('#overall_col').addClass('hide');
            }

            var infant_data = <?php echo json_encode($infant_data)?>;
            if(infant_data != null && infant_data != "") {
                var infant = {
                    title: {
                        text: "Infant/Toddler",
                        fontFamily: "Calibri"
                    },
                    legend: {
                        horizontalAlign: "center", // "center" , "right"
                        verticalAlign: "top"  // "top" , "bottom"
                    },
                    animationEnabled: true,
                    data: [{
                        type: "pie",
                        startAngle: 45,
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabel: "{label} ({y})",
                        yValueFormatString:"#,##0.#"%"",
                        dataPoints: infant_data
                    }]
                };
                $("#infant_chart").CanvasJSChart(infant);
            } else{
                $('#infant_col').addClass('hide');
            }

            var teen_data = <?php echo json_encode($teen_data)?>;
            if(teen_data != null && teen_data != "") {
                var teen = {
                    title: {
                        text: "Teen",
                        fontFamily: "Calibri"
                    },
                    legend: {
                        horizontalAlign: "center", // "center" , "right"
                        verticalAlign: "top"  // "top" , "bottom"
                    },
                    animationEnabled: true,
                    data: [{
                        type: "pie",
                        startAngle: 45,
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabel: "{label} ({y})",
                        yValueFormatString: "#,##0.#" % "",
                        dataPoints: teen_data
                    }]
                };
                $("#teen_chart").CanvasJSChart(teen);
            } else {
                $('#teen_col').addClass('hide');
            }

            var adult_data = <?php echo json_encode($adult_data)?>;
            if(adult_data != null && adult_data != "") {
                var adult = {
                    title: {
                        text: "Adult",
                        fontFamily: "Calibri"
                    },
                    legend: {
                        horizontalAlign: "center", // "center" , "right"
                        verticalAlign: "top"  // "top" , "bottom"
                    },
                    animationEnabled: true,
                    data: [{
                        type: "pie",
                        startAngle: 45,
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabel: "{label} ({y})",
                        yValueFormatString: "#,##0.#" % "",
                        dataPoints: adult_data
                    }]
                };
                $("#adult_chart").CanvasJSChart(adult);
            } else {
                $('#adult_col').addClass('hide');
            }

            var senior_data = <?php echo json_encode($senior_data)?>;
            if(senior_data != null && senior_data != "") {
                var senior = {
                    title: {
                        text: "Senior",
                        fontFamily: "Calibri"
                    },
                    legend: {
                        horizontalAlign: "center", // "center" , "right"
                        verticalAlign: "top"  // "top" , "bottom"
                    },
                    animationEnabled: true,
                    data: [{
                        type: "pie",
                        startAngle: 45,
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabel: "{label} ({y})",
                        yValueFormatString: "#,##0.#" % "",
                        dataPoints: senior_data
                    }]
                };
                $("#senior_chart").CanvasJSChart(senior);
            } else {
                $('#senior_col').addClass('hide')
            }
        };

        function showAgeModal(data, date_start, date_end, desc, sex) {
            $(".age_bracket_title").html("");
            $('#age_modal').modal('show');
            $('.age_bracket_body').html(loading);
            $("label").css("background-color","");
            data.css("background-color","yellow");
            var request_type = $('#request_type').val();

            var url = "<?php echo asset('admin/report/agebracket/filter'); ?>";
            var json = {
                "_token" : "<?php echo csrf_token(); ?>",
                "desc" : desc,
                "date_start" : date_start,
                "date_end" : date_end,
                "sex" : sex,
                "type" : request_type,
                "getInfo" : true
            };
            $.post(url,json,function(result){
                $('.age_bracket_body').html(result);
            });
            $('.closeModalBtn').on('click', function() {
                data.css("background-color","");
            });
            $('#age_modal').on('hide.bs.modal', function() {
                data.css("background-color","");
            });
        }
    </script>
@endsection

