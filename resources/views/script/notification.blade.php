<script>
    <?php $user=Session::get('auth');?>
    var acceptRef = dbRef.ref('Accept');
    var rejectRef = dbRef.ref('Reject');
    var callRef = dbRef.ref('Call');
    var arriveRef = dbRef.ref('Arrival');
    var admitRef = dbRef.ref('Admit');
    var dischargeRef = dbRef.ref('Discharge');
    var transferRef = dbRef.ref('Transfer');
    var feedbackRef = dbRef.ref('Feedback');

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

        var action_md = data.action_md;
        var facility_calling = data.facility_calling;

        var msg = 'Dr. '+action_md+' of '+facility_calling+' is requesting a call from '+data.referred_name+
            '<br />'+ data.date;
        var msg2 = 'Dr. '+action_md+' of '+facility_calling+' is requesting a call from '+data.referred_name+
            '\n'+ data.date;
        verify(data.code,'warning','Requesting a Call',msg,msg2);
    });

    arriveRef.on('child_added',function(snapshot){

        var data = snapshot.val();
        console.log(data);
        var patient_name = data.patient_name;
        var current_facility = data.current_facility;

        var msg = patient_name+' arrived at '+current_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+' arrived at '+current_facility+
            '\n'+ data.date;
        verify(data.code,'success','Arrived',msg,msg2);
    });

    admitRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var patient_name = data.patient_name;
        var current_facility = data.current_facility;

        var msg = patient_name+' admitted at '+current_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+' admitted at '+current_facility+
            '\n'+ data.date;
        verify(data.code,'info','Admitted',msg,msg2);
    });

    dischargeRef.on('child_added',function(snapshot){
        var data = snapshot.val();
        var date = data.date;
        var patient_name = data.patient_name;
        var current_facility = data.current_facility;

        var msg = patient_name+' discharged from '+current_facility+
            '<br />'+ data.date;
        var msg2 = patient_name+' discharged from '+current_facility+
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
            url: "{{ url('doctor/verify/') }}/"+ code,
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
        var doctor_name = $.ajax({
            async: false,
            url: "{{ url('doctor/name/') }}/"+data.user_id,
            success: function(name){
                return name;
            }
        }).responseText;

        var msg = "From: "+doctor_name+"<br>Code: "+data.code+"<br>Message: "+data.msg;
        var msg2 = "From: "+doctor_name+"\nCode: "+data.code+"\nMessage: "+data.msg;
        verify(data.code,'Success','New Feedback',msg,msg2);
        {{--if(data.user_id != "{{ $user->id }}"){--}}
            {{----}}
        {{--}--}}
    });

</script>