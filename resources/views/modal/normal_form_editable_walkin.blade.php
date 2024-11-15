<?php
$user = Session::get('auth');
$facilities = \App\Facility::select('id','name')
    ->where('id','!=',$user->facility_id)
    ->where('status',1)
    ->where('referral_used','yes')
    ->orderBy('name','asc')->get();
$myfacility = \App\Facility::find($user->facility_id);
$facility_address = \App\Http\Controllers\LocationCtrl::facilityAddress($myfacility->id);
$departments = \App\Http\Controllers\LocationCtrl::getDepartmentByFacility($myfacility->id);
$referral_reasons = \App\ReasonForReferral::get();
?>
<div class="modal fade" role="dialog" id="normalFormModalWalkIn">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('doctor/patient') }}" method="POST" class="form-submit normal_form_walkin">
                <div class="jim-content">
                    @include('include.header_form')
                    <div class="form-group-sm form-inline">
                        {{ csrf_field() }}
                        <input type="hidden" name="patient_id" class="patient_id" value="" />
                        <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                        <input type="hidden" name="code" value="" />
                        <input type="hidden" name="source" value="{{ $source }}" />
                        <input type="hidden" class="referring_name" value="" /><br>

                        <div class="row">
                            <div class="col-md-3">
                                <small class="text-success"><b>NAME OF REFERRING FACILITY:</b></small>
                            </div>
                            <div class="col-md-8">
                                <select name="referring_facility_walkin" class="form-control-select select2 select_facility_walkin" style="width: 100%;" required>
                                    <option value="">Select Facility...</option>
                                    @foreach($facilities as $row)
                                        <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-2">
                                <small class="text-success"><b>ADDRESS:</b></small>
                            </div>
                            <div class="col-md-10">
                                <span class="text-primary facility_address"></span>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-7">
                                <small class="text-success"><b>REFERRED TO:</b></small>
                                {{ $myfacility->name }}
                            </div>
                            <div class="mobile-view"><br></div>
                            <div class="col-md-5">
                                <small class="text-success"><b>DEPARTMENT:</b></small>
                                <select name="referred_department" class="form-control-select select_department select_department_normal" style="padding: 3px" required>
                                    <option value="">Select Department...</option>
                                    @foreach($departments as $d)
                                        <option value="{{ $d->id }}">{{ $d->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>ADDRESS:</b></small>
                                {{ $facility_address['address'] }}
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-7">
                                <small class="text-success"><b>DATE/TIME REFERRED (ReCo):</b></small>
                                {{ date('l F d, Y h:i A') }}
                            </div>
                            <div class="mobile-view"><br></div>
                            <div class="col-md-5">
                                <small class="text-success"><b>DATE/TIME TRANSFERRED:</b></small>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-5">
                                <small class="text-success"><b>NAME OF PATIENT: </b></small>
                                <span class="text-danger patient_name"></span>
                            </div>
                            <div class="web-view">
                                <div class="col-md-2">
                                    <small class="text-success"><b>AGE: </b></small>
                                    <span class="text-danger patient_age"></span>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-success"><b>SEX: </b></small>
                                    <select name="patient_sex" class="patient_sex form-control-select" style="padding: 3px" required>
                                        <option value="">Select...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-success"><b>STATUS: </b></small>
                                    <select name="civil_status" class="civil_status form-control-select" style="padding: 3px" required>
                                        <option value="">Select...</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Divorced</option>
                                        <option>Separated</option>
                                        <option>Widowed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mobile-view">
                                <br>
                                <div class="col-md-7">
                                    <table class="table">
                                        <tr>
                                            <td style="width:10%;">
                                                <small class="text-success"><b>AGE: </b></small>
                                                <span class="text-danger patient_age"></span>
                                            </td>
                                            <td style="width:15%;">
                                                <small class="text-success"><b>SEX: </b></small>
                                                <select name="patient_sex" class="patient_sex form-control-select" style="padding: 3px" required>
                                                    <option value="">Select...</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </td>
                                            <td style="width:15%;">
                                                <small class="text-success"><b>STATUS: </b></small>
                                                <select name="civil_status" class="civil_status form-control-select" style="padding: 3px" required>
                                                    <option value="">Select...</option>
                                                    <option>Single</option>
                                                    <option>Married</option>
                                                    <option>Divorced</option>
                                                    <option>Separated</option>
                                                    <option>Widowed</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>ADDRESS: </b></small>
                                <span class="text-danger patient_address"></span>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-7">
                                <small class="text-success"><b>PHILHEALTH STATUS: </b></small>
                                <div class="mobile-view"><br></div>
                                <label>None <input type="radio" name="phic_status" value="None" checked></label>
                                <label>Member <input type="radio" name="phic_status" value="Member"></label>
                                <label>Dependent <input type="radio" name="phic_status" value="Dependent"></label>
                            </div>
                            <div class="mobile-view"><br></div>
                            <div class="col-md-5">
                                <small class="text-success"><b>PHILHEALTH #:</b></small>
                                <input type="text" class="text-danger form-control phic_id" name="phic_id" />
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>CASE SUMMARY: </b><i>(pertinent Hx/PE, including meds, labs, course etc.)</i></small>
                                <textarea class="form-control" name="case_summary" style="resize: none;width: 100%;" rows="7" required></textarea>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>SUMMARY OF RECO: </b><i>(pls. refer to ReCo Guide in Referring Patients Checklist)</i></small>
                                <textarea class="form-control" name="reco_summary" style="resize: none;width: 100%;" rows="7" required></textarea>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>DIAGNOSIS: </b></small>
                                <span class="text-red">*</span><br><br>
                                <a data-toggle="modal" data-target="#modal-icd" type="button" class="btn btn-sm btn-success" onclick="searchICD()">
                                    <i class="fa fa-medkit"></i> Add ICD-10
                                </a>
                                <button type="button" class="btn btn-sm btn-success" onclick="addNotesDiagnoses()"><i class="fa fa-plus"></i> Add Notes in Diagnosis
                                </button>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <button type="button" id="clear_icd_walkin" class="btn btn-sm btn-danger" onclick="clearIcd()">Clear ICD-10</button>
                                <div class="text-green" id="selected_icd" style="padding-top: 5px;"></div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <button type="button" id="clear_notes_walkin" class="btn btn-sm btn-info" onclick="clearNotesDiagnoses()">Clear notes diagnosis</button>
                                <div id="add_diagnosis_notes" style="padding-top: 5px;"></div>
                            </div>
                        </div><br>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <button type="button" id="clear_other_diag_walkin" class="btn btn-sm btn-warning" onclick="clearOtherDiagnoses()">Clear other Diagnosis</button>
                                <div id="other_diagnosis" style="padding-top: 5px;"></div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>REASON FOR REFERRAL: </b></small>
                                <span class="text-red">*</span><br>
                                <select name="reason_referral1" class="form-control-select select2 reason_referral" style="width: 100%" required>
                                    <option value="">Select reason for referral</option>
                                    <option value="-1">Other reason for referral</option>
                                    @foreach($referral_reasons as $reason)
                                        <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <div id="other_referral_reason"></div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-success"><b>NAME OF REFERRED:</b></small><br>
                                <small class="text-success"><i></i>MD/HCW- Mobile Contact # (ReCo):</small></small>
                            </div>
                            <div class="col-md-8">
                                <select name="referred_md" class="referred_md select2 form-control-select" style="width: 100%;">
                                    <option value="">Any...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat cancelWalkin" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                        <button type="submit" id="sbmtWalkin" class="btn btn-success btn-flat btn-submit"><i class="fa fa-send"></i> Submit</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="patient_modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body patient_body">
                <center>
                    <img src="{{ asset('resources/img/loading.gif') }}" alt="">
                </center>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-icd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title" style="font-size: 17pt;">Search ICD-10 by keyword:</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-lg">
                    <input type="text" id="icd10-keyword" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" onclick="searchICD()">Find</button>
                    </span>
                </div><br>
                <div class="icd_body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="otherDiagnoses()">Other Diagnosis</button>
                <button type="button" class="btn btn-success" onclick="getAllCheckbox()"><i class="fa fa-save"></i> Save selected check</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#clear_icd_walkin").hide();
    $("#clear_notes_walkin").hide();
    $("#clear_other_diag_walkin").hide();

    $("#sbmtWalkin").on('click',function(e){
        if(!($("#icd_walkin").val()) && !($("#other_diag_walkin").val())){
            Lobibox.alert("error", {
                msg: "Select ICD-10 / Other diagnosis!"
            });
            return false;
        }
    });

    function clearIcd(){
        $('#selected_icd').html("");
        $("#clear_icd_walkin").hide();
    }

    function clearOtherDiagnoses(){
        $("#other_diagnosis").html("");
        $("#clear_other_diag_walkin").hide();
    }

    function clearNotesDiagnoses(){
        $("#add_diagnosis_notes").html("");
        $("#clear_notes_walkin").hide();
    }

    function clearOtherReferralReason(){
        $("#other_referral_reason").html("");
    }

    function addNotesDiagnoses(){
        $("#add_diagnosis_notes").html(loading);
        $("#clear_notes_walkin").show();
        setTimeout(function(){
            $("#add_diagnosis_notes").html('<small class="text-success">ADD NOTES IN DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control add_notes_diagnosis" name="diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>')
        },500);
    }

    $('.reason_referral').on('change', function() {
        var value = $(this).val();
        if(value == '-1') {
            $("#other_referral_reason").html(loading);
            setTimeout(function(){
                $("#other_referral_reason").html('<small class="text-success">OTHER REASON FOR REFERRAL:</small> <span class="text-red">*</span>\n' +
                    '                                <br />\n' +
                    '                                <textarea class="form-control" name="other_reason_referral" style="resize: none;width: 100%;" rows="7" required></textarea>')
            },500);
            $("#other_referral_reason").show();
        }else{
            clearOtherReferralReason();
        }
    });

    function searchICD() {
        $(".icd_body").html(loading);
        var url = "<?php echo asset('icd/search'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "icd_keyword" : $("#icd10-keyword").val()
        };
        $.post(url,json,function(result){
            setTimeout(function(){
                $(".icd_body").html(result);
            },500);
        });
    }

    function getAllCheckbox() {
        $('#modal-icd').modal('toggle');
        $("#clear_icd_walkin").show();
        var values = [];
        $('input[name="icd_checkbox[]"]:checked').each(function () {
            values[values.length] = (this.checked ? $(this).parent().parent().siblings("td").eq(1).text() : "");
            var icd_description = $(this).parent().parent().siblings("td").eq(1).text();
            var id = $(this).val();
            if(this.checked){
                $("#selected_icd").append('=> '+icd_description+' '+'<br><input id="icd_walkin" type="hidden" name="icd_ids[]" value="'+id+'">');
            }
            clearOtherDiagnoses();
        });
        console.log(values);
    }

    function otherDiagnoses(){
        $('#modal-icd').modal('hide');
        $("#other_diagnosis").html(loading);
        $("#clear_other_diag_walkin").show();
        setTimeout(function(){
            $("#other_diagnosis").html('<small class="text-success">OTHER DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control reason_referral" id="other_diag_walkin" name="other_diagnoses" style="resize: none;width: 100%;" rows="7" required></textarea>')
        },500);
    }
</script>