<div class="timeline-footer">
    <div class="form-inline">
        {{--@if( ($row->status == 'referred' || $row->status == 'seen' || $row->status == 'redirected' || $row->status == 'transferred') && $user->department_id == $row->department_id )--}}
        @if($row->status == 'referred' || $row->status == 'seen' || $row->status == 'redirected' || $row->status == 'transferred' || $row->status == 'followup')
            <div class="form-group">
                <a class="btn btn-warning btn-xs view_form" href="#referralForm"
                   data-toggle="modal"
                   data-code="{{ $row->code }}"
                   data-item="#item-{{ $row->id }}"
                   data-status="{{ $row->status }}"
                   data-referral_status="referred"
                   data-type="{{ $row->type }}"
                   data-id="{{ $row->id }}"
                   data-referred_from="{{ $row->referred_from }}"
                   data-patient_name="{{ $row->patient_name }}"
                   data-backdrop="static">
                    <i class="fa fa-folder"></i> View Form
                </a>
            </div>
        @endif
        @if($row->status == 'accepted' && $row->telemedicine)
            <?php $latestReferredActivity = \App\Activity::where('code',$row->code)->where('status','referred')->orderBy('id','desc')->first() ?>
            <button class="btn-xs  bg-success btn-flat" id="telemedicine" onclick="openTelemedicine({{ $row->id }}, '{{ $row->code }}', '{{ $row->type }}', {{ $row->action_md_id }}, {{ $latestReferredActivity->id }});"><i class="fa fa-camera"></i> Join</button>
        @endif
        @if($seen > 0)
            <div class="form-group">
                <a href="#seenModal" data-toggle="modal"
                   data-id="{{ $row->id }}"
                   class="btn btn-success btn-xs btn-seen"><i class="fa fa-user-md"></i> Seen
                    @if($seen>0)
                        <small class="badge bg-green-active" id="count_seen{{ $row->code }}">{{ $seen }}</small>
                    @endif
                </a>
            </div>
        @endif
        @if($caller_md > 0)
            <div class="form-group">
                <a href="#callerModal" data-toggle="modal"
                   data-id="{{ $row->id }}"
                   class="btn btn-primary btn-xs btn-caller"><i class="fa fa-phone"></i> Caller
                    @if($caller_md>0)
                        <small class="badge bg-blue-active">{{ $caller_md }}</small>
                    @endif
                </a>
            </div>
        @endif
        <button class="btn btn-xs btn-info btn-feedback" data-toggle="modal"
                data-target="#feedbackModal"
                data-code="{{ $row->code }}"
                onclick="viewReco($(this))"
        >
            <i class="fa fa-comments"></i>
            ReCo
            <span class="badge bg-blue" id="reco_count{{ $row->code }}">{{ $feedback }}</span>
        </button>
        <?php $doh_remarks = \App\Monitoring::where("code","=",$row->code)->count(); ?>
        @if($doh_remarks>0)
            <button class="btn btn-xs btn btn-doh" data-toggle="modal" style="background-color: #dd7556;color: white"
                    data-target="#feedbackDOH"
                    data-code="{{ $row->code }}">
                <i class="fa fa-phone-square"></i> 711 DOH CVCHD HealthLine
                <span class="badge bg-green">{{ $doh_remarks }}</span>
            </button>
        @endif
        <?php $issue_and_concern = \App\Issue::where("tracking_id","=",$row->id)->count(); ?>
        @if($issue_and_concern>0)
            <button class="btn btn-xs btn-danger btn-issue-incoming" data-toggle="modal"
                    data-target="#IssueAndConcern"
                    data-code="{{ $row->code }}"
                    data-referred_from="{{ $row->referred_from }}"
                    data-tracking_id="{{ $row->id }}">
                <i class="fa fa fa-exclamation-triangle"></i> Issue and Concern
                <span class="badge bg-red">{{ $issue_and_concern }}</span>
            </button>
        @endif
    </div>
</div>