<script>
    <?php $user = Session::get('auth'); ?>

    /*var arriveRef = dbRef.ref('Arrival');
    var admitRef = dbRef.ref('Admit');
    var dischargetRef = dbRef.ref('Discharge');
    var transferRef = dbRef.ref('Transfer');*/
    var referred_name = '';
    //initializes variables
    var current_facility, code, patient_name, track_id, form_type;
    current_facility = "{{ \App\Facility::find($user->facility_id)->name }}";

    $('body').on('click','.btn-action',function(){
        code = $(this).data('code');
        patient_name = $(this).data('patient_name');
        track_id = $(this).data('track_id');
    });

    $('#arriveForm').on('submit',function(e){
        $("#arrived_button").attr('disabled',true);
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/arrive/') }}/" + track_id,
            type: 'POST',
            success: function() {
                window.location.reload(true);
            },
            error: function(){

            }
        });
    });

    $('#archiveForm').on('submit',function(e){
        $("#notarrived_button").attr('disabled',true);
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/archive/') }}/" + track_id,
            type: 'POST',
            success: function(){
                window.location.reload(true);
            }
        });
    });

    $('#admitForm').on('submit',function(e){
        $("#admitted_button").attr('disabled',true);
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/admit/') }}/" + track_id,
            type: 'POST',
            success: function(){
                window.location.reload(true);
            }
        });
    });


    $('#dischargeForm').on('submit',function(e){
        $("#discharged_button").attr('disabled',true);
        $(this).ajaxSubmit({
            url: "{{ url('doctor/referral/discharge/') }}/" + track_id,
            type: 'POST',
            success: function(date){
                window.location.reload(true);
            }
        });
    });

    $('.select_facility').on('change',function(){
        var id = $(this).val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.facility_address').html(data.address);

                $('.select_department').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.select_department').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
            },
            error: function(){
                $('#serverModal').modal();
            }
        });

    });

    $('body').on('click','.btn-transfer',function() {
        $("#transfer_tracking_id").val($(this).data("track_id"));
    });

    $('body').on('submit','#referAcceptForm',function(e) {
        console.log("Transfer submit!");
        $("#transferred_submit").attr("disabled",true);
    });

    $('.view_form').on('click',function() {
        $(".referral_body").html(loading);
        code = $(this).data('code');
        form_type = $(this).data('type');
        id = $(this).data('id');

        $('#normalFormModal').find('span').html('');
        $('#pregnantFormModal').find('span').html('');

        if(form_type=='normal'){
            $(".referral_body").html(loading);
            $.ajax({
                url: "{{ url('doctor/referral/data/normal') }}/"+id+"/referring/normal",
                type: "GET",
                success: function(data) {
                    setTimeout(function() {
                        $(".referral_body").html(data);
                    },300);
                },
                error: function(){
                    $('#serverModal').modal();
                }
            });
        }else{
            $(".referral_body").html(loading);
            $.ajax({
                url: "{{ url('doctor/referral/data/pregnant') }}/"+id+"/referring/pregnant",
                type: "GET",
                success: function(data) {
                    setTimeout(function() {
                        $(".referral_body").html(data);
                    },300);
                },
                error: function(){
                    $('#serverModal').modal();
                }
            });
        }
    });


    function getPregnantForm()
    {
        $.ajax({
            url: "{{ url('doctor/referral/data/pregnant') }}/"+id,
            type: "GET",
            success: function(record){
                console.log(record);
                var print_url = "{{ url('doctor/print/form/') }}/"+id;
                $('.btn-refer-pregnant').attr('href',print_url);
                $('.button_option').hide();
                var data = record.form;
                var baby = record.baby;
                var patient_address='';
                var referred_address= '';

                patient_address += (data.patient_brgy) ? data.patient_brgy+', ': '';
                patient_address += (data.patient_muncity) ? data.patient_muncity+', ': '';
                patient_address += (data.patient_province) ? data.patient_province: '';

                referred_address += (data.ff_brgy) ? data.ff_brgy+', ': '';
                referred_address += (data.ff_muncity) ? data.ff_muncity+', ': '';
                referred_address += (data.ff_province) ? data.ff_province: '';

                var woman_major_findings = data.woman_major_findings;
                if (/\n/g.test(woman_major_findings))
                {
                    woman_major_findings = woman_major_findings.replace(/\n/g, '<br>');
                }

                var woman_information_given = data.woman_information_given;
                if (/\n/g.test(woman_information_given))
                {
                    woman_information_given = woman_information_given.replace(/\n/g, '<br>');
                }

                if(baby){
                    var baby_major_findings = baby.baby_major_findings;
                    if (/\n/g.test(baby_major_findings))
                    {
                        baby_major_findings = baby_major_findings.replace(/\n/g, '<br>');
                    }

                    var baby_information_given = baby.baby_information_given;
                    if (/\n/g.test(baby_information_given))
                    {
                        baby_information_given = baby_information_given.replace(/\n/g, '<br>');
                    }
                }

                age = data.woman_age;
                sex = data.sex;
                referring_contact = data.referring_contact;
                referring_md_contact = data.referring_md_contact;
                referred_name = data.referring_facility;

                $('span.record_no').html(data.record_no);
                $('span.arrival_date').html(data.arrival_date);
                $('span.referred_date').html(data.referred_date);
                $('span.md_referring').html(data.md_referring);
                $('span.referring_md_contact').html(data.referring_md_contact);
                $('span.referring_facility').html(data.referring_facility);
                $('span.department_name').html(data.department);
                $('span.referring_contact').html(data.referring_contact);
                $('span.referred_name').html(data.referred_facility);
                $('span.referred_address').html(referred_address);
                $('span.facility_brgy').html(data.facility_brgy);
                $('span.facility_muncity').html(data.facility_muncity);
                $('span.facility_province').html(data.facility_province);
                $('span.health_worker').html(data.health_worker);
                $('span.woman_name').html(data.woman_name);
                $('span.woman_age').html(data.woman_age);
                $('span.woman_address').html(patient_address);
                $('span.woman_reason').html(data.woman_reason);
                $('span.woman_major_findings').html(woman_major_findings);
                $('span.woman_before_treatment').html(data.woman_before_treatment);
                $('span.woman_before_given_time').html(data.woman_before_given_time);
                $('span.woman_during_transport').html(data.woman_during_transport);
                $('span.woman_transport_given_time').html(data.woman_transport_given_time);
                $('span.woman_information_given').html(woman_information_given);

                if(baby){

                    $('span.baby_name').html(baby.baby_name);
                    $('span.baby_dob').html(baby.baby_dob);
                    $('span.weight').html(baby.weight);
                    $('span.gestational_age').html(baby.gestational_age);
                    $('span.baby_reason').html(baby.baby_reason);
                    $('span.baby_major_findings').html(baby_major_findings);
                    $('span.baby_last_feed').html(baby.baby_last_feed);
                    $('span.baby_before_treatment').html(baby.baby_before_treatment);
                    $('span.baby_before_given_time').html(baby.baby_before_given_time);
                    $('span.baby_during_transport').html(baby.baby_during_transport);
                    $('span.baby_transport_given_time').html(baby.baby_transport_given_time);
                    $('span.baby_information_given').html(baby_information_given);
                }

                $('span.covid_number').html(data.covid_number);
                $('span.clinical_status').html(data.refer_clinical_status);
                $('span.surveillance_category').html(data.refer_sur_category);

                $('.loading').hide();
            },
            error: function(){
                $('#serverModal').modal();
                $('.loading').hide();
            }
        });
    }
</script>