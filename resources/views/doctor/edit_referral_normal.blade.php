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

    .remove-icon-btn{
        position: absolute;
        top: -2px; /* Adjust as needed */
        right: 12px; /* Adjust as needed */
        background: transparent;
        border: none;
        font-weight: bold;
        font-size: 24px;
        color: #ff0000; /* Optional: Trash icon color */
        font-size: 18px; /* Optional: Adjust icon size */
        cursor: pointer;
        transition: transform 0.2s;
    }
    .remove-icon-btn:hover {
        transform: scale(1.1); /* Slightly increase size on hover */
    }
    .remove-icon-btn i {
        pointer-events: none; /* To ensure the button handles the click, not the icon */
    }
    
</style>

<form action="{{ url('doctor/referral/edit') }}" method="POST" class="edit_normal_form" enctype="multipart/form-data">
    <div class="jim-content">
        @include('include.header_form', ['optionHeader' => 'edit'])<br>
        <div class="form-group-sm form-inline">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="referral_status" value="{{ $referral_status }}">
            <input type="hidden" name="form_type" value="normal">
            <input type="hidden" name="username" value="{{ $username }}">
            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>NAME OF REFERRING FACILITY: </b></small><span class="referring_name">{{ $form->referring_name }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>FACILITY CONTACT #: </b></small><span class="referring_contact">{{ $form->referring_contact }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>ADDRESS: </b></small><span class="referring_address">{{ $form->referring_address }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-4">
                    <small class="text-success"><b>REFERRED TO: </b></small> &nbsp;<span class="text-red">*</span><br>
                    <input type="hidden" name="old_facility" value="{{ $form->referred_fac_id }}">
                    <select name="referred_to" class="select2 edit_facility_normal form-control" required>
                        <option value="">Select Facility...</option>
                        @foreach($facilities as $row)
                            @if($row->id == $form->referred_fac_id)
                                <option data-name="{{ $row->name }}" value="{{ $row->id }}" selected>{{ $row->name }}</option>
                            @else
                                <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <small class="text-success"><b>DEPARTMENT: </b></small> <span class="text-red">*</span><br>
                    <select name="department_id" class="form-control edit_department_normal" style="width: 100%;" required>
                        <option value="">Select Option</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <small class="text-success"><b>ADDRESS:</b></small><br>
                    &nbsp;<span class="text-yellow edit_fac_address_normal"></span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-7">
                    <small class="text-success"><b>DATE/TIME REFERRED <i>(ReCo)</i>: </b></small><span class="date_referred">{{ $form->date_referred }}</span>
                </div>
                <div class="col-md-5">
                    <small class="text-success"><b>DATE/TIME TRANSFERRED: </b></small><span class="date_transferred"></span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-4">
                    <small class="text-success"><b>NAME OF PATIENT: <br></b></small>
                    &nbsp;<span class="patient_name">{{ $form->patient_name }}</span>
                </div>
                <div class="col-md-2">
                    <small class="text-success"><b>AGE: </b></small><br> &nbsp;
                    <span class="patient_age">
                    @if($age_type == "y")
                            {{ $patient_age }} years
                        @elseif($age_type == "m")
                            {{ $patient_age['month'] }} mos, {{ $patient_age['days'] }} days
                        @endif
                </span>
                </div>
                <div class="col-md-3">
                    <small class="text-success"><b>SEX: </b></small><br>&nbsp;
                    <span class="patient_sex"></span>
                </div>
                <div class="col-md-3">
                    <small class="text-success"><b>STATUS: </b></small><br> &nbsp;
                    <span class="civil_status"></span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>ADDRESS: </b></small>
                    <span class="patient_address">{{ $form->patient_address }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-6">
                    <small class="text-success"><b>PHILHEALTH STATUS: </b></small>
                    <span class="phic_status">{{ $form->phic_status }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-success"><b>PHILHEALTH #: </b></small>
                    <span class="phic_id">{{ $form->phic_id }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-4">
                    <small class="text-success"><b>COVID NUMBER</b></small><br>
                    <input type="text" class="form-control covid_number" name="covid_number" style="width: 100%;">
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
                <div class="col-md-12">
                    <small class="text-success"><b>CASE SUMMARY:</b> <i>(pertinent Hx/PE, including meds, labs, course etc.)</i></small> <span class="text-red">*</span><br />
                    <textarea class="form-control case_summary" name="case_summary" style="resize: none;width: 100%;" rows="7" required>{{ $form->case_summary }}</textarea>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>SUMMARY OF RECO:</b> <i>(pls. refer to ReCo Guide in Referring Patients Checklist)</i></small> <span class="text-red">*</span><br />
                    <textarea class="form-control reco_summary" name="reco_summary" style="resize: none;width: 100%;" rows="7" required>{{ $form->reco_summary }}</textarea>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>DIAGNOSIS</b></small> <span class="text-red">*</span>
                    <small><b><input id="diag_prompt" style="text-align: center; color: red; border-color: transparent; width:30%;" value="SELECT ICD-10 / OTHER DIAGNOSIS" readonly></b></small><br><br>
                    <a data-toggle="modal" data-target="#icd-modal" type="button" class="btn btn-sm btn-success" onclick="searchICD10()">
                        <i class="fa fa-medkit"></i> Add ICD-10
                    </a>
                    <button type="button" class="btn btn-sm btn-success add_notes_btn" onclick="addNotesDiagnosis()"><i class="fa fa-plus"></i> Add notes in diagnosis</button>
                </div>
            </div><br>

            <div class="row icd_selected" style="padding-top: 10px;">
                <div class="col-md-12">
                    <small class="text-success"><b>ICD-10 Code and Description: </b></small>&emsp;
                    <button type="button" class="btn btn-xs btn-danger" onclick="clearIcdNormal()">Clear ICD 10</button><br>
                    <input type="hidden" id="icd_cleared" name="icd_cleared" value="">
                    <div id="icd_selected" style="padding-top: 5px">
                        @if(isset($icd))
                            @foreach($icd as $i)
                                <span> => {{ $i->description }}</span><br>
                                <input type="hidden" id="icd_ids" name="icd_ids[]" value="{{ $i->id }}">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><br>

            <div class="row notes_diagnosis" style="padding-top: 10px;">
                <div class="col-md-12">
                    <small class="text-success"><b>Notes in Diagnosis: </b></small>&emsp;
                    <input type="hidden" name="notes_diag_cleared" id="notes_diag_cleared" value="">
                    <button type="button" class="btn btn-xs btn-info" onclick="clearNotesDiagnosis()"> Clear notes diagnosis</button>
                    <textarea class="form-control normal_notes_diagnosis" name="diagnosis" style="resize: none;width: 100%;" rows="5">{{ $form->diagnosis }}</textarea>
                </div>
            </div><br>

            <div class="row other_diag" style="padding-top: 10px">
                <div class="col-md-12">
                    <small class="text-success"><b>Other Diagnosis: </b></small>&emsp;
                    <input type="hidden" name="other_diag_cleared" class="other_diag_cleared" value="">
                    <button type="button" class="btn btn-xs btn-warning" onclick="clearOtherDiagnosis(true)"> Clear other diagnosis</button>
                    <textarea class="form-control" id="other_diagnosis" name="other_diagnoses" style="resize: none;width: 100%;" rows="5">{{ $form->other_diagnoses }}</textarea>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>REASON FOR REFERRAL: </b></small> <span class="text-red">*</span><br>
                    <select name="reason_referral" class="form-control-select select2 reason_referral" style="width: 100%" required="">
                        <option value="">Select reason for referral</option>
                        <option value="-1">Other reason for referral</option>
                        @foreach($reason_for_referral as $reason_referral)
                            <option value="{{ $reason_referral->id }}">{{ $reason_referral->reason }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12" id="other_reason_referral">
                </div>
            </div><br>

            <div class="row with_file_attached hide">
                <div class="col-md-12">
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
                    {{--<a href="{{ asset($file_path) }}" class="reason" style="font-size: 12pt;" download>{{ $file_name }}</a>--}}
                </div>
            </div><br>

            <div class="row no_file_attached hide">
                <div class="col-md-12">
                    <small class="text-success"><b>FILE ATTACHMENTS:</b></small> &emsp;
                    <button type="button" class="btn btn-md btn-danger" id="remove_files_btn" onclick="removeFiles()">Remove Files</button><br><br>
                    <div class="attachment">
                        <div class="col-md-3" id="upload1">
                            <div class="file-upload">
                                <div class="text-center image-upload-wrap" id="image-upload-wrap1">
                                    <input class="file-upload-input files" multiple id="file_upload_input1" type='file' name="file_upload[]" onchange="readUrl(this, 1);" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>
                                    <img src="{{ asset('resources/img/add_file.png') }}" style="width: 50%; height: 50%;">
                                </div>
                                <div class="file-upload-content" id="file-upload-content1">
                                    <img class="file-upload-image" id="file-upload-image1" src="#"/>
                                    <div class="image-title-wrap">
                                        <b><small class="image-title" id="image-title1" style="display:block; word-wrap: break-word;"></small></b>
                                        {{--<button type="button" onclick="removeFile(1)" class="remove-image"> Remove </button>--}}
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
                            {{--<div class="file-upload-content">--}}
                                {{--<img class="file-upload-image" src="#" alt="your image" />--}}
                                {{--<div class="image-title-wrap">--}}
                                  {{--<button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>--}}
                               {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>NAME OF REFERRING MD/HCW: </b></small>
                    <span class="referring_md">{{ $form->md_referring }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>CONTACT # OF REFERRING MD/HCW: </b></small>
                    <span class="referring_md_contact">{{ $form->referring_md_contact }}</span>
                </div>
            </div><br>

            <div class="row">
                <div class="col-md-12">
                    <small class="text-success"><b>NAME OF DOCTOR (REFERRED HOSPITAL):</b> <i>(MD/HCW- Mobile Contact # (ReCo))</i></small><br>
                    <select name="referred_md" class="form-control edit_action_md" style="width: 100%;">
                        <option value="">Any</option>
                    </select>
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
@include('script.edit_referred')