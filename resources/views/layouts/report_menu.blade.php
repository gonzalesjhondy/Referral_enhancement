<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Report <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ url('admin/report/online') }}"><i class="fa fa-users"></i>Online Users</a>
        </li>
        <li>
            <a href="{{ url('online/facility') }}"><i class="fa fa-hospital-o"></i>Online Facility</a>
        </li>
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-times-circle-o"></i>Offline Facility</a>
            <ul class="dropdown-menu">
                @foreach(\App\Province::get() as $prov)
                    <li><a href="{{ asset('offline/facility').'/'.$prov->id }}">{{ $prov->description }} Province</a></li>
                @endforeach
            </ul>
        </li>
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-calendar-check-o"></i>Login Status</a>
            <ul class="dropdown-menu">
                @foreach(\App\Province::get() as $prov)
                    <li><a href="{{ asset('weekly/report').'/'.$prov->id }}">{{ $prov->description }} Province</a></li>
                @endforeach
            </ul>
        </li>
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-calendar-check-o"></i>Onboard Facility</a>
            <ul class="dropdown-menu">
                <li><a href="{{ asset('onboard/facility/0') }}">All Province</a></li>
                @foreach(\App\Province::get() as $prov)
                    <li><a href="{{ asset('onboard/facility').'/'.$prov->id }}">{{ $prov->description }} Province</a></li>
                @endforeach
            </ul>
        </li>
    <!--
        <li><a href="{{ url('onboard/users') }}"><i class="fa fa-ambulance"></i>Onboard Users</a></li>
            <li><a href="{{ url('admin/report/referral') }}"><i class="fa fa-line-chart"></i>Referral Status</a></li>
            <li><a href="{{ url('admin/daily/users') }}"><i class="fa fa-users"></i>Daily Users</a></li>
            <li><a href="{{ url('admin/daily/referral') }}"><i class="fa fa-building"></i>Daily Hospital</a></li>
            -->
        <li><a href="{{ url('admin/report/consolidated/incomingv2') }}"><i class="fa fa-file-archive-o"></i>Consolidated</a></li>
        <li><a href="{{ url('admin/statistics') }}"> <i class="fa fa-calendar-check-o"></i>Statistics Report</a></li>

        <li><a href="{{ url('admin/declined') }}"> <i class="fa fa-ban"></i>Declined Referral</a></li> <!--I add this for the declined--->
        
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-calendar-check-o"></i>Walkin Report </a>
            <ul class="dropdown-menu">
                @foreach(\App\Province::get() as $prov)
                    <li><a href="{{ asset('report/walkin').'/'.$prov->id }}">{{ $prov->description }} Province</a></li>
                @endforeach
            </ul>
        </li>
        <!--
            <li><a href="{{ url('admin/er_ob') }}"><i class="fa fa-certificate"></i>Statistics Report ER OB</a></li>
        -->
        <li><a href="{{ url('admin/average/user_online') }}"><i class="fa fa-certificate"></i>Average User's Online</a></li>
        <!--
            <li><a href="{{ url('admin/report/graph/bar_chart') }}"><i class="fa fa-bar-chart-o"></i>Graph</a></li>
        -->
        @if($user->level=='admin')
            <li><a href="{{ url('reports') }}"><i class="fa fa-caret-square-o-right"></i>Dashboard Report</a></li>
        @endif
            <li><a href="{{ url('admin/report/top/icd') }}"><i class="fa fa-odnoklassniki-square"></i>Top ICD-10 Diagnosis</a></li>
            <li><a href="{{ url('admin/report/top/reason_for_referral') }}"><i class="fa fa-code-fork"></i>Top Reason for Referral</a></li>
            <li><a href="{{ url('admin/report/top/reason_for_declined') }}"><i class="fa fa-code-fork"></i>Top Reason for declined</a></li><!----I add this for declined--->
            <li><a href="{{ url('admin/report/tat') }}"><i class="fa fa-clock-o"></i>Turn Around Time</a></li>
            {{--<li class="dropdown-submenu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-clock-o"></i>Turn Around Time</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('admin/report/tat/incoming') }}"> Incoming</a></li>
                    <li><a href="{{ url('admin/report/tat/outgoing') }}"> Outgoing</a></li>
                </ul>
            </li>--}}
            <li><a href="{{ url('admin/report/agebracket') }}"><i class="fa fa-child"></i>Report by Age Bracket</a></li>
        @if($user->level=='admin')
            <li>
                <a href="{{ url('admin/report/deactivated') }}"><i class="fa fa-user-times"></i>Deactivated Users</a>
            </li>
        @endif
        <li class="dropdown-submenu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i>Covid Report </a>
            <ul class="dropdown-menu">
                @foreach(\App\Province::get() as $prov)
                    <li><a href="{{ asset('admin/report/covid').'/'.$prov->id }}">{{ $prov->description }} Province</a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="{{ url('admin/coordinated/referral') }}"><i class="fa fa-hand-rock-o"></i>Coordinated Referral</a></li>
    </ul>
</li>