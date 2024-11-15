<script>
    <?php $user = Session::get('auth');?>
    var code,
        item,
        status,
        patient_name,
        facility,
        referred_from,
        referred_name,
        type,
        form_id,
        age,
        sex,
        id,
        form_type,
        referring_name,
        referring_contact,
        referring_md_contact;
    var my_facility_name = "{{ \App\Facility::find($user->facility_id)->name }}";
    var my_department_id = "{{ $user->department_id }}";
    var my_contact = "{{ $user->contact }}";
</script>

<script>
    /*var action_md = "{{ $user->fname }} {{ $user->mname }} {{ $user->lname }}";
    referred_name = action_md;
    var content = '';
    connRef.child(myfacility).on('child_added', function(snapshot) {
        console.log(myfacility);
        console.log("append the refer patient");
        var data = snapshot.val();
        var type = data.form_type;
        type = (type=='#normalFormModal') ? 'normal-section':'pregnant-section';
        var referral_type = (type=='normal-section') ? 'normal':'pregnant';
        $('.count_referral').html(count_referral);
        $('.alert-section').empty();
        content = '<li>' +
            '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
            '    <div class="timeline-item '+type+'" id="item-'+data.tracking_id+'">\n' +
            '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">'+data.date+'</span></span>\n' +
            '        <h3 class="timeline-header no-border"><a href="#" class="patient_name">'+data.patient_name+'</a> <small class="status">[ '+data.sex+', '+data.age+' ]</small> was <span class="badge bg-blue">referred</span> to <span class="text-danger">'+data.department_name+'</span> by <span class="text-warning">Dr. '+data.referring_md+'</span> of <span class="facility">'+data.referring_name+'</span></h3>\n' +
            '        <div class="timeline-footer">\n';

        if(my_department_id==data.department_id){
            content +=  '    <a class="btn btn-warning btn-xs view_form" href="#referralForm"\n' +
                '               data-toggle="modal"\n' +
                '               data-code="'+data.patient_code+'"\n' +
                '               data-item="#item-'+data.tracking_id+'"\n' +
                '               data-referral_status="referred"\n' +
                '               data-type="'+referral_type+'"\n' +
                '               data-id="'+data.tracking_id+'"\n' +
                '               data-referred_from="'+data.referred_from+'"\n' +
                '               data-patient_name="'+data.patient_name+'"\n' +
                '               data-backdrop="static">\n' +
                '                <i class="fa fa-folder"></i> View Form\n' +
                '            </a>' +
                '<h5 class="text-red blink_new_referral pull-right">New Referral</h5>';
        }

         content +=   '' +
            '        </div>\n' +
            '    </div>\n' +
            '</li>';

        $('.timeline').prepend(content);

    });*/
</script>

@include('script.view_form')

