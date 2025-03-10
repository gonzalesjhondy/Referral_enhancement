<?php
$user = Session::get('auth');
$facilities = \App\Facility::select('id','name')
    ->where('id','!=','63')
    ->where('referral_used','yes')
    ->orderBy('name','asc')->get();
$multi_faci = \App\FacilityAssign::select('faci.id', 'faci.name')
    ->leftJoin('facility as faci', 'faci.id', '=', 'facility_assignment.facility_id')
    ->where('facility_assignment.user_id', $user->id)
    ->where('facility_assignment.status', 'Active')
    ->orderBy('faci.name','asc')
    ->get();
?>
@extends('layouts.app')

@section('content')
    <style>
        .table-input tr td:first-child {
            background: #f5f5f5;
            text-align: right;
            vertical-align: middle;
            font-weight: bold;
            padding: 3px;
            width:30%;
        }
        .table-input tr td {
            border:1px solid #bbb !important;
        }
        label {
            padding: 0px !important;
        }
    </style>
    <div class="col-md-9">
        <div class="box box-success">
            <div class="box-header with-border">
                <?php $title = isset($title) ? $title : "Login As";?>
                <h3>{{ $title. $user->user_id }}</h3>
            </div>
            <div class="box-body">
                <form method="POST" class="form-horizontal form-submit" id="hospitalForm" action="{{ asset('admin/login') }}">
                    {{ csrf_field() }}
                    <table class="table table-input table-bordered table-hover" border="1">
                        <tr class="has-group">
                            <td>Facility :</td>
                            <td>
                                <select class="form-control select2" name="facility_id" required>
                                    <option value="">Select Facility...</option>
                                    @if(count($multi_faci) > 1 && $user->level == 'doctor')
                                        @foreach($multi_faci as $f)
                                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach($facilities as $f)
                                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr class="has-group barangay_holder">
                            <td>User Level :</td>
                            <td>
                                <select class="form-control" name="level" required>
                                    @if($user->level == 'admin')
                                        <option value="">Select Level...</option>
                                        <option value="support">IT Support</option>
                                        <option value="doctor">Doctor</option>
                                        <option value="mcc">Medical Center Chief</option>
                                    @else
                                        <option value="doctor" selected>Doctor</option>
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-sign-in"></i> Login
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    @if($user->level == 'admin')
    <div class="col-md-3">
        @include('admin.sidebar.quick')
    </div>
    @endif
@endsection
@section('js')

@endsection

