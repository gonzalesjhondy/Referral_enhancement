<input type="hidden" id="edit_referred_other_reason_normal" value="{{ $form->other_reason_referral }}">
<script>
    $('#diag_prompt').hide();

    $("#edit_save_btn").on('click',function(e){
        if(!($('input[name="icd_ids[]"]').val()) && !($("#other_diagnosis").val())){
            e.preventDefault();
            $('#diag_prompt').show();
            $('#diag_prompt').focus();
            return false;
        }
    });

    $('.edit_normal_form').on('submit', function(e) {
        $("#edit_save_btn").attr('disabled', true);
    });

    setDepartment();
    function setDepartment() {
        var id = $('.edit_facility_normal').val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.edit_fac_address_normal').html(data.address);

                $('.edit_department_normal').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.edit_department_normal').append($('<option>', {
                        value: val.id,
                        text : val.description
                    }));
                });
                $('.edit_department_normal').val("<?php echo $form->department_id;?>");
                setReferredMd();
            },
            error: function(){
                $('#serverModal').modal();
            }
        });

    }

    $('.edit_facility_normal').on('change',function(){
        var id = $(this).val();
        var url = "{{ url('location/facility/') }}";
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(data){
                console.log(data);
                $('.edit_fac_address_normal').html(data.address);

                $('.edit_department_normal').empty()
                    .append($('<option>', {
                        value: '',
                        text : 'Select Department...'
                    }));
                jQuery.each(data.departments, function(i,val){
                    $('.edit_department_normal').append($('<option>', {
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

    function setReferredMd() {
        var referred_facility = $('.edit_facility_normal').val();
        var id = $('.edit_department_normal').val();
        var list = "{{ url('list/doctor') }}";
        if(id){
            if(referred_facility==0){
                referred_facility = "{{ $user->facility_id }}";
            }
            $.ajax({
                url: list+'/'+referred_facility+'/'+id,
                type: 'GET',
                success: function(data){
                    $('.edit_action_md').empty()
                        .append($('<option>', {
                            value: '',
                            text : 'Any...'
                        }));
                    jQuery.each(data, function(i,val){
                        $('.edit_action_md').append($('<option>', {
                            value: val.id,
                            text: 'Dr. ' + val.fname + ' ' + val.mname + ' ' + val.lname + ' - ' + val.contact,
                        }));
                    });
                    $('.edit_action_md').val("<?php echo $form->md_referred_id;?>");
                    console.log("formd_referred_id:", <?php echo $form->md_referred_id; ?>);
                },
                error:function(){
                    $('#serverModal').modal();
                }
            });
        }
    }

    $('.edit_department_normal').on('change',function() {
        var referred_facility = $('.edit_facility_normal').val();
        var id = $(this).val();
        var list = "{{ url('list/doctor') }}";
        if(id){
            if(referred_facility==0){
                referred_facility = "{{ $user->facility_id }}";
            }
            $.ajax({
                url: list+'/'+referred_facility+'/'+id,
                type: 'GET',
                success: function(data){
                    $('.edit_action_md').empty()
                        .append($('<option>', {
                            value: '',
                            text : 'Any...'
                        }));
                    jQuery.each(data, function(i,val){
                        $('.edit_action_md').append($('<option>', {
                            value: val.id,
                            text : 'Dr. '+val.fname+' '+val.mname+' '+val.lname+' - '+val.contact
                        }));
                    });
                },
                error:function(){
                    $('#serverModal').modal();
                }
            });
        }
    });

    $('.icd_selected, .notes_diagnosis, .other_diag').hide();

    $('.patient_sex').html("<?php echo $form->patient_sex;?>");
    $('.civil_status').html("<?php echo $form->patient_status;?>");
    $('.phic_id').val("<?php echo $form->phic_id;?>");
    $('.phic_status').val("<?php echo $form->phic_status;?>");
    $('.covid_number').val("<?php echo $form->covid_number;?>");
    $('.clinical_status').val("<?php echo $form->refer_clinical_status;?>");
    $('.surve_category').val("<?php echo $form->refer_sur_category;?>");

    @if(isset($icd[0]))
        $('.icd_selected').show();
    @endif

    @if(isset($form->diagnosis))
    $('.notes_diagnosis').show();
    $('.add_notes_btn').hide();
    @endif

    @if(isset($form->other_diagnoses))
    $('.other_diag').show();
    @endif

    @if(isset($file_path) && count($file_path) > 0)
    $('.with_file_attached').removeClass('hide');
    @else
    $('.no_file_attached').removeClass('hide');
    @endif

    function clearFileUpload() {
        $('.with_file_attached').addClass('hide');
        $('.no_file_attached').removeClass('hide');
        $('#file_cleared').val("true");
    }

    $('.reason_referral').val("<?php echo $reason->id;?>");
    @if(isset($form->other_reason_referral))
        var other_reason = $("#edit_referred_other_reason_normal").val();
        $('.reason_referral').val("-1");
        $('#other_reason_referral').html("<textarea class='form-control' id='other_reason' name='other_reason_referral' style='resize: none;width: 100%;' rows='3' required></textarea>");
        $('#other_reason').val(`${other_reason}`);
    @else
        $('#other_reason_referral').hide();
        $('#other_reason').val('');
    @endif

    function clearIcdNormal() {
        $("#icd_selected").html("");
        $(".icd_selected").hide();
        $('#icd_cleared').val("true");
        $('input[name="icd_ids[]"]').empty();
    }

    function clearOtherDiagnosis(btn) {
        $("#other_diagnosis").val("");
        $(".other_diag").hide();
        if(btn) {
            $('.other_diag_cleared').val("true");
        }
    }

    function clearNotesDiagnosis() {
        $(".normal_notes_diagnosis").val("");
        $(".notes_diagnosis").hide();
        $(".add_notes_btn").show();
        $('#notes_diag_cleared').val("true");
    }

    function clearOtherReasonReferral() {
        $('#other_reason').val("");
        $("#other_reason_referral").html("");
    }

    function addNotesDiagnosis() {
        $(".notes_diagnosis").show();
        $(".normal_notes_diagnosis").html(loading);
        $(".normal_notes_diagnosis").html("");
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
        if(value === '-1') {
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
            clearOtherDiagnosis(false);
        });
    }

    var upload_pos = 2;
    var upload_count = 0;
    function readUrl(input, pos) {
        var word = '{{ asset('resources/img/document_icon.png') }}';
        var pdf = '{{ asset('resources/img/pdf_icon.png') }}';
        var excel = '{{ asset('resources/img/sheet_icon.png') }}';
        if (input.files && input.files[0]) {
            var tmp_pos = pos;
            var imgSize = {width: '150px', height: '120px'};
            for(var i = 0; i < input.files.length; i++) {
                var file = input.files[i];
                if(file && file !== null) {
                    var reader = new FileReader();
                    var type = file.type;
                    if(type === 'application/pdf') {
                        $('#file-upload-image'+pos).attr('src',pdf).css(imgSize);
                        pos+=1;
                    } else if(type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        $('#file-upload-image'+pos).attr('src',word).css(imgSize);
                        pos+=1;
                    } else if(type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        $('#file-upload-image'+pos).attr('src',excel).css(imgSize);
                        pos+=1;
                    } else {
                        reader.onloadend = function(e) {
                            $('#file-upload-image'+pos).attr('src', e.target.result).css(imgSize);
                            pos+=1;
                        };
                    }
                    $('#image-upload-wrap'+tmp_pos).hide();
                    $('#file-upload-content'+tmp_pos).show();
                    // $('#image-title' + tmp_pos++).html(file.name);
                    let filename = file.name;
                    
                    var maxLength = 12;
                    
                    var truncateName = filename.length > maxLength ? filename.substring(0, maxLength) + '...' : filename;
                    $('#image-title'  + tmp_pos++).html(truncateName).attr('title', filename);

                    reader.readAsDataURL(file);
                    upload_count+=1;

                    addFile();
                }
            }
        }
        $('#remove_files_btn').show();
    }

    function addFile() {
        var src = '{{ asset('resources/img/add_file.png') }}';
        if(upload_count % 4 == 0) {
            $('.attachment').append(
                '<div class="clearfix"></div>'
            );
        }
        $('.attachment').append(
            '<div class="col-md-3" id="upload'+upload_pos+'">\n' +
            '   <div class="file-upload">\n' +
            '       <div class="text-center image-upload-wrap" id="image-upload-wrap'+upload_pos+'">\n' +
            '           <input class="file-upload-input files" multiple id="file_upload_input'+upload_pos+'" type="file" name="file_upload[]" onchange="readUrl(this, '+upload_pos+');" accept="image/png, image/jpeg, image/jpg, image/gif, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"/>\n' +
            '           <img src="'+src+'" style="width: 50%; height: 50%;">\n' +
            '       </div>\n' +
            '       <div class="file-upload-content" id="file-upload-content'+upload_pos+'">\n' +
            '           <img class="file-upload-image" id="file-upload-image'+upload_pos+'" src="#"/>\n' +
            '           <div class="image-title-wrap">\n' +
            '               <b><small class="image-title" id="image-title'+upload_pos+'" style="display:block; word-wrap: break-word;"></small></b>\n' +
            /*'               <button type="button" onclick="removeFile('+upload_pos+')" class="remove-image"> Remove </button>\n' +*/
            '                   <button type="button" onclick="removeOneFile('+upload_pos+')" class="remove-icon-btn"> <i class="fa fa-trash"></i> </button>\n' +
            '           </div>\n' +
            '       </div>\n' +
            '   </div>\n' +
            '</div>'
        );
        upload_pos+=1;
    }

    function removeOneFile(uploadCount){
        $('#upload' + uploadCount).remove();

        upload_count -= 1;

        if(upload_pos > uploadCount){
            upload_pos -= 1;
        }
        if(uploadCount === 0){
            $('#remove_files_btn');
        }

       console.log("upload_pos:", upload_pos);

    }

    function removeFiles() {
        $('.attachment').html("");
        upload_count = 0;
        upload_pos = 1;
        $('#remove_files_btn').hide();
        addFile();
    }

    $(document).ready(function() {
        for (var i = 0; i < upload_count; i++) {
            $('#image-upload-wrap' + i).bind('dragover', function () {
                $('#image-upload-wrap' + i).addClass('image-dropping');
            });
            $('#image-upload-wrap' + i).bind('dragleave', function () {
                $('#image-upload-wrap' + i).removeClass('image-dropping');
            });
        }
        $('#remove_files_btn').hide();
    });

    $(".select2").select2({ width: '100%' });

</script>