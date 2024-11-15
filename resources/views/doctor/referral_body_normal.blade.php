<?php $user = Session::get('auth'); ?>
<style>
    .mobile-view {
        display: none;
        visibility: hidden;
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

    #telemedicine {
        border-color:#00a65a;
        border: none;
        padding: 7px;
    }
    #telemedicine:hover {
        background-color: lightgreen;
    }
</style>

@include('include.header_form', ['optionHeader' => 'referred'])<br>

<table class="table table-striped form-label referral-table">
    <tr>
        <td colspan="6" class="form-label">Name of Referring Facility: <span class="referring_name form-details">{{ $form->referring_name }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Facility Contact #: <span class="referring_contact form-details">{{ $form->referring_contact }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Address: <span class="referring_address form-details">{{ $form->referring_address }}</span></td>
    </tr>
    <tr>
        <td colspan="3">Referred to: <span class="referred_name form-details">{{ $form->referred_name }}</span></td>
        <td colspan="3">Department: <span class="department_name form-details">{{ $form->department }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Address: <span class="referred_address form-details">{{ $form->referred_address }}</span></td>
    </tr>
    <tr>
        <td colspan="3">Date/Time Referred (ReCo): <span class="date_referred form-details">{{ $form->date_referred }}</span></td>
        <td colspan="3">Date/Time Transferred: <span class="date_transferred form-details"></span></td>
    </tr>
    <tr>
        <td colspan="3">Name of Patient: <span class="patient_name form-details">{{ $form->patient_name }}</span></td>
        <td>Age: <span class="patient_age form-details">
            @if($age_type == "y")
                @if($patient_age == 1)
                    {{ $patient_age }} year old
                @else
                    {{ $patient_age }} years old
                @endif
            @elseif($age_type == "m")
                @if($patient_age['month'])
                    {{ $patient_age['month'] }} mo,
                @else
                    {{ $patient_age['month'] }} mos,
                @endif
                @if($patient_age['days'] == 1)
                    {{ $patient_age['days'] }} day old
                @else
                    {{ $patient_age['days'] }} days old
                @endif
            @endif
            </span><br>
            <small><i>(at time of referral)</i></small>
        </td>
        <td>Sex: <span class="patient_sex form-details">{{ $form->patient_sex }}</span></td>
        <td>Status: <span class="patient_status form-details">{{ $form->patient_status }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Address: <span class="patient_address form-details">{{ $form->patient_address }}</span></td>
    </tr>
    <tr>
        <td colspan="3">PhilHealth status: <span class="phic_status form-details">{{ $form->phic_status }}</span></td>
        <td colspan="3">PhilHealth #: <span class="phic_id form-details">{{ $form->phic_id }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Covid Number: <span class="covid_number form-details">{{ $form->covid_number }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Clinical Status: <span class="clinical_status form-details" style="text-transform: capitalize;">{{ $form->refer_clinical_status }}</span></td>
    </tr>
    <tr>
        <td colspan="6">Surveillance Category: <span class="surveillance_category form-details" style="text-transform: capitalize;">{{ $form->refer_sur_category }}</span></td>
    </tr>
    <tr>
        <td colspan="6">
            Case Summary (pertinent Hx/PE, including meds, labs, course etc.):
            <br />
            <span class="case_summary form-details">{!! nl2br($form->case_summary) !!}</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            Summary of ReCo (pls. refer to ReCo Guide in Referring Patients Checklist):
            <br />
            <span class="reco_summary form-details">{!! nl2br($form->reco_summary) !!}</span>
        </td>
    </tr>
    @if(isset($icd[0]))
        <tr>
            <td colspan="6">
                ICD-10 Code and Description:
                <br />
                @foreach($icd as $i)
                    <span class="reason form-details">{{ $i->code }} - {{ $i->description }}</span><br>
                @endforeach
            </td>
        </tr>
    @endif
    @if(isset($form->diagnosis))
        <tr>
            <td colspan="6">
                Diagnosis/Impression:
                <br />
                <span class="diagnosis form-details">{!! nl2br($form->diagnosis) !!}</span>
            </td>
        </tr>
    @endif
    @if(isset($form->other_diagnoses))
        <tr>
            <td colspan="6">
                Other Diagnoses:
                <br />
                <span class="reason form-details">{{ $form->other_diagnoses }}</span>
            </td>
        </tr>
    @endif
    @if(isset($reason))
        <tr>
            <td colspan="6">
                Reason for referral:
                <br />
                <span class="reason form-details">{{ $reason->reason }}</span>
            </td>
        </tr>
    @endif
    @if(isset($form->other_reason_referral))
        <tr>
            <td colspan="6">
                Reason for referral:
                <br />
                <span class="reason form-details">{{ $form->other_reason_referral }}</span>
            </td>
        </tr>
    @endif
    @if(isset($file_path))
        <tr>
            <td colspan="6">
                @if(count($file_path) > 1) File Attachments: @else File Attachment: @endif
                @for($i = 0; $i < count($file_path); $i++)
                    <a href="{{ $file_path[$i] }}" id="file_download" class="reason" target="_blank" style="font-size: 12pt;" download>{{ $file_name[$i] }}</a>
                    @if($i + 1 != count($file_path))
                        ,&nbsp
                    @endif
                @endfor
                {{--<a href="{{ asset($file_path) }}" id="file_download" class="reason" target="_blank" style="font-size: 12pt;" download>{{ $file_name }}</a>--}}
            </td>
        </tr>
    @endif
    <tr>
        <td colspan="6">
            Name of referring MD/HCW: <span class="referring_md form-details">{{ $form->md_referring }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            Contact # of referring MD/HCW: <span class="referring_md_contact form-details">{{ $form->referring_md_contact }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="6">Name of referred MD/HCW- Mobile Contact # (ReCo): <span class="referred_md form-details">{{ $form->md_referred }}</span></td>
    </tr>
</table>
<hr />

<button class="btn-sm btn-default btn-flat" data-dismiss="modal" id="closeReferralForm{{$form->code}}"><i class="fa fa-times"></i> Close</button>
<div class="form-fotter pull-right">
    {{--@if(!($cur_status == 'referred' || $cur_status == 'redirected' || $cur_status == 'transferred' || $cur_status == 'rejected') && $form->department_id === 5 && $user->id == $form->md_referring_id)
        <button class="btn-sm bg-success btn-flat" id="telemedicine" onclick="openTelemedicine('{{ $form->tracking_id }}','{{ $form->code }}','{{ $form->action_md }}','{{ $form->referring_md }}');"><i class="fa fa-camera"></i> Telemedicine</button>
        <a href="{{ url('doctor/print/prescription').'/'.$id }}" target="_blank" type="button" style="color: black;" class="btn btn-sm bg-warning btn-flat" id="prescription"><i class="fa fa-file-zip-o"></i> Prescription</a>
    @endif--}}
    @if(($cur_status == 'transferred' || $cur_status == 'referred' || $cur_status == 'redirected') && $user->id == $form->md_referring_id)
        <button class="btn-sm btn-primary btn-flat button_option edit_form_btn" data-toggle="modal" data-target="#editReferralForm" data-id="{{ $id }}" data-type="normal" data-referral_status="{{ $referral_status }}"><i class="fa fa-edit"></i> Edit Form</button>
    @endif
    @if($cur_status == 'cancelled' && $user->id == $form->md_referring_id)
        <button class="btn-sm btn-danger btn-flat button_option undo_cancel_btn" data-toggle="modal" data-target="#undoCancelModal" data-id="{{ $id }}"><i class="fa fa-times"></i> Undo Cancel</button>
    @endif
    @if($referral_status == 'referred' || $referral_status == 'redirected')
        @if(!$form->telemedicine)
            <button class="btn-sm btn-primary btn-flat queuebtn" data-toggle="modal" data-target="#queueModal" data-id="{{ $id }}"><i class="fa fa-pencil"></i> Update Queue</button>
            <button class="btn-sm btn-info btn_call_request btn-flat btn-cal button_option" data-toggle="modal" data-target="#sendCallRequest"><i class="fa fa-phone"></i> Call Request <span class="badge bg-red-active call_count" data-toggle="tooltip" title=""></span> </button>
            <button class="btn-sm btn-danger btn-flat button_option" data-toggle="modal" data-target="#rejectModal"><i class="fa fa-line-chart"></i> Recommend to Redirect</button>
        @endif
        <button class="btn-sm btn-success btn-flat button_option" data-toggle="modal" data-target="#acceptFormModal"><i class="fa fa-check"></i> Accept</button>
    @endif
    <a href="{{ url('doctor/print/form').'/'.$form->tracking_id }}" target="_blank" class="btn-refer-normal btn btn-sm btn-warning btn-flat"><i class="fa fa-print"></i> Print Form</a>
</div>
<div class="clearfix"></div>

<script>
    function getParameterByName(name) {
        url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
    if(getParameterByName('referredCode')) {
        $("#telemedicine").addClass('hide');
        $(".edit_form_btn").addClass('hide');
    }

    function openTelemedicine(tracking_id, code, action_md, referring_md) {
        console.log("mao");
        var url = "<?php echo asset('api/video/call'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "tracking_id" : tracking_id,
            "code" : code,
            "action_md" : action_md,
            "referring_md" : referring_md,
            "trigger_by" : "{{ $user->id }}",
            "form_type" : "normal"
        };
        $.post(url,json,function(){

        });
        var windowName = 'NewWindow'; // Name of the new window
        var windowFeatures = 'width=600,height=400'; // Features for the new window (size, position, etc.)
        var newWindow = window.open("{{ asset('doctor/telemedicine?id=') }}"+tracking_id+"&code="+code+"&form_type=normal&referring_md=yes", windowName, windowFeatures);
        if (newWindow && newWindow.outerWidth) {
            // If the window was successfully opened, attempt to maximize it
            newWindow.moveTo(0, 0);
            newWindow.resizeTo(screen.availWidth, screen.availHeight);
        }
    }
</script>

