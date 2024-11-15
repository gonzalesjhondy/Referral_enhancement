<?php
$user = Session::get('auth');
?>
@extends('layouts.app')

@section('content')
    <style>
        .widget-user-header {
            padding: 10px 15px !important;
        }
        .widget-user-2 {
            margin-top: 5px;
            margin-bottom: 0px;
            font-weight: 300;
        }
        .online_container {
            display: flex;
            flex-flow: row wrap;
        }
        .card-wrap {
            flex: 0 0 33%;
            display: flex;
            padding: 10px; /* gutter width */
        }
        .card {
            box-shadow: 0 0 4px rgba(0,0,0,0.4);
            flex: 0 0 100%;
            background-color: white;
        }
    </style>
    <div class="row">
        <div class="col-md-8">
            <div class="jim-content" style="background: rgba(255, 255, 255, 0.4)">
                <h3 class="page-header">{{ strtoupper($title) }}</h3>
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td class="text-left" width="100px;">ONLINE USERS</td>
                        <td ><span class="badge bg-blue online-user">0</span></td>
                    </tr>
                    <tr>
                        <td class="text-left" width="100px;">OFF DUTY BUT ONLINE</td>
                        <td >
                            <span class="badge bg-green online-off-duty">0</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" width="180px;">TOTAL ONLINE</td>
                        <td ><span class="badge bg-orange total-online">0</span></td>
                    </tr>
                    </tbody>
                </table>
                <?php
                $online_off_duty = 0;
                $online_user = 0;
                $total_online = 0;
                $doctor_online_count = 0;
                ?>
                @if(count($data)>0)
                    @foreach($data as $faci)
                        <section class="content" style="background-color: #b4b4b940">
                            <div class="box box-primary">
                                <h5><b> {{ $faci[0]->facility }} </b></h5>
                            </div>
                            <div class="online_container">
                            @for($i = 0; $i < count($faci); $i++)
                                <?php $row = $faci[$i];
                                if($row->status=='login_off'){
                                    $status = '<em>OFF DUTY</em>';
                                    $color = 'yellow';
                                    $online_off_duty++;
                                }
                                else {
                                    $color = 'blue';
                                    $status = 'ON DUTY';
                                    $online_user++;
                                }
                                $total_online++;
                                ?>
                                <div class="card-wrap">
                                    <div class="card">
                                        <div class="widget-user-header bg-{{ $color }}-active">
                                            <span>{{ $row->level == 'doctor' ? 'Dr. ' : '' }} {!! strtoupper($row->fname." ".$row->lname) !!}</span><br>
                                            &nbsp;<small class="widget-user-desc badge bg-maroon" style="margin-left: 0px;">{{ $row->abbr ? $row->abbr : "NO ABBR" }}</small>
                                        </div>
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <?php
                                                $contact = $explode = explode(",",$row->contact);
                                                ?>
                                                <li><a href="#" style="word-wrap: break-word">
                                                        @foreach($contact as $con)
                                                            {{ $con }}
                                                        @endforeach
                                                        <span class="pull-right badge bg-blue"><i class="fa fa-phone"></i> </span></a></li>
                                                <li><a href="#">{{ $row->department ? $row->department : "." }} <span class="pull-right badge bg-aqua"><i class="fa fa-hospital-o"></i> </span></a></li>
                                                <li><a href="#" class="text-{{ $color }}">{!! $status !!} <span class="pull-right badge bg-{{ $color }}">{{ date('h:i A',strtotime($row->login)) }}</span></a></li>
                                            </ul>
                                        </div>
                                        <?php $doctor_online_count++;?>
                                        @if( ($doctor_online_count % 3) == 0 )
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="online_container">
                                        @endif
                                    </div>
                                </div>
                            @endfor
                            </div>
                            <div class="clearfix"></div>
                            <?php $doctor_online_count = 0;?>
                        </section>
                    @endforeach
                @else
                    <div class="alert-section">
                        <div class="alert alert-warning">
                            <span class="text-warning">
                                <i class="fa fa-warning"></i> No Online Doctors!
                            </span>
                        </div>
                    </div>

                    <ul class="timeline">
                    </ul>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-4">
            @include('mcc.sidebar.hospitals')
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(".online-user").text("<?php echo $online_user; ?>");
        $(".online-off-duty").text("<?php echo $online_off_duty; ?>");
        $(".total-online").text("<?php echo $total_online; ?>");

        $(".hospital_online").text("<?php echo Session::get('hospital_online_count'); ?>");
    </script>
@endsection
