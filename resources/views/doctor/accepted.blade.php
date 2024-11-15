<?php
$user = Session::get('auth');
$start = \Carbon\Carbon::parse($start)->format('m/d/Y');
$end = \Carbon\Carbon::parse($end)->format('m/d/Y');
?>
@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <style>
        .facility {
            color: #ff8456;
        }
    </style>
    <div class="col-md-12">
        <div class="jim-content">
            <div class="pull-right">
                <form class="form-inline" action="{{ url('doctor/accepted') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Code,Firstname,Lastname" value="{{ \Illuminate\Support\Facades\Session::get('keywordAccepted') }}" name="keyword">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="daterange" value="{{ date("m/d/Y",strtotime($start)).' - '.date("m/d/Y",strtotime($end)) }}" max="{{ date('Y-m-d') }}" name="daterange">
                    </div>
                    <button type="submit" class="btn btn-md btn-success" style="padding: 8px 15px;"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <h3 class="page-header">{{ $title }} <small class="text-danger">TOTAL: {{ $patient_count }}</small> </h3>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    @if(count($data)>0)
                        <div class="hide info alert alert-success">
                        <span class="text-success">
                            <i class="fa fa-check"></i> <span class="message"></span>
                        </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-gray">
                                <tr>
                                    <th></th>
                                    <th>Referring Facility</th>
                                    <th>Patient Name/Code</th>
                                    <th>Date Accepted</th>
                                    <th>Current Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                    <?php
                                    $modal = ($row->type=='normal') ? '#normalFormModal' : '#pregnantFormModal';
                                    $type = ($row->type=='normal') ? 'Non-Pregnant' : 'Pregnant';
                                    //$step = \App\Http\Controllers\doctor\ReferralCtrl::step($row->code);
                                    $step = \App\Http\Controllers\doctor\ReferralCtrl::step_v2($row->status);
                                    $feedback = \App\Feedback::where('code',$row->code)->count();

                                    $status = '';
                                    $current = \App\Activity::where('code',$row->code)
                                        ->orderBy('id','desc')
                                        ->first();
                                    if($current)
                                    {
                                        $status = strtoupper($current->status);
                                    }

                                    $start = \Carbon\Carbon::parse($row->date_accepted);
                                    $end = \Carbon\Carbon::now();
                                    $diff = $end->diffInHours($start);
                                    ?>
                                    <tr>
                                        <td width="1%">
                                            <a href="{{ asset('doctor/referred?referredCode=').$row->code }}" class="btn btn-xs btn-success" target="_blank">
                                                <i class="fa fa-stethoscope"></i> Track
                                            </a>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <span class="facility" title="{{ $row->name }}">
                                            @if(strlen($row->name)>25)
                                                {{ substr($row->name,0,25) }}...
                                            @else
                                                {{ $row->name }}
                                            @endif
                                            </span>
                                            <br />
                                            <span class="text-muted">{{ $type }}</span>
                                        </td>
                                        <td>
                                            <a href="#referralForm" class="view_form"
                                               data-toggle="modal"
                                               data-type="{{ $row->type }}"
                                               data-id="{{ $row->id }}"
                                               data-code="{{ $row->code }}">
                                                <span class="text-primary">{{ $row->patient_name }}</span>
                                                <br />
                                                <small class="text-warning">{{ $row->code }}</small>
                                            </a>
                                        </td>
                                        <td>{{ $row->date_accepted }}</td>
                                        <td class="activity_{{ $row->code }}">{{ $status }}</td>
                                        <td style="white-space: nowrap;">
                                            @if($row->department_id === 5 && $row->action_md === $user->id)
                                                <button class="btn-sm bg-success btn-flat" id="telemedicine" onclick="openTelemedicine('{{ $row->id }}','{{ $row->code }}','{{ $row->action_md }}','{{ $row->referring_md }}','{{ $row->type }}');"><i class="fa fa-camera"></i></button>
                                                @if($row->prescription)
                                                    <a href="{{ url('doctor/print/prescription').'/'.$row->id }}" target="_blank" type="button" style="border: 1px solid black;color: black;" class="btn btn-sm bg-warning btn-flat" id="prescription"><i class="fa fa-file-zip-o"></i></a>
                                                @endif
                                            @endif
                                            @if( ($status=='ACCEPTED' || $status == 'TRAVEL'))
                                                <button class="btn btn-sm btn-primary btn-action"
                                                        title="Patient Arrived"

                                                        data-toggle="modal"
                                                        data-toggle="tooltip"
                                                        data-target="#arriveModal"
                                                        data-track_id="{{ $row->id }}"
                                                        data-patient_name="{{ $row->patient_name }}"
                                                        data-code="{{ $row->code}}">
                                                    <i class="fa fa-wheelchair"></i>
                                                </button>
                                            @endif
                                            @if( ($status=='ACCEPTED' || $status == 'TRAVEL'))
                                                <button class="btn btn-sm btn-danger btn-action"
                                                        title="Patient Didn't Arrive"

                                                        data-toggle="modal"
                                                        data-toggle="tooltip"
                                                        data-target="#archiveModal"
                                                        data-track_id="{{ $row->id }}"
                                                        data-patient_name="{{ $row->patient_name }}"
                                                        data-code="{{ $row->code}}">
                                                    <i class="fa fa-wheelchair"></i>
                                                </button>
                                            @endif

                                            @if($status=='ARRIVED' || $status=='ADMITTED')
                                                @if($status != 'ADMITTED')
                                                    <button class="btn btn-sm btn-info btn-action"
                                                            title="Patient Admitted"

                                                            data-toggle="modal"
                                                            data-toggle="tooltip"
                                                            data-target="#admitModal"
                                                            data-track_id="{{ $row->id }}"
                                                            data-patient_name="{{ $row->patient_name }}"
                                                            data-code="{{ $row->code}}">
                                                        <i class="fa fa-stethoscope"></i>
                                                    </button>
                                                @endif

                                                <button class="btn btn-sm btn-warning btn-action"
                                                        title="Patient Discharged"

                                                        data-toggle="modal"
                                                        data-toggle="tooltip"
                                                        data-target="#dischargeModal"
                                                        data-track_id="{{ $row->id }}"
                                                        data-patient_name="{{ $row->patient_name }}"
                                                        data-code="{{ $row->code}}">
                                                    <i class="fa fa-wheelchair-alt"></i>
                                                </button>

                                                <button class="btn btn-sm btn-success btn-action btn-transfer"
                                                        title="Transfer Patient"

                                                        data-toggle="modal"
                                                        data-toggle="tooltip"
                                                        data-target="#referAcceptFormModal"
                                                        data-track_id="{{ $row->id }}"
                                                        data-patient_name="{{ $row->patient_name }}"
                                                        data-code="{{ $row->code}}">
                                                    <i class="fa fa-ambulance"></i>
                                                </button>
                                            @endif

                                            @if($step<=4)
                                                <button class="btn btn-sm btn-info btn-feedback" data-toggle="modal"
                                                        data-target="#feedbackModal"
                                                        data-code="{{ $row->code }}">
                                                    <i class="fa fa-comments"> {{ $feedback }}</i>

                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{ $data->links() }}
                            </div>
                        </div>
                        <table class="table table-striped">
                            <caption>LEGENDS:</caption>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn-sm bg-success btn-flat"><i class="fa fa-camera"></i></button></td>
                                <td>Telemedicine</td>
                            </tr>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn-sm bg-warning btn-flat"><i class="fa fa-file-zip-o"></i></button></td>
                                <td>Prescription</td>
                            </tr>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn btn-sm btn-primary"><i class="fa fa-wheelchair"></i></button></td>
                                <td>Patient Arrived</td>
                            </tr>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn btn-sm btn-danger"><i class="fa fa-wheelchair"></i></button></td>
                                <td>Patient Didn't Arrive</td>
                            </tr>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn btn-sm btn-info"><i class="fa fa-stethoscope"></i> </button></td>
                                <td>Patient Admitted</td>
                            </tr>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn btn-sm btn-warning"><i class="fa fa-wheelchair-alt"></i> </button></td>
                                <td>Patient Discharged</td>
                            </tr>
                            <tr>
                                <td class="text-right" width="60px"><button class="btn btn-sm btn-success"><i class="fa fa-ambulance"></i></button></td>
                                <td>Transfer Patient</td>
                            </tr>
                        </table>
                    @else
                        <div class="alert alert-warning">
                        <span class="text-warning">
                            <i class="fa fa-warning"></i> No data found!
                        </span>
                        </div>
                    @endif
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>

    </div>
    @include('modal.refer')
    @include('modal.accepted')
    @include('modal.accept_reject')
    {{--@include('modal.feedback')--}}
