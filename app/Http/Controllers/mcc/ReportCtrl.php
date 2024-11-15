<?php

namespace App\Http\Controllers\mcc;

use App\Activity;
use App\Facility;
use App\Seen;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('chief');
    }

    public function online()
    {
        $user = Session::get('auth');

        $start = date('m/d/Y');
        $end = date('m/d/Y');

        $date = Session::get('date_online');
        if($date){
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }

        $data = User::select('department.description',
                    'department.id'
                )
                ->leftJoin('department','department.id','=','users.department_id')
                ->where('users.facility_id',$user->facility_id) //TODO: possible changes for multiple facility log-in
                ->where('users.level','doctor')
                ->groupBy('users.department_id')
                ->get();
        return view('mcc.online',[
            'title' => 'Online Users per Department',
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function filterOnline(Request $req)
    {
        Session::put('date_online',$req->date);
        return redirect()->back();
    }

    public function incoming()
    {
        $user = Session::get('auth');

        $start = Carbon::now()->startOfMonth()->format('m/d/Y');
        $end = Carbon::now()->endOfMonth()->format('m/d/Y');

        $date = Session::get('date_incoming');
        if($date){
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }

        $data = Facility::orderBy('name','asc')
            ->where('id','!=',$user->facility_id)
            ->where('status',1)
            ->get();

        return view('mcc.incoming',[
            'title' => 'Incoming Referrals',
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function filterIncoming(Request $req)
    {
        Session::put('date_incoming',$req->date);
        return redirect()->back();
    }

    static function countIncoming($status,$facility_id)
    {
        $user = Session::get('auth');
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $date = Session::get('date_incoming');
        if($date){
            $range = explode('-',str_replace(' ', '', $date));
            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();
        }

        if($status=='seen'){
            return self::countIncomingSeen($facility_id,$start,$end,$user);
        }

        $ref = Tracking::where('tracking.referred_to',$user->facility_id)
                    ->where('tracking.referred_from',$facility_id)
                    ->whereBetween('tracking.date_referred',[$start,$end]);

        if($status){
            $ref = $ref->join('activity','activity.code','=','tracking.code')
                        ->where('activity.status',$status)
                        ->distinct('activity.code')
                        ->count('activity.code');
        }else{
            $ref = $ref->count();
        }

        return $ref;
    }

    static function countIncomingSeen($facility_id,$start,$end,$user)
    {
        $ref = Tracking::leftJoin('seen','seen.tracking_id','=','tracking.id')
                    ->where('tracking.referred_to',$user->facility_id)
                    ->where('tracking.referred_from',$facility_id)
                    ->whereBetween('tracking.date_referred',[$start,$end])
                    ->distinct('seen.tracking_id')
                    ->count('tracking_id');
        return $ref;
    }

    static function countLogin($status,$department_id)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        $u = Session::get('auth');
        $date = Session::get('date_online');
        if($date){
            $range = explode('-',str_replace(' ', '', $date));
            $start = Carbon::parse($range[0])->startOfDay();
            $end = Carbon::parse($range[1])->endOfDay();
        }

        $users = User::where("users.level",'doctor')
                    ->where('users.facility_id',$u->facility_id); //TODO: possible changes for multiple facility log-in

        if($department_id){
            $users = $users->where('users.department_id',$department_id);
        }else{
            $users = $users->where('users.department_id','');
        }

        if($status){
            $users = $users->join('login','login.userId','=','users.id')
                        ->where('login.status',$status)
                        ->whereBetween('login.login',[$start,$end])
                        ->distinct('login.userId')
                        ->count('login.userId');
        }else{
            $users = $users->count();
        }

        return $users;


    }

    public function timeframe()
    {
        $user = Session::get('auth');

        $start = Carbon::now()->startOfMonth()->format('m/d/Y');
        $end = Carbon::now()->endOfMonth()->format('m/d/Y');

        $date = Session::get('date_timeframe');
        if($date){
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }

        $start_date = Carbon::parse($start)->startOfDay();
        $end_date = Carbon::parse($end)->endOfDay();

        $data = Tracking::select('code','date_referred','date_seen')
                    ->where('referred_from',$user->facility_id)
                    ->whereBetween('date_referred',[$start_date,$end_date])
                    ->orderBy('id','desc')
                    ->paginate(20);

        return view('mcc.timeframe',[
            'title' => 'Referral Time Frame',
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);
    }

    static function timeDiff($start,$end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        if($start > $end)
            return false;

        $end_date='2015-12-05 11:59:29';
        $start_date='2015-11-01 11:58:14';


        $start_time = strtotime($start);
        $end_time = strtotime($end);
        $difference = $end_time - $start_time;
        $diff = '';

        $seconds = $difference % 60;            //seconds
        $difference = floor($difference / 60);

        if($seconds) $diff = $seconds."s";

        $min = $difference % 60;              // min
        $difference = floor($difference / 60);

        if($min) $diff = $min."m $diff";

        $hours = $difference % 24;  //hours
        $difference = floor($difference / 24);

        if($hours) $diff = $hours."h $diff";

        $days = $difference % 30;  //days
        $difference = floor($difference / 30);

        if($days) $diff = $days."d $diff";

        $month = $difference % 12;  //month
        $difference = floor($difference / 12);

        if($month) $diff = $month."mo $diff";


        return $diff;
    }

    static function getDateAction($status,$code)
    {
        $user = Session::get('auth');
        $ref = Activity::where('code',$code);

        if($status == 'accepted'){
            $ref = $ref->where('referred_from',$user->facility_id);
        }
        $ref = $ref->where('status',$status)
                    ->orderBy('id','desc')
                    ->first();
        if($ref)
            return $ref->date_referred;
        return false;
    }

    public function filterTimeframe(Request $req)
    {
        Session::put('date_timeframe',$req->date);
        return redirect()->back();
    }

    public function searchTrackReferral(Request $req)
    {
        Session::put('referredCode',$req->keyword);
        return redirect('mcc/track');
    }

    public function trackReferral()
    {
        $code = Session::get('referredCode');

        $data = Tracking::select(
            'tracking.*',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
            DB::raw('CONCAT(users.fname," ",users.mname," ",users.lname) as referring_md'),
            'patients.sex',
            'facility.name as facility_name',
            'facility.id as facility_id',
            'patients.id as patient_id'
        )
            ->join('patients','patients.id','=','tracking.patient_id')
            ->join('facility','facility.id','=','tracking.referred_to')
            ->leftJoin('users','users.id','=','tracking.referring_md')
            ->where(function($q){
                $q->where('tracking.status','referred')
                    ->orwhere('tracking.status','seen')
                    ->orwhere('tracking.status','accepted')
                    ->orwhere('tracking.status','arrived')
                    ->orwhere('tracking.status','admitted')
                    ->orwhere('tracking.status','transferred')
                    ->orwhere('tracking.status','discharged')
                    ->orwhere('tracking.status','cancelled')
                    ->orwhere('tracking.status','archived')
                    ->orwhere('tracking.status','rejected');
            })
            ->where('tracking.code',$code)
            ->orderBy('date_referred','desc')
            ->paginate(10);

        return view('mcc.tracking',[
            'title' => 'Track Patients',
            'data' => $data
        ]);
    }

}
