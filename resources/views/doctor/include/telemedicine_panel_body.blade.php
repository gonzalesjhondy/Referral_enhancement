<link href="{{ asset('public/css/telemedicine_panel.css?v=21') }}" rel="stylesheet">
<div class="panel-body panel-scoped-telemedicine">
    <?php
    $position = ["1st","2nd","3rd","4th","5th","6th","7th","8th","9th","10th","11th","12th"];
    $position_count = 0;
    $referred_track = \App\Activity::where("code",$row->code)->where("status","referred")->first();
    $queue_referred = \App\Activity::where('code',$row->code)->where('status','queued')->orderBy('id','desc')->first()->remarks;
    $referred_seen_track = \App\Seen::where("code",$referred_track->code)
        ->where("facility_id",$referred_track->referred_to)
        ->where("created_at",">=",$referred_track->created_at)
        ->exists();
    $referred_queued_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_to",$referred_track->referred_to)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","queued")
        ->exists();
    $referred_accepted_hold = \App\Activity::where("code",$referred_track->code)
        ->where("referred_to",$referred_track->referred_to)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","accepted");
    $referred_accepted_track = $referred_accepted_hold->exists();
    $referred_rejected_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_to",$referred_track->referred_to)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","rejected")
        ->exists();
    $referred_cancelled_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_to",$referred_track->referred_to)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","cancelled")
        ->exists();
    $referred_examined_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_from",$referred_track->referred_from)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","examined")
        ->exists();
    Session::put('referred_examined_track', $referred_examined_track);// I add this on 
    $referred_prescription_hold = \App\Activity::where("code",$referred_track->code)
        ->where("referred_from",$referred_track->referred_from)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","prescription");
    $referred_prescription_track = $referred_prescription_hold->exists();
    $referred_upward_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_from",$referred_track->referred_from)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","upward")
        ->exists();
    $referred_redirected_track = \App\Activity::where("code",$referred_track->code)
        ->where("status","redirected")
        ->exists();
    $referred_treated_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_from",$referred_track->referred_from)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","treated")
        ->exists();
    $referred_followup_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_from",$referred_track->referred_from)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","followup")
        ->exists();
    $referred_end_track = \App\Activity::where("code",$referred_track->code)
        ->where("referred_from",$referred_track->referred_from)
        ->where("created_at",">=",$referred_track->created_at)
        ->where("status","end")
        ->exists();
    $redirected_track = \App\Activity::where("code",$row->code)
        ->where(function($query) {
            $query->where("status","redirected")
                ->orWhere("status","transferred");
        })
        ->get();
    $followup_track = \App\Activity::where("code",$row->code)
        ->where("status","followup")
        ->get();
    $lab_request = \App\LabRequest::where("activity_id",$referred_track->id)
        ->first(); // I am adding this condition for error messages of lab result icon

    //reset the variable in followup if followup not exist
    $followup_queued_track = 0;
    $followup_accepted_track = 0;
    $followup_rejected_track = 0;
    $followup_cancelled_track = 0;
    $followup_examined_track = 0;
    $followup_upward_track = 0;
    $followup_admitted_track = 0;
    $followup_discharged_track = 0;
    //end reset

    //reset the variable in redirected if redirected not exist
    $redirected_queued_track = 0;
    $redirected_accepted_track = 0;
    $redirected_rejected_track = 0;
    $redirected_cancelled_track = 0;
    $redirected_examined_track = 0;
    $redirected_upward_track = 0;
    $redirected_admitted_track = 0;
    $redirected_discharged_track = 0;
    //end reset
    ?>
    <small class="label position-blue">{{ $position[$position_count].' appointment - '.\App\Facility::find($referred_track->referred_to)->name }}</small><br>
    <div class="stepper-wrapper">
        <div class="stepper-item completed">
            <div class="step-counter"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            <div class="step-name">Appointment</div>
        </div>
        <div class="stepper-item @if($referred_seen_track || $referred_accepted_track || $referred_rejected_track) completed @endif" id="seen_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter"><i class="fa fa-eye" aria-hidden="true"></i></div>
            <div class="step-name">Seen</div>
        </div>
        <div class="text-center stepper-item @if($referred_accepted_track) completed @endif" data-actionmd="" id="accepted_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter
            <?php
                if($referred_cancelled_track && !$referred_accepted_track)
                    echo "bg-yellow";
                elseif($referred_rejected_track)
                    echo "bg-red";
                elseif($referred_queued_track && !$referred_accepted_track)
                    echo "bg-orange";
            ?>
            "
             id="rejected_progress{{ $referred_track->code.$referred_track->id }}"
            ><div id="queue_number{{ $referred_track->code.$referred_track->id }}">
                <?php
                    if($referred_rejected_track)
                        echo'<i class="fa fa-thumbs-down" aria-hidden="true" style="font-size:15px;"></i>';
                    elseif($referred_cancelled_track && !$referred_accepted_track)
                        echo'<i class="fa fa-times" aria-hidden="true" style="font-size:15px;"></i>' ;      
                    elseif($referred_queued_track && !$referred_accepted_track)
                        echo '<i class="fa fa-hourglass-half" aria-hidden="true" style="font-size:15px;"></i>';
                    else
                        echo'<i class="fa fa-thumbs-up" aria-hidden="true" style="font-size:15px;"></i>';
                ?>
                </div>
            </div>
            
            <div class="text-center step-name" id="rejected_name{{ $referred_track->code.$referred_track->id }}">
                <?php
                if($referred_cancelled_track && !$referred_accepted_track)
                    echo 'Cancelled';
                elseif($referred_rejected_track)
                    echo 'Declined';
                elseif($referred_queued_track && !$referred_accepted_track)
                    echo 'Queued at <br> <b>'. $queue_referred.'</b>';
                else
                    echo 'Accepted'
                ?>
            </div>
        </div>
        <div class="stepper-item @if($referred_examined_track) completed @endif" id="examined_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter step-counter-examined" onclick="telemedicineExamined('{{ $row->id }}', '{{ $referred_track->code }}', '{{ $referred_accepted_hold->first()->action_md }}', '{{ $referred_track->referring_md }}', '{{ $referred_track->id }}', '{{ $row->type }}', '{{ $referred_track->referred_to }}','{{$referred_treated_track}}','{{$referred_redirected_track}}','{{$referred_upward_track}}','{{$referred_followup_track}}')"><i class="fa fa-building" aria-hidden="true"></i></div>
            <div class="step-name">Consultation</div>
        </div>

        <div class="stepper-item stepper-item-prescription @if($referred_prescription_track) completed @endif" id="prescribed_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter step-counter-prescription popoverTelemedicine" 
                data-toggle="popover" 
                data-placement="top" 
                title='Generate PDF<button type="button" class="close" onclick="closePopover();">×</button>'
                data-content='<a class="btn btn-app" onclick="telemedicinePrescription(`{{ $row->id }}`,
                    `{{ $referred_prescription_hold->first()->id }}`,
                    `{{ $referred_track->code }}`,
                    `{{ $referred_track->id }}`)" >
                    <i class="fa fa-file-text-o"></i> Prescription
                    </a>&nbsp;&nbsp;
                    <a class="btn btn-app" onclick="telemedicineLabResult(`{{ $referred_track->id }}`, `{{$lab_request->laboratory_code}}`)">
                        <i class="fa fa-building-o"></i> Lab Result
                        </a>'>
                <i class="fa fa-home" aria-hidden="true"></i>
            </div>
            <div class="step-name" style="margin-right:10px;">Disposition</div>
        </div>       
 
 <!--  original code-->   {{--<div class="stepper-item-upward @if($referred_upward_track && !$referred_treated_track) completed @endif" id="upward_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter"><i class="fa fa-caret-up" aria-hidden="true" style="font-size:25px"></i></div>
            <div class="step-name">Upward</div> --}}<!--  end of original code-->
