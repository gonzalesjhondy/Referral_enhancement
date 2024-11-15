<?php
$count = 1;
?>

<input type="hidden" name="id" id="modal_id" value="{{ $data->id }}">
<div class="row">
    <div class="col-md-4 form-group">
        <b>Facility Name:</b><br>
        <input type="text" class="form-control" id="modal_faci_name" style="background-color: white" readonly value="{{ $data->name }}">
    </div>
    <div class="col-md-4 form-group">
        <b>Requester:</b><br>
        <input type="text" class="form-control" id="modal_requester" style="background-color: white" readonly value="{{ $data->requester }}">
    </div>
    <div class="col-md-4 form-group mt-3 mt-md-0">
        <b>Email:</b><br>
        <input type="text" class="form-control" id="modal_email" style="background-color: white" readonly value="{{ $data->email }}">
    </div>
</div>

<div class="row">
    <div class="col-md-4 form-group mt-3 mt-md-0">
        <b>Contact Number:</b><br>
        <input type="text" class="form-control" id="modal_contact" style="background-color: white" readonly value="{{ $data->contact }}">
    </div>
    <div class="col-md-4 form-group mt-3">
        <b>Preferred Date of Training:</b><br>
        <?php
            if($data->preferred_date != '0000-00-00')
                $pref_date = $data->preferred_date;
            else
                $pref_date = "";
        ?>
        <input type="date" style="background-color: white" name="date" id="modal_date" class="form-control" min="{{ $morrow }}" readonly value="{{ $pref_date }}">
    </div>
    <div class="col-md-4 form-group mt-3">
        <b>Category:</b><br>
        <input type="text" class="form-control" id="modal_category" style="background-color: white" readonly value="{{ $data->category }}">
    </div>
</div>

<div class="form-group mt-3">
    <b>Message:</b><br>
    <textarea class="form-control" rows="5  " style="resize: none; background-color: white;" id="modal_message" readonly>{{ $data->message }}</textarea>
</div>

<div class="form-group">
    <b>Remarks:</b><br><br>
    <div class="text-center">
        <div class="table-container">
            <div class="table-responsive" style="overflow-x: auto">
                <table class="table table-bordered table-striped table-hover table-fixed-header" id="remarks_table">
                    <thead class="header">
                    <tr class="bg-navy-active text-center">
                        <th></th>
                        <th class="text-center">Encoded By</th>
                        <th class="text-center" style="width:50%;">Remarks</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Date</th>
                    </tr>
                    </thead>
                    @if(count($remarks) > 0)
                        @foreach($remarks as $rem)
                            <?php
                            if($rem->status == 'ongoing')
                                $bg = 'badge bg-red';
                            else if($rem->status == 'resolved')
                                $bg = 'badge bg-green';
                            ?>
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $rem->fname }} {{ $rem->lname }}</td>
                                <td>{{ $rem->remarks }}</td>
                                <td class="{{ $bg }}">{{ ucfirst($rem->status) }}</td>
                                <?php
                                $date = $rem->created_at;
                                $date = $date->format('Y-m-d h:i:s');
                                ?>
                                <td>{{ $date }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td></td>
                            <td>{{ $data->remarks }}</td>
                            <td class="{{ $bg }}">{{ ucfirst($data->status) }}</td>
                            <td>{{ $data->updated_at }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <input type="button" class="btn-sm btn-info" onclick="addRemarks()" id="add_remarks" value="Add Remarks"><br><br>
        <small id="remarks_title" class="pull-left">ADD REMARKS:</small><br>
        <textarea class="form-control" name="remarks" rows="3" style="resize: none; background-color: white; border: solid black 1px" id="modal_remarks" placeholder="Remarks"></textarea>
        <small class="text-danger pull-left" id="warning"><b>* Enter remarks!</b></small><br>
        <input type="button" class="btn-sm btn-danger" onclick="addStatus('ongoing')" id="ongoing_btn" title="Mark as Ongoing" value="Ongoing">
        <input type="button" class="btn-sm btn-success" onclick="addStatus('resolve')" id="resolve_btn" title="Mark as Resolved" value="Resolve">
    </div>
</div>

<script>
    $('#warning, #remarks_title').hide();
    changeStatus('{{ $data->status }}');
    $('#modal_remarks').addClass('hidden');
    $('#ongoing_btn, #resolve_btn').hide();

    function changeStatus(status) {
        console.log(status);
        var id = $('#modal_id').val();
        if(status === 'resolved') {
            $('#add_remarks').hide();
            $('#status'+id).attr('class','badge bg-green').html('RESOLVED');
        } else if(status === 'seen') {
            var id = $('#modal_id').val();
            $('#status'+id).attr('class','badge bg-light-blue').html('SEEN');
        } else if(status === 'ongoing') {
            $('#status'+id).attr('class','badge bg-red').html('ONGOING');
        }
    }

    function addRemarks(){
        $('#modal_remarks').removeClass('hidden');
        $('#ongoing_btn, #resolve_btn, #remarks_title').show();
        $('#add_remarks').hide();
    }

    function addStatus(status){
        var remarks = $('#modal_remarks').val();
        var appt_id = $('#modal_id').val();
        if(remarks === "" || remarks === null) {
            $('#warning').show();
        } else {
            var json = {
                "remarks" : remarks,
                "appt_id" : appt_id,
                "_token" : "<?php echo csrf_token()?>"
            };

            var current_stat = "";
            if(status === 'ongoing') {
                var url = "<?php echo asset('admin/appointment/addOngoing') ?>";
                current_stat = 'ongoing';
            } else if (status === 'resolve') {
                var url = "<?php echo asset('admin/appointment/resolve') ?>";
                current_stat = 'resolved';
            }

            $.post(url,json,function(result){
                var data = result.data;
                var user = result.user;
                var status = data.status;
                if(status === 'ongoing') {
                    var bg = 'badge bg-red';
                } else if (status === 'resolved') {
                    var bg = 'badge bg-green';
                }
                status = status.replace(/^./, status[0].toUpperCase());
                var created_at = data.created_at;
                var date = created_at.toLocaleString();

                $('#remarks_table').append(
                    '<tr>\n' +
                    '   <td>' + {{ $count++ }} +'</td>\n' +
                    '   <td>' + user.fname + ' ' + user.lname + '</td>\n' +
                    '   <td>' + data.remarks + '</td>\n' +
                    '   <td class="' + bg + '">' + status + '</td>\n' +
                    '   <td>' + date + '</td>\n' +
                    '</tr>'
                );
                $('#modal_remarks').val('').addClass('hidden');
                $('#ongoing_btn, #resolve_btn').hide();
                changeStatus(current_stat);
            });
            if(status === 'ongoing') {
                $('#add_remarks').show();
            }
            $('#warning, #remarks_title').hide();
        }
    }
</script>