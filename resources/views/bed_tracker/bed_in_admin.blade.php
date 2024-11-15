@extends('layouts.app')

@section('content')
    <style>
        .editable-empty{
            color: #ff3d3c;
        }
        .tooltip-ex { /* Container for our tooltip */
            position: relative;
            display: inline-block;
        }

        .tooltip-ex .tooltip-ex-text { /* This is for the tooltip text */
            visibility: hidden;
            width: 100px;
            background-color: #00a65a;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 10px; /* This defines tooltip text position */
            position: absolute;
            z-index: 1;
        }

        .tooltip-ex:hover .tooltip-ex-text { /* Makes tooltip text visible when text is hovered on */
            visibility: visible;
        }
    </style>
    <div class="box box-success">
        <div class="box-body">
            <div class="box-header with-border">
                <h5>Bed Availability Status as of <span id="time"></span></h5>
            </div>
            <form action="" method="GET">
                <div class="row" style="width: 70%">
                    <div class="col-md-4">
                        <select name="province" class="form-control" onchange="onChangeProvince($(this).val())">
                            <option value="">Select All Province</option>
                            @foreach($province as $pro)
                                <option value="{{ $pro->id }}" <?php if(isset($province_select)){if($pro->id == $province_select)echo 'selected';} ?>>{{ $pro->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="facility" id="facility" class="select2">
                            <option value="{{ $facility_select }}">Select All Facility</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter" onclick="loadPage()"></i> Filter</button>
                            <a href="{{ asset('bed_export') }}" type="button" class="btn btn-danger"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            <button type="button" class="btn btn-warning" onclick="refreshPage()"><i class="fa fa-eye"></i> View All</button>
                        </span>
                    </div>
                </div>
            </form><br>
            <section class="content-area">
                <div style="font-size: 6pt;" class="table-responsive">
                    <table class="table table-striped table-fixed-header" border="1">
                        <thead class='header'>
                        <tr >
                            <th rowspan="4" class="info" style="vertical-align: middle;border: black;"><center>Name of Hospital</center></th>
                            <th class="success" style="vertical-align: middle;border: black" rowspan="4"><center>Hospital Category</center></th>
                            <th style="background-color: rgb(251, 233, 218);border-top: black;" colspan="20"><center>Number of Available Beds</center></th>
                            <th style="border-top: black;" class="info" colspan="4"><center>Number of Waitlist</center></th>
                            <th class="bg-pink" style="background-color: #ffb3b8;width: 10%;vertical-align: middle;margin-left: 20px;border-top: black" rowspan="4"><center>Remarks</center></th>
                            <th class="bg-pink" style="background-color: #ffb3b8;vertical-align: middle;border-top: black;" rowspan="4"><center>Encoded By</center></th>
                        </tr>
                        <tr>
                            <th colspan="8" class="danger"><center>COVID BEDS</center></th>
                            <th class="info" colspan="2"><center>Mechanical Ventilators</center></th>
                            <th class="warning" colspan="8"><center>Non-COVID BEDS</center></th>
                            <th class="info" colspan="2"><center>Mechanical Ventilators</center></th>
                            <th class="danger" colspan="2" rowspan="2" style="vertical-align: middle"><center>COVID BEDS</center></th>
                            <th class="warning" colspan="2" rowspan="2" style="vertical-align: middle"><center>Non-COVID BEDS</center></th>
                        </tr>
                        <tr>
                            <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>Emergency Room (ER)</center></th>
                            <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>ICU - Intensive Care Units</center></th>
                            <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>COVID Beds</center></th>
                            <th colspan="2" class="success"><center>Isolation Beds</center></th>
                            <th class="info"><center>Used</center></th>
                            <th class="info"><center>Vacant</center></th>
                            <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>Emergency Room (ER)</center></th>
                            <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>ICU - Intensive Care Units</center></th>
                            <th colspan="2" style="background-color: rgb(252, 233, 219);"><center>Regular Beds</center></th>
                            <th colspan="2" class="success"><center>Isolation Beds</center></th>
                            <th class="info"><center>Used</center></th>
                            <th class="info"><center>Vacant</center></th>
                        </tr>
                        <tr>
                            <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                            <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                            <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                            <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                            <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                            <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                            <th class="success">Vacant</th>
                            <th class="success">Occupied</th>
                            <th class="info"></th>
                            <th class="info"></th>
                            <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                            <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                            <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                            <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                            <th style="background-color: rgb(252, 233, 219);">Vacant</th>
                            <th style="background-color: rgb(252, 233, 219);">Occupied</th>
                            <th class="success">Vacant</th>
                            <th class="success">Occupied</th>
                            <th class="info"></th>
                            <th class="info"></th>
                            <th class="danger"><center>Emergency Room (ER)</center></th>
                            <th class="danger"><center>ICU - Intensive Care Units</center></th>
                            <th class="warning"><center>Emergency Room (ER)</center></th>
                            <th class="warning"><center>ICU - Intensive Care Units</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($facility as $row)
                            @if(!isset($facility_checker[$row->province]))
                                <?php $facility_checker[$row->province] = true; ?>
                                <tr>
                                    <th style="font-size: 14pt;" colspan="36">{{ strtoupper(\App\Province::find($row->province)->description) }} PROVINCE</th>
                                </tr>
                            @endif
                            <tr>
                                <td>
                                    <b class="text-green">{{ $row->name }}</b><br>
                                    <span class="text-yellow">({{ $row->contact }})</span>
                                </td>
                                <td><span class="text-green"><center>{{ ucfirst($row->level) }}</center></span></td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_covid_vacant ? $row->emergency_room_covid_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (Emergency Room (ER)) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_covid_occupied ? $row->emergency_room_covid_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (Emergency Room (ER)) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->icu_covid_vacant ? $row->icu_covid_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (ICU - Intensive Care Units) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->icu_covid_occupied ? $row->icu_covid_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (ICU - Intensive Care Units) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->beds_covid_vacant ? $row->beds_covid_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (COVID Beds) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->beds_covid_occupied ? $row->beds_covid_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (COVID Beds) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_covid_vacant ? $row->isolation_covid_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (Isolation Beds) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_covid_occupied ? $row->isolation_covid_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                (Isolation Beds) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_used_covid ? $row->mechanical_used_covid : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                Mechanical Ventilators<br>
                                                (Used)
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_vacant_covid ? $row->mechanical_vacant_covid : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                COVID BEDS<br>
                                                Mechanical Ventilators<br>
                                                (Used)
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_non_vacant ? $row->emergency_room_non_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (Emergency Room (ER)) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_non_occupied ? $row->emergency_room_non_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (Emergency Room (ER)) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->icu_non_vacant ? $row->icu_non_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (ICU - Intensive Care Units) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->icu_non_occupied ? $row->icu_non_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (ICU - Intensive Care Units) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->beds_non_vacant ? $row->beds_non_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (Regular Beds) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->beds_non_occupied ? $row->beds_non_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (Regular Beds) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_non_vacant ? $row->isolation_non_vacant : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (Isolation Beds) Vacant
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->isolation_non_occupied ? $row->isolation_non_occupied : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                (Isolation Beds) Occupied
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_used_non ? $row->mechanical_used_non : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                Mechanical Ventilators
                                                (Used)
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->mechanical_vacant_non ? $row->mechanical_vacant_non : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Non-COVID BEDS<br>
                                                Mechanical Ventilators
                                                (Vacant)
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_covid_wait ? $row->emergency_room_covid_wait : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Number of Waitlist<br>
                                                COVID BEDS
                                                (Emergency Room (ER))
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->icu_covid_wait ? $row->icu_covid_wait : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Number of Waitlist<br>
                                                COVID BEDS
                                                (ICU - Intensive Care Units)
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->emergency_room_non_wait ? $row->emergency_room_non_wait : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Number of Waitlist<br>
                                                Non-COVID BEDS
                                                (Emergency Room (ER))
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span class="htmlHigh">
                                        <span class="tooltip-ex">
                                            <span style="color: black !important;font-size: 10pt;">{{ $row->icu_non_wait ? $row->icu_non_wait : 0 }}</span>
                                            <span class="tooltip-ex-text">
                                                Number of Waitlist<br>
                                                Non-COVID BEDS
                                                (ICU - Intensive Care Units)
                                            </span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 7pt;">{{ $row->remarks }}</span>
                                </td>
                                <td style="font-size: 7pt;">
                                    <?php
                                        $encoded_by = \App\BedTracker::
                                                    select("bed_tracker.id","users.fname","users.mname","users.lname","bed_tracker.created_at")
                                                    ->leftJoin("users","users.id","=","bed_tracker.encoded_by")
                                                    ->where("bed_tracker.facility_id","=",$row->id)
                                                    ->where("users.level","!=","opcen")
                                                    ->orderBy("bed_tracker.id","desc")
                                                    ->first();
                                        $created_at = $encoded_by->created_at;
                                        $encoded_by = ucfirst($encoded_by->fname).' '.strtoupper($encoded_by->mname[0]).'. '.ucfirst($encoded_by->lname);
                                        echo $encoded_by;
                                    ?><br>
                                    @if($created_at)
                                        <small class="text-blue">{{ date("F d,Y",strtotime($created_at)) }}</small><br>
                                        <small class="text-yellow">({{ date('g:i a',strtotime($created_at)) }})</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>


@endsection

@section('js')
    <script src="{{ asset('resources/plugin/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>

    <script language='javascript' type='text/javascript'>
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });
    </script>

    <script>
        var timeDisplay = document.getElementById("time");
        function refreshTime() {
            var dateString = new Date().toLocaleString("en-US");
            var formattedString = dateString.replace(", ", " - ");
            timeDisplay.innerHTML = formattedString;
        }
        setInterval(refreshTime, 1000);

        //turn to inline mode
        $.fn.editable.defaults.mode = 'popup';
        //editables
        $(".text_editable").each(function(){
            $('#'+this.id).editable({
                type : 'textarea',
                name: 'username',
                title: $(this).data("title"),
                emptytext: 'empty',
                success: function(response, newValue) {
                    var url = "<?php echo asset('bed_update'); ?>";
                    var json = {
                        "_token" : "<?php echo csrf_token(); ?>",
                        "facility_id" : this.id,
                        "column" : 'remarks',
                        "value" : newValue
                    };
                    var title = $(this).data("title");
                    $.post(url,json,function(result){
                        console.log(result);
                        Lobibox.notify('success', {
                            title: "",
                            msg: title+" saved!",
                            size: 'mini',
                            rounded: true
                        });
                    });
                }
            });
        });

        @if($province_select)
        onChangeProvince("<?php echo $province_select; ?>");
        @endif
        function onChangeProvince($province_id){
            $('.loading').show();
            if($province_id){
                var url = "{{ url('bed_tracker/select/facility') }}";
                $.ajax({
                    url: url+'/'+$province_id,
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
                    error: function(){
                        $('#serverModal').modal();
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
    </script>
@endsection

