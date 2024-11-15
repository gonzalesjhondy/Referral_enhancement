<?php

namespace App\Http\Controllers\Monitoring;

use App\Issue;
use App\Monitoring;
use App\OfflineFacilityRemark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Facility;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MonitoringCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function monitoring(Request $request){
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = date('Y-m-d',strtotime(Carbon::now()->subDays(3))).' 00:00:00';
            $date_end = date('Y-m-d').' 23:59:59';
        }

        $pending_activity = \DB::connection('mysql')->select("call monitoring('$date_start','$date_end')");

        return view('monitoring.monitoring',[
            "pending_activity" => $pending_activity,
            "date_start" => $date_start,
            "date_end" => $date_end
        ]);
    }

    public function bodyRemark(Request $request){
        return view('monitoring.monitoring_remark',[
            "activity_id" => $request->activity_id,
            "code" => $request->code,
            "remark_by" => $request->remark_by,
            "referring_facility" => $request->referring_facility,
            "referred_to" => $request->referred_to
        ]);
    }

    public function offlineRemarkBody(Request $request){
        return view('admin.report.offline_remark_body',[
            "facility_id" => $request->facility_id
        ]);
    }

    public function offlineRemarkAdd(Request $request){
        $facility_id = $request->facility_id;
        $remark_by = Session::get('auth')->id;
        $remarks = $request->remarks;
        $offline_facility_remarks = new OfflineFacilityRemark();
        $offline_facility_remarks->facility_id = $facility_id;
        $offline_facility_remarks->remark_by = $remark_by;
        $offline_facility_remarks->remarks = $remarks;
        $offline_facility_remarks->save();

        Session::put("add_offline_remark",true);
        return Redirect::back();
    }

    public function addRemark(Request $request){
        $monitoring_not_accepted = new Monitoring();
        $monitoring_not_accepted->code = $request->code;
        $monitoring_not_accepted->remark_by = Session::get('auth')->id;
        $monitoring_not_accepted->activity_id = $request->activity_id;
        $monitoring_not_accepted->referring_facility = $request->referring_facility;
        $monitoring_not_accepted->referred_to = $request->referred_to;
        $monitoring_not_accepted->remarks = $request->remarks;
        $monitoring_not_accepted->save();

        Session::put("add_remark",true);
        return Redirect::back();
    }

    public function feedbackDOH($code){
        $data = Monitoring::where("code","=",$code)->orderBy("id","asc")->get();;

        return view('doctor.feedback_monitoring',[
            'data' => $data
        ]);
    }

    public function getIssue(Request $request){
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
            $date_end = date('Y-m-d').' 23:59:59';
        }

        $issue = \DB::connection('mysql')->select("call issue('$date_start','$date_end')");
        return view('doctor.issue',[
            "issue" => $issue,
            "date_start" => $date_start,
            "date_end" => $date_end
        ]);
    }

    public function IssueAndConcern($tracking_id,$referred_from){
        $facility = Facility::find($referred_from);
        $data = Issue::where("tracking_id","=",$tracking_id)->orderBy("id","asc")->get();
        return view('issue.issue',[
            'data' => $data,
            'facility' => $facility
        ]);
    }

    public function issueSubmit(Request $request)
    {
        $issue = $request->get('issue');
        $tracking_id = $request->get('tracking_id');
        $data  = array(
            "tracking_id" => $tracking_id,
            "issue" => $issue,
            "status" => 'outgoing'
        );
        Issue::create($data);

        $facility = Facility::find(Session::get("auth")->facility_id);
        return view("issue.issue_append",[
            "facility_name" => $facility->name,
            "facility_picture" => $facility->picture,
            "tracking_id" => $tracking_id,
            "issue" => $issue
        ]);
    }

}
