<?php
$user = Session::get('auth');
?>
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ url('resources/plugin/daterange/daterangepicker.css') }}" />
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
                <form class="form-inline" action="{{ url('doctor/archived') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Code,Firstname,Lastname" value="{{ \Illuminate\Support\Facades\Session::get('keywordArchived') }}" name="keyword">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" id="daterange" max="{{ date('Y-m-d') }}" name="daterange">
                    </div>
                    <button type="submit" class="btn btn-md btn-success" style="padding: 8px 15px;"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <h3 class="page-header">{{ $title }} <small class="text-danger">TOTAL: <span class="badge" style="cursor: pointer" onclick="exportArchivedExcel()">{{ number_format($data->total()) }}</span></small> </h3>
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
                                    <th>Date Archived</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $row)
                                    <?php
                                    $modal = ($row->type=='normal') ? '#normalFormModal' : '#pregnantFormModal';
                                    $type = ($row->type=='normal') ? 'Non-Pregnant' : 'Pregnant';
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
                                            <a data-toggle="modal" href="#referralForm"
                                                data-type="{{ $row->type }}"
                                                data-id="{{ $row->id }}"
                                                data-code="{{ $row->code }}"
                                                data-referral_status="referring"
                                                class="view_form">
                                                    <span class="text-primary">{{ $row->patient_name }}</span>
                                                    <br />
                                                    <small class="text-warning">{{ $row->code }}</small>
                                            </a>
                                        </td>
                                        <?php
                                        $status = '';
                                        $current = \App\Activity::where('code',$row->code)
                                            ->orderBy('id','desc')
                                            ->first();
                                        if($current)
                                        {
                                            $status = strtoupper($current->status);
                                        }
                                        ?>
                                        <td>{{ \App\Http\Controllers\doctor\PatientCtrl::getDischargeDate($current->status,$row->code) }}</td>
                                        <td>
                                            {!! nl2br(\App\Http\Controllers\doctor\PatientCtrl::getCancellationReason($current->status,$row->code)) !!}
                                        </td>
                                        <td>
                                            {{ $current->status == 'archived' ? "Didn't Arrived" : 'Not Accepted' }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{ $data->links() }}
                            </div>
                        </div>

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
    @include('modal.accept_reject')
@endsection
@include('script.firebase')
@section('js')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @include('script.datetime')
    @include('script.accepted')

    <script src="{{ url('resources/plugin/daterange/moment.min.js') }}"></script>
    <script src="{{ url('resources/plugin/daterange/daterangepicker.js') }}"></script>
    <?php
    $start = \Illuminate\Support\Facades\Session::get('startArchivedDate');
    $end = \Illuminate\Support\Facades\Session::get('endArchivedDate');
    if(!$start)
        $start = \Carbon\Carbon::now()->startOfYear()->format('m/d/Y');

    if(!$end)
        $end = \Carbon\Carbon::now()->endOfYear()->format('m/d/Y');

    $start = \Carbon\Carbon::parse($start)->format('m/d/Y');
    $end = \Carbon\Carbon::parse($end)->format('m/d/Y');
    ?>
    <script>
        $('#daterange').daterangepicker({
            "startDate": "{{ $start }}",
            "endDate": "{{ $end }}",
            "opens": "left"
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            console.log("{{ $start }}");
        });

        function exportArchivedExcel() {
            window.open("<?php echo asset('excel/export/archived'); ?>", '_blank');
        }
    </script>
@endsection

