<?php
$user = Session::get('auth');
$reason_for_referral = \App\ReasonForReferral::get();
$facilities = \App\Facility::select('id','name')
    ->where('id','!=',$user->facility_id)
    ->where('status',1)
    ->where('referral_used','yes')
    ->orderBy('name','asc')->get();
?>

<style>
    .file-upload {
        background-color: #ffffff;
        width: 100%;
        height: 35%;
        margin: 0 auto;
        padding: 20px;
        border: 1px dashed dimgrey;
    }
    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }
    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }
    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }
    .file-upload-content {
        display: none;
        text-align: center;
    }
    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }
    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }
    .image-dropping,
    .image-upload-wrap:hover {
        background-color: /*#6ab155*/#1FB264;
        border: 4px dashed #ffffff;
    }
    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }
    .drag-text {
        text-align: center;
    }
    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }
    .file-upload-image {
        max-height: 75%;
        max-width: 75%;
        margin: auto;
        padding: 20px;
    }
    .remove-image {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 600;
    }
    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }
    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }
    @media only screen and (max-width: 720px) {
        .file-upload {
            background-color: #ffffff;
            width: 50%;
        }
        .file-upload-image {
            max-height: 50%;
            max-width: 50%;
        }
    }
</style>

<form action="{{ url('doctor/referral/edit') }}" method="POST" class="edit_normal_form" enctype="multipart/form-data">
    <div class="jim-content">
        @include('include.header_form')<br>
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="referral_status" value="{{ $referral_status }}">
        <input type="hidden" name="form_type" value="pregnant">
        <input type="hidden" name="baby_id" value="{{ $form['baby']->baby_id }}">
        <input type="hidden" name="mother_id" value="{{ $form['pregnant']->mother_id }}">
        <input type="hidden" name="username" value="{{ $username }}">

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
                <span class="record_number">{{ $data['pregnant']->record_no }}</span>
            </div>
            <div class="col-md-4">
                <small class="text-success"><b>REFERRED DATE: </b></small>
                <span class="referred_date">{{ $data['pregnant']->referred_date }}</span>
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-6">
                <small class="text-success"><b>REFERRING NAME: </b></small>
                <br class="mobile-view">{{ $form['pregnant']->md_referring }}
            </div><br class="mobile-view">
            <div class="col-md-4">
                <small class="text-success"><b>ARRIVAL DATE: </b></small>
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-12">
                <small class="text-success"><b>CONTACT # OF REFERRING MD/HCW: </b></small>
                <span class="referring_md_contact">{{ $form['pregnant']->referring_md_contact }}</span>
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-12">
                <small class="text-success"><b>REFERRING FACILITY: </b></small>
                <span class="referring_facility">{{ $form['pregnant']->referring_facility }}</span>
            </div><br class="mobile-view">
        </div><br>

        <div class="row">
            <div class="col-md-12">
                <small class="text-success"><b>FACILITY CONTACT #: </b></small>
                <span class="referring_contact">{{ $form['pregnant']->referring_contact }}</span>
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-12">
                <small class="text-success"><b>ACCOMPANIED BY THE HEALTH WORKER: </b></small>
                <span class="health_worker">{{ $form['pregnant']->health_worker }}</span>
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-6">
                <small class="text-success"><b>REFERRED TO: </b></small><br>
                <input type="hidden" name="old_facility" value="{{ $form['pregnant']->referred_facility_id }}">
                <select name="referred_to" class="select2 edit_facility_pregnant form-control" required>
                    <option value="">Select Facility...</option>
                    @foreach($facilities as $row)
                        <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
                {{--<span class="referred_name">{{ $form['pregnant']->referred_facility }}</span>--}}
            </div>
            <div class="col-md-4">
                <small class="text-success"><b>DEPARTMENT: </b></small><br>&emsp;
                <select name="department_id" class="form-control-select edit_department_pregnant" required>
                    <option value="">Select Department...</option>
                </select>
                {{--<span class="department_name">{{ $form['pregnant']->department }}</span>--}}
            </div>
        </div><br>

        <div class="row">
            <div class="col-md-4">
                <small class="text-success"><b>COVID NUMBER</b></small><br>
                <input class="covid_number" type="text" name="covid_number" style="width: 100%;" >
            </div>
            <div class="col-md-4">
                <small class="text-success"><b>CLINICAL STATUS</b></small><br>
                <select name="refer_clinical_status" id="" class="form-control-select clinical_status" style="width: 100%;">
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
                <select name="refer_sur_category" id="" class="form-control-select surve_category" style="width: 100%;">
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
                            <span class="woman_name"> {{ $form['pregnant']->woman_name }}</span>
                        </td>
                        <td>
                            <small class="text-success"><b>AGE: </b></small>
                            <span class="patient_age">{{ $form['pregnant']->woman_age }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>ADDRESS: </b></small>
                            <span class="woman_address">{{ $form['pregnant']->patient_address }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>MAIN REASON FOR REFERRAL: </b></small>
                            <label><input <?php if($form['pregnant']->woman_reason=='None') echo 'checked'; ?> type="radio" name="woman_reason" value="None" checked /> None </label>
                            <label><input <?php if($form['pregnant']->woman_reason=='Emergency') echo 'checked'; ?> type="radio" name="woman_reason" value="Emergency" /> Emergency </label>
                            <label><input <?php if($form['pregnant']->woman_reason=='Non-Emergency') echo 'checked'; ?> type="radio" name="woman_reason" value="Non-Emergency" /> Non-Emergency </label>
                            <label><input <?php if($form['pregnant']->woman_reason=='To accompany the baby') echo 'checked'; ?> type="radio" name="woman_reason" value="To accompany the baby" /> To accompany the baby </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>MAJOR FINDINGS: </b><i> (Clinical and BP,Temp,Lab)</i></small>
                            <textarea class="form-control woman_major_findings" name="woman_major_findings" style="resize: none;width: 100%" rows="5" required>{{ $form['pregnant']->woman_major_findings }}</textarea>
                        </td>
                    </tr>
                    <tr class="bg-gray">
                        <td colspan="4">Treatments Give Time</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>BEFORE REFERRAL</b></small><br/>
                            <input type="text" class="form-control woman_before_treatment" name="woman_before_treatment" placeholder="Treatment Given" />
                            <input type="text" class="form-control form_datetime woman_before_given_time" name="woman_before_given_time" placeholder="Date/Time Given" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>DURING TRANSPORT </b></small><br/>
                            <input type="text" class="form-control woman_during_transport" name="woman_during_transport" placeholder="Treatment Given" />
                            <input type="text" class="form-control form_datetime woman_transport_given_time" name="woman_transport_given_time" placeholder="Date/Time Given" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>INFORMATION GIVEN TO THE WOMAN AND COMPANION ABOUT THE REASON FOR REFERRAL</b></small><br/>
                            <textarea class="form-control woman_information_given" name="woman_information_given" style="resize: none;" rows="5" required>{{ $form['pregnant']->woman_information_given }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>DIAGNOSIS: </b></small><span class="text-red">*</span>
                            <small><b><input id="diag_prompt" style="text-align: center; color: red; border-color: transparent; width:70%;" value="SELECT ICD-10 / OTHER DIAGNOSIS" readonly></b></small><br><br>
                            <a data-toggle="modal" data-target="#icd-modal" type="button" class="btn btn-sm btn-success" onclick="searchICD10()">
                                <i class="fa fa-medkit"></i> Add ICD-10
                            </a>
                            <button type="button" class="btn btn-sm btn-success add_notes_btn" onclick="addNotesDiagnosis()"><i class="fa fa-plus"></i> Add notes in diagnosis</button>
                        </td>
                    </tr>
                    <tr class="icd_selected" style="padding-top: 10px;">
                        <td colspan="4">
                            <small class="text-success"><b>ICD-10 Code and Description: </b></small>&emsp;
                            <button type="button" class="btn btn-xs btn-danger" onclick="clearIcdNormal()">Clear ICD 10</button><br>
                            <input type="hidden" id="icd_cleared" name="icd_cleared" value="">
                            <div id="icd_selected" style="padding-top: 5px">
                                @if(isset($icd))
                                    @foreach($icd as $i)
                                        <input type="hidden" id="icd_ids" name="icd_ids[]" value="{{ $i->id }}">
                                        <small> => {{ $i->description }}</small><br>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr class="notes_diag">
                        <td colspan="4">
                            <small class="text-success"><b>Notes in Diagnosis: </b></small>&emsp;
                            <input type="hidden" name="notes_diag_cleared" id="notes_diag_cleared" value="">
                            <button type="button" class="btn btn-xs btn-info" onclick="clearNotesDiagnosisPregnant()">Clear Notes Diagnosis</button>
                            <textarea class="form-control notes_diagnosis" name="notes_diagnoses" style="resize: none;" rows="5">{{ $form['pregnant']->notes_diagnoses }}</textarea>
                        </td>
                    </tr>
                    <tr class="other_diag">
                        <td colspan="4">
                            <small class="text-success"><b>Other Diagnosis: </b></small>&emsp;
                            <input type="hidden" name="other_diag_cleared" class="other_diag_cleared" value="">
                            <button type="button" class="btn btn-xs btn-warning" onclick="clearOtherDiagnosisPregnant()">Clear other diagnosis</button>
                            <textarea class="form-control other_diagnosis" name="other_diagnoses" style="resize: none;" rows="5">{{ $form['pregnant']->other_diagnoses }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>REASON FOR REFERRAL: </b></small><span class="text-red">*</span>
                            <select name="reason_referral" class="form-control-select select2 reason_referral" required="">
                                <option value="">Select reason for referral</option>
                                <option value="-1">Other reason for referral</option>
                                @foreach($reason_for_referral as $reason_referral)
                                    <option value="{{ $reason_referral->id }}">{{ $reason_referral->reason }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" id="other_reason_referral">
                        </td>
                    </tr>

                </table>
            </div>
            <div class="col-sm-6">
                <table class="table bg-warning">
                    <tr class="bg-gray">
                        <th colspan="4">BABY</th>
                    </tr>
                    <tr>
                        <td colspan="2"><small class="text-success"><b>NAME: </b></small><br />
                            <input type="text" class="form-control baby_fname" style="width: 100%" name="baby_fname" placeholder="First Name" /><br />
                            <input type="text" class="form-control baby_mname" style="width: 100%" name="baby_mname" placeholder="Middle Name" /><br />
                            <input type="text" class="form-control baby_lname" style="width: 100%" name="baby_lname" placeholder="Last Name" />
                        </td>
                        <td style="vertical-align: top !important;"><small class="text-success"><b>DATE AND HOUR OF BIRTH: </b></small>
                            <br />
                            <input type="text" class="form-control form_datetime baby_dob" style="width: 100%" name="baby_dob" placeholder="Date/Time"/><br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><small class="text-success"><b>BIRTH WEIGHT: </b></small> <input type="text" class="form-control baby_weight" style="width: 100%" name="baby_weight" placeholder="kg or lbs"/><br /></td>
                        <td><small class="text-success"><b>GESTATIONAL AGE: </b></small> <input type="text" class="form-control baby_gestational_age" style="width: 100%" name="baby_gestational_age" placeholder="age" /><br /></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>MAIN REASON FOR REFERRAL: </b></small>
                            <label><input <?php if($form['baby']->baby_reason=='None') echo 'checked';?> type="radio" name="baby_reason" value="None"> None </label>
                            <label><input <?php if($form['baby']->baby_reason=='Emergency') echo 'checked';?> type="radio" name="baby_reason" value="Emergency"> Emergency </label>
                            <label><input <?php if($form['baby']->baby_reason=='Non-Emergency') echo 'checked';?> type="radio" name="baby_reason" value="Non-Emergency"> Non-Emergency </label>
                            <label><input <?php if($form['baby']->baby_reason=='To accompany the mother') echo 'checked';?> type="radio" name="baby_reason" value="To accompany the mother"> To accompany the mother </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>MAJOR FINDINGS: </b><i> (Clinics and BP,Temp,Lab) </i></small><br/>
                            <textarea class="form-control baby_major_findings" name="baby_major_findings" style="resize: none;width: 100%" rows="5">{{ $form['baby']->baby_major_findings }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><small class="text-success"><b>LAST (BREAST) FEED (TIME): </b></small><input type="text" class="form-control form_datetime baby_last_feed" style="width: 100%" name="baby_last_feed" placeholder="Date/Time" /><br /></td>
                    </tr>
                    <tr class="bg-gray">
                        <td colspan="4">Treatments Give Time</td>
                    </tr>
                    <tr>
                        <td colspan="4"><small class="text-success"><b>BEFORE REFERRAL</b></small>
                            <br />
                            <input type="text" class="form-control baby_before_treatment" name="baby_before_treatment" placeholder="Treatment Given" />
                            <input type="text" class="form-control form_datetime baby_before_given_time" name="baby_before_given_time" placeholder="Date/Time Given" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"><small class="text-success"><b>DURING TRANSPORT</b></small>
                            <br />
                            <input type="text" class="form-control baby_during_transport" name="baby_during_transport" placeholder="Treatment Given" />
                            <input type="text" class="form-control form_datetime baby_transport_given_time" name="baby_transport_given_time" placeholder="Date/Time Given" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <small class="text-success"><b>INFORMATION GIVEN TO THE WOMAN AND COMPANION ABOUT THE REASON FOR REFERRAL</b></small>
                            <br />
                            <textarea class="form-control baby_information_given" name="baby_information_given" style="resize: none;width: 100%" rows="5">{{ $form['baby']->baby_information_given }}</textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="with_file_attached hide">
                    <small class="text-success"><b>
                            @if(count($file_path) > 1) FILE ATTACHMENTS: @else FILE ATTACHMENT: @endif
                        </b></small>
                    <input type="hidden" name="file_cleared" id="file_cleared" value="">
                    <button type="button" class="btn btn-xs btn-warning" onclick="clearFileUpload()"> Remove File Attachment</button><br/><br/>
                    @for($i = 0; $i < count($file_path); $i++)
                        <a href="{{ $file_path[$i] }}" id="file_download" class="reason" target="_blank" style="font-size: 12pt;" download>{{ $file_name[$i] }}</a>
                        @if($i + 1 != count($file_path))
                            ,&nbsp;&nbsp;
                        @endif
                    @endfor
    {{--                <a href="{{ asset($file_path) }}" class="reason" style="font-size: 12pt;" download>{{ $file_name }}</a>--}}
                </div>
                <div class="no_file_attached hide">
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
                    {{--<div class="file-upload">--}}
                        {{--<div class="image-upload-wrap">--}}
                            {{--<input class="file-upload-input" type='file' name="file_upload" onchange="readURL(this);" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>--}}
                            {{--<div class="drag-text">--}}
                                {{--<h3>Drag and drop a file or select add Image</h3>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="file-upload-content">--}}
                            {{--<img class="file-upload-image" src="#" alt="your image" />--}}
                            {{--<div class="image-title-wrap">--}}
                                {{--<button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        <hr />

        <button class="btn btn-default btn-flat exit_edit_btn" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        <div class="form-fotter pull-right">
            <button type="submit" class="btn btn-success btn-flat btn-submit" id="edit_save_btn"><i class="fa fa-send"></i> Save </button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

@include('script.datetime')
@include('script.edit_referred_pregnant')
