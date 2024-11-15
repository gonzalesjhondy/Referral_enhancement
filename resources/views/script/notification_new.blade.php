<script>
    <?php $user = Session::get('auth');?>
    var acceptRef = dbRef.ref('Accept');
    var rejectRef = dbRef.ref('Reject');
    var callRef = dbRef.ref('Call');
    var arriveRef = dbRef.ref('Arrival');
    var admitRef = dbRef.ref('Admit');
    var dischargeRef = dbRef.ref('Discharge');
    var transferRef = dbRef.ref('Transfer');
    var feedbackRef = dbRef.ref('Feedback');
    var redirectedRef = dbRef.ref('Redirected');

    acceptRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var action_md = data.action_md;
        var facility_name = data.facility_name;
        var patient_name = data.patient_name;

        var msg = patient_name+'  was accepted by Dr. '+action_md+' of '+facility_name+
            '<br />'+ data.date;
        var msg2 = patient_name+'  was accepted by Dr. '+action_md+' of '+facility_name+
            '\n'+ data.date;
        verify(data.code,'success','Accepted',msg,msg2);
    });

    rejectRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var patient_name = data.patient_name;
        var action_md = data.action_md;
        var old_facility = data.old_facility;

        var msg = 'Dr. '+action_md+' of '+old_facility+' recommended to redirect '+patient_name+' to other facility.'+
            '<br />'+ data.date;
        var msg2 = 'Dr. '+action_md+' of '+old_facility+' recommended to redirect '+patient_name+' to other facility.'+
            '\n'+ data.date;
        verify(data.code,'error','Redirected',msg,msg2);
    });

    callRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        console.log(data);

        var action_md = data.action_md;
        var facility_calling = data.facility_calling;

        var msg = 'Dr. '+action_md+' of '+facility_calling+' is requesting a call. <br />'+ data.date;
        var msg2 = 'Dr. '+action_md+' of '+facility_calling+' is requesting a call. \n'+ data.date;
        verify(data.code,'warning','Requesting a Call',msg,msg2);
    });

    arriveRef.on('child_added',function(snapshot){

        var data = snapshot.val();
        console.log(data);
        var patient_name = data.patient_name;
        var current_facility = data.current_facility;

        var msg = patient_name+' has arrived at '+current_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+' has arrived at '+current_facility+
            '\n'+ data.date;
        verify(data.code,'success','Arrived',msg,msg2);
    });

    admitRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var patient_name = data.patient_name;
        var current_facility = data.current_facility;

        var msg = patient_name+' was admitted at '+current_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+' was admitted at '+current_facility+
            '\n'+ data.date;
        verify(data.code,'info','Admitted',msg,msg2);
    });

    dischargeRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var date = data.date;
        var patient_name = data.patient_name;
        var current_facility = data.current_facility;

        var msg = patient_name+' was discharged from '+current_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+' was discharged from '+current_facility+
            '\n'+ data.date;
        verify(data.code,'info','Discharged',msg,msg2);
    });

    transferRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var date = data.date;
        var patient_name = data.patient_name;
        var action_md = data.action_md;
        var old_facility = data.old_facility;
        var new_facility = data.new_facility;

        var msg = patient_name+'  was referred by Dr. '+action_md+' of '+old_facility+' to '+new_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+'  was referred by Dr. '+action_md+' of '+old_facility+' to '+new_facility+
            '<br />'+ data.date;
        verify(data.code,'warning','Transferred',msg,msg2);

    });

    redirectedRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        console.log("redirected-wew notification_new");
        console.log(data);
        $.ajax({
            url: "{{ url('doctor/verify_redirected/') }}/"+data.code,
            type: "GET",
            success: function(flag){
                console.log(flag);
                if(flag==1) {
                    var count_referral = $('.count_referral').html();

                    Lobibox.notify('success', {
                        delay: false,
                        title: 'New Redirected',
                        msg: data.patient_name+' was redirected by Dr. '+data.referring_md+' of '+data.referring_facility,
                        img: "{{ url('resources/img/ro7.png') }}",
                        sound: false
                    });

                    count_referral = parseInt(count_referral);
                    count_referral += 1;
                    $('.count_referral').html(count_referral);

                    var type = data.form_type;
                    type = (type=='#normalFormModal') ? 'normal-section':'pregnant-section';
                    var referral_type = (type=='normal-section') ? 'normal':'pregnant';

                    $('.alert-section').empty();

                    content = '<li>' +
                        '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
                        '    <div class="timeline-item '+type+'" id="item-'+data.tracking_id+'">\n' +
                        '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">'+data.date+'</span></span>\n' +
                        '        <h3 class="timeline-header no-border"><a href="#" class="patient_name">'+data.patient_name+'</a> <small class="status">[ '+data.sex+', '+data.age+' ]</small> was <span class="badge bg-blue">redirected</span> to <span class="text-danger">'+data.department_name+'</span> by <span class="text-warning">Dr. '+data.referring_md+'</span> of <span class="facility">'+data.referring_facility+'</span></h3>\n' +
                        '        <div class="timeline-footer">\n';

                    var my_department_id = "{{ $user->department_id }}";
                    if(my_department_id==data.department_id) {
                        content +=  '<a class="btn btn-warning btn-xs view_form" href="#referralForm"\n' +
                            '               data-toggle="modal"\n' +
                            '               data-code="'+data.code+'"\n' +
                            '               data-item="#item-'+data.activity_id+'"\n' +
                            '               data-referral_status="redirected"\n' +
                            '               data-type="'+referral_type+'"\n' +
                            '               data-id="'+data.track_id+'"\n' +
                            '               data-referred_from="'+data.referred_from+'"\n' +
                            '               data-patient_name="'+data.patient_name+'"\n' +
                            '               data-backdrop="static">\n' +
                            '                <i class="fa fa-folder"></i> View Form\n' +
                            '            </a>' +
                            '<h5 class="text-red blink_new_referral pull-right">New Redirected</h5>';
                    }

                    content +=   '' +
                        '        </div>\n' +
                        '    </div>\n' +
                        '</li>';

                    $('.timeline').prepend(content);

                }
            }
        });

    });

    //MAO NI SIYA ANG REALTIME NORFICATION SA MGA TENANT

    function lobibox(status,title,msg)
    {
        Lobibox.notify(status, {
            delay: false,
            title: title,
            msg: msg,
            img: "{{ url('resources/img/ro7.png') }}",
            sound: false
        });
    }

    function verify(code,status,title,msg,msg2)
    {
        $.ajax({
            url: "{{ url('doctor/verify/') }}/"+code,
            type: "GET",
            success: function(data){
                if(data==1){
                    lobibox(status,title,msg);
                    desktopNotification(title,msg2);
                }
            }
        });
    }

    feedbackRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        console.log(data);
        $.ajax({
            async: false,
            url: "{{ url('doctor/feedback_send/') }}/"+data.code+"/"+data.user_id+"/"+data.msg,
            success: function(result){
                console.log(result);
                if(result.isNotify == "true"){
                    $(".reco-body").append(result.feedback_receiver);
                    try{
                        var objDiv = document.getElementById(code);
                        objDiv.scrollTop = objDiv.scrollHeight;
                    } catch(err){
                        console.log("modal not open");
                    }
                    Lobibox.notify("success", {
                        title: data.code,
                        size: 'normal',
                        sound: false,
                        delay: false,
                        closeOnClick: false,
                        img: result.picture,
                        msg: result.content
                    });
                }
            }
        });
    });

</script>