{{--Firebase On Child Added in Seen, Reject and Accept--}}
{{--<script>
    var accepts = dbRef.ref('Accept');
    var rejects = dbRef.ref('Reject');
    var seen = dbRef.ref('Seen');
    var redirected = dbRef.ref('Redirected');

    accepts.on('child_added',function(snapshot){
        var data = snapshot.val();
        var form = $('#item-'+data.item).parent();
        var content = '<i class="fa fa-user-plus bg-olive"></i>\n' +
            '<div class="timeline-item">\n' +
            '    <span class="time"><i class="fa fa-user-plus"></i> '+data.date+'</span>\n' +
            '    <h3 class="timeline-header no-border"><a href="#">'+data.patient_name+'</a> was ACCEPTED by <span class="text-success">Dr. '+data.action_md+'</span></h3>\n' +
            '\n' +
            '</div>';
        form.html(content);
    });

    rejects.on('child_added',function(snapshot){
        console.log("test the redirected!");
        var data = snapshot.val();
        var form = $('#item-'+data.item).parent();
        var content = '<i class="fa fa-user-times bg-maroon"></i>\n' +
            '<div class="timeline-item">\n' +
            '    <span class="time"><i class="fa fa-calendar"></i> '+data.date+'</span>\n' +
            '    <h3 class="timeline-header no-border"><a href="#">'+data.patient_name+'</a> RECOMMENDED TO REDIRECT to other facility by <span class="text-danger">Dr. '+data.action_md+'</span></h3>\n' +
            '\n' +
            '</div>';
        form.html(content);
    });

    redirected.on('child_added',function(snapshot){
        console.log("test the redirected!");
        var data = snapshot.val();
        var type = data.form_type;
        type = (type=='#normalFormModal') ? 'normal-section':'pregnant-section';
        var referral_type = (type=='normal-section') ? 'normal':'pregnant';
        $('.count_referral').html(count_referral);
        $('.alert-section').empty();
        content = '<li>' +
            '    <i class="fa fa-ambulance bg-blue-active"></i>\n' +
            '    <div class="timeline-item '+type+'" id="item-'+data.tracking_id+'">\n' +
            '        <span class="time"><i class="icon fa fa-ambulance"></i> <span class="date_activity">'+data.date+'</span></span>\n' +
            '        <h3 class="timeline-header no-border"><a href="#" class="patient_name">'+data.name+'</a> <small class="status">[ '+data.sex+', '+data.age+' ]</small> was <span class="badge bg-blue">redirected</span> to <span class="text-danger">'+data.department_name+'</span> by <span class="text-warning">Dr. '+data.referring_md+'</span> of <span class="facility">'+data.referring_name+'</span></h3>\n' +
            '        <div class="timeline-footer">\n';

        if(my_department_id==data.department_id){
            content +=  '            <a class="btn btn-warning btn-xs btn-refer" href="'+data.form_type+'"\n' +
                '               data-toggle="modal"\n' +
                '               data-code="'+data.patient_code+'"\n' +
                '               data-item="#item-'+data.tracking_id+'"\n' +
                '               data-status="referred"\n' +
                '               data-type="'+referral_type+'"\n' +
                '               data-id="'+data.tracking_id+'"\n' +
                '               data-referred_from="'+data.referred_from+'"\n' +
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
    });

    seen.on('child_added',function(snapshot){
        var data = snapshot.val();
        console.log(data);
        var item = '#item-'+data.item;
        var date = data.date;

        $(item).removeClass('pregnant-section normal-section').addClass('read-section');
        $(item).find('.icon').removeClass('fa-ambulance').addClass('fa-eye');
        $(item).find('.date_activity').html(date);
    });
</script>--}}

{{--when call button is click--}}
<script>
$('body').on('click','.btn_call_request',function(){
    console.log("btn_call_request");
    $('.referring_contact').html(referring_contact);
    $('.referring_md_contact').html(referring_md_contact);
    $.ajax({
        url: "{{ url('doctor/referral/calling/') }}/" + form_id,
        type: 'GET',
        success: function(data) {
            /*console.log(data);
            var callRef = dbRef.ref('Call');
            var call_data = {
                date: data.date, //can be change to returne date
                facility_calling: my_facility_name,
                action_md: action_md,
                tracking_id: form_id,
                code: code,
                contact: my_contact,
                activity_id: data.activity_id,
                referred_from: referred_from,
                referred_name: referred_name
            };
            callRef.push(call_data);
            callRef.on('child_added',function(data){
                setTimeout(function(){
                    callRef.child(data.key).remove();
                    $('.loading').hide();
                },300);
            });*/
        },
        error: function(error){
            console.log(error);
            $('#serverModal').modal();
        }
    });
});
</script>

{{--SEEN BY--}}
<script>
    $('body').on('click','.btn-seen',function(){
        var de = '<hr />\n' +
            '                    LOADING...\n' +
            '                    <br />\n' +
            '                    <br />';
        $('#seenBy_section').html(de);
        var id = $(this).data('id');
        var seenUrl = "{{ url('doctor/referral/seenBy/list/') }}/"+id;
        $.ajax({
            url: seenUrl,
            type: "GET",
            success: function(data){
                var content = '<div class="list-group">';

                jQuery.each(data, function(i,val){
                    content += '<a href="#" class="list-group-item clearfix">\n' +
                        '<strong class="text-green">Dr. '+val.user_md+'</strong>\n' +
                        '<br />\n' +
                        '<small>\n' +
                        'Facility: <b>'+val.facility_name+'</b>\n' +
                        '</small>\n' +
                        '<br />\n' +
                        '<small>\n' +
                        'Seen: <b>'+val.date_seen+'</b>\n' +
                        '</small>\n' +
                        '<br />\n' +
                        '<small>\n' +
                        'Contact: <b>'+val.contact+'</b>\n' +
                        '</small>\n' +
                        '</a>';
                });

                content += '</div>';
                setTimeout(function () {
                    $('#seenBy_section').html(content);
                },500);
            },
            error: function () {
                $('#serverModal').modal('show');
            }
        });
    });

    $('body').on('click','.btn-caller',function(){
        var de = '<hr />\n' +
            '                    LOADING...\n' +
            '                    <br />\n' +
            '                    <br />';
        $('#callerBy_section').html(de);
        var id = $(this).data('id');
        var callerUrl = "{{ url('doctor/referral/callerBy/list/') }}/"+id;
        $.ajax({
            url: callerUrl,
            type: "GET",
            success: function(data){
                var content = '<div class="list-group">';

                jQuery.each(data, function(i,val){
                    content += '<a href="#" class="list-group-item clearfix">\n' +
                        '<span class="title-info">'+val.user_md+'</span>\n' +
                        '<br />\n' +
                        '<small class="text-primary">\n' +
                        'Time: '+val.date_call+'\n' +
                        '</small>\n' +
                        '<br />\n' +
                        '<small class="text-success">\n' +
                        'Contact: '+val.contact+'\n' +
                        '</small>\n' +
                        '</a>';
                });
                content += '</div>';
                setTimeout(function () {
                    $('#callerBy_section').html(content);
                },500);
            },
            error: function () {
                $('#serverModal').modal('show');
            }
        });
    });
</script>