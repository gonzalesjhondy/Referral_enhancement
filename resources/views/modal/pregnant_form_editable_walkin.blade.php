<?php
$user = Session::get('auth');
$myfacility = \App\Facility::find($user->facility_id);
$facilities = \App\Facility::select('id','name')
    ->where('id','!=',$user->facility_id)
    ->where('status',1)
    ->orderBy('name','asc')->get();
$facility_address = \App\Http\Controllers\LocationCtrl::facilityAddress($myfacility->id);
$departments = \App\Http\Controllers\LocationCtrl::getDepartmentByFacility($myfacility->id);
$reason_for_referral = \App\ReasonForReferral::get();
?>
<div class="modal fade" role="dialog" id="pregnantFormModalWalkIn">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" class="form-submit pregnant_form_walkin">
                <div class="jim-content">
                    @include('include.header_form')
                    <div class="form-group-sm form-inline">
                        {{ csrf_field() }}
                        <input type="hidden" name="patient_id" class="patient_id" value="" />
                        <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                        <input type="hidden" name="code" value="" />
                        <input type="hidden" name="source" value="{{ $source }}" />
                        <input type="hidden" class="referring_name" value="{{ $myfacility->name }}" /><br>

                        <div class="row">
                            <div class="col-md-12">
                                <b>REFERRAL RECORD</b>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-2">
                                <b>WHO IS REFERRING: </b>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>RECORD NUMBER: </b></small>
                                <input type="text" class="form-control" name="record_no" placeholder="" style="width:100%;"/>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>REFERRED DATE: </b></small>
                                {{ date('l M d, Y') }}
                            </div>
                            <div class="col-md-2">
                                <small class="text-success"><b>TIME: </b></small>
                                {{ date('h:i A') }}
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-success"><b>NAME OF REFERRING MD/HCW: </b></small>
                                <span class="text-danger">Not Specified</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>ARRIVAL DATE: </b></small>
                            </div>
                            <div class="col-md-2">
                                <small class="text-success"><b>TIME: </b></small>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-1">
                                <small class="text-success"><b>FACILITY: </b></small>
                            </div>
                            <div class="col-md-8">
                                <select name="referring_facility_walkin" class="form-control-select select2 select_facility_walkin" style="width: 100%" required>
                                    <option value="">Select Facility...</option>
                                    @foreach($facilities as $row)
                                        <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>ACCOMPANIED BY THE HEALTH WORKER: </b></small>
                                <input type="text" class="form-control" name="health_worker" style="width: 50%;" placeholder="Name of Health Worker"/>
                            </div>
                        </div><br class="mobile-view">

                        <div class="row">
                            <div class="col-md-2">
                                <small class="text-success"><b>REFERRED TO: </b></small>
                            </div>
                            <div class="col-md-5">
                                <span class="text-info">{{ $myfacility->name }}</span>
                            </div><br class="mobile-view">
                            <div class="col-md-5">
                                <small class="text-success"><b>DEPARTMENT: </b></small>
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
                                <small class="text-success"><b>ADDRESS: </b></small>
                                <span class="text-primary">{{ $facility_address['address'] }}</span>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-sm-6">
                                <table class="table bg-warning">
                                    <tr class="bg-gray">
                                        <th colspan="4">WOMAN</th>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><small class="text-success"><b>NAME: </b></small> <span class="text-danger patient_name"></span></td>
                                        <td><small class="text-success"><b>AGE: </b></small> <span class="text-danger patient_age"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><small class="text-success"><b>ADDRESS: </b></small> <span class="text-danger patient_address"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <small class="text-success"><b>MAIN REASON FOR REFERRAL: </b></small>
                                            <label><input type="radio" name="woman_reason" value="None" checked /> None </label>
                                            <label><input type="radio" name="woman_reason" value="Emergency" /> Emergency </label>
                                            <label><input type="radio" name="woman_reason" value="Non-Emergency" /> Non-Emergency </label>
                                            <label><input type="radio" name="woman_reason" value="To accompany the baby" /> To accompany the baby </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <small class="text-success"><b>MAJOR FINDINGS: </b><i>(Clinica and BP,Temp,Lab)</i></small>
                                            <br />
                                            <textarea class="form-control" name="woman_major_findings" style="resize: none;width: 100%" rows="5" required></textarea>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray">
                                        <td colspan="4">Treatments Give Time</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><small class="text-success"><b>BEFORE REFERRAL</b></small>
                                            <br />
                                            <input type="text" class="form-control" name="woman_before_treatment" placeholder="Treatment Given" />
                                            <input type="text" class="form-control form_datetime" name="woman_before_given_time" placeholder="Date/Time Given" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><small class="text-success"><b>DURING TRANSPORT</b></small>
                                            <br />
                                            <input type="text" class="form-control" name="woman_during_treatment" placeholder="Treatment Given" />
                                            <input type="text" class="form-control form_datetime" name="woman_during_given_time" placeholder="Date/Time Given" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <small class="text-success"><b>INFORMATION GIVEN TO THE WOMAN AND COMPANION ABOUT THE REASON FOR REFERRAL</b></small>
                                            <br />
                                            <textarea class="form-control woman_information_given" name="woman_information_given" style="resize: none;width: 100%" rows="5" required></textarea>
                                        </td>
                                    </tr>
                                    {{--<tr>--}}
                                        {{--<td colspan="6">--}}
                                            {{--Diagnosis/Impression:--}}
                                            {{--<br />--}}
                                            {{--<textarea class="form-control" rows="7" name="diagnosis" style="resize: none;width: 100%;margin-top: 1%" required></textarea>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                         <td colspan="4">
                                            <small class="text-success"><b>DIAGNOSIS</b><span class="text-red">*</span></small>
                                            <br><br>
                                            <a data-toggle="modal" data-target="#icd-modal-preg-walkin" type="button" class="btn btn-sm btn-success" onclick="searchICD10PregWalkin()">
                                                <i class="fa fa-medkit"></i>  Add ICD-10
                                            </a>
                                            <button type="button" class="btn btn-sm btn-success" onclick="addNotesDiagnosisPregWalkin()"><i class="fa fa-plus"></i> Add notes in diagnosis</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" id="clear_icd_pwalkin" class="btn btn-sm btn-danger" onclick="clearICDPregWalkin()"> Clear ICD-10</button>
                                            <div class="text-green" id="icd_selected_preg_walkin" style="padding-top: 5px;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" id="clear_notes_pwalkin" class="btn btn-sm btn-info" onclick="clearNotesDiagnosisPregWalkin()"> Clear notes diagnosis</button>
                                            <div id="add_notes_diagnosis_preg_walkin" style="padding-top: 5px;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <button type="button" id="clear_other_diag_pwalkin" class="btn btn-sm btn-warning" onclick="clearOtherDiagnosisPregWalkin()"> Clear other diagnosis</button>
                                            <div id="others_diagnosis_preg_walkin" style="padding-top: 5px;">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small class="text-success"><b>REASON FOR REFERRAL: </b> <span class="text-red">*</span></small>
                                        <select name="reason_referral1" class="form-control-select select2 reason_referral" style="width: 100%;" required>
                                            <option value="">Select reason for referral</option>
                                            <option value="-1">Other reason for referral</option>
                                            @foreach($reason_for_referral as $reason_referral)
                                                <option value="{{ $reason_referral->id }}">{{ $reason_referral->reason }}</option>
                                            @endforeach
                                        </select>
                                        <div id="other_reason_referral_preg_walkin"></div>
                                    </div>
                                </div>
                            </div><br class="mobile-view">

                            <div class="col-sm-6">
                            <table class="table bg-warning">
                                <tr class="bg-gray">
                                    <th colspan="4">BABY</th>
                                </tr>
                                <tr>
                                    <td colspan="2"><small class="text-success"><b>NAME: </b></small><br />
                                        <input type="text" class="form-control" style="width: 100%" name="baby_fname" placeholder="First Name" /><br />
                                        <input type="text" class="form-control" style="width: 100%" name="baby_mname" placeholder="Middle Name" /><br />
                                        <input type="text" class="form-control" style="width: 100%" name="baby_lname" placeholder="Last Name" />
                                    </td>
                                    <td style="vertical-align: top !important;"><small class="text-success"><b>DATE AND HOUR OF BIRTH: </b></small>
                                        <br />
                                        <input type="text" class="form-control  form_datetime" style="width: 100%" name="baby_dob" placeholder="Date/Time" /><br />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><small class="text-success"><b>BIRTH WEIGHT: </b></small> <input type="text" class="form-control" style="width: 100%" name="baby_weight" placeholder="kg or lbs" /><br /></td>
                                    <td><small class="text-success"><b>GESTATIONAL AGE: </b></small> <input type="text" class="form-control" style="width: 100%" name="baby_gestational_age" placeholder="age" /><br /></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <small class="text-success"><b>MAIN REASON FOR REFERRAL: </b></small>
                                        <label><input type="radio" name="baby_reason" value="None" checked /> None </label>
                                        <label><input type="radio" name="baby_reason" value="Emergency" /> Emergency </label>
                                        <label><input type="radio" name="baby_reason" value="Non-Emergency" /> Non-Emergency </label>
                                        <label><input type="radio" name="baby_reason" value="To accompany the mother" /> To accompany the mother </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>MAJOR FINDINGS: </b><i>(Clinica and BP,Temp,Lab)</i></small><br />
                                        <textarea class="form-control" name="baby_major_findings" style="resize: none;width: 100%" rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>LAST (BREAST) FEED (TIME): </b></small> <input type="text" class="form-control form_datetime" style="width: 100%" name="baby_last_feed" placeholder="Date/Time" /><br /></td>
                                </tr>
                                <tr class="bg-gray">
                                    <td colspan="4">Treatments Give Time</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>BEFORE REFERRAL</b></small><br />
                                        <input type="text" class="form-control" name="baby_before_treatment" placeholder="Treatment Given" />
                                        <input type="text" class="form-control form_datetime" name="baby_before_given_time" placeholder="Date/Time Given" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>DURING TRANSPORT</b></small><br />
                                        <input type="text" class="form-control" name="baby_during_treatment" placeholder="Treatment Given" />
                                        <input type="text" class="form-control form_datetime" name="baby_during_given_time" placeholder="Date/Time Given" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <small class="text-success"><b>INFORMATION GIVEN TO THE WOMAN AND COMPANION ABOUT THE REASON FOR REFERRAL</b></small>
                                        <br />
                                        <textarea class="form-control" name="baby_information_given" style="resize: none;width: 100%" rows="5"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat cancelWalkin" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                        <button type="submit" id="sbmtPregWalkin" class="btn btn-success btn-flat btn-submit"><i class="fa fa-send"></i> Submit</button>
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

<div class="modal fade" id="icd-modal-preg-walkin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" style="font-size: 17pt;">Search ICD-10 by keyword</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-lg">
                    <input type="text" id="icd10_keyword_preg_walkin" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" onclick="searchICD10PregWalkin()">Find</button>
                    </span>
                </div><br>
                <div class="icd_body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="othersDiagnosisPregWalkin()"> Other Diagnosis</button>
                <button type="button" class="btn btn-success" onclick="getAllCheckBoxPregWalkin()"><i class="fa fa-save"></i> Save selected check</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $("#clear_other_diag_pwalkin").hide();
    $("#clear_notes_pwalkin").hide();
    $("#clear_icd_pwalkin").hide();

    $("#sbmtPregWalkin").on('click',function(e){
        if(!($("#icd_preg_walkin").val()) && !($("#other_preg_walkin").val())){
            Lobibox.alert("error", {
                msg: "Select ICD-10 / Other diagnosis!"
            });
            return false;
        }
    });

    function clearICDPregWalkin() {
        $("#icd_selected_preg_walkin").html("");
        $("#clear_icd_pwalkin").hide();
    }

    function clearOtherDiagnosisPregWalkin() {
        $("#others_diagnosis_preg_walkin").html("");
        $("#clear_other_diag_pwalkin").hide();
    }

    function clearNotesDiagnosisPregWalkin() {
        $("#add_notes_diagnosis_preg_walkin").html("");
        $("#clear_notes_pwalkin").hide();
    }

    function clearOtherReasonReferralPregWalkin() {
        $("#other_reason_referral_preg_walkin").html("");
    }

    function addNotesDiagnosisPregWalkin() {
        $("#add_notes_diagnosis_preg_walkin").html(loading);
        $("#clear_notes_pwalkin").show();
        setTimeout(function(){
            $("#add_notes_diagnosis_preg_walkin").html('<small class="text-success">ADD NOTES IN DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control add_notes_diagnosis" name="notes_diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>');
        },500);
    }

    $('.reason_referral').on('change', function() {
        var value = $(this).val();
        if(value == '-1') {
            $("#other_reason_referral_preg_walkin").html(loading);
            setTimeout(function(){
                $("#other_reason_referral_preg_walkin").html('<small class="text-success">OTHER REASON FOR REFERRAL:</small> <span class="text-red">*</span>\n' +
                    '                                <br />\n' +
                    '                                <textarea class="form-control" name="other_reason_referral" style="resize: none;width: 100%;" rows="7" required></textarea>');
            },500);
            $("#other_reason_referral_preg_walkin").show();
        }else{
            clearOtherReasonReferralPregWalkin();
        }
    });

    function searchICD10PregWalkin() {
        $(".icd_body").html(loading);
        var url = "<?php echo asset('icd/search'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "icd_keyword" : $("#icd10_keyword_preg_walkin").val()
        };
        $.post(url,json,function(result){
            setTimeout(function(){
                $(".icd_body").html(result);
            },500);
        });
    }

    function getAllCheckBoxPregWalkin() {
        $('#icd-modal-preg-walkin').modal('toggle');
        $("#clear_icd_pwalkin").show();
        var values = [];

        $('input[name="icd_checkbox[]"]:checked').each(function () {
            values[values.length] = (this.checked ? $(this).parent().parent().siblings("td").eq(1).text() : "");
            var icd_description = $(this).parent().parent().siblings("td").eq(1).text();
            var id = $(this).val();
            if(this.checked){
                $("#icd_selected_preg_walkin").append('=> '+icd_description+' '+'<br><input type="hidden" id="icd_preg_walkin" name="icd_ids[]" value="'+id+'">');
            }
            clearOtherDiagnosisPregWalkin();
        });
        console.log(values);
    }

    function othersDiagnosisPregWalkin(){
        $('#icd-modal-preg-walkin').modal('hide');
        $("#others_diagnosis_preg_walkin").html(loading);
        $("#clear_other_diag_pwalkin").show();
        setTimeout(function(){
            $("#others_diagnosis_preg_walkin").html('<span class="text-success">OTHER DIAGNOSIS:</span> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control reason_referral" id="other_preg_walkin" name="other_diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>');
        },500);
    }
</script>