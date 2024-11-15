<?php
$user = Session::get('auth');
$counter = 0;
?>
@extends('layouts.app')

@section('content')
<style>
    .ui-autocomplete {
        background-color: white;
        width: 20%;
        z-index: 1100;
        max-height: 300px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }

    .ui-menu-item {
        cursor: pointer;
    }

    .file-upload {
        background-color: #ffffff;
        /*width: 100%!*200px*!;*/
        margin: 0 auto;
        /* padding: 20px; */
        padding: 10px;
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
        background-color:
            /*#6ab155*/
            #1FB264;
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

    .mobile-view {
        display: none;
        visibility: hidden;
    }

    .container-referral {
        border: 1px solid lightgrey;
        width: 100%;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 5px;
        padding-right: 5px;
    }

    @media only screen and (max-width: 720px) {
        .file-upload {
            background-color: #ffffff;
            width: 300px;
            margin: 0 auto;
            padding: 20px;
        }

        .web-view {
            display: none;
            visibility: hidden;
        }

        .mobile-view {
            display: block;
            visibility: visible;
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

      /********************* for file upload NORMAL FORM *********************/
    .fileuploadBackground{
        background-color: rgba(0, 0, 0, 0.7); 
    }
   .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.7); 
    }

    /* Center the modal vertically */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    @media (min-width: 576px) {
        .modal-dialog-centered {
            min-height: calc(100% - 3.5rem);
        }
    }

    /* Full width modal content */
    .modal-content {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
    }

    /* Uniform file preview container */
    .file-preview-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
    }

    /* Carousel styling */
    #filePreviewCarousel {
        flex-grow: 1;
        margin: 0 15px;
        max-width: 800px;
    }

    /* Navigation buttons */
    .nav-button {
        background: none;
        border: none;
        font-size: 2rem;
        color: #333;
        opacity: 0.7;
        transition: opacity 0.3s;
    }

    .nav-button:hover {
        opacity: 1;
    }

    .prev-icon-file,
    .next-icon-file {
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        padding: 10px;
    }

    /* Ensure uniform preview display */
    .carousel-item {
        text-align: center;
    }

    .carousel-item img, 
    .carousel-item embed {
        max-width: 100%;
        max-height: 70vh;
        margin: auto;
        display: block;
        width: auto;
        height: auto;
    }

    /* Set default size for different file types */
    .pdf-preview,
    .image-preview {
        width: 100%;
        height: 600px; /* Standard height for all previews */
    }

    /* Word/Excel file unsupported message */
    .file-not-supported {
        text-align: center;
        margin-top: 20px;
        color: #dc3545;
    }

    div#filePreviewModal {
        background-color: rgba(0,0,0,0.99);
    }

</style>

