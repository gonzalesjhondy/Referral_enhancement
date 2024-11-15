<?php

namespace App\Http\Controllers\doctor;

use App\Activity;
use App\Department;
use App\Facility;
use App\Http\Controllers\admin\UserCtrl;
use App\Http\Controllers\ParamCtrl;
use App\Login;
use App\Patients;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Events\NewReferral;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('doctor');
    }

    //==================================================================
    public function countIncomingPatients()
    {
        // Replicating the logic from ReferralCtrl@index to count the referred patients
        $currentYear = now()->year;

        // // Assuming 'status' is the column that identifies referred patients
        // $incomingPatientsCount = Referral::where('status', 'referred')
        //                                  ->whereYear('created_at', $currentYear)
        //                                  ->count();

        // // Return the count as JSON response
        // return response()->json(['count' => $incomingPatientsCount]);

        // SQL query equivalent: grouping by date, filtering by 'referred_to' and specific statuses
        $incomingPatientsCount = DB::table('activity')
                            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as incoming'))
                            ->where('referred_to')  // Filtering based on referred_to
                            ->whereIn('status', ['referred', 'redirected', 'transferred'])  // Filtering based on statuses
                            ->whereYear('created_at', $currentYear)  // Filter based on the current year
                            ->groupBy(DB::raw('DATE(created_at)'))  // Grouping by date
                            ->orderBy('incoming', 'desc')  // Sorting to get the highest count
                            ->limit(1)  // Limiting the result to the top entry
                            ->first();  // Retrieving the first result

        // Return the result as JSON
        return response()->json($incomingPatientsCount);
    }
    //==================================================================

    public function index()
    {
        ParamCtrl::lastLogin();

        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        $user = Session::get("auth");
        $group_by_department = $user->level == 'admin' ?  //TODO: possible changes for multiple facility log-in
            Login::
            select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
                ->leftJoin("users","users.id","=","login.userId")
                ->leftJoin("department","department.id","=","users.department_id")
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->where("users.level","doctor")
                ->groupBy("users.department_id")
                ->get()
        :
            Login::
            select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
                ->leftJoin("users","users.id","=","login.userId")
                ->leftJoin("department","department.id","=","users.department_id")
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->where("users.facility_id",$user->facility_id)
                ->where("users.level","doctor")
                ->groupBy("users.department_id")
                ->get()
        ;

        $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
        $date_end = Carbon::now()->endOfYear()->format('Y-m-d').' 23:59:59';

        $incoming_statistics = \DB::connection('mysql')->select("call statistics_report_facility('$date_start','$date_end','$user->facility_id','$user->level')")[0];
        //return json_encode($incoming_statistics);

        $referred_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','referred','$user->level')");
        $accepted_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','accepted','$user->level')");
        $redirected_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','redirected','$user->level')");


        //for past 15 days
        $date_start_past = date('Y-m-d',strtotime(Carbon::now()->subDays(15))).' 00:00:00';
        $date_end_past = date('Y-m-d',strtotime(Carbon::now()->subDays(1))).' 23:59:59';
        $referred_past = DB::connection('mysql')->select("call doctor_past_transaction('$date_start_past','$date_end_past','$user->facility_id','referred','$user->level')");
        $accepted_past = DB::connection('mysql')->select("call doctor_past_transaction('$date_start_past','$date_end_past','$user->facility_id','accepted','$user->level')");
        $redirected_past = DB::connection('mysql')->select("call doctor_past_transaction('$date_start_past','$date_end_past','$user->facility_id','redirected','$user->level')");

        $index = 0;
        foreach($referred_query as $row){
            $data['referred'][] = $row->value;
            $data['accepted'][] = $accepted_query[$index]->value;
            $data['redirected'][] = $redirected_query[$index]->value;
            $index++;
        }

        return view('doctor.home',[
            "group_by_department" => $group_by_department,
            "doctor_monthly_report" => $data,
            "referred_past" => $referred_past,
            "accepted_past" => $accepted_past,
            "redirected_past" => $redirected_past,
            "incoming_statistics" => $incoming_statistics,
            "date_start" => $date_start,
            "date_end" => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function index1()
    {
        $date_start = Carbon::now()->startOfYear();
        $formatted_date_start = $date_start->format('F d, Y');
        $formatted_date_end = Carbon::now()->format('F d, Y');
        $year = $date_start->year;

        $totalDataIncoming = Session::get('totalIncoming_for_Dashboard');
        $totalDataReferred = Session::get('totalReffered_for_Dashboard');

        session()->forget('profileSearch.telemedicine');
        session()->forget('telemed');
        
        return view('doctor.home1',[
            "totalIncoming" => $totalDataIncoming,
            "totalReferred" => $totalDataReferred,
            "date_start" => $formatted_date_start,
            "date_end" => $formatted_date_end,
            "year" => $year,
        ]);
    }

    public function doctorMonthlyReport() {
        $user = Session::get("auth");
        $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
        $date_end = Carbon::now()->endOfYear()->format('Y-m-d').' 23:59:59';

        $referred_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','referred','$user->level')");
        $accepted_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','accepted','$user->level')");
        $redirected_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','redirected','$user->level')");

        $index = 0;
        $data = [];
        foreach($referred_query as $row){
            $data['referred'][] = $row->value;
            $data['accepted'][] = $accepted_query[$index]->value;
            $data['redirected'][] = $redirected_query[$index]->value;
            $index++;
        }

        return $data;
    }

    public function optionPerDepartment() {
        $user = Session::get("auth");
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        $group_by_department = $user->level == 'admin' ? //TODO: possible changes for multiple facility log-in
            Login::
            select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
                ->leftJoin("users","users.id","=","login.userId")
                ->leftJoin("department","department.id","=","users.department_id")
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->where("users.level","doctor")
                ->groupBy("users.department_id")
                ->get()
            :
            Login::
            select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
                ->leftJoin("users","users.id","=","login.userId")
                ->leftJoin("department","department.id","=","users.department_id")
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->where("users.facility_id",$user->facility_id)
                ->where("users.level","doctor")
                ->groupBy("users.department_id")
                ->get()
        ;

        return $group_by_department;
    }

    public function optionPerActivity() {
        $user = Session::get("auth");
        $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
        $date_end = Carbon::now()->endOfYear()->format('Y-m-d').' 23:59:59';

        $incoming_statistics = \DB::connection('mysql')->select("call statistics_report_facility('$date_start','$date_end','$user->facility_id','$user->level')")[0];

        return json_encode($incoming_statistics);
    }

    public function optionLastTransaction() {
        $user = Session::get("auth");
        //for past 15 days
        $date_start_past = date('Y-m-d',strtotime(Carbon::now()->subDays(15))).' 00:00:00';
        $date_end_past = date('Y-m-d',strtotime(Carbon::now()->subDays(1))).' 23:59:59';
        $referred_past = DB::connection('mysql')->select("call doctor_past_transaction('$date_start_past','$date_end_past','$user->facility_id','referred','$user->level')");
        $accepted_past = DB::connection('mysql')->select("call doctor_past_transaction('$date_start_past','$date_end_past','$user->facility_id','accepted','$user->level')");
        $redirected_past = DB::connection('mysql')->select("call doctor_past_transaction('$date_start_past','$date_end_past','$user->facility_id','redirected','$user->level')");

        return [
            "referred_past" => $referred_past,
            "accepted_past" => $accepted_past,
            "redirected_past" => $redirected_past
        ];
    }

    public function viewMap(){
        $facility = Facility::whereNotNull("latitude")->get();
        return view('map',[
            "facility" => $facility
        ]);
    }

    public function getTransactions($type) {
        $user = Session::get("auth");
//        $user = User::where('id','1016')->first();
        $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
        $date_end = Carbon::now()->endOfYear()->format('Y-m-d').' 23:59:59';
        $desc = "";
        $data = Activity::select(
            'tracking.code',
            DB::raw('CONCAT(patients.fname," ",patients.mname,". ",patients.lname) as patient_name'),
            'pro.description as province',
            'mun.description as muncity',
            'bar.description as barangay',
            'tracking.date_referred',
            'tracking.type',
            'facility.name as referring_facility'
        )
            ->leftJoin('tracking','tracking.code','=','activity.code')
            ->leftJoin('patients','patients.id','=','activity.patient_id')
            ->leftJoin("province as pro","pro.id","=","patients.province")
            ->leftJoin("muncity as mun","mun.id","=","patients.muncity")
            ->leftJoin("barangay as bar","bar.id","=","patients.brgy")
            ->leftJoin('facility','facility.id','=','activity.referred_from')
            ->whereBetween('activity.created_at',[$date_start, $date_end])
            ->where('activity.referred_to',$user->facility_id)
            ->orderBy('tracking.date_referred','desc');

        if($type == 'incoming_total') {
            $desc = "Total Incoming";
            $data = $data->where(function($query) {
                $query->where('activity.status', 'referred')
                    ->orWhere('activity.status', 'redirected')
                    ->orWhere('activity.status', 'transferred');
                })
                ->where('tracking.walkin','no')
                ->groupBy('activity.code');
        }
        else if($type == 'accepted') {
            $desc = "Accepted Patients";
            $data = $data->where('activity.status','accepted')
                    ->where('tracking.walkin','no');
        }
        else if($type == 'seen_only') {
            $desc = "Seen Only";
            /*
             * TODO:
             *      try ->whereNull(DB::raw())
             * */

//            $data = $data->where(function($query) {
//                    $query->where('activity.status','referred')
//                        ->orWhere('activity.status','redirected')
//                        ->orWhere('activity.status','transferred');
//                })
//                ->leftJoin('seen', function($join) {
//                    $join->on('seen.code','=','activity.code')
//                        ->on('seen.created_at','>=','activity.created_at')
//                        ->on('seen.facility_id','=','activity.referred_to');
//                })
//                ->where('seen.code','!=',null)
//                ->leftJoin('activity as act2', function($join) {
//                    $join->on('act2.code','=','activity.code')
//                        ->on('act2.referred_from','=','activity.referred_from')
//                        ->on('act2.referred_to','=','activity.referred_to');
//                })
//                ->where(function($query) {
//                    $query->where('act2.status','!=','accepted')
//                        ->orWhere('act2.status','!=','admitted')
//                        ->orWhere('act2.status','!=','archived')
//                        ->orWhere('act2.status','!=','arrived')
//                        ->orWhere('act2.status','!=','calling')
//                        ->orWhere('act2.status','!=','called')
//                        ->orWhere('act2.status','!=','cancelled')
//                        ->orWhere('act2.status','!=','discharged')
//                        ->orWhere('act2.status','!=','form_updated')
//                        ->orWhere('act2.status','!=','queued')
//                        ->orWhere('act2.status','!=','rejected')
//                        ->orWhere('act2.status','!=','travel');
//                })
////                ->whereNotExists(function($query) {
////                    $query->select(DB::raw(1))
////                        ->from('activity as act2')
////                        ->where('act2.status','=','accepted')
////                        ->where('act2.referred_from','=','activity.referred_from')
////                        ->where('act2.date_referred','>=','activity.created_at');
////                })
////                ->whereNotExists(function($query) {
////                    $query->select(DB::raw(1))
////                        ->from('activity as act3')
////                        ->where('act3.code','=','activity.code')
////                        ->where('act3.status','=','rejected')
////                        ->where('act3.referred_from','='.'activity.referred_from')
////                        ->where('act3.referred_to','=','activity.referred_to')
////                        ->where('act3.id','>','activity.id')
////                        ->where('act3.created_at','>=','activity.created_at');
////                })
//                ->groupBy('activity.code');
        }
        else if($type == 'not_seen') {
            $desc = "No Action";
            $data = $data->leftJoin('seen', function($join) {
                    $join->on('seen.code','=','activity.code')
                        ->on('seen.created_at','>=','activity.created_at')
                        ->on('seen.facility_id','=','activity.referred_to');
                })
                ->where('seen.code',null)
                ->where(function($query) {
                    $query->where('activity.status', 'referred')
                        ->orWhere('activity.status', 'redirected')
                        ->orWhere('activity.status', 'transferred');
                })
                ->where('tracking.walkin','no');
        }

        Session::put('dashboard_data',$data->get());
        $data = $data->paginate(50);

        return view('modal.dashboard_modal',[
            'data' => $data,
            'desc' => $desc,
            'type' => $type,
            'date_start' => $date_start,
            'date_end' => $date_end
        ]);
    }

    public function selectAccount(){
        $user = Session::get("auth");
        $affiliated = UserCtrl::getUserFacilities($user->id);
        return view('doctor.select_account', [
            'user' => $user,
            'affiliated' => $affiliated
        ]);
    }

    
}
