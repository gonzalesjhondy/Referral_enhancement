<?php
$counter = 0;
$faci_count = 0;
?>

<fieldset>
    <div class="col-xs-9">
        <h4><i class="fa fa-user-md"></i> Update Facility Assignment</h4>
    </div>
    <div class="col-xs-3">
        <button type="button" class="close" style="float: right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</fieldset>
<div class="form-group">
    <label>First Name:</label>
    <input type="text" class="form-control fname" autofocus name="fname" readonly style="background-color: white" value="{{ $user->fname }}">
</div>
<div class="form-group bg-">
    <label>Middle Name:</label>
    <input type="text" class="form-control mname" name="mname" readonly style="background-color: white" value="{{ $user->mname }}">
</div>
<div class="form-group">
    <label>Last Name:</label>
    <input type="text" class="form-control lname" name="lname" readonly style="background-color: white" value="{{ $user->lname }}">
</div>
<hr />

<div class="form-group">
    <label>Affiliated Facilities: </label>
    <div class="table-responsive" style="overflow-x: auto">
        <table class="table table-bordered table-striped" id="faci_table">
            <thead>
            <tr style="font-size: 13px;">
                <th class="text-center" width="25%">Facility Name</th>
                <th class="text-center" width="20%">Department</th>
                <th class="text-center" width="15%">Contact Number</th>
                <th class="text-center" width="15%">Email Address</th>
                <th class="text-center" width="15%">Status</th>
                <th class="text-center" width="10%">Action</th>
            </tr>
            </thead>
            @if(count($user_faci) > 0)
                @foreach($user_faci as $f)
                    <?php $faci_count++; ?>
                    <tr style="font-size: 9pt;" class="faci_apil{{$counter}}">
                        <td>
                            <select class="form-control select2" name="faci[]" required>
                                <option value="">Select...</option>
                                @foreach($facilities as $facility)
                                    <option <?php if($facility->id == $f->faci_id) echo 'selected'?> value="{{ $facility->id }}">{{ $facility->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="select2" name="department[]" required>
                                <option value="">Select...</option>
                                @foreach($departments as $dep)
                                    <option <?php if($f->department_id == $dep->id) echo 'selected'?> value="{{ $dep->id }}">{{ $dep->description }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <textarea class="form-control" rows="2" required style="resize: none" name="contact[]" >{{ $f->contact }} </textarea>
                        </td>
                        <td>
                            <textarea class="form-control" rows="2" required style="resize: none;" name="email[]">{{ $f->email }}</textarea>
                        </td>
                        <td>
                            <select class="form-control" name="status[]" required>
                                <option value="">Select...</option>
                                <option value="Active" <?php if($f->status=='Active') echo "selected";?> >Active</option>
                                <option value="Inactive" <?php if($f->status=='Inactive') echo "selected";?> >Inactive</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-xs btn-danger text-center" id="btn_remove{{$counter}}" onclick="removeFacility({{$counter++}})"type="button" style="width: 100%">Remove</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div><br>
    <div class="text-center">
        <button class="btn-xs btn-warning text-center" id="add_row_btn" type="button">
            <i class="fa fa-plus"> Add Row</i>
        </button><br><br>
    </div>
</div>
<hr />
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Update</button>
</div>

<script>
    $('.select2').select2();

    /* ADD/REMOVE "REMOVE" BUTTON */
    var counter = {{ $counter }};
    var faci_count = {{ $faci_count }};
    disableRemoveBtn();
    function removeFacility(pos) {
        $('.faci_apil'+pos).prop('disabled', true).remove();
        faci_count -= 1;
        disableRemoveBtn();
    }

    function disableRemoveBtn() {
        console.log('counter: ' + counter);
        console.log('faci_count: ' + faci_count);
        for(var i = 0; i <= counter; i++) {
            if(faci_count > 1)
                $('#btn_remove'+i).show();
            else
                $('#btn_remove'+i).hide();
        }
    }

    $('#add_row_btn').on('click', function() {
        faci_count += 1;
        string =
            '<tr style="font-size: 10pt" class="faci_apil'+counter+'">\n' +
            '                    <td><small>\n' +
            '                        <select class="form-control select2" name="faci[]" required>\n' +
            '                            <option value="">Select...</option>\n';

        @foreach($facilities as $f)
            id = '{{ $f->id }}';
            name = '{{ $f->name }}';
            string += "<option value="+id+">"+name+"</option>";
        @endforeach

        string += '</select></small></td><td>' +
        '       <select class="select2" name="department[]" required>\n' +
        '           <option value="">Select...</option>';

        @foreach($departments as $dep)
            dept_id = '{{ $dep->id }}';
            dept_desc = '{{ $dep->description }}';
            string += "<option value="+dept_id+">"+dept_desc+"</option>"
        @endforeach

        string +=
            '       </select></small>\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <textarea class="form-control" rows="2" required style="resize: none" name="contact[]" ></textarea>\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <textarea class="form-control" rows="2" required style="resize: none;" name="email[]"></textarea>\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <select class="form-control" name="status[]" required>\n' +
            '           <option value="">Select...</option>\n' +
            '           <option value="Active">Active</option>\n' +
            '           <option value="Inactive">Inactive</option>\n' +
            '       </select>\n' +
            '   </td>\n' +
            '   <td>\n' +
            '       <button class="btn-xs btn-danger text-center" id="btn_remove'+counter+'" onclick="removeFacility('+counter+')"type="button" style="width: 100%">Remove</button>\n' +
            '   </td>\n' +
            '</tr>';

        $('#faci_table').append(string);
        $(".select2").select2({ width: '100%' });
        counter += 1;
        disableRemoveBtn();
    });


    /*-----------------------------*/
</script>