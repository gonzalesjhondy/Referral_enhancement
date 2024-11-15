<style>
    @media only screen and (max-width: 720px) {
        #pregnant-content {
            width: 100%;
        }
    }
</style>

<div class="modal fade" role="dialog" id="pregnantModal" style="text-align: center">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="pregnant-content">
            <div class="modal-header">
                <i class="fa fa-user-secret"></i> SELECT OPTION
            </div>
            <div class="modal-body">
                <button  data-target="#normalFormModal" data-backdrop="static" data-toggle="modal" type="button" class="btn btn-warning col-sm-6" onclick="setClinicalFormTile('normal')">
                    <img src="{{ url('resources/img/female.png') }}" width="100" />
                    <br />
                    Non-Pregnant
                </button>
                <button data-target="#pregnantFormModal" data-backdrop="static" data-toggle="modal" type="button" class="btn btn-info col-sm-6" onclick="setClinicalFormTile('pregnant')">
                    <img src="{{ url('resources/img/pregnant.png') }}" width="100" />
                    <br />
                    Pregnant
                </button>
            </div>
            <div class="modal-footer"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="pregnantModalWalkIn" style="text-align: center">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="pregnant-content">
            <div class="modal-header">
                <i class="fa fa-user-secret"></i> SELECT OPTION
            </div>
            <div class="modal-body">
                <button  data-target="#normalFormModalWalkIn" data-backdrop="static" data-toggle="modal" type="button" class="btn btn-warning col-sm-6" onclick="setClinicalFormTile('normal')">
                    <img src="{{ url('resources/img/female.png') }}" width="100" />
                    <br />
                    Non-Pregnant
                </button>
                <button data-target="#pregnantFormModalWalkIn" data-backdrop="static" data-toggle="modal" type="button" class="btn btn-info col-sm-6" onclick="setClinicalFormTile('pregnant')">
                    <img src="{{ url('resources/img/pregnant.png') }}" width="100" />
                    <br />
                    Pregnant
                </button>
            </div>
            <div class="modal-footer"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
