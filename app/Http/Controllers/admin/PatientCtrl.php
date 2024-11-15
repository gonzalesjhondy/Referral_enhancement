<?php

namespace App\Http\Controllers\admin;

use App\Activity;
use App\Barangay;
use App\Facility;
use App\Login;
use App\Province;
use App\Seen;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PatientCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function incomingDateRange(Request $request)
    {
        $date_from = date("Y-m-d",strtotime(explode('-', $request->date_range)[0]));
        $date_end = explode('-', $request->date_range)[1];

        return \DB::connection('mysql')->select("call mergeTable($date_from,$date_end)");

    }

    public function incoming()
    {
        $incomingData = \DB::connection('mysql')->select("call incomingMonitorPatient()");
        return view('admin.report.incoming',
            [
                'title' => 'Incoming Patients',
                'data' => $incomingData
            ]);
    }

    public function outgoing()
    {
        $outgoingData = \DB::connection('mysql')->select("call incomingMonitorPatient()");
        return view('admin.report.outgoing',
        [
            'title' => 'Outgoing Patients',
            'data' => $outgoingData
        ]);
    }

    public function consolidatedIncoming()
    {
        $incomingData = \DB::connection('mysql')->select("call consolidatedIncoming()");
        return view('admin.report.consolidated_incoming',
            [
                'title' => 'INCOMING REFERRAL CONSOLIDATION TABLE  (Within Province Wide Health System)',
                'data' => $incomingData
            ]);
    }

    public function consolidatedOutgoing()
    {
        $outgoingData = \DB::connection('mysql')->select("call incomingMonitorPatient()");
        return view('admin.report.consolidated_outgoing',
            [
                'title' => 'Outgoing Patients',
                'data' => $outgoingData
            ]);
    }

    public function consolidatedIncomingv2(Request $request)
    {
        if($request->isMethod('post') && isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $facility_id = Session::get("auth")->facility_id;
        //Session::get("auth")->level == "mcc" ? $stored_name = "consolidatedIncomingMcc('$date_start','$date_end','$facility_id')" : $stored_name = "consolidatedIncoming('$date_start','$date_end')";
        $stored_name = "consolidatedIncomingMcc('$date_start','$date_end','$facility_id')";
        $incomingData = \DB::connection('mysql')->select("call $stored_name");

        Session::put('data',$incomingData);
        return view('admin.report.consolidated_incomingv2',
        [
            'title' => 'REFERRAL CONSOLIDATION TABLE (Within Province Wide Health System)',
            'data' => $incomingData,
            'date_range_start' => $date_start,
            'date_range_end' => $date_end
        ]);
    }

    public function NoAction($facility_id,$date_start,$date_end,$type){

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
            ->where('tracking.'.$type,"=",$facility_id)
            ->whereBetween('tracking.date_referred',[$date_start,$date_end])
            ->where(function($q){
                $q->where('tracking.status','referred')
                    ->orwhere('tracking.status','cancelled')
                    ->orwhere('tracking.status','rejected')
                    ->orwhere('tracking.status','seen')
                    ->orwhere('tracking.status','archived');
            })
            ->orderBy('tracking.date_referred','desc')
            ->paginate(10);

        return view("admin.report.no_action_view",[
            'title' => 'Viewed Only',
            'data' => $data,
        ]);
    }

}