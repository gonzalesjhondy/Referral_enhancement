<?php
$error = \Illuminate\Support\Facades\Input::get('error');
?>
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="jim-content">
                <form action="{{ asset('admin/report/top/icd') }}" method="GET" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <span class="text-green" style="font-size: 17pt;">Top 10 ICD-10 Diagnosis </span>
                        <span style="font-size: 12pt;"><i>as of </i></span>
                        <?php $date_range = date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)); ?>
                        <select name="request_type" class="form-control" style="width: 200px;">
                            <option name="request_type" value="incoming" @if(empty($request_type) || $request_type == 'incoming') selected @endif>Incoming</option>
                            <option name="request_type" value="outgoing" @if($request_type == 'outgoing') selected @endif>Outgoing</option>
                        </select>
                        <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" id="consolidate_date_range">
                        <select name="province_id" id="" class="form-control">
                            <option value="">Select Province</option>
                            @foreach(\App\Province::get() as $prov)
                                <option value="{{ $prov->id }}" <?php if($prov->id == $province_id) echo 'selected'; ?>>{{ $prov->description }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-md btn-info"><i class="fa fa-search"></i> Filter</button>
                        <button type="button" class="btn btn-md btn-warning" onClick="window.location.href = '{{ asset('admin/report/top/icd') }}'"><i class="fa fa-search"></i> View All</button>
                        <a href="{{ asset('excel/export/top_icd/all') }}" class="btn btn-danger" target="_blank">
                            <i class="fa fa-file-excel-o"></i> Export Excel
                        </a>
                    </div>
                </form><br>
                <div class="box-body table-responsive no-padding">
                    <table class="table">
                        <tbody>
                        <tr class="bg-success">
                            <th>Code</th>
                            <th>Description</th>
                            <th>Count</th>
                        </tr>
                        @foreach($icd as $top)
                        <?php
                            $pie_chart_data[] = [
                                "label" => $top->code,
                                "y" => $top->count
                            ];
                        ?>
                        <tr>
                            <td>{{ $top->code }}</td>
                            <td>{{ $top->description }}</td>
                            <td>
                                <label onclick="topIcdData($(this),'{{ $date_start }}','{{ $date_end }}','{{ $top->icd_id }}')" >{{ $top->count }}</label>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-success">
                <div id="top_icd" style="height: 300px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="top-icd-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-xs-10">
                            <h3 class="modal-title top-icd-title"></h3>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="close" style="float: right" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body top-icd-body">
                    ...
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('excel/export/top_icd') }}" class="btn btn-danger" target="_blank">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @include('script.chart')
    <script>
        $('#consolidate_date_range').daterangepicker({
            minDate:new Date("2022-01-13")
        });

        window.onload = function() {

            var options = {
                title: {
                    text: "Top 10 Icd-10 Diagnosis",
                    fontFamily: "Arial"
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
                    dataPoints: <?php echo json_encode($pie_chart_data); ?>
                }]
            };
            $("#top_icd").CanvasJSChart(options);
        }

        function topIcdData(data, date_start, date_end, icd_id){
            $(".top-icd-title").html('');
            $("#top-icd-modal").modal('show');
            $(".top-icd-body").html(loading);
            $("label").css("background-color","");
            data.css("background-color","yellow");
            var url = "<?php echo asset('admin/report/top/icd_filter'); ?>"+"?date_start="+date_start+"&date_end="+date_end+"&icd_id="+icd_id;
            var title_flag = true;
            $.get(url,function(result) {
                setTimeout(function() {
                    $(".top-icd-body").html(
                        "<table id=\"table\" class='table table-hover table-bordered' style='font-size: 9pt;'>\n" +
                        "    <tr class='bg-success'><th></th><th class='text-green'>Code</th><th class='text-green'>Patient Name</th><th class='text-green'>Address</th><th class='text-green'>Age</th><th class='text-green'>ICD Code</th><th class='text-green'>ICD Description</th></tr>\n" +
                        "</table>"
                    );
                    jQuery.each(result, function(index, value) {
                        if(title_flag) {
                            $(".top-icd-title").html(value["icd_description"]+' <span class="badge bg-yellow data_count">'+result.length+'</span>');
                            title_flag = false;
                        }
                        var track_url = "<?php echo asset('doctor/referred?referredCode='); ?>"+value["code"];
                        var tr = $('<tr />');
                        tr.append("<a href='"+track_url+"' class=\"btn btn-xs btn-success\" target=\"_blank\">\n" +
                            "<i class=\"fa fa-stethoscope\"></i> Track\n" +
                            "</a>");
                        tr.append( $('<td />', { text : value["code"] } ));
                        tr.append( $('<td />', { text : value["patient_name"] } ));
                        tr.append( $('<td />', { text : value["province"]+", "+value["muncity"]+", "+value["barangay"] } ));
                        tr.append( $('<td />', { text : value["age"] } ));
                        tr.append( $('<td />', { text : value["icd_code"] } ));
                        tr.append( $('<td />', { text : value["icd_description"] } ));
                        $("#table").append(tr);
                    });
                },500);
            });
        }
    </script>
@endsection

