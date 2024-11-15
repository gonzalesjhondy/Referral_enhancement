<?php
$user = Session::get('auth');
?>

@extends('layouts.app')

@section('content')
    <style>
        .txtTitle { font-size:1.4em; font-weight: bold; color: #ac2020 }
        .txtDoctor { font-weight: bold; color: #1a9cb7;}
        .txtPatient { font-weight: bold; font-size: 1em; color: #22a114 }
        .txtHospital { font-weight: bold; color: #9d7311; }
        .txtInfo { font-weight: bold; color: #437ea9; }
        /*.tracking { background : #efefef; padding:5px;}
        .tracking table td { font-size: 0.9em; padding:10px 15px; vertical-align: top; letter-spacing: 0.5px; }
        .tracking table td:first-child { white-space: nowrap; color: #959595; letter-spacing: normal; width: 100px;  }*/
        .remarks { display: block; color: #df9e38}
        .txtCode { color: #f39c12}
        .txtSub { font-size: 0.7em; font-weight: normal;color: #737373}
    </style>
    <style type="text/css">
        .bs-wizard {margin-top: 20px;}
        /*Form Wizard*/
        .bs-wizard {border-bottom: solid 1px #4caf50; padding: 0 0 10px 0;}
        .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
        .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
        .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; margin-bottom: 5px;}
        .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #4caf50; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #4caf50; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
        .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
        .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #4caf50;}
        .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
        .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
        .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
        .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
        .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
        .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
        .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
        .bs-wizard-stepnum { color: #4caf50 !important;}
        /*END Form Wizard*/
        @media only screen and (max-width: 440px) {
            .bs-wizard-stepnum {
                font-size: 14px;
                text-transform: lowercase;
            }
            .step-name {
                font-size : 9px;
            }
            .not_arrived {
                font-size: 8px;
            }
        }
    </style>
    <div class="row">
        <div class="col-md-3">
            @if($referredCode)
                @include('sidebar.track_referred')
            @else
                @include('sidebar.search_referred')
            @endif
            @include('sidebar.quick')
        </div>
        <div class="col-md-9">
            @if(count($data) > 0)
               
                @foreach($data as $row)
                    <?php
                    $type = ($row->type=='normal') ? 'success':'danger';
                    $modal = ($row->type=='normal') ? '#normalFormModal' : '#pregnantFormModal';

                    $activities = \App\Activity::select(
                        'activity.*',
                        DB::raw('CONCAT(users.fname," ",users.mname," ",users.lname) as md_name'),
                        DB::raw('CONCAT(u.fname," ",u.mname," ",u.lname) as referring_md'),
                        'users.contact',
                        'fac_rejected.name as fac_rejected',
                        'referring_md as referring_md_id'
                    )
                        ->where('activity.code',$row->code)
                        ->where('activity.id','>=',function($q) use($row,$user){
                            $q->select('id')
                                ->from('activity')
                                ->where('code',$row->code)
                                ->where(function($q){
                                    $q->where('status','referred')
                                        ->orwhere('status','rejected')
                                        ->orwhere('status','transferred');
                                })
                                ->first()
                            ;
                        })
                        ->leftJoin('users','users.id','=','activity.action_md')
                        ->leftJoin('users as u','u.id','=','activity.referring_md')
                        ->leftJoin('facility as fac_rejected','fac_rejected.id','=','users.facility_id')
                        ->orderBy('id','desc')
                        ->get();

                    $department_name = 'N/A';
                    $dept = \App\Department::find($row->department_id);
                    if($dept) {
                        $department_name = $dept->description;
                    }
                    $patient = \App\Patients::find($row->patient_id);
                    if(isset($patient->brgy)) {
                        $patient_address = $patient->region.', '.\App\Province::find($patient->province)->description.', '.\App\Muncity::find($patient->muncity)->description.', '.\App\Barangay::find($patient->brgy)->description;
                    }
                    else {
                        $patient_address = $patient->region.', '.$patient->province_others.', '.$patient->muncity_others.', '.$patient->brgy_others;
                    }

                    $seen = \App\Seen::where('tracking_id',$row->id)->count();
                    $checkForCancellation = \App\Http\Controllers\doctor\ReferralCtrl::checkForCancellation($row->code);

                    $feedback = \App\Feedback::where('code',$row->code)->count();
                    $caller_md = \App\Activity::where('code',$row->code)->where("status","=","calling")->count();
                    $redirected = \App\Activity::where('code',$row->code)->where("status","=","redirected")->count();
                    ?>
                    <div style="border:2px solid #7e7e7e;" class="panel panel-{{ $type }}">
                        <div class="panel-heading">
                            <span class="txtTitle"><i class="fa fa-wheelchair"></i> {{ ucwords(strtolower($row->patient_name)) }} <small class="txtSub">[ {{ $row->sex }}, {{ $row->age }} ] from {{ $patient_address }}. </small></span>
                            <br />
                            @if($row->contact)
                                Patient Contact Number: <strong class="text-primary">{{ $row->contact }}</strong>
                                <br />
                            @endif
                            Referred by:
                            <span class="txtDoctor" href="#">
                                <?php
                                    if($row->user_level == 'doctor'){
                                        $referring_md = "Dr. ".$row->referring_md;
                                    } else{
                                        $referring_md = $row->referring_md;
                                    }
                                    ?>
                                    {{ $referring_md }}
                            </span>
                            <br />
                            Patient Code: <span class="txtCode">{{ $row->code }}</span>
                        </div>
                        @if($row->telemedicine)
                            @include('doctor.include.telemedicine_panel_body')
                        @else
                            @include('doctor.include.referred_panel_body')
                        @endif
                        <div class="panel-footer">
                            <a data-toggle="modal" href="#referralForm"
                               data-type="{{ $row->type }}"
                               data-id="{{ $row->id }}"
                               data-code="{{ $row->code }}"
                               data-referral_status="referring"
                               class="view_form btn btn-warning btn-xs">
                                <i class="fa fa-folder"></i> View Form
                            </a>
                            @if($seen>0)
                                <a href="#seenModal" data-toggle="modal"
                                   data-id="{{ $row->id }}"
                                   class="btn btn-seen btn-xs btn-success"><i class="fa fa-user-md"></i> Seen
                                    @if($seen>0)
                                        <small class="badge bg-green-active" id="count_seen{{ $row->code }}">{{ $seen }}</small>
                                    @endif
                                </a>
                            @endif
                            @if($caller_md > 0)
                                <a href="#callerModal" data-toggle="modal" id="caller_button{{ $row->code }}"
                                   data-id="{{ $row->id }}"
                                   class="btn btn-primary btn-xs btn-caller"><i class="fa fa-phone"></i> Caller
                                    @if($caller_md>0)
                                        <small class="badge bg-blue-active" id="count_caller{{ $row->code }}">{{ $caller_md }}</small>
                                    @endif
                                </a>
                            @endif
                            <div id="html_websocket_departed{{ $row->code }}" style="display: inline;"></div>
                           @if((Session::get('referred_accepted_track') || Session::get('redirected_accepted_track') ) || !Session::get('referred_travel_track') && !Session::get('redirected_travel_track') && !Session::get('referred_arrived_track') && !Session::get('redirected_arrived_track') && $row->referred_from == $user->facility_id)
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a>
                            {{-- @else
                            <a href="#transferModal" data-toggle="modal"
                            data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a> --}}
                            @endif
                            <!-- @if((Session::get('referred_accepted_track') || Session::get('redirected_accepted_track')) && (!Session::get('referred_travel_track') || !Session::get('redirected_travel_track')) && (!Session::get('referred_arrived_track') || !Session::get('redirected_arrived_track')) 
                            && (!Session::get('referred_notarrived_track') || !Session::get('redirected_notarrived_track')) && $row->referred_from == $user->facility_id)
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a>
                            @elseif(Session::get('redirected_transferred_track') && Session::get('redirected_accepted_track') && Session::get('redirected_travel_track') && Session::get('redirected_notarrived_track'))
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a>
                            @endif -->
                            <!-- @if(Session::get('referred_accepted_track') && !Session::get('referred_travel_track') && !Session::get('referred_arrived_track') 
                            && (!Session::get('referred_notarrived_track') && $row->referred_from == $user->facility_id))
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart1</a>
                            @elseif(Session::get('redirected_transferred_track') && Session::get('redirected_accepted_track') && !Session::get('redirected_travel_track') && !Session::get('redirected_arrived_track'))
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart2</a>
                            @elseif(!Session::get('redirected_transferred_track') && Session::get('redirected_accepted_track') && !Session::get('referred_travel_track') && (!Session::get('referred_examined_track') || !Session::get('follow_examined_track')))
                             <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> EXAMINE</a>
                            @endif -->
                         
                            <!-- @if(Session::get('referred_accepted_track') && !Session::get('referred_travel_track') && !Session::get('referred_arrived_track'))
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a>
                            @elseif(Session::get('redirected_transferred_track') && Session::get('redirected_accepted_track') && !Session::get('redirected_travel_track') && !Session::get('redirected_arrived_track'))
                                <a href="#transferModal" data-toggle="modal"
                                   data-id="{{ $row->id }}" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a>
                            @endif -->

                            <button class="btn btn-xs btn-info btn-feedback" data-toggle="modal"
                                    data-target="#feedbackModal"
                                    data-code="{{ $row->code }}"
                                    onclick="viewReco($(this))"
                            >
                                <i class="fa fa-comments"></i> ReCo
                                <span class="badge bg-blue" id="reco_count{{ $row->code }}">{{ $feedback }}</span>
                            </button>
                            <?php $issue_and_concern = \App\Issue::where("tracking_id","=",$row->id)->count(); ?>
                            <button class="btn btn-xs btn-danger btn-issue-referred" data-toggle="modal"
                                    data-target="#IssueAndConcern"
                                    data-code="{{ $row->code }}"
                                    data-referred_from="{{ $row->referred_from }}"
                                    data-tracking_id="{{ $row->id }}">
                                <i class="fa fa fa-exclamation-triangle"></i> Issue and Concern
                                @if($issue_and_concern>0)
                                    <span class="badge bg-red">{{ $issue_and_concern }}</span>
                                @endif
                            </button>
                            <?php $doh_remarks = \App\Monitoring::where("code","=",$row->code)->count(); ?>
                            @if($doh_remarks>0)
                                <button class="btn btn-xs btn-doh" data-toggle="modal" style="background-color: #dd7556;color: white"
                                        data-target="#feedbackDOH"
                                        data-code="{{ $row->code }}">
                                    <i class="fa fa-phone-square"></i> 711 DOH CVCHD HealthLine
                                    <span class="badge bg-green">{{ $doh_remarks }}</span>
                                </button>
                            @endif
                            @if($redirected > 0)
                                {{--<a href="#" data-toggle="modal"--}}
                                   {{--data-id="{{ $row->id }}"--}}
                                   {{--class="btn btn-danger btn-xs btn-caller"><i class="fa fa-chevron-circle-right"></i> Redirected--}}
                                    @if($redirected>0)
                                        {{--<small class="badge bg-red-active">{{ $redirected }}</small>--}}
                                    @endif
                                {{--</a>--}}
                            @endif
                            @if(!$checkForCancellation)
                                @if(!isset($_GET['referredCode']))
                                    <a href="#cancelModal" data-toggle="modal"
                                       data-id="{{ $row->id }}" class="btn btn-xs btn-default btn-cancel"><i class="fa fa-times"></i> Cancel</a>
                                @else
                                    @if($user->level === 'admin' || ($user->level === "doctor" && $duplicate == true))
                                        <?php
                                            if($user->level === 'admin')
                                                $admin = 'admin';
                                        ?>
                                        <a href="#cancelModal" data-toggle="modal"
                                           data-id="{{ $row->id }}" data-user="{{ $admin }}" class="btn btn-xs btn-default btn-cancel"><i class="fa fa-times"></i> Cancel</a>
                                    @endif
                               @endif
                            @endif
                        </div>
                    </div>
                @endforeach
                               
                <div class="text-center">
                    {{ $data->appends(['filterRef' => request('filterRef')])->links() }}
                </div>
            @else
                <div class="alert alert-warning">
                <span class="text-warning" style="font-weight: bold; font-size: 1.2em;">
                    <i class="fa fa-warning"></i> No Referred Patients!
                </span>
                </div>
            @endif
        </div>
    </div>

    @include('modal.accept')
    @include('modal.refer')
    @include('modal.accept_reject')
    @include('modal.seen')
    @include('modal.caller')
    @include('modal.cancel')
    @include('modal.transfer')
@endsection

@section('js')
    @include('script.referred')
    {{--@include('script.firebase')--}}
    <script>
        @if(Session::get('redirected_patient'))
            Lobibox.notify('success', {
                title: "Success",
                msg: "Successfully Redirected Patient!"
            });
            <?php Session::put("redirected_patient",false); ?>
        @endif
        @if(Session::get('departed'))
            Lobibox.notify('success', {
                title: "Success",
                msg: "Successfully Departed Patient!"
            });
        <?php Session::put("departed",false); ?>
        @endif
        @if(Session::get('already_departed'))
            Lobibox.alert("error",
            {
                msg: "This referral was already departed"
            });
        <?php Session::put("already_departed",false); ?>
        @endif
        @if(Session::get('ignore_edit'))
                Lobibox.alert("error",
            {
                msg: "Updating form was ignored because this referral was rejected by receiving facility."
            });
        <?php Session::put("ignore_edit",false); ?>
        @endif
        @if(Session::get('already_accepted'))
        Lobibox.alert("error",
            {
                msg: "Updating form was ignored because this referral was already accepted by receiving facility."
            });
        <?php Session::put("already_accepted",false); ?>
        @endif
        @if(Session::get('rejected_by_admin'))
        Lobibox.alert("error",
            {
                msg: "This referral was already cancelled."
            });
        <?php Session::put("rejected_by_admin",false); ?>
        @endif

        @if(Session::get('refer_patient'))
        Lobibox.alert("success",
            {
                msg: "Successfully referred the patient!"
            });
        <?php Session::put("refer_patient",false); ?>
        @endif

        @if(Session::get('redirected_failed'))
            Lobibox.alert("error",
                {
                    msg: "Failed to redirect the patient, please try again!"
                });
            <?php Session::put("redirected_failed",false); ?>
        @endif

        $('body').on('click','.btn-transfer',function() {
            $(".transportation_body").html(''); //clear data
            var id = $(this).data('id');
            var url = "{{ url('doctor/referred/departed') }}/"+id;
            var transportation_all = <?php echo \App\ModeTransportation::get(); ?>;
            var select_transportation = "<select class='form-control' onchange='addOthers()' name='mode_transportation' id='mode_transportation' >";
            $.each(transportation_all,function($x,$y){
                select_transportation += "<option value='"+$y.id+"'>"+$y.transportation+"</option>";
            });
            select_transportation += "</select><br>";

            $(".transportation_body").append(select_transportation);
            $("#transferReferralForm").attr('action',url);
        });

        $(document).ready(function(){
            $('.toggle').toggle();

            $("a[href='#toggle']").on('click',function () {
                var id = $(this).data('id');
                $('.toggle'+id).toggle();
                var txt = ($(this).html() =='View More') ? 'View Less': 'View More';
                $(this).html(txt);
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $(".select2").select2({ width: '100%' });

        $('#daterange').daterangepicker({
            "singleDatePicker": false,
            "startDate": "{{ $start }}",
            "endDate": "{{ $end }}"
        });

        function clearFieldsSidebar(){
            <?php
            Session::put('referredKeyword',false);
            Session::put('referredSelect',false);
            Session::put('referred_date',false);
            Session::put('referred_facility',false);
            Session::put('referred_department',false);
            ?>
            refreshPage();
        }

        @if(Session::get('referral_update_save'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("update_message"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("referral_update_save",false);
        Session::put("update_message",false)
        ?>
        @endif
    </script>
@endsection

@section('css')

@endsection