<!-- jondy changes code -->
        <div class="stepper-item-upward @if($referred_upward_track && !$referred_treated_track && !$referred_followup_track) completed @endif" id="upward_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter"><i class="fa fa-caret-up" aria-hidden="true" style="font-size:25px"></i></div>
            <div class="step-name">Transfer</div> <!--end of upward changes-->

 <!--original code follow up--> {{-- <div class="stepper-item stepper-item-follow_new @if($referred_followup_track && !$referred_rejected_track) completed @endif" id="departed_progress{{ $referred_track->code.$referred_track->id }}">
                <div class="step-counter-follow_new" onclick="telemedicineFollowUpPatient('{{ $referred_redirected_track }}','{{ $referred_end_track }}','{{ $referred_examined_track }}','{{ $referred_followup_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}')"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                <div class="step-name step-name-treated_new">Follow Up</div>
            </div> --}} <!--end of original code-->


            <!-- my changes to follow up -->
            <div class="stepper-item stepper-item-follow_new @if($referred_followup_track && !$referred_rejected_track) completed @endif" id="departed_progress{{ $referred_track->code.$referred_track->id }}">
                <div class="step-counter-follow_new" onclick="telemedicineFollowUpPatient('{{ $referred_redirected_track }}','{{ $referred_end_track }}','{{ $referred_examined_track }}','{{ $referred_followup_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}','{{$referred_treated_track}}','{{$referred_upward_track}}')"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                <div class="step-name step-name-treated_new">Follow Up</div>
            </div><!--  end -->

            <!--Original code treated-->
            {{--<div class="stepper-item stepper-item-treated_new @if($referred_end_track && !$referred_followup_track) completed @endif" id="treated_progress{{ $referred_track->code.$referred_track->id }}">
                <div class="step-counter-treated_new" onclick="telemedicineTreatedPatient('{{ $referred_upward_track }}','{{ $referred_examined_track }}','{{ $referred_treated_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}')"><i class="fa fa-heart" aria-hidden="true"></i></div>
                <div class="step-name step-name-treated_new">Treated</div>
            </div> --}}<!-- end -->


            <!-- my changes to treated -->
                <div class="stepper-item stepper-item-treated_new @if($referred_treated_track && !$referred_followup_track) completed @endif" id="treated_progress{{ $referred_track->code.$referred_track->id }}">
                    <div class="step-counter-treated_new" onclick="telemedicineTreatedPatient('{{ $referred_upward_track }}','{{ $referred_examined_track }}','{{ $referred_treated_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}','{{$referred_followup_track}}')"><i class="fa fa-heart" aria-hidden="true"></i></div>
                    <div class="step-name step-name-treated_new">Treated</div>
                </div>
            <!--  end -->
        </div>
       

        <div class="stepper-item stepper-item-referred @if($referred_redirected_track && $referred_upward_track && !$referred_treated_track && !$referred_followup_track ) completed @endif" id="departed_progress{{ $referred_track->code.$referred_track->id }}">
            <div class="step-counter step-counter-referred" onclick="telemedicineReferPatient('{{ $referred_redirected_track }}','{{ $referred_followup_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}')"><i class="fa fa-share" aria-hidden="true"></i></div>
            <div class="step-name">Referred</div>
            {{-- <div class="stepper-item stepper-item-follow @if($referred_followup_track && !$referred_rejected_track) completed @endif" id="departed_progress{{ $referred_track->code.$referred_track->id }}">
                <div class="step-counter-follow" onclick="telemedicineFollowUpPatient('{{ $referred_redirected_track }}','{{ $referred_end_track }}','{{ $referred_examined_track }}','{{ $referred_followup_track }}','{{ $referred_treated_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}')"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                <div class="step-name">Follow Up</div>
            </div> --}}
            {{-- <div class="stepper-item stepper-item-end @if($referred_end_track && !$referred_followup_track) completed @endif" id="departed_progress{{ $referred_track->code.$referred_track->id }}">
                <div class="step-counter-end" onclick="telemedicineEndPatient('{{ $referred_treated_track }}','{{ $referred_redirected_track }}','{{ $referred_followup_track }}','{{ $referred_end_track }}','{{ $referred_track->code }}','{{ $referred_track->id }}')">7</div>
                <div class="step-name step-name-end">Ended</div>
            </div> --}}
        </div>
       
    </div>
    @if(count($followup_track) > 0)
        @foreach($followup_track as $follow_track)
            <?php
            $queue_follow = \App\Activity::where('code',$follow_track->code)->where('status','queued')->orderBy('id','desc')->first()->remarks;
            $position_count++;
            $follow_seen_track = \App\Seen::where("code",$follow_track->code)
                ->where("facility_id",$follow_track->referred_to)
                ->where("created_at",">=",$follow_track->created_at)
                ->exists();
            $follow_queued_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_to",$follow_track->referred_to)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","queued")
                ->exists();
            $follow_accepted_hold = \App\Activity::where("code",$follow_track->code)
                ->where("referred_to",$follow_track->referred_to)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","accepted");
            $follow_accepted_track = $follow_accepted_hold->exists();
            $follow_rejected_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_to",$follow_track->referred_to)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","rejected")
                ->exists();
            $follow_cancelled_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_to",$follow_track->referred_to)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","cancelled")
                ->exists();
            $follow_examined_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_from",$follow_track->referred_from)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","examined")
                ->exists();
            $follow_prescription_hold = \App\Activity::where("code",$follow_track->code)
                ->where("referred_from",$follow_track->referred_from)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","prescription");
            $follow_prescription_track = $follow_prescription_hold->exists();
            $follow_upward_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_from",$follow_track->referred_from)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","upward")
                ->exists();
            $follow_redirected_track = \App\Activity::where("code",$follow_track->code)
                ->where("status","redirected")
                ->exists();
            $follow_treated_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_from",$follow_track->referred_from)
                ->where("created_at",">=",$follow_track->created_at)
                ->where("status","treated")
                ->exists();
            $follow_followup_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_from",$follow_track->referred_from)
                ->where("created_at",">",$follow_track->created_at)
                ->where("status","followup")
                ->exists();
            $follow_end_track = \App\Activity::where("code",$follow_track->code)
                ->where("referred_from",$follow_track->referred_from)
                ->where("created_at",">",$follow_track->created_at)
                ->where("status","end")
                ->exists();
            $lab_request = \App\LabRequest::where("activity_id",$follow_track->id)
                ->first(); // I am adding this condition for error messages of lab result icon
                
            ?>
            <small class="label position-blue">{{ $position[$position_count].' appointment - '.\App\Facility::find($follow_track->referred_to)->name }}</small><br>
            <div class="stepper-wrapper">
                <div class="stepper-item completed">
                    <div class="step-counter"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                    <div class="step-name">Appointment</div>
                </div>
                <div class="stepper-item @if($follow_seen_track || $follow_accepted_track || $follow_rejected_track) completed @endif" id="seen_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter"><i class="fa fa-eye" aria-hidden="true"></i></div>
                    <div class="step-name">Seen</div>
                </div>
                <div class="text-center stepper-item @if($follow_accepted_track || $follow_rejected_track) completed @endif" data-actionmd="" id="accepted_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter
                    
                        <?php
                            if($follow_cancelled_track && !$follow_accepted_track)
                                echo "bg-yellow";
                            elseif($follow_rejected_track)
                                echo "bg-red";
                            elseif($follow_queued_track && !$follow_accepted_track)
                                echo "bg-orange";
                        ?>"
                     
                        id="rejected_progress{{ $follow_track->code.$follow_track->id }}">
                        <div id="follow_queue_number{{ $follow_track->code.$follow_track->id }}">
                            <?php
                                if($follow_cancelled_track && !$follow_accepted_track)
                                    echo '<i class="fa fa-times" aria-hidden="true" style="font-size:15px;"></i>';
                                elseif($follow_rejected_track)
                                    echo '<i class="fa fa-thumbs-down" aria-hidden="true" style="font-size:15px;"></i>';
                                elseif($follow_queued_track && !$follow_accepted_track)
                                    echo '<i class="fa fa-hourglass-half" aria-hidden="true" style="font-size:15px;"></i>';
                                else
                                    echo '<i class="fa fa-thumbs-up" aria-hidden="true" style="font-size:15px;"></i>'
                            ?>

                        </div>
                    </div>
                  
                    <div class="text-center step-name" id="rejected_name{{ $follow_track->code.$follow_track->id }}">
                    <?php
                        if($follow_cancelled_track && !$follow_accepted_track)
                            echo 'Cancelled';
                        elseif($follow_rejected_track)
                            echo 'Declined';
                        elseif($follow_queued_track && !$follow_accepted_track)
                            echo 'Queued at <br> <b>'. $queue_referred.'</b>';
                        else
                            echo 'Accepted'
                    ?>
                    </div>
                </div>
                <div class="stepper-item @if($follow_examined_track) completed @endif" id="examined_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter step-counter-examined" onclick="telemedicineExamined('{{ $row->id }}', '{{ $follow_track->code }}', '{{ $follow_accepted_hold->first()->action_md }}', '{{ $follow_track->referring_md }}', '{{ $follow_track->id }}', '{{ $row->type }}', '{{ $follow_track->referred_to }}','{{$follow_treated_track}}','{{$follow_redirected_track}}','{{$follow_upward_track}}','{{$follow_followup_track}}')"><i class="fa fa-building" aria-hidden="true"></i></div>
                    <div class="step-name">Consultation</div>
                </div>
                
                <div class="stepper-item stepper-item-prescription @if($follow_examined_track || $follow_prescription_track) completed @endif" id="prescribed_progress{{ $follow_track->code.$follow_track->id }}" id="lab_progress{{$lab_request->requested_by}}">
                    <div class="step-counter step-counter-prescription popoverTelemedicine"
                    data-toggle="popover"
                    data-placement="top"
                    title='Generate PDF<button type="button" class="close" onclick="closePopover();">×</button>'
                    data-content='<a class="btn btn-app" onclick="telemedicinePrescription(`{{$row->id}}`,
                    `{{ $follow_prescription_hold->first()->id }}`,
                    `{{ $follow_track->code }}`,     
                    `{{ $follow_track->id }}`)" >
                    <i class="fa fa-file-text-o"></i> Prescription
                    </a>&nbsp;&nbsp;
                    <a class="btn btn-app" onclick="telemedicineLabResult(`{{ $follow_track->id }}`,`{{ $lab_request->laboratory_code}}`,`{{$lab_request->requested_by}}`)">
                    <input type="hidden" id="user_request" name="user" value="">    
                    <i class="fa fa-building-o"></i> Lab Result
                    </a>'>
                    <i class="fa fa-home" aria-hidden="true"></i>
                </div>
                    <div class="step-name" style="margin-right:10px;">Disposition</div>
            </div>

