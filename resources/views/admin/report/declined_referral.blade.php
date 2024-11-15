<?php $user = Session::get('auth'); ?>
@extends('layouts.app')

@section('content')
    <style>
       
    </style>
    <div class="row col-md-12">
        <div class="box box-success">

        <div class="row">
                <div class="col-md-8">
                    <div class="box-header with-border">
                        <h3> Declined Report </h3>
                        <form action="{{ asset('admin/declined') }}" style="margin-top:20px;display:flex;" id="myForm" method="POST" class="form-inline">
                            {{ csrf_field() }}
                            <select name="inoutgoing" class="form-control" style="width:40%;" required>
                                <option value="">Select For</option>
                                <option value="referred_to">Incoming</option>
                                <option value="referred_from">Outgoing</option> 
                            </select>
                            <div class="form-group-sm" style="margin-bottom: 10px;display:flex;width:100%;">
                                <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" placeholder="Filter your daterange here..." id="consolidate_date_range"  style="width: 40%;height:35px;">
                                <button type="submit" class="btn btn-success btn-sm btn-flat">
                                    <i class="fa fa-search"></i> Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- <section class="content-header">
                <h1>
                    Declined Report
                    <small>Control panel</small>
                </h1>
            </section>
            <section class="content">
            </section>
            <div class="col-md-8">
                <div class="box-header with-border" style="margin-top: -240px;">
                    <div class="form-group">
                        <form id="filterForm" method="POST" action="{{ asset('admin/declined') }}">
                            {{ csrf_field() }} -->
                            <?php 
                            //$date_range = date("m/d/Y",strtotime($date_range_start)).' - '.date("m/d/Y",strtotime($date_range_end)); 
                            ?>
                            <!-- <div class="form-group" style="width:40%;">
                                <select name="inoutgoing" class="form-control" id="inoutgoing" required>
                                    <option value="">Select For</option>
                                    <option value="referred_to">Incoming</option>
                                    <option value="referred_from">Outgoing</option>
                                </select>
                            </div>
                            <div class="form-group-sm" style="margin-bottom: 10px;display:flex;width:100%;">
                                <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" placeholder="Filter your daterange here..." id="consolidate_date_range">
                                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Filter</button>
                            </div> -->
                            <!-- <div class="form-group col-md-4">
                                <input type="text" class="form-control" name="date_range" value="{{ $date_range }}" placeholder="Filter your daterange here..." id="consolidate_date_range">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Filter</button>
                            </div> -->
                        <!-- </form>
                    </div>
                </div>
            </div> -->
            <div class="box-body">
               
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-fixed-header"> 
                        <thead>
                            <tr>
                            <th scope="col">City</th>
                            <th scope="col">Total Referred</th>
                            <th scope="col">Total Declined</th>
                            <th scope="col">Percent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cebu Province</td>
                                <td>{{$data['cebu_province_referred']}}</td>
                                <td>{{$data['cebu_province_rejected']}}</td>
                                <td>
                                    @if($data['cebu_province_percent'] > 0)
                                        {{$data['cebu_province_percent']}}%
                                    
                                    @else
                                        0.00%
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Cebu City</td>
                                <td>{{$data['cebu_city_referred']}}</td>
                                <td>{{$data['cebu_city_rejected']}}</td>
                                <td>
                                     @if($data['cebu_city_percent'] > 0)
                                      {{$data['cebu_city_percent']}}%
                                    @else
                                        0.00%
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Mandaue City</td>
                                <td>{{$data['mandaue_city_referred']}}</td>
                                <td>{{$data['mandaue_city_rejected']}}</td>
                                <td>
                                    @if($data['mandaue_city_percent'] > 0)
                                    {{ $data['mandaue_city_percent'] }}%
                                    @else
                                        0.00%
                                    @endif
                                
                                </td>
                            </tr>
                            <tr>
                                <td>Lapu-Lapu City City</td>
                                <td>{{$data['lapulapu_city_referred']}}</td>
                                <td>{{$data['lapulapu_city_rejected']}}</td>
                                <td>
                                    @if($data['lapulapu_city_percent'] > 0)
                                        {{$data['lapulapu_city_percent']}}%
                                    @else
                                     0.00%
                                    @endif
                                    
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
            
            </div>
        </div>
    </div>



