<div class="modal fade" role="dialog" id="acceptFormModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>ACCEPT PATIENT</h4>
                <hr />
                <form method="post" id="acceptForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding:0px;">REMARKS:</label>
                        <textarea class="form-control accept_remarks" name="remarks" required rows="5" style="resize: none;"></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Accept</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="queueModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4><i class="fa fa-pencil"></i> UPDATE QUEUE NUMBER:</h4>
                <hr />
                <form method="post" id="updateQueue">
                    {{ csrf_field() }}
                    <input type="hidden" id="queue_id" name="tracking_id">
                    <div class="form-group">
                        <input type="text" class="form-control" name="queue_number" required>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Update</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="callConfirmationModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>CALL REQUEST</h4>
                <hr />
                <button type="button" class="btn btn-lg btn-block btn-success"><i class="fa fa-phone"></i> Called</button>
                <hr />

                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

