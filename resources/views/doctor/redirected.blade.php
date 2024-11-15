<?php
$user = Session::get('auth');

$start = \Illuminate\Support\Facades\Session::get('startRedirectedDate');
$end = \Illuminate\Support\Facades\Session::get('endRedirectedDate');
if(!$start)
    $start = \Carbon\Carbon::now()->subWeeks(52)->startOfYear()->format('m/d/Y');

if(!$end)
    $end = \Carbon\Carbon::now()->endOfYear()->format('m/d/Y');

$start = \Carbon\Carbon::parse($start)->format('m/d/Y');
$end = \Carbon\Carbon::parse($end)->format('m/d/Y');

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
                <form class="form-inline" action="{{ url('doctor/redirected') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Code,Firstname,Lastname" value="{{ \Illuminate\Support\Facades\Session::get('keywordRedirected') }}" name="keyword">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" value="{{ $start.' - '.$end }}" id="daterange" max="{{ date('Y-m-d') }}" name="daterange">
                    </div>
                    <button type="submit" class="btn btn-md btn-success" style="padding: 8px 15px;"><i class="fa fa-search"></i></button><br><br>
                    <div class="row">
                        <div class="col-md-7">
                            <select class="form-control select select2" id="facility_filter" name="facility_filter">
                                <option value="">Select facility...</option>
                                @foreach($facilities as $faci)
                                    <option value="{{ $faci->id }}">{{ $faci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-info btn-sm btn-flat"><i class="fa fa-filter"></i> Filter</button>
                            <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
                                <i class="fa fa-eye"></i> View All
                            </button><br><br>
                        </div>
                    </div>
                </form>
            </div>
            <h3 class="page-header">{{ $title }} <small class="text-danger">TOTAL: {{ number_format($data->total()) }}</small> <br><br></h3>
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
                                    <th width="25%">Referring Facility</th>
                                    <th width="25%">Patient Name/Code</th>
                                    <th width="25%">Date Redirected</th>
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
                                            @if(strlen($row->name)>35)
                                                    {{ substr($row->name,0,35) }}...
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
                                        <td>{{ \App\Http\Controllers\doctor\PatientCtrl::getRedirectedDate('redirected',$row->code) }}</td>
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
{{--@include('script.firebase')--}}
@section('js')
    @include('script.referred')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @include('script.datetime')
    @include('script.accepted')

    <script>
        $('#daterange').daterangepicker({
            "singleDatePicker": false,
            "startDate": "{{ $start }}",
            "endDate": "{{ $end }}",
            "opens": "left"
        });
    </script>
@endsection

