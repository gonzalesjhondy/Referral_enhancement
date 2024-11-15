<template>
    <audio ref="audioVideo" :src="audioVideoUrl" loop></audio>
    <div class="modal fade callModal" role="dialog" id="video-call-confirmation" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img :src="imageUrl" alt="Image">
                    <p class="txt">{{ doctorCaller }}</p>
                    <p class="isCalling">is calling you</p>
                    <p style="font-size: .9em">The call will start as soon as you accept</p>
                    <div class="row">
                        <div class="col-xs-6">
                            <div>
                                <button type="button" class="btn btn-default btn-sm acceptButton" data-toggle="modal" data-dismiss="modal" @click="acceptCall"><i class="fa fa-check"></i></button>
                            </div>
                            <div class="textAccept">Accept</div>
                        </div>
                        <div class="col-xs-6">
                            <div>
                                <button type="button" class="btn btn-default btn-sm ignoreButton" data-dismiss="modal" @click="cancelCall"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="textDecline">Decline</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name : "ReferralApp",
        props: {
            user: Object,
            count_referral: Number
        },
        data(){
            return {
                increment_referral: Number,
                reco_count : $("#reco_count_val").val(),
                audioVideoUrl: $("#broadcasting_url").val()+"/public/facebook.mp3",
                tracking_id: Number,
                referral_code: String,
                action_md: Number,
                imageUrl: $("#broadcasting_url").val()+"/resources/img/video/doctorLogo.png",
                doctorCaller: String,
                telemedicineFormType: String,
                activity_id: Number
            }
        },
        methods: {
            playAudio() {
                audioElement.play();
                setTimeout(function(){
                    audioElement.pause();
                },10000);
            },
            async playVideoCallAudio() {
                await this.$refs.audioVideo.play();
                let self = this;
                setTimeout(function() {
                    console.log("pause");
                    $("#video-call-confirmation").modal('hide');
                    self.$refs.audioVideo.pause();
                },60000);
            },
            notifyReco(code, feedback_count, redirect_track) {
                let content = '<button class=\'btn btn-xs btn-info\' onclick=\'viewReco($(this))\' data-toggle=\'modal\'\n' +
                    '                               data-target=\'#feedbackModal\'\n' +
                    '                               data-code="'+code+'" ' +
                    '                               >\n' +
                    '                           <i class=\'fa fa-comments\'></i> ReCo <span class=\'badge bg-blue\' id="reco_count'+code+'">'+feedback_count+'</span>\n' +
                    '                       </button><a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '                                                <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '                                            </a>';
                Lobibox.notify("success", {
                    title: code,
                    size: 'normal',
                    delay: false,
                    closeOnClick: false,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png",
                    msg: content
                });
            },
            appendReco(code, name_sender, facility_sender, date_now, msg) {
                let picture_sender = $("#broadcasting_url").val()+"/resources/img/receiver.png";
                let message = msg.replace(/^\<p\>/,"").replace(/\<\/p\>$/,"");
                $(".reco-body"+code).append('<div class=\'direct-chat-msg left\'>\n' +
                    '                    <div class=\'direct-chat-info clearfix\'>\n' +
                    '                    <span class="direct-chat-name text-info pull-left">'+facility_sender+'</span><br>'+
                    '                    <span class=\'direct-chat-name pull-left\'>'+name_sender+'</span>\n' +
                    '                    <span class=\'direct-chat-timestamp pull-right\'>'+date_now+'</span>\n' +
                    '                    </div>\n' +
                    '                    <img class=\'direct-chat-img\' title=\'\' src="'+picture_sender+'" alt=\'Message User Image\'>\n' +
                    '                    <div class=\'direct-chat-text\'>\n' +
                    '                    '+message+'\n' +
                    '                    </div>\n' +
                    '                    </div>')
            },
            notifyReferral(patient_name, referring_md, referring_name, redirect_track) {
                let content = patient_name+' was referred by Dr. '+referring_md+' of '+referring_name + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('success', {
                    delay: false,
                    title: 'New Referral',
                    msg: content,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png",
                    sound: false
                });
            },
            notifyReferralSeen(patient_name, seen_by, seen_by_facility, patient_code, activity_id, redirect_track) {
                $("#seen_progress"+patient_code+activity_id).addClass("completed");
                let msg = patient_name+' was seen by Dr. '+seen_by+' of '+seen_by_facility + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('info', {
                    delay: false,
                    title: 'Referral Seen',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralAccepted(patient_name, accepting_doctor, accepting_facility_name, activity_id, patient_code, tracking_id, date_accepted, remarks, redirect_track, accepting_doctor_id) {
                $("#accepted_progress"+patient_code+activity_id).addClass("completed");
                $("#accepted_progress"+patient_code+activity_id).attr("data-actionmd", accepting_doctor_id);
                $("#rejected_progress"+patient_code+activity_id).removeClass("bg-orange");
                $("#rejected_name"+patient_code+activity_id).html("Accepted");
                $("#follow_queue_number"+patient_code+activity_id).html("<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"font-size:15px;\"></i>") // for follow 2nd position more
                $("#queue_number"+patient_code+activity_id).html("<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"font-size:15px;\"></i>")// add this for referred 1st position
                $("#icon_progress"+patient_code+activity_id).html("<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\" style=\"font-size:15px;\"></i>"); //I add this icon jondy
                $("#html_websocket_departed"+patient_code).html(this.buttonDeparted(tracking_id));
                $("#prepend_from_websocket"+patient_code).prepend('<tr class="toggle toggle" style="display: table-row;">\n' +
                    '                                                            <td>'+date_accepted+'</td>\n' +
                    '                                                            <td>\n' +
                    '                                                                <span class="txtPatient">'+patient_name+'</span>  was accepted by <span class="txtDoctor">Dr. '+accepting_doctor+'</span> of <span class="txtHospital">'+accepting_facility_name+'</span>.\n' +
                    '                                                                <span class="remarks">Remarks: '+remarks+'</span>\n' +
                    '                                                            </td>\n' +
                    '                                                        </tr>');
                let msg = patient_name+' was accepted by Dr. '+accepting_doctor+' of '+accepting_facility_name + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('success', {
                    delay: false,
                    title: 'Accepted',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png",
                });
            },
            notifyReferralRejected(patient_code, date_rejected, rejected_by, rejected_by_facility, patient_name, remarks, activity_id, redirect_track, telemedicine) {
                $("#accepted_progress"+patient_code+activity_id).addClass("completed");
                let rejected_process_element = $("#rejected_progress"+patient_code+activity_id);
                rejected_process_element.removeClass("bg-orange");
                rejected_process_element.addClass("bg-red");
                let redirectButtonName = "";
                if(telemedicine)
                    redirectButtonName = '<button class="btn btn-success btn-xs btn-redirected" onclick="consultToOtherFacilities(\'' + patient_code + '\')">\n' +
                        '    <i class="fa fa-camera"></i> Consult other facilities<br>\n' +
                        '</button>';
                else
                    redirectButtonName = '                                                           <button class="btn btn-success btn-xs btn-redirected" data-toggle="modal" data-target="#redirectedFormModal" data-activity_code="'+patient_code+'">\n' +
                        '                                                                <i class="fa fa-ambulance"></i> Redirect to other facility\n' +
                        '                                                            </button>\n';

                $("#rejected_name"+patient_code+activity_id).html("Declined");
                $("#prepend_from_websocket"+patient_code).prepend('' +
                    '<tr>\n' +
                    '                                                    <td>'+date_rejected+'</td>\n' +
                    '                                                    <td>\n' +
                    '                                                        <span class="txtDoctor">'+rejected_by+'</span> of <span class="txtHospital">'+rejected_by_facility+'</span> recommended to redirect <span class="txtPatient">'+patient_name+'</span> to other facility.\n' +
                    '                                                        <span class="remarks">Remarks: '+remarks+'</span>\n' +
                    '                                                        <br>\n' +
                    redirectButtonName+
                    '                                                     </td>\n' +
                    '                                                </tr>');
                let msg = patient_name+' was recommend to redirect by Dr. '+rejected_by+' of '+rejected_by_facility + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('error', {
                    delay: false,
                    title: 'Declined',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png",
                });
            },
            notifyReferralCall(patient_code, count_caller, caller_date, caller_by, caller_by_facility, called_to_facility, caller_by_contact, redirect_track) {
                $("#count_caller"+patient_code).html(count_caller);
                $("#prepend_from_websocket"+patient_code).prepend('<tr>\n' +
                    '                                                       <td>'+caller_date+'</td>\n' +
                    '                                                            <td>\n' +
                    '                                                                <span class="txtDoctor">Dr. '+caller_by+'</span> of <span class="txtHospital">'+caller_by_facility+'</span> is requesting a call from <span class="txtHospital">'+called_to_facility+'</span>.\n' +
                    '                                                                 Please contact this number <span class="txtInfo">('+caller_by_contact+')</span> .\n' +
                    '                                                           </td>\n' +
                    '                                                        </tr>');
                let msg = 'Dr. '+caller_by+' of '+caller_by_facility+' is requesting a call. Please contact this number ('+caller_by_contact+') <br>'+ caller_date  + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('warning', {
                    delay: false,
                    title: 'Requesting a Call',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png",
                });
            },
            notifyReferralDeparted(patient_name, departed_by, departed_by_facility, departed_date, mode_transportation, redirect_track) {
                let msg = patient_name+' was departed by Dr. '+departed_by+' of '+departed_by_facility+' and transported by '+mode_transportation+'<br>'+departed_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';

                Lobibox.notify('info', {
                    delay: false,
                    closeOnClick: false,
                    title: 'Referral Departed',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralArrived(patient_code, activity_id, patient_name, current_facility, arrived_date, remarks, redirect_track) {
                $("#arrived_progress"+patient_code+activity_id).addClass("completed");
                $("#departed_progress"+patient_code+activity_id).addClass("completed");
                $("#prepend_from_websocket"+patient_code).prepend('<tr class="toggle" style="display: table-row;">\n' +
                    '                                                            <td>'+arrived_date+'</td>\n' +
                    '                                                            <td>\n' +
                    '                                                                <span class="txtPatient">'+patient_name+'</span>  has arrived at '+current_facility+
                    '                                                                <span class="remarks">Remarks: '+remarks+'</span>\n' +
                    '                                                            </td>\n' +
                    '                                                        </tr>');
                let msg = patient_name+' has arrived at '+current_facility+ '<br>'+ arrived_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('success', {
                    delay: false,
                    title: 'Arrived',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralNotArrived(patient_code, activity_id, patient_name, current_facility, arrived_date, remarks, redirect_track) {
                $("#notarrived_progress"+patient_code+activity_id).addClass("bg-red");
                $("#departed_progress"+patient_code+activity_id).addClass("completed");
                let arrived_element = $("#arrived_name"+patient_code+activity_id);
                arrived_element.html("Not Arrived");
                arrived_element.addClass("not_arrived");
                $("#prepend_from_websocket"+patient_code).prepend('<tr class="toggle" style="display: table-row;">\n' +
                    '                                                            <td>'+arrived_date+'</td>\n' +
                    '                                                            <td>\n' +
                    '                                                                <span class="txtPatient">'+patient_name+"</span>  didn't arrive at "+current_facility+
                    '                                                                <span class="remarks">Remarks: '+remarks+'</span>\n' +
                    '                                                            </td>\n' +
                    '                                                        </tr>');
                let msg = patient_name+" didn't arrive at "+current_facility+ '<br>'+ arrived_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('error', {
                    delay: false,
                    title: 'Did Not Arrive',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralAdmitted(patient_code, activity_id, patient_name, current_facility, admitted_date, redirect_track) {
                $("#admitted_progress"+patient_code+activity_id).addClass("completed");
                $("#prepend_from_websocket"+patient_code).prepend('<tr class="toggle" style="display: table-row;">\n' +
                    '                                                            <td>'+admitted_date+'</td>\n' +
                    '                                                            <td>\n' +
                    '                                                                <span class="txtPatient">'+patient_name+'</span>  was admitted at '+current_facility+
                    '                                                            </td>\n' +
                    '                                                        </tr>');

                let msg = patient_name+' has admitted at '+current_facility+ '<br>'+ admitted_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('success', {
                    delay: false,
                    title: 'Admitted',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralDischarged(patient_code, activity_id, patient_name, current_facility, discharged_date, remarks, redirect_track) {
                $("#discharged_progress"+patient_code+activity_id).addClass("completed");
                $("#prepend_from_websocket"+patient_code).prepend('<tr class="toggle" style="display: table-row;">\n' +
                    '                                                            <td>'+discharged_date+'</td>\n' +
                    '                                                            <td>\n' +
                    '                                                                <span class="txtPatient">'+patient_name+"</span>  was discharged at "+current_facility+
                    '                                                                <span class="remarks">Remarks: '+remarks+'</span>\n' +
                    '                                                            </td>\n' +
                    '                                                        </tr>');
                let msg = patient_name+" was discharged at "+current_facility+ '<br>'+ discharged_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('success', {
                    delay: false,
                    title: 'Discharged',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },

            notifyReferralCancelled(patient_code, activity_id, patient_name, referring_md, referring_name, cancelled_date, redirect_track) {
                $("#rejected_progress"+patient_code+activity_id).addClass("completed");
                let msg = patient_name+"'s referral was cancelled by Dr. "+referring_md+' of '+referring_name+ '<br>'+ cancelled_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('error', {
                    delay: false,
                    title: 'Cancelled',
                    closeOnClick: false,
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },

            notifyReferralCancelledAdmin(patient_code, activity_id, patient_name, referring_md, referring_name, cancelled_date, redirect_track, remarks) {
                $("#accepted_progress"+patient_code+activity_id).addClass("completed");
                $("#rejected_progress"+patient_code+activity_id).addClass("bg-yellow");
                $("#rejected_name"+patient_code+activity_id).html("Cancelled");
                $("#prepend_from_websocket"+patient_code).prepend('' +
                    '<tr>\n' +
                    '    <td>'+cancelled_date+'</td>\n' +
                    '    <td>\n' +
                    '       <span class="txtPatient">'+patient_name+'</span>`s referral was cancelled by Dr. <span class="txtDoctor">'+referring_md+'</span> of <span class="txtHospital">'+referring_name+'</span>.\n' +
                    '       <span class="remarks">Remarks: '+remarks+'</span>\n' +
                    '       <br>\n' +
                    '   </td>\n' +
                    '</tr>');
                let msg = patient_name+"'s referral was cancelled by 711 Admin <br>" + cancelled_date + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('error', {
                    delay: false,
                    title: 'Cancelled',
                    closeOnClick: false,
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },

            notifyReferralUndoCancel(patient_code, activity_id, msg, status) {
                let stat = "success";
                if(status === "rejected") {
                    stat = "error";
                }
                $("#rejected_progress"+patient_code+activity_id).removeClass("completed");
                Lobibox.notify(stat, {
                    delay: false,
                    title: 'Cancellation Undone',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralUpdateFormFaciChanged(msg) {
                Lobibox.notify('error', {
                    delay: false,
                    closeOnClick: false,
                    title: 'Patient Redirected!',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralUpdateFormFaciSame(msg) {
                Lobibox.notify('warning', {
                    delay: false,
                    closeOnClick: false,
                    title: 'Referral Form Updated!',
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyReferralQueueUpdated(patient_code, activity_id, remarks, date_queued, patient_name, queued_by, queued_by_facility, redirect_track, first_queue) {
                $("#accepted_progress"+patient_code+activity_id).addClass("completed");
                $("#rejected_progress"+patient_code+activity_id).addClass("bg-orange");
                $("#rejected_name"+patient_code+activity_id).html("Queued at <br>" + "<b>" + remarks + "</b>");
                $("#follow_queue_number"+patient_code+activity_id).html("<i class=\"fa fa-hourglass-half\" aria-hidden=\"true\" style=\"font-size:15px;\"></i>"); // Add this Follow in 2nd more position
                $("#queue_number"+patient_code+activity_id).html("<i class=\"fa fa-hourglass-half\" aria-hidden=\"true\" style=\"font-size:15px;\"></i>"); // I add this for reffered 1st position
                $("#icon_progress"+patient_code+activity_id).html("<i class=\"fa fa-hourglass-half\" aria-hidden=\"true\" style=\"font-size:15px;\"></i>"); //I add this icon jondy
                $("#prepend_from_websocket"+patient_code).prepend('' +
                    '<tr>\n' +
                    '    <td>'+date_queued+'</td>\n' +
                    '    <td>\n' +
                    '       <span class="txtPatient">'+patient_name+'</span>`s queueing number was updated by Dr. <span class="txtDoctor">'+queued_by+'</span> of <span class="txtHospital">'+queued_by_facility+'</span>.\n' +
                    '       <span class="remarks">Status: First queued at '+first_queue+'. Latest queue update is at <b><u>'+remarks+'</u></b></span>\n' +
                    '       <br>\n' +
                    '   </td>\n' +
                    '</tr>');
                let msg = patient_name+" was queued at " + remarks +" by Dr. "+queued_by+' of '+queued_by_facility+ '<br>'+ date_queued + '<br><br>\n' +
                    '       <a href="'+redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                    '       </a>';
                Lobibox.notify('warning', {
                    delay: false,
                    title: 'Queued!',
                    closeOnClick: false,
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },
            notifyNewWalkin(patient_name, referred_to, date_referred) {
                let msg = "<b> " + patient_name + "</b> was registered as a walk-in patient at <b> " + referred_to + "</b>.<br><br>" + date_referred + '<br>\n' +
                    '       <a href="../patient/walkin" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Show\n' +
                    '       </a>';
                Lobibox.notify('warning', {
                    delay: false,
                    title: 'New Walk-in Patient!',
                    closeOnClick: false,
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },

            notifyNewAppointment(faci_name, requester, date_requested) {
                let msg = requester + " of " + faci_name + " has made an appointment request.<br><br>" + date_requested + '<br>\n' +
                    '       <a href="admin/appointment" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Show\n' +
                    '       </a>';
                Lobibox.notify('info', {
                    delay: false,
                    title: 'New Appointment!',
                    closeOnClick: true,
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },

            notifyNewUserFeedback(date_submitted) {
                let msg = "A user feedback has been submitted." + '<br><br>'+ date_submitted + '<br>\n' +
                    '       <a href="admin/user_feedback" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                    '           <i class=\'fa fa-stethoscope\'></i> Show\n' +
                    '       </a>';
                Lobibox.notify('info', {
                    delay: false,
                    title: 'New User Feedback!',
                    closeOnClick: true,
                    msg: msg,
                    img: $("#broadcasting_url").val()+"/resources/img/ro7.png"
                });
            },

            buttonSeen(count_seen, tracking_id) {
                return count_seen > 0 ? '<a href="#seenModal" data-toggle="modal" data-id="'+tracking_id+'" class="btn btn-success btn-xs btn-seen" style="margin-left:3px;"><i class="fa fa-user-md"></i> Seen\n' +
                    '                <small class="badge bg-green-active">'+count_seen+'</small>\n' +
                    '          </a>' : '';
            },
            buttonReco(code,count_reco) {
                return '<button class="btn btn-xs btn-info btn-feedback margin-left" data-toggle="modal" data-target="#feedbackModal" data-code="'+code+'" onclick="viewReco($(this))" style="margin-left:3px;">\n' +
                    '            <i class="fa fa-comments"></i>\n' +
                    '            ReCo\n' +
                    '            <span class="badge bg-blue" id="reco_count'+code+'">'+count_reco+'</span>\n' +
                    '        </button>';
            },
            buttonDeparted(tracking_id) {
                return '<a href="#transferModal" data-toggle="modal" data-id="'+tracking_id+'" class="btn btn-xs btn-success btn-transfer"><i class="fa fa-ambulance"></i> Depart</a>';
            },
            buttonTrack(patient_code) {
                return '<br><a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode='+patient_code+'" class="btn btn-xs btn-warning" target="_blank">\n' +
                    '                                                <i class="fa fa-stethoscope"></i> Track\n' +
                    '                                            </a>';
            },
            callADoctor(tracking_id,code) {
                this.tracking_id = tracking_id
                this.referral_code = code
                this.playVideoCallAudio();
                $(document).ready(function() {
                    console.log( "ready!" );
                    $("#video-call-confirmation").modal('toggle');
                });
            },
            acceptCall() {
                this.$refs.audioVideo.pause();
                $("#video-call-confirmation").modal('toggle');
                let windowName = 'NewWindow'; // Name of the new window
                let windowFeatures = 'width=600,height=400'; // Features for the new window (size, position, etc.)
                const referring_md_status = this.user.id === this.action_md ? 'no' : 'yes'
                let url = $("#broadcasting_url").val()+`/doctor/telemedicine?id=${this.tracking_id}&code=${this.referral_code}&form_type=${this.telemedicineFormType}&referring_md=${referring_md_status}&activity_id=${this.activity_id}`
                let newWindow = window.open(url, windowName, windowFeatures);
                if (newWindow && newWindow.outerWidth) {
                    // If the window was successfully opened, attempt to maximize it
                    newWindow.moveTo(0, 0);
                    newWindow.resizeTo(screen.availWidth, screen.availHeight);
                }
                this.telemedicineExamined();
            },
            examinedCompleted(patient_code, activity_id) {
                $("#examined_progress"+patient_code+activity_id).addClass("completed");
            },
            prescribedCompleted(patient_code, activity_id) {
                $("#prescribed_progress"+patient_code+activity_id).addClass("completed");
            },
            upwardCompleted(patient_code,activity_id) {
                $("#upward_progress"+patient_code+activity_id).addClass("completed");
            },
            // labreq(request_id,activity_id){//I add this changes
            //     $("#lab_progress"+request_id).addClass("completed");
            // },
            async telemedicineExamined() {
                const updateExamined = {
                    code : this.referral_code,
                }
                await axios.post(`${$("#broadcasting_url").val()}/api/video/examined`, updateExamined).then(response => {
                    console.log(response)
                });
            },
            cancelCall() {
                this.$refs.audioVideo.pause();
            }
        },
        created() {
            console.log("VUE.JS 3")
            Echo.join('chat')
                .here(users => {
                    //console.log(users)
                    let websocket_element = $(".websocket_status")
                    websocket_element.html("CONNECTED")
                    websocket_element.addClass("text-green")
                })
            this.increment_referral = this.count_referral
            Echo.join('new_referral')
                .listen('NewReferral', (event) => {
                    console.log("my event", event);
                    if(this.user.facility_id === event.payload.referred_to) {
                        this.playAudio();
                        this.increment_referral++;
                        if($("#referral_page_check").val()) {
                            console.log("append the refer patient");
                            $('.count_referral').html(this.increment_referral);
                            let position = event.payload.position;
                            let position_bracket = ['','1st','2nd','3rd', '4th','5th','6th','7th','8th','9th','10th','11th','12th','13th','14th','15th','16th','17th','18th','19th','20th'];
                            let position_content = '';
                            if(position > 0) {
                                position_content = "<div class='badge-overlay'>\n" +
                                    "                                            <span class='top-right badge1 red'>" + position_bracket[position + 1] + " Position</span>\n" +
                                    "                                        </div>";
                            }
                            let type = event.payload.form_type;
                            type = type=='normal' ? 'normal-section':'pregnant-section';
                            let referral_type = (type=='normal-section') ? 'normal':'pregnant';
                            let content = '<li id="referral_incoming'+event.payload.patient_code+'">' +
                                position_content +
                                '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
                                '    <div class="timeline-item '+type+'" id="item-'+event.payload.tracking_id+'">\n' +
                                '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">'+event.payload.referred_date+'</span></span>\n' +
                                '        <h3 class="timeline-header no-border">' +
                                '           <span>' +
                                '               <a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode='+event.payload.patient_code+'" class="patient_name" target="_blank">'+event.payload.patient_name+'</a>' +
                                '           </span>'+
                                '           <small class="status">[ '+event.payload.patient_sex+', '+event.payload.age+' ]</small> was <span class="text-blue">'+event.payload.status+'</span> to <span class="text-danger">'+event.payload.referred_department+'</span> by <span class="text-warning">Dr. '+event.payload.referring_md+'</span> of <span class="facility">'+event.payload.referring_name+'</span></h3>\n' +
                                '        <div class="timeline-footer">\n';

                            /*if(my_department_id==data.department_id) {*/
                            content +=  '    <div class="form-group">' +
                                '                <a class="btn btn-warning btn-xs view_form" href="#referralForm"\n' +
                                '                   data-toggle="modal"\n' +
                                '                   data-code="'+event.payload.patient_code+'"\n' +
                                '                   data-item="#item-'+event.payload.tracking_id+'"\n' +
                                '                   data-referral_status="referred"\n' +
                                '                   data-type="'+referral_type+'"\n' +
                                '                   data-id="'+event.payload.tracking_id+'"\n' +
                                '                   data-referred_from="'+event.payload.referred_from+'"\n' +
                                '                   data-patient_name="'+event.payload.patient_name+'"\n' +
                                '                   data-backdrop="static">\n' +
                                '                <i class="fa fa-folder"></i> View Form\n' +
                                '               </a>' +
                                                this.buttonSeen(event.payload.count_seen, event.payload.tracking_id)+
                                                this.buttonReco(event.payload.patient_code, event.payload.count_reco)+
                                '               <h5 class="text-red blink_new_referral pull-right">New Referral</h5>'+
                                '             </div>';
                            /*}*/

                            content +=   '' +
                                '        </div>\n' +
                                '    </div>\n' +
                                '</li>';

                            $('.timeline').prepend(content);
                        }
                        this.notifyReferral(event.payload.patient_name, event.payload.referring_md, event.payload.referring_name, event.payload.redirect_track)
                    }
                });

            Echo.join('reco')
                .listen('SocketReco', (event) => {
                    $("#reco_count"+event.payload.code).html(event.payload.feedback_count);
                    axios.get($("#broadcasting_url").val()+'/activity/check/'+event.payload.code+'/'+this.user.facility_id).then(response => {
                        if(response.data && event.payload.sender_facility !== this.user.facility_id && $("#archived_reco_page").val() !== 'true') {
                            this.reco_count++
                            $("#reco_count").html(this.reco_count)
                            this.appendReco(event.payload.code, event.payload.name_sender, event.payload.facility_sender, event.payload.date_now, event.payload.message)
                            try {
                                let objDiv = document.getElementById(event.payload.code);
                                objDiv.scrollTop = objDiv.scrollHeight;
                                if (!objDiv.scrollTop)
                                    this.notifyReco(event.payload.code, event.payload.feedback_count, event.payload.redirect_track)
                            } catch(err){
                                console.log("modal not open");
                                this.notifyReco(event.payload.code, event.payload.feedback_count, event.payload.redirect_track)
                            }
                        }
                    });
                });

            Echo.join('referral_seen')
                .listen('SocketReferralSeen', (event) => {
                    $("#count_seen"+event.payload.patient_code).html(event.payload.count_seen); //increment seen both referring and referred
                    if(event.payload.referring_facility_id === this.user.facility_id) {
                        this.notifyReferralSeen(event.payload.patient_name, event.payload.seen_by, event.payload.seen_by_facility, event.payload.patient_code, event.payload.activity_id, event.payload.redirect_track)
                    }
                });

            Echo.join('referral_accepted')
                .listen('SocketReferralAccepted', (event) => {
                    if(event.payload.referred_from === this.user.facility_id) {
                        this.notifyReferralAccepted(event.payload.patient_name, event.payload.accepting_doctor, event.payload.accepting_facility_name, event.payload.activity_id, event.payload.patient_code, event.payload.tracking_id ,event.payload.date_accepted, event.payload.remarks, event.payload.redirect_track, event.payload.accepting_doctor_id)
                    }
                });

            Echo.join('referral_rejected')
                .listen('SocketReferralRejected', (event) => {
                    if(event.payload.referred_from === this.user.facility_id) {
                        this.notifyReferralRejected(event.payload.patient_code, event.payload.date_rejected, event.payload.rejected_by, event.payload.rejected_by_facility, event.payload.patient_name, event.payload.remarks, event.payload.activity_id, event.payload.redirect_track, event.payload.telemedicine)
                    }
                });

            Echo.join('referral_call')
                .listen('SocketReferralCall', (event) => {
                    if(event.payload.called_to === this.user.facility_id) {
                        this.notifyReferralCall(event.payload.patient_code, event.payload.count_caller, event.payload.caller_date, event.payload.caller_by, event.payload.caller_by_facility, event.payload.called_to_facility, event.payload.caller_by_contact, event.payload.redirect_track)
                    }
                });

            Echo.join('referral_departed')
                .listen('SocketReferralDeparted', (event) => {
                    if(event.payload.referred_to === this.user.facility_id) {
                        this.notifyReferralDeparted(event.payload.patient_name, event.payload.departed_by, event.payload.departed_by_facility, event.payload.departed_date, event.payload.mode_transportation, event.payload.redirect_track)
                    }
                });

            Echo.join('referral_arrived')
                .listen('SocketReferralArrived', (event) => {
                    if(event.payload.referred_from === this.user.facility_id) {
                        this.notifyReferralArrived(event.payload.patient_code, event.payload.activity_id, event.payload.patient_name, event.payload.current_facility, event.payload.arrived_date, event.payload.remarks, event.payload.redirect_track)
                    }
                });

            Echo.join('referral_not_arrived')
                .listen('SocketReferralNotArrived', (event) => {
                    if(event.payload.referred_from === this.user.facility_id) {
                        this.notifyReferralNotArrived(event.payload.patient_code, event.payload.activity_id, event.payload.patient_name, event.payload.current_facility, event.payload.arrived_date, event.payload.remarks, event.payload.redirect_track)
                    }
                });

            Echo.join('referral_admitted')
                .listen('SocketReferralAdmitted', (event) => {
                    if(event.payload.referred_from === this.user.facility_id) {
                        this.notifyReferralAdmitted(event.payload.patient_code, event.payload.activity_id, event.payload.patient_name, event.payload.current_facility, event.payload.arrived_date, event.payload.redirect_track)
                    }
                });

            Echo.join('referral_discharged')
                .listen('SocketReferralDischarged', (event) => {
                    console.log(event);
                    // console.log('request_id',event.payload.request_by, 'activity id:', event.payload.activity_id);
                    if(event.payload.status === 'telemedicine') {
                        if((event.payload.referred_to === this.user.facility_id || event.payload.referring_md === this.user.id) && event.payload.trigger_by !== this.user.id ) {
                            console.log("callAdoctor");
                            this.action_md = event.payload.action_md;
                            this.doctorCaller = event.payload.doctorCaller;
                            this.telemedicineFormType = event.payload.form_type;
                            this.activity_id = event.payload.activity_id;
                            this.callADoctor(event.payload.tracking_id,event.payload.code);
                        } 
                        else if(event.payload.referred_from === this.user.facility_id) {
                            if(event.payload.telemedicine_status === 'examined') {
                                console.log("examinedcompleted");
                                this.examinedCompleted(event.payload.code, event.payload.activity_id);
                            } else if(event.payload.telemedicine_status === 'prescription') {
                                console.log("prescribedCompleted");
                                this.prescribedCompleted(event.payload.code, event.payload.activity_id)
                            } else if(event.payload.telemedicine_status === 'upward') {
                                console.log("upwardCompleted");
                                this.upwardCompleted(event.payload.code, event.payload.activity_id)
                            }
                        }
                    } else {
                        if(event.payload.referred_from === this.user.facility_id) {
                            this.notifyReferralDischarged(event.payload.patient_code, event.payload.activity_id, event.payload.patient_name, event.payload.current_facility, event.payload.arrived_date, event.payload.remarks, event.payload.redirect_track)
                        }
                    }

                    // if(event.payload.laboratory_code){I add this changes
                    //     console.log('succefully upload labrequest');
                    //     this.labreq(event.payload.request_by,event.payload.activity_id);                         
                    // }
                });

            Echo.join('referral_update')
                .listen('SocketReferralUpdate', (event) => {
                    if(event.payload.notif_type === "cancel referral") {
                        if(event.payload.referred_to === this.user.facility_id) {
                            $('#closeReferralForm'+event.payload.patient_code).click();
                            let content =
                                '    <i class="fa fa-ban bg-red"></i>\n' +
                                '    <div class="timeline-item ">\n' +
                                '        <span class="time"><i class="icon fa fa-calendar"></i> <span class="date_activity">'+event.payload.cancelled_date+'</span></span>\n' +
                                '        <h3 class="timeline-header no-border">' +
                                '           <strong class="text-bold">    '+
                                '           <a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode='+event.payload.patient_code+'" class="patient_name" target="_blank">'+event.payload.patient_name+'</a>' +
                                '           </strong>'+
                                '            was <span class="text-red"> cancelled </span> by <span class="text-warning">Dr. '+event.payload.referring_md+'</span> of <span class="facility">'+event.payload.referring_name+'</span></h3>\n' +
                                '        <div class="timeline-footer">\n'+
                                '           <div class="form-group">' +
                                this.buttonReco(event.payload.patient_code, event.payload.count_reco)+
                                '           </div>\n' +
                                '        </div>\n' +
                                '    </div>\n';

                            $('#referral_incoming'+event.payload.patient_code).html(content);
                            this.notifyReferralCancelled(event.payload.patient_code, event.payload.activity_id, event.payload.patient_name, event.payload.referring_md, event.payload.referring_name, event.payload.cancelled_date, event.payload.redirect_track)
                        }
                        if(event.payload.referred_from === this.user.facility_id && event.payload.admin === 'yes') {
                            console.log("admin cancellation!!");
                            this.notifyReferralCancelledAdmin(event.payload.patient_code, event.payload.activity_id, event.payload.patient_name, event.payload.referring_md, event.payload.referring_name, event.payload.cancelled_date, event.payload.redirect_track, event.payload.remarks);
                        }
                    }
                    else if(event.payload.notif_type === "undo cancel") {
                        if(event.payload.referred_to === this.user.facility_id) {
                            console.log('undo cancel');
                            console.log('undo status', event.payload.status);
                            console.log(event.payload);
                            let status = event.payload.status;
                            if(status === 'referred' || status === 'redirected' || status === 'accepted' || status === 'followup') { // I add this code status === 'followup' to realtime the undo of cancellation in followup status
                                let type = event.payload.form_type;
                                type = type==='normal' ? 'normal-section':'pregnant-section';
                                let referral_type = (type==='normal-section') ? 'normal':'pregnant';
                                let content =
                                    '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
                                    '    <div class="timeline-item '+type+'" id="item-'+event.payload.tracking_id+'">\n' +
                                    '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">'+event.payload.undo_date+'</span></span>\n' +
                                    '        <h3 class="timeline-header no-border">' +
                                    '           <strong class="text-bold">    '+
                                    '           <a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode='+event.payload.patient_code+'" class="patient_name" target="_blank">'+event.payload.patient_name+'</a>' +
                                    '           </strong>'+
                                    '           <small class="status">[ '+event.payload.patient_sex+', '+event.payload.age+' ]</small> was ' ;
                                if(status === 'accepted') {
                                    content +=
                                        '<span class="badge bg-blue">'+event.payload.status+'</span> by <span class="text-warning">Dr. '+event.payload.referred_md+'</span> of <span class="facility">'+event.payload.referred_name+'</span></h3>\n' +
                                        '        <div class="timeline-footer">\n' +
                                        '           <div class="form-group">' ;
                                }else{
                                    content +=
                                        '<span class="badge bg-blue">'+event.payload.status+'</span> to <span class="text-danger">'+event.payload.referred_department+'</span> by <span class="text-warning">Dr. '+event.payload.referring_md+'</span> of <span class="facility">'+event.payload.referring_name+'</span></h3>\n' +
                                        '        <div class="timeline-footer">\n' +
                                        '           <div class="form-group">' ;
                                }

                                if(status !== 'accepted') {
                                    content +=
                                        '                <a class="btn btn-warning btn-xs view_form" href="#referralForm"\n' +
                                        '                   data-toggle="modal"\n' +
                                        '                   data-code="'+event.payload.patient_code+'"\n' +
                                        '                   data-item="#item-'+event.payload.tracking_id+'"\n' +
                                        '                   data-referral_status="referred"\n' +
                                        '                   data-type="'+referral_type+'"\n' +
                                        '                   data-id="'+event.payload.tracking_id+'"\n' +
                                        '                   data-referred_from="'+event.payload.referred_from+'"\n' +
                                        '                   data-patient_name="'+event.payload.patient_name+'"\n' +
                                        '                   data-backdrop="static">\n' +
                                        '                <i class="fa fa-folder"></i> View Form\n' +
                                        '               </a>' ;
                                    if(event.payload.cur_queue !== '') {
                                        content += '<h5 class="text-red pull-right">Queued at <b>'+event.payload.cur_queue+'&emsp;</b></h5>';
                                    }
                                }
                                content +=
                                    this.buttonSeen(event.payload.count_seen, event.payload.tracking_id) +
                                    this.buttonReco(event.payload.patient_code, event.payload.count_reco) ;

                                content +=
                                    '             </div>\n' +
                                    '        </div>\n' +
                                    '    </div>\n';

                                $('#referral_incoming'+event.payload.patient_code).html(content);
                                let msg = event.payload.patient_name + " was referred again by Dr. " + event.payload.referring_md+ " of " +
                                    event.payload.referring_name+ "<br>"+ event.payload.undo_date + '<br><br>\n' +
                                    '       <a href="'+event.payload.redirect_track+'" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                                    '       </a>';
                                this.notifyReferralUndoCancel(event.payload.patient_code, event.payload.activity_id, msg, status);
                            } else if (status === 'rejected') {
                                let content = '' +
                                    '   <i class="fa fa-user-times bg-maroon"></i>\n' +
                                    '   <div class="timeline-item">\n' +
                                    '       <span class="time"><i class="fa fa-calendar"></i>' + event.payload.undo_date + '</span>\n' +
                                    '       <h3 class="timeline-header no-border">\n' +
                                    '           <span>\n' +
                                    '               <a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode=' + event.payload.patient_code + '" target="_blank">' + event.payload.patient_name + '</a>\n' +
                                    '           </span>\n' +
                                    '          was RECOMMENDED TO REDIRECT to other facility by <span class="text-danger">Dr. ' + event.payload.referring_md +'</span>\n' +
                                    '       </h3>\n' +
                                    this.buttonSeen(event.payload.count_seen, event.payload.tracking_id) +
                                    this.buttonReco(event.payload.patient_code, event.payload.count_reco) +
                                    '   </div>';
                                $('#referral_incoming'+event.payload.patient_code).html(content);
                            }
                        }
                    }
                    else if(event.payload.notif_type === "update form") {
                        $('#closeReferralForm'+event.payload.patient_code).click();
                        if(event.payload.faci_changed === true) {
                            if(event.payload.old_facility === this.user.facility_id) {
                                let content =
                                    '    <i class="fa fa-ban bg-red"></i>\n' +
                                    '    <div class="timeline-item ">\n' +
                                    '        <span class="time"><i class="icon fa fa-calendar"></i> <span class="date_activity">'+event.payload.update_date+'</span></span>\n' +
                                    '        <h3 class="timeline-header no-border">' +
                                    '           <span class="text-warning"> Dr. ' + event.payload.referring_md + '</span> of <span class="facility">' + event.payload.referring_name + '</span> updated ' +
                                    '           <strong class="text-bold">    '+
                                    '           <a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode='+event.payload.patient_code+'" class="patient_name" target="_blank">'+event.payload.patient_name+'`s</a>' +
                                    '           </strong>'+
                                    "          form and <span class='text-red'> referred </span> pt to another facility. </h3>\n" +
                                    '        <div class="timeline-footer">\n'+
                                    '           <div class="form-group">' +
                                    this.buttonReco(event.payload.patient_code, event.payload.count_reco)+
                                    '           </div>\n' +
                                    '        </div>\n' +
                                    '    </div>\n';
                                $('#referral_incoming' + event.payload.patient_code).html(content);

                                let msg = event.payload.patient_name + "'s referral form was updated and pt was referred to another facility. <br>" +
                                    event.payload.update_date + '<br><br>\n' +
                                    '       <a href="' + event.payload.redirect_track + '" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                                    '       </a>'
                                ;

                                this.notifyReferralUpdateFormFaciChanged(msg);
                            }
                            if(event.payload.referred_to === this.user.facility_id) {
                                this.playAudio();
                                this.increment_referral++;
                                if($("#referral_page_check").val()) {
                                    console.log("append the refer patient");
                                    $('.count_referral').html(this.increment_referral);
                                    let type = event.payload.form_type;
                                    type = type==='normal' ? 'normal-section':'pregnant-section';
                                    let referral_type = (type==='normal-section') ? 'normal':'pregnant';
                                    let content = '<li id="referral_incoming'+event.payload.patient_code+'">' +
                                        '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
                                        '    <div class="timeline-item '+type+'" id="item-'+event.payload.tracking_id+'">\n' +
                                        '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">'+event.payload.update_date+'</span></span>\n' +
                                        '        <h3 class="timeline-header no-border">' +
                                        '           <strong class="text-bold">    '+
                                        '           <a href="'+$("#broadcasting_url").val()+'/doctor/referred?referredCode='+event.payload.patient_code+'" class="patient_name" target="_blank">'+event.payload.patient_name+'</a>' +
                                        '           </strong>'+
                                        '           <small class="status">[ '+event.payload.patient_sex+', '+event.payload.age+' ]</small> was <span class="badge bg-blue">'+event.payload.status+'</span> to <span class="text-danger">'+event.payload.referred_department+'</span> by <span class="text-warning">Dr. '+event.payload.referring_md+'</span> of <span class="facility">'+event.payload.referring_name+'</span></h3>\n' +
                                        '        <div class="timeline-footer">\n';

                                    content +=  '    <div class="form-group">' +
                                        '                <a class="btn btn-warning btn-xs view_form" href="#referralForm"\n' +
                                        '                   data-toggle="modal"\n' +
                                        '                   data-code="'+event.payload.patient_code+'"\n' +
                                        '                   data-item="#item-'+event.payload.tracking_id+'"\n' +
                                        '                   data-referral_status="referred"\n' +
                                        '                   data-type="'+referral_type+'"\n' +
                                        '                   data-id="'+event.payload.tracking_id+'"\n' +
                                        '                   data-referred_from="'+event.payload.referred_from+'"\n' +
                                        '                   data-patient_name="'+event.payload.patient_name+'"\n' +
                                        '                   data-backdrop="static">\n' +
                                        '                <i class="fa fa-folder"></i> View Form\n' +
                                        '               </a>' +
                                        this.buttonSeen(event.payload.count_seen, event.payload.tracking_id)+
                                        this.buttonReco(event.payload.patient_code, event.payload.count_reco)+
                                        '               <h5 class="text-red blink_new_referral pull-right">New Referral</h5>'+
                                        '             </div>';

                                    content +=   '' +
                                        '        </div>\n' +
                                        '    </div>\n' +
                                        '</li>';

                                    $('.timeline').prepend(content);
                                }
                                this.notifyReferral(event.payload.patient_name, event.payload.referring_md, event.payload.referring_name, event.payload.redirect_track)
                            }
                        }
                        else if(event.payload.faci_changed === false) {
                            if(event.payload.referred_to === this.user.facility_id) {
                                let type = event.payload.form_type;
                                type = type === 'normal' ? 'normal-section' : 'pregnant-section';
                                let referral_type = (type === 'normal-section') ? 'normal' : 'pregnant';
                                let content =
                                    '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
                                    '    <div class="timeline-item ' + type + '" id="item-' + event.payload.tracking_id + '">\n' +
                                    '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">' + event.payload.update_date + '</span></span>\n' +
                                    '        <h3 class="timeline-header no-border">' +
                                    '           <strong class="text-bold">    ' +
                                    '           <a href="' + $("#broadcasting_url").val() + '/doctor/referred?referredCode=' + event.payload.patient_code + '" class="patient_name" target="_blank">' + event.payload.patient_name + '</a>' +
                                    '           </strong>' +
                                    '           <small class="status">[ ' + event.payload.patient_sex + ', ' + event.payload.age + ' ]</small> was <span class="badge bg-blue">' + event.payload.status + '</span> to <span class="text-danger">' + event.payload.referred_department + '</span> by <span class="text-warning">Dr. ' + event.payload.referring_md + '</span> of <span class="facility">' + event.payload.referring_name + '</span></h3>\n' +
                                    '        <div class="timeline-footer">\n' +
                                    '           <div class="form-group">' +
                                    '                <a class="btn btn-warning btn-xs view_form" href="#referralForm"\n' +
                                    '                   data-toggle="modal"\n' +
                                    '                   data-code="' + event.payload.patient_code + '"\n' +
                                    '                   data-item="#item-' + event.payload.tracking_id + '"\n' +
                                    '                   data-referral_status="referred"\n' +
                                    '                   data-type="' + referral_type + '"\n' +
                                    '                   data-id="' + event.payload.tracking_id + '"\n' +
                                    '                   data-referred_from="' + event.payload.referred_from + '"\n' +
                                    '                   data-patient_name="' + event.payload.patient_name + '"\n' +
                                    '                   data-backdrop="static">\n' +
                                    '                <i class="fa fa-folder"></i> View Form\n' +
                                    '               </a>' +
                                    this.buttonSeen(event.payload.count_seen, event.payload.tracking_id) +
                                    this.buttonReco(event.payload.patient_code, event.payload.count_reco) +
                                    '               <h5 class="text-red blink_new_referral pull-right">FORM HAS BEEN UPDATED!</h5>' +
                                    '             </div>\n' +
                                    '        </div>\n' +
                                    '    </div>\n';

                                $('#referral_incoming' + event.payload.patient_code).html(content);

                                let msg = event.payload.patient_name + "'s referral form was updated by Dr. " +
                                    event.payload.referring_md + " of " + event.payload.referring_name + " <br> " +
                                    event.payload.update_date + '<br><br>\n' +
                                    '       <a href="' + event.payload.redirect_track + '" class=\'btn btn-xs btn-warning\' target=\'_blank\'>\n' +
                                    '           <i class=\'fa fa-stethoscope\'></i> Track\n' +
                                    '       </a>'
                                ;

                                this.notifyReferralUpdateFormFaciSame(msg);
                            }
                        }
                    }
                    else if(event.payload.notif_type === "queue patient") {
                        console.log("que at::", event.payload);
                        if(event.payload.referred_from === this.user.facility_id) {
                            this.notifyReferralQueueUpdated(event.payload.patient_code, event.payload.activity_id, event.payload.remarks, event.payload.date_queued, event.payload.patient_name, event.payload.queued_by, event.payload.queued_by_facility, event.payload.redirect_track, event.payload.first_queue);
                        }
                    }
                });

            Echo.join('admin_notifs')
                .listen('AdminNotifs', (event) => {
                    if(this.user.level === "admin") {
                        if(event.payload.notif_type === "new walkin") {
                            this.notifyNewWalkin(event.payload.patient_name, event.payload.referred_to, event.payload.date_referred);
                        }
                        else if(event.payload.notif_type === "new appointment") {
                            this.notifyNewAppointment(event.payload.appt_faci, event.payload.appt_requester, event.payload.date_requested);
                        }
                        else if(event.payload.notif_type === "new feedback") {
                            this.notifyNewUserFeedback(event.payload.date_submitted);
                        }
                    }
            });
        }
    }
</script>

<style scoped>

    .callModal {
        position: fixed;
        left: 0;
        right: 0;
        margin-top: 15%;
        margin-bottom: 10%;
        background: rgba(0,0,0,0);
    }
    .modal-body {
        padding-left: 10px;
        padding-right: 10px;
        border: 4px solid black;
        border-radius: 5px;
    }
    .modal-content {
        padding: 20px;
    }
    .txt{
        font-weight: bold;
        font-size: 1.5em;
        padding: 3px;
    }
    .isCalling {
        font-weight: bold;
        font-size: 1.3em;
    }
    .acceptButton{
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: green;
        font-size: 24px;
        cursor: pointer;
        left: 15px;
    }
    .acceptButton i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .ignoreButton {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: red;
        font-size: 24px;
        cursor: pointer;
        right: 15px;
    }
    .ignoreButton i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .textAccept {
        text-align: center;
        font-size: 14px;
        margin-top: 15px;
        margin-bottom: 10px;
        margin-left: 30px;
    }
    .textDecline {
        text-align: center;
        font-size: 14px;
        margin-top: 15px;
        margin-right: 28px;
    }
</style>