<!--Original code -->{{-- <div class="stepper-item-upward @if($follow_upward_track) completed @endif" id="upward_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter"><i class="fa fa-caret-up" aria-hidden="true" style="font-size:25px"></i></div>
                    <div class="step-name">Upward</div>--}} <!-- end of original code-->

                <!-- jondy cahanges in upward -->
                <div class="stepper-item-upward @if($follow_upward_track && !$follow_followup_track) completed @endif" id="upward_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter"><i class="fa fa-caret-up" aria-hidden="true" style="font-size:25px"></i></div>
                    <div class="step-name">Transfer</div>
                <!-- end of changes -->
                   
<!--Original code--> {{--<div class="stepper-item stepper-item-follow_new @if($follow_followup_track && !$follow_rejected_track) completed @endif" id="departed_progress{{ $follow_track->code.$follow_track->id }}">
                        <div class="step-counter-follow_new" onclick="telemedicineFollowUpPatient('{{ $follow_redirected_track }}','{{ $follow_end_track }}','{{ $follow_examined_track }}','{{ $follow_followup_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}')"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                        <div class="step-name">Follow Up</div>
                    </div>--}} <!--end original code -->

                    <!-- jondy changes code -->
                   <div class="stepper-item stepper-item-follow_new @if($follow_followup_track && !$follow_rejected_track) completed @endif" id="departed_progress{{ $follow_track->code.$follow_track->id }}">
                        <div class="step-counter-follow_new" onclick="telemedicineFollowUpPatient('{{ $follow_redirected_track }}','{{ $follow_end_track }}','{{ $follow_examined_track }}','{{ $follow_followup_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}','{{$follow_treated_track}}','{{$follow_upward_track}}')"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                        <div class="step-name">Follow Up</div>
                    </div>
                    <!-- end changes -->
        
<!--original code -->{{--<div class="stepper-item stepper-item-treated_new @if($follow_treated_track) completed @endif" id="treated_progress{{ $follow_track->code.$follow_track->id }}">
                        <div class="step-counter-treated_new" onclick="telemedicineTreatedPatient('{{ $follow_upward_track }}','{{ $follow_examined_track }}','{{ $follow_treated_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}')"><i class="fa fa-heart" aria-hidden="true"></i></div>
                        <div class="step-name step-name-treated_new">Treated</div>
                    </div>--}}<!--end original code -->


                    <!-- jondy changes in treated -->
                    <div class="stepper-item stepper-item-treated_new @if($follow_treated_track && !$follow_followup_track && !$follow_upward_track) completed @endif" id="treated_progress{{ $follow_track->code.$follow_track->id }}">
                        <div class="step-counter-treated_new" onclick="telemedicineTreatedPatient('{{ $follow_upward_track }}','{{ $follow_examined_track }}','{{ $follow_treated_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}','{{$follow_followup_track}}')"><i class="fa fa-heart" aria-hidden="true"></i></div>
                        <div class="step-name step-name-treated_new">Treated</div>
                    </div>
                    <!-- end of changes treated-->
                </div>
