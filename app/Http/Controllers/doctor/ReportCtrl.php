<?php

namespace App\Http\Controllers\doctor;

use App\Activity;
use App\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ReportCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctor');
    }

    public function filterIncoming(Request $req)
    {
        Session::put('report_incoming_date',$req->date);
        Session::put('report_incoming_facility',$req->facility);
        Session::put('report_incoming_department',$req->department);
        return redirect()->back();
    }

    public function incoming()
    {
        $user = Session::get('auth');
        $start = Carbon::now()->startOfMonth()->format('m/d/y');
        $end = Carbon::now()->endOfMonth()->format('m/d/y');
        $date = Session::get('report_incoming_date');
        $facility = Session::get('report_incoming_facility');
        $department = Session::get('report_incoming_department');

        if($date)
        {
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }

        $start_date = Carbon::parse($start)->startOfDay();
        $end_date = Carbon::parse($end)->endOfDay();

        $data = Tracking::whereBetween('tracking.date_referred',[$start_date,$end_date])
            ->where('tracking.referred_to',$user->facility_id)
            ->leftJoin('facility','facility.id','=','tracking.referred_from')
            ->select('tracking.*','facility.name as facility');

        if($facility)
        {
            $data = $data->where('tracking.referred_from',$facility);
        }

        if($department)
        {
            $data = $data->where('tracking.department_id',$department);
        }

        $data = $data->orderBy('tracking.id','desc')
            ->paginate(20);

        return view('doctor.report.incoming',[
            'title' => 'Incoming Referral Report',
            'data' => $data,
            'start' => $start,
            'end' => $end
        ]);
    }

    static function checkStatus($date_referred,$status,$code)
    {
        $user = Session::get('auth');
        $act = Activity::where('code',$code)
                    ->where('referred_from',$user->facility_id)
                    ->where('status',$status)
                    ->orderBy('id','desc')
                    ->first();

        if($act && $act->date_referred > $date_referred)
            return $act->date_referred;

        return false;
    }

    public function filterOutgoing(Request $req)
    {
        Session::put('report_outgoing_date',$req->date);
        Session::put('report_outgoing_facility',$req->facility);
        Session::put('report_outgoing_department',$req->department);
        return redirect()->back();
    }

    public function outgoing()
    {
        $user = Session::get('auth');
        $start = Carbon::now()->startOfMonth()->format('m/d/y');
        $end = Carbon::now()->endOfMonth()->format('m/d/y');
        $date = Session::get('report_outgoing_date');
        $facility = Session::get('report_outgoing_facility');
        $department = Session::get('report_outgoing_department');

        if($date)
        {
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }

        $start_date = Carbon::parse($start)->startOfDay();
        $end_date = Carbon::parse($end)->endOfDay();

        $data = Tracking::select('code','date_referred','date_seen')
            ->where('referred_from',$user->facility_id)
            ->whereBetween('date_referred',[$start_date,$end_date]);

        if($facility){
            $data = $data->where('referred_to',$facility);
        }
        if($department)
        {
            $data = $data->where('tracking.department_id',$department);
        }
        $data = $data->orderBy('id','desc')
            ->paginate(20);

        return view('doctor.report.outgoing',[
            'title' => 'Outgoing Referral Report',
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
}
