<div class="modal fade" role="dialog" id="arriveModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>PATIENT ARRIVED</h4>
                <hr />
                <form method="post" id="arriveForm">
                    {{ csrf_field() }}
                    <div class="form-group-lg">
                        <div class="text-center text-bold text-success">
                            <small class="text-muted">Date/Time Arrived:</small><br />
                            {{ date('M d, Y h:i A') }}
                        </div>
                    </div>
                    <hr />
                    <div class="form-group-lg">
                        <label style="padding: 0px;">Remarks: </label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none" required></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" id="arrived_button"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="archiveModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>PATIENT DIDN'T ARRIVED</h4>
                <hr />
                <form method="post" id="archiveForm">
                    {{ csrf_field() }}
                    <div class="form-group-lg">
                        <label style="padding: 0px;">Remarks: </label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none"></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" id="notarrived_button"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="admitModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>ADMIT PATIENT</h4>
                <hr />
                <form method="post" id="admitForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding: 0px">Select Date/Time:</label>
                        <br />
                        <input type="text" value="{{ date('Y-m-d H:i') }}" class="form-control form_datetime" name="date_time" placeholder="Date/Time Admitted" />
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" id="admitted_button" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="dischargeModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>DISCHARGE PATIENT</h4>
                <hr />
                <form method="post" id="dischargeForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding: 0px">Select Date/Time:</label>
                        <br />
                        <input type="text" value="{{ date('Y-m-d H:i') }}" class="form-control form_datetime" name="date_time" placeholder="Date/Time Admitted" />
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label style="padding: 0px">ICD10</label>--}}
                        {{--<br />--}}
                        {{--<a data-toggle="modal"--}}
                           {{--data-target="#icd-modal-discharge"--}}
                           {{--type="button"--}}
                           {{--class="btn btn-sm btn-success"--}}
                           {{--onclick="searchICD10()">--}}
                            {{--<i class="fa fa-medkit"></i>  Add ICD-10--}}
                        {{--</a>--}}
                        {{--<button type="button" id="clear_icd" class="btn btn-sm btn-danger" onclick="clearICD()"> Clear ICD-10</button>--}}
                        {{--<div><span class="text-green" id="icd_selected"></span></div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label style="padding: 0px">Clinical Status</label>
                        <br />
                        <select name="clinical_status" class="form-control" >
                            <option value="">Select option</option>
                            <option value="asymptomatic">Asymptomatic for at least 3 days</option>
                            <option value="recovered">Recovered</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Surveillance Category</label>
                        <br />
                        <select name="sur_category" class="form-control" >
                            <option value="">Select option</option>
                            <option value="contact_pum">Contact (PUM)</option>
                            <option value="suspect">Suspect</option>
                            <option value="probable">Probable</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Enter Remarks:</label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none" required></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat" id="discharged_button"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--<div class="modal fade" id="icd-modal-discharge">
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
                <button type="button" class="btn btn-success" onclick="getAllCheckBox()"><i class="fa fa-save"></i> Save selected check</button>
            </div>
        </div>
    </div>
</div>--}}