<!-- original code -->{{--<div class="stepper-item stepper-item-referred @if($follow_redirected_track) completed @endif" id="departed_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter step-counter-referred" onclick="telemedicineReferPatient('{{ $follow_upward_track }}','{{ $follow_redirected_track }}','{{ $follow_followup_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}')"><i class="fa fa-share" aria-hidden="true"></i></div>
                    <div class="step-name">Referred</div>--}} <!-- endoriginal code -->
            <!-- jondy changes -->
                <div class="stepper-item stepper-item-referred @if($follow_redirected_track && $follow_upward_track && !$follow_treated_track && !$follow_followup_track) completed @endif" id="departed_progress{{ $follow_track->code.$follow_track->id }}">
                    <div class="step-counter step-counter-referred" onclick="telemedicineReferPatient('{{ $follow_redirected_track }}','{{ $follow_followup_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}')"><i class="fa fa-share" aria-hidden="true"></i></div>
                    <div class="step-name">Referred</div>  <!--end jondy changes -->
                    {{-- <div class="stepper-item stepper-item-follow @if($follow_followup_track && !$follow_rejected_track) completed @endif" id="departed_progress{{ $follow_track->code.$follow_track->id }}">
                        <div class="step-counter-follow" onclick="telemedicineFollowUpPatient('{{ $follow_redirected_track }}','{{ $follow_end_track }}','{{ $follow_examined_track }}','{{ $follow_followup_track }}','{{ $follow_treated_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}')"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
                        <div class="step-name">Follow Up</div>
                    </div> --}}
                    {{-- <div class="stepper-item stepper-item-end @if($follow_end_track) completed @endif" id="end_progress{{ $follow_track->code.$follow_track->id }}">
                        <div class="step-counter-end" onclick="telemedicineEndPatient('{{ $follow_treated_track }}','{{ $follow_redirected_track }}','{{ $follow_followup_track }}','{{ $follow_end_track }}','{{ $follow_track->code }}','{{ $follow_track->id }}')">7</div>
                        <div class="step-name step-name-end">Ended</div>
                    </div> --}}
                </div>
            </div>
        <!-- my changes in file upload -->
        <div class="stepper-wrapper">
             
                    <?php
                    // My changes in file Display
                    $referredActivities = $user->activities()
                        ->where('code', $follow_track->code) 
                        ->where('id', $referred_track->id)
                        ->get();
                    
                    $followActivities = $user->activities()
                        ->where('code', $follow_track->code)
                        ->where("status","followup")
                        ->get();  
                    // dd($referredActivities, $followActivities);
                    ?>
                    <?php $pdfFiles = []; ?>
                    <?php $imageFiles = []; ?>
                    @foreach ($position as $index => $pos)
                        @if ( $index== 1)
                            <?php $referredFiles = []; ?>
                            @foreach ($referredActivities as $referredActivity)
                                <?php
                                $fileNames = explode('|', $referredActivity->lab_result);
                                $referredFiles = array_merge($referredFiles, $fileNames);
                                $activity_id = $referredActivity->id;
                                $activity_code = $referredActivity->code;
                                foreach($fileNames as $filename){
                                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                    if (in_array($extension, ['pdf'])){
                                        $pdfFiles[] = $filename;                                            
                                    }elseif (in_array($extension, ['JPG','JPEG','PNG','jpg', 'jpeg', 'png','webp','jfif'])){
                                        $imageFiles[] = $filename;
                                    }
                                }
                                ?>
                            @endforeach
                            <?php $sortedFiles = array_merge($pdfFiles, $imageFiles); 
                                $jsonsortedFiles = json_encode($sortedFiles);
                            ?> 
                            <!-- @if ($pos == $position[$position_count]) -->
                           {{-- @foreach ($sortedFiles as $referredFile)
                                <a href="javascript:void(0);" class="d-file" onclick="openFileViewer('{{$index}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}', '{{ $referredFile }}', '{{$referredActivities}}')">
                                <!-- <img src="path_to_icon_based_on_filetype" class="file-icon">{{ $referredFile }}  -->
                                @if(ends_with($referredFile, '.pdf'))
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;{{$referredFile}}
                                @else
                                    <i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp;{{$referredFile}}
                                @endif
                                </a>&nbsp;
                            @endforeach --}}
                            @if(empty($sortedFiles))
                                <a href="javascript:void(0);" onclick="addfilesInFollowupIfempty('{{$index}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}','{{$referredFile}}','{{$referredActivities}}')">
                                    <div class="file-wrapper-icon">
                                        <img src="../public/fileupload/add_folder.ico"/><br>
                                        <label class="file-Icon-label">Add File</label>
                                    </div>
                                </a>
                            @else
                            <!-- <a href="javascript:void(0);" onclick="FileFolder('{{$index}}','{{$jsonsortedFiles}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}','{{ $referredFile }}', '{{$referredActivities}}')">
                            <i class="fa fa-folder folder-icon" style="color:#FFE68C;font-size: 30px; cursor:pointer;" data-toggle="modal" data-target="#folderModal"></i></a> -->
                                <a href="javascript:void(0);" onclick="FileFolder('{{$index}}','{{$jsonsortedFiles}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}','{{ $referredFile }}', '{{$referredActivities}}')">
                                    <div class="file-wrapper-icon">
                                        <img src="../public/fileupload/icon_checked_folder.ico"/><br>
                                        <label class="file-Icon-label">File upload</label>
                                    </div>
                                </a>  
                            @endif
                        <!-- @endif -->
                        @elseif ($index >= 2)
                            <?php $pdfFiles_follow = []; ?>
                            <?php $imageFiles_follow = []; ?>
                            <?php $followFiles = []; ?>
                            @if (isset($followActivities[$index - 2]))
                                <?php
                                $followActivity = $followActivities[$index - 2];
                                $fileNames = explode('|', $followActivity->lab_result);
                                $followFiles = array_merge($followFiles, $fileNames);
                                $follow_id   = $followActivity->id;

                                foreach($fileNames as $filename){
                                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                                    if (in_array($extension, ['pdf'])){
                                        $pdfFiles_follow[] = $filename;                                            
                                    }elseif (in_array($extension, ['JPG','JPEG','PNG','jpg', 'jpeg', 'png','webp','jfif'])){
                                        $imageFiles_follow[] = $filename;
                                    }
                                }
                                
                                ?>
                            @endif
                                <?php $sortedFiles_follow = array_merge($pdfFiles_follow, $imageFiles_follow) ?>
                                <?php $sortedFilesFollow = json_encode($sortedFiles_follow); ?>
                                <?php  $allfiles = implode('|', array_map('/',$imageFiles_follow));?>
                            @if ($pos == $position[$position_count])
                                    {{--@foreach ($sortedFiles_follow as $followFile)   
                                  
                                    <a href="javascript:void(0);" class="d-file" onclick="openFileViewer('{{$index}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}', '{{ $followFile }}', '{{$followActivity}}')">
                                        <!-- <img src="path_to_icon_based_on_filetype" class="file-icon">{{ $referredFile }}  -->
                                        @if(ends_with($followFile, '.pdf'))
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;{{$followFile}} 
                                        @else
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>&nbsp; {{$followFile}}
                                        @endif
                                      
                                    </a>&nbsp;
                                    @endforeach --}}
                                    @if(empty($sortedFiles_follow))
                                        <a href="#"  onclick="addfilesInFollowupIfempty('{{$index}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}','{{$followFile}}')">
                                            <div class="file-wrapper-icon">
                                                <img src="../public/fileupload/add_folder.ico"/><br>
                                                <label class="file-Icon-label">Add File</label>
                                            </div>
                                        </a>&nbsp;
                                   @else 
                                        <a href="javascript:void(0);" onclick="FileFolder('{{$index}}','{{$sortedFilesFollow}}','{{$activity_code}}','{{$activity_id}}','{{$follow_id}}','{{ asset('public/fileupload/' . $user->username . '/') }}','{{ $followFile }}', '{{$followActivity}}')">
                                            <div class="file-wrapper-icon">
                                                <img src="../public/fileupload/icon_checked_folder.ico"/><br>
                                                <label class="file-Icon-label">File upload</label>
                                            </div>
                                        </a>
                                    @endif  
                            @endif
                        @endif
                    @endforeach
                <!--   // End of  My changes in file Display -->
            </div>
            <div id="modalContainer"></div>              
        <!-- end of my changes in display file upload -->
        @endforeach
    @endif

    @if(count($redirected_track) > 0)
        @foreach($redirected_track as $redirect_track)
            <?php
            $queue_redirected = \App\Activity::where('code',$redirect_track->code)->where('status','queued')->orderBy('id','desc')->first()->remarks;
            $position_count++;
            $redirected_seen_track = \App\Seen::where("code",$redirect_track->code)
                ->where("facility_id",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->exists();
            $redirected_queued_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_to",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","queued")
                ->exists();
            $redirected_accepted_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_to",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","accepted")
                ->exists();
            $redirected_rejected_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_to",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","rejected")
                ->exists();
            $redirected_cancelled_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_to",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","cancelled")
                ->exists();    
            $redirected_travel_track = \App\Activity::where("code",$redirect_track->code)
                // ->where("referred_to",$redirect_track->referred_from) // I remove this para mo highlight ang depart
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","travel")
                ->exists();
            $redirected_arrived_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_from",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","arrived")
                ->exists();
            $redirected_notarrived_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_from",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","archived")
                ->exists();
            $redirected_admitted_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_from",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","admitted")
                ->exists();
            $redirected_discharged_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_from",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","discharged")
                ->exists();
            
            $redirected_transferred_track = \App\Activity::where("code",$redirect_track->code)
                ->where("referred_from",$redirect_track->referred_to)
                ->where("created_at",">=",$redirect_track->created_at)
                ->where("status","transferred")
                ->exists();
            ?>
            <!-- Start changes -->
            <small class="label position-blue">{{ $position[$position_count].' position - '.\App\Facility::find($redirect_track->referred_to)->name }}</small><br>
            <div class="stepper-wrapper">
                <div class="stepper-item completed">
                    <div class="step-counter"><i class="fa fa-share" aria-hidden="true"></i></div>
                    <div class="step-name">{{ count($redirected_track) > 1 ? 'Redirected' : 'Referred' }}</div>
                </div>
                <div class="stepper-item @if($redirected_seen_track || $redirected_accepted_track || $redirected_rejected_track) completed @endif" id="seen_progress{{ $redirect_track->code.$redirect_track->id }}">
                    <div class="step-counter"><i class="fa fa-eye" aria-hidden="true"></i></div>
                    <div class="step-name">Seen</div>
                </div>
                <!----------------my changes jondy--------------->
                <div class="stepper-item @if($redirected_accepted_track || $redirected_rejected_track || $redirected_cancelled_track) completed @endif" id="accepted_progress{{ $redirect_track->code.$redirect_track->id }}">
                    <div class="step-counter
                    <?php
                            if($redirected_rejected_track)
                                echo "bg-red";
                            elseif($redirected_cancelled_track)
                                echo "bg-yellow";
                            elseif($redirected_queued_track && !$redirected_accepted_track)
                                echo "bg-orange";
                    ?>
                    " id="rejected_progress{{ $redirect_track->code.$redirect_track->id }}">
                        <div id="icon_progress{{ $redirect_track->code.$redirect_track->id }}">
                            <?php
                                if($redirected_rejected_track)
                                    echo'<i class="fa fa-thumbs-down" aria-hidden="true" style="font-size:15px;"></i>';
                                elseif($redirected_cancelled_track)
                                    echo'<i class="fa fa-times" aria-hidden="true" style="font-size:15px;"></i>' ;      
                                elseif($redirected_queued_track && !$redirected_accepted_track)
                                    echo '<i class="fa fa-hourglass-half" aria-hidden="true" style="font-size:15px;"></i>';
                                else
                                    echo'<i class="fa fa-thumbs-up" aria-hidden="true" style="font-size:15px;"></i>';
                            ?>
                        </div>
                    </div>
                    <div class="step-name text-center" id="rejected_name{{ $redirect_track->code.$redirect_track->id }}"><?php
                        if($redirected_rejected_track)
                            echo 'Declined';
                        elseif($redirected_cancelled_track)
                            echo 'Cancelled';
                        elseif($redirected_queued_track && !$redirected_accepted_track)
                            echo "Queued at <br><b>".$queue_redirected."</b>";
                        else
                            echo "Accepted"
                        ?>
                    </div>
                </div>
                <!----------------my changes jondy--------------->
                <div class="stepper-item @if( ($redirected_travel_track || $redirected_arrived_track || $redirected_notarrived_track) && !$redirected_rejected_track && !$redirected_cancelled_track ) completed @endif" id="departed_progress{{ $redirect_track->code.$redirect_track->id }}">
                    <div class="step-counter"><i class="fa fa-paper-plane fa-rotate-90" aria-hidden="true"></i></div>
                    <div class="step-name">Departed</div>
                </div>
         
                <!----------------my changes jondy--------------->
                <div class="stepper-item @if($redirected_arrived_track && !$redirected_rejected_track && !$redirected_cancelled_track ) completed @endif" id="arrived_progress{{ $redirect_track->code.$redirect_track->id }}">
                    <div class="step-counter {{ $redirected_notarrived_track && !$redirected_arrived_track && !$redirected_rejected_track ? 'bg-red' : '' }}" id="notarrived_progress{{ $redirect_track->code.$redirect_track->id }}">{!! $redirected_notarrived_track && !$redirected_arrived_track && !$redirected_rejected_track && !$redirected_cancelled_track? '<i class="fa fa-ambulance" aria-hidden="true" style="font-size: 15px;"></i>&nbsp;<i class="fa fa-cloud" aria-hidden="true" style="font-size: 10px;"></i>' :
                         '<i class="fa fa-ambulance" aria-hidden="true" style="font-size: 15px"></i>' !!}</div>
                  
                    @if($redirected_notarrived_track && !$redirected_arrived_track && !$redirected_rejected_track && !$redirected_cancelled_track)
                        <div class="step-name not_arrived">Not Arrived</div>
                    @else
                        <div class="step-name" id="arrived_name{{ $redirect_track->code.$redirect_track->id }}">Arrived</div>
                    @endif
                </div>
                <!----------------my changes jondy--------------->
                <div class="stepper-item @if(($redirected_admitted_track || $redirected_discharged_track) && !$redirected_cancelled_track ) completed @endif" id="admitted_progress{{ $redirect_track->code.$redirect_track->id }}">
                    <div class="step-counter"><i class="fa fa-bed" aria-hidden="true" style="font-size: 15px;"></i></div>
                    <div class="step-name">Admitted</div>
                </div>
                <div class="stepper-item @if($redirected_discharged_track && !$redirected_transferred_track) completed @endif" id="discharged_progress{{ $redirect_track->code.$redirect_track->id }}">
                    <div class="step-counter"><i class="fa fa-clipboard" aria-hidden="true" style="font-size: 15px;"></i><i class="fa fa-check" style="font-size: 15px; color: blue;"></i></div>
                    <div class="step-name">Discharged</div>
                </div>
            </div>
            <!-- End of changes -->
        @endforeach
    @endif
    @if(count($activities) > 0)
        <?php $first = 0;
        $latest_act = \App\Activity::where('code',$row->code)->latest('created_at')->first();
        ?>
        <div class="row">
            <div class="tracking col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped" style="font-size: 9pt;">
                        <thead class="prepend_from_firebase{{ $row->code }}" id="prepend_from_websocket{{ $row->code }}"></thead>
                        @foreach($activities as $act)
                            <?php
                            $act_name = \App\Patients::find($act->patient_id);
                            $old_facility_data = \App\Facility::find($act->referred_from);
                            $old_facility = $old_facility_data->name;
                            $old_facility_id = $old_facility_data->id;
                            if($act->status=='transferred' || $act->status=='redirected'|| $act->status=='referred' || $act->status=='calling'){
                                $act_icon = 'fa-ambulance';
                            }

                            $new_facility = 'N/A';
                            $tmp_new = \App\Facility::find($act->referred_to);

                            if($act->referred_to==0)
                            {
                                $tmp_new = \App\Facility::find($act->referred_from);
                            }

                            if($tmp_new){
                                $new_facility = $tmp_new->name;
                            }

                            ?>
                            @if($act->status=='rejected')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtDoctor">Dr. {{ $act->md_name }}</span> of <span class="txtHospital">{{ $act->fac_rejected }}</span> recommended to redirect <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span> to other facility.
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                        <br />
                                        @if($user->facility_id==$act->referred_from && $latest_act->status=='rejected')
                                            <button class="btn btn-success btn-xs btn-redirected" onclick="consultToOtherFacilities('{{ $act->code }}')">
                                                <i class="fa fa-camera"></i> Consult other facilities<br>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($act->status=='referred' || $act->status=='redirected')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($act->referring_md_id!=0)
                                            <?php
                                            if($old_facility_id == 63)
                                                $referred_md = $act->referring_md;
                                            else
                                                $referred_md = 'Dr. '.$act->referring_md;
                                            ?>
                                            <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span>  was {{ count($redirected_track) > 1 ? 'redirected' : 'referred' }} by <span class="txtDoctor">{{ $referred_md }}</span> of <span class="txtHospital">{{ $old_facility }}</span> to <span class="txtHospital">{{ $new_facility }}.</span>
                                            @if($act->remarks)
                                                <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                            @endif
                                        @else
                                            <strong>Walk-In Patient:</strong> <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($act->status=='transferred')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span>  was {{ $act->status }} by <span class="txtDoctor">Dr. {{ $act->md_name }}</span> of <span class="txtHospital">{{ $old_facility }}</span> to <span class="txtHospital">{{ $new_facility }}.</span>
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='calling')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtDoctor">Dr. {{ $act->md_name }}</span> of <span class="txtHospital">{{ $new_facility }}</span> is requesting a call from <span class="txtHospital">{{ $old_facility }}</span>.
                                        @if($user->facility_id==$act->referred_from)
                                            Please contact this number <span class="txtInfo">({{ $act->contact }})</span> .
                                        @endif
                                    </td>
                                </tr>
                            @elseif($act->status=='accepted' || $act->status=='examined' || $act->status=='treated' || $act->status=='upward' || $act->status=='followup')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span>  was {{ $act->status }} by <span class="txtDoctor">Dr. {{ $act->md_name }}</span> of <span class="txtHospital">{{ $new_facility }}</span>.
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='arrived')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->created_at)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->created_at)) }}
                                        </div>
                                        <div  class="time-small">
                                            {{ date('h:i A', strtotime($act->created_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span> arrived at <span class="txtHospital">{{ $new_facility }}</span>.
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='admitted')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->created_at)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->created_at)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->created_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span> was admitted at <span class="txtHospital">{{ $new_facility }}</span>.
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='discharged')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->created_at)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->created_at)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->created_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span> was discharged from <span class="txtHospital">{{ $new_facility }}</span>.
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                        <?php
                                        ($row->type=='normal') ? $covid_discharge = \App\PatientForm::where("code",$act->code)->first() : $covid_discharge = \App\PregnantForm::where("code",$act->code)->first();
                                        ?>
                                        @if($covid_discharge->dis_clinical_status or $covid_discharge->dis_sur_category)
                                            <span class="remarks">Clinical Status: <b>{{ ucfirst($covid_discharge->dis_clinical_status) }}</b></span>
                                            <span class="remarks">Surveillance Category: <b>{{ ucfirst($covid_discharge->dis_sur_category) }}</b></span>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($act->status=='archived')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->created_at)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->created_at)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->created_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span> didn't arrive to <span class="txtHospital">{{ $new_facility }}</span>.
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='cancelled')
                                <?php
                                $doctor = \App\User::find($act->action_md);
                                ?>
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        Referral was cancelled by
                                        <span class="txtDoctor">
                                                                <?php
                                            if($doctor->facility_id == 63)
                                                $cancel_doctor = $doctor->fname.' '.$doctor->mname.' '.$doctor->lname;
                                            else
                                                $cancel_doctor = 'Dr. '.$doctor->fname.' '.$doctor->mname.' '.$doctor->lname;
                                            ?>
                                            {{ $cancel_doctor }}.
                                                            </span>
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='travel')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}</span>  has departed by <span class="txtDoctor">{{ $act->remarks == 5 ? explode('-',$act->remarks)[1] : \App\ModeTransportation::find($act->remarks)->transportation }}</span>.
                                    </td>
                                </tr>
                            @elseif($act->status=='form_updated')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}'s</span> form was updated by <span class="txtDoctor">Dr. {{ $act->md_name }}</span> of <span class="txtHospital">{{ $old_facility }}</span>
                                        <span class="remarks">Remarks: {{ $act->remarks }}</span>
                                    </td>
                                </tr>
                            @elseif($act->status=='queued')
                                <tr @if($first==1) class="toggle toggle{{ $row->id }}" @endif>
                                    <!-- <td>{{ date('M d, Y h:i A',strtotime($act->date_referred)) }}</td> -->
                                    <td>
                                        <div class="date-large">
                                            {{ date('M d, Y',strtotime($act->date_referred)) }}
                                        </div>
                                        <div class="time-small">
                                            {{ date('h:i A', strtotime($act->date_referred)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="txtPatient">{{ $act_name->fname }} {{ $act_name->mname }} {{ $act_name->lname }}'s</span> was queued by <span class="txtDoctor">Dr. {{ $act->md_name }}</span> of <span class="txtHospital">{{ $new_facility }}</span>
                                        <span class="remarks">Remarks: Queued at <b>{{ $act->remarks }}</b></span>
                                    </td>
                                </tr>
                            @endif
                            <?php $first = 1; ?>
                        @endforeach
                    </table>
                </div>
                @if(count($activities)>1)
                    <div style="border-top: 1px solid #ccc;">
                        <div class="text-center">
                            <a href="#toggle" data-id="{{ $row->id }}">View More</a> <small class="text-muted">({{ count($activities) }})</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
//--------------> adding folder list
function FileFolder(index,sortedFiles,activity_code,activity_id,follow_id,baseUrl) {
    //var sortedFiles = JSON.parse(sortedFiles);
    $(document).on('keydown', function(event) {
            if (event.keyCode === 27) { // Check if Escape key is pressed
                location.reload(); // Reload the page to refresh modal content
            }
    });

    var asortedFiles = Array.isArray(sortedFiles) ? sortedFiles : JSON.parse(sortedFiles);
    console.log("my assorted files:", asortedFiles);
    // Show the modal
    // showFolderModal();
    if(!$('#folderModal').hasClass('show')){
        var filesListHtml = asortedFiles.map(file => {
            var fileExtension = file.split('.').pop().toLowerCase();
            var checkboxHtml = `
                <div class="checkbox-container">
                    <input type="checkbox" class="file-checkbox" value="${file}" onchange="toggleFileSelection('${file}', event, '${baseUrl}','${activity_code}','${activity_id}','${follow_id}','${index}')" />
                </div>`;
            if(fileExtension == 'pdf'){
                iconHtml = `
                    <div class="d-flex flex-column  align-items-center justify-content-center">
                        <img src="../public/fileupload/pdffile.png" width="100%" height="100px" class="pdf-file" alt="PDF File"/>
                    </div>`;
            }else { // const fileUrl = `${baseUrl}/${file}`; 
                iconHtml = `<img src="${baseUrl}/${file}" width="100%" height="100px" alt="image File" />`;
            }
            return `<div class="cardsfile">
                        <div class="card mb-4 shadow-sm card-body-file">
                            ${checkboxHtml}
                            <a href="javascript:void(0);" id="fileContentList" onclick="openFileViewer('${index}','${activity_code}','${activity_id}','${follow_id}','${baseUrl}', '${file}','${asortedFiles}')" class="file-link">
                                <div class="card-body card-body-card">
                                   ${iconHtml}
                                </div>
                            </a>
                        </div>
                    </div>
                    `;
        }).join('');
        var modalsContent = `
            <div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-labelledby="folderModalLabel">
                <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-vertical-list">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" id="folderModalLabel">File Folder List</h4>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label><input type="checkbox" id="checkVisible" value='${asortedFiles}' onclick="checkVisibleFiles(this.checked, '${asortedFiles}','${baseUrl}','${activity_code}','${activity_id}','${follow_id}','${index}')" />&nbsp; Select all files</label>
                                        <button type="button" id="removeFiles" class="btn btn-success btn-xs">remove files</button>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-xs" onclick="addfilesInFollowupIfempty('${index}','${activity_code}','${activity_id}','${follow_id}','${baseUrl}','${asortedFiles}')">
                                            Add More Files
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        ${filesListHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div
        `;

        document.getElementById('modalContainer').innerHTML = modalsContent;
    };
    $('.cardsfile').each(function() {
        if(asortedFiles.length === 1){
            $(this).addClass('col-md-12');
        }else if(asortedFiles.length === 2){
            $(this).addClass('col-md-6');
        }else if(asortedFiles.length === 3){
            $(this).addClass('col-md-4');
        }
        else{
            $(this).addClass('col-md-3');
        }
    });
    modal = $('#folderModal');
    // $('.modal-content .card-body-folder').html(index == 1 ? filesListHtml : '');
    $('#folderModal').modal('show');
    event.stopPropagation();
   
}

    
$('#folderModal').on('hidden.bs.modal', function (e) {
    $('#folderModal').modal('hide');
    $('#modalContainer').empty();
    $('#folderModal').remove();
    $('.modal-backdrop').remove();
});
//----------------for checkbox remove multiple files--------------------------//
var selectedFiles = [];
function checkVisibleFiles(checked, files,baseUrl,code,activity_id,follow_id,position) {
    var checkboxes = document.querySelectorAll('.cardsfile input[type="checkbox"]');
    
    var filesArray = files.split(',');
    var checkbox = $('.file-checkbox:checked');
    if(checkbox.length > 0){
        selectedFiles = [];
    }
    if(!checked){
        checkboxes.forEach(function(checkbox) {
        selectedFiles = [];
        checkbox.checked = checked;
        const index = selectedFiles.indexOf(checkbox.value);
            if (index > -1) {
                selectedFiles.splice(index, 1);
            }
        });
        console.log("select all files", selectedFiles);
    }else{
        selectedFiles.push(...filesArray);
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = checked;
            if (selectedFiles.indexOf(checkbox.value) === -1) {
                selectedFiles.push(checkbox.value);
            }
        });

        $('#removeFiles').click(function() {

            $.ajax({
                url: "<?php echo asset("api/video/deletMorefiles") ?>",
                type: "POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    baseUrl: baseUrl,
                    files: selectedFiles,
                    code:code,
                    activity_id:activity_id,
                    follow_id:follow_id,
                    position:position
                },
                success: function(response){
                    console.log('My response', response.message);
                    selectedFiles.forEach(function(filename) {
                        $('.file-checkbox').each(function() {
                            var fileCheckbox = $(this);
                            var fileValue = fileCheckbox.val();
                            
                            if (fileValue === filename && fileCheckbox.prop('checked')) {
                                setTimeout(function() {
                                    fileCheckbox.closest('.cardsfile').remove();
                                    errorNotify("Selected file already Deleted in position " + position);
                                }, 50); 
                            }
                        });
                    });
                    updateFilesInFollowup(response.message, baseUrl, position, code, activity_id, follow_id);
                },
                error: function(xhr, status, error){
                    console.error("Error removing files:", error);
                }
            });
        });

        console.log("select all files", selectedFiles);
     
       
    }
}

