<?php
$user = Session::get('auth');
$facilities = \App\Facility::select('id','name')
    ->where('referral_used','yes')
    ->orderBy('name','asc')->get();

$dateReportOnline = \Illuminate\Support\Facades\Session::get('dateReportOnline');
if(!$dateReportOnline)
    $dateReportOnline = date('m/d/Y');
?>
@extends('layouts.app')

@section('content')
    <style>
        label {
            padding: 0px !important;
        }
    </style>

    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3>{{ $title }}<br />
                    <small class="text-success">
                        {{ date('F d, Y',strtotime($dateReportOnline))}}
                    </small>
                </h3>
                <div>
                    <form action="{{ url('admin/report/online') }}" method="GET" class="form-inline">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <select name="province" class="form-control" onchange="onChangeProvince($(this).val())">
                                <option value="">Select All Province</option>
                                @foreach($province as $pro)
                                    <option value="{{ $pro->id }}" <?php if(isset($province_select)){if($pro->id == $province_select) echo 'selected';} ?>>{{ $pro->description }}</option>
                                @endforeach
                            </select>
                            <select name="facility" id="facility" class="facility">
                                @if($facility_select)
                                    <option value="{{ $facility_select }}">{{ $facility_select_name }}</option>
                                @else
                                    <option value="">Select Facility</option>
                                @endif
                            </select>
                            <select name="level" class="form-control">
                                <option value="">Select User Level</option>
                                @foreach($user_level as $row)
                                    <option value="{{ $row->level }}" <?php if(isset($user_level_select)){if($row->level == $user_level_select) echo 'selected';} ?>>
                                        @if($row->level == 'bed_tracker')
                                            Bed Tracker
                                        @elseif($row->level == 'eoc_city')
                                            EOC City
                                        @elseif($row->level == 'medical_dispatcher')
                                            Medical Dispatcher
                                        @elseif($row->level == 'mcc')
                                            MCC
                                        @else
                                            {{ ucfirst($row->level) }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" id="daterange" max="{{ date('Y-m-d') }}" value="{{ $dateReportOnline }}" name="date" class="form-control" />
                            <button type="submit" class="btn-sm btn-info btn-flat"><i class="fa fa-search"></i> Filter</button>
                            <button type="button" class="btn-sm btn-warning btn-flat" onclick="refreshPage()"><i class="fa fa-eye"></i> View All</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body">
                @if(count($data) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered table-fixed-header">
                            <thead class='header'>
                            <tr class="bg-black">
                                <th>Facility</th>
                                <th>Name of User</th>
                                <th>Level</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Login</th>
                            </tr>
                            </thead>
                            <?php
                                $h = 0;
                                $count = 0;
                            ?>
                            @foreach($data as $row)
                            <tr>
                                <td class="text-warning text-bold">
                                    @if($h != $row->facility_id)
                                    {{ \App\Facility::find($row->facility_id)->name }}
                                    <?php $h = $row->facility_id; ?>
                                    @endif
                                </td>
                                <td class="text-success">
                                    <?php
                                        $count++;
                                        echo $count;
                                    ?>
                                    {{ ucwords(mb_strtolower($row->lname)) }}, {{ ucwords(mb_strtolower($row->fname)) }}<br>
                                    <small class="text-warning">{{ $row->contact }}</small>
                                </td>
                                <td class="text-danger">
                                    {{ ucfirst($row->level) }}
                                </td>
                                <td class="text-danger">
                                    @if($row->department_id>0)
                                    {{ ucfirst(\App\Department::find($row->department_id)->description) }}
                                    @endif
                                </td>
                                <td>
                                    {{ ($row->login_status=='login') ? 'On Duty' : 'Off Duty' }}
                                </td>
                                <td>
                                    {{ date('h:i A',strtotime($row->last_login)) }}
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
    <link rel="stylesheet" href="{{ url('resources/plugin/daterange/daterangepicker.css') }}" />
@endsection

@section('js')
    <script src="{{ url('resources/plugin/daterange/moment.min.js') }}"></script>
    <script src="{{ url('resources/plugin/daterange/daterangepicker.js') }}"></script>

    <script>
        <?php
            $date = date('m/d/Y',strtotime($dateReportOnline));
        ?>
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });
        $('#daterange').daterangepicker({
            "singleDatePicker": true,
            "startDate": "{{ $date }}",
            "endDate": "{{ $date }}"
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });


        $(".facility").select2({ width: '250px' });

        @if($province_select)
            onChangeProvince("<?php echo $province_select; ?>");
        @endif
        function onChangeProvince(province_id) {
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
    </script>
@endsection

