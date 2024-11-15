<?php
$search_referral = Session::get('search_referral');
$user = Session::get('auth');
?>
@extends('layouts.app')

@section('content')
    <style>

        .timeline .facility {
            color: #ff8456;
        }
        .blink_new_referral {
            animation: blinkMe 2s linear infinite;
        }
        @keyframes blinkMe {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 1;
            }
        }

        .mobile-view {
            display: none;
            visibility: hidden;
        }

        @media only screen and (max-width: 720px) {
            .file-upload {
                background-color: #ffffff;
                width: 300px;
                margin: 0 auto;
                padding: 20px;
            }

            .web-view {
                display: none;
                visibility: hidden;
            }

            .mobile-view {
                display: block;
                visibility: visible;
            }
        }

        .time {
            margin-top: 30px;
        }

        .badge-overlay {
            position: absolute;
            left: 0%;
            top: 0px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 100;
            -webkit-transition: width 1s ease, height 1s ease;
            -moz-transition: width 1s ease, height 1s ease;
            -o-transition: width 1s ease, height 1s ease;
            transition: width 0.4s ease, height 0.4s ease
        }

        .badge1 {
            margin: 0;
            color: white;
            padding: 5px 5px;
            font-size: 7px;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            line-height: normal;
            text-transform: uppercase;
            background: #ff405f;
        }

        .badge1.red {
            background: #ff405f;
        }

        .top-right {
            position: absolute;
            top: 0;
            right: 0;
            -ms-transform: translateX(30%) translateY(0%) rotate(45deg);
            -webkit-transform: translateX(30%) translateY(0%) rotate(45deg);
            transform: translateX(30%) translateY(0%) rotate(45deg);
            -ms-transform-origin: top left;
            -webkit-transform-origin: top left;
            transform-origin: top left;
        }
    </style>
    @php

        $filterFef = request()->query('filterRef');

    @endphp
    <div class="row">
        <input type="hidden" id="referral_page_check" value="1">
        <div class="col-md-3">
            @include('sidebar.filter_referral')
            @include('sidebar.quick')
        </div>
 
        <div class="col-md-9">
            <div class="jim-content">
                @if(count($data) > 0)
                    @if($filterFef == '0')
                    <div class="alert alert-warning">
                            <div class="text-warning">
                                <i class="fa fa-warning"></i> Referrals that are not accepted within 72 hours will be <a href="{{ asset('doctor/archived') }}" style="color: #ff405f"> <b><u>archived</u></b></a><br>
                                <i class="fa fa-warning"></i> Referrals that are not accepted within 30 minutes will get a call from 711 DOH CVCHD HealthLine
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <div class="text-info">
                                <i class="fa fa-info-circle"></i> Incoming patients referred to a particular department can only be accepted by those registered doctors who are assigned in that department.
                            </div>
                        </div>
                    @endif          
                @endif
                <h3 class="page-header">
                    @if($filterFef == '0')
                     {{$title}} <!-- Incoming Patients  {{$option}} -->
                    @else
                        Incoming Consultation
                    @endif
                  
                </h3>
                @if(count($data) > 0)
                    <div class="row">
                        <ul class="timeline">
                            <!-- timeline time label -->

                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            @foreach($data as $row)
                                <?php
                                $type = ($row->type=='normal') ? 'normal-section':'pregnant-section';
                                $type = ($row->status=='referred' || $row->status=='redirected' || $row->status=='transferred' || $row->status=='followup') ? $type : 'read-section';
                                $icon = ($row->status=='referred' || $row->status=='redirected' || $row->status=='followup') ? 'fa-ambulance' : 'fa-eye';
                                $modal = ($row->type=='normal') ? '#normalFormModal' : '#pregnantFormModal';
                                $date = date('M d, Y h:i A',strtotime($row->date_referred));
                                $feedback = \App\Feedback::where('code',$row->code)->count();

                                $department = '"Not specified department"';
                                $check_dept = \App\Department::find($row->department_id);
                                if($check_dept)
                                {
                                    $department = $check_dept->description;
                                }
                                $seen = \App\Seen::where('tracking_id',$row->id)->count();
                                $caller_md = \App\Activity::where('code',$row->code)->where("status","=","calling")->count();
                                //$redirected = \App\Activity::where('code',$row->code)->where("status","=","redirected")->count();
                                $position_bracket = ['','1st','2nd','3rd','4th','5th','6th','7th','8th','9th','10th','11th','12th','13th','14th','15th','16th','17th','18th','19th','20th'];
                                $queue = \App\Activity::where('code',$row->code)->where('status','queued')->orderBy('id','desc')->first();
                                ?>
                                <li id="referral_incoming{{ $row->code }}">
                                    @if($row->position > 0)
                                        <div class='badge-overlay'>
                                            <span class='top-right badge1 red'>{{ $position_bracket[$row->position+1] }} Position</span>
                                        </div>
                                    @endif
                                    @if($row->status == 'referred' || $row->status == 'seen' || $row->status == 'redirected' || $row->status=='followup')
                                        <i class="fa fa-ambulance bg-blue-active"></i>
                                        <div class="timeline-item {{ $type }}" id="item-{{ $row->id }}">
                                            <span class="time"><i class="icon fa {{ $icon }}"></i> <span class="date_activity">{{ $date }}</span></span>
                                            <h3 class="timeline-header no-border">
                                                <span>
                                                    <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" target="_blank">{{ $row->patient_name }}</a>
                                                </span>
                                                <small class="status">
                                                    [ {{ $row->sex }}, {{ $row->patient_age }} ]
                                                </small>
                                                was <span class="text-blue">{{ $row->status }}</span> to
                                                <span class="text-danger">{{ $department }}</span>
                                                by <span class="text-warning">{{ $row->referring_md }}</span> of
                                                <span class="facility">{{ $row->facility_name }}</span>
                                                @if(count($queue) > 0)
                                                    <h5 class="text-red pull-right">Queued at <b>{{ $queue->remarks }}</b>&emsp;</h5>
                                                @endif
                                            </h3> <!-- time line for #referred #seen #redirected -->
                                            @include('doctor.include.timeline_footer')
                                        </div>
                                    @elseif($row->status=='rejected')
                                        <i class="fa fa-user-times bg-maroon"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-calendar"></i> {{ $date }}</span>
                                            <h3 class="timeline-header no-border">
                                                <span>
                                                    <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" target="_blank">{{ $row->patient_name }}</a>
                                                </span>
                                                was RECOMMENDED TO REDIRECT to other facility by <span class="text-danger">Dr. {{ $row->action_md }}</span>
                                            </h3>
                                            @include('doctor.include.timeline_footer')
                                        </div>
                                    @elseif($row->status=='cancelled')
                                        <i class="fa fa-ban bg-red"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-calendar"></i> {{ $date }}</span>
                                            <h3 class="timeline-header no-border">
                                                <span>
                                                    <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" target="_blank">{{ $row->patient_name }}</a>
                                                </span>
                                                was <span class="text-red">{{ $row->status }}</span> by
                                                {{ $row->referring_md }}
                                                <br><br>
                                                @include('doctor.include.timeline_footer')
                                            </h3>
                                        </div>
                                    @elseif($row->status == 'transferred')
                                        <i class="fa fa-ambulance bg-blue-active"></i>
                                        <div class="timeline-item {{ $type }}" id="item-{{ $row->id }}">
                                            <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">{{ $date }}</span></span>
                                            <h3 class="timeline-header no-border">
                                            <span>
                                                <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" target="_blank">{{ $row->patient_name }}</a>
                                            </span>
                                                <small class="status">
                                                    [ {{ $row->sex }}, {{ $row->patient_age }} ]
                                                </small>
                                                was <span class="text-blue">{{ $row->status }}</span> to
                                                <span class="text-danger">{{ $department }}</span>
                                                by <span class="text-warning">{{ $row->referring_md }}</span> of
                                                <span class="facility">{{ $row->facility_name }}</span>
                                            </h3> <!-- time line for #referred #seen #redirected -->
                                            @include('doctor.include.timeline_footer')
                                        </div>
                                    @else
                                        <i class="fa fa-user-plus bg-olive"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-calendar"></i> {{ $date }}</span>
                                            <h3 class="timeline-header no-border">
                                                <span>
                                                    <a href="{{ asset("doctor/referred")."?referredCode=".$row->code }}" target="_blank">{{ $row->patient_name }}</a>
                                                </span>
                                                was <span class="text-green">{{ $row->status }}</span> by
                                                <span class="text-success">
                                                    Dr. {{ $row->action_md }}
                                                </span>
                                                <br><br>
                                                @include('doctor.include.timeline_footer')
                                            </h3>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <div class="text-center">
                                {{ $data->appends(['filterRef' => request('filterRef')])->links() }}
                        </div>
                    </div>
                @else
                    <div class="alert-section">
                        <div class="alert alert-warning">
                            <span class="text-warning">
                                <i class="fa fa-warning"></i> No referrals!
                                <ul>
                                    <li>Filer List:</li>
                                    <ul>
                                        @if(isset($search_referral['keyword']))
                                            <li>Code - {{ $search_referral['keyword'] }}</li>
                                        @endif
                                        <li>Date range - {{ $start.' - '.$end }}</li>
                                        @if(isset($search_referral['department']))
                                            <li>Department - {{ \App\Department::find($search_referral['department'])->description }}</li>
                                        @endif
                                    </ul>
                                </ul>
                            </span>
                        </div>
                    </div>

                    <ul class="timeline">
                    </ul>
                @endif
            </div>
        </div>
    </div>

    @include('modal.accept_reject')
    @include('modal.reject')
    @include('modal.refer')
    @include('modal.accept')
    @include('modal.contact')
    @include('modal.seen')
    @include('modal.caller')