function toggleFileSelection(file, event,baseUrl,code,activity_id,follow_id,position){
 
    if(event.target.checked){
        selectedFiles.push(file);
    }else{
        const index = selectedFiles.indexOf(file);
        if(index > -1){
            selectedFiles.splice(index, 1);
        }
    } 
    console.log("selected files", selectedFiles);
    $(document).ready(function() {
        $('#removeFiles').click(function() {

            $.ajax({
                url: "<?php echo asset("api/video/deletMorefiles") ?>",
                type: "POST",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    baseUrl: baseUrl,
                    files: selectedFiles,
                    code:code,
                    activity_id:activity_id,
                    follow_id:follow_id,
                    position:position
                },
                success: function(response){
                    console.log('My response', response.message);
                    selectedFiles.forEach(function(filename) {
                        $('.file-checkbox').each(function() {
                            var fileCheckbox = $(this);
                            var fileValue = fileCheckbox.val();
                            
                            if (fileValue === filename && fileCheckbox.prop('checked')) {
                                setTimeout(function() {
                                    fileCheckbox.closest('.cardsfile').remove();
                                    errorNotify("Selected file already Deleted in position " + position);
                                }, 50); 
                            }
                        });
                    });
                    updateFilesInFollowup(response.message, baseUrl, position, code, activity_id, follow_id);
                },
                error: function(xhr, status, error){
                    console.error("Error removing files:", error);
                }
            });
        });

    });
}

