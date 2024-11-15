@extends('layouts.app')

@section('content')
    <div class="box box-success">
        <div class="box-body">
            <div class="box-header with-border">
                <h1>
                    Referral not accepted within 30 minutes as
                </h1>
                <form action="{{ asset('monitoring') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group-lg">
                        <input type="text" class="form-control active" name="date_range" value="{{ date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)) }}" placeholder="Filter your daterange here..." id="consolidate_date_range" autocomplete="off">
                        <button type="submit" class="btn-lg btn-info btn-flat" onclick="loadPage();"><i class="fa fa-search"></i> Filter</button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th width="13%">Patient Code</th>
                        <th>Patient Contact Number</th>
                        <th>Referring Facility</th>
                        <th>Referred To</th>
                        <th>Date Referred</th>
                        <th>Turn around time not accepted</th>
                        <th>Issue and Concern</th>
                        <th width="20%">Action</th>
                    </tr>
                    @foreach($pending_activity as $row)
                        <tr class="">
                            <td >
                                <strong class="text-bold" style="font-size: 15pt">
                                    <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" target="_blank">{{ $row->code }}</a>
                                </strong><br>
                                <small class="text-warning"><i>Click the code to track the referral</i></small>
                            </td>
                            <td>{{ $row->patient_contact }}</td>
                            <td >
                                {{ $row->referring_facility }}<br>
                                <span class="text-blue">{{ $row->referring_department }}</span><br>
                                <span class="text-green">{{ $row->contact_from }}</span>
                            </td>
                            <td >
                                {{ $row->referred_to }}<br>
                                <?php
                                    if($row->patient_normal_id){
                                        $referred_department = $row->referred_department_normal;
                                        $department_color = "blue";
                                    } else {
                                        $referred_department = $row->referred_department_pregnant." - Pregnant";
                                        $department_color = "red";
                                    }
                                ?>
                                <span class="text-{{ $department_color }}">{{ $referred_department }}</span><br>
                                <span class="text-green">{{ $row->contact_to }}</span>
                            </td>
                            <td >
                                {{ date("F d,Y",strtotime($row->date_referred)) }}<br>
                                <small class="text-yellow">({{ date('g:i a',strtotime($row->date_referred)) }})</small>
                            </td>
                            <td><span class="text-green" style="font-size: 15pt;">{{ $row->time_not_accepted }}</span><br> minutes</td>
                            <td width="20%">
                                <?php
                                    $issue_and_concern = \App\Issue::where("tracking_id",$row->tracking_id)->get();
                                ?>
                                @foreach($issue_and_concern as $issue)
                                    <strong class="text-red">=> {{ $issue->issue }}</strong><br><br>
                                @endforeach
                            </td>
                            <td width="20%">
                                <?php
                                    $monitoring_not_accepted = \App\Monitoring::select("monitoring.remarks","monitoring.created_at",\Illuminate\Support\Facades\DB::raw("CONCAT(users.fname,' ',users.mname,' ',users.lname) as agent_name"))->where("monitoring.code","=",$row->code)
                                                                ->leftJoin("users","users.id","=","monitoring.remark_by")
                                                                ->get();
                                ?>
                                @if($row->redirected_count)
                                <span>Redirected by referred facility:</span> <small class="text-red"><span class="badge bg-red">{{ $row->redirected_count }}</span></small><br>
                                @endif
                                @if($row->transferred_count)
                                <span>Transferred by referred facility:</span> <small class="text-red"><span class="badge bg-yellow">{{ $row->transferred_count }}</span></small><br>
                                @endif
                                @if(count($monitoring_not_accepted) > 0)
                                    @foreach($monitoring_not_accepted as $monitoring)
                                        <span class="text-green">={{ $monitoring->remarks }}</span><br>
                                        <small class="text-yellow">({{ date('F d,Y g:i a',strtotime($monitoring->created_at)) }})</small>
                                        <br>
                                        <small class="text-red"><i>{{ $monitoring->agent_name }}</i></small>
                                        <br><br>
                                    @endforeach
                                    @if(Session::get('auth')->level == 'opcen')
                                        <button class="btn btn-xs btn-info" href="#add_remark" data-toggle="modal" onclick="addRemark(
                                                '<?php echo $row->activity_id; ?>',
                                                '<?php echo $row->code; ?>',
                                                '<?php echo $row->referring_facility_id ?>',
                                                '<?php echo $row->referred_to_id ?>'
                                                )"
                                        ><i class="fa fa-sticky-note"></i> Add more action</button>
                                    @endif
                                @else
                                    @if(Session::get('auth')->level == 'opcen')
                                            <button class="btn btn-xs btn-primary" href="#add_remark" data-toggle="modal" onclick="addRemark(
                                                    '<?php echo $row->activity_id; ?>',
                                                    '<?php echo $row->code; ?>',
                                                    '<?php echo $row->referring_facility_id ?>',
                                                    '<?php echo $row->referred_to_id ?>'
                                                    )"
                                            ><i class="fa fa-sticky-note"></i> Add action</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="add_remark">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body monitoring_remark">

                </div><!-- /.modal-content -->
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection

@section('js')
    <script>
        //Date range picker
        $('#consolidate_date_range').daterangepicker();

        @if(Session::get('add_remark'))
        Lobibox.notify('success', {
            title: "",
            msg: "Successfully added ramark!",
            size: 'mini',
            rounded: true
        });
        <?php Session::put("add_remark",false); ?>
        @endif

        function addRemark(activity_id,code,referring_facility,referred_to){
            $(".monitoring_remark").html(loading);
            var json = {
                "_token" : "<?php echo csrf_token()?>",
                "activity_id" : activity_id,
                "code" : code,
                "referring_facility" : referring_facility,
                "referred_to" : referred_to
            };
            console.log(json);
            var url = "<?php echo asset('monitoring/remark') ?>";
            $.post(url,json,function(result){
                setTimeout(function(){
                    $(".monitoring_remark").html(result);
                },500);
            })
        }
    </script>
@endsection

