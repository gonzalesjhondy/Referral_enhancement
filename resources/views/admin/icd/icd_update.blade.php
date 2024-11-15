<form method="POST" action="{{ asset('admin/icd/update') }}">
    {{ csrf_field() }}
    <fieldset>
        <legend><i class="fa fa-pencil"></i> Update ICD</legend>
    </fieldset>
    <div class="form-group">
        <input type="hidden" name="icd_id" id="id_update" value="{{ $data->id }}">
        <label>Code:</label>
        <input type="text" class="form-control" name="code" id="code_update" value="{{ $data->code }}" required>
        <span id="code_warning" style="color: red;"></span>
    </div>
    <div class="form-group">
        <label>Description:</label>
        <textarea rows="2" class="form-control" name="description" required>{{ $data->description }}</textarea>
    </div>
    <div class="form-group">
        <label>Group:</label>
        <input type="text" class="form-control" name="group" value="{{ $data->group }}">
    </div>
    <div class="form-group">
        <label>Case Rate:</label>
        <input type="text" class="form-control" name="case_rate" value="{{ $data->case_rate }}">
    </div>
    <div class="form-group">
        <label>Professional Fee:</label>
        <input type="text" class="form-control" name="professional_fee" value="{{ $data->professional_fee }}">
    </div>
    <div class="form-group">
        <label>Health Care Fee:</label>
        <input type="text" class="form-control" name="health_care_fee" value="{{ $data->health_care_fee }}">
    </div>
    <div class="form-group">
        <label>Source:</label>
        <input type="text" class="form-control" name="source" value="{{ $data->source }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="button" data-toggle="modal" data-target="#icd_delete" class="btn btn-danger btn-sm" onclick= "deleteICD({{ $data->id }})"><i class="fa fa-trash"></i> Delete</button>
        <button type="submit" value="true" id="icd_update_btn" name="icd_update_btn" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
    </div>
</form>

<script>
    $('#code_update').on('input', function( event ) {
        var code = $("#code_update").val();
        $('#code_update').val(code.toUpperCase());
        var url = "{{ url('admin/icd/checkIfExistICD') }}";
        var json = {
            "code" : code,
            "_token" : "<?php echo csrf_token(); ?>"
        };
        $.post(url,json, function(checkIfExist) {
            if(checkIfExist['id'] == $('#id_update').val() || checkIfExist['exist'] == 0 ) {
                $('#code_warning').html("");
                $('#icd_update_btn').prop('disabled', false);
            }else {
                event.preventDefault();
                $('#code_warning').html("Code already exists!");
                $('#code_update').focus();
                $('#icd_update_btn').prop('disabled', true);
            }
        });
    });
</script>
