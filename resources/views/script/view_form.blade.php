{{--Normal and Pregnant Form--}}
<script>
    $('body').on('click','.view_form',function () {
        code = $(this).data('code');
        item = $(this).data('item');
        status = $(this).data('status');
        type = $(this).data('type');
        form_id = $(this).data('id');
        referred_from = $(this).data('referred_from');
        patient_name = $(this).data('patient_name');
        facility = $(item).find('.facility').html();
        var referral_status = $(this).data('referral_status');

        if(type === 'normal') {
            form_type = '#referralForm';
            var form_url = "{{ url('doctor/referral/data/normal') }}/"+form_id+"/"+referral_status+"/"+type;
            $(".referral_body").html(loading);
            $.ajax({
                url: form_url,
                type: "GET",
                success: function(data) {
                    console.log("normal");
                    setTimeout(function(){
                        $(".referral_body").html(data);
                    },300);
                },
                error: function(){
                    $('#serverModal').modal();
                }
            });
        }
        else if(type === 'pregnant') {
            form_type = '#referralForm';
            $(".referral_body").html(loading);
            console.log("pregnant");
            $.ajax({
                url: "{{ url('doctor/referral/data/pregnant') }}/"+form_id+"/"+referral_status+"/"+type,
                type: "GET",
                success: function(request){
                    setTimeout(function() {
                        $(".referral_body").html(request);
                    },300);
                },
                error: function(){
                    $('#serverModal').modal();
                }
            });

        }

        if(referral_status === 'referred' || referral_status === 'redirected' || referral_status === 'transferred') {
            var seenUrl = "{{ url('doctor/referral/seenBy_save/') }}/"+form_id+"/"+code;
            $.ajax({
                url: seenUrl,
                type: "GET",
                success: function(result){

                },
                error: function(){
                    console.log('error');
                }
            });
        }

    });

    $('body').on('submit','#acceptForm',function(e) {
        e.preventDefault();
        $('.loading').show();
        var tracking_id = form_id;
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/accept/') }}/" + tracking_id,
            type: 'POST',
            success: function () {
                window.location.reload(false);
                /*if(tracking_id=='denied') {
                    window.location.reload(false);
                } else {
                    console.log(patient_name);
                    var acceptRef = dbRef.ref('Accept');
                    acceptRef.push({
                        date: getDateReferred(),
                        item: tracking_id,
                        facility_name: "{{ \App\Facility::find($user->facility_id)->name }}",
                        action_md: action_md,
                        patient_name: patient_name,
                        code: code,
                        reason: reason
                    });
                    acceptRef.on('child_added',function(data){
                        setTimeout(function(){
                            acceptRef.child(data.key).remove();
                            window.location.reload(false);
                        },500);
                    });
                }*/
            }
        });
    });

    $('body').on('submit','#rejectForm',function(e) {
        e.preventDefault();
        $('.loading').show();
        referred_to = $('.new_facility').val();
        var old_facility = "{{ \App\Facility::find($user->facility_id)->name }}";
        var reason = $('.reject_reason').val();
        referring_name = old_facility;
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/reject/') }}/"+form_id,
            type: 'POST',
            success: function(tracking_id) {
                window.location.reload(false);
                console.log('hellllloooo',tracking_id);
                /*if(tracking_id=='denied')
                {
                    window.location.reload(false);
                }else{
                    var rejectRef = dbRef.ref('Reject');
                    rejectRef.push({
                        date: getDateReferred(),
                        item: form_id,
                        activity_id: tracking_id,
                        old_facility: old_facility,
                        action_md: action_md,
                        patient_name: patient_name,
                        code: code,
                        reason: reason,
                        referred_from: referred_from
                    });

                    rejectRef.on('child_added',function(data){
                        setTimeout(function(){
                            rejectRef.child(data.key).remove();
                            window.location.reload(false);
                        },500);
                    });
                }*/
            },
            error: function() {
                $('#serverModal').modal();
            }
        });
    });

    $('body').on('click', '.exit_edit_btn', function (e) {
       $('#editReferralForm').hide();
       $('#referralForm').show();
    });
    $('body').on('click','.edit_form_btn',function(e) {
        $('#referralForm').hide();
        form_id = $(this).data('id');
        type = $(this).data('type');
        status = $(this).data('referral_status');

        var form_url = "{{ url('doctor/referral/edit_info') }}/"+form_id+"/"+type+"/"+status;
        $(".edit_referral_body").html(loading);
        $.ajax({
            url: form_url,
            type: "GET",
            success: function(data) {
                console.log("form url: " + form_url);
                setTimeout(function(){
                    $('.edit_referral_body').html(data);
                },300);
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    });

    $('body').on('click','.undo_cancel_btn',function(e) {
        form_id = $(this).data('id');
        $('#undo_cancel_id').val(form_id);
    });

    $('body').on('click','.queuebtn',function(e) {
        $('#queue_id').val($(this).data('id'));
    });

    $('body').on('submit', '#updateQueue',function (e) {
        e.preventDefault();
        $('.loading').show();
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/queuePatient/') }}",
            type: 'POST',
            success: function (data) {
                console.log(data);
                window.location.reload(false);
            }
        });
    });

    function getDateReferred()
    {
        var date = new Date();
        var months=["Jan","Feb","Mar","Apr","May","Jun","Jul",
            "Aug","Sep","Oct","Nov","Dec"];

        var day = (date.getDate()<10) ? "0"+date.getDate(): date.getDate();
        var val = months[date.getMonth()]+" "+day+", "+date.getFullYear();
        var hours = (date.getHours()<10) ? "0"+date.getHours(): date.getHours();
        var min = (date.getMinutes()<10) ? "0"+date.getMinutes():date.getMinutes();
        var mid = 'AM';
        if(hours==0){
            hours=12;
        }else if(hours>12){
            hours = hours - 12;
            mid = 'PM';
        }

        val +=" "+hours+":"+min+" "+mid;
        return val;
    }

</script>