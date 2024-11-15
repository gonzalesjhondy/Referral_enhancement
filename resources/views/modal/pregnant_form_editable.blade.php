<?php

    // $appointmentParam = $_GET['appointment']; // I add this
    $appointmentParam = isset($_GET['appointment']) ? $_GET['appointment'] : session('telemed');
    
    $facility_id_telemed = json_decode(json_decode($appointmentParam, true), true)[0]['facility_id'] ?? json_decode($appointmentParam, true)[0]['facility_id'];
    $telemedicine_appointment_id = json_decode(json_decode($appointmentParam, true),true)[0]['appointmentId'] ?? json_decode($appointmentParam, true)[0]['appointmentId'];
    $telemedicine_doctor_id = json_decode(json_decode($appointmentParam, true),true)[0]['doctorId'] ?? json_decode($appointmentParam, true)[0]['doctorId'];

    $user = Session::get('auth');
    $myfacility = \App\Facility::find($user->facility_id);

    if($facility_id_telemed){
        $facilities = \App\Facility::select('id','name', 'address')
        ->where('id','!=',$user->facility_id)
        ->where('id', $facility_id_telemed) // I am adding this to get the specific facility name
        ->where('status',1)
        ->where('referral_used','yes')
        ->orderBy('name','asc')->get();
    }else{
        $facilities = \App\Facility::select('id','name')
        ->where('id','!=',$user->facility_id)
        ->where('status',1)
        ->where('referral_used','yes')
        ->orderBy('name','asc')->get();
    }   
        
    $reason_for_referral = \App\ReasonForReferral::get();
    $department = \App\Department::all();
    
    $appoitment_sched = \App\AppointmentSchedule::select('id', 'department_id')
                        ->where('id', $telemedicine_appointment_id)->get();

    $department_id = $appoitment_sched[0]->department_id;
    
