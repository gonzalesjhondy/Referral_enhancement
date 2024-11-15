<?php
// $appointmentParam = $_GET['appointment'];
$telemed = session('telemed');

$appointmentParam = isset($_GET['appointment']) ? $_GET['appointment'] : $telemed;

$facility_id_telemedicine = json_decode(json_decode($appointmentParam, true), true)[0]['facility_id'] ?? json_decode($appointmentParam, true)[0]['facility_id'];
$telemedicine_appointment_id = json_decode(json_decode($appointmentParam, true), true)[0]['appointmentId'] ?? json_decode($appointmentParam, true)[0]['appointmentId'];
$telemedicine_doctor_id = json_decode(json_decode($appointmentParam, true), true)[0]['doctorId'] ?? json_decode($appointmentParam, true)[0]['doctorId'];

$user = Session::get('auth');
$facilities = \App\Facility::select('id', 'name', 'address')
    ->where('id', '!=', $user->facility_id)
    ->where('status', 1)
    ->where('referral_used', 'yes');
if ($facility_id_telemedicine) {
    $facilities = $facilities->where('id', $facility_id_telemedicine);
}

$facilities = $facilities
    ->orderBy('name', 'asc')
    ->get();

$myfacility = \App\Facility::find($user->facility_id);
$facility_address = \App\Http\Controllers\LocationCtrl::facilityAddress($myfacility->id);
$inventory = \App\Inventory::where("facility_id", $myfacility->id)->get();
$reason_for_referral = \App\ReasonForReferral::get();
$department = \App\Department::all();

$doctor = \App\User::select('id', 'fname', 'mname', 'lname', 'contact')->get();

$appoitment_sched = \App\AppointmentSchedule::select('id', 'department_id')
    ->where('id', $telemedicine_appointment_id)->get();

$department_id = $appoitment_sched[0]->department_id;

?>

<style>
    .small-box {
        width: 100px;
        height: 100px;
        border-width: 2px;
        border-color: darkgray;
    }

    @media only screen and (max-width: 768px) {
        embed {
            height: 60vh; /* Adjust for smaller screens */
        }
    }

    @media only screen and (max-width: 480px) {
        embed {
            height: 50vh; /* Further reduce height for extra small screens */
        }
    }
</style>