@endsection
@section('css')

@endsection

@section('js')
    @include('script.referral')
    <script>
        function openTelemedicine(tracking_id, referral_code, form_type, action_md, activity_id) {
            let windowName = 'NewWindow'; // Name of the new window
            let windowFeatures = 'width=600,height=400'; // Features for the new window (size, position, etc.)
            let userid = '{{ $user->id }}';
            const referring_md_status = userid == action_md ? 'no' : 'yes';
            let url = $("#broadcasting_url").val()+`/doctor/telemedicine?id=${tracking_id}&code=${referral_code}&form_type=${form_type}&referring_md=${referring_md_status}&activity_id=${activity_id}`;
            let newWindow = window.open(url, windowName, windowFeatures);
            if (newWindow && newWindow.outerWidth) {
                newWindow.moveTo(0, 0);
                newWindow.resizeTo(screen.availWidth, screen.availHeight);
            }
            const updateExamined = {
                code : referral_code
            }
            $.post(`${$("#broadcasting_url").val()}/api/video/examined`, updateExamined, function(response) {
                console.log(response)
            })
        }
    </script>
    <script>
        $(".select2").select2({ width: '100%' });

        function clearFieldsSidebar(){
            <?php
            Session::put('search_referral',false)
            ?>
            refreshPage();
        }

        $('#daterange').daterangepicker({
            "singleDatePicker": false,
            "startDate": "{{ $start }}",
            "endDate": "{{ $end }}"
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        @if(Session::get('incoming_denied'))
        Lobibox.alert("error", //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "This referral was already accepted,rejected or redirected"
            });
        <?php Session::put("incoming_denied",false); ?>
        @endif
    </script>

    <!--
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <audio id="carteSoudCtrl">
        <source src="{{ url('public/notify.mp3') }}" type="audio/mpeg">
    </audio>
    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyD_XAIS_TWWI3BjflYl4TRmI_mBJqRcOx8",
            authDomain: "laravelfcm-fc6bf.firebaseapp.com",
            projectId: "laravelfcm-fc6bf",
            storageBucket: "laravelfcm-fc6bf.appspot.com",
            messagingSenderId: "975525743047",
            appId: "1:975525743047:web:9fe2e039d68c0f00e5b1e2",
            measurementId: "G-K2YD0S1V9M"
        };

        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();
        messaging
            .requestPermission()
            .then(function () {
                console.log("Notification permission granted.");
                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                $.get("<?php echo asset('login/update/token') ?>"+"/"+token,function(result){});
                console.log(token);
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function(payload) {
            var login_referred_facility = "<?php echo $user->facility_id; ?>";
            if(login_referred_facility == payload.data.referred_facility){
                $('#carteSoudCtrl')[0].play();
                console.log(payload.data.code);
                $.get("<?php echo asset('api/referral/append'); ?>"+"/"+payload.data.code,function(result){
                    $(".timeline").prepend(result);
                });
            }
        });
    </script>
    -->

@endsection