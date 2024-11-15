{{--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('resources/img/favicon1.png') }}" type="image/x-icon">
    <meta http-equiv="cache-control" content="max-age=0" />
    <title>{{ (isset($title)) ? $title : 'Referral System'}}</title>
    {{--<audio id="carteSoudCtrl">
        <source src="{{ url('public/notify.mp3') }}" type="audio/mpeg">
    </audio>--}}
    <!-- SELECT 2 -->
    <link href="{{ asset('resources/plugin/select2/select2.min.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('resources/plugin/Ionicons/css/ionicons.min.css') }}">

    <!-- Font awesome -->
    <link href="{{ asset('resources/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('resources/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('resources/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/assets/css/AdminLTE.min.css') }}">
    <!-- bootstrap datepicker -->

    <link href="{{ asset('resources/plugin/datepicker/datepicker3.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/plugin/Lobibox/lobibox.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('resources/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link href="{{ asset('resources/plugin/daterangepicker_old/daterangepicker-bs3.css') }}" rel="stylesheet">

    <link href="{{ asset('resources/plugin/table-fixed-header/table-fixed-header.css') }}" rel="stylesheet">

    <link rel="manifest" href="{{ asset('/manifest.json') }}" />
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('resources/assets/js/jquery.min.js?v='.date('mdHis')) }}"></script>

    <title>
        @yield('title','Home')
    </title>

    @yield('css')
    <style>
        .btn-primary:focus, 
        .btn-primary:hover {
        background-color: #265a88;
        background-position: 0 -15px;
        }

        body {
            background: url('{{ asset('resources/img/backdrop.png') }}'), -webkit-gradient(radial, center center, 0, center center, 460, from(#ccc), to(#ddd));
        }
        .loading {
            background: rgba(255, 255, 255, 0.9) url('{{ asset('resources/img/loading.gif')}}') no-repeat center;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:999999999;
            display: none;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: rgba(38, 125, 61, 0.92);
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }
        #myBtn:hover {
            background-color: #555;
        }
        .form-label {
            font-size: 10pt;
        }

        .form-details {
            font-size: 12pt;
            color: #e08e0b;;
        }
        .incoming_nav {
            transform: rotateY(0deg); /* Faces right (default) */
        }

        .outgoing_nav {
            transform: rotateY(180deg); /* Flips to face left */
        }

        @if($user->level == 'admin')
        @media screen and (min-width: 1920px) {
            #container-nav {
                width: 1500px !important;
            }
        }
        @endif
    </style>