<div class="modal fade" role="dialog" id="normalFormModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('doctor/patient') }}" method="POST" class="form-submit normal_form">
                <div class="jim-content">
                    @include('include.header_form')
                    <div class="form-group-sm form-inline">
                        {{ csrf_field() }}
                        <input type="hidden" name="telemedicine" class="telemedicine" value="">
                        <input type="hidden" name="patient_id" class="patient_id" value="" />
                        <input type="hidden" name="date_referred" class="date_referred" value="{{ date('Y-m-d H:i:s') }}" />
                        <input type="hidden" name="code" value="" />
                        <input type="hidden" name="source" value="{{ $source }}" />
                        <input type="hidden" class="referring_name" value="{{ $myfacility->name }}" />
                        <input type="hidden" name="appointmentId" value="{{ $telemedicine_appointment_id }}" />
                        <input type="hidden" name="doctorId" value="{{ $telemedicine_doctor_id }}" />
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-success"><b>NAME OF REFERRING FACILITY:</b></small><br>
                                &nbsp;<span>{{ $myfacility->name }}</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>ADDRESS:</b></small><br>
                                &nbsp;<span>{{ $facility_address['address'] }}</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>NAME OF REFERRING MD/HCW:</b></small><br>
                                &nbsp;<span>Dr. {{ $user->fname }} {{ $user->mname }} {{ $user->lname }}</span>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-success"><b>DATE/TIME REFERRED (ReCo):</b></small><br>
                                &nbsp;<span>{{ date('l F d, Y h:i A') }}</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>NAME OF PATIENT:</b></small><br>
                                &nbsp;<span class="patient_name"></span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>ADDRESS:</b></small><br>
                                &nbsp;<span class="patient_address"></span>
                            </div>
                        </div><br>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-success"><b>REFERRED TO:</b></small> &nbsp;<span class="text-red">*</span><br>
                                @if($appointmentParam)
                                <input type="hidden" name="referred_facility" value="{{$facilities->find($facility_id_telemedicine)->id}}">
                                <select class="select2 select_facility form-control" disabled>
                                    <option>{{$facilities->find($facility_id_telemedicine)->name}}</option>
                                </select>
                                @else
                                <select name="referred_facility" class="select2 select_facility form-control" required>
                                    <option value="">Select Facility...</option>
                                    @foreach($facilities as $row)
                                    <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @endif

                                {{-- <select name="referred_facility" class="select2 select_facility form-control" required>
                                    <option value="">Select Facility...</option>
                                    @foreach($facilities as $row)
                                        <option data-name="{{ $row->name }}" value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                                </select> --}}
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>DEPARTMENT:</b></small> <span class="text-red">*</span><br>
                                @if($appointmentParam)
                                <input type="hidden" name="referred_department" value="{{$department->find($department_id)->id}}">
                                <select class="form-control select_department select_department_normal" style="width: 100%;" disabled>
                                    <option>{{$department->find($department_id)->description}}</option>
                                </select>
                                @else
                                <select name="referred_department" class="form-control select_department select_department_normal" style="width: 100%;" required>
                                    <option value="">Select Department...</option>
                                </select>
                                @endif
                                <!-- <select name="referred_department" class="form-control select_department select_department_normal" style="width: 100%;" required>
                                    <option value="">Select Department...</option>
                                </select> -->
                            </div>
                            <div class="col-md-4">
                                <small class="text-success"><b>ADDRESS:</b></small><br>

                                @if($appointmentParam)
                                &nbsp;<span class="text-yellow facility_address">{{$facilities->find($facility_id_telemedicine)->address}}</span>
                                @else
                                &nbsp;<span class="text-yellow facility_address"></span>
                                @endif
                            </div>
                        </div><br>

                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <small class="text-success"><b>AGE: </b></small><br>
                                    &nbsp;<span class="patient_age"></span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-success"><b>SEX: </b></small> <span class="text-red">*</span><br>
                                    <select name="patient_sex" class="patient_sex form-control" style="width: 100%;" required>
                                        <option value="">Select...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-success"><b>CIVIL STATUS: </b></small> <span class="text-red">*</span><br>
                                    <select name="civil_status" style="width: 100%;" id="civil_status_web" class="civil_status form-control" required>
                                        <option value="">Select...</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-success"><b>COVID NUMBER</b></small><br>
                                <input type="text" class="form-control" name="covid_number" style="width: 100%;">
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
                            <div class="col-md-12">
                                <small class="text-success"><b>CASE SUMMARY:</b> <i>(pertinent Hx/PE, including meds, labs, course etc.)</i></small> <span class="text-red">*</span><br />
                                <textarea class="form-control" name="case_summary" style="resize: none;width: 100%;" rows="7" required></textarea>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>SUMMARY OF RECO:</b> <i>(pls. refer to ReCo Guide in Referring Patients Checklist)</i></small> <span class="text-red">*</span><br />
                                <textarea class="form-control" name="reco_summary" style="resize: none;width: 100%;" rows="7" required></textarea>
                            </div>
                        </div><br>


                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>DIAGNOSIS</b></small> <span class="text-red">*</span>
                                <br><br>
                                <a data-toggle="modal" data-target="#icd-modal" type="button" class="btn btn-sm btn-success" onclick="searchICD10()">
                                    <i class="fa fa-medkit"></i> Add ICD-10
                                </a>
                                <button type="button" class="btn btn-sm btn-success" onclick="addNotesDiagnosis()"><i class="fa fa-plus"></i> Add notes in diagnosis</button>
                            </div>
                        </div>


                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <button type="button" id="clear_icd" class="btn btn-xs btn-danger" onclick="clearICD()"> Clear ICD-10</button><br>
                                <div class="text-success" id="icd_selected" style="padding-top: 5px"></div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-12">
                                <button type="button" id="clear_notes" class="btn btn-xs btn-info" onclick="clearNotesDiagnosis()"> Clear notes diagnosis</button>
                                <div id="add_notes_diagnosis" style="padding-top: 5px"></div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px">
                            <div class="col-md-12">
                                <button type="button" id="clear_other_diag" class="btn btn-xs btn-warning" onclick="clearOtherDiagnosis()"> Clear other diagnosis</button>
                                <div id="others_diagnosis" style="padding-top: 5px"></div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>REASON FOR REFERRAL:</b></small> <span class="text-red">*</span><br>
                                <select name="reason_referral1" class="form-control-select select2 reason_referral" style="width: 100%" required>
                                    <option value="">Select reason for referral</option>
                                    <option value="-1">Other reason for referral</option>
                                    @foreach($reason_for_referral as $reason_referral)
                                    <option value="{{ $reason_referral->id }}">{{ $reason_referral->reason }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 10px">
                            <div class="col-md-12">
                                <div id="other_reason_referral"></div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>NAME OF REFERRED:</b> <i>(MD/HCW- Mobile Contact # (ReCo))</i></small><br>
                                @if($appointmentParam)
                                <input type="hidden" name="reffered_md_telemed" value="{{$doctor->find($telemedicine_doctor_id)->id}}">
                                <select class="referred_md form-control-select select2" style="width: 100%" disabled>
                                    <option value="{{$doctor->find($telemedicine_doctor_id)->id}}">Doctor {{ $doctor->find($telemedicine_doctor_id)->fname}} {{$doctor->find($telemedicine_doctor_id)->mname}} {{$doctor->find($telemedicine_doctor_id)->lname}} - {{$doctor->find($telemedicine_doctor_id)->contact}}</option>
                                </select>
                                @else
                                <select name="reffered_md" class="referred_md form-control-select select2" style="width: 100%">
                                    <option value="">Any...</option>
                                </select>
                                @endif

                            </div>
                        </div><br>

                        <!-- <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>NAME OF REFERRED:</b> <i>(MD/HCW- Mobile Contact # (ReCo))</i></small><br>
                                <select name="reffered_md" class="referred_md form-control-select select2" style="width: 100%">
                                    <option value="">Any...</option>
                                </select>
                            </div>
                        </div><br> -->

                        <div class="row">
                            <div class="col-md-12">
                                <small class="text-success"><b>FILE ATTACHMENTS:</b></small> &emsp;
                                <button type="button" class="btn btn-md btn-danger" id="remove_files_btn" onclick="removeFiles()">Remove Files</button>
                                <br><br>
                                <div class="attachment">
                                    <div class="col-md-3" id="upload1">
                                        <div class="file-upload">
                                            <div class="text-center image-upload-wrap" id="image-upload-wrap1">
                                                <input class="file-upload-input files" multiple id="file_upload_input1" type='file' name="file_upload[]" onchange="readUrl(this, 1);" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf" />
                                                <img src="{{ asset('resources/img/add_file.png') }}" style="width: 50%; height: 50%;">
                                            </div>
                                            <div class="file-upload-content" id="file-upload-content1">
                                                <img class="file-upload-image" id="file-upload-image1" src="#" />
                                                <div class="image-title-wrap">
                                                    <b><small class="image-title" id="image-title1" style="display:block; word-wrap: break-word;"></small></b>
                                                    {{--<button type="button" onclick="removeFile(1)" class="remove-image"> Remove </button>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Back</button>
                        <button type="submit" id="sbmitBtn" class="btn btn-success btn-flat btn-submit"><i class="fa fa-send"></i> Submit</button>
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

<div class="modal fade" id="icd-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" style="font-size: 17pt;">Search ICD-10 by keyword</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-lg">
                    <input type="text" id="icd10_keyword" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" onclick="searchICD10()">Find</button>
                    </span>
                </div><br>
                <div class="icd_body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="othersDiagnosis()"> Other Diagnosis</button>
                <button type="button" class="btn btn-success" onclick="getAllCheckBox()"><i class="fa fa-save"></i> Save selected check</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    $('#clear_icd, #clear_notes, #clear_other_diag, #icd_selected').hide();
    $("#sbmitBtn").on('click', function(e) {
        if (!($("#icd").val()) && !($("#other_diag").val())) {
            Lobibox.alert("error", {
                msg: "Select ICD-10 / Other diagnosis!"
            });
            return false;
        }
    });

    function clearICD() {
        $("#icd_selected").html("");
        $("#clear_icd, #icd_selected").hide();
    }

    function clearOtherDiagnosis() {
        $("#others_diagnosis").html("");
        $("#clear_other_diag").hide();
    }

    function clearNotesDiagnosis() {
        $("#add_notes_diagnosis").html("");
        $("#clear_notes").hide();
    }

    function clearOtherReasonReferral() {
        $("#other_reason_referral").html("");
    }

    function addNotesDiagnosis() {
        $("#add_notes_diagnosis").html(loading);
        $("#clear_notes").show();
        setTimeout(function() {
            $("#add_notes_diagnosis").html('<small class="text-success">ADD NOTES IN DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea class="form-control add_notes_diagnosis" name="diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>')
        }, 500);
    }
    $('.reason_referral').on('change', function() {
        var value = $(this).val();
        if (value == '-1') {
            $("#other_reason_referral").html(loading);
            setTimeout(function() {
                $("#other_reason_referral").html('<small class="text-success">OTHER REASON FOR REFERRAL:</small> <span class="text-red">*</span>\n' +
                    '                                <br />\n' +
                    '                                <textarea class="form-control" name="other_reason_referral" style="resize: none;width: 100%;" rows="7" required></textarea>')
            }, 500);
            $("#other_reason_referral").show();
        } else {
            clearOtherReasonReferral();
        }
    });


    function searchICD10() {
        $(".icd_body").html(loading);
        var url = "<?php echo asset('icd/search'); ?>";
        var json = {
            "_token": "<?php echo csrf_token(); ?>",
            "icd_keyword": $("#icd10_keyword").val()
        };
        $.post(url, json, function(result) {
            setTimeout(function() {
                $(".icd_body").html(result);
            }, 500);
        });
    }

    var push_notification_diagnosis_ccmc = "";

    function getAllCheckBox() {
        $('#icd-modal').modal('toggle');
        $('#clear_icd, #icd_selected').show();
        var values = [];
        $('input[name="icd_checkbox[]"]:checked').each(function() {
            values[values.length] = (this.checked ? $(this).parent().parent().siblings("td").eq(1).text() : "");
            var icd_description = $(this).parent().parent().siblings("td").eq(1).text();
            var id = $(this).val();
            if (this.checked) {
                $("#icd_selected").append('=> ' + icd_description + ' ' + '<br><input id="icd" type="hidden" name="icd_ids[]" value="' + id + '">');
                console.log("icd id: " + id);
            }
            clearOtherDiagnosis();
        });

        push_notification_diagnosis_ccmc = values.join(","); //diagnosis for CCMD for their push notification
        console.log(values);
    }

    function othersDiagnosis() {
        $('#icd-modal').modal('hide');
        $("#others_diagnosis").html(loading);
        $("#clear_other_diag").show();
        setTimeout(function() {
            $("#others_diagnosis").html('<small class="text-success">OTHER DIAGNOSIS:</small> <span class="text-red">*</span>\n' +
                '                                <br />\n' +
                '                                <textarea id="other_diag" class="form-control reason_referral" name="other_diagnosis" style="resize: none;width: 100%;" rows="7" required></textarea>')
        }, 500);
    }
</script>

<script>
    var upload_pos = 2;
    var upload_count = 0;
    let fileInfoArray = [];
    let fileQueue = [];
    let isProcessing = false;

    function readUrl(input, pos) {
        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                fileQueue.push({
                    file: input.files[i],
                    pos: pos + i
                });
            }
            processFileQueue();
        }
    }

    function processFileQueue() {
        if (isProcessing || fileQueue.length === 0) return;

        isProcessing = true;
        let { file, pos } = fileQueue.shift();
        processFile(file, pos);
    }

    function processFile(file, pos) {
        let reader = new FileReader();
        let type = file.type;
        let filename = file.name;

        let fileIndex = fileInfoArray.length;
   

        reader.onloadend = function(e) {
            let iconSrc;

            fileInfoArray.push({
                name: filename,
                type: type,
                src: e.target.result,
                file: file
            });

            if (type === 'application/pdf') {
                iconSrc = '{{ asset('resources/img/pdf_icon.png') }}';
            } else if (type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                iconSrc = '{{ asset('resources/img/document_icon.png') }}';
               
            } else if (type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                iconSrc = '{{ asset('resources/img/sheet_icon.png') }}';
               
            } else if (type.startsWith('image/')) {
                iconSrc = e.target.result;
            } else {
                iconSrc = '{{ asset('resources/img/file_icon.png') }}'; // Default icon
            }

            setFileUploadImage(pos, iconSrc, filename, {width: '150px', height: '120px'}, fileIndex);

            $('#image-upload-wrap'+pos).hide();
            $('#file-upload-content'+pos).show();

            var maxLength = 12;
            var truncateName = filename.length > maxLength ? filename.substring(0, maxLength) + '...' : filename;
            $('#image-title' + pos).html(truncateName).attr('title', filename);

            upload_count++;
            addFile();

            isProcessing = false;
            processFileQueue(); // Process next file in queue
            $('#remove_files_btn').show();
        };

        reader.onerror = function() {
            console.error('File reading failed');
            isProcessing = false;
            processFileQueue(); // Process next file in queue even if this one failed
        };

        if (type === 'application/pdf' || type.startsWith('image/')) {
            reader.readAsDataURL(file);
        } else {
            reader.readAsArrayBuffer(file); // Just to trigger onloadend for non-previewable files
        }
    }

    
    function setFileUploadImage(pos, src, filename, imgSize, fileIndex) {
        $('#file-upload-image'+pos)
            .attr('src', src)
            .attr('title', filename)
            .css(imgSize)
            .off('click')  // Remove any existing click handlers
            .on('click', function() {
                showPreviewFile(fileIndex);
            });
            
    }

    function showPreviewFile(index) {
        console.log("file Upload :", fileInfoArray);
        let activeFiles = fileInfoArray.filter(file => file !== null);
        console.log("Active files:", activeFiles);
        
        // If no valid files at this index, close modal
        if (!activeFiles[index]) {
            console.log("No file found at index:", index);
            $('#filePreviewModal').modal('hide');
            return;
        }

        let currentFile = activeFiles[index];
        $('#carousel-inner').empty();
        console.log("Showing preview for file:", currentFile.name);

        let content = '';

        if (currentFile.type === 'application/pdf') {
            // Use PDF.js to render the PDF with uniform height and width
            content = `
                <embed src="${currentFile.src}" type="application/pdf" style="width:100%;height:80vh;" />
            `;
        } else if (currentFile.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            content = `
                <div class="file-not-supported">
                    <p>Word document preview is not available.</p>
                    <p>File Name: ${currentFile.name}</p>
                    <button class="btn btn-primary" onclick="convertToWord(${index})">Download Word File</button>
                </div>`;
        } else if (currentFile.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            content = `
                <div class="file-not-supported">
                    <p>Excel spreadsheet preview is not available.</p>
                    <p>File Name: ${currentFile.name}</p>
                    <button class="btn btn-primary" onclick="convertToExcel(${index})">Download Excel File</button>
                </div>`;
        } else if (currentFile.type.startsWith('image/')) {
            // Display image with a default max size
            content = `<img src="${currentFile.src}" alt="${currentFile.name}" class="image-preview">`;
        } else {
            content = `
                <div class="file-not-supported">
                    <p>Preview not available for this file type.</p>
                    <p>File Type: ${currentFile.type}</p>
                </div>`;
        }

        // Append content and show modal
        $('#carousel-inner').append(`<div class="carousel-item active">${content}</div>`);

        $('#filePreviewCarousel').attr('data-index', index);

        $('#filePreviewModal').modal('show');

        $('#filePreviewModal').css('z-index', parseInt($('#normalFormModal').css('z-index')) + 10);
        $('.modal-backdrop:last').css('z-index', parseInt($('#normalFormModal').css('z-index')) + 5);
    }

    function convertToWord(index) {
        downloadFile(index, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    }

    function convertToExcel(index) {
        downloadFile(index, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    function downloadFile(index, mimeType) {
        let file = fileInfoArray[index].file;
        let blob = new Blob([file], { type: mimeType });
        let link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = fileInfoArray[index].name;
        link.click();
    }



    function addFile() {

        var src = '{{ asset('resources/img/add_file.png') }}';
        if(upload_count % 4 == 0) {
            $('.attachment').append(
                '<div class="clearfix"></div>'
            );
        }
        $('.attachment').append(
            '<div class="col-md-3" id="upload'+upload_pos+'" style="position: relative;">\n' +
            '   <div class="file-upload">\n' +
            '       <div class="text-center image-upload-wrap" id="image-upload-wrap'+upload_pos+'">\n' +
            '           <input class="file-upload-input files" multiple id="file_upload_input'+upload_pos+'" type="file" name="file_upload[]" onchange="readUrl(this, '+upload_pos+');" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>\n' +
            '           <img src="'+src+'" style="width: 50%; height: 50%;">\n' +
            '       </div>\n' +
            '       <div class="file-upload-content" id="file-upload-content'+upload_pos+'">\n' +
            '           <img class="file-upload-image" id="file-upload-image'+upload_pos+'" src="#"/>\n' +
            '           <div class="image-title-wrap">\n' +
            '               <b><small class="image-title" id="image-title'+upload_pos+'" style="display:block; word-wrap: break-word;"></small></b>\n' +
            '               <button type="button" onclick="removeOneFile('+upload_pos+')" class="remove-icon-btn"> <i class="fa fa-trash"></i> </button>\n' +
            '           </div>\n' +
            '       </div>\n' +
            '   </div>\n' +
            '</div>'
        );

        upload_pos+=1;
    }

    function navigateCarousel(direction){
        let currentIndex = parseInt($('#filePreviewCarousel').attr('data-index'));
        let newIndex = direction == 'next' ? currentIndex + 1 : currentIndex - 1;

        if(newIndex >= 0 && newIndex < fileInfoArray.length){
            showPreviewFile(newIndex);
        }
    }

    function removeFiles() {
        $('.attachment').html("");
        upload_count = 0;
        upload_pos = 1;
        $('#remove_files_btn').hide();
        addFile();
    }

    
    function removeOneFile(uploadCount) {
    // Close the modal and remove the file preview element
    $('#filePreviewModal').modal('hide');

    const fileElement = $('#upload' + uploadCount);
    const fileName = fileElement.find('.image-title').attr('title');
    
    // Remove from fileInfoArray
    if (fileName) {
        const fileIndex = fileInfoArray.findIndex(file => file.name === fileName);
        if (fileIndex !== -1) {
            // Remove the file from fileInfoArray
            fileInfoArray.splice(fileIndex, 1);
            console.log("File removed successfully. Updated fileInfoArray:", fileInfoArray);
            
            // Remove all existing file upload elements except the last one (add file button)
            $('.attachment').children().not(':last').remove();
            
            // Recreate elements for remaining files
            fileInfoArray.forEach((fileInfo, index) => {
                const position = index + 1;
                
                // Create new element for this file
                var src = '{{ asset('resources/img/add_file.png') }}';
                if(index % 4 == 0) {
                    $('.attachment').prepend('<div class="clearfix"></div>');
                }
                
                const newElement = $(
                    '<div class="col-md-3" id="upload'+position+'" style="position: relative;">\n' +
                    '   <div class="file-upload">\n' +
                    '       <div class="text-center image-upload-wrap" id="image-upload-wrap'+position+'">\n' +
                    '           <input class="file-upload-input files" multiple id="file_upload_input'+position+'" type="file" name="file_upload[]" onchange="readUrl(this, '+position+');" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>\n' +
                    '           <img src="'+src+'" style="width: 50%; height: 50%;">\n' +
                    '       </div>\n' +
                    '       <div class="file-upload-content" id="file-upload-content'+position+'">\n' +
                    '           <img class="file-upload-image" id="file-upload-image'+position+'" src="#"/>\n' +
                    '           <div class="image-title-wrap">\n' +
                    '               <b><small class="image-title" id="image-title'+position+'" style="display:block; word-wrap: break-word;"></small></b>\n' +
                    '               <button type="button" onclick="removeOneFile('+position+')" class="remove-icon-btn"> <i class="fa fa-trash"></i> </button>\n' +
                    '           </div>\n' +
                    '       </div>\n' +
                    '   </div>\n' +
                    '</div>'
                );
                
                // Insert before the last element (add file button)
                $('.attachment').children().last().before(newElement);
                console.log("fileInfo", fileInfo);
                // Set up the file input with the correct file
                const currentInput = document.getElementById('file_upload_input' + position);
                if (currentInput) {
                    const dt = new DataTransfer();
                    dt.items.add(fileInfo.file);
                    currentInput.files = dt.files;
                    
                    // Update the preview
                    const iconSrc = fileInfo.type.startsWith('image/') ? fileInfo.src : getIconSrc(fileInfo.type);
                    
                    $('#image-upload-wrap'+position).hide();
                    $('#file-upload-content'+position).show();
                    
                    setFileUploadImage(
                        position,
                        iconSrc,
                        fileInfo.name,
                        {width: '150px', height: '120px'},
                        index
                    );

                    // Update filename display
                    const maxLength = 12;
                    const truncateName = fileInfo.name.length > maxLength ? 
                        fileInfo.name.substring(0, maxLength) + '...' : 
                        fileInfo.name;
                    $('#image-title' + position).html(truncateName).attr('title', fileInfo.name);
                }
            });
        }
    }

    // Update counts
    upload_count = fileInfoArray.length;
    
    // Reset if no files remaining
    if (upload_count === 0) {
        upload_count = 0;
        upload_pos = 1;
        $('#remove_files_btn').hide();
        addFile();
    } else {
        // Ensure upload_pos is correct for next file addition
        upload_pos = upload_count + 1;
    }

    // Clear file queue
    fileQueue = [];
    isProcessing = false;
}

function getIconSrc(fileType) {
    if (fileType === 'application/pdf') {
        return '{{ asset('resources/img/pdf_icon.png') }}';
    } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
        return '{{ asset('resources/img/document_icon.png') }}';
    } else if (fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        return '{{ asset('resources/img/sheet_icon.png') }}';
    } else {
        return '{{ asset('resources/img/file_icon.png') }}';
    }
}

    // function removeOneFile(uploadCount){

    //     $('#filePreviewModal').modal('hide');

    //     $('#upload' + uploadCount).remove();

    //     fileInfoArray.splice(uploadCount, 1);

    //     upload_count = fileInfoArray.length;

    //     $('.col-md-3').each(function(newIndex) {
    //         $(this).attr('id', `upload${newIndex}`);
    //         $(this).find('.remove-icon-btn').attr('onclick', `removeOneFile(${newIndex})`);
    //     });
        
    //     showPreviewFile();

    //     if (fileInfoArray.length === 0) {
    //         upload_count = 0;
    //         upload_pos = 1;
    //         $('#remove_files_btn').hide();
    //         addFile();
    //     }

    // }

    $(document).ready(function() {
        for (var i = 0; i < upload_count; i++) {
            $('#image-upload-wrap' + i).bind('dragover', function () {
                $('#image-upload-wrap' + i).addClass('image-dropping');
            });
            $('#image-upload-wrap' + i).bind('dragleave', function () {
                $('#image-upload-wrap' + i).removeClass('image-dropping');
            });
        }
        $('#remove_files_btn').hide();
    });
</script>