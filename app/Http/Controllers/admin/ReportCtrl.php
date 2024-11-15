<?php

namespace App\Http\Controllers\admin;

use App\Activity;
use App\Department;
use App\Facility;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ParamCtrl;
use App\Icd;
use App\Icd10;
use App\Login;
use App\PatientForm;
use App\Patients;
use App\PregnantForm;
use App\Profile;
use App\Province;
use App\Seen;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Tags\See;
use Illuminate\Support\Facades\Log;

class ReportCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function online()
    {
        $date = Session::get('dateReportOnline');
        if(!$date){
            $date = date('Y-m-d');
        }

        $start = Carbon::parse($date)->startOfDay();
        $end = Carbon::parse($date)->endOfDay();

        $data = Login::select(
                    'login.*',
                        'users.*',
                        'login.status as login_status'
                )
                ->join('users','users.id','=','login.userId')
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->where('users.level','!=','admin')
                ->where('users.username','!=','rtayong_doctor')
                ->orderBy('users.facility_id','asc') //TODO: possible changes for multiple facility log-in
                ->orderBy('login.id','desc')
                ->orderBy('users.lname','asc')
                ->paginate(20);

        return view('admin.online',[
            'title' => 'Online Users',
            'data' => $data
        ]);
    }

    public function filterOnline(Request $req)
    {
        Session::put('dateReportOnline',$req->date);
        return self::online();
    }

    public function filterOnline1(Request $req)
    {
        Session::put('dateReportOnline',$req->date);
        return self::online1();
    }

    public function referral()
    {
        $start = Session::get('startDateReportReferral');
        $end = Session::get('endDateReportReferral');
        if(!$start)
            $start = date('Y-m-d');
        if(!$end)
            $end = date('Y-m-d');

        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();

        $data = Tracking::whereBetween('updated_at',[$start,$end])
            ->orderBy('updated_at','desc')
            ->paginate(20);
        return view('admin.referral',[
            'title' => 'Referral Status',
            'data' => $data
        ]);
    }

    public function filterReferral(Request $req)
    {
        $range = explode('-',str_replace(' ', '', $req->date));
        $tmp1 = explode('/',$range[0]);
        $tmp2 = explode('/',$range[1]);

        $start = $tmp1[2].'-'.$tmp1[0].'-'.$tmp1[1];
        $end = $tmp2[2].'-'.$tmp2[0].'-'.$tmp2[1];

        Session::put('startDateReportReferral',$start);
        Session::put('endDateReportReferral',$end);
        return self::referral();
    }

    public function graph(){
        return view('admin.report.graph');
    }

    public function bar_chart(){
        return view('admin.report.bar_chart');
    }

    public function createDateRangeArray($strDateFrom,$strDateTo)
    {
        $aryRange = [];

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        $iDateFrom -= 86400;
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }

        return $aryRange;
    }

    public function formatTheTAT($mins) {
        $hours = floor($mins /60);
        $mins  = $mins %60;

        if((int)$hours > 24){
            $days = floor($hours /24);
            $hours = $hours %24;
        }
        if(isset($days))
            $days .= $days > 1 ? " Days " : " Day ";

        if($hours > 0)
            $hours .= $hours > 1 ? " Hours " : " Hour ";
        else
            $hours = "";

        $mins .= $mins > 1 ? " Minutes " : " Minute ";

        return $days.$hours.$mins;
    }

    public function getMinutes($date_start,$date_end) {
        $to_time = strtotime($date_start);
        $from_time = strtotime($date_end);
        return round(abs($to_time - $from_time) / 60,2);
    }

    public function turnAroundTimeIncoming(Request $request) { //tat
        $user = Session::get('auth');
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0]));
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1]));
        } else {
            $date_start = date('Y-m-d',strtotime(Carbon::now()->subDays(15)));
            $date_end = date('Y-m-d');
        }

        $iDateFrom = mktime(1, 0, 0, substr($date_start, 5, 2), substr($date_start, 8, 2), substr($date_start, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($date_end, 5, 2), substr($date_end, 8, 2), substr($date_end, 0, 4));

        $iDateFrom -= 86400;
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            $per_day = date("Y-m-d",$iDateFrom);

            $referred = Activity::
                        select("activity.code","activity.created_at")
                            ->where("activity.referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
            if($request->facility_from) {
                $referred = $referred->where("activity.referred_from",$request->facility_from);
            }
            if($request->department_to) {
                $referred = $referred->where("activity.department_id",$request->department_to);
            }
            $referred = $referred->whereBetween("activity.created_at",[$per_day." 00:00:00",$per_day." 23:59:59"])
                ->where('activity.status','referred')
                ->get();

            $redirected = Activity::
            select("activity.code","activity.created_at")
                ->where("activity.referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
            if($request->facility_from) {
                $redirected = $redirected->where("activity.referred_from",$request->facility_from);
            }
            if($request->department_to) {
                $redirected = $redirected->where("activity.department_id",$request->department_to);
            }
            $redirected = $redirected
                ->whereBetween("activity.created_at",[$per_day." 00:00:00",$per_day." 23:59:59"])
                ->where('activity.status','redirected')
                ->get();

            $transferred = Activity::
            select("activity.code","activity.created_at")
            ->where("activity.referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
            if($request->facility_from) {
                $transferred = $transferred->where("activity.referred_from",$request->facility_from);
            }
            if($request->department_to) {
                $transferred = $transferred->where("activity.department_id",$request->department_to);
            }
            $transferred = $transferred->whereBetween("activity.created_at",[$per_day." 00:00:00",$per_day." 23:59:59"])
            ->where('activity.status','transferred')
            ->get();

            foreach($referred as $refer) {
                $refer_to_seen = Seen::where("code",$refer->code)
                    ->where("created_at",">=",$refer->created_at)
                    ->where("facility_id",$request->facility_to ? $request->facility_to : $user->facility_id)
                    ->first();

                if($refer_to_seen) {
                    $refer_seen_holder[] = $this->getMinutes($refer->created_at,$refer_to_seen->created_at); //refer to seen
                    $refer_seen_overall[] = $this->getMinutes($refer->created_at,$refer_to_seen->created_at); //refer to seen
                    $refer_seen_details[] = [
                        "code" => $refer_to_seen->code,
                        "minutes" => $this->getMinutes($refer->created_at,$refer_to_seen->created_at),
                        "date_referred" => $refer->created_at,
                        "date_seened" => $refer_to_seen->created_at,
                        "date_referred_format" => date("M d, Y h:i A",strtotime($refer->created_at)),
                        "date_seened_format" => date("M d, Y h:i A",strtotime($refer_to_seen->created_at))
                    ];

                    $seen_to_accept = Activity::where("code",$refer_to_seen->code)
                        ->where("created_at",">=",$refer_to_seen->created_at)
                        ->where("referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
                    if($request->facility_from) {
                        $seen_to_accept = $seen_to_accept->where("activity.referred_from",$request->facility_from);
                    }
                    if($request->department_to) {
                        $seen_to_accept = $seen_to_accept->where("activity.department_id",$request->department_to);
                    }
                    $seen_to_accept = $seen_to_accept->where("status","accepted")
                        ->first();

                    if($seen_to_accept) {
                        $seen_accept_holder[] = $this->getMinutes($refer_to_seen->created_at,$seen_to_accept->created_at); // seen to accept

                        $accept_to_arrive = Activity::where("code",$seen_to_accept->code)
                            ->where("created_at",">=",$seen_to_accept->created_at)
                            ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                            ->where("status","arrived")
                            ->first();

                        if($accept_to_arrive) {
                            $accept_arrive_holder[] = $this->getMinutes($seen_to_accept->created_at,$accept_to_arrive->created_at); // accept to arrive

                            $arrive_to_admit = Activity::where("code",$accept_to_arrive->code)
                                ->where("created_at",">=",$accept_to_arrive->created_at)
                                ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                                ->where("status","admitted")
                                ->first();

                            if($arrive_to_admit) {
                                $arrive_admit_holder[] = $this->getMinutes($accept_to_arrive->created_at,$arrive_to_admit->created_at); // arrive to admit

                                $admit_to_discharge = Activity::where("code",$arrive_to_admit->code)
                                    ->where("created_at",">=",$arrive_to_admit->created_at)
                                    ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge)
                                    $admit_discharge_holder[] = $this->getMinutes($arrive_to_admit->created_at,$admit_to_discharge->created_at); // admit to discharge
                            }
                            else {
                                $admit_to_discharge = Activity::where("code",$accept_to_arrive->code)
                                    ->where("created_at",">=",$accept_to_arrive->created_at)
                                    ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge) {
                                    $admit_discharge_holder[] = $this->getMinutes($accept_to_arrive->created_at,$admit_to_discharge->created_at); // admit to discharge
                                }
                            }
                        }
                    }

                    $seen_to_reject = Activity::
                        select("act.created_at")
                        ->from("activity as act")
                        ->where("act.code",$refer_to_seen->code)
                        ->where("act.created_at",">=",$refer_to_seen->created_at)
                        ->where("act.referred_to", $request->facility_to ? $request->facility_to : $user->facility_id);
                    if($request->facility_from) {
                        $seen_to_reject = $seen_to_reject->where("act.referred_from",$request->facility_from);
                    }
                    if($request->department_to) {
                        $seen_to_reject = $seen_to_reject->join("users as user","user.id","=","act.action_md")->where("user.department_id",$request->department_to);
                    }
                    $seen_to_reject = $seen_to_reject->where("act.status","rejected")
                        ->orderBy("act.created_at","asc")
                        ->first();

                    if($seen_to_reject) {
                        $seen_reject_holder[] = $this->getMinutes($refer_to_seen->created_at,$seen_to_reject->created_at); // seen to rejected
                    }
                }

                $refer_to_accept = Activity::where("code",$refer->code)
                    ->where("created_at",">=",$refer->created_at)
                    ->where("referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
                if($request->facility_from) {
                    $refer_to_accept = $refer_to_accept->where("referred_from",$request->facility_from);
                }
                if($request->department_to) {
                    $refer_to_accept = $refer_to_accept->where("department_id",$request->department_to);
                }
                $refer_to_accept = $refer_to_accept->where("status","accepted")
                    ->first();

                if($refer_to_accept) {
                    $refer_accept_holder[] = $this->getMinutes($refer->created_at,$refer_to_accept->created_at);
                    ////
                    $refer_accept_details[] = [
                        "code" => $refer_to_accept->code,
                        "minutes" => $this->getMinutes($refer->created_at,$refer_to_accept->created_at),
                        "date_referred" => $refer->created_at,
                        "date_accepted" => $refer_to_accept->created_at,
                        "date_referred_format" => date("M d, Y h:i A",strtotime($refer->created_at)),
                        "date_accepted_format" => date("M d, Y h:i A",strtotime($refer_to_accept->created_at)),
                        "status" => "referred"
                    ];
                }
            }

            foreach($redirected as $redirect) {
                $redirect_to_seen = Seen::where("code",$redirect->code)
                    ->where("created_at",">=",$redirect->created_at)
                    ->where("facility_id",$request->facility_to ? $request->facility_to : $user->facility_id)
                    ->first();

                if($redirect_to_seen) {
                    $redirect_seen_holder[] = $this->getMinutes($redirect->created_at,$redirect_to_seen->created_at); //redirect to seen

                    $seen_to_accept_redirect = Activity::where("code",$redirect_to_seen->code)
                        ->where("created_at",">=",$redirect_to_seen->created_at)
                        ->where("referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
                    if($request->facility_from) {
                        $seen_to_accept_redirect = $seen_to_accept_redirect->where("referred_from",$request->facility_from);
                    }
                    if($request->department_to) {
                        $seen_to_accept_redirect = $seen_to_accept_redirect->where("department_id",$request->department_to);
                    }
                    $seen_to_accept_redirect = $seen_to_accept_redirect->where("status","accepted")
                        ->first();

                    if($seen_to_accept_redirect) {
                        $seen_accept_holder_redirect[] = $this->getMinutes($redirect_to_seen->created_at,$seen_to_accept_redirect->created_at); // seen to accept

                        $accept_to_arrive_redirect = Activity::where("code",$seen_to_accept_redirect->code)
                            ->where("created_at",">=",$seen_to_accept_redirect->created_at)
                            ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                            ->where("status","arrived")
                            ->first();
                        if($accept_to_arrive_redirect) {
                            $accept_arrive_holder_redirect[] = $this->getMinutes($seen_to_accept_redirect->created_at,$accept_to_arrive_redirect->created_at); // accept to arrive

                            $arrive_to_admit_redirect = Activity::where("code",$accept_to_arrive_redirect->code)
                                ->where("created_at",">=",$accept_to_arrive_redirect->created_at)
                                ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                                ->where("status","admitted")
                                ->first();

                            if($arrive_to_admit_redirect) {
                                $arrive_admit_holder_redirect[] = $this->getMinutes($accept_to_arrive_redirect->created_at,$arrive_to_admit_redirect->created_at); // arrive to admit

                                $admit_to_discharge_redirect = Activity::where("code",$arrive_to_admit_redirect->code)
                                    ->where("created_at",">=",$arrive_to_admit_redirect->created_at)
                                    ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge_redirect)
                                    $admit_discharge_holder_redirect[] = $this->getMinutes($arrive_to_admit_redirect->created_at,$admit_to_discharge_redirect->created_at); // admit to discharge
                            }
                            else {
                                $admit_to_discharge_redirect = Activity::where("code",$accept_to_arrive_redirect->code)
                                    ->where("created_at",">=",$accept_to_arrive_redirect->created_at)
                                    ->where("referred_from",$request->facility_to ? $request->facility_to : $user->facility_id)
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge_redirect) {
                                    $admit_discharge_holder_redirect[] = $this->getMinutes($accept_to_arrive_redirect->created_at,$admit_to_discharge_redirect->created_at); // admit to discharge
                                }
                            }
                        }
                    }

                    $seen_to_reject_redirect = Activity::where("code",$redirect_to_seen->code)
                        ->where("created_at",">=",$redirect_to_seen->created_at)
                        ->where("referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
                    if($request->facility_from) {
                        $seen_to_reject_redirect = $seen_to_reject_redirect->where("referred_from",$request->facility_from);
                    }
                    if($request->department_to) {
                        $seen_to_reject_redirect = $seen_to_reject_redirect->where("department_id",$request->department_to);
                    }
                    $seen_to_reject_redirect = $seen_to_reject_redirect->where("status","rejected")
                        ->first();
                    if($seen_to_reject_redirect) {
                        $seen_reject_holder_redirect[] = $this->getMinutes($redirect_to_seen->created_at,$seen_to_reject_redirect->created_at); // seen to rejected
                    }
                }


                $redirect_to_accept = Activity::where("code",$redirect->code)
                    ->where("created_at",">=",$redirect->created_at)
                    ->where("referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
                if($request->facility_from) {
                    $redirect_to_accept = $redirect_to_accept->where("referred_from",$request->facility_from);
                }
                if($request->department_to) {
                    $redirect_to_accept = $redirect_to_accept->where("department_id",$request->department_to);
                }
                $redirect_to_accept = $redirect_to_accept->where("status","accepted")
                    ->first();

                if($redirect_to_accept) {
                    $redirect_accept_holder[] = $this->getMinutes($redirect->created_at,$redirect_to_accept->created_at); //redirect to accept
                    ////
                    $redirect_accept_details[] = [
                        "code" => $redirect_to_accept->code,
                        "minutes" => $this->getMinutes($redirect->created_at,$redirect_to_accept->created_at),
                        "date_redirected" => $redirect->created_at,
                        "date_accepted" => $redirect_to_accept->created_at,
                        "date_redirected_format" => date("M d, Y h:i A",strtotime($redirect->created_at)),
                        "date_accepted_format" => date("M d, Y h:i A",strtotime($redirect_to_accept->created_at)),
                        "status" => "redirected"
                    ];
                }
            }

            foreach($transferred as $transfer) {
                $transfer_to_accept = Activity::where("code",$transfer->code)
                    ->where("created_at",">=",$transfer->created_at)
                    ->where("referred_to",$request->facility_to ? $request->facility_to : $user->facility_id);
                if($request->facility_from) {
                    $transfer_to_accept = $transfer_to_accept->where("referred_from",$request->facility_from);
                }
                if($request->department_to) {
                    $transfer_to_accept = $transfer_to_accept->where("department_id",$request->department_to);
                }
                $transfer_to_accept = $transfer_to_accept->where("status","accepted")
                    ->first();

                if($transfer_to_accept) {
                    $transfer_accept_holder[] = $this->getMinutes($transfer->created_at,$transfer_to_accept->created_at); // transfer to accept
                }
            }

            $c = array_column($refer_accept_details,'minutes'); // which column needed to be sorted
            array_multisort($c,SORT_DESC,$refer_accept_details); // sorts the array $refer_accept_details with respective of aray $c

            $d = array_column($redirect_accept_details,'minutes'); // which column needed to be sorted
            array_multisort($d,SORT_DESC,$redirect_accept_details); // sorts the array $redirect_accept_details with respective of aray $c

            $data[] = [
                "date" => date("M d",strtotime($per_day)),
                "referred" => count($referred),
                "redirected" => count($redirected),
                "transferred" => count($transferred),
                //"refer_to_seen" => round(collect($refer_seen_holder)->avg(),2),
                "refer_to_accept_details" => $refer_accept_details,
                "refer_to_accept" => round(collect($refer_accept_holder)->avg(),2),
                "redirect_to_accept_details" => $redirect_accept_details,
                "redirect_to_accept" => round(collect($redirect_accept_holder)->avg(),2),
                "transfer_to_accept" => round(collect($transfer_accept_holder)->avg(),2)
            ];
            $refer_seen_holder = [];
            $refer_accept_details = [];
            $redirect_accept_details = [];
            $refer_accept_holder = [];
            $redirect_accept_holder = [];
            $transfer_accept_holder = [];
        }

        $b = array_column($refer_seen_details,'minutes'); // which column needed to be sorted
        array_multisort($b,SORT_DESC,$refer_seen_details); // sorts the array $refer_seen_details with respective of aray $b

        return view('admin.report.tat_incoming',[
            "data_points" => $data,
            "user" => $user,

            "refer_to_seen_details" => $refer_seen_details,
            "refer_to_seen" => $this->formatTheTAT(round(collect($refer_seen_overall)->avg(),2)),
            "seen_to_accept" => $this->formatTheTAT(round(collect($seen_accept_holder)->avg(),2)),
            "seen_to_reject" => $this->formatTheTAT(round(collect($seen_reject_holder)->avg(),2)),
            "accept_to_arrive" => $this->formatTheTAT(round(collect($accept_arrive_holder)->avg(),2)),
            "arrive_to_admit" => $this->formatTheTAT(round(collect($arrive_admit_holder)->avg(),2)),
            "admit_to_discharge" => $this->formatTheTAT(round(collect($admit_discharge_holder)->avg(),2)),


            "redirect_to_seen" => $this->formatTheTAT(round(collect($redirect_seen_holder)->avg(),2)),
            "seen_to_accept_redirect" => $this->formatTheTAT(round(collect($seen_accept_holder_redirect)->avg(),2)),
            "seen_to_reject_redirect" => $this->formatTheTAT(round(collect($seen_reject_holder_redirect)->avg(),2)),
            "accept_to_arrive_redirect" => $this->formatTheTAT(round(collect($accept_arrive_holder_redirect)->avg(),2)),
            "arrive_to_admit_redirect" => $this->formatTheTAT(round(collect($arrive_admit_holder_redirect)->avg(),2)),
            "admit_to_discharge_redirect" => $this->formatTheTAT(round(collect($admit_discharge_holder_redirect)->avg(),2)),

            "date_start" => $date_start,
            "date_end" => $date_end,
            "province_select_from" => $request->province_from,
            "province_select_to" => $request->province_to,
            "facility_select_from" => $request->facility_from,
            "facility_select_to" => $request->facility_to,
            "facility_name_from" => Facility::find($request->facility_from)->name,
            "facility_name_to" => Facility::find($request->facility_to)->name,
            "department_select_to" => $request->department_to,
            "department_name_to" => Department::find($request->department_to)->description
        ]);
    }

    public function turnAroundTimeOutgoing(Request $request) { //tat
        $user = Session::get('auth');
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0]));
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1]));
        } else {
            $date_start = date('Y-m-d',strtotime(Carbon::now()->subDays(15)));
            $date_end = date('Y-m-d');
        }

        $iDateFrom = mktime(1, 0, 0, substr($date_start, 5, 2), substr($date_start, 8, 2), substr($date_start, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($date_end, 5, 2), substr($date_end, 8, 2), substr($date_end, 0, 4));

        $iDateFrom -= 86400;
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            $per_day = date("Y-m-d",$iDateFrom);

            $referred = Activity::
            select("activity.code","activity.created_at","activity.referred_to")
                ->where("activity.referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
            if($request->facility_to) {
                $referred = $referred->where("activity.referred_to",$request->facility_to);
            }
            $referred = $referred->whereBetween("activity.created_at",[$per_day." 00:00:00",$per_day." 23:59:59"])
                ->where('activity.status','referred')
                ->get();

            $redirected = Activity::
            select("activity.code","activity.created_at","activity.referred_to")
                ->where("activity.referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
            if($request->facility_to) {
                $redirected = $redirected->where("activity.referred_to",$request->facility_to);
            }
            $redirected = $redirected->whereBetween("activity.created_at",[$per_day." 00:00:00",$per_day." 23:59:59"])
                ->where('activity.status','redirected')
                ->get();

            $transferred = Activity::
            select("activity.code","activity.created_at","activity.referred_to")
                ->where("activity.referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
            if($request->facility_to) {
                $transferred = $transferred->where("activity.referred_to",$request->facility_to);
            }
            $transferred = $transferred->whereBetween("activity.created_at",[$per_day." 00:00:00",$per_day." 23:59:59"])
            ->where('activity.status','transferred')
            ->get();

            foreach($referred as $refer) {
                $refer_to_seen = Seen::where("code",$refer->code)
                    ->where("created_at",">=",$refer->created_at)
                    ->where("facility_id",$refer->referred_to) //done
                    ->first();

                if($refer_to_seen) {
                    $refer_seen_holder[] = $this->getMinutes($refer->created_at,$refer_to_seen->created_at); //refer to seen
                    $refer_seen_overall[] = $this->getMinutes($refer->created_at,$refer_to_seen->created_at); //refer to seen
                    $refer_seen_details[] = [
                        "code" => $refer_to_seen->code,
                        "minutes" => $this->getMinutes($refer->created_at,$refer_to_seen->created_at),
                        "date_referred" => $refer->created_at,
                        "date_seened" => $refer_to_seen->created_at,
                        "date_referred_format" => date("M d, Y h:i A",strtotime($refer->created_at)),
                        "date_seened_format" => date("M d, Y h:i A",strtotime($refer_to_seen->created_at))
                    ];

                    $seen_to_accept = Activity::where("code",$refer_to_seen->code)
                        ->where("created_at",">=",$refer_to_seen->created_at)
                        ->where("referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
                    if($request->facility_to) {
                        $seen_to_accept = $seen_to_accept->where("referred_to",$request->facility_to);
                    }
                    $seen_to_accept = $seen_to_accept->where("status","accepted")
                        ->first();

                    if($seen_to_accept) {
                        $seen_accept_holder[] = $this->getMinutes($refer_to_seen->created_at,$seen_to_accept->created_at); // seen to accept

                        $accept_to_arrive = Activity::where("code",$seen_to_accept->code)
                            ->where("created_at",">=",$seen_to_accept->created_at)
                            //->where("referred_to",$user->facility_id) //previous
                            ->where("referred_from",$seen_to_accept->referred_to) //done kay if arrived ang action naka locate sa from
                            ->where("status","arrived")
                            ->first();

                        if($accept_to_arrive) {
                            $accept_arrive_holder[] = $this->getMinutes($seen_to_accept->created_at,$accept_to_arrive->created_at); // accept to arrive

                            $arrive_to_admit = Activity::where("code",$accept_to_arrive->code)
                                ->where("created_at",">=",$accept_to_arrive->created_at)
                                //->where("referred_to",$user->facility_id) //previous
                                ->where("referred_from",$accept_to_arrive->referred_from) //done kay if admitted ang action naka locate sa from
                                ->where("status","admitted")
                                ->first();

                            if($arrive_to_admit) {
                                $arrive_admit_holder[] = $this->getMinutes($accept_to_arrive->created_at,$arrive_to_admit->created_at); // arrive to admit

                                $admit_to_discharge = Activity::where("code",$arrive_to_admit->code)
                                    ->where("created_at",">=",$arrive_to_admit->created_at)
                                    //->where("referred_to",$user->facility_id) //previous
                                    ->where("referred_from",$arrive_to_admit->referred_from) //done kay if discharged ang action naka locate sa from
                                    ->where("status","discharged")
                                    ->first();

                                if($admit_to_discharge)
                                    $admit_discharge_holder[] = $this->getMinutes($arrive_to_admit->created_at,$admit_to_discharge->created_at); // admit to discharge
                            }
                            else {
                                $admit_to_discharge = Activity::where("code",$accept_to_arrive->code)
                                    ->where("created_at",">=",$accept_to_arrive->created_at)
                                    //->where("referred_to",$user->facility_id) //previous
                                    ->where("referred_from",$accept_to_arrive->referred_from) //done kay if discharged ang action naka locate sa from
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge) {
                                    $admit_discharge_holder[] = $this->getMinutes($accept_to_arrive->created_at,$admit_to_discharge->created_at); // admit to discharge
                                }
                            }
                        }
                    }

                    $seen_to_reject = Activity::where("code",$refer_to_seen->code)
                        ->where("created_at",">=",$refer_to_seen->created_at)
                        ->where("referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
                    if($request->facility_to) {
                        $seen_to_reject = $seen_to_reject->where("referred_to",$request->facility_to);
                    }
                    $seen_to_reject = $seen_to_reject->where("status","rejected")
                        ->first();

                    if($seen_to_reject) {
                        $seen_reject_holder[] = $this->getMinutes($refer_to_seen->created_at,$seen_to_reject->created_at); // seen to rejected
                    }
                }

                $refer_to_accept = Activity::where("code",$refer->code)
                    ->where("created_at",">=",$refer->created_at)
                    ->where("referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
                if($request->facility_to) {
                    $refer_to_accept = $refer_to_accept->where("referred_to",$request->facility_to);
                }
                $refer_to_accept = $refer_to_accept->where("status","accepted")
                    ->first();

                if($refer_to_accept) {
                    $refer_accept_holder[] = $this->getMinutes($refer->created_at,$refer_to_accept->created_at);
                    ////
                    $refer_accept_details[] = [
                        "code" => $refer_to_accept->code,
                        "minutes" => $this->getMinutes($refer->created_at,$refer_to_accept->created_at),
                        "date_referred" => $refer->created_at,
                        "date_accepted" => $refer_to_accept->created_at,
                        "date_referred_format" => date("M d, Y h:i A",strtotime($refer->created_at)),
                        "date_accepted_format" => date("M d, Y h:i A",strtotime($refer_to_accept->created_at)),
                        "status" => "referred"
                    ];
                }
            }

            foreach($redirected as $redirect) {
                $redirect_to_seen = Seen::where("code",$redirect->code)
                    ->where("created_at",">=",$redirect->created_at)
                    ->where("facility_id",$redirect->referred_to) //done must change and last change
                    ->first();

                if($redirect_to_seen) {
                    $redirect_seen_holder[] = $this->getMinutes($redirect->created_at,$redirect_to_seen->created_at); //redirect to seen

                    $seen_to_accept_redirect = Activity::where("code",$redirect_to_seen->code)
                        ->where("created_at",">=",$redirect_to_seen->created_at)
                        ->where("referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done must change and last change
                    if($request->facility_to) {
                        $seen_to_accept_redirect = $seen_to_accept_redirect->where("referred_to",$request->facility_to);
                    }
                    $seen_to_accept_redirect = $seen_to_accept_redirect->where("status","accepted")
                        ->first();

                    if($seen_to_accept_redirect) {
                        $seen_accept_holder_redirect[] = $this->getMinutes($redirect_to_seen->created_at,$seen_to_accept_redirect->created_at); // seen to accept

                        $accept_to_arrive_redirect = Activity::where("code",$seen_to_accept_redirect->code)
                            ->where("created_at",">=",$seen_to_accept_redirect->created_at)
                            //->where("referred_to",$user->facility_id) //previous
                            ->where("referred_from",$seen_to_accept_redirect->referred_to) //done from siya if ang action kay arrived
                            ->where("status","arrived")
                            ->first();

                        if($accept_to_arrive_redirect) {
                            $accept_arrive_holder_redirect[] = $this->getMinutes($seen_to_accept_redirect->created_at,$accept_to_arrive_redirect->created_at); // accept to arrive

                            $arrive_to_admit_redirect = Activity::where("code",$accept_to_arrive_redirect->code)
                                ->where("created_at",">=",$accept_to_arrive_redirect->created_at)
                                //->where("referred_to",$user->facility_id) //previous
                                ->where("referred_from",$accept_to_arrive_redirect->referred_from) //done from siya if ang action kay admitted
                                ->where("status","admitted")
                                ->first();

                            if($arrive_to_admit_redirect) {
                                $arrive_admit_holder_redirect[] = $this->getMinutes($accept_to_arrive_redirect->created_at,$arrive_to_admit_redirect->created_at); // arrive to admit

                                $admit_to_discharge_redirect = Activity::where("code",$arrive_to_admit_redirect->code)
                                    ->where("created_at",">=",$arrive_to_admit_redirect->created_at)
                                    //->where("referred_to",$user->facility_id) //previous
                                    ->where("referred_from",$arrive_to_admit_redirect->referred_from) //done from siya if ang action kay discharged
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge_redirect)
                                    $admit_discharge_holder_redirect[] = $this->getMinutes($arrive_to_admit_redirect->created_at,$admit_to_discharge_redirect->created_at); // admit to discharge
                            }
                            else {
                                $admit_to_discharge_redirect = Activity::where("code",$accept_to_arrive_redirect->code)
                                    ->where("created_at",">=",$accept_to_arrive_redirect->created_at)
                                    //->where("referred_to",$user->facility_id) //previous
                                    ->where("referred_from",$accept_to_arrive_redirect->referred_from) //done from siya if ang action kay discharged
                                    ->where("status","discharged")
                                    ->first();
                                if($admit_to_discharge_redirect) {
                                    $admit_discharge_holder_redirect[] = $this->getMinutes($accept_to_arrive_redirect->created_at,$admit_to_discharge_redirect->created_at); // admit to discharge
                                }
                            }
                        }
                    }

                    $seen_to_reject_redirect = Activity::where("code",$redirect_to_seen->code)
                        ->where("created_at",">=",$redirect_to_seen->created_at)
                        ->where("referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
                    if($request->facility_to) {
                        $seen_to_reject_redirect = $seen_to_reject_redirect->where("referred_to",$request->facility_to);
                    }
                    $seen_to_reject_redirect = $seen_to_reject_redirect->where("status","rejected")
                        ->first();
                    if($seen_to_reject_redirect) {
                        $seen_reject_holder_redirect[] = $this->getMinutes($redirect_to_seen->created_at,$seen_to_reject_redirect->created_at); // seen to rejected
                    }
                }


                $redirect_to_accept = Activity::where("code",$redirect->code)
                    ->where("created_at",">=",$redirect->created_at)
                    ->where("referred_from",$request->facility_from ? $request->facility_from : $user->facility_id); //done
                if($request->facility_to) {
                    $redirect_to_accept = $redirect_to_accept->where("referred_to",$request->facility_to);
                }
                $redirect_to_accept = $redirect_to_accept->where("status","accepted")
                    ->first();

                if($redirect_to_accept) {
                    $redirect_accept_holder[] = $this->getMinutes($redirect->created_at,$redirect_to_accept->created_at); //redirect to accept
                    ////
                    $redirect_accept_details[] = [
                        "code" => $redirect_to_accept->code,
                        "minutes" => $this->getMinutes($redirect->created_at,$redirect_to_accept->created_at),
                        "date_redirected" => $redirect->created_at,
                        "date_accepted" => $redirect_to_accept->created_at,
                        "date_redirected_format" => date("M d, Y h:i A",strtotime($redirect->created_at)),
                        "date_accepted_format" => date("M d, Y h:i A",strtotime($redirect_to_accept->created_at)),
                        "status" => "redirected"
                    ];
                }
            }

            foreach($transferred as $transfer) {
                $transfer_to_accept = Activity::where("code",$transfer->code)
                    ->where("created_at",">=",$transfer->created_at)
                    //->where("referred_from",$user->facility_id) //previous
                    ->where("referred_to",$transfer->referred_to) //done referred_to siya kay outgoing
                    ->where("status","accepted")
                    ->first();

                if($transfer_to_accept) {
                    $transfer_accept_holder[] = $this->getMinutes($transfer->created_at,$transfer_to_accept->created_at); // transfer to accept
                }
            }

            $c = array_column($refer_accept_details,'minutes'); // which column needed to be sorted
            array_multisort($c,SORT_DESC,$refer_accept_details); // sorts the array $refer_accept_details with respective of aray $c

            $d = array_column($redirect_accept_details,'minutes'); // which column needed to be sorted
            array_multisort($d,SORT_DESC,$redirect_accept_details); // sorts the array $redirect_accept_details with respective of aray $c

            $data[] = [
                "date" => date("M d",strtotime($per_day)),
                "referred" => count($referred),
                "redirected" => count($redirected),
                "transferred" => count($transferred),
                "refer_to_accept_details" => $refer_accept_details,
                "refer_to_accept" => round(collect($refer_accept_holder)->avg(),2),
                "redirect_to_accept_details" => $redirect_accept_details,
                "redirect_to_accept" => round(collect($redirect_accept_holder)->avg(),2),
                "transfer_to_accept" => round(collect($transfer_accept_holder)->avg(),2)
            ];
            $refer_accept_holder = [];
            $refer_accept_details = [];
            $redirect_accept_holder = [];
            $transfer_accept_holder = [];
        }

        $b = array_column($refer_seen_details,'minutes'); // which column needed to be sorted
        array_multisort($b,SORT_DESC,$refer_seen_details); // sorts the array $a with respective of aray $b

        return view('admin.report.tat_outgoing',[
            "data_points" => $data,
            "user" => $user,

            "refer_to_seen_details" => $refer_seen_details,
            "refer_to_seen" => $this->formatTheTAT(round(collect($refer_seen_holder)->avg(),2)),
            "seen_to_accept" => $this->formatTheTAT(round(collect($seen_accept_holder)->avg(),2)),
            "seen_to_reject" => $this->formatTheTAT(round(collect($seen_reject_holder)->avg(),2)),
            "accept_to_arrive" => $this->formatTheTAT(round(collect($accept_arrive_holder)->avg(),2)),
            "arrive_to_admit" => $this->formatTheTAT(round(collect($arrive_admit_holder)->avg(),2)),
            "admit_to_discharge" => $this->formatTheTAT(round(collect($admit_discharge_holder)->avg(),2)),


            "redirect_to_seen" => $this->formatTheTAT(round(collect($redirect_seen_holder)->avg(),2)),
            "seen_to_accept_redirect" => $this->formatTheTAT(round(collect($seen_accept_holder_redirect)->avg(),2)),
            "seen_to_reject_redirect" => $this->formatTheTAT(round(collect($seen_reject_holder_redirect)->avg(),2)),
            "accept_to_arrive_redirect" => $this->formatTheTAT(round(collect($accept_arrive_holder_redirect)->avg(),2)),
            "arrive_to_admit_redirect" => $this->formatTheTAT(round(collect($arrive_admit_holder_redirect)->avg(),2)),
            "admit_to_discharge_redirect" => $this->formatTheTAT(round(collect($admit_discharge_holder_redirect)->avg(),2)),

            "date_start" => $date_start,
            "date_end" => $date_end,
            "province_select_from" => $request->province_from,
            "province_select_to" => $request->province_to,
            "facility_select_from" => $request->facility_from,
            "facility_select_to" => $request->facility_to,
            "facility_name_from" => Facility::find($request->facility_from)->name,
            "facility_name_to" => Facility::find($request->facility_to)->name
        ]);
    }

    public function online1(Request $request) //12/23/2019 created
    {
        $date = Session::get('dateReportOnline');
        if(!$date)
            $date = date('Y-m-d');

        $start = date('Y-m-d',strtotime($date)).' 00:00:00';
        $end = date('Y-m-d',strtotime($date)).' 23:59:59';

        $province_select = $request->province;
        $facility_select = $request->facility;
        $user_level_select = $request->level;

        $data = \DB::connection('mysql')->select("call AttendanceFunc('$start','$end','$province_select','$facility_select','$user_level_select')");

        $user_level = User::select("level")->groupBy("level")->get();
        $province = Province::get();

        return view('admin.online',[
            'title' => 'Online Users',
            'data' => $data,
            'user_level' => $user_level,
            'province' => $province,
            'province_select' => $province_select,
            'facility_select' => $facility_select,
            'facility_select_name' => Facility::find($facility_select)->name,
            'user_level_select' => $user_level_select
        ]);
    }

    public function onlineFacility(Request $request) {
        if($request->isMethod('post') && isset($request->day_date)){
            $day_date = date('Y-m-d',strtotime($request->day_date));
        } else {
            $day_date = date('Y-m-d');
        }

        $province_select = $request->province;
        $data = \DB::connection('mysql')->select("call online_facility('$day_date','$province_select')");
        $province = Province::get();

        return view('admin.report.online_facility',[
            'title' => 'ONLINE FACILITY',
            'data' => $data,
            'day_date' => $day_date,
            'province' => $province,
            'province_select' => $province_select,
        ]);
    }

    public function offlineFacility(Request $request,$province_id){
        if($request->isMethod('post') && isset($request->day_date))
            $day_date = date('Y-m-d',strtotime($request->day_date));
        else
            $day_date = date('Y-m-d');

        $data = \DB::connection('mysql')->select("call offline_facility('$day_date','$province_id')");

        return view('admin.report.offline_facility',[
            'title' => 'Offline Facility',
            "data" => $data,
            'day_date' => $day_date,
            'province_id' => $province_id
        ]);
    }

    public function weeklyReport($province_id,Request $request){
        if($request->isMethod('post') && isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0]));
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1]));
        } else {
            $date_start = date('Y-m-d',strtotime(Carbon::now()->subDays(31)));
            $date_end = date('Y-m-d');
        }

        $facility = Facility::select("id as facility_id","hospital_type","name")->where("referral_used","yes")
            ->where("province",$province_id)
            ->orderBy(DB::raw("
                CASE
                    WHEN hospital_type = 'government' THEN 'a'
                    WHEN hospital_type = 'private' THEN 'b'
                    ELSE hospital_type
                END 
            "),"asc")
            ->orderBy("name","desc")
            ->get();
        $generate_weeks = \DB::connection('mysql')->select("call generate_weeks('$date_start','$date_end')");

        return view('admin.report.offline_facility_weekly',[
            'title' => 'Login Status',
            'facility' => $facility,
            'generate_weeks' => $generate_weeks,
            'date_start' => $date_start,
            'date_end' => $date_end,
            "province" => Province::find($province_id)->description,
            "province_id" => $province_id
        ]);
    }

    public function onboardFacility(Request $request,$province_id) {
        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Activity::select("created_at")->orderBy("created_at","asc")->first()->created_at;
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $data = \DB::connection('mysql')->select("call onboard_facility('$province_id','$date_start','$date_end')");

        //return view($province_id ? 'admin.report.onboard_facility' : 'admin.report.onboard_facility_all',[
        return view('admin.report.onboard_facility',[
            'title' => 'ONBOARD FACILITY',
            'data' => $data,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'province_id' => $province_id
        ]);
    }

    public function onboardUsers(){
        $onboard_users = \DB::connection('mysql')->select("call onboard_users()");
        return view('admin.report.onboard_users',[
            "onboard_users" => $onboard_users
        ]);
    }

    public function statisticsReport(Request $request) {
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfDay()->format('Y-m-d').' 23:59:59';
            $request->date_range = $date_start." - ".$date_end;
        }
        $apiCtrl = new ApiController();
        $data = $apiCtrl->api($request);

        $hospital_type_list = Facility::select("hospital_type")->whereNotNull("hospital_type")->groupBy("hospital_type")->get();
        $province_list = Province::get();

        return view('admin.report.statistics',[
            'data' => $data,
            'date_range_start' => $date_start,
            'date_range_end' => $date_end,
            'request_type' => $request->request_type,
            'hospital_type' => $request->hospital_type,
            'province_id' => $request->province_id,
            'facility_id' => $request->facility_id,
            'muncity_id' => $request->muncity_id,
            'barangay_id' => $request->barangay_id,
            'hospital_type_list' => $hospital_type_list,
            'province_list' => $province_list
        ]);
    }

    public function erobReport(Request $request){
        if($request->isMethod('post') && isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $stored_name = "er_ob_report('$date_start','$date_end')";
        $data = \DB::connection('mysql')->select("call $stored_name");

        return view('admin.report.er_ob',[
            'title' => 'ER OB REPORT',
            "data" => $data,
            'date_range_start' => $date_start,
            'date_range_end' => $date_end
        ]);
    }

    public function averageUsersOnline(){
        $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
        $date_end = Carbon::now()->endOfYear()->format('Y-m-d').' 23:59:59';

        $data = \DB::connection('mysql')->select("call average_login_month('$date_start','$date_end')");
        return view('admin.report.average_users_online',[
            "data" => $data
        ]);
    }

    public function sottoReports() {
        return view("admin.report.sotto_reports");
    }

    public function topIcd(Request $request) {
        $user = Session::get('auth');
        $facility_id = $user->facility_id;
        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = '2022-01-13 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $icd = Icd::
                select("icd.icd_id","icd10.code","icd10.description",DB::raw("count(icd.icd_id) as count"))
                ->leftJoin("icd10","icd10.id","=","icd.icd_id");


        $icd = $icd->leftJoin("activity",function($join) {
                    $join->on("activity.code","=","icd.code");
                    $join->on(function($join1) {
                        $join1->where("activity.status","=","referred");
                        $join1->orWhere("activity.status","=","redirected");
                        $join1->orWhere("activity.status","=","transferred");
                    });
                });

        if($user->level != 'admin'){
            $icd = $icd->where(empty($request->request_type) || $request->request_type == "incoming" ? "activity.referred_to" : "activity.referred_from", $facility_id);
        }

        if($request->province_id) {
           $icd = $icd->leftJoin("facility","facility.id","=","activity.referred_to")
               ->where("facility.province",$request->province_id);
        }

        $icd =  $icd->whereBetween("icd.created_at",[$date_start,$date_end])
                ->groupBy("icd.icd_id")
                ->OrderBY(DB::raw("count(icd.icd_id)"),"desc")
                ->limit(10)
                ->get();

        Session::put("export_top_icd_excel_all",$icd);

        return view("admin.report.top_icd",[
            "icd" => $icd,
            "date_start" => $date_start,
            "date_end" => $date_end,
            "province_id" => $request->province_id,
            "request_type" => $request->request_type
        ]);
    }

    public function exportTopIcdAllExcel() {
        $export_top_icd_excel_all = Session::get("export_top_icd_excel_all");
        $file_name = "export_top_icd_excel_all.xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('admin.excel.export_top_icd_all',[
            "data" => $export_top_icd_excel_all
        ]);
    }

    public function icdFilter(Request $request) {
        $icd = Icd::
                select(
                    "icd.code",
                    "icd.id as icd_id",
                    DB::raw('CONCAT(pat.fname," ",pat.mname,". ",pat.lname) as patient_name'),
                    DB::raw(ParamCtrl::getAge("pat.dob")." as age"),
                    "pro.description as province",
                    "mun.description as muncity",
                    "bar.description as barangay",
                    "icd10.code as icd_code",
                    "icd10.description as icd_description"
                )
                ->leftJoin("tracking as track","track.code","=","icd.code")
                ->leftJoin("patients as pat","pat.id","=","track.patient_id")
                ->leftJoin("province as pro","pro.id","=","pat.province")
                ->leftJoin("muncity as mun","mun.id","=","pat.muncity")
                ->leftJoin("barangay as bar","bar.id","=","pat.brgy")
                ->leftJoin("icd10","icd10.id","=","icd.icd_id")
                ->where("icd.icd_id",$request->icd_id)
                ->whereBetween("icd.created_at",[$request->date_start,$request->date_end])
                ->get();

        Session::put("export_top_icd_excel",$icd);

        return $icd;
    }

    public function exportTopIcdExcel() {
        $export_top_icd_excel = Session::get("export_top_icd_excel");
        $file_name = "export_top_icd_excel.xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('admin.excel.export_top_icd',[
            "data" => $export_top_icd_excel
        ]);
    }
    //--------------------------------added code for declined
   public function getDeclinedRemarks($status, $level, $date_start, $date_end){

//---------------------------------------------------------------------------------->
        // $data = Activity::query();
    
        // if($status == 'rejected'){
        //     $data = $data->whereIn("referred_to", $level)
        //         ->where("status", 'rejected')
        //         ->whereBetween('created_at', [$date_start,$date_end])
        //         ->select('remarks','created_at', DB::raw('COUNT(remarks) as count'))
        //         ->groupBy('remarks')
        //         ->havingRaw('COUNT(*) > 1')
        //         ->orderBy('count', 'desc')
        //         ->limit(10)
        //         ->get();

        // } else {
        //     return "Invalid status";
        // }

        // return $data;
//------------------------------------------------------------------------------------>

        if($status !== 'rejected'){
            return 'Invalid Status';
        }

        $remarksData = Activity::query()
            ->whereIn("referred_to", $level)
            ->where("status", 'rejected')
            ->whereBetween('created_at', [$date_start, $date_end])
            ->select('remarks', 'created_at')
            ->get();

        $groupRemarks = [];
        $threshold = 2;

        foreach($remarksData as $remarksData){
            $remark = $remarksData->remarks;
            $grouped = false;
            
            foreach($groupRemarks as &$group){
                if(levenshtein($remark, $group['remark']) <= $threshold){
                    $group['count']++;
                    $group['remarks'][] = $remarksData;
                    // Track the most frequent remark within each group
                    if(isset($group['remark_frequency'][$remark])){
                        $group['remark_frequency'][$remark]++;
                    }else{
                        $group['remark_frequency'][$remark] = 1;
                    }

                      // Update the main remark if the current remark is more frequent
                    if ($group['remark_frequency'][$remark] > $group['remark_frequency'][$group['remark']]) {
                        $group['remark'] = $remark;
                    }

                    $grouped = true;
                    break;
                }
            } 

            if(!$grouped){
                $groupRemarks[] = [
                    'remark' => $remark,
                    'count' => 1,
                    'remarks' => [$remarksData],
                    'remark_frequency' => [$remark => 1]
                ];
            }

        }
        // Filter groups where count > 1
        $groupRemarks = array_filter($groupRemarks, function ($group) {
            return $group['count'] > 1;
        });
        //descending order  take the highest count 
        usort($groupRemarks, function($as, $bs){
            return $bs['count'] <=> $as['count'];
        });

        $result = array_map(function($group){
            return[
                'remarks' => $group['remark'],
                'count' => $group['count'],
            ];
        }, array_slice($groupRemarks, 0, 10));
       
        // $result1 = array_slice($groupRemarks, 0, 10);
 
        return $result;
    }

    public function populateLevel($level){
        $facility = Facility::select("id","level");

        if ($level == 2) {
            $facility = $facility->where('level', '2')->where('id', '!=', 24);
        } elseif ($level == 3) {
            $facility = $facility->where('level', '3')->where('id', '!=', 24);
        } elseif ($level == 5) {
            $facility = $facility->where('id', '=', 24);
        } else {
            return "Invalid level";
        }

        return $facility->pluck('id')->toArray();
    }   

    public function getDeclinedHolder($date_start, $date_end){
        
        $facilityLevel2 = $this->getDeclinedRemarks("rejected", $this->populateLevel(2), $date_start, $date_end);
        $facilityLevel3 = $this->getDeclinedRemarks("rejected", $this->populateLevel(3), $date_start, $date_end);
        $vecenteSottoFacility = $this->getDeclinedRemarks("rejected", $this->populateLevel(5), $date_start, $date_end);

        return [
            "Level2" =>  $facilityLevel2,
            "Level3" =>  $facilityLevel3,
            "Vecente Sotto" => $vecenteSottoFacility,
        ];
    }

    public function topReasonForDeclined(Request $request) {
        // Log::info('Request Dataadsasdasd22: ', $request->all());

        if($request->date_range){
            $dates = explode(' - ', $request->date_range);
            $date_start = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay()->format('Y-m-d H:i:s');
            $date_end = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay()->format('Y-m-d H:i:s');
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
        }

        $date_range = date('m/d/Y', strtotime($date_start)).' - '.date('m/d/Y', strtotime($date_end));
        
        $data = $this->getDeclinedHolder($date_start, $date_end);
        $selectedFacility = $request->facility_category;
        // Debugging statement

        return view('admin.report.top_reason_for_declined', [
            'data' => $data,
            'date_range' => $date_range,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'selected_category' => $selectedFacility,
        ]);
    }

    //-------------------------------------------------------
    public function topReasonForReferral(Request $request) {
        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = '2022-01-13 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $pregnant_form = PregnantForm::
            select("reason_referral")
            ->whereNotNull("reason_referral")
            ->where("reason_referral","!=","-1");

        if($request->province_id) {
            $pregnant_form = $pregnant_form->leftJoin("facility","facility.id","=","pregnant_form.referred_to")
                ->where("facility.province",$request->province_id);
        }
        $pregnant_form = $pregnant_form->whereBetween("pregnant_form.created_at",[$date_start,$date_end]);

        $union = PatientForm::
            select("reason_referral")
            ->whereNotNull("reason_referral")
            ->where("reason_referral","!=","-1");

        if($request->province_id) {
            $union = $union->leftJoin("facility","facility.id","=","patient_form.referred_to")
                ->where("facility.province",$request->province_id);
        }

        $union = $union->whereBetween("patient_form.created_at",[$date_start,$date_end])
            ->unionAll($pregnant_form);

        $reason_for_referral = DB::table( DB::raw("({$union->toSql()}) as sub") )
            ->mergeBindings($union->getQuery())
            ->leftJoin("reason_referral","reason_referral.id","=","sub.reason_referral")
            ->select("reason_referral.id","reason_referral.reason",DB::raw("count(reason_referral.id) as count"))
            ->groupBy("reason_referral.id")
            ->OrderBY(DB::raw("count(reason_referral.id)"),"desc")
            ->get();

        return view("admin.report.top_reason_for_referral",[
            "reason_for_referral" => $reason_for_referral,
            "date_start" => $date_start,
            "date_end" => $date_end,
            "province_id" => $request->province_id
        ]);
    }

    public function filterTopReasonReferral(Request $request) {
        $pregnant_form = PregnantForm::
        select("reason_referral","code","patient_woman_id as patient_id")
            ->whereNotNull("reason_referral")
            ->where("reason_referral","!=","-1")
            ->where("reason_referral",$request->reason_referral_id);

        if($request->province_id) {
            $pregnant_form = $pregnant_form->leftJoin("facility","facility.id","=","pregnant_form.referred_to")
                ->where("facility.province",$request->province_id);
        }
        $pregnant_form = $pregnant_form->whereBetween("pregnant_form.created_at",[$request->date_start,$request->date_end]);

        $union = PatientForm::
        select("reason_referral","code","patient_id")
            ->whereNotNull("reason_referral")
            ->where("reason_referral","!=","-1")
            ->where("reason_referral",$request->reason_referral_id);

        if($request->province_id) {
            $union = $union->leftJoin("facility","facility.id","=","patient_form.referred_to")
                ->where("facility.province",$request->province_id);
        }

        $union = $union->whereBetween("patient_form.created_at",[$request->date_start,$request->date_end])
            ->unionAll($pregnant_form);

        $reason_for_referral = DB::table( DB::raw("({$union->toSql()}) as sub") )
            ->mergeBindings($union->getQuery())
            ->leftJoin("reason_referral","reason_referral.id","=","sub.reason_referral")
            ->leftJoin("patients as pat","pat.id","=","patient_id")
            ->leftJoin("province as pro","pro.id","=","pat.province")
            ->leftJoin("muncity as mun","mun.id","=","pat.muncity")
            ->leftJoin("barangay as bar","bar.id","=","pat.brgy")
            ->select(
                "reason_referral.id",
                        "reason_referral.reason",
                        "code",
                        DB::raw('CONCAT(pat.fname," ",pat.mname,". ",pat.lname) as patient_name'),
                        DB::raw(ParamCtrl::getAge("pat.dob")." as age"),
                        "pro.description as province",
                        "mun.description as muncity",
                        "bar.description as barangay"
            )
            ->get();

        Session::put("export_reason_referral_excel",$reason_for_referral);
        return $reason_for_referral;
    }

    public function exportReasonForReferralExcel() {
        $export_top_icd_excel = Session::get("export_reason_referral_excel");
        $file_name = "export_reason_referral_excel.xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('admin.excel.export_reason_referral',[
            "data" => $export_top_icd_excel
        ]);
    }

    public function deactivated() {
        $date = Session::get('dateReportDeact');

        if(!$date){
            $date = Carbon::now()->startOfMonth();
        }

        $data = User::where("status", "inactive")->where("updated_at","like",'%'.$date.'%')->orderBy('facility_id')->get(); //TODO: possible changes for multiple facility log-in

        return view("admin.report.deactivated", [
            'title' => 'Deactivated Users',
            "data" => $data
        ]);
    }

    public function filterDeactivated(Request $req) {
        Session::put('dateReportDeact',$req->date);
        return self::deactivated();
    }

    private function getTotalCases($province, $start, $end) {
        $normal = PatientForm::select(
            'faci.id as facility_id',
            'faci.name as facility_name',
            'patient_form.referred_to',
            'patient_form.refer_clinical_status',
            'patient_form.refer_sur_category',
            'patient_form.dis_sur_category'
        )
            ->where('faci.province', $province)
            ->leftJoin('facility as faci','faci.id','=','patient_form.referred_to')
            ->where(function($query) {
                $query->whereNotNull('patient_form.refer_clinical_status')
                    ->orWhereNotNull('patient_form.refer_sur_category')
                    ->orWhereNotNull('patient_form.dis_sur_category');
            })
            ->whereBetween('patient_form.time_referred',[$start,$end])
            ->orderBy('facility_name','asc')
            ->get();
        $pregnant = PregnantForm::select(
            'faci.id as facility_id',
            'faci.name as facility_name',
            'pregnant_form.referred_to',
            'pregnant_form.refer_clinical_status',
            'pregnant_form.refer_sur_category',
            'pregnant_form.dis_sur_category'
        )
            ->where('faci.province', $province)
            ->leftJoin('facility as faci','faci.id','=','pregnant_form.referred_to')
            ->where(function($query) {
                $query->whereNotNull('pregnant_form.refer_clinical_status')
                    ->orWhereNotNull('pregnant_form.refer_sur_category')
                    ->orWhereNotNull('pregnant_form.dis_sur_category');
            })
            ->whereBetween('pregnant_form.referred_date',[$start,$end])
            ->orderBy('facility_name','asc')
            ->get();

        $total = count($normal) + count($pregnant);
        return array(
            'normal' => $normal,
            'pregnant'=> $pregnant,
            'total' => $total
        );
    }

    private function getCovidBg($cases) {
        if($cases > 1000)
            return 'bg-red-active';
        else if($cases < 1000 && $cases >= 500)
            return 'bg-yellow-active';
        else
            return 'bg-teal-active';
    }

    public function covidReport(Request $request, $province) {
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfDay()->format('Y-m-d').' 23:59:59';
            $request->date_range = $date_start." - ".$date_end;
        }

        Session::put('startDateCovidReport',$date_start);
        Session::put('endDateCovidReport',$date_end);

        $bohol_cases = self::getTotalCases(1, $date_start, $date_end);
        $cebu_cases = self::getTotalCases(2, $date_start, $date_end);
        $negros_cases = self::getTotalCases(3, $date_start, $date_end);
        $siquijor_cases = self::getTotalCases(4, $date_start, $date_end);


        if($province == 1) {
            $data = $bohol_cases;
        } else if($province == 2) {
            $data = $cebu_cases;
        } else if($province == 3) {
            $data = $negros_cases;
        } else {
            $data = $siquijor_cases;
        }
        $normal = self::countCases($data['normal']);
        $pregnant = self::countCases($data['pregnant']);

        $final = array();
        $asymp = $mild = $moderate = $severe = $critical = 0;
        $refer_contact = $refer_suspect = $refer_probable = $refer_confirmed = 0;
        $dis_contact = $dis_suspect = $dis_probable = $dis_confirmed = 0;

        for($i = 0; $i < count($normal); $i++) {
            $norm = $normal[$i];
            for($j = 0; $j < count($pregnant); $j++) {
                $preg = $pregnant[$j];
                if($norm['id'] === $preg['id']) {
                    $asymp = $norm['asymp'] + $preg['asymp'];
                    $mild = $norm['mild'] + $preg['mild'];
                    $moderate = $norm['moderate'] + $preg['moderate'];
                    $severe = $norm['severe'] + $preg['severe'];
                    $critical = $norm['critical'] + $preg['critical'];
                    $refer_contact = $norm['refer_contact'] + $preg['refer_contact'];
                    $refer_suspect = $norm['refer_suspect'] + $preg['refer_suspect'];
                    $refer_probable = $norm['refer_probable'] + $preg['refer_probable'];
                    $refer_confirmed = $norm['refer_confirmed'] + $preg['refer_confirmed'];
                    $dis_contact = $norm['dis_contact'] + $preg['dis_contact'];
                    $dis_suspect = $norm['dis_suspect'] + $preg['dis_suspect'];
                    $dis_probable = $norm['dis_probable'] + $preg['dis_probable'];
                    $dis_confirmed = $norm['dis_confirmed'] + $preg['dis_confirmed'];
                    $total = $norm['total'] + $preg['total'];
                    array_push($final, array(
                        'total' => $total,
                        'id' => $norm['id'],
                        'name' => $norm['name'],
                        'asymp' => $asymp,
                        'mild' => $mild,
                        'moderate' => $moderate,
                        'severe' => $severe,
                        'critical' => $critical,
                        'refer_contact' => $refer_contact,
                        'refer_suspect' => $refer_suspect,
                        'refer_probable' => $refer_probable,
                        'refer_confirmed' => $refer_confirmed,
                        'dis_contact' => $dis_contact,
                        'dis_suspect' => $dis_suspect,
                        'dis_probable' => $dis_probable,
                        'dis_confirmed' => $dis_confirmed
                    ));
                    $normal[$i] = null;
                    $pregnant[$j] = null;
                }
            }
        }

        if(count($normal) > 0) {
            foreach($normal as $norm) {
                if($norm !== NULL) {
                    array_push($final, $norm);
                }
            }
        }
        if(count($pregnant) > 0) {
            foreach($pregnant as $preg) {
                if($preg !== NULL) {
                    array_push($final, $preg);
                }
            }
        }

        rsort($final);

        return view("admin.report.covid_report", [
            'title' => 'Covid Report',
            'province' => $province,
            'data' => $final,
            'count_bohol' => $bohol_cases['total'],
            'count_cebu' => $cebu_cases['total'],
            'count_negros' => $negros_cases['total'],
            'count_siquijor' => $siquijor_cases['total'],
            'bohol_bg' => self::getCovidBg($bohol_cases['total']),
            'cebu_bg' => self::getCovidBg($cebu_cases['total']),
            'negros_bg' => self::getCovidBg($negros_cases['total']),
            'siquijor_bg' => self::getCovidBg($siquijor_cases['total'])
        ]);
    }

    public function coordinatedData($date_start, $date_end, $pluck_from, $pluck_to) {
        $data = Activity::whereBetween("created_at",[$date_start,$date_end])
                                ->where(function ($query) {
                                    $query->where('status', 'referred')
                                        ->orWhere('status', 'redirected')
                                        ->orWhere('status', 'transferred');
                                })
                                ->whereIn("referred_from", $pluck_from)
                                ->whereIn("referred_to", $pluck_to)
                                ->count();

        return $data;
    }
    
    public function coordinatedPluck($category, $level) {
        $pluck = Facility::
                    select('id')
                    ->where('referral_used','yes')
                    ->where('province',2);

        if($category == 'cebu_province') {
            $pluck = $pluck->where('muncity', '!=', 63) //cebu city
            ->where('muncity', '!=', 80) //mandaue city
            ->where('muncity', '!=', 76); //lapulapu city
        } 
        else if ($category == 'cebu_city') {
            $pluck = $pluck->where('muncity', 63);
        }
        else if ($category == 'mandaue_city') {
            $pluck = $pluck->where('muncity', 80);
        }
        else if ($category == 'lapulapu_city') {
            $pluck = $pluck->where('muncity', 76);
        }
        else {
            return 'error in category';
        }
                    
        if($level == 'rhu') {
            $pluck = $pluck->where(function ($query) {
                $query->where('level', 'infirmary')
                    ->orWhere('level', 'primary_care_facility')
                    ->orWhere('level', 'RHU');
            });
        }
        else if ($level == 1 || $level == 2 || $level == 3) {
            $pluck = $pluck->where('level', $level);
        }
        else {
            return 'error in level';
        }        
        
        $pluck = $pluck->get();

        return $pluck;
    }

    public function coordinatedMappers($category, $date_start, $date_end) {
        $categoryOptions = ["rhu", 1, 2, 3];
        $categoryColumn = ["rhu" => "RHU", 1 => "LEVEL 1", 2 => "LEVEL 2", 3 => "LEVEL 3"];
        $mappers = [];
    
        foreach($categoryOptions as $cat1) {
            $total = 0;
            $categoryData = [];
    
            foreach($categoryOptions as $cat2) {
                $refer = $this->coordinatedData(
                    $date_start,
                    $date_end,
                    $this->coordinatedPluck($category, $cat1),
                    $this->coordinatedPluck($category, $cat2)
                );
                $total += $refer;
                $categoryData[] = [
                    "pointed" => $categoryColumn[$cat1],
                    "category" => $category,
                    "coordinate" => $categoryColumn[$cat1].' TO '.$categoryColumn[$cat2],
                    "refer" => $refer
                ];
            }
    
            foreach ($categoryData as &$data) {
                if ($total > 0) {
                    $data["percentage"] = round(($data["refer"] / $total) * 100).'%';
                } else {
                    $data["percentage"] = 0;
                }
                $mappers[] = $data;
            }
    
            $mappers[] = [
                "pointed" => $categoryColumn[$cat1+1],
                "total" => $total
            ];
        }
    
        return $mappers;
    }

    public function coordinatedReferral(Request $request) {
        $category = $request->category ? $request->category : 'cebu_province';
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfDay()->format('Y-m-d').' 23:59:59';
            $request->date_range = $date_start." - ".$date_end;
        }

        $start = \Carbon\Carbon::parse($date_start)->format('m/d/Y');
        $end = \Carbon\Carbon::parse($date_end)->format('m/d/Y');
        $data = $this->coordinatedMappers($category, $date_start, $date_end); 

        return view("admin.report.coordinated_referral", [
            "start" => $start,
            "end" => $end,
            "category" => $category,
            "data" => $data
        ]);
    }

    function countCases($data) {
        $facilities = array();
        $asymp = 0;
        $mild = 0;
        $moderate = 0;
        $severe = 0;
        $critical = 0;
        $refer_contact = 0;
        $refer_suspect = 0;
        $refer_probable = 0;
        $refer_confirmed = 0;
        $dis_contact = 0;
        $dis_suspect = 0;
        $dis_probable = 0;
        $dis_confirmed = 0;
        $total = 0;

        for($i = 0; $i < count($data); $i++) {
            $row = $data[$i];

            $clinic_stat = $row->refer_clinical_status;
            if($clinic_stat != 'NULL') {
                if ($clinic_stat === 'asymptomatic')
                    $asymp++;
                else if ($clinic_stat === 'mild')
                    $mild++;
                else if ($clinic_stat === 'moderate')
                    $moderate++;
                else if ($clinic_stat === 'severe')
                    $severe++;
                else if ($clinic_stat === 'critical')
                    $critical++;
            }

            $refer_sur = $row->refer_sur_category;
            if($refer_sur != 'NULL') {
                if ($refer_sur === 'contact_pum')
                    $refer_contact++;
                else if ($refer_sur === 'suspect')
                    $refer_suspect++;
                else if ($refer_sur === 'probable')
                    $refer_probable++;
                else if ($refer_sur === 'confirmed')
                    $refer_confirmed++;
            }

            $dis_sur = $row->dis_sur_category;
            if($dis_sur != 'NULL') {
                if ($dis_sur === 'contact_pum')
                    $dis_contact++;
                else if ($dis_sur === 'suspect')
                    $dis_suspect++;
                else if ($dis_sur === 'probable')
                    $dis_probable++;
                else if ($dis_sur === 'confirmed')
                    $dis_confirmed++;
            }

            if($clinic_stat != 'NULL' || $refer_sur != "NULL" || $dis_sur != "NULL") {
                $total++;
            }

            if($row->facility_id !== $data[$i+1]->facility_id) {
                $data2 = array(
                    'total' => $total,
                    'id' => $row->facility_id,
                    'name' => $row->facility_name,
                    'asymp' => $asymp,
                    'mild' => $mild,
                    'moderate' => $moderate,
                    'severe' => $severe,
                    'critical' => $critical,
                    'refer_contact' => $refer_contact,
                    'refer_suspect' => $refer_suspect,
                    'refer_probable' => $refer_probable,
                    'refer_confirmed' => $refer_confirmed,
                    'dis_contact' => $dis_contact,
                    'dis_suspect' => $dis_suspect,
                    'dis_probable' => $dis_probable,
                    'dis_confirmed' => $dis_confirmed
                );
                array_push($facilities,$data2);
                $asymp = $mild = $moderate = $severe = $critical = 0;
                $refer_contact = $refer_suspect = $refer_probable = $refer_confirmed = 0;
                $dis_contact = $dis_suspect = $dis_probable = $dis_confirmed = 0;
                $total = 0;
            }
        }
        return $facilities;
    }

    public function walkinReport(Request $req,$province) {
        if(isset($req->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$req->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$req->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d') . ' 00:00:00';
            $date_end = Carbon::now()->endOfDay()->format('Y-m-d') . ' 23:59:59';
            $req->date_range = $date_start." - ".$date_end;
        }

        $tracking = Tracking::select(
            'faci.name as faci_name',
            'faci.id as faci_id',
            'faci.hospital_type',
            'tracking.code',
            'tracking.walkin',
            'act.status'
        )
            ->leftJoin('activity as act','act.code','=','tracking.code')
            ->leftJoin('facility as faci','faci.id','=','act.referred_to')
            ->where('tracking.walkin','yes')
            ->where('faci.province',$province)
            ->where('tracking.status','!=','cancelled')
            ->whereBetween('tracking.date_referred',[$date_start,$date_end])
            ->orderBy('faci_name','asc')
            ->groupBy('act.code')
            ->get();

        $final = array();
        $walkin = 0;
        $transferred = 0;
        $walkin_total = 0;
        $transferred_total = 0;

        /* count walkin */
        for($i = 0; $i < count($tracking); $i++) {
            $row = $tracking[$i];

            $act = Activity::where('code',$row->code)->where('status','transferred')->first();

            if(!$act)
                $walkin++;
            else if($act && ($act->referred_from == $row->faci_id))
                $transferred++;

            if($row->faci_id !== $tracking[$i+1]->faci_id) {
                array_push($final, [
                    'walkin' => $walkin,
                    'transferred' => $transferred,
                    'faci_id' => $row->faci_id,
                    'faci_name' => $row->faci_name,
                    'hospital_type' => $row->hospital_type
                ]);
                $walkin_total += $walkin;
                $transferred_total += $transferred;
                $walkin = 0;
                $transferred = 0;
            }
        }

        rsort($final);

        return view('admin.report.walkin_report',[
            'title' => 'WALKIN REPORT',
            "data" => $final,
            'date_range_start' => $date_start,
            'date_range_end' => $date_end,
            'province' => $province,
            'province_name' => Province::select('description as name')->where('id',$province)->first()->name,
            'walkin_total' => $walkin_total,
            'transferred_total' => $transferred_total
        ]);
    }

    public function walkinIndividual($facility_id, $status, $date_range){
        $date_range = str_replace('|','/',$date_range);
        $date_start = date('Y-m-d',strtotime(explode(' - ',$date_range)[0])).' 00:00:00';
        $date_end = date('Y-m-d',strtotime(explode(' - ',$date_range)[1])).' 23:59:59';

        $data = Tracking::select(
            'tracking.status',
            'tracking.code',
            'tracking.type',
            'act.referred_from',
            'act.referred_to'
        )
            ->leftJoin('activity as act','act.code','=','tracking.code')
            ->where('tracking.walkin','yes')
            ->where('tracking.status','!=','cancelled')
            ->whereBetween('tracking.date_referred',[$date_start,$date_end]);

        if($status === 'transferred')
            $data = $data->where('act.referred_from',$facility_id)
                ->where('act.status','transferred');
        else
            $data = $data->where('tracking.status','!=','transferred') /*activity is not checked yet whether naa bay transfer or not*/
                ->where('act.referred_to',$facility_id);

        $data = $data->groupBy('act.code')->get();

        $final = array();
        foreach($data as $row) {
            $stat = Activity::where('code',$row->code)->where('status','transferred')->first();
            $get_pt = false;
            if(($status == 'walkin' && !isset($stat)) || ($status == 'transferred' && isset($stat)))
                $get_pt = true;

            if($get_pt) { /*add pt to final*/
                $pt = Patients::select(
                    'patients.fname', 'patients.mname', 'patients.lname',
                    'patients.dob',
                    'brgy.description as brgy',
                    'muncity.description as muncity',
                    'prov.description as prov'
                )
                    ->leftJoin('barangay as brgy','brgy.id','=','patients.brgy')
                    ->leftJoin('muncity','muncity.id','=','patients.muncity')
                    ->leftJoin('province as prov','prov.id','=','patients.province');

                if($row->type == 'normal')
                    $pt = $pt->leftJoin('patient_form as pt_form','pt_form.patient_id','=','patients.id');
                else
                    $pt = $pt->leftJoin('pregnant_form as pt_form','pt_form.patient_woman_id','=','patients.id');

                $pt = $pt->where('pt_form.code', $row->code)->first();

                array_push($final,[
                    'code' => $row->code,
                    'name' => ucfirst($pt->fname)." ".ucfirst($pt->mname)." ".ucfirst($pt->lname),
                    'address' => $pt->brgy.", ".$pt->muncity.", ".$pt->prov,
                    'age' => ParamCtrl::getAge($pt->dob),
                    'referring_facility' => Facility::where('id',$row->referred_from)->first()->name,
                    'referred_facility' => Facility::where('id',$row->referred_to)->first()->name,
                    'status' => $row->status
                ]);
            }
        }

        Session::put('walkin_report_data',$final);
        if($status == 'walkin') {
            Session::put('walkin_report_title','Walk-in Report');
            Session::put('walkin_status','walkin');
        } else {
            Session::put('walkin_report_title','(Walk-in) Transferred Report');
            Session::put('walkin_status','transferred');
        }
        return $final;
    }

    public function exportWalkinReport() {
        $data = Session::get('walkin_report_data');
        $title = Session::get('walkin_report_title');

        $file_name = $title.".xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");
        return view('admin.report.export.walkin',[
            'data' => $data,
            'title' => $title,
            'status' => Session::get('walkin_status')
        ]);
    }

    public function ageBracketFilter2(Request $req) {
        return self::ageBracketFilter($req->desc, $req->date_start, $req->date_end, $req->sex, $req->type, $req->getInfo);
    }

    public function ageBracketFilter($desc, $date_start, $date_end, $sex, $type, $getInfo) {
        $user = Session::get('auth');
        $filter_facility = Session::get('agebracket_facility');
        $filter_province = Session::get('agebracket_province');
        $faci_id = $user->facility_id;
        $description = "";
        $data = Tracking::select(
            'tracking.code',
            DB::raw('CONCAT(patients.fname," ",patients.mname,". ",patients.lname) as patient_name'),
            'patients.dob',
            'tracking.code',
            "pro.description as province",
            "mun.description as muncity",
            "bar.description as barangay",
            'tracking.date_referred',
            'tracking.referred_from',
            'tracking.referred_to',
            'tracking.status',
            'tracking.type',
            'facility.name as facility_referred',
            DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred) as age")
        )
            ->whereBetween('tracking.date_referred',[$date_start, $date_end])
            ->leftJoin('patients','patients.id','=','tracking.patient_id')
            ->leftJoin("province as pro","pro.id","=","patients.province")
            ->leftJoin("muncity as mun","mun.id","=","patients.muncity")
            ->leftJoin("barangay as bar","bar.id","=","patients.brgy")
            ->orderBy('tracking.date_referred', 'desc');


        if($type == "incoming") {
            $data = $data->where('tracking.referred_to',$faci_id)->leftJoin('facility','facility.id','=','tracking.referred_from');
            if(isset($filter_facility))
                $data = $data->where('tracking.referred_from',$filter_facility);
        } else if($type == 'outgoing') {
            $data = $data->where('tracking.referred_from',$faci_id)->leftJoin('facility','facility.id','=','tracking.referred_to');
            if(isset($filter_facility))
                $data = $data->where('tracking.referred_to',$filter_facility);
        }

        if(isset($filter_province))
            $data = $data->where('facility.province',$filter_province);

        if($desc == 'infant') {
            $description = "Infant/Toddler (0-5 years of age)";
            $data = $data->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred)"),'<=', '5');
        }
        else if($desc == 'teen') {
            $description = "Teens (6-17 years of age)";
            $data = $data->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred)"),'<=', '17')
                ->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred)"),'>=', '6');
        }
        else if($desc == 'adult') {
            $description = "Adult (18-59 years of age)";
            $data = $data->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred)"),'<=', '59')
                ->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred)"),'>=', '18');
        }
        else if($desc == 'senior') {
            $description = "Senior (60 years old and above)";
            $data = $data->where(DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, tracking.date_referred)"),'>=', '60');
        }

        if($sex == 'Male' || $sex == 'Female') {
            $data = $data->where('patients.sex',$sex);
            $description .= " [".$sex."]";
        }

        Session::put('agebracket_data', $data->get());
        Session::put('age_category',$description);
        Session::put('agebracket_type',$type);

        if($getInfo) {
            $data = $data->paginate(50);
            $data = self::getDiagnosis($data);

            return view("admin.report.agebracket.agebracket_modal",[
                'data'=> $data,
                'description' => $description,
                'desc' => $desc,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'sex' => $sex,
                'type' => $type
            ]);
        }else {
            $data = $data->get();
        }
        return $data;
    }

    public function getDiagnosis($data) {
        foreach($data as $row) {
            $timestamp = strtotime($row->date_referred);
            $row->date_referred = date('M d, Y',$timestamp);

            $icd = Icd::select('icd10.code', 'icd10.description')
                ->join('icd10', 'icd10.id', '=', 'icd.icd_id')
                ->where('icd.code',$row->code)->get();
            $diagnosis = "";
            if(count($icd) > 0) {
                foreach($icd as $i) {
                    $diagnosis = $i->description . "\n";
                }
            } else {
                if($row->type == 'normal') {
                    $diag = PatientForm::select('diagnosis','other_diagnoses')->where('code', $row->code)->first();
                    $diagnosis = ($diag->other_diagnoses == null) ? $diag->diagnosis : $diag->other_diagnoses;
                }
                else if($row->type == 'pregnant') {
                    $diag = PregnantForm::select('notes_diagnoses','other_diagnoses')->where('code', $row->code)->first();
                    $diagnosis = ($diag->other_diagnoses == null) ? $diag->notes_diagnoses : $diag->other_diagnoses;
                }
            }
            $row->diagnosis = $diagnosis == null ? "" : $diagnosis;
        }
        return $data;
    }

    public function ageBracket(Request $req) {
        /* NOTE:
         *  Filter by age bracket along with their diagnosis and sex.
         *      -> Infant/Toddler (0-5)
         *      -> Teens (6-17)
         *      -> Adult (18-59)
         *      -> Senior (60 - Above)
         */
        if($req->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$req->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$req->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d') . ' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        if($req->request_type == '' || !isset($req->request_type)) {
            $req->request_type = 'incoming';
        }

        Session::put('agebracket_facility', $req->facility);
        Session::put('agebracket_province', $req->province);

        $data = array(
            [
                'description' => "Infant/Toddler (0-5 years old)",
                'type' => "infant",
                'male' => self::ageBracketFilter('infant',$date_start, $date_end, 'Male', $req->request_type, false),
                'female' => self::ageBracketFilter('infant',$date_start, $date_end, 'Female', $req->request_type, false),
            ],
            [
                'description' => "Teen (6-17 years old)",
                'type' => 'teen',
                'male' => self::ageBracketFilter('teen',$date_start, $date_end, 'Male', $req->request_type, false),
                'female' => self::ageBracketFilter('teen',$date_start, $date_end, 'Female', $req->request_type, false)
            ],
            [
                'description' => "Adult (18-59 years old)",
                'type' => 'adult',
                'male' => self::ageBracketFilter('adult',$date_start, $date_end, 'Male', $req->request_type, false),
                'female' => self::ageBracketFilter('adult',$date_start, $date_end, 'Female', $req->request_type, false)
            ],
            [
                'description' => "Senior (60 years old and Above)",
                'type' => 'senior',
                'male' => self::ageBracketFilter('senior',$date_start, $date_end, 'Male', $req->request_type, false),
                'female' => self::ageBracketFilter('senior',$date_start, $date_end, 'Female', $req->request_type, false)
            ]
        );

        return view("admin.report.agebracket.age_bracket",[
            "title" => 'Report by Age Bracket',
            "data" => $data,
            "date_start" => $date_start,
            "date_end" => $date_end,
            "request_type" => $req->request_type,
            "facility" => $req->facility,
            "province" => $req->province
        ]);
    }

    public function exportAgeBracket(){
        $data = Session::get("agebracket_data");
        $data = self::getDiagnosis($data);
        $description = Session::get('age_category');
        $type = Session::get('agebracket_type');
        $file_name = "export_age_bracket".$description.".xls";

        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('admin.excel.export_age_bracket',[
            "data" => $data,
            "description" => $description,
            "type" => $type
        ]);
    }

    public function get_date(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $cebuprovince = Facility::where('province', 2)
        ->where('muncity', '!=', 63)
        ->where('muncity', '!=', 80)
        ->where('muncity', '!=', 76)
        ->with('activities')
        ->get();

        // Call viewDeclined method with parameters
    }

    public function getReferOrDecline($InOutgoing,$category, $pluck, $date_start, $date_end) {
  
        // $data = new Activity();
        // if($category == 'referred') {
        //     $data = $data->whereIn("referred_to", $pluck)
        //         ->where(function($query) {
        //         $query->where("status",'referred')
        //             ->orWhere("status", 'redirected');
        //     });
        // }
        // else if ($category == 'rejected') {
        //     $data = $data->whereIn("referred_to", $pluck)
        //                 ->where(function($query) {
        //                     $query->where("status",'rejected');
        //                 });
        // }
        // else {
        //     return "invalid category";
        // }
        // $data = $data
        //         ->whereBetween("created_at",[$date_start.' 00:00:00',$date_end.' 23:59:59'])
        //         ->count();
        
        // return $data;
        //----------------------------------------------------------//
        if(empty($InOutgoing)){
            return 0;
        }
        $data = new Activity();
        if($category == 'referred') {
            $data = $data->whereIn($InOutgoing, $pluck)
                ->where(function($query) {
                $query->where("status",'referred')
                    ->orWhere("status", 'redirected');
            });
        }
        else if ($category == 'rejected') {
            $data = $data->whereIn($InOutgoing, $pluck)
                        ->where(function($query) {
                            $query->where("status",'rejected');
                        });
        }
        else {
            return "invalid category";
        }
        $data = $data
                ->whereBetween("created_at",[$date_start.' 00:00:00',$date_end.' 23:59:59'])
                ->count();
        
        return $data;
        //-----------------------------------------------------------
    }

    public function referOrDeclineHolder($InOutgoing,$date_start, $date_end) {
        $cebu_province_referred = $this->getReferOrDecline($InOutgoing,"referred", $this->populatePluck('cebu_province'), $date_start, $date_end);
        $cebu_province_rejected = $this->getReferOrDecline($InOutgoing,"rejected", $this->populatePluck('cebu_province'), $date_start, $date_end);

        $cebu_mandaue_referred = $this->getReferOrDecline($InOutgoing,"referred", $this->populatePluck('mandaue_city'), $date_start, $date_end);
        $cebu_mandaue_rejected = $this->getReferOrDecline($InOutgoing,"rejected", $this->populatePluck('mandaue_city'), $date_start, $date_end);

        $cebu_city_referred = $this->getReferOrDecline($InOutgoing,"referred", $this->populatePluck('cebu_city'), $date_start, $date_end);
        $cebu_city_rejected = $this->getReferOrDecline($InOutgoing,"rejected", $this->populatePluck('cebu_city'), $date_start, $date_end);

        $cebu_lapu_referred = $this->getReferOrDecline($InOutgoing,"referred", $this->populatePluck('lapulapu_city'), $date_start, $date_end);
        $cebu_lapu_rejected = $this->getReferOrDecline($InOutgoing,"rejected", $this->populatePluck('lapulapu_city'), $date_start, $date_end);

        return [
            "cebu_province_referred" => $cebu_province_referred,
            "cebu_province_rejected" => $cebu_province_rejected,
            "cebu_province_percent" => number_format(($cebu_province_rejected / $cebu_province_referred) * 100, 2), //code dire jondy

            "cebu_city_referred" => $cebu_city_referred,
            "cebu_city_rejected" => $cebu_city_rejected,
            "cebu_city_percent" =>  number_format(($cebu_city_rejected / $cebu_city_referred) * 100, 2),

            "mandaue_city_referred" => $cebu_mandaue_referred,
            "mandaue_city_rejected" => $cebu_mandaue_rejected,
            "mandaue_city_percent" => number_format(($cebu_mandaue_rejected / $cebu_mandaue_referred) * 100, 2),

            "lapulapu_city_referred" =>  $cebu_lapu_referred,
            "lapulapu_city_rejected" =>  $cebu_lapu_rejected,
            "lapulapu_city_percent" => number_format(($cebu_lapu_rejected / $cebu_lapu_referred) * 100, 2),
        ];
    }

    public function populatePluck($city) {
        $pluck = Facility::select("id")->where('province', 2);
        if($city == 'cebu_province') {
            $pluck = $pluck
            ->where('muncity', '!=', 63)
            ->where('muncity', '!=', 80)
            ->where('muncity', '!=', 76);
        }
        else if($city == 'cebu_city') {
            $pluck = $pluck->where('muncity', '=', 63);
        }
        else if($city == 'mandaue_city') {
            $pluck = $pluck->where('muncity', '=', 80);
        }
        else if($city == 'lapulapu_city') {
            $pluck = $pluck->where('muncity', '=', 76);
        }
        else {
            return "invalid city";
        }

        $pluck = $pluck->get();

        return $pluck;
    }

    public function viewDeclined(Request $request)
    {
        // if($request->start_date) {

        // }
        // $startDate = $req->input('start_date');
        // $endDate = $req->input('end_date');
  
        // // Initialize variables to avoid undefined variable errors
        // $cebuprovince = [];
        // $cebucity = [];
        // $mandauecity = [];
        // $lapulapucity = [];
        $InOutgoing = $request->inoutgoing;
        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0]));
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1]));
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d');
            $date_end = Carbon::now()->endOfDay()->format('Y-m-d');
        }

        $date_range = date('m/d/Y', strtotime($date_start)).' - '.date('m/d/Y', strtotime($date_end));

        $cebuprovince = Facility::select("id")->where('province', 2)
            ->where('muncity', '!=', 63)
            ->where('muncity', '!=', 80)
            ->where('muncity', '!=', 76)
            //->with('activities')
            ->get();

        $data = $this->referOrDeclineHolder($InOutgoing,$date_start, $date_end);

        $cebucity = Facility::where('province', 2)
            ->where('muncity', '=', 63)
            ->with('activities')
            ->get();

        $mandauecity = Facility::where('province', 2)
            ->where('muncity', '=', 80)
            ->with('activities')
            ->get();

        $lapulapucity = Facility::where('province', 2)
            ->where('muncity', '=', 76)
            ->with('activities')
            ->get();
  
        // Pass data to the view
        return view('admin.report.declined_referral', [
            'cebuprovince' => $cebuprovince,
            'cebucity' => $cebucity,
            'mandauecity' => $mandauecity,
            'lapulapucity' => $lapulapucity,
            'startDate' => $startDate,
            'endDate' => $endDate, // Make sure to include endDate in the view data
            'data' => $data,
            'date_range' => $date_range
        ]);
    }

    public function PinakaDakoRerferVecenteSottoOutgoing(){
        $latestActivity = DB::table('activity')
        ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as outgoing'))
        ->where('referred_from', 24)
        ->whereIn('status', ['referred', 'redirected', 'transferred'])
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('outgoing', 'desc')
        ->limit(1)
        ->first();

        return response()->json($latestActivity);
    }

    public function PinakaDakoRerferVecenteSottoIncoming(){
        $latestActivity = DB::table('activity')
        ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as incoming'))
        ->where('referred_to', 24)
        ->whereIn('status', ['referred', 'redirected', 'transferred'])
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('incoming', 'desc')
        ->limit(1)
        ->first();

        return response()->json($latestActivity);
    }
}
