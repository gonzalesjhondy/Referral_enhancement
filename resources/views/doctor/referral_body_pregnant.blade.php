<?php
$user = Session::get('auth');
?>

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
</style>
@include('include.header_form')
<table class="table table-striped form-label">
    <tr>
        <th colspan="4">REFERRAL RECORD</th>
    </tr>
    <tr>
        <td>Who is Referring</td>
        <td>Record Number: <span class="record_no form-details">{{ $form['pregnant']->record_no }}</span></td>
        <td colspan="2">Referred Date: <span class="referred_date form-details">{{ $form['pregnant']->referred_date }}</span></td>
    </tr>
    <tr>
        <td colspan="2">Referring Name: <span class="md_referring form-details">{{ $form['pregnant']->md_referring }}</span></td>
        <td colspan="2">Arrival Date: </td>
    </tr>
    <tr>
        <td colspan="4">Contact # of referring MD/HCW: <span class="referring_md_contact form-details">{{ $form['pregnant']->referring_md_contact }}</span></td>
    </tr>
    <tr>
        <td colspan="4">Referring Facility: <span class="referring_facility form-details">{{ $form['pregnant']->referring_facility }}</span></td>
    </tr>
    <tr>
        <td colspan="4">Facility Contact #: <span class="referring_contact form-details">{{ $form['pregnant']->referring_contact }}</span></td>
    </tr>
    <tr>
        <td colspan="4">Accompanied by the Health Worker: <span class="health_worker form-details">{{ $form['pregnant']->health_worker }}</span></td>
    </tr>
    <tr>
        <td colspan="2">Referred To: <span class="referred_name form-details">{{ $form['pregnant']->referred_facility }}</span></td>
        <td colspan="2">Department: <span class="department_name form-details">{{ $form['pregnant']->department }}</span></td>
    </tr>
    <tr>
        <td colspan="4">Covid Number: <span class="covid_number form-details">{{ $form['pregnant']->covid_number }}</span></td>
    </tr>
    <tr>
        <td colspan="4">Clinical Status: <span class="clinical_status form-details" style="text-transform: capitalize;">{{ $form['pregnant']->refer_clinical_status }}</span></td>
    </tr>
    <tr>
        <td colspan="4">Surveillance Category: <span class="surveillance_category form-details" style="text-transform: capitalize;">{{ $form['pregnant']->refer_sur_category }}</span></td>
    </tr>
</table>