@endsection

@section('js')
    @include('script.filterMuncity')
    <script>
        $(".statistics_select2").select2({ width: '250px' });
        $("#statistics_referred").html("{{ $statistics_referred }}");
        $("#statistics_redirected").html("{{ $statistics_redirected }}");
        $("#statistics_transferred").html("{{ $statistics_transferred }}");
        $("#total_right").html("{{ $statistics_total }}");
        $('#consolidate_date_range').daterangepicker();

        // $('#filterForm').on('submit', function(event) {
        //         event.preventDefault(); // Prevent form submission

        //         $('#consolidate_date_range').daterangepicker({
        //     locale: {
        //     format: 'YYYY-MM-DD' // or any other date format you prefer
        //     },
        //     startDate: moment().startOf('year'), // set the initial start date to the beginning of the current year
        //     endDate: moment(), // set the initial end date to today
        //     minDate: '2021-01-01', // set the minimum selectable date to January 1, 2021
        //     // opens: 'left' // adjust to where you want the calendar to open 
        //     }, function(start, end, label) {
                
        //         var startDate = start.format('YYYY-MM-DD');
        //         var endDate = end.format('YYYY-MM-DD');
        //         console.log("Start Date: " + startDate);
        //         console.log("End Date: " + endDate);
        //     });


        //         var formData = $(this).serialize(); // Serialize form data
        //         console.log('formData', formData);
        //         // Make AJAX request to fetch filtered data
        //         $.ajax({
        //             url: '/your/filter/route', // Replace with your actual route
        //             type: 'GET', // Adjust the method as per your route configuration
        //             data: formData,
        //             success: function(response) {
        //                 // Update your table or data display area with filtered data
        //                 console.log(response); // Log the response for debugging
        //                 // Example: $('#dataTable').html(response);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(error); // Log any errors for debugging
        //             }
        //         });
        //     });



        //Date range picker
        // $('#consolidate_date_range').daterangepicker({
        //     locale: {
        //     format: 'YYYY-MM-DD' // or any other date format you prefer
        //     },
        //     startDate: moment().startOf('year'), // set the initial start date to the beginning of the current year
        //     endDate: moment(), // set the initial end date to today
        //     minDate: '2021-01-01', // set the minimum selectable date to January 1, 2021
        //     // opens: 'left' // adjust to where you want the calendar to open 
        // }, function(start, end, label) {
            
        //     var startDate = start.format('YYYY-MM-DD');
        //     var endDate = end.format('YYYY-MM-DD');
        //     console.log("Start Date: " + startDate);
        //     console.log("End Date: " + endDate);



        //     var url = "<?php echo url('admin/declined'); ?>";
        //     $.ajax({
        //         url: url,
        //         type: 'GET',
        //         data: {
        //             start_date: startDate,
        //             end_date: endDate
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             // Handle the response from the server
        //         },
        //         error: function(xhr) {
        //             console.error(xhr);
        //             // Handle errors here
        //         }
        //     });

    // You can now use startDate and endDate variables as needed
