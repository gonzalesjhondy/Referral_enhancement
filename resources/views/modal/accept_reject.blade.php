<?php
    $user = Session::get('auth');
    $myfacility = \App\Facility::find($user->facility_id);
    $department = \App\Http\Controllers\LocationCtrl::facilityAddress($myfacility->id);
    $facility_address = $department['address'];
?>
<style>
    #normalFormModal span {
        color: #e08e0b;
    }

    #pregnantFormModal span {
        color: #1e8a2a;
    }
</style>

<div class="modal fade" role="dialog" id="referralForm">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="jim-content referral_body">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="editReferralForm" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close exit_edit_btn" data-dismiss="modal">&times;</button>
            </div>
            <div class="edit_referral_body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="icd-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" style="font-size: 17pt;">Search ICD-10 by keyword</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-lg">
                    <input type="text" id="icd10_keyword" class="form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat" onclick="searchICD10()">Find</button>
                    </span>
                </div><br>
                <div class="icd_body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="othersDiagnosis()"> Other Diagnosis</button>
                <button type="button" class="btn btn-success" onclick="getAllCheckBox()"><i class="fa fa-save"></i> Save selected check</button>
            </div>
        </div>
    </div>
</div>