?>
<div class="modal fade" role="dialog" id="pregnantFormModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" class="form-submit pregnant_form">
            <div class="jim-content">
                @include('include.header_form')
                <div class="form-group-sm form-inline">
                {{ csrf_field() }}
                    <input type="hidden" name="telemedicine" class="telemedicine" value="">
                    <input type="hidden" name="patient_id" class="patient_id" value="" />
                    <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                    <input type="hidden" name="code" value="" />
                    <input type="hidden" name="source" value="{{ $source }}" />
                    <input type="hidden" class="referring_name" value="{{ $myfacility->name }}" /><br>
                    <input type="hidden" name="appointmentId" value="{{ $telemedicine_appointment_id }}" /><!-- I add this changes for passing to the controller -->
                    <input type="hidden" name="doctorId" value="{{ $telemedicine_doctor_id }}" /><!-- I add this changes for passing to the controller -->
                    <div class="row">
                        <div class="col-md-12">
                            <b>REFERRAL RECORD</b>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-2">
                            <span><b>WHO IS REFERRING:</b></span>
                        </div>
                        <div class="col-md-4">
                            <small class="text-success"><b>RECORD NUMBER: </b></small>
                            <input type="text" class="form-control" name="record_no" placeholder="" style="width: 100%"/>
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
                            <br class="mobile-view">
                            Dr. {{ $user->fname }} {{ $user->mname }} {{ $user->lname }}
                        </div><br class="mobile-view">
                        <div class="col-md-4">
                            <small class="text-success"><b>ARRIVAL DATE: </b></small>
                        </div>
                        <div class="col-md-2">
                            <small class="text-success"><b>TIME: </b></small>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-success"><b>REFERRING FACILITY: </b></small>
                            {{ $myfacility->name }}
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
                        <div class="col-md-6">
                            @if($appointmentParam)
                            <input type="hidden" name="referred_facility" value="{{ $facilities->find($facility_id_telemed)->id }}">
                            <select class="form-control-select select2 select_facility" style="width: 100%" required disabled>
                                <option>{{$facilities->find($facility_id_telemed)->name }}</option>                               
                            </select>
                            @else
                            <select name="referred_facility" class="form-control-select select2 select_facility" style="width: 100%" required>
                                <option value="">Select Facility...</option>
                                @foreach($facilities as $row)
                                    <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @endif
                           
                        </div><br class="mobile-view">
                        <div class="col-md-4">
                            @if($appointmentParam)
                            <input type="hidden" name="referred_department" value="{{ $department->find($department_id)->id }}">
                            <select class="form-control-select select_department select_department_pregnant" required disabled>
                                <option>{{$department->find($department_id)->description}}</option>
                            </select>
                            @else
                            <select name="referred_department" class="form-control-select select_department select_department_pregnant" required>
                                <option value="">Select Department...</option>
                            </select>
                            @endif
                            
                    </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-2">
                            <small class="text-success"><b>ADDRESS: </b></small>
                        </div>
                        <div class="col-md-9">
                        @if($appointmentParam)
                        <span class="text-primary facility_address">{{$facilities->find($facility_id_telemed)->address}}</span>
                        @else
                        <span class="text-primary facility_address"></span>
                        @endif
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-success"><b>COVID NUMBER</b></small><br>
                            <input type="text" name="covid_number" style="width: 100%;">
                        </div>
                        <div class="col-md-4">
                            <small class="text-success"><b>CLINICAL STATUS</b></small><br>
                            <select name="clinical_status" class="form-control-select" style="width: 100%;">
                                <option value="">Select option</option>
                                <option value="asymptomatic">Asymptomatic</option>
                                <option value="mild">Mild</option>
                                <option value="moderate">Moderate</option>
                                <option value="severe">Severe</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <small class="text-success"><b>SURVEILLANCE CATEGORY</b></small><br>
                            <select name="sur_category" class="form-control-select" style="width: 100%;">
                                <option value="">Select option</option>
                                <option value="contact_pum">Contact (PUM)</option>
                                <option value="suspect">Suspect</option>
                                <option value="probable">Probable</option>
                                <option value="confirmed">Confirmed</option>
                            </select>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table bg-warning">
                                <tr class="bg-gray">
                                    <th colspan="4">WOMAN</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <small class="text-success"><b>NAME: </b></small>
                                        <span class="text-danger patient_name"></span>
                                    </td>
                                    <td><small class="text-success"><b>AGE: </b></small><span class="text-danger patient_age"></span></td>
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
                                        <small class="text-success"><b>MAJOR FINDINGS:</b> <i> (Clinical and BP,Temp,Lab)</i>
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
                                    <td colspan="4"><small class="text-success"><b>DURING TRANSPORT </b></small>
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
                                    {{--<span class="text-success">--}}
                                        {{--@if(Session::get('auth')->level == 'opcen')--}}
                                            {{--Chief Complaints--}}
                                        {{--@else--}}
                                            {{--Diagnosis/Impression:--}}
                                        {{--@endif--}}
                                    {{--</span> <span class="text-red">*</span>--}}
                                        {{--<br />--}}
                                        {{--<textarea class="form-control" rows="7" name="diagnosis" style="resize: none;width: 100%;margin-top: 1%" required></textarea>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                <tr>
                                     <td colspan="6">
                                        <small class="text-success"><b>DIAGNOSIS: </b></small> <span class="text-red">*</span>
                                        <br><br>
                                        <a data-toggle="modal" data-target="#icd-modal-pregnant" type="button" class="btn btn-sm btn-success" onclick="searchICD10Pregnant()">
                                            <i class="fa fa-medkit"></i>  Add ICD-10
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success" onclick="addNotesDiagnosisPregnant()" hidden="hidden"><i class="fa fa-plus"></i> Add notes in diagnosis</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <button type="button" id="clear_icd_pregnant" class="btn btn-sm btn-danger" onclick="clearICDPregnant()" hidden="hidden"> Clear ICD-10</button>
                                        <div class="text-green" id="icd_selected_pregnant" style="padding-top: 5px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <button type="button" id="clear_notes_pregnant" class="btn btn-sm btn-info" onclick="clearNotesDiagnosisPregnant()" hidden="hidden"> Clear notes diagnosis</button>
                                        <div id="add_notes_diagnosis_pregnant" style="padding-top: 5px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <button type="button" id="clear_other_diag_pregnant" class="btn btn-sm btn-warning" onclick="clearOtherDiagnosisPregnant()" hidden="hidden"> Clear other diagnosis</button>
                                        <div id="others_diagnosis_pregnant" style="padding-top: 5px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <small class="text-success"><b>REASON FOR REFERRAL: </b></small> <span class="text-red">*</span>
                                    <select name="reason_referral1" class="form-control-select select2 reason_referral" style="width: 100%" required>
                                        <option value="">Select reason for referral</option>
                                        <option value="-1">Other reason for referral</option>
                                        @foreach($reason_for_referral as $reason_referral)
                                            <option value="{{ $reason_referral->id }}">{{ $reason_referral->reason }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="other_reason_referral_pregnant"></div>
                                </div>
                            </div>
                        </div>
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
                                    <td colspan="4"><small class="text-success"><b>MAJOR FINDINGS: </b><i>(Clinica and BP,Temp,Lab)</i></small>
                                        <br />
                                        <textarea class="form-control" name="baby_major_findings" style="resize: none;width: 100%" rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>LAST (BREAST) FEED (TIME): </b></small><input type="text" class="form-control form_datetime" style="width: 100%" name="baby_last_feed" placeholder="Date/Time" /><br /></td>
                                </tr>
                                <tr class="bg-gray">
                                    <td colspan="4">Treatments Give Time</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>BEFORE REFERRAL</b></small>
                                        <br />
                                        <input type="text" class="form-control" name="baby_before_treatment" placeholder="Treatment Given" />
                                        <input type="text" class="form-control form_datetime" name="baby_before_given_time" placeholder="Date/Time Given" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>DURING TRANSPORT</b></small>
                                        <br />
                                        <input type="text" class="form-control" name="baby_during_treatment" placeholder="Treatment Given" />
                                        <input type="text" class="form-control form_datetime" name="baby_during_given_time" placeholder="Date/Time Given" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"><small class="text-success"><b>INFORMATION GIVEN TO THE WOMAN AND COMPANION ABOUT THE REASON FOR REFERRAL</b></small>
                                        <br />
                                        <textarea class="form-control" name="baby_information_given" style="resize: none;width: 100%" rows="5"></textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-success"><b>FILE ATTACHMENTS:</b></small> &emsp;
                            <button type="button" class="btn btn-md btn-danger" id="preg_remove_files" onclick="removeFilePregnant()">Remove Files</button><br><br>
                            <div class="pregnant_file_attachment">
                                <div class="col-md-3" id="pregnant_upload1">
                                    <div class="file-upload">
                                        <div class="text-center image-upload-wrap" id="pregnant_image-upload-wrap1">
                                            <input class="file-upload-input" multiple type="file" name="file_upload[]" onchange="readURLPregnant(this, 1);" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>
                                            <img src="{{ asset('resources/img/add_file.png') }}" style="width: 50%; height: 50%;">
                                        </div>
                                        <div class="file-upload-content" id="pregnant_file-upload-content1">
                                            <img class="file-upload-image" id="pregnant_file-upload-image1"/>
                                            <div class="image-title-wrap">
                                                <b><small class="image-title" id="pregnant_image-title1" style="display:block; word-wrap: break-word;">Uploaded File</small></b>
                                                {{--<button type="button" id="pregnant_remove_upload1" onclick="removeUploadPregnant(1)" class="btn-sm remove-image">Remove</button>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped col-sm-6"></table>
                <hr />
                     <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                        <button type="submit" id="sbmtPreg" class="btn btn-success btn-flat btn-submit"><i class="fa fa-send"></i> Submit</button>
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

<div class="modal fade" id="icd-modal-pregnant">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" style="font-size: 17pt;">Search ICD-10 by keyword</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-lg">
                    <input type="text" id="icd10_keyword_pregnant" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" onclick="searchICD10Pregnant()">Find</button>
                    </span>
                </div><br>
                <div class="icd_body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="othersDiagnosisPregnant()"> Other Diagnosis</button>
                <button type="button" class="btn btn-success" onclick="getAllCheckBoxPregnant()"><i class="fa fa-save"></i> Save selected check</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $("#clear_icd_pregnant").hide();
    $("#clear_notes_pregnant").hide();
    $("#clear_other_diag_pregnant").hide();

    $("#sbmtPreg").on('click',function(e){
        if(!($("#icd_preg").val()) && !($("#other_diag_preg").val())){
            Lobibox.alert("error", {
                msg: "Select ICD-10 / Other diagnosis!"
            });
            return false;
        }
    });

    function clearICDPregnant() {
        $("#icd_selected_pregnant").html("");
        $("#clear_icd_pregnant").hide();
    }

    function clearOtherDiagnosisPregnant() {
        $("#others_diagnosis_pregnant").html("");
        $("#clear_other_diag_pregnant").hide();
    }

    function clearNotesDiagnosisPregnant() {
        $("#add_notes_diagnosis_pregnant").html("");
        $("#clear_notes_pregnant").hide();
    }

    function clearOtherReasonReferralPregnant() {
        $("#other_reason_referral_pregnant").html("");
    }

    function addNotesDiagnosisPregnant() {
        $("#add_notes_diagnosis_pregnant").html(loading);
        $("#clear_notes_pregnant").show();
        setTimeout(function(){
            $("#add_notes_diagnosis_pregnant").html('<small class="text-success">ADD NOTES IN DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control add_notes_diagnosis" name="notes_diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>')
        },500);
    }

    $('.reason_referral').on('change', function() {
        var value = $(this).val();
        if(value == '-1') {
            $("#other_reason_referral_pregnant").html(loading);
            setTimeout(function(){
                $("#other_reason_referral_pregnant").html('<small class="text-success">OTHER REASON FOR REFERRAL:</small> <span class="text-red">*</span>\n' +
                    '                                <br />\n' +
                    '                                <textarea class="form-control" name="other_reason_referral" style="resize: none;width: 100%;" rows="7" required></textarea>')
            },500);
            $("#other_reason_referral_pregnant").show();
        }else{
            clearOtherReasonReferralPregnant();
        }
    });

    function searchICD10Pregnant() {
        $(".icd_body").html(loading);
        var url = "<?php echo asset('icd/search'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "icd_keyword" : $("#icd10_keyword_pregnant").val()
        };
        $.post(url,json,function(result){
            setTimeout(function(){
                $(".icd_body").html(result);
            },500);
        });
    }

    var push_notification_diagnosis_ccmc_pregnant = "";
    function getAllCheckBoxPregnant() {
        $('#icd-modal-pregnant').modal('toggle');
        $("#clear_icd_pregnant").show();
        var values = [];

        $('input[name="icd_checkbox[]"]:checked').each(function () {
            values[values.length] = (this.checked ? $(this).parent().parent().siblings("td").eq(1).text() : "");
            var icd_description = $(this).parent().parent().siblings("td").eq(1).text();
            var id = $(this).val();
            if(this.checked){
                $("#icd_selected_pregnant").append('=> '+icd_description+' '+'<br><input id="icd_preg" type="hidden" name="icd_ids[]" value="'+id+'">');
            }
            clearOtherDiagnosisPregnant();
        });
        console.log(values);
        push_notification_diagnosis_ccmc_pregnant = values.join(","); //diagnosis for CCMD for their push notification
    }

    function othersDiagnosisPregnant(){
        $('#icd-modal-pregnant').modal('hide');
        $("#others_diagnosis_pregnant").html(loading);
        $("#clear_other_diag_pregnant").show();
        setTimeout(function(){
            $("#others_diagnosis_pregnant").html('<small class="text-success">OTHER DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control reason_referral" id="other_diag_preg" name="other_diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>')
        },500);
    }
</script>

<script>
    var pregnant_pos = 2;
    var pregnant_count = 0 ;
    function readURLPregnant(input, pos) {
        var word = '{{ asset('resources/img/document_icon.png') }}';
        var pdf = '{{ asset('resources/img/pdf_icon.png') }}';
        var excel = '{{ asset('resources/img/sheet_icon.png') }}';
        if (input.files) {
            var tmp_pos = pos;
            for(var i = 0; i < input.files.length; i++) {
                var file = input.files[i];
                if(file && file !== null) {
                    var reader = new FileReader();
                    var type = file.type;
                    if(type === 'application/pdf') {
                        $('#pregnant_file-upload-image'+pos).attr('src',pdf);
                        pos+=1;
                    } else if(type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        $('#pregnant_file-upload-image'+pos).attr('src',word);
                        pos+=1;
                    } else if(type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        $('#pregnant_file-upload-image'+pos).attr('src',excel);
                        pos+=1;
                    } else {
                        reader.onloadend = function(e) {
                            $('#pregnant_file-upload-image'+pos).attr('src',e.target.result);
                            pos+=1;
                        };
                    }
                    $('#pregnant_image-upload-wrap'+tmp_pos).hide();
                    $('#pregnant_file-upload-content'+tmp_pos).show();
                    $('#pregnant_image-title'+tmp_pos++).html(file.name);
                    reader.readAsDataURL(file);
                    pregnant_count+=1;
                }
                addFilePregnant();
            }
        }
        $('#preg_remove_files').show();
    }
    function addFilePregnant() {
        var add_file_icon = '{{ asset('resources/img/add_file.png') }}';

        if((pregnant_count % 4) == 0) {
            $('.pregnant_file_attachment').append(
                '<div class="clearfix"></div>'
            );
        }
        $('.pregnant_file_attachment').append(
            '<div class="col-md-3" id="pregnant_upload'+pregnant_pos+'">\n' +
            '   <div class="file-upload">\n' +
            '       <div class="text-center image-upload-wrap" id="pregnant_image-upload-wrap'+pregnant_pos+'">\n' +
            '           <input class="file-upload-input" multiple type="file" name="file_upload[]" onchange="readURLPregnant(this, '+pregnant_pos+');" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>\n' +
            '           <img src="'+add_file_icon   +'" style="width: 50%; height: 50%;">\n' +
            '       </div>\n' +
            '       <div class="file-upload-content" id="pregnant_file-upload-content'+pregnant_pos+'">\n' +
            '           <img class="file-upload-image" id="pregnant_file-upload-image'+pregnant_pos+'"/>\n' +
            '           <div class="image-title-wrap">\n' +
            '               <b><small class="image-title" id="pregnant_image-title'+pregnant_pos+'" style="display:block; word-wrap: break-word;">Uploaded File</small></b>\n' +
            '               <button type="button" id="pregnant_remove_upload'+pregnant_pos+'" onclick="removeUploadPregnant('+pregnant_pos+')" class="remove-icon-btn"><i class="fa fa-trash"></i></button>\n' +
            '           </div>\n' +
            '       </div>\n' +
            '   </div>\n' +
            '</div>'
        );
        pregnant_pos+=1;
    }

    function removeFilePregnant() {
        $('.pregnant_file_attachment').html("");
        pregnant_count = 0;
        pregnant_pos = 1;
        $('#preg_remove_files').hide();
        addFilePregnant();
    }

    function removeUploadPregnant(uploadCount){
        $('#pregnant_upload' + uploadCount).remove();

        upload_count -= 1;

        if(pregnant_pos > uploadCount){
            pregnant_pos -= 1;
        }
        if(uploadCount === 0){
            $('#remove_files_btn');
        }

        console.log("upload_pos:", pregnant_pos);

    }

    $(document).ready(function() {
        for (var i = 0; i < pregnant_count; i++) {
            $('#pregnant_image-upload-wrap' + i).bind('dragover', function () {
                $('#pregnant_image-upload-wrap' + i).addClass('image-dropping');
            });
            $('#pregnant_image-upload-wrap' + i).bind('dragleave', function () {
                $('#pregnant_image-upload-wrap' + i).removeClass('image-dropping');
            });
        }
        $('#preg_remove_files').hide();
    });
</script>