//});
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });

        
        var user_level = "<?php echo $user->level; ?>";
        var user_facility_id = "<?php echo $user->facility_id; ?>";

        function statisticsData(data,request_type,facility_id,status,date_range) {
            if(user_level === "mayor" || user_level === "dmo" || ( user_level === 'doctor' && user_facility_id !== facility_id )) {
                Lobibox.alert('error', {
                    msg: 'You are not authorized to view this data!'
                });
                return;
            }

            date_range = date_range.replace(/\//ig, "%2F");
            date_range = date_range.replace(/ /g, "+");

            console.log('datrange', date_range);

            var statistics_title = "";
            if(status === 'denied') {
                statistics_title = 'Recommend to Redirect';
            }
            else if(status === 'not_seen') {
                statistics_title = 'Not Seen';
            }
            else if (status === 'seen_only') {
                statistics_title = 'Seen Only';
            }
            $(".statistics-title").html(request_type.charAt(0).toUpperCase() + request_type.slice(1)+" Statistics - "+statistics_title+" ");
            $("#statistics-modal").modal('show');
            $(".statistics-body").html(loading);
            $("span").css("background-color","");
            data.css("background-color","yellow");
            var url = "<?php echo asset('api/individual'); ?>"+"?request_type="+request_type+"&facility_id="+facility_id+"&status="+status+"&date_range="+date_range;
            //console.log(url);
            $.get(url,function(result){
                setTimeout(function(){
                    $(".statistics-title").append('<span class="badge bg-yellow data_count">'+result.length+'</span>');
                    var statisticsBody = "<table id=\"table\" class='table table-hover table-bordered' style='font-size: 9pt;'>\n" +
                                            "<tr class='bg-success'><th></th><th class='text-green'>Code</th><th class='text-green'>Patient Name</th><th class='text-green'>Referring Doctor</th><th class='text-green'>Reason for Referral</th><th class='text-green'>Address</th><th class='text-green'>Age</th><th class='text-green'>Referring Facility</th><th class='text-green'>Referred Facility</th><th class='text-green'>Referred Date</th>";
                    if (['denied', 'cancelled'].includes(status)) {
                        statisticsBody += "<th class='text-green'>Remarks</th>";
                    }
                    statisticsBody += "</tr>\n" +
                                            "</table>";
                    $(".statistics-body").html(statisticsBody);

                    jQuery.each(result, function(index, value) {
                        var track_url = "<?php echo asset('doctor/referred?referredCode='); ?>"+value["code"];
                        var tr = $('<tr />');
                        tr.append("<a href='"+track_url+"' class=\"btn btn-xs btn-success\" target=\"_blank\">\n" +
                            "<i class=\"fa fa-stethoscope\"></i> Track\n" +
                            "</a>");
                        tr.append( $('<td />', { text : value["code"] } ));
                        tr.append( $('<td />', { text : value["patient_name"] } ));
                        tr.append( $('<td />', { text : value["referring_doctor"] } ));
                        tr.append( $('<td />', { text : value["reason_for_referral"] } ));
                        tr.append( $('<td />', { text : value["province"]+", "+value["muncity"]+", "+value["barangay"] } ));
                        tr.append( $('<td />', { text : value["age"] } ));
                        tr.append( $('<td />', { text : value["referring_facility"] } ));
                        tr.append( $('<td />', { text : value["referred_facility"] } ));
                        tr.append( $('<td />', { text : value["referred_date"] } ));
                        if(['denied', 'cancelled'].includes(status))
                            tr.append( $('<td />', { text : value["remarks"] } ));
                        $("#table").append(tr);
                    });

                },500);
            });
        }

        function clearRequiredFields() {
            $('.muncity').attr('required',false);
            $('.barangay').attr('required',false);
        }

        var province_id = null;
        var muncity_id = null;
        var barangay_id = null;
        @if($muncity_id)
            province_id = {{ $province_id }};
            muncity_id = "{{ $muncity_id }}";
            filterSidebar(province_id,'muncity',muncity_id);
        @endif
        @if($muncity_id && $barangay_id)
            muncity_id = "{{ $muncity_id }}";
            barangay_id = "{{ $barangay_id }}";
            filterSidebar(muncity_id,'barangay',null,barangay_id);
        @endif
        @if($facility_id)
            filterFacility('',"{{ $province_id }}","{{ $facility_id }}");
        @endif

        function getFacility(province_id) {
            $('.loading').show();
            var url = "{{ asset('vaccine/onchange/facility') }}"+"/"+province_id;
            var tmp = "";
            $.ajax({
                url: url,
                type: 'get',
                async: false,
                success : function(data){
                    tmp = data;
                    setTimeout(function(){
                        $('.loading').hide();
                    },500);
                }
            });
            return tmp;
        }

        function filterFacility(data, province_id = null, facility_id = null) {
            try {
                province_id = data.val();
            } catch(e) {

            }

            $('.facility').empty();
            var $newOption = $("<option selected='selected'></option>").val("").text('Please Select Facility');
            $('.facility').append($newOption).trigger('change');

            var result = getFacility(province_id);
            jQuery.each(result, function(i,val) {
                $('.facility').append($('<option>', {
                    value: val.id,
                    text : val.name
                }));
            });

            $('.facility').val(facility_id);
        }

    </script>
@endsection

