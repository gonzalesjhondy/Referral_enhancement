<?php
$counter = 1;
$morrow = new DateTime('tomorrow');
$morrow = $morrow->format('Y-m-d');
?>

@extends('layouts.app')

@section('content')
    <style>
        .bg_new {
            background-color: #ffcba4;
        }

        .bg_seen {
            background-color: #fbf7f3;
        }

        .bg_resolved {
            background-color: #ace1af;
        }
    </style>

    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="pull-right">
                <form action="{{ asset('admin/appointment') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 10px;">
                        <input type="text" class="form-control" name="appt_keyword" value="{{ $keyword }}" id="keyword" placeholder="Search...">
                        <button type="submit" class="btn btn-success btn-sm btn-flat">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-sm btn-flat">
                            <i class="fa fa-eye"></i> View All
                        </button>
                        <a href="{{ asset('admin/appointment/export') }}" class="btn btn-danger btn-sm btn-flat" target="_blank">
                            <i class="fa fa-file-excel-o"></i> Export
                        </a>
                        <br><br>
                        <select class="form-control select" id="status_filter" name="status_filter">
                            <option value="">Select status...</option>
                            <option value="new" @if($status == "new") selected @endif> New </option>
                            <option value="seen" @if($status == 'seen') selected @endif> Seen </option>
                            <option value="ongoing" @if($status == 'ongoing') selected @endif> Ongoing </option>
                            <option value="resolved" @if($status == 'resolved') selected @endif> Resolved </option>
                        </select>
                        <input type="date" name="date_filter" id="date_filter" class="form-control" value="{{ $date }}">
                        <button type="submit" class="btn btn-info btn-sm btn-flat">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
            <h3>APPOINTMENTS <small>({{ $count }})</small></h3>

        </div>
        <div class="box-body appointments">
            @if(count($data)>0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-fixed-header">
                        <tr class="bg-success bg-navy-active">
                            <th class="text-center">Facility Name</th>
                            <th class="text-center">Requester</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Contact</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Date Requested</th>
                            <th class="text-center">Status</th>
                        </tr>
                        @foreach($data as $row)
                            <tr style="font-size: 13px">
                                <td style="white-space: nowrap;">
                                    <b>
                                        <a
                                            href="#appt_modal"
                                            data-toggle="modal"
                                            onclick="ApptBody('<?php echo $row->id; ?>')"
                                        >
                                            {{ $row->name }}
                                        </a>
                                    </b>
                                </td>
                                <td> {{ $row->requester }}</td>
                                <td> {{ $row->email }} </td>
                                <td class="text-center"> {{ $row->contact }} </td>
                                <td class="text-center"> {{ $row->category}} </td>
                                <td class="text-center"> {{ date_format($row->created_at, 'F d, Y, h:i a') }} </td>
                                <td class="text-center">
                                    <?php
                                    if($row->status == 'new')
                                        $bg = 'badge bg-yellow';
                                    else if($row->status == 'seen')
                                        $bg = 'badge bg-light-blue';
                                    else if($row->status == 'ongoing')
                                        $bg = 'badge bg-red';
                                    else if($row->status == 'resolved')
                                        $bg = 'badge bg-green';
                                    ?>
                                    <span class="{{ $bg }}" id="status{{ $row->id }}"> {{ strtoupper($row->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="text-center">
                        {!! $data->links() !!}
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <span class="text-warning">
                        <i class="fa fa-warning"></i> No appointments found!
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" role="dialog" id="appt_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><b>APPOINTMENT REQUEST</b></h4>
                </div>
                <div class="modal-body appt_body">
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button class="btn btn-default btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
                </div>
            </div>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('js')
    <script>
        @if(Session::get('appt_notif'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("appt_msg"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("appt_notif",false);
        Session::put("appt_msg",false)
        ?>
        @endif

        function ApptBody(id){
            $('.appt_body').html(loading);
            var json = {
                "id" : id,
                "_token" : "<?php echo csrf_token()?>"
            };
            var url = "<?php echo asset('admin/appointment/details') ?>";
            $.post(url,json,function(response){
                $('.appt_body').html(response);
            });
        }
    </script>
@endsection
