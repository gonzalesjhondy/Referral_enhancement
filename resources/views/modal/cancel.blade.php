
<div class="modal fade" role="dialog" id="cancelModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4><i class="fa fa-user-times"></i> Cancel Referral </h4>
                <div id="seenBy_section">
                    <hr />
                    <form method="post" action="" id="cancelReferralForm">
                        {{ csrf_field() }}
                        <input type="hidden" name="admin" value="" id="cancelAdmin">
                        <div class="form-group">
                            <textarea required class="form-control" name="reason" style="resize: none;" rows="6" placeholder="Reason for Cancellation"></textarea>
                        </div>
                        <div class="pull-right">
                            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i> Close
                            </button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn-cancel-submit">
                                <i class="fa fa-check"></i> Submit
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal modal-danger fade" role="dialog" id="undoCancelModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h5><b>UNDO CANCEL</b></h5>
                <hr />
                <form action="{{ asset('doctor/referral/undo_cancel') }}" method="POST" id="undoCancelForm">
                    {{ csrf_field() }}
                    <div class="form-group" style="text-align: center">
                        <b>ARE YOU SURE YOU WANT TO UNDO CANCELLATION? </b>
                    </div>
                    <hr />
                    <div class="form-footer undo_cancel_body" style="text-align: center">
                        <input type="hidden" id="undo_cancel_id" name="undo_cancel_id" value="">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" class="btn btn-success btn-flat" id="btn-undocancel-submit"><i class="fa fa-check"></i> Yes</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->