//removeSelectedFiles(selectedFiles,baseUrl,activity_code,activity_id,follow_id,position);
// function removeSelectedFiles(selectedFiles,baseUrl,activity_code,activity_id,follow_id,position) {
//     console.log("removing files", selectedFiles,activity_code);
//     if(selectedFiles.length === 0){
//         console.log("No files selected for removal.");
//         return;
//     }

// }
//----------------End for checkbox remove multiple files--------------------------//

//-------------->End adding folder list

    // Initialize popover
    $(function () {
        $('.popoverTelemedicine').popover({
            html: true
        });
    });

    function closePopover() {
        $('.popoverTelemedicine').popover('hide')
    }

    //---------------------------------------------------------------------------------------------------
    var modalOpenEsc = false; //Flag to track if modal is para ma reload ang page use ESC key
    function openFileViewer(position,code, activity_id, follow_id, baseUrl, fileNames, allfiles) {
        modalOpenEsc = true; //  Set flag to true when modal is opened
        if(document.getElementById('carouselmodaId')){
            return;
        }
        var carouselmodaId_exists = document.getElementById('carouselmodaId');
        if(carouselmodaId_exists){
            carouselmodaId_exists.parentNode.removeChild(carouselmodaId_exists);
        }
        
        let fileslist = allfiles.split(',');
        // Split_filesname.filter(filename => filename.trim() !== '').map(function(filename);
        let allfilename = fileslist.filter(filename => filename.trim() !== '').map(filename => { return filename});
        let allfilenames = fileslist.map(filename => `"${filename.trim()}"`);
        console.log("my filesssss", allfilename);
        const clickedFile = allfilename.findIndex(file => file === fileNames);
        // console.log('selected file', clickedFile);
        let carouselItems = '';

        allfilename.forEach((file, index) => {
            let isActive = index === clickedFile ? 'active' : '';
            var fileExtension = file.split('.').pop().toLowerCase();
            const fileUrl = `${baseUrl}/${file}`; 
            if(fileExtension === 'pdf'){
                carouselItems += ` 
                    <div class="item ${isActive}" data-filename="${file}">
                        <embed src="${fileUrl}" type="application/pdf" style="width:100%;height:500px;" />
                    </div>
                `;
            }else{
                carouselItems += `
                <div class="item ${isActive}" data-filename="${file}">
                    <img src="${fileUrl}" alt="..." style="max-width:100%;max-height:calc(100vh - 100px)">
                </div>
                `;
            }
        });

        var modalContent = `
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Additional wrapper for vertical centering -->
                        <div class="vertical-center-wrapper" style="display: table; width: 100%; height: 100vh;">
                            <div class="text-center" style="display: table-cell; vertical-align: middle;">
                                <div class="card" style="padding: 20px;">
                                        <div id="carousel-example-generic" class="carousel slide" data-interval="false">
                                                <div class="carousel-inner">
                                                    ${carouselItems}
                                                </div>
                                                <a class="left carousel-control left-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control right-control" href="#carousel-example-generic" role="button" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                        </div>
                                       
                                        <div class="carousel-buttons" style="position: absolute; bottom: 10px; left: 0; right: 0;">
                                            <a href="" id="download" class="btn btn-success filecolor" download="">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                            <a href="#" id="updateButton" onclick="editFileforFollowup('${baseUrl}','${code}','${activity_id}','${follow_id}','${position}');"  class="btn btn-success filecolor">
                                                <i class="fa fa-pencil-square-o"></i> Update
                                            </a>
                                    
                                            <a href="#" id="addmore" class="btn btn-success filecolor" onclick="addfilesInFollowupIfempty('${position}','${code}','${activity_id}','${follow_id}','${baseUrl}','${fileNames}');">
                                                <i class="fa fa-plus"></i> Add More
                                            </a>
                                            <a href="#" id="deleteButton" onclick="DeleteFileforFollowup('${baseUrl}','${code}','${activity_id}','${follow_id}','${position}')" class="btn btn-danger filecolorDelete">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                            <a href="#" class="btn btn-default filecolorclose" onclick="closeModalButton()" id="closeModalId">
                                                <i class="fa fa-times"></i> close
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>              
        `;

        var modal = document.createElement('div');
        modal.id = 'carouselmodaId'
        modal.innerHTML = modalContent;
        modal.style.position = 'fixed';
        modal.style.top = '0';
        modal.style.left = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.backgroundColor = 'rgba(0,0,0,0.99)';
        modal.style.zIndex = '9999';

        document.body.appendChild(modal);
        updateDownloadButton(baseUrl); 
        
        modal.onclick = function (event) {
            if(event.target === modal){
                modal.parentNode.removeChild(modal);
            }
        };
       
        getfilename(baseUrl,code,activity_id,follow_id,position);   
    }
 
    function closeModal() {
        $("#carouselmodaId").hide();
    }

    function closeModalButton() {
        $("#carouselmodaId").remove();
        // $("#folderModal").remove();
        // $(".modal-backdrop").remove();
    }

    $('#carouselmodaId').on('hidden.bs.modal', function () {
        $("#folderModal").remove();
    });

   
    // Flag to indicate whether a file deletion operation is in progress
    var isDeletingFile = false;
    // Function to disable next and previous slide arrows
    function disableSlideArrows() {
        $(".carousel-control.left").addClass("disabled");
        $(".carousel-control.right").addClass("disabled");
    }

    // Function to enable next and previous slide arrows
    function enableSlideArrows() {
        $(".carousel-control.left").removeClass("disabled");
        $(".carousel-control.right").removeClass("disabled");
    }

    $(document).ready(function() {
        $('.carousel').carousel({
            interval: false,
        });
        
        var buttonFileClicked = false
        var buttonDisabled = false;
        
        function disableDeleteBtn(){ // this will disable button if slide file
            var deletebtn = document.getElementById("deleteButton");
            var addmorebtn = document.getElementById("addmore");
            var updateBtn = document.getElementById("updateButton");
            var download = document.getElementById("download");

            if(buttonDisabled){
                return;
            }
                deletebtn.style.pointerEvents = "none";
                addmorebtn.style.pointerEvents = "none";
                updateBtn.style.pointerEvents = "none";
                download.style.pointerEvents = "none";

                deletebtn.style.opacity = "0.5";
                addmorebtn.style.opacity = "0.5";
                updateBtn.style.opacity = "0.5";
                download.style.opacity = "0.5";

                buttonDisabled = true;
            setTimeout(function() {
                 if(!buttonFileClicked){
                    deletebtn.style.pointerEvents = "";
                    deletebtn.style.opacity = "";
                    addmorebtn.style.pointerEvents = "";
                    addmorebtn.style.opacity = "";
                    updateBtn.style.pointerEvents = "";
                    updateBtn.style.opacity = "";
                    download.style.pointerEvents = "";
                    download.style.opacity = "";

                    buttonDisabled = false;
                 }
                
            }, 1000); // 0.5 seconds
        } 
        //this will control the arrow keyboard left & right
        $(document).keydown(function(e) {
            var isDeleteModalOpen = $("#telemedicineDeleteFileFollowupFormModal").hasClass("show") || $("#telemedicineDeleteFileFollowupFormModal").css("display") === "block";// when modal open the carousel won't slide
            var isUpdateModalOpen = $("#telemedicineUpateFileFormModal").hasClass("show") || $("#telemedicineUpateFileFormModal").css("display") === "block";
            var isAddModalOpen    = $("#FollowupAddEmptyFileFormModal").hasClass("show") || $("#FollowupAddEmptyFileFormModal").css("display") === "block";
            if (isDeletingFile) {
                return;
             }
            if(isDeleteModalOpen || isUpdateModalOpen || isAddModalOpen){
                return;
            }
            if(buttonFileClicked){
                return false;
            }
            if (e.keyCode === 37) {
            // Previous
            $(".carousel-control.left").click();
                disableDeleteBtn();
                return false;
            }

            if (e.keyCode === 39) {
            // Next
            $(".carousel-control.right").click();
                disableDeleteBtn();
                return false;
            }
        });
    });
    
    $(document).keydown(function(event) { //this will close modal of press the keyboard Esc
        selectedFiles = [];//mao ni mo clear sa selectedFiles nga gi select previously sa folderModal
        if (event.keyCode == 27) {
            selectedFiles = [];
            location.reload(true); // Refresh the page immediately
            $('#carouselmodaId').hide();
            // $("#carouselmodaId").remove();

            $('#folderModal').hide();
            // $('#folderModal').remove();
            $('.modal-backdrop').remove();
        }
    });

    function getfilename(baseUrl,code,activity_id,follow_id,position) {
        // Use delegated events to handle clicks for dynamically added elements
        $(document).on('click', '#updateButton', function(e) {
            var editFileName = $('.carousel-inner .item.active').data('filename');
            e.preventDefault();
            editFileforFollowup(baseUrl, editFileName, code, activity_id, follow_id,position);
        });

        $(document).on('click', '#deleteButton', function(e) {
            e.preventDefault();
            var deleteFileName = $('.carousel-inner .item.active').data('filename');
            DeleteFileforFollowup(baseUrl,deleteFileName,code,activity_id,follow_id,position)
        });

        $(document).on('click', '#AddfileEmpty', function(e) {
            e.preventDefault();
            var addFileName = $('.carousel-inner .item.active').data('filename');    
            addfilesInFollowupIfempty(position,code,activity_id,follow_id,addFileName)
        });

        $('#carouselModalId').on('slid.bs.carousel', '#carousel-example-generic', function() {
            var activeFileName = $('.carousel-inner .item.active').data('filename');
           
        });
    }

    function updateDownloadButton(baseUrl) {
        var activeFileName = $('.carousel-inner .item.active').data('filename');
        // Assuming baseUrl is accessible and it points to the directory where files are stored
        $('#download').attr('href', baseUrl + '/' + activeFileName);
        $('#download').attr('download', activeFileName);
    }

    $(document).ready(function() {
        var baseUrl = " <?php echo  asset('public/fileupload/' . $user->username . '/') ?>";
        
        updateDownloadButton(); // Initial setup for the download button
        // Ensure the modal and carousel are in the DOM
        $(document).on('slid.bs.carousel', '#carousel-example-generic', function () {
            
            updateDownloadButton(baseUrl); // Call this to update the download link based on the new active item
        });
        // Any other initialization code
    });

</script>
<style>
/** ---------------My changes File Folder Modal -------------- */
.date-large {
    font-size: 12px;
    font-weight: bold;
}

.time-small {
    font-size: 11px;
}

.card-body-folder{
        margin-bottom: 5px; /* Adjust as needed */
        margin-right: 30px;
    }
.position-blue{
    color: #337AB7 !important;
}
.iconUl{
    list-style-type:none;
}
  .modal-dialog-centered {
    position: fixed;
    margin: 0;
    width: 100%;
    height: 100%;
    padding: 0;
  }

  .modal-vertical-list {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: auto;
    height: auto;
    max-height: 90%;
  }
  #folderModal{
    background-color: rgba(0,0,0,0.90)
  }
  .file-wrapper-icon{
    margin-top: -200px;
    margin-left: 10px;
    text-align: center;
    display: inline-block;
  }
  .file-Icon-label{
    display: block;
    margin: 0 auto;
    color: black;
    font-weight: normal;
    
  }
  .file-link {
    display: block;
    text-decoration: none;
}
.modal-body {
    max-height: calc(100vh - 212px);
    overflow-y: auto;
}
/** ---------------My changes File Folder Modal -------------- */
</style>
