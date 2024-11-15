<?php

namespace App\Http\Controllers\admin;

use App\Activity;
use App\Facility;
use App\Login;
use App\Seen;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DailyCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function users()
    {
        $facilities = Facility::where('status',1)
            ->orderBy('name','asc')
            ->get();

        return view('admin.report.users',[
            'title' => 'Daily Users',
            'data' => array(),
            'facilities' => $facilities
        ]);
    }

    public function usersFilter(Request $req)
    {
        Session::put('dateDailyUsers',$req->date);
        return self::users();
    }

    static function countDailyUsers($id)
    {
        return array(
            'on' => self::countLogin($id,'login','doctor'),
            'off' => self::countLogin($id,'login_off','doctor'),
            'total' => self::countTotal($id,'doctor'),
            'it_on' => self::countLogin($id,'login','support'),
            'it_total' => self::countTotal($id,'support')
        );
    }

    static function countLogin($id,$status,$level)
    {
        $date = Session::get('dateDailyUsers');
        if(!$date){
            $date = date('Y-m-d');
        }

        $start = Carbon::parse($date)->startOfDay();
        $end = Carbon::parse($date)->endOfDay();

        $data = Login::join('users','users.id','=','login.userId') //TODO: possible changes for multiple facility log-in
            ->where('users.facility_id',$id)
            ->whereBetween('login.login',[$start,$end])
            ->groupBy('login.userId')
            ->where('users.level',$level)
            ->where('login.status',$status)
            ->get();
        return count($data);
    }

    static function countTotal($id,$level){
        return User::where('facility_id',$id) //TODO: possible changes for multiple facility log-in
            ->where('level',$level)
            ->count();
    }

    public function referral()
    {
        $data = Facility::where('status',1)
            ->orderBy('name','asc')
            ->paginate(20);

        return view('admin.report.referral',[
            'title' => 'Daily Referral',
            'data' => $data
        ]);
    }

    public function incoming()
    {
        $data = Facility::where('status',1)
            ->orderBy('name','asc')
            ->paginate(20);

        return view('admin.report.incoming',
            [
                'title' => 'Daily Referral',
                'data' => $data
            ]);
    }

    public function outgoing()
    {
        $data = Facility::where('status',1)
            ->orderBy('name','asc')
            ->paginate(20);

        return view('admin.report.outgoing',
            [
                'title' => 'Daily Referral',
                'data' => $data
            ]);
    }

    public function referralFilter(Request $req)
    {
        $range = explode('-',str_replace(' ', '', $req->date));
        $tmp1 = explode('/',$range[0]);
        $tmp2 = explode('/',$range[1]);

        $start = $tmp1[2].'-'.$tmp1[0].'-'.$tmp1[1];
        $end = $tmp2[2].'-'.$tmp2[0].'-'.$tmp2[1];

        Session::put('startDateDailyReferral',$start);
        Session::put('endDateDailyReferral',$end);
        return self::referral();
    }

    static function countOutgoingReferral($id)
    {
        $start = Session::get('startDateDailyReferral');
        $end = Session::get('endDateDailyReferral');
        if(!$start)
            $start = date('Y-m-d');
        if(!$end)
            $end = date('Y-m-d');

        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();


        $accepted = Activity::where('referred_to',$id)
            ->whereBetween('date_referred',[$start,$end])
            ->where('status','accepted')
            ->count();

        $redirected = Tracking::join('activity','activity.code','=','tracking.code')
            ->where('tracking.referred_to',$id)
            ->where('activity.status','rejected')
            ->whereBetween('tracking.date_referred',[$start,$end])
            ->count();

        $seen = Seen::select('tracking_id',DB::raw('count(*) as total'))
            ->join('tracking','tracking.id','=','seen.tracking_id')
            ->where('tracking.referred_to',$id)
            ->whereBetween('tracking.date_referred',[$start,$end])
            ->groupBy('tracking_id')
            ->get();

        $total = Tracking::where('tracking.referred_to',$id)
            ->whereBetween('tracking.date_referred',[$start,$end])
            ->count();

        $cseen = (count($seen)- ($accepted+$redirected));
        if($cseen < 0)
            $cseen = 0;

        $unseen = $total - count($seen);

        return array(
            'accepted' => $accepted,
            'redirected' => $redirected,
            'seen' => $cseen,
            'unseen' => $unseen,
            'total' => $total
        );
    }

    static function countIncommingReferral($id)
    {
        $start = Session::get('startDateDailyReferral');
        $end = Session::get('endDateDailyReferral');
        if(!$start)
            $start = date('Y-m-d');
        if(!$end)
            $end = date('Y-m-d');

        $start = Carbon::parse($start)->startOfDay();
        $end = Carbon::parse($end)->endOfDay();

        $accepted = Activity::where('referred_from',$id)
            ->whereBetween('date_referred',[$start,$end])
            ->where('status','accepted')
            ->count();

        $redirected = Activity::where('referred_from',$id)
            ->whereBetween('date_referred',[$start,$end])
            ->where('status','rejected')
            ->count();

        $seen = Seen::select('tracking_id',DB::raw('count(*) as total'))
            ->join('tracking','tracking.id','=','seen.tracking_id')
            ->where('tracking.referred_from',$id)
            ->whereBetween('tracking.date_referred',[$start,$end])
            ->groupBy('tracking_id')
            ->get();

        $cseen = (count($seen)- ($accepted+$redirected));
        if($cseen<0){
            $cseen = 0;
        }
        $total = $cseen + $accepted + $redirected;


        return array(
            'accepted' => $accepted,
            'redirected' => $redirected,
            'seen' => $cseen,
            'total' => $total
        );
    }
}
