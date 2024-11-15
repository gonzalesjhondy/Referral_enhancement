<?php
$user = Session::get('auth');
$multi_faci = Session::get('multiple_login');
?>
<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
</div>
<input type="hidden" id="reco_count_val" value="{{ $reco_count }}">
<div id="navbar" class="navbar-collapse collapse" style="font-size: 8pt;">
  <ul class="nav navbar-nav">   <!-- id="navbar-main" -->
        @if(!$multi_faci && ($user->level=='doctor' || $user->level=='midwife' || $user->level=='medical_dispatcher' || $user->level=='nurse' || $user->level=='mayor' || $user->level=='dmo'))
            <li><a href="{{ url('doctor/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            @if($user->level != 'mayor' && $user->level != 'dmo')
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> Patients <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('doctor/patient') }}"><i class="fa fa-table"></i> List of Patients</a></li>
                    <li><a href="{{ url('manage/appointment') }}"><i class="fa fa-table"></i> Manage Appointment</a></li>
                    <li><a href="{{ url('doctor/appointment/calendar') }}"><i class="fa fa-table"></i> Appointment Calendar</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ url('doctor/accepted') }}"><i class="fa fa-user-plus"></i> Accepted Patients</a></li>
                    <li><a href="{{ url('doctor/discharge') }}"><i class="fa fa-users"></i> Discharged Patients</a></li>
                    <li><a href="{{ url('doctor/transferred') }}"><i class="fa fa-ambulance"></i> Transferred Patients</a></li>
                    <li><a href="{{ url('doctor/cancelled') }}"><i class="fa fa-user-times"></i> Cancelled Patients</a></li>
                    <li><a href="{{ url('doctor/archived') }}"><i class="fa fa-archive"></i> Archived Patients</a></li>
                    <li><a href="{{ url('doctor/redirected') }}"><i class="fa fa-external-link"></i> Redirected Patients</a></li>
                    <li><a href="{{ url('doctor/redirect/reco') }}"><i class="fa fa-external-link-square"></i> Recommended to be Redirected</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ url('doctor/referred/track') }}"><i class="fa fa-line-chart"></i> Track Patient</a></li>
                    <li class="hide"><a href="{{ url('maintenance') }}"><i class="fa fa-line-chart"></i> Rerouted Patients</a></li>
                </ul>
            </li>
            @endif
            <!--
                <li><a href="{{ url('inventory').'/'.$user->facility_id }}"><i class="fa fa-calculator"></i> Inventory </a></li>
             -->
                
            @if($user->level != 'mayor' && $user->level != 'dmo')
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wheelchair"></i> Referral <span class="badge" style="font-size: 8pt;"><span class="count_referral">{{ $count }}</span> New</span><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('doctor/referral') }}?filterRef=0"><i class="fa fa-ambulance"></i> Incoming &nbsp;&nbsp; <span class="badge"><span class="count_referral">{{ $count }}</span> New</span></a></li>
                    <li><a href="{{ url('doctor/referred') }}?filterRef=0"><i class="fa fa-user"></i>&nbsp; Referred Patients</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ url('doctor/duplicate') }}"><i class="fa fa-files-o"></i> Duplicate Referrals</a></li>
                    <!--
                    <li><a href="{{ url('maintenance') }}"><i class="fa fa-hospital-o"></i> Emergency Walk-In</a></li>
                    <li><a href="{{ url('doctor/report/incoming') }}"><i class="fa fa-sign-in"></i> Incoming Referral Report</a></li>
                    <li><a href="{{ url('doctor/report/outgoing') }}"><i class="fa fa-sign-out"></i> Outgoing Referral Report</a></li>
                    -->
                </ul>
            </li>

            <!-- Telemed Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-video-camera"></i> Telemed 
                    <span class="badge" style="font-size: 8pt;">
                        <span class="count_referral_telemed">{{ $countTelemed }}</span> New
                    </span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ url('doctor/referral') }}?filterRef=1">
                            <i class="fa fa-ambulance incoming_nav"></i> Incoming &nbsp;&nbsp; 
                            <span class="badge">
                                <span class="count_referral_telemed">{{ $countTelemed }}</span> New
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('doctor/referred') }}?filterRef=1">
                            <i class="fa fa-ambulance outgoing_nav"></i> Outgoing &nbsp;&nbsp; 
                            <!-- <span class="badge">
                                <span class="count_referral_telemed">{{ $countTelemed }}</span> New
                            </span> -->
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @include('layouts.report_menu')
        @elseif($user->level=='support')
            <li><a href="{{ url('support/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            @include('layouts.report_menu')
            <li><a href="{{ url('support/users') }}"><i class="fa fa-user-md"></i> Manage Users</a></li>
            <li><a href="{{ url('support/hospital') }}"><i class="fa fa-hospital-o"></i> Hospital Info</a></li>
        <!--
                <li><a href="{{ url('inventory').'/'.$user->facility_id }}"><i class="fa fa-calculator"></i> Inventory <span class="badge bg-red"> New</span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Reports
                        @if($count>0)
            <span class="badge">
        <span class="count_referral">{{ $count }}</span>
                    </span>
                        @endif
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('support/report/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
                        <li><a href="{{ url('support/report/referral') }}"><i class="fa fa-wheelchair"></i>Daily Referrals</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('support/report/incoming') }}"><i class="fa fa-ambulance"></i>Incoming Referral
                                @if($count>0)
            <span class="badge">
            <span class="count_referral">{{ $count }}</span>
                                </span>
                                @endif
                </a>
            </li>
            <li>
                <a href="{{ url('support/chat') }}">
                                <i class="fa fa-comments"></i> IT Support: Group Chat
                            </a>
                        </li>
                    </ul>
                </li>
                -->
        @elseif($user->level=='mcc')
            <li><a href="{{ url('mcc/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('mcc/report/online') }}" data-toggle="modal"><i class="fa fa-users"></i> Online Department</a></li>
                        <li><a href="{{ url('mcc/report/incoming') }}" data-toggle="modal"><i class="fa fa-line-chart"></i> Incoming Referral</a></li>
                        <li><a href="{{ url('mcc/report/timeframe') }}" data-toggle="modal"><i class="fa fa-calendar"></i> Referral Time Frame</a></li>
                        <li><a tabindex="-1" href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i> Consolidated</a></li>
                    </ul>
                </li>
                -->
            <li><a href="{{ url('mcc/track') }}"><i class="fa fa-line-chart"></i> Track</a></li>
            @include('layouts.report_menu')
        @elseif($user->level=='admin')
            <li><a href="{{ url('admin/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ambulance"></i> E-Referral<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('doctor/patient') }}"><i class="fa fa-table"></i> List of Patients</a></li>
                    <li><a href="{{ url('doctor/referred') }}"><i class="fa fa-ambulance"></i> Referred Patients</a></li>
                    <li><a href="{{ url('doctor/referred/track') }}"><i class="fa fa-line-chart"></i> Track Patient</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ url('doctor/duplicate') }}"><i class="fa fa-files-o"></i> Duplicate Referrals</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-phone"></i> Call <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('opcen/client') }}"><i class="fa fa-phone"></i> Call Center</a></li>
                    <li><a href="{{ url('it/client') }}"><i class="fa fa-phone"></i> IT</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Manage <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('admin/users') }}" ><i class="fa fa-users"></i> IT Support/ Call Center/ Bed</a></li>
                    {{--<li><a href="{{ url('admin/doctor/assignment') }}" ><i class="fa fa-user-md"></i>&nbsp; Doctor's Facility Assignment</a></li>--}}
                    <li><a href="{{ url('admin/facility') }}" ><i class="fa fa-hospital-o"></i>&nbsp; Facilities</a></li>
                    <li><a href="{{ url('admin/province') }}" ><i class="fa fa-hospital-o"></i>&nbsp; Province</a></li>
                    <li class="dropdown-submenu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="nav-label"><i class="fa fa-hospital-o"></i>&nbsp;&nbsp;&nbsp; Municipality</span></a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Province::get() as $prov)
                                <li><a href="{{ asset('admin/municipality').'/'.$prov->id }}">{{ $prov->description }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ url('admin/reason-referral') }}"><i class="fa fa-wrench"></i> Reason for Referral</a></li>
                    <li><a href="{{ url('admin/icd') }}"><i class="fa fa-file-text-o"></i> ICD-10</a></li>
                    <li><a href="{{ url('admin/appointment') }}"><i class="fa fa-pencil-square-o"></i> Appointments </a></li>
                    <li><a href="{{ url('admin/user_feedback') }}"><i class="fa fa-comments-o"></i> User Feedbacks </a></li>
                <!-- <li><a href="{{ url('excel/import') }}"><i class="fa fa-file-excel-o"></i> Import</a></li> -->
                </ul>
            </li>
            @include('layouts.report_menu')
        @elseif($user->level=='eoc_region')
            <li><a href="{{ url('eoc_region/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ url('eoc_city/graph') }}"><i class="fa fa-line-chart"></i> Graph</a></li>
        @elseif($user->level=='eoc_city')
            <li><a href="{{ url('eoc_city/') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ url('eoc_city/graph') }}"><i class="fa fa-line-chart"></i> Graph</a></li>
        @elseif($user->level=='opcen')
            <li><a href="{{ url('opcen') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ url('opcen/client') }}"><i class="fa fa-phone"></i> Call</a></li>
            <li><a href="{{ asset('public/directory/Call-Center-Directory.xlsx') }}"><i class="fa fa-print"></i> Directory</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ambulance"></i> E-Referral <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('doctor/patient') }}"><i class="fa fa-table"></i> List of Patients</a></li>
                    <li><a href="{{ url('doctor/referred') }}"><i class="fa fa-ambulance"></i> Referred Patients</a></li>
                    <li><a href="{{ url('doctor/referred/track') }}"><i class="fa fa-line-chart"></i> Track Patient</a></li>
                    <li><a href="{{ url('revised/referral') }}"><i class="fa fa-file-text"></i> E-Referral Form <small class="badge bg-red"> New</small></a></li>
                </ul>
            </li>
            @include('layouts.report_menu')
        @elseif($user->level == 'bed_tracker')
            <li><a href="{{ url('bed_tracker') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ url('bed').'/'.$user->facility_id }}"><i class="fa fa-bed"></i> Update Bed Availability <small class="badge bg-red"> New</small></a></li>
        @elseif($user->level=='vaccine')
            <li><a href="{{ url('vaccine') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            @foreach(\App\Province::get() as $prov)
                <li><a href="{{ asset('vaccine/vaccineview').'/'.$prov->id }}">{{ $prov->description }}</a></li>
            @endforeach
            <li><a href="{{ asset('vaccine/facility').'/cebu' }}">Cebu City</a></li>
            <li><a href="{{ asset('vaccine/facility').'/mandaue' }}">Mandaue City</a></li>
            <li><a href="{{ asset('vaccine/facility').'/lapu' }}">Lapu-Lapu City</a></li>
        @endif
        @if($user->level == 'admin')
            <li><a href="{{ url('admin/login') }}"><i class="fa fa-sign-in"></i> Login As</a></li>
        @endif
        @if(!$multi_faci && $user->level != 'vaccine')
            {{--<li><a href="{{ asset('public/manual/Ereferral-User-Manual.pdf') }}" target="_blank"><i class="fa fa-file-pdf-o"></i> E-REFERRAL Manual </a></li>--}}
            <li><a href="{{ url('bed_admin') }}"><i class="fa fa-bed"></i> BAS</a></li>
            @if($user->level == 'admin')
                <li><a href="{{ url('patient/walkin') }}"><i class="fa fa-odnoklassniki"></i> Walk-in Patients Monitoring </a></li>
            @endif
            <li><a href="{{ url('monitoring') }}"><i class="fa fa-clock-o"></i> NA within 30 minutes </a></li>
            <li><a href="{{ url('issue/concern') }}"><i class="fa fa fa-exclamation-triangle"></i> IAC </a></li>
            {{--<li><a href="{{ url('chat') }}"><i class="fa fa-wechat"></i> Chat <span class="badge bg-green"><span>{{ $count_chat }}</span> New</span></a></li>--}}
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                More <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-wechat"></i> Reco Messages
                    </a>
                    <ul class="dropdown-menu"><a href="{{ url('reco') }}"><i class="fa fa-wechat"></i> ReCo <span class="badge bg-green"><span id="reco_count">{{ $reco_count }}</span> New</span></a></ul>
                </li>
                <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user-md"></i> Who's Online
                    </a>
                @endif
                @if(!$multi_faci)
                    <ul class="dropdown-menu"><a href="{{ url('doctor/list') }}"><i class="fa fa-user-md"></i> Who's Online</a></ul>
                </li>
                @endif
                <li class="dropdown-submenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gear"></i> Settings <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if($user->level == 'opcen')
                            <li><a href="{{ url('admin/login') }}"><i class="fa fa-sign-in"></i> Login As </a></li>
                        @endif
                        <li><a href="#setLogoutTime" data-toggle="modal" onclick="openLogoutTime();"><i class="fa fa-clock-o"></i> Set Time to Logout</a></li>
                        <li><a href="#editProfileModal" data-toggle="modal"><i class="fa fa-pencil"></i> Edit Profile</a></li>
                        <li><a href="#resetPasswordModal" data-toggle="modal"><i class="fa fa-key"></i> Change Password</a></li>
                        @if($user->level=='doctor' || $user->level=='midwife')
                            <li><a href="#dutyModal" data-toggle="modal"><i class="fa fa-user-md"></i> Change Login Status</a></li>
                            <li class="divider"></li>
                            <li><a href="#loginModal" data-toggle="modal"><i class="fa fa-users"></i> Switch User</a></li>
                        @else
                            <li class="divider"></li>
                        @endif
                        <li>
                            <a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                        @if(Session::get('admin'))
                            <?php
                            $check_login_as = \App\User::find($user->id);
                            ?>
                            <li><a href="{{ url('admin/account/return') }}"><i class="fa fa-user-secret"></i> <?php echo $check_login_as->level == 'admin' ? 'Back as Admin' : 'Back as Agent'; ?></a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div><!--/.nav-collapse -->