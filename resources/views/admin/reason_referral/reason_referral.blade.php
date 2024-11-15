@extends('layouts.app')

@section('content')
    <div class="row">
        <title>Reasons For Referral</title>
        <div class="box">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Reasons For Referral
                </h1>
                <ol class="breadcrumb form-inline my-2 my-lg-0">
                    <form action="{{ asset('admin/reason-referral/search') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="search" class="form-control" name="keyword" placeholder="Reason" style="width: 50%;">
                        <button type="submit" class="btn btn-success btn-sm btn-flat"><i class="fa fa-search"></i> Search</button>
                        <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#add_new">
                            Add New
                        </button>
                    </form>
                </ol><br>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <section class="col-lg-12">
                        <form action="{{ asset('admin/reason-referral/add') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal fade" id="add_new">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Add Reason</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <textarea class="form-control" cols="20" rows="3" name="reason" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </form>

                        <form action="{{ asset('admin/reason-referral/update') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal fade" id="reason_edit">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Update Reason for Referral</h4>
                                        </div>
                                        <div class="modal-body reason_edit_body">
                                            inside modal-body
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </form>

                        <form action="{{ asset('admin/reason-referral/delete') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal modal-danger sm fade" id="reason_delete">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <input type="hidden" value="" name="id_delete" class="reason_id_delete">
                                            <strong>Are you sure you want to delete?</strong>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-outline"><i class="fa fa-trash"></i> Yes</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </form>

                        <div class="box">
                            <!-- /.box-header -->
                            <div class="box-body no-padding table-responsive float-left">
                                <table class="table table-striped table-hover" data-pagination="true" >
                                    @foreach($reasons as $row)
                                        <tr>
                                            <td>{{ $row->reason }}</td>
                                            <td>
                                                <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#reason_edit" onclick="EditReason({{ $row->id }})">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#reason_delete" onclick="DeleteReason({{ $row->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div style="text-align: right;">
                                    {!! $reasons->links() !!}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('js')
    <script>
        @if(session()->has('notif'))
        Lobibox.notify('info',{
            msg:"<?php echo session()->get('notif'); ?>",
            size: 'mini',
            rounded: true
        });
        @endif

        function EditReason(id){
            var url = "<?php echo asset('admin/reason-referral/edit');?>";
            var json = {
                "reason_id" : id,
                "_token" : "<?php echo csrf_token(); ?>" 
            };

            $(".reason_edit_body").html("Please wait...");
            $.post(url, json, function(result){
                $(".reason_edit_body").html(result);
            });
        }

        function DeleteReason(id){
            $(".reason_id_delete").val(id);
        }
    </script>
@endsection