</head>
<body>
<?php $multiple_login = Session::get('multiple_login'); ?>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default fixed-top">
        <div class="header" style="background-color:#2F4054;padding:8px;">
            <div class="col-md-3">
                <input type="hidden" id="broadcasting_url" value="{{ url("/") }}">
                <div style="padding: 2px;">
                    <?php
                        $count = \App\Http\Controllers\doctor\ReferralCtrl::countReferral();
                        $countTelemed = \App\Http\Controllers\doctor\ReferralCtrl::countTelemed();
                        $reco_count = \App\Http\Controllers\FeedbackCtrl::recoCount();

                        $user = Session::get('auth');
                        $t = '';
                        $dept_desc = '';
                        if($user->level=='doctor')
                            $t='Dr.';
                        else if($user->level=='support')
                            $dept_desc = ' / IT Support';

                        if($user->department_id > 0)
                            $dept_desc = ' / ' . \App\Department::find($user->department_id)->description;

                    ?>
                    <span class="text-orange">
                        Welcome, </span> <span style="color: white">{{ $t }} {{ $user->fname }} {{ $user->lname }}
                        @if(!$multiple_login) {{ $dept_desc }} @endif
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <div style="padding: 2px;">
                    <?php
                    $user_logs = \App\Login::where("userId",$user->id)->orderBy("id","desc")->first();
                    $login_time = $user_logs->login;
                    $user_logs->logout == "0000-00-00 00:00:00" ? $logout_time = explode(' ',$user_logs->login)[0].' 23:59:59' : $logout_time = $user_logs->logout;
                    $logout_time = date("M d, Y H:i:s",strtotime($logout_time));
                    ?>
                    <span class="text-orange">Logout Time: </span> <span class="text-red" id="logout_time"> </span>&nbsp;
                    <button href="#setLogoutTime" data-toggle="modal" class="btn btn-xs btn-danger" onclick="openLogoutTime();"><i class="fa clock-o"></i> Set Time to Logout</button>
                </div>
            </div>
            <div class="col-md-3">
                <div style="padding: 2px;">
                    @if($user->level != 'vaccine' && !$multiple_login)
                        <span style="color: white">{{ \App\Facility::find($user->facility_id)->name }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <span class="text-orange">WebSocket: </span> <span class="websocket_status" style="color: white">Connecting...</span>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="header" style="background-color:#59ab91;padding:15px;">
            <div class="container">
                    @if($user->level == 'opcen')
                    <img src="{{ asset('resources/img/banner_711healthline2023v1.png?v=1') }}" class="img-responsive" />
                @elseif($user->level == 'bed_tracker')
                    <img src="{{ asset('resources/img/bed_banner.png?v=1') }}" class="img-responsive" />
                @elseif($user->level == 'vaccine')
                    <img src="{{ asset('resources/img/updated_vaccine_logo.png?v=1') }}" class="img-responsive" />
                @else
                    <img src="{{ asset('resources/img/banner_referral2023v1-01.png?v=1') }}" class="img-responsive" />
                @endif
            </div>
        </div>
        <div class="container" id="container-nav">
            @include('layouts.navbar')
        </div>
    </nav>

    <div class="{{ (request()->is([
                                'admin/report/patient/incoming','admin/report/patient/outgoing','admin/report/consolidated/incoming',
                                'admin/report/graph/incoming','admin/report/consolidated/incomingv2','admin/report/graph/bar_chart',
                                'vaccine/vaccineview/1','vaccine/vaccineview/2','vaccine/vaccineview/3','vaccine/vaccineview/4',

                                'onboard/facility/0','onboard/facility/1','onboard/facility/2','onboard/facility/3','onboard/facility/4',
                                'offline/facility/1','offline/facility/2','offline/facility/3','offline/facility/4',
                                'vaccine/facility/cebu','vaccine/facility/mandaue','vaccine/facility/lapu','weekly/report/1','weekly/report/2','weekly/report/3','weekly/report/4',
                                'admin/statistics',

                                'vaccine','bed_admin','reports','monitoring', 'admin/report/tat' ,'admin/report/tat/incoming', 'admin/report/tat/outgoing','admin/report/top/icd',
                                'admin/report/top/reason_for_referral','bed/'.$user->facility_id,
                                'admin/report/covid/1','admin/report/covid/2','admin/report/covid/3','admin/report/covid/4',
                                'report/walkin/1','report/walkin/2','report/walkin/3','report/walkin/4',

                                'doctor/appointment/calendar'
                                ]))
                                ? 'container-fluid'
                                : 'container'
                }}" >
            <div class="loading"></div>
            <div id="app_layout">
                <referral-app :user="{{ Session::get('auth') }}" :count_referral="{{ (int)$count }}"></referral-app>
            </div>
            @yield('content')
        <div class="clearfix"></div>
    </div> <!-- /container -->
</body>
</html>

@include('modal.server')
@include('modal.editProfile')
@include('modal.password')
@include('modal.duty')
@include('modal.login')
@include('modal.incoming')
@include('modal.feedback')

<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i></button>
<footer class="footer">
    <div class="container">
        <p class="text-center">All Rights Reserved {{ date("Y") }} | Version 6.7 </p>
    </div>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('resources/plugin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('resources/assets/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/jquery-validate.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('resources/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="{{ asset('resources/assets/js/script.js') }}?v=1"></script>

<script src="{{ asset('resources/plugin/Lobibox/Lobibox.js') }}?v=2"></script>
<script src="{{ asset('resources/plugin/select2/select2.min.js') }}?v=1"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('resources/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}?v=1"></script>

<!-- tinymce -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.3/tinymce.min.js"></script>

<script src="{{ url('resources/plugin/daterangepicker_old/moment.min.js') }}"></script>
<script src="{{ url('resources/plugin/daterangepicker_old/daterangepicker.js') }}"></script>

<script src="{{ asset('resources/assets/js/jquery.canvasjs.min.js') }}?v=1"></script>

<!-- TABLE-HEADER-FIXED -->
<script src="{{ asset('resources/plugin/table-fixed-header/table-fixed-header.js') }}"></script>

<!-- VUE Scripts -->
<script src="{{ asset('public/js/app_layout.js?version=').date('YmdHis') }}" defer></script>

@include('layouts.app_script')
{{--@include('script.firebase')--}}
@include('script.newreferral')
@include('script.password')
@include('script.duty')
{{--@include('script.desktop-notification')
@include('script.notification_new')--}}
@include('script.feedback')

@yield('js')