@endsection
{{--@include('script.firebase')--}}
@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @include('script.datetime')
    @include('script.accepted')
    @include('script.feedback')

    <script>
        $('#daterange').daterangepicker({
            "opens" : "left"
        });

        function openTelemedicine(tracking_id, code, action_md, referring_md, type) {
            var url = "<?php echo asset('api/video/call'); ?>";
            var json = {
                "_token" : "<?php echo csrf_token(); ?>",
                "tracking_id" : tracking_id,
                "code" : code,
                "action_md" : action_md,
                "referring_md" : referring_md,
                "trigger_by" : "{{ $user->id }}",
                "form_type" : type
            };
            $.post(url,json,function(){

            });
            /*window.open("{{ asset('doctor/telemedicine?id=') }}"+tracking_id+"&code="+code, "_blank", "fullscreen=yes");*/
            var windowName = 'NewWindow'; // Name of the new window
            var windowFeatures = 'width=600,height=400'; // Features for the new window (size, position, etc.)
            var newWindow = window.open("{{ asset('doctor/telemedicine?id=') }}"+tracking_id+"&code="+code+"&form_type="+type+"&referring_md=no", windowName, windowFeatures);
            if (newWindow && newWindow.outerWidth) {
                // If the window was successfully opened, attempt to maximize it
                newWindow.moveTo(0, 0);
                newWindow.resizeTo(screen.availWidth, screen.availHeight);
            }
        }
    </script>
@endsection

