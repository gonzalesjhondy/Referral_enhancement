<?php
$user = Session::get('auth');
$status = session::get('status');
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
        width: 30%;
    }

    .table-input tr td {
        border: 1px solid #bbb !important;
    }

    label {
        padding: 0px !important;
    }
</style>
<div class="col-md-9">
    <div class="row">
        <div class="jim-content">
            <h3 class="page-header">{{ $title }}</h3>
            @if($status == 'added')
            <div class="alert alert-success">
                <span class="text-success">
                    <i class="fa fa-check"></i> Added Successfully!
                </span>
            </div>
            @endif
            <form method="POST" class="form-horizontal form-submit" id="form-submit" action="{{ asset('doctor/patient/'.$method) }}">
                {{ csrf_field() }}
                <input type="hidden" id="from-consultation" name="from_consultation" value="">
                <table class="table table-input table-bordered table-hover" border="1">
                    <tr class="has-group">
                        <td>PhilHealth Status :</td>
                        <td>
                            <select class="form-control select_phic" name="phic_status" required>
                                <option>None</option>
                                <option>Member</option>
                                <option>Dependent</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>PhilHealth ID :<br /> <small class="text-info"><em>(If applicable)</em></small></td>
                        <td><input type="text" name="phicID" class="phicID form-control" disabled value="" /></td>
                    </tr>
                    <tr class="has-group">
                        <td>First Name :</td>
                        <td><input type="text" name="fname" class="fname form-control" required /> </td>
                    </tr>
                    <tr>
                        <td>Middle Name :</td>
                        <td><input type="text" name="mname" class="mname form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Last Name :</td>
                        <td><input type="text" name="lname" class="lname form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Contact Number :</td>
                        <td><input type="text" name="contact" class="contact form-control" required /> </td>
                    </tr>
                    <tr class="has-group">
                        <td>Birth Date :</td>
                        <td><input type="date" name="dob" id="dob" class="form-control" min="1910-05-11" max="{{ date('Y-m-d') }}" required /> </td>
                    </tr>
                    <tr>
                        <td>Sex :</td>
                        <td class="has-group">
                            <label style="cursor: pointer;"><input type="radio" name="sex" class="sex" value="Male" required style="display:inline;"> Male</label>
                            &nbsp;&nbsp;&nbsp;<br />
                            <label style="cursor: pointer;"><input type="radio" name="sex" class="sex" value="Female" required> Female</label>
                            <span class="span"></span>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Civil Status :</td>
                        <td>
                            <select name="civil_status" class="form-control" required id="civil_status" style="width: 100%">
                                <option>Single</option>
                                <option>Married</option>
                                <option>Divorced</option>
                                <option>Separated</option>
                                <option>Widowed</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Region: </td>
                        <td>
                            <select class="form-control region" name="region" onchange="othersRegion($(this),'{{ $province }}');" required>
                                <option value="Region VII">Region VII</option>
                                <option value="NCR">NCR</option>
                                <option value="CAR">CAR</option>
                                <option value="Region I">Region I</option>
                                <option value="Region II">Region II</option>
                                <option value="Region III">Region III</option>
                                <option value="Region IV-A">Region IV-A</option>
                                <option value="Mimaropa">Mimaropa</option>
                                <option value="Region V">Region V</option>
                                <option value="Region VI">Region VI</option>
                                <option value="Region VIII">Region VIII</option>
                                <option value="Region IX">Region IX</option>
                                <option value="Region X">Region X</option>
                                <option value="Region XI">Region XI</option>
                                <option value="Region XII">Region XII</option>
                                <option value="Region XIII">Region XIII</option>
                                <option value="BARMM">BARMM</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group ">
                        <td>Province :</td>
                        <td class="province_holder">
                            <select class="form-control province" name="province" onchange="filterSidebar($(this),'muncity')" required>
                                <option value="">Select Province</option>
                                @foreach($province as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr class="has-group ">
                        <td>Municipality/City :</td>
                        <td class="muncity_holder">
                            <select class="muncity select2" name="muncity" onchange="filterSidebar($(this),'barangay')" required>

                            </select>
                        </td>
                    </tr>
                    <tr class="has-group">
                        <td>Barangay :</td>
                        <td class="barangay_holder">
                            <select class="barangay select2" name="brgy" required>
                                <option value="">Select Barangay</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <a href="{{ asset('doctor/patient') }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-send"></i> Submit
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="col-md-3">
    @include('sidebar.quick')
</div>
@endsection
@section('js')
@include('script.filterMuncity')
<script>
    var telemedicineAppointment = JSON.parse(getCookie('telemedicineAppointment'));
    var telemedAppointment = @json(telemedicineAppointment);
    // console.log("teleme-add-patient",telemedAppointment);
    if (telemedicineAppointment.length > 0) {
        console.log('from-Add',telemedicineAppointment);
        $("#from-consultation").val(JSON.stringify(telemedicineAppointment));
    }

    $(".select2").select2({
        width: '100%'
    });
    $('.select_phic').on('change', function() {
        var status = $(this).val();
        if (status != 'None') {
            $('.phicID').attr('disabled', false);
        } else {
            $('.phicID').val('').attr('disabled', true);
        }
    });
</script>
@endsection