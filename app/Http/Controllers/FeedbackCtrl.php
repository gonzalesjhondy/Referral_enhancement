<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Feedback;
use App\RecoSeen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeedbackCtrl extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function home() {
        return view('feedback.feedback');
    }

    public function CommentAppend(Request $request) {
        $textarea_body = view('feedback.textarea_body');
        $comment_append = view('feedback.comment_append',[
            "comment" => $request->comment
        ]);
        $view = $textarea_body.'explode|ruseltayong|explode'.$comment_append;
        return $view;
    }

    public function recoView() {
        return view('reco.reco');
    }

    public function recoFetch() {
        $user = Session::get('auth');
        $start = date('m/d/Y',strtotime(Carbon::now()->subDays(7)));
        $end = Carbon::now()->endOfDay()->format('m/d/Y');

        $data = Activity::select(
            'feedback.message',
            'feedback.code',
            'feedback.id as reco_id',
            'feedback.sender as userid_sender',
            'reco_seen.id as reco_seen',
            \DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            \DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
            \DB::raw('COALESCE(CONCAT(users.fname," ",users.mname," ",users.lname),"WALK IN") as referring_md'),
            'patients.sex',
            'patients.id as patient_id',
            'patients.contact',
            'users.level as user_level'
        )
            ->leftJoin('patients','patients.id','=','activity.patient_id')
            ->leftJoin('tracking','tracking.code','=','activity.code')
            ->join("feedback","feedback.code","=","activity.code")
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('feedback as fac2',function($join){
                $join->on("feedback.code","=","fac2.code");
                $join->on("feedback.id","<","fac2.id");
            })
            ->leftJoin('reco_seen',function($join) use ($user) {
                $join->on('reco_seen.reco_id','=','feedback.id')
                    ->where('reco_seen.seen_userid','=',$user->id);
            })
            ->whereNull("fac2.id")
            ->where(function($query) use ($user) {
                $query->where("activity.referred_from",$user->facility_id)
                        ->orWhere("activity.referred_to",$user->facility_id);
            });

        $start_date = Carbon::parse($start)->startOfDay();
        $end_date = Carbon::parse($end)->endOfDay();

        $data = $data->whereBetween('feedback.created_at',[$start_date,$end_date])
            ->where(function($q){
                $q->where('activity.status','referred')
                    ->orwhere('activity.status','redirected')
                    ->orwhere('activity.status','transferred');
            })
            ->groupBy("activity.code")
            ->orderBy("feedback.created_at","desc")
            ->get();

        return $data;
    }

    public static function recoCount() {
        $user = Session::get('auth');
        $start = date('m/d/Y',strtotime(Carbon::now()->subDays(7)));;
        $end = Carbon::now()->endOfDay()->format('m/d/Y');

        $start_date = Carbon::parse($start)->startOfDay();
        $end_date = Carbon::parse($end)->endOfDay();

        $data = Activity::leftJoin('patients','patients.id','=','activity.patient_id')
            ->leftJoin('tracking','tracking.code','=','activity.code')
            ->join("feedback","feedback.code","=","activity.code")
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('feedback as fac2',function($join){
                $join->on("feedback.code","=","fac2.code");
                $join->on("feedback.id","<","fac2.id");
            })
            ->leftJoin('reco_seen',function($join) use ($user) {
                $join->on('reco_seen.reco_id','=','feedback.id')
                    ->where('reco_seen.seen_userid','=',$user->id);
            })
            ->whereNull("fac2.id")
            ->whereNull("reco_seen.id")
            ->where('feedback.sender','!=',$user->id)
            ->where(function($query) use ($user) {
                $query->where("activity.referred_from",$user->facility_id)
                    ->orWhere("activity.referred_to",$user->facility_id);
            })->whereBetween('feedback.created_at',[$start_date,$end_date])
            ->where(function($q){
                $q->where('activity.status','referred')
                    ->orwhere('activity.status','redirected')
                    ->orwhere('activity.status','transferred');
            })
            ->groupBy("activity.code")
            ->orderBy("feedback.created_at","desc")
            ->get();

        return count($data);
    }

    public function recoNew($code) {
        $user = Session::get('auth');

        $data = Activity::select(
            'feedback.message',
            'feedback.code',
            'feedback.id as reco_id',
            'feedback.sender as userid_sender',
            'reco_seen.id as reco_seen',
            \DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            \DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
            \DB::raw('COALESCE(CONCAT(users.fname," ",users.mname," ",users.lname),"WALK IN") as referring_md'),
            'patients.sex',
            'patients.id as patient_id',
            'patients.contact',
            'users.level as user_level'
        )
            ->leftJoin('patients','patients.id','=','activity.patient_id')
            ->leftJoin('tracking','tracking.code','=','activity.code')
            ->join("feedback","feedback.code","=","activity.code")
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('reco_seen',function($join) use ($user) {
                $join->on('reco_seen.reco_id','=','feedback.id')
                    ->where('reco_seen.seen_userid','=',$user->id);
            })
            ->where(function($query) use ($user) {
                $query->where("activity.referred_from",$user->facility_id)
                    ->orWhere("activity.referred_to",$user->facility_id);
            })
            ->where(function($q){
            $q->where('activity.status','referred')
                ->orwhere('activity.status','redirected')
                ->orwhere('activity.status','transferred');
            })
            ->where('activity.code',$code)
            ->groupBy("activity.code")
            ->first();

        return $data;
    }

    public function recoSelect($code) {
        $user = Session::get('auth');
        $userid = $user->id;
        $facility_id = $user->facility_id;
        $chat_image = asset("resources/img");
        $data = Activity::select( //TODO: possible changes for multiple facility log-in
            'feedback.id',
            'feedback.message',
            \DB::raw("DATE_FORMAT(feedback.created_at, '%d %b %l:%i %p') as send_date"),
            \DB::raw("if(users.id = $userid, 'right','left') as position"),
            \DB::raw("if(users.facility_id = $facility_id, '".$chat_image.'/receiver.png'."','".$chat_image.'/sender.png'."') as chat_image"),
            \DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            \DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
            'patients.sex',
            'patients.id as patient_id',
            'patients.contact',
            'facility.name as facility_name',
            \DB::raw('CONCAT(
                if(users.level="doctor","Dr. ",""),
            users.fname," ",users.mname," ",users.lname) as sender_name')
        )
            ->leftJoin('patients','patients.id','=','activity.patient_id')
            ->leftJoin('tracking','tracking.code','=','activity.code')
            ->leftJoin("feedback","feedback.code","=","activity.code")
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id')
            ->where("activity.code",$code)
            ->groupBy("feedback.id")
            ->get();

        return $data;
    }

    public function recoSeen(Request $request) {
        $reco_seen = new RecoSeen();
        $reco_seen->reco_id = $request->reco_id;
        $reco_seen->seen_userid = $request->seen_userid;
        $reco_seen->seen_facility_id = $request->seen_facility_id;
        $reco_seen->code = $request->code;
        $reco_seen->save();
    }

    public function recoSeen1($code) {
        $user = Session::get('auth');
        $reco_id = Feedback::where("code",$code)->orderBy("id","desc")->first()->id;
        $reco_seen = new RecoSeen();
        $reco_seen->reco_id = $reco_id;
        $reco_seen->seen_userid = $user->id;
        $reco_seen->seen_facility_id = $user->facility_id;
        $reco_seen->code = $code;
        $reco_seen->save();
    }

}