<div class="row">
    <div class="col-sm-6">
        <table class="table bg-warning">
            <tr class="bg-gray">
                <th colspan="4">WOMAN</th>
            </tr>
            <tr>
                <td colspan="3">Name: <span class="woman_name form-details">{{ $form['pregnant']->woman_name }}</span></td>
                <td>Age: <span class="patient_age form-details"> {{ $form['pregnant']->woman_age }}</span><br><small><i>(at time of referral)</i></small></td>
            </tr>
            <tr>
                <td colspan="4">Address: <span class="woman_address form-details">{{ $form['pregnant']->patient_address }}</span></td>
            </tr>
            <tr>
                <td colspan="4">
                    Main Reason for Referral: <span class="woman_reason form-details">{!! nl2br($form['pregnant']->woman_reason) !!}</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">Major Findings (Clinica and BP,Temp,Lab)
                    <br />
                    <span class="woman_major_findings form-details">{!! nl2br($form['pregnant']->woman_major_findings) !!}</span>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr class="bg-gray">
                <td colspan="4">Treatments Give Time</td>
            </tr>
            <tr>
                <td colspan="4">Before Referral: <span class="woman_before_treatment form-details">{{ $form['pregnant']->woman_before_treatment }}</span> - <span class="woman_before_given_time form-details">{{ $form['pregnant']->woman_before_given_time }}</span></td>
            </tr>
            <tr>
                <td colspan="4">During Transport: <span class="woman_during_transport form-details">{{ $form['pregnant']->woman_during_transport }}</span> - <span class="woman_transport_given_time form-details">{{ $form['pregnant']->woman_transport_given_time }}</span></td>
            </tr>
            <tr>
                <td colspan="4">Information Given to the Woman and Companion About the Reason for Referral
                    <br />
                    <span class="woman_information_given form-details">{!! nl2br($form['pregnant']->woman_information_given) !!}</span>
                </td>
            </tr>
            @if(isset($icd[0]))
                <tr>
                    <td colspan="4">
                        ICD-10 Code and Description:
                        <br />
                        @foreach($icd as $i)
                            <span class="reason form-details">{{ $i->code }} - {{ $i->description }}</span><br>
                        @endforeach
                    </td>
                </tr>
            @endif
            @if(isset($form['pregnant']->notes_diagnoses))
                <tr>
                    <td colspan="4">
                        Diagnosis/Impression:
                        <br />
                        <span class="diagnosis form-details">{!! nl2br($form['pregnant']->notes_diagnoses) !!}</span>
                    </td>
                </tr>
            @endif
            @if(isset($form['pregnant']->other_diagnoses))
                <tr>
                    <td colspan="4">
                        Other Diagnoses:
                        <br />
                        <span class="reason form-details">{{ $form['pregnant']->other_diagnoses }}</span>
                    </td>
                </tr>
            @endif
            @if(isset($reason))
                <tr>
                    <td colspan="4">
                        Reason for referral:
                        <br />
                        <span class="reason form-details">{{ $reason->reason }}</span>
                    </td>
                </tr>
            @endif
            @if(isset($form['pregnant']->other_reason_referral))
                <tr>
                    <td colspan="4">
                        Reason for referral:
                        <br />
                        <span class="reason form-details">{{ $form['pregnant']->other_reason_referral }}</span>
                    </td>
                </tr>
            @endif

            @if(isset($file_path))
                <tr>
                    <td colspan="6">
                        @if(count($file_path) > 1) File Attachments: @else File Attachment: @endif <br>
                        @for($i = 0; $i < count($file_path); $i++)
                            <a href="{{ $file_path[$i] }}" id="file_download" class="reason" target="_blank" style="font-size: 12pt;" download>{{ $file_name[$i] }}</a>
                            @if($i + 1 != count($file_path))
                                ,&nbsp;
                            @endif
                        @endfor
                    </td>
                </tr>
            @endif
            {{--@if(isset($file_path))--}}
                {{--<tr>--}}
                    {{--<td colspan="4">--}}
                        {{--File Attachment:--}}
                        {{--<a href="{{ asset($file_path) }}" target="_blank" class="reason" style="font-size: 12pt;" download>{{ $file_name }}</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endif--}}
        </table>
    </div>

    <div class="col-sm-6">
        <table class="table bg-warning">
            <tr class="bg-gray">
                <th colspan="4">BABY</th>
            </tr>
            <tr>
                <td colspan="2">Name: <span class="baby_name form-details">{{ $form['baby']->baby_name }}</span></td>
                <td>Date of Birth: <span class="baby_dob form-details">{{ $form['baby']->baby_dob }}</span></td>
            </tr>
            <tr>
                <td colspan="2">Birth Weight: <span class="weight form-details">{{ $form['baby']->weight }}</span></td>
                <td>Gestational Age: <span class="gestational_age form-details">{{ $form['baby']->gestational_age }}</span></td>
            </tr>
            <tr>
                <td colspan="4">
                    Main Reason for Referral: <span class="baby_reason form-details">{{ $form['baby']->baby_reason }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">Major Findings (Clinical and BP,Temp,Lab)
                    <br />
                    <span class="baby_major_findings form-details">{!! nl2br($form['baby']->baby_major_findings) !!}</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">Last (Breast) Feed (Time): <span class="baby_last_feed form-details">{{ $form['baby']->baby_last_feed }}</span></td>
            </tr>
            <tr class="bg-gray">
                <td colspan="4">Treatments Give Time</td>
            </tr>
            <tr>
                <td colspan="4">Before Referral: <span class="baby_before_treatment form-details">{{ $form['baby']->baby_before_treatment }}</span> - <span class="baby_before_given_time form-details">{{ $form['baby']->baby_before_given_time }}</span></td>
            </tr>
            <tr>
                <td colspan="4">During Transport: <span class="baby_during_transport form-details">{{ $form['baby']->baby_during_transport }}</span> - <span class="baby_transport_given_time form-details">{{ $form['baby']->baby_transport_given_time }}</span></td>
            </tr>
            <tr>
                <td colspan="4">Information Given to the Woman and Companion About the Reason for Referral
                    <br />
                    <span class="baby_information_given form-details">{!! $form['baby']->baby_information_given !!}</span>
                </td>
            </tr>
        </table>
    </div>
</div>

<table class="table table-striped col-sm-6"></table>
<div class="clearfix"></div>
<hr />
<button class="btn btn-default btn-flat" data-dismiss="modal" id="closeReferralForm{{$form['pregnant']->code}}"><i class="fa fa-times"></i> Close</button>
<div class="pull-right">
    @if(!($cur_status == 'referred' || $cur_status == 'redirected' || $cur_status == 'transferred' || $cur_status == 'rejected') && $form['pregnant']->department_id === 5 && $user->id == $form['pregnant']->md_referring_id)
        <button class="btn-sm bg-success btn-flat" id="telemedicine" onclick="openTelemedicine('{{ $form['pregnant']->tracking_id }}','{{ $form['pregnant']->code }}','{{ $form['pregnant']->action_md }}','{{ $form['pregnant']->referring_md }}');"><i class="fa fa-camera"></i> Telemedicine</button>
        <a href="{{ url('doctor/print/prescription').'/'.$id }}" target="_blank" type="button" style="color: black;" class="btn btn-sm bg-warning btn-flat" id="prescription"><i class="fa fa-file-zip-o"></i> Prescription</a>
    @endif
    @if(($cur_status == 'transferred' || $cur_status == 'referred' || $cur_status == 'redirected') && $user->id == $form['pregnant']->md_referring_id)
        <button class="btn btn-primary btn-flat button_option edit_form_btn" data-toggle="modal" data-target="#editReferralForm" data-id="{{ $id }}" data-type="pregnant" data-referral_status="{{ $referral_status }}"><i class="fa fa-edit"></i> Edit Form</button>
    @endif
    @if($cur_status == 'cancelled' && $user->id == $form['pregnant']->md_referring_id)
    <button class="btn btn-danger btn-flat button_option undo_cancel_btn" data-toggle="modal" data-target="#undoCancelModal" data-id="{{ $id }}"><i class="fa fa-times"></i> Undo Cancel</button>
    @endif
    @if($referral_status == 'referred' || $referral_status == 'redirected')
        @if(!$form['pregnant']->getAttribute('telemedicine'))
            <button class="btn btn-primary btn-flat queuebtn" data-toggle="modal" data-target="#queueModal" data-id="{{ $id }}"><i class="fa fa-pencil"></i> Update Queue </button>
            <button class="btn btn-info btn_call_request btn-flat btn-call button_option" data-toggle="modal" data-target="#sendCallRequest"><i class="fa fa-phone"></i> Call Request</button>
            <button class="btn btn-danger btn-flat button_option" data-toggle="modal" data-target="#rejectModal"><i class="fa fa-line-chart"></i> Recommend to Redirect</button>
        @endif
    <button class="btn btn-success btn-flat button_option" data-toggle="modal" data-target="#acceptFormModal"><i class="fa fa-check"></i> Accept</button>
    @endif
    <a href="{{ url('doctor/print/form').'/'.$form['pregnant']->tracking_id }}" target="_blank" class="btn-refer-pregnant btn btn-warning btn-flat"><i class="fa fa-print"></i> Print Form</a>
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
        var url = "<?php echo asset('api/video/call'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "tracking_id" : tracking_id,
            "code" : code,
            "action_md" : action_md,
            "referring_md" : referring_md,
            "trigger_by" : "{{ $user->id }}",
            "form_type" : "pregnant"
        };
        $.post(url,json,function(){

        });
        var windowName = 'NewWindow'; // Name of the new window
        var windowFeatures = 'width=600,height=400'; // Features for the new window (size, position, etc.)
        var newWindow = window.open("{{ asset('doctor/telemedicine?id=') }}"+tracking_id+"&code="+code+"&form_type=pregnant&referring_md=yes", windowName, windowFeatures);
        if (newWindow && newWindow.outerWidth) {
            // If the window was successfully opened, attempt to maximize it
            newWindow.moveTo(0, 0);
            newWindow.resizeTo(screen.availWidth, screen.availHeight);
        }
    }
</script>
