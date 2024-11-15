<input type="hidden" id="edit_referred_other_reason_pregnant" value="{{ $form['pregnant']->other_reason_referral }}">
<script>
    $('#diag_prompt').hide();

    $("#edit_save_btn").on('click',function(e){
        if(!($('input[name="icd_ids[]"]').val()) && !($(".other_diagnosis").val())){
            e.preventDefault();
            $('#diag_prompt').show();
            $('#diag_prompt').focus();
            return false;
        }
    });

    $('.edit_normal_form').on('submit', function() {
        $("#edit_save_btn").attr('disabled', true);
    });

    $('.edit_facility_pregnant').val("<?php echo $form['pregnant']->referred_facility_id;?>");

    setDepartment();
    function setDepartment() {
        var id = $('.edit_facility_pregnant').val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.edit_department_pregnant').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.edit_department_pregnant').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
                $('.edit_department_pregnant').val("<?php echo $form['pregnant']->department_id;?>");
            },
            error: function(){
                $('#serverModal').modal();
            }
        });
    }

    $('.edit_facility_pregnant').on('change',function(){
        var id = $(this).val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.edit_department_pregnant').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.edit_department_pregnant').append($('<option>', {
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

    /* INITIALIZE WOMAN VALUES */
    $('.covid_number').val("<?php echo $form['pregnant']->covid_number;?>");
    $('.clinical_status').val("<?php echo $form['pregnant']->refer_clinical_status;?>");
    $('.surve_category').val("<?php echo $form['pregnant']->refer_sur_category;?>");
    $('.woman_before_treatment').val("<?php echo $form['pregnant']->woman_before_treatment;?>");
    $('.woman_before_given_time').val("<?php echo $form['pregnant']->woman_before_given_time;?>");
    $('.woman_during_transport').val("<?php echo $form['pregnant']->woman_during_transport;?>");
    $('.woman_transport_given_time').val("<?php echo $form['pregnant']->woman_transport_given_time;?>");

    /* INITIALIZE BABY VALUES */
    $('.baby_fname').val("<?php echo $form['baby']->baby_fname;?>");
    $('.baby_mname').val("<?php echo $form['baby']->baby_mname;?>");
    $('.baby_lname').val("<?php echo $form['baby']->baby_lname;?>");
    $('.baby_dob').val("<?php echo $form['baby']->baby_dob;?>");
    $('.baby_weight').val("<?php echo $form['baby']->weight;?>");
    $('.baby_gestational_age').val("<?php echo $form['baby']->gestational_age;?>");
    $('.baby_last_feed').val("<?php echo $form['baby']->baby_last_feed?>");
    $('.baby_before_treatment').val("<?php echo $form['baby']->baby_before_treatment;?>");
    $('.baby_before_given_time').val("<?php echo $form['baby']->baby_before_given_time;?>");
    $('.baby_during_transport').val("<?php echo $form['baby']->baby_during_transport;?>");
    $('.baby_transport_given_time').val("<?php echo $form['baby']->baby_transport_given_time?>");

    $('.baby_fname, .baby_mname, .baby_lname').on('change', function() {
        var fname = $('.baby_fname').val();
        var mname = $('.baby_mname').val();
        var lname = $('.baby_lname').val();
        if((fname != "") || (mname != "") || (lname != "")) {
            $('.baby_fname, .baby_lname').prop('required', true);
            $('.baby_dob, .baby_weight, .baby_gestational_age').prop('required', true);
        }
        else {
            $('.baby_fname, .baby_lname').prop('required', false);
            $('.baby_dob, .baby_weight, .baby_gestational_age').prop('required', false);
        }
    });

    $('.icd_selected, .notes_diag, .other_diag').hide();

    @if(isset($icd[0]))
    $('.icd_selected').show();
    @endif

    @if(isset($form['pregnant']->notes_diagnoses))
    $('.notes_diag').show();
    $('.add_notes_btn').hide();
    @endif

    @if(isset($form['pregnant']->other_diagnoses))
    $('.other_diag').show();
    @endif

    $('.reason_referral').val("<?php echo $reason->id;?>");
    @if(isset($form['pregnant']->other_reason_referral))
        var other_reason = $("#edit_referred_other_reason_pregnant").val();
        $('.reason_referral').val("-1");
        $('#other_reason_referral').html("<textarea class='form-control' id='other_reason' name='other_reason_referral' style='resize: none;width: 100%;' rows='3' required></textarea>");
        $('#other_reason').val(other_reason);
    @else
        $('#other_reason_referral').hide();
        $('#other_reason').val('');
    @endif

    @if(isset($file_path) && count($file_path) > 0)
    $('.with_file_attached').removeClass('hide');;
    @else
    $('.no_file_attached').removeClass('hide');
    @endif

    function clearFileUpload() {
        $('.with_file_attached').addClass('hide');
        $('.no_file_attached').removeClass('hide');
        $('#file_cleared').val("true");
    }

    function clearIcdNormal() {
        $("#icd_selected").html("");
        $(".icd_selected").hide();
        $('#icd_cleared').val("true");
        $('input[name="icd_ids[]"]').empty();
    }

    function clearOtherDiagnosisPregnant() {
        $(".other_diagnosis").val("");
        $(".other_diag").hide();
        $('.other_diag_cleared').val("true");
    }

    function clearNotesDiagnosisPregnant() {
        $(".notes_diagnosis").val("");
        $(".notes_diag").hide();
        $(".add_notes_btn").show();
        $('#notes_diag_cleared').val("true");
    }

    function clearOtherReasonReferral() {
        $('#other_reason').val("");
        $("#other_reason_referral").html("");
    }

    function addNotesDiagnosis() {
        $(".notes_diag").show();
        $(".notes_diagnosis").html(loading);
        $(".notes_diagnosis").html("");
    }

    function searchICD10() {
        $(".icd_body").html(loading);
        var url = "<?php echo asset('icd/search'); ?>";
        var json = {
            "_token" : "<?php echo csrf_token(); ?>",
            "icd_keyword" : $("#icd10_keyword").val()
        };
        $.post(url,json,function(result){
            setTimeout(function(){
                $(".icd_body").html(result);
            },500);
        });
    }

    function othersDiagnosis() {
        $('#icd-modal').modal('hide');
        $(".other_diag").show();
        $('#diag_prompt').hide();
    }

    $('.reason_referral').on('change', function() {
        var value = $(this).val();
        if(value == '-1') {
            $('#other_reason_referral').show();
            $('#other_reason_referral').html(loading);
            setTimeout(function(){
                $('#other_reason_referral').html("<textarea class='form-control' id='other_reason' name='other_reason_referral' style='resize: none;width: 100%;' rows='3' placeholder='Other reason for referral' required></textarea>");
            },500);
        }else{
            clearOtherReasonReferral();
        }
    });

    function getAllCheckBox() {
        $('#icd-modal').modal('toggle');
        $('.icd_selected').show();
        $('#diag_prompt').hide();
        var values = [];

        $('input[name="icd_checkbox[]"]:checked').each(function () {
            values[values.length] = (this.checked ? $(this).parent().parent().siblings("td").eq(1).text() : "");
            var icd_description = $(this).parent().parent().siblings("td").eq(1).text();
            var id = $(this).val();
            if(this.checked){
                console.log(icd_description);
                $("#icd_selected").append('=> '+icd_description+' '+'<br><input id="icd" type="hidden" name="icd_ids[]" value="'+id+'">');
            }
            clearOtherDiagnosisPregnant();
        });
    }

    var pregnant_pos = 2;
    var pregnant_count = 0 ;
    function readURLPregnant(input, pos) {
        var word = '{{ asset('resources/img/document_icon.png') }}';
        var pdf = '{{ asset('resources/img/pdf_icon.png') }}';
        var excel = '{{ asset('resources/img/sheet_icon.png') }}';
        if (input.files) {
            var tmp_pos = pos;
            for(var i = 0; i < input.files.length; i++) {
                var file = input.files[i];
                if(file && file !== null) {
                    var reader = new FileReader();
                    var type = file.type;
                    if(type === 'application/pdf') {
                        $('#pregnant_file-upload-image'+pos).attr('src',pdf);
                        pos+=1;
                    } else if(type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        $('#pregnant_file-upload-image'+pos).attr('src',word);
                        pos+=1;
                    } else if(type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        $('#pregnant_file-upload-image'+pos).attr('src',excel);
                        pos+=1;
                    } else {
                        reader.onloadend = function(e) {
                            $('#pregnant_file-upload-image'+pos).attr('src',e.target.result);
                            pos+=1;
                        };
                    }
                    $('#pregnant_image-upload-wrap'+tmp_pos).hide();
                    $('#pregnant_file-upload-content'+tmp_pos).show();
                    $('#pregnant_image-title'+tmp_pos++).html(file.name);
                    reader.readAsDataURL(file);
                    pregnant_count+=1;
                }
                addFilePregnant();
            }
        }
        $('#preg_remove_files').show();
    }
    function addFilePregnant() {
        var add_file_icon = '{{ asset('resources/img/add_file.png') }}';

        if((pregnant_count % 4) == 0) {
            $('.pregnant_file_attachment').append(
                '<div class="clearfix"></div>'
            );
        }
        $('.pregnant_file_attachment').append(
            '<div class="col-md-3" id="pregnant_upload'+pregnant_pos+'">\n' +
            '   <div class="file-upload">\n' +
            '       <div class="text-center image-upload-wrap" id="pregnant_image-upload-wrap'+pregnant_pos+'">\n' +
            '           <input class="file-upload-input" multiple type="file" name="file_upload[]" onchange="readURLPregnant(this, '+pregnant_pos+');" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>\n' +
            '           <img src="'+add_file_icon   +'" style="width: 50%; height: 50%;">\n' +
            '       </div>\n' +
            '       <div class="file-upload-content" id="pregnant_file-upload-content'+pregnant_pos+'">\n' +
            '           <img class="file-upload-image" id="pregnant_file-upload-image'+pregnant_pos+'"/>\n' +
            '           <div class="image-title-wrap">\n' +
            '               <b><small class="image-title" id="pregnant_image-title'+pregnant_pos+'" style="display:block; word-wrap: break-word;">Uploaded File</small></b>\n' +
            '               {{--<button type="button" id="pregnant_remove_upload'+pregnant_pos+'" onclick="removeUploadPregnant('+pregnant_pos+')" class="btn-sm remove-image">Remove</button>--}}\n' +
            '           </div>\n' +
            '       </div>\n' +
            '   </div>\n' +
            '</div>'
        );
        pregnant_pos+=1;
    }

    function removeFilePregnant() {
        $('.pregnant_file_attachment').html("");
        pregnant_count = 0;
        pregnant_pos = 1;
        $('#preg_remove_files').hide();
        addFilePregnant();
    }

    $(document).ready(function() {
        for (var i = 0; i < pregnant_count; i++) {
            $('#pregnant_image-upload-wrap' + i).bind('dragover', function () {
                $('#pregnant_image-upload-wrap' + i).addClass('image-dropping');
            });
            $('#pregnant_image-upload-wrap' + i).bind('dragleave', function () {
                $('#pregnant_image-upload-wrap' + i).removeClass('image-dropping');
            });
        }
        $('#preg_remove_files').hide();
    });

    $(".select2").select2({ width: '100%' });
</script>