<?php
$counter = 1;
?>

@extends('layouts.app')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="pull-right">
                <form action="{{ asset('admin/user_feedback') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group-lg" style="margin-bottom: 10px;">
                        <input type="text" class="form-control" name="keyword" value="{{ Session::get('user_feedback_keyword') }}" placeholder="Search...">
                        <button type="submit" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
                            <i class="fa fa-eye"></i> View All
                        </button>
                    </div>
                </form>
            </div>
            <h3>User Feedback <small>({{ $count }})</small></h3>
        </div>
        <div class="box-body">
            @if(count($data)>0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <tr class="bg-navy-active">
                            <th class="text-center"> Name / Facility Name</th>
                            <th class="text-center"> Contact </th>
                            <th class="text-center"> &emsp;Subject&emsp;</th>
                            <th class="text-center"> Message </th>
                            <th class="text-center"> Date Submitted </th>
                            <th class="text-center"> Status </th>
                            <th class="text-center" colspan="2"> Action </th>
                        </tr>
                        @foreach($data as $row)
                            <tr class="{{ $bg }}">
                                <td><b> {{ $row->name }} </b></td>
                                <td> {{ $row->contact }} <br> {{ $row->email }} </td>
                                <td class="text-center"> {{ $row->subject }} </td>
                                <td> {{ $row->message }} </td>
                                <td> {{ date_format($row->created_at, 'F d, Y, h:i a') }}</td>
                                <td class="text-center">
                                    <?php
                                        if($row->status == 'new')
                                            $budgie = "badge bg-yellow";
                                        else if($row->status == 'seen')
                                            $budgie = "badge bg-light-blue";
                                        else if($row->status == 'resolved')
                                            $budgie = "badge bg-green";
                                    ?>
                                    <span class="{{ $budgie }}" id="status{{ $row->id }}"> {{ strtoupper($row->status) }}</span>
                                </td>
                                @if($row->status != 'resolved')
                                    @if($row->status == 'new')
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning" title="Mark as Seen" id="seen_btn{{ $row->id }}" onclick="FeedbackSeen({{ $row->id }})"> <i class="fa fa-eye"></i> </button>
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td class="text-center">
                                        <a
                                                href="#feedback_modal"
                                                data-toggle="modal"
                                                onclick="FeedbackRemarks('<?php echo $row->id; ?>')"
                                        >
                                            <button class="btn btn-sm btn-success" title="Mark as Resolved"><i class="fa fa-check"></i></button>
                                        </a>
                                    </td>
                                @endif
                                @if($row->status == 'resolved')
                                    <td colspan="2" class="text-center">
                                        <a
                                                href="#feedback_modal"
                                                data-toggle="modal"
                                                onclick="FeedbackRemarks('<?php echo $row->id; ?>')"
                                        >
                                            <button class="btn btn-sm btn-primary" id="remarks_btn">View Remarks</button>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <span class="text-warning">
                        <i class="fa fa-warning"></i> No user feedback found!
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" role="dialog" id="feedback_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h5 class="modal-title"><b>RESOLVE FEEDBACK</b></h5>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ asset('user_feedback/resolve') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="feedback_id">
                        <div class="form-group mt-3">
                            <b>Remarks:</b><br>
                            <textarea class="form-control" name="remarks" rows="7" style="resize: none; background-color: white;" id="modal_remarks" required> </textarea>
                        </div>

                        <div class="form-group pull-right">
                            <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
                            <button type="submit" id="resolve_btn" class="btn btn-success btn-flat btn-submit"><i class="fa fa-check"></i> Resolve</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div><!-- /.modal-content -->
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('js')
    <script>
        @if(Session::get('user_feedback_notif'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("user_feedback_msg"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("user_feedback_notif",false);
        Session::put("user_feedback_msg",false)
        ?>
        @endif

        function FeedbackSeen(id) {
            var url = "{{ asset('user_feedback/seen') }}";
            var json = {
                "id" : id,
                "_token" : "<?php echo csrf_token()?>"
            };
            $.post(url,json,function(data){
                console.log(data);
                if(data.success) {
                    $('#status'+id).attr('class','badge bg-light-blue');
                    $('#status'+id).html('SEEN');
                    $('#seen_btn'+id).hide();
                }
            });
        }

        function FeedbackRemarks(id){
            $('.loading').show();
            $('#feedback_id').val(id);
            var url = "{{ asset('user_feedback/details') }}";
            var json = {
                "id" : id,
                "_token" : "<?php echo csrf_token()?>"
            };
            $.post(url,json,function(data){
                $('.loading').hide();
                console.log(data.remarks);
                if(data.status === 'resolved') {
                    $('#modal_remarks').val(data.remarks);
                    $('#modal_remarks').attr('readonly', true);
                    $('#resolve_btn').hide();
                } else {
                    $('#modal_remarks').val('');
                    $('#modal_remarks').attr('readonly', false);
                    $('#resolve_btn').show();
                }
            });
        }
    </script>
@endsection