<div class="row">
    <div class="col-md-3">
        @include('sidebar.filter_profile')
    </div>
    <div class="col-md-9">
        <div class="jim-content">
            <h3 class="page-header">{{ $title }}</h3>
            @if(count($data))
            <div class="table-responsive">
                <table class="table table-striped" style="white-space:nowrap;">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Age/DOB</th>
                            <th>Region/Province</th>
                            <th>Municipality/Barangay</th>
                            <th style="width:18%; text-align: center">Action</th>
                        </tr>
                        @foreach($data as $row)
                        <?php
                        $modal = ($row->type == 'normal') ? '#normalFormModal' : '#pregnantFormModal';
                        ?>
                        <tr>
                            <td>
                                <b>
                                    <a href="#patient_modal" data-toggle="modal" data-id="{{ $row->id }}" onclick="PatientBody('<?php echo $row->id ?>')" class="update_info">
                                        {{ $row->fname }} {{ isset($row->mname[0]) ? strtoupper($row->mname[0]) : '' }}. {{ $row->lname }}
                                    </a>
                                </b><br>
                                <small class="text-success">{{ $row->contact }}</small>
                            </td>
                            <td>
                                {{ $row->sex }}<br>
                                <small class="text-success">{{ $row->civil_status }}</small>
                            </td>
                            <td>
                                <?php $age = \App\Http\Controllers\ParamCtrl::getAge($row->dob);
                                $month = \App\Http\Controllers\ParamCtrl::getMonths($row->dob) ?>
                                @if( $age == 1)
                                {{ $age }} year old
                                @elseif( $age > 0)
                                {{ $age }} years old
                                @else
                                @if($month['month'] == 1)
                                {{ $month['month'] }} mo,
                                @else
                                {{ $month['month'] }} mos,
                                @endif
                                @if($month['days'] == 1)
                                {{ $month['days'] }} day
                                @else
                                {{ $month['days'] }} days
                                @endif
                                @endif
                                <br />
                                <small class="text-muted">{{ date('M d, Y',strtotime($row->dob)) }}</small>
                            </td>
                            <td>
                                {{ $row->region }}<br />
                                <?php
                                if (!$province_display = \App\Province::find($row->province)->description)
                                    $province_display = $row->province_others;
                                ?>
                                <small class="text-success">{{ $province_display }}</small>
                            </td>
                            <td>
                                <?php
                                $brgy_id = ($source == 'tsekap') ? $row->barangay_id : $row->brgy;
                                $city_id = ($source == 'tsekap') ? $row->muncity_id : $row->muncity;
                                $phic_id = ($source == 'tsekap') ? $row->phicID : $row->phic_id;
                                $phic_id_stat = 0;
                                if ($phic_id) {
                                    $phic_id_stat = 1;
                                }
                                ?>

                                <?php
                                if (!$brgy = \App\Barangay::find($brgy_id)->description)
                                    $brgy = $row->brgy_others;
                                if (!$city = \App\Muncity::find($city_id)->description)
                                    $city = $row->muncity_others;
                                ?>
                                {{ $city }}<br />
                                <small class="text-success">{{ $brgy }}</small>
                            </td>
                            <td>
                                @if($row->sex=='Female' && ($age >= 10 && $age <= 49)) <a href="#pregnantModal" data-patient_id="{{ $row->id }}" data-toggle="modal" data-type="pregnant" class="btn btn-primary btn-xs profile_info hide patient-emergency hidden" onclick="handleRefer()" style="width:100%;margin-bottom:5px;">
                                    <i class="fa fa-ambulance"></i>
                                    Refer
                                    </a>
                                    <a href="#pregnantModal" data-patient_id="{{ $row->id }}" data-toggle="modal" data-type="pregnant" data-telemedicine="1" onclick="handleTelemedicine()" class="btn btn-success btn-xs profile_info hide patient-consultation hidden" style="width:100%;margin-bottom:5px;">
                                        <i class="fa fa-stethoscope"></i>
                                        Consultation
                                    </a><br>
                                    <a href="#" id="walkinPregnant{{ $counter }}" data-patient_id="{{ $row->id }}" data-toggle="modal" data-type="pregnant" onclick="promptWalkinPregnant(<?php echo $counter++ ?>)" style="width:100%;" class="btn btn-warning btn-xs profile_info hide patient-emergency hidden">
                                        <i class="fa fa-stethoscope"></i>
                                        Walk-In
                                    </a>
                                    @else
                                    <a href="#normalFormModal" data-patient_id="{{ $row->id }}" data-backdrop="static" data-toggle="modal" data-type="normal" style="width:100%;margin-bottom:5px;" onclick="handleRefer()" class="btn btn-primary btn-xs profile_info patient-emergency hidden">
                                        <i class="fa fa-ambulance"></i>
                                        Refer
                                    </a>
                                    <a href="#normalFormModal" data-patient_id="{{ $row->id }}" data-backdrop="static" data-toggle="modal" data-type="normal" onclick="handleTelemedicine()" style="width:100%;margin-bottom:5px;" class="btn btn-success btn-xs profile_info patient-consultation hidden">
                                        <i class="fa fa-stethoscope"></i>
                                        Consultation
                                    </a><br>
                                    <a href="#" id="walkinNormal{{ $counter }}" data-patient_id="{{ $row->id }}" data-backdrop="static" data-toggle="modal" data-type="normal" onclick="promptWalkinNormal(<?php echo $counter++ ?>)" style="width:100%;" class="btn btn-warning btn-xs profile_info patient-emergency hidden">
                                        <i class="fa fa-stethoscope"></i>
                                        Walk-In
                                    </a>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <ul class="pagination pagination-sm no-margin pull-right">
                {{ $data->links() }}
            </ul>

            @else
            <div class="alert alert-warning">
                <span class="text-warning">
                    <i class="fa fa-warning"></i> Patient not found!
                </span>
            </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="filePreviewModal" tabindex="-1" role="dialog" aria-labelledby="filePreviewModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header"> -->
                <!-- <h4 class="modal-title" id="filePreviewModalLabel">File Preview</h4> -->
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div> -->
            <div class="modal-body">
                <div class="file-preview-container">
                    <button class="nav-button prev-button" onclick="navigateCarousel('prev')">
                        <span class="prev-icon-file glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <div id="filePreviewCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                        <div class="carousel-inner" id="carousel-inner">
                            <!-- File previews will be dynamically inserted here -->
                        </div>
                    </div>
                    <button class="nav-button next-button" onclick="navigateCarousel('next')">
                        <span class="next-icon-file glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modal.pregnantModal')
@include('modal.normal_form_editable')
@include('modal.normal_form_editable_walkin')
@include('modal.pregnant_form_editable')
@include('modal.pregnant_form_editable_walkin')
@endsection

@section('js')
@include('script.filterMuncity')
{{--@include('script.firebase')--}}
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase.js"></script>
@include('script.datetime')
<script>

    $(document).ready(function() {
        $(".patient-emergency").removeClass('hidden');
        $(".patient-consultation").removeClass('hidden');

        const telemedicineAppoinmentSlot = decodeURIComponent(new URL(window.location.href).searchParams.get('appointment'));
        var appointment = @json($telemedicine);
        //let url = new URL(window.location.href);
        if (telemedicineAppoinmentSlot && telemedicineAppoinmentSlot !== 'null') {
            $(".Appointment").val(telemedicineAppoinmentSlot);
        }

        if (JSON.parse(telemedicineAppoinmentSlot)) {
            $(".patient-emergency").remove();
        
            setCookie('telemedicineAppointment', telemedicineAppoinmentSlot, 1);
            
            console.log("telemedicineAppoinmentSlot", telemedicineAppoinmentSlot);
            
        }else if(appointment){

            $(".patient-emergency").remove();
            $(".Appointment").val(appointment);

            // $.ajax({
            //     url: "{{ url('pass/appointment') }}",
            //     method: 'POST',
            //     data: {
            //         telemed: appointment,
            //         _token: '{{ csrf_token() }}'  // Include the CSRF token for security
            //     },
            //     success: function(response) {
            //         console.log("Appointment successfully passed to the backend.", appointment);
            //     },
            // });
            console.log("appointment-search", appointment)

        } else {
            $(".patient-consultation").remove();
            $(".Appointment").val('');
            setCookie('telemedicineAppointment', false, 1);
        }
    });

    function handleRefer() {
        $(".telemedicine").val(0);
        selectFormTitle("Clinical ");
    }

    function handleTelemedicine() {
        $(".telemedicine").val(1);
        selectFormTitle("Clinical ");
    }

    function setClinicalFormTile(type) {
        if (type == "pregnant") {
            selectFormTitle("BEmONC/ CEmONC ");
        } else {
            selectFormTitle("Clinical ");
        }
    }

    function selectFormTitle(initialTitle) {
        const telemedicine = parseInt($(".telemedicine").val());
        if (telemedicine) {
            $(".clinical-form-title").html(`${initialTitle} Telemedicine Consultation`);
        } else {
            $(".clinical-form-title").html(`${initialTitle} Referral Form`);
        }
    }

    function promptWalkinPregnant(counter) {
        Lobibox.confirm({
            msg: "Do you want to proceed to walkin?",
            callback: function($this, type, ev) {
                if (type == 'yes') {
                    $('#walkinPregnant' + counter).attr('onclick', "");
                    $('#walkinPregnant' + counter).attr('href', '#pregnantModalWalkIn');
                    $('#walkinPregnant' + counter).click();
                } else {
                    $('#walkinPregnant' + counter).attr('onClick', 'promptWalkinPregnant(' + counter + ')');
                    $('#walkinPregnant' + counter).attr('href', '#');
                }
            }
        });
    }

    $('.cancelWalkin').on('click', function() {
        var counter = "<?php echo $counter; ?>";
        for (var i = 0; i < counter; i++) {
            $('#walkinPregnant' + i).attr('href', '#');
            $('#walkinPregnant' + i).attr('onClick', 'promptWalkinPregnant(' + i + ')');
            $('#walkinNormal' + i).attr('href', '#');
            $('#walkinNormal' + i).attr('onClick', 'promptWalkinNormal(' + i + ')');
        }
    });

    function promptWalkinNormal(counter) {
        selectFormTitle("Clinical ");
        Lobibox.confirm({
            msg: "Do you want to proceed to walkin?",
            callback: function($this, type, ev) {
                if (type == 'yes') {
                    $('#walkinNormal' + counter).attr('onclick', "");
                    $('#walkinNormal' + counter).attr('href', '#normalFormModalWalkIn');
                    $('#walkinNormal' + counter).click();
                } else {
                    $('#walkinNormal' + counter).attr('onClick', 'promptWalkinNormal(' + counter + ')');
                    $('#walkinNormal' + counter).attr('href', '#');
                }
            }
        });
    }

    function PatientBody(patient_id) {
        console.log(patient_id);
        var url = "<?php echo asset('doctor/patient/update'); ?>";
        var json = {
            "patient_id": patient_id,
            "_token": "<?php echo csrf_token(); ?>"
        };
        $.post(url, json, function(result) {
            $(".patient_body").html(result);
        });
    }

    $(".select2").select2({
        width: '100%'
    });

    var referring_facility = "{{ $user->facility_id }}";
    var referred_facility = '';
    var referring_facility_name = $(".referring_name").val();
    var referring_md = "{{ $user->fname }} {{ $user->mname }} {{ $user->lname }}";
    var name,
        age,
        sex,
        address,
        form_type,
        reason,
        patient_id,
        civil_status,
        phic_status,
        phic_id,
        department_id,
        department_name;

    $('.select_facility_walkin').on('change', function() {
        var id = $(this).val();
        referred_facility = "{{ $user->facility_id }}";
        var url = "{{ url('location/facility/') }}";
        referring_facility_name = $(this).find(':selected').data('name');

        $.ajax({
            url: url + '/' + id,
            type: 'GET',
            success: function(data) {
                console.log(data);
                $('.facility_address').html(data.address);
            },
            error: function() {
                $('#serverModal').modal();
            }
        });
    });

    $('.select_department').on('change', function() {
        var id = $(this).val();
        var list = "{{ url('list/doctor') }}";
        if (id) {
            if (referred_facility == 0) {
                referred_facility = "{{ $user->facility_id }}";
            }
            $.ajax({
                url: list + '/' + referred_facility + '/' + id,
                type: 'GET',
                success: function(data) {
                    $('.referred_md').empty()
                        .append($('<option>', {
                            value: '',
                            text: 'Any...'
                        }));
                    jQuery.each(data, function(i, val) {
                        $('.referred_md').append($('<option>', {
                            value: val.id,
                            text: 'Dr. ' + val.fname + ' ' + val.mname + ' ' + val.lname + ' - ' + val.contact
                        }));

                    });
                },
                error: function() {
                    $('#serverModal').modal();
                }
            });
        }
    });

    $('.profile_info').removeClass('hide');
    $('.profile_info').on('click', function() {
        patient_id = $(this).data('patient_id');
        $.ajax({
            url: "{{ url('doctor/patient/info/') }}/" + patient_id,
            type: "GET",
            success: function(data) {
                patient_id = data.id;
                name = data.patient_name;
                sex = data.sex;
                age = data.age;
                civil_status = data.civil_status;
                phic_status = data.phic_status;
                phic_id = data.phic_id;
                address = data.address;

                $('.patient_name').html(name);
                $('.patient_address').html(address);
                $('input[name="phic_status"][value="' + phic_status + '"]').attr('checked', true);
                $('.phic_id').val(phic_id);
                $('.patient_sex').val(sex);
                if (data.ageType === 'y') {
                    if (age === 1)
                        $('.patient_age').html(age + " year old");
                    else
                        $('.patient_age').html(age + " years old");
                } else if (data.ageType === 'm') {
                    var age_str = "";
                    if (age.month === 1)
                        age_str = age.month + " month, ";
                    else
                        age_str = age.month + " months, ";

                    if (age.days === 1)
                        age_str += age.days + " day old";
                    else
                        age_str += age.days + " days old";

                    $('.patient_age').html(age_str);
                }
                $('.civil_status').val(civil_status);
                $('.patient_id').val(patient_id);
            },
            error: function() {
                $('#serverModal').modal();
            }
        });
    });

    function sendNotifierData(age, chiefComplaint, department, diagnosis, patient, sex, referring_hospital, date_referred, patient_code) {
        // Check if Firebase app with name '[DEFAULT]' already exists
        if (!firebase.apps.length) {
            // Your web app's Firebase configuration
            var firebaseConfig = {
                apiKey: "AIzaSyB_vRWWDwfiJVCA7RWOyP4lxyWn5QLYKmA",
                authDomain: "notifier-5e4e8.firebaseapp.com",
                databaseURL: "https://notifier-5e4e8-default-rtdb.firebaseio.com",
                projectId: "notifier-5e4e8",
                storageBucket: "notifier-5e4e8.appspot.com",
                messagingSenderId: "359294836752",
                appId: "1:359294836752:web:87c854779366d0f11d2a95",
                measurementId: "G-HEYDWWHLKV"
            };
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);
        }

        //initialize firebase
        var dbRef = firebase.database();
        //create table
        var requestRef = dbRef.ref('23');

        const newRef = requestRef.push({
            age: age,
            chiefComplaint: chiefComplaint,
            department: department,
            diagnosis: diagnosis,
            patient: patient,
            sex: sex,
            referring_hospital: referring_hospital,
            date_referred: moment(date_referred).format("YYYY-MM-DD HH:mm:ss"),
            patient_code: patient_code
        });

        const firebase_key = newRef.key;
        console.log(firebase_key)


        var form = new FormData();
        form.append("age", age);
        form.append("chiefComplaint", chiefComplaint);
        form.append("department", department);
        form.append("diagnosis", diagnosis);
        form.append("patient", patient);
        form.append("sex", sex);
        form.append("referring_hospital", referring_hospital);
        form.append("date_referred", moment(date_referred).format("YYYY-MM-DD HH:mm:ss"));
        form.append("patient_code", patient_code);
        form.append("firebase_key", firebase_key);

        var settings = {
            "url": "https://dohcsmc.com/notifier/api/insert_referral_5pm",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
        });
    }

    $('.normal_form').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();
        $('.btn-submit').attr('disabled', true);
     
        // const formData = new FormData(this);

        // const activFiles =  fileInfoArray.filter(file => file && !file.removed);

        // formData.delete('file_upload[]');

        // activFiles.forEach(fileInfo => {
        //     if(fileInfo.file){
        //         formData.append('file_upload[]', fileInfo.file);
        //     }
        // });
        // console.log("remaining file to upload", formData);
        form_type = '#normalFormModal';
        department_id = $('.select_department_normal').val();
        department_name = $('.select_department_normal option:selected').html();
        telemed = $('.telemedicine').val();

        $(this).ajaxSubmit({
            url: "{{ url('doctor/patient/refer/normal') }}",
            type: 'POST',
            success: function(data) {
                console.log(data);
                
                if (data == 'consultation_rejected') {
                    $('.loading').hide();
                    $('#pregnantModal').modal('hide');
                    $('#normalFormModal').modal('hide');
                    Lobibox.alert("error", {
                        msg: "This appoinment schedule is not available, please select other schedule in the calendar."
                    });
                    return;
                }
                //if((data.referred_to == 790 || data.referred_to == 23) && data.userid == 1687) {
                if (data.referred_to == 790 || data.referred_to == 23) {
                    var push_diagnosis = push_notification_diagnosis_ccmc ? push_notification_diagnosis_ccmc : $("#other_diag").val();
                    data.age = parseInt(data.age);
                    sendNotifierData(data.age, data.chiefComplaint, data.department, push_diagnosis, data.patient, data.sex, data.referring_hospital, data.date_referred, data.patient_code);
                    $('.loading').hide();
                    $('#pregnantModal').modal('hide');
                    $('#normalFormModal').modal('hide');
                    $('.btn-submit').attr('disabled', false);
                    Lobibox.alert("success", {
                        msg: "Successfully referred the patient!"
                    });
                } //push notification for CCMD
                else {
                    $(location).attr('href', `{{ asset('doctor/referred') }}?filterRef=${encodeURIComponent(telemed)}`);
                }
            }
            /*,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
                $('.loading').hide();
                $('#pregnantModal').modal('hide');
                $('#normalFormModal').modal('hide');
                $('.btn-submit').attr('disabled',false);
                Lobibox.notify('error', {
                    title: "Error",
                    msg: "Status: " + textStatus+" Error: " + errorThrown
                });
            }*/
        });
    });

    $('.normal_form_walkin').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();
        reason = $('.reason_referral').val();
        form_type = '#normalFormModal';
        department_id = $('.select_department_normal').val();
        department_name = $('.select_department_normal option:selected').html();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/patient/refer/walkin/normal') }}",
            type: 'POST',
            success: function(data) {
                console.log(data);
                setTimeout(function() {
                    window.location.reload(false);
                }, 500);
            },
            error: function() {
                $('#serverModal').modal();
            }
        });
    });

    $('.pregnant_form').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();
        form_type = '#pregnantFormModal';
        sex = 'Female';
        reason = $('.woman_information_given').val();
        department_id = $('.select_department_pregnant').val();
        department_name = $('.select_department_pregnant :selected').text();
        telemed = $('.telemedicine').val();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/patient/refer/pregnant') }}",
            type: 'POST',
            success: function(data) {
                console.log("patient", data);
                //if((data.referred_to == 790 || data.referred_to == 23) && data.userid == 1687) {
                if (data.referred_to == 790 || data.referred_to == 23) {
                    data.age = parseInt(data.age);
                    var push_diagnosis = push_notification_diagnosis_ccmc_pregnant ? push_notification_diagnosis_ccmc_pregnant : $("#other_diag_preg").val();
                    sendNotifierData(data.age, data.chiefComplaint, data.department, push_diagnosis, data.patient, data.sex, data.referring_hospital, data.date_referred, data.patient_code);
                    $('.loading').hide();
                    $('#pregnantModal').modal('hide');
                    $('#pregnantFormModal').modal('hide');
                    $('.btn-submit').attr('disabled', false);
                    Lobibox.alert("success", {
                        msg: "Successfully referred the patient!"
                    });
                } else {
                    $(location).attr('href', `{{ asset('doctor/referred') }}?filterRef=${encodeURIComponent(telemed)}`);
                }
            }
            /*,
                        error: function(XMLHttpRequest, textStatus, errorThrown){
                            $('.loading').hide();
                            $('#pregnantModal').modal('hide');
                            $('#pregnantFormModal').modal('hide');
                            $('.btn-submit').attr('disabled',false);
                            Lobibox.notify('error', {
                                title: "Error",
                                msg: "Status: " + textStatus+" Error: " + errorThrown
                            });
                        }*/
        });

    });

    $('.pregnant_form_walkin').on('submit', function(e) {
        e.preventDefault();
        $('.loading').show();
        form_type = '#pregnantFormModal';
        sex = 'Female';
        reason = $('.woman_information_given').val();
        department_id = $('.select_department_pregnant').val();
        department_name = $('.select_department_pregnant :selected').text();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/patient/refer/walkin/pregnant') }}",
            type: 'POST',
            success: function(data) {
                console.log(data);
                setTimeout(function() {
                    window.location.reload(false);
                }, 500);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
                $('#serverModal').modal();
            }
        });

    });

    function sendNormalData(data) {
        console.log("ni sud!");
        if (data.id != 0) {
            var form_data = {
                referring_name: referring_facility_name,
                patient_code: data.patient_code,
                patient_name: name,
                age: age,
                sex: sex,
                date: data.referred_date,
                form_type: form_type,
                tracking_id: data.id,
                referring_md: referring_md,
                referred_from: referring_facility,
                department_id: department_id,
                department_name: department_name
            };

            var dbRef = firebase.database();
            var connRef = dbRef.ref('Referral');
            connRef.child(referred_facility).push(form_data);

            var data = {
                "to": "/topics/ReferralSystem" + referred_facility,
                "data": {
                    "subject": "New Referral",
                    "date": data.referred_date,
                    "body": name + " was referred to your facility from " + referring_facility_name + "!"
                }
            };

            connRef.on('child_added', function(data) {
                setTimeout(function() {
                    connRef.child(data.key).remove();
                    window.location.reload(false);
                }, 500);
            });

            $.ajax({
                url: 'https://fcm.googleapis.com/fcm/send',
                type: 'post',
                data: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'key=AAAAJjRh3xQ:APA91bFJ3YMPNZZkuGMZq8MU8IKCMwF2PpuwmQHnUi84y9bKiozphvLFiWXa5I8T-lP4aHVup0Ch83PIxx8XwdkUZnyY-LutEUGvzk2mu_YWPar8PmPXYlftZnsJCazvpma3y5BI7QHP'
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    setTimeout(function() {
                        console.log("Force refresh!");
                        window.location.reload(false);
                    }, 15000);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Status: " + textStatus);
                    console.log("Error: " + errorThrown);
                }
            });

        } else {
            console.log("error else");
            setTimeout(function() {
                window.location.reload(false);
            }, 500);
        }
        console.log("ni lahus sa last!");
    }

    @if(Session::get('patient_update_save'))
    Lobibox.notify('success', {
        title: "",
        msg: "<?php echo Session::get("patient_message"); ?>",
        size: 'mini',
        rounded: true
    });
    <?php
    Session::put("patient_update_save", false);
    Session::put("patient_message", false)
    ?>
    @endif
</script>
@endsection