<?php

namespace App\Http\Controllers\doctor;

use App\Activity;
use App\Baby;
use App\Department;
use App\Events\NewReferral;
use App\Events\SocketReco;
use App\Events\SocketReferralAccepted;
use App\Events\SocketReferralAdmitted;
use App\Events\SocketReferralArrived;
use App\Events\SocketReferralCall;
use App\Events\SocketReferralCancelled;
use App\Events\SocketReferralDeparted;
use App\Events\SocketReferralDischarged;
use App\Events\SocketReferralNotArrived;
use App\Events\SocketReferralQueuePatient;
use App\Events\SocketReferralRejected;
use App\Events\SocketReferralSeen;
use App\Events\SocketReferralUndoCancel;
use App\Events\SocketReferralUpdate;
use App\Events\SocketReferralUpdateForm;
use App\Facility;
use App\Feedback;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DeviceTokenCtrl;
use App\Http\Controllers\ParamCtrl;
use App\Icd;
use App\Icd10;
use App\Issue;
use App\ModeTransportation;
use App\Monitoring;
use App\PatientForm;
use App\Patients;
use App\PregnantForm;
use App\Province;
use App\ReasonForReferral;
use App\Seen;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Matrix\Exception;

class ReferralCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('doctor');
    }

    public function index(Request $request)
    {
        ParamCtrl::lastLogin();
        $keyword = '';
        $dept = '';
        $fac = '';
        $option = '';
        $start = Carbon::now()->startOfYear()->format('m/d/Y');
        $end = Carbon::now()->endOfDay()->format('m/d/Y');
        $user = Session::get('auth');
        
        $telemedOrReferral = $request->query('filterRef', null);
       
        $data = Tracking::select(
            'tracking.*',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS patient_age"),
            'patients.sex',
            'facility.name as facility_name',
            DB::raw('CONCAT(
                        if(users.level="doctor","Dr. ",""),
                    users.fname," ",users.mname," ",users.lname) as referring_md'),
            'tracking.action_md as action_md_id',
            DB::raw('CONCAT(action.fname," ",action.mname," ",action.lname) as action_md'),
            DB::raw("(SELECT count(act1.code) from activity act1 where act1.code = tracking.code and (act1.status = 'redirected' or act1.status = 'transferred')) as position")
        )
            ->join('patients','patients.id','=','tracking.patient_id')
            ->join('facility','facility.id','=','tracking.referred_from')
            ->leftJoin('users','users.id','=','tracking.referring_md')
            ->leftJoin('users as action','action.id','=','tracking.action_md')
            ->where('referred_to',$user->facility_id);
           
        if ($telemedOrReferral !== null) {
            $data = $data->where('tracking.telemedicine', $telemedOrReferral);
        }

        if($request->search)
        {
            $keyword = $request->search;
            $data = $data->where(function($q) use ($keyword){
                $q->where('patients.lname',"$keyword")
                    ->orwhere('patients.fname',"$keyword")
                    ->orwhere('tracking.code',"$keyword");
            });
        }
       
        if($request->department_filter)
        {
            $dept = $request->department_filter;
            $data = $data->where('tracking.department_id',$dept);
        }

        if($request->facility_filter)
        {
            $fac = $request->facility_filter;
            $data = $data->where('tracking.referred_from',$fac);
        }

        if($request->date_range)
        {
            $date = $request->date_range;
            $range = explode('-',str_replace(' ', '', $date));
            $start = $range[0];
            $end = $range[1];
        }

        $start_date = Carbon::parse($start)->startOfDay();
        $end_date = Carbon::parse($end)->endOfDay();

        if($request->more_position) {
            $data = $data->where(DB::raw("(SELECT count(act1.code) from activity act1 where act1.code = tracking.code and (act1.status = 'redirected' or act1.status = 'transferred'))"),$request->more_position == 5 ? ">" : "=",$request->more_position);
        }

        if($request->province_filter) {
            $data = $data->where("facility.province",$request->province_filter);
        }

        if($request->option_filter)
        {
            $option = $request->option_filter;
            if($option == 'referred') {
                $data = $data->where(function($q){
                    $q->where('tracking.status','referred')
                        ->orWhere('tracking.status','redirected')
                        ->orWhere('tracking.status','transferred')
                        ->orwhere('tracking.status','seen');
                });
            }
            elseif($option == 'accepted') {
                $data = $data->where(function($q){
                    $q->where('tracking.status','accepted')
                        ->orwhere('tracking.status','arrived')
                        ->orwhere('tracking.status','admitted')
                        ->orwhere('tracking.status','discharged');
                });
            }
            elseif($option == 'seen_only') {
                $data = $data->join('seen',function($join) use ($user) {
                    $join->on('seen.code','=','tracking.code');
                    $join->on('seen.created_at','>=','tracking.created_at');
                })
                ->where(function($query) {
                    $query->where('tracking.status','!=','accepted')
                        ->where('tracking.status','!=','redirected')
                        ->where('tracking.status','!=','rejected')
                        ->where('tracking.status','!=','arrived')
                        ->where('tracking.status','!=','admitted')
                        ->where('tracking.status','!=','discharged')
                        ->where('tracking.status','!=','transferred')
                        ->where('tracking.status','!=','archived')
                        ->where('tracking.status','!=','cancelled');
                })
                ->groupBy('tracking.code');
            }
        } else {
            $data = $data->where(function($q){
                $q->where('tracking.status','referred')
                    ->orwhere('tracking.status','seen')
                    ->orwhere('tracking.status','accepted')
                    ->orwhere('tracking.status','redirected')
                    ->orwhere('tracking.status','rejected')
                    ->orwhere('tracking.status','arrived')
                    ->orwhere('tracking.status','admitted')
                    ->orwhere('tracking.status','discharged')
                    ->orwhere('tracking.status','transferred')
                    ->orwhere('tracking.status','archived')
                    ->orwhere('tracking.status','cancelled')
                    ->orWhere('tracking.status','followup');
            });
        }

        $data = $data->whereBetween('tracking.date_referred',[$start_date,$end_date])
            ->orderBy("tracking.date_referred","desc")
            ->paginate(15);

        $facilities = Facility::where('id','<>',$user->facility_id)
            ->where('status',1)
            ->select('facility.id','facility.name')
            ->orderBy('name','asc')
            ->get();

        $departments = Department::leftJoin('users','users.department_id','=','department.id')
            ->select('department.*')
            ->where('users.department_id','<>','')
            ->where('users.facility_id',$user->facility_id)
            ->distinct('department.id')
            ->get();

        $provinces = Province::get();

        Session::put('totalIncoming_for_Dashboard', $data->total());
       
        return view('doctor.referral',[
            'title' => 'Incoming Patients',
            'data' => $data,
            'start' => $start,
            'end' => $end,
            'keyword' => $keyword,
            'department' => $dept,
            'facility' => $fac,
            'province' => $request->province_filter,
            'option' => $option,
            'more_position' => $request->more_position,
            'facilities' => $facilities,
            'departments' => $departments,
            'provinces' => $provinces
        ]);
    }

    static function countReferral()
    {
        $user = Session::get('auth');
        $count = Tracking::where('referred_to',$user->facility_id)
        ->where('telemedicine', 0)
            ->where(function($q){
                $q->where('status','referred')
                    ->orwhere('status','seen')
                    ->orWhere('status','redirected')
                    ->orWhere('status','transferred');
            })
            ->where(DB::raw("TIMESTAMPDIFF(MINUTE,date_referred,now())"),"<=",4320)
            ->count();
        return $count;
    }

    static function countTelemed()
    {
        $user = Session::get('auth');
        $count = Tracking::where('referred_to',$user->facility_id)
            ->where('telemedicine', 1)
            ->where(function($q){
                $q->where('status','referred')
                    ->orwhere('status','seen')
                    ->orWhere('status','redirected')
                    ->orWhere('status','transferred');
            })
            ->where(DB::raw("TIMESTAMPDIFF(MINUTE,date_referred,now())"),"<=",4320)
            ->count();
        return $count;
    }


    function seen($track_id) {

        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');
        Tracking::where('id',$track_id)
            ->update([
                'date_seen' => $date,
                'status' => 'seen'
            ]);
        $code = Tracking::find($track_id)->code;
        $activity = Activity::where('code',$code)
            ->where(function($q){
                $q->where('status','referred')
                    ->orwhere('status','redirected')
                    ->orwhere('status','transferred');
            })
            ->where('referred_to',$user->facility_id)
            ->orderBy('id','desc')
            ->first();
        $activity->update([
            'date_seen' => $date
        ]);
        return $activity->id;
    }

    public static function securedFile($file_link){
        $file_explode = explode("/",$file_link);
        if($file_explode[0] == "http:")
            return "https://fileupload.user.edgecloudph.com/".$file_explode[3]."/".$file_explode[4];
        return $file_link;
    }

    public function normalFormTelemed($id){
        $track = Tracking::select('status', 'type')->where('id', $id)->first();
        Session::put('telemed', true);
        return self::normalForm($id, $track->status, $track->type);
    }

    public static function normalForm($id,$referral_status,$form_type) {
        $track = Tracking::select('code', 'status', 'referred_from as referring_fac_id')->where('id', $id)->first();
        $icd = Icd::select('icd10.code', 'icd10.description')
            ->join('icd10', 'icd10.id', '=', 'icd.icd_id')
            ->where('icd.code',$track->code)->get();

        $file_link = (PatientForm::select('file_path')->where('code', $track->code)->first())->file_path;

        //        $path = self::securedFile($file_link);
        //        $file_name = basename($path);

        $path = [];
        $file_name = [];

        if($file_link != null && $file_link != "") {
            $explode = explode("|",$file_link);
            foreach($explode as $link) {
                $path_tmp = self::securedFile($link);
                if($path_tmp != '') {
                    array_push($path, $path_tmp);
                    array_push($file_name, basename($path_tmp));
                }
            }
        }

        $reason = ReasonForReferral::select("reason_referral.reason","reason_referral.id")
            ->join('patient_form', 'patient_form.reason_referral', 'reason_referral.id')
            ->where('patient_form.code', $track->code)->first();

        $form = self::normalFormData($id);
        $arr = [
            "form" => $form['form'],
            "id" => $id,
            "patient_age" => $form['age'],
            "age_type" => $form['ageType'],
            "reason" => $reason,
            "icd" => $icd,
            "file_path" => $path,
            "file_name" => $file_name,
            "referral_status" => $referral_status,
            "cur_status" => $track->status,
            "referring_fac_id" => $track->referring_fac_id,
            "form_type" => $form_type
        ];
        if(Session::get('telemed')) {
            Session::put('telemed',false);
            return $arr;
        } else {
            return view("doctor.referral_body_normal",$arr);
        }
    }

    public static function normalFormData($id) {
        $form = PatientForm::select(
            DB::raw("'$id' as tracking_id"),
            'tracking.action_md',
            'tracking.referring_md',
            'tracking.telemedicine',
            'patient_form.code as code',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            'patients.dob as dob',
            'patients.sex as patient_sex',
            'patients.civil_status as patient_status',
            'patients.phic_status',
            'patients.phic_id',
            'patient_form.covid_number',
            'patient_form.refer_clinical_status',
            'patient_form.refer_sur_category',
            'patient_form.case_summary',
            'patient_form.reco_summary',
            'patient_form.other_reason_referral',
            'patient_form.diagnosis',
            'patient_form.other_diagnoses',
            DB::raw("if(
                patients.brgy,
                concat(patients.region,', ',province.description,', ',muncity.description,', ',barangay.description),
                concat(patients.region,', ',patients.province_others,', ',patients.muncity_others,', ',patients.brgy_others)
            ) as patient_address"),
            DB::raw("concat(p.description,', ',m.description,', ',b.description) as referring_address"),
            DB::raw("concat(pp.description,', ',mm.description,', ',pp.description) as referred_address"),
            'facility.name as referring_name',
            'ff.name as referred_name',
            'ff.id as referred_fac_id',
            DB::raw("DATE_FORMAT(patient_form.time_referred,'%M %d, %Y %h:%i %p') as time_referred"),
            DB::raw("DATE_FORMAT(patient_form.time_transferred,'%M %d, %Y %h:%i %p') as time_transferred"),
            DB::raw('CONCAT(
                        if(
                            users.level="doctor",
                            "Dr. ",
                            ""
                        )
                ,users.fname," ",users.mname," ",users.lname) as md_referring'),
            'users.id as md_referring_id',
            DB::raw('CONCAT("Dr. ",u.fname," ",u.mname," ",u.lname," / ",u.contact) as md_referred'),
            'u.id as md_referred_id',
            'facility.contact as referring_contact',
            'ff.contact as referred_contact',
            'users.contact as referring_md_contact',
            'department.description as department',
            'department.id as department_id',
            DB::raw("DATE_FORMAT(act.date_referred,'%M %e, %Y %r') as date_referred"),
            DB::raw("DATE_FORMAT(tracking.date_referred,'%m/%e/%Y') as date_referral")
        )
            ->join('patients','patients.id','=','patient_form.patient_id')
            ->join('tracking','tracking.form_id','=','patient_form.id')
            ->join('facility','facility.id','=','tracking.referred_from')
            ->join('facility as ff','ff.id','=','tracking.referred_to')
            ->leftJoin('users','users.id','=','tracking.referring_md')
            ->leftJoin('users as u','u.id','=','patient_form.referred_md')
            ->leftJoin('barangay','barangay.id','=','patients.brgy')
            ->leftJoin('muncity','muncity.id','=','patients.muncity')
            ->leftJoin('province','province.id','=','patients.province')
            ->leftJoin('barangay as b','b.id','=','facility.brgy')
            ->leftJoin('muncity as m','m.id','=','facility.muncity')
            ->leftJoin('province as p','p.id','=','facility.province')
            ->leftJoin('barangay as bb','bb.id','=','ff.brgy')
            ->leftJoin('muncity as mm','mm.id','=','ff.muncity')
            ->leftJoin('province as pp','pp.id','=','ff.province')
            ->leftJoin('department','department.id','=','patient_form.department_id')
            ->leftJoin('activity as act','act.code','=','tracking.code')
            ->where('tracking.id',$id)
            ->where(function($query) {
                $query->where('act.status', 'referred')
                    ->orWhere('act.status', 'redirected')
                    ->orWhere('act.status', 'transferred');
            })
            ->orderBy('act.date_referred','desc')
            ->first();
        Session::put('date_referral', $form['date_referral']);
        $age =  ParamCtrl::getAge($form['dob']);
        $ageType = "y";
        if($age == 0){
            $age = ParamCtrl::getMonths($form['dob']);
            $ageType = "m";
        }
        return [
            "form" => $form,
            "age" => $age,
            "ageType" => $ageType
        ];
    }


    public static function pregnantFormTelemed($id){
        $track = Tracking::select('status', 'type')->where('id', $id)->first();
        Session::put('telemed', true);
        return self::pregnantForm($id, $track->status, $track->type);
    }

    public static function pregnantForm($id,$referral_status) {
        $track = Tracking::select('code', 'status', 'referred_from as referring_fac_id')->where('id', $id)->first();
        $icd = Icd::select('icd10.code', 'icd10.description')
            ->join('icd10', 'icd10.id', '=', 'icd.icd_id')
            ->where('icd.code',$track->code)->get();

        $file_link = (PregnantForm::select('file_path')->where('code', $track->code)->first())->file_path;

        $path = [];
        $file_name = [];

        if($file_link != null && $file_link != "") {
            $explode = explode("|",$file_link);
            foreach($explode as $link) {
                $path_tmp = self::securedFile($link);
                if($path_tmp != '') {
                    array_push($path, $path_tmp);
                    array_push($file_name, basename($path_tmp));
                }
            }
        }

        $reason = ReasonForReferral::select("reason_referral.id", "reason_referral.reason")
            ->join('pregnant_form', 'pregnant_form.reason_referral', 'reason_referral.id')
            ->where('pregnant_form.code', $track->code)->first();

        $arr = [
            "form" => self::pregnantFormData($id),
            "id" => $id,
            "reason" => $reason,
            "icd" => $icd,
            "file_path" => $path,
            "file_name" => $file_name,
            "referral_status" => $referral_status,
            "cur_status" => $track->status,
            "referring_fac_id" => $track->referring_fac_id,
            "form_type" => "pregnant"
        ];
      
        if(Session::get('telemed')) {
            Session::put('telemed',false);
            return $arr;
        } else {
            return view("doctor.referral_body_pregnant",$arr);
        }
    }

    public static function pregnantFormData($id) {
        $form = PregnantForm::select(
            DB::raw("'$id' as tracking_id"),
            'tracking.action_md',
            'tracking.telemedicine', // I add this a piece of code for accessing telemedicine
            'tracking.referring_md',
            'pregnant_form.patient_baby_id',
            'pregnant_form.code',
            'pregnant_form.record_no',
            'pregnant_form.other_reason_referral',
            'pregnant_form.notes_diagnoses',
            'pregnant_form.other_diagnoses',
            DB::raw("DATE_FORMAT(pregnant_form.referred_date,'%M %d, %Y %h:%i %p') as referred_date"),
            DB::raw("DATE_FORMAT(pregnant_form.arrival_date,'%M %d, %Y %h:%i %p') as arrival_date"),
            DB::raw('CONCAT(
                if(users.level="doctor","Dr. ","")
            ,users.fname," ",users.mname," ",users.lname) as md_referring'),
            'users.id as md_referring_id',
            'facility.name as referring_facility',
            'b.description as facility_brgy',
            'm.description as facility_muncity',
            'p.description as facility_province',
            'ff.name as referred_facility',
            'ff.id as referred_facility_id',
            'bb.description as ff_brgy',
            'mm.description as ff_muncity',
            'pp.description as ff_province',
            'pregnant_form.health_worker',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as woman_name'),
            DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS woman_age"),
            'patients.sex',
            DB::raw("if(
                patients.brgy,
                concat(patients.region,', ',province.description,', ',muncity.description,', ',barangay.description),
                concat(patients.region,', ',patients.province_others,', ',patients.muncity_others,', ',patients.brgy_others)
            ) as patient_address"),
            'pregnant_form.woman_reason',
            'pregnant_form.woman_major_findings',
            'pregnant_form.woman_before_treatment',
            DB::raw("DATE_FORMAT(pregnant_form.woman_before_given_time,'%M %d, %Y %h:%i %p') as woman_before_given_time"),
            'pregnant_form.woman_during_transport',
            DB::raw("DATE_FORMAT(pregnant_form.woman_transport_given_time,'%M %d, %Y %h:%i %p') as woman_transport_given_time"),
            'pregnant_form.woman_information_given',
            'facility.contact as referring_contact',
            'ff.contact as referred_contact',
            'users.contact as referring_md_contact',
            'department.description as department',
            'department.id as department_id',
            'pregnant_form.covid_number',
            'pregnant_form.refer_clinical_status',
            'pregnant_form.refer_sur_category',
            'pregnant_form.dis_clinical_status',
            'pregnant_form.dis_sur_category',
            'patients.id as mother_id',
            'patients.dob',
            DB::raw("DATE_FORMAT(tracking.date_referred,'%m/%e/%Y') as date_referral")
        )
            ->leftJoin('patients','patients.id','=','pregnant_form.patient_woman_id')
            ->leftJoin('tracking','tracking.form_id','=','pregnant_form.id')
            ->leftJoin('facility','facility.id','=','tracking.referred_from')
            ->leftJoin('facility as ff','ff.id','=','tracking.referred_to')
            ->leftJoin('users','users.id','=','pregnant_form.referred_by')
            ->leftJoin('barangay','barangay.id','=','patients.brgy')
            ->leftJoin('muncity','muncity.id','=','patients.muncity')
            ->leftJoin('province','province.id','=','patients.province')
            ->leftJoin('barangay as b','b.id','=','facility.brgy')
            ->leftJoin('muncity as m','m.id','=','facility.muncity')
            ->leftJoin('province as p','p.id','=','facility.province')
            ->leftJoin('barangay as bb','bb.id','=','ff.brgy')
            ->leftJoin('muncity as mm','mm.id','=','ff.muncity')
            ->leftJoin('province as pp','pp.id','=','ff.province')
            ->leftJoin('department','department.id','=','pregnant_form.department_id')
            ->where('tracking.id',$id)
            ->first();

        $baby = array();
        if(isset($form->patient_baby_id) && $form->patient_baby_id > 0)
        {
            $baby = PregnantForm::select(
                DB::raw('CONCAT(baby.fname," ",baby.mname," ",baby.lname) as baby_name'),
                'pregnant_form.patient_baby_id as baby_id',
                'baby.fname as baby_fname',
                'baby.mname as baby_mname',
                'baby.lname as baby_lname',
                DB::raw("DATE_FORMAT(bb.birth_date,'%M %d, %Y %h:%i %p') as baby_dob"),
                'bb.weight',
                'bb.gestational_age',
                'pregnant_form.baby_reason',
                'pregnant_form.baby_major_findings',
                DB::raw("DATE_FORMAT(pregnant_form.baby_last_feed,'%M %d, %Y %h:%i %p') as baby_last_feed"),
                'pregnant_form.baby_before_treatment',
                DB::raw("DATE_FORMAT(pregnant_form.baby_before_given_time,'%M %d, %Y %h:%i %p') as baby_before_given_time"),
                'pregnant_form.baby_during_transport',
                DB::raw("DATE_FORMAT(pregnant_form.baby_transport_given_time,'%M %d, %Y %h:%i %p') as baby_transport_given_time"),
                'pregnant_form.baby_information_given'
            )
                ->join('baby as bb','bb.baby_id','=','pregnant_form.patient_baby_id')
                ->join('patients as baby','baby.id','=','pregnant_form.patient_baby_id')
                ->join('tracking','tracking.form_id','=','pregnant_form.id')
                ->where('tracking.id',$id)
                ->first();

            if($baby['baby_dob'] === null) {
                $dob_ = Patients::select(DB::raw("DATE_FORMAT(patients.dob,'%M %d, %Y %h:%i %p') as baby_dob"))
                    ->join('pregnant_form as pregnant','pregnant.patient_baby_id','=','patients.id')
                    ->join('tracking','tracking.code','=','pregnant.code')
                    ->where('tracking.id',$id)
                    ->first();
                $baby['baby_dob'] = $dob_->baby_dob;
            }
        }

        Session::put('date_referral', $form['date_referral']);
        $form['woman_age'] = ParamCtrl::getAge($form['dob']);

        return array(
            'pregnant' => $form,
            'baby' => $baby
        );
    }

    public function referred2()
    {
        ParamCtrl::lastLogin();
        $user = Session::get('auth');
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
            ->where('referred_from',$user->facility_id)
            ->where(function($q){
                $q->where('tracking.status','referred')
                    ->orwhere('tracking.status','seen')
                    ->orwhere('tracking.status','seen')
                    ->orwhere('tracking.status','accepted')
                    ->orwhere('tracking.status','transferred')
                    ->orwhere('tracking.status','discharged')
                    ->orwhere('tracking.status','cancelled')
                    ->orwhere('tracking.status','rejected');
            })
            ->orderBy('date_referred','desc')
            ->paginate(15);
            session()->forget('profileSearch.telemedicine');
            
            session()->forget('telemed');
            
        return view('doctor.referred',[
            'title' => 'Referred Patients',
            'data' => $data
        ]);
    }

    //============== REFERRED ================
    public function referred(Request $request)
    {
        $telemedOrReferral = $request->query('filterRef', null);

        $user = Session::get('auth');
        ParamCtrl::lastLogin();
        $search = $request->search;
        $option_filter = $request->option_filter;
        $date = $request->date_range;
        $facility_filter = $request->facility_filter;
        $department_filter = $request->department_filter;

        $start = Carbon::now()->startOfYear()->format('m/d/Y');
        $end = Carbon::now()->endOfDay()->format('m/d/Y');

        if($request->referredCode){
            ParamCtrl::lastLogin();
            $data = Tracking::select(
                'tracking.*',
                DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
                DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
                DB::raw('CONCAT(users.fname," ",users.mname," ",users.lname) as referring_md'),
                'patients.sex',
                'facility.name as facility_name',
                'facility.id as facility_id',
                'patients.id as patient_id',
                'patients.contact',
                'users.level as user_level'
            )
                ->join('patients','patients.id','=','tracking.patient_id')
                ->join('facility','facility.id','=','tracking.referred_to')
                ->leftJoin('users','users.id','=','tracking.referring_md')
                ->where('tracking.code',$request->referredCode)
                ->orderBy('date_referred','desc')
                ->paginate(10);

        } else {
            $data = Activity::select(
                'tracking.*',
                DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
                DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
                DB::raw('COALESCE(CONCAT(users.fname," ",users.mname," ",users.lname),"WALK IN") as referring_md'),
                'patients.sex',
                'facility.name as facility_name',
                'facility.id as facility_id',
                'patients.id as patient_id',
                'patients.contact',
                'users.level as user_level',
                'activity.referring_md as wew'
            )
                ->leftJoin('patients','patients.id','=','activity.patient_id')
                ->leftJoin('facility','facility.id','=','activity.referred_to')
                ->leftJoin('tracking','tracking.code','=','activity.code')
                ->leftJoin('users','users.id','=',DB::raw("if(activity.referring_md,activity.referring_md,activity.action_md)"))
                ->where('activity.referred_from',$user->facility_id);

            if ($telemedOrReferral !== null) {
                $data = $data->where('tracking.telemedicine', $telemedOrReferral);
            }

            if($request->more_position) {
                $data = $data->where(DB::raw("(SELECT count(act1.code) from activity act1 where act1.code = tracking.code and (act1.status = 'redirected' or act1.status = 'transferred'))"),$request->more_position == 5 ? ">" : "=",$request->more_position);
            }

            if($search){
                $data = $data->where(function($q) use ($search){
                    $q->where('patients.fname','like',"%$search%")
                        ->orwhere('patients.mname','like',"%$search%")
                        ->orwhere('patients.lname','like',"%$search%")
                        ->orwhere('activity.code','like',"%$search%");
                });
            }

            if($facility_filter)
                $data = $data->where('activity.referred_to',$facility_filter);
            if($department_filter)
                $data = $data->where('activity.department_id',$department_filter);

            if($date) {
                $range = explode('-',str_replace(' ', '', $date));
                $start = $range[0];
                $end = $range[1];
            }

            $start_date = Carbon::parse($start)->startOfDay();
            $end_date = Carbon::parse($end)->endOfDay();

            $data = $data->whereBetween('activity.created_at',[$start_date,$end_date]);

            if($option_filter) {
                $option = $request->option_filter;
                if($option == 'referred') {
                    $data = $data->where(function($q){
                        $q->where('tracking.status','referred')
                            ->orWhere('tracking.status','redirected')
                            ->orWhere('tracking.status','transferred')
                            ->orwhere('tracking.status','seen');
                    });
                }
                elseif($option == 'accepted') {
                    $data = $data->where(function($q){
                        $q->where('tracking.status','accepted')
                            ->orwhere('tracking.status','arrived')
                            ->orwhere('tracking.status','admitted')
                            ->orwhere('tracking.status','discharged');
                    });
                }
                elseif($option == 'seen_only') {
                    $data = $data->join('seen',function($join) use ($user) {
                        $join->on('seen.code','=','tracking.code');
                        $join->on('seen.created_at','>=','tracking.created_at');
                    })
                        ->where(function($query) {
                            $query->where('tracking.status','!=','accepted')
                                ->where('tracking.status','!=','redirected')
                                ->where('tracking.status','!=','rejected')
                                ->where('tracking.status','!=','arrived')
                                ->where('tracking.status','!=','admitted')
                                ->where('tracking.status','!=','discharged')
                                ->where('tracking.status','!=','transferred')
                                ->where('tracking.status','!=','archived')
                                ->where('tracking.status','!=','cancelled');
                        })
                        ->groupBy('tracking.code');
                }
            }
            else {
                $data = $data->where(function($q){
                    $q->where('activity.status','referred')
                        ->orwhere('activity.status','redirected')
                        ->orwhere('activity.status','transferred');
                });
            }

            $data = $data->orderBy('activity.id','desc')
            ->groupBy("activity.code");

            $referred_excel = $data->get();
            Session::put("export_referred_excel",$referred_excel);
            $data = $data->paginate(10);
        }
        session()->forget('profileSearch.telemedicine');
            session()->forget('telemed');
        //  $new_referral = $request->query();

        Session::put('totalReffered_for_Dashboard', $data->total());

        return view('doctor.referred2',[
            'title' => 'Referred Patients',
            'data' => $data,
            'start' => $start,
            'end' => $end,
            'referredCode' => $request->referredCode,
            'search' => $search,
            'option_filter' => $option_filter,
            'facility_filter' => $facility_filter,
            'department_filter' => $department_filter,
            'user' => $user,
            'more_position' => $request->more_position,
            'duplicate' => $request->duplicate,
            // 'new_referral' => $new_referral,
        ]);
    }

    public function exportReferredExcel() {
        $export_referred_excel = Session::get("export_referred_excel");
        $file_name = "export_referred_excel.xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");


        return view('admin.excel.export_referred_excel',[
            "data" => $export_referred_excel
        ]);
    }

    public function exportArchivedExcel() {
        $export_archived_excel = Session::get("export_archived_excel");
        $file_name = "export_archived_excel.xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('admin.excel.export_archived_excel',[
            "data" => $export_archived_excel
        ]);
    }

    public function trackReferral(Request $request)
    {
        $code = $request->referredCode;

        ParamCtrl::lastLogin();
        $data = Tracking::select(
            'tracking.*',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
            DB::raw('CONCAT(users.fname," ",users.mname," ",users.lname) as referring_md'),
            'patients.sex',
            'facility.name as facility_name',
            'facility.id as facility_id',
            'patients.id as patient_id',
            'patients.contact'
        )
            ->join('patients','patients.id','=','tracking.patient_id')
            ->join('facility','facility.id','=','tracking.referred_to')
            ->leftJoin('users','users.id','=','tracking.referring_md')
            ->where('tracking.code',$code)
            ->orderBy('date_referred','desc')
            ->paginate(10);

        return view('doctor.tracking',[
            'title' => 'Track Patients',
            'data' => $data,
            'code' => $code
        ]);
    }

    public function searchTrackReferral(Request $req)
    {
        Session::put('referredCode',$req->keyword);
        return redirect('doctor/referred');
    }

    static function step_v2($status){
        $step = 0;
        if($status == 'referred')
            $step = 1;
        elseif($status == 'seen')
            $step = 2;
        elseif($status == 'accepted')
            $step = 3;
        elseif($status == 'arrived')
            $step = 4;
        elseif($status == 'admitted')
            $step = 5;
        elseif($status == 'discharged')
            $step = 6;
        elseif($status == 'transferred')
            $step = 6;
        elseif($status == 'cancelled')
            $step = 0;
        elseif($status == 'archived')
            $step = 4.5;

        return $step;
    }

    static function step($code)
    {
        $step = 0;
        $seen = Tracking::where('code',$code)
            ->where('date_seen','<>','')
            ->first();
        if(self::hasStatus('referred',$code))
            $step = 1;
        if($seen)
            $step = 2;
        if(self::hasStatus('accepted',$code))
            $step = 3;
        if(self::hasStatus('arrived',$code))
            $step = 4;
        if(self::hasStatus('admitted',$code))
            $step = 5;
        if(self::hasStatus('discharged',$code))
            $step = 6;
        if(self::hasStatus('cancelled',$code))
            $step = 0;
        if(self::hasStatus('archived',$code))
            $step = 4.5;

        return $step;
    }

    static function hasStatus($status,$code)
    {
        $check = Activity::where('code',$code)
            ->where('status',$status)
            ->first();
        if($check)
            return true;
        return false;
    }

    public function reject(Request $req, $track_id)
    {
        $user = Session::get('auth');
        $track = Tracking::find($track_id);

        if($track->status=='accepted' || $track->status=='rejected' || ($track->status=='redirected' && $track->referred_to != $user->facility_id)) {
            Session::put('incoming_denied',true);
            return;
        } // trap if already accepted or rejected

        Tracking::where('id',$track_id)
            ->update([
                'status' => 'rejected',
                'action_md' => $user->id
            ]);
        $track = Tracking::find($track_id);
        $act = Activity::where('code',$track->code)
            ->orderBy('id','desc')
            ->first();
        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'referred_from' => $act->referred_from,
            'referred_to' => $user->facility_id,
            'action_md' => $user->id,
            'remarks' => $req->remarks,
            'status' => $track->status
        );
        $activity = Activity::create($data);

        //start websocket
        $latest_referred_or_redirected = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred")
                ->orWhere("status","followup");
        })
            ->orderBy("id","desc")
            ->first();
        $patient = Patients::find($act->patient_id);
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $referral_rejected = [
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.'. '.ucfirst($patient->lname), //
            "rejected_by" => ucfirst($user->fname).' '.ucfirst($user->lname), //
            "rejected_by_facility" => Facility::find($activity->referred_to)->name,
            "referred_from" => $activity->referred_from, //
            "patient_code" => $activity->code, //
            "date_rejected" => date('M d, Y h:i A',strtotime($activity->created_at)), //
            "remarks" => $activity->remarks, //
            "activity_id" => $latest_referred_or_redirected->id,
            "redirect_track" => $redirect_track
        ];
        if($track->telemedicine)
            $referral_rejected['telemedicine'] = $track->telemedicine;

        broadcast(new SocketReferralRejected($referral_rejected));
        //end websocket
    }

    public function accept(Request $req,$track_id)
    {
        $user = Session::get('auth');
        $track = Tracking::find($track_id);
        if($track->status=='accepted' || $track->status=='rejected' || ($track->status=='redirected' && $track->referred_to != $user->facility_id)) {
            Session::put('incoming_denied',true);
            return;
        } // trap if already accepted or rejected

        Tracking::where('id',$track_id)
            ->update([
                'status' => 'accepted',
                'action_md' => $user->id,
                'date_accepted' => date('Y-m-d H:i:s')
            ]);
        $track = Tracking::find($track_id);

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'referred_from' => $track->referred_from,
            'referred_to' => $user->facility_id,
            'department_id' => $track->department_id,
            'referring_md' => $track->referring_md,
            'action_md' => $user->id,
            'remarks' => isset($req->remarks) ? $req->remarks : "",
            'status' => $track->status
        );

        $activity = Activity::create($data);

        //start websocket
        $latest_activity = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred")
                ->orWhere("status","followup");
        })
            ->orderBy("id","desc")
            ->first();
        $patient = Patients::find($latest_activity->patient_id);
        $redirect_track = asset("doctor/referred?referredCode=").$latest_activity->code;
        $referral_accepted = [
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.'. '.ucfirst($patient->lname),
            "accepting_doctor_id" => $user->id,
            "accepting_doctor" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "accepting_facility_name" => Facility::find($user->facility_id)->name,
            "referred_from" => $latest_activity->referred_from,
            "patient_code" => $latest_activity->code,
            "tracking_id" => $track_id,
            "activity_id" => $latest_activity->id,
            "date_accepted" => date('M d, Y h:i A',strtotime($activity->date_referred)),
            "remarks" => $activity->remarks,
            "redirect_track" => $redirect_track
        ];
        broadcast(new SocketReferralAccepted($referral_accepted));
        //end websocket
    }

    public function call($activity_id)
    {
        $user = Session::get('auth');

        $md_name = "Dr. $user->fname $user->mname $user->lname";
        $activity = Activity::find($activity_id);
        $action_md = User::find($activity->action_md);
        $action_md = "Dr. $action_md->fname $action_md->mname $action_md->lname";
        $facility_name = Facility::find($activity->referred_from)->name;

        $remarks = "$md_name called $facility_name";
        Activity::where('id',$activity_id)
            ->update([
                'remarks' => $remarks
            ]);
    }

    public function calling($track_id)
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');
        $track = Tracking::find($track_id);
        
        if($track->status == 'rejected')
            return;

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $track->referred_from,
            'referred_to' => $track->referred_to,
            'action_md' => $user->id,
            'remarks' => 'N/A',
            'status' => 'calling'
        );
        $activity = Activity::create($data);

        $caller_by = ucwords(mb_strtolower($user->fname))." ".ucwords(mb_strtolower($user->lname));
        $caller_by_facility = Facility::find($track->referred_to)->name;
        $called_to_facility = Facility::find($track->referred_from)->name;
        $count_caller = Activity::where("code",$track->code)->where("status","=","calling")->count();
        //start websocket
        $patient = Patients::find($track->patient_id);
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $referral_call = [
            "patient_code" => $track->code,
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.'. '.ucfirst($patient->lname),
            "caller_by" => $caller_by,
            "caller_by_contact" => $user->contact,
            "caller_by_facility" => $caller_by_facility,
            "caller_date" => date('M d, Y h:i A',strtotime($activity->created_at)),
            "called_to" => $activity->referred_from,
            "called_to_facility" => $called_to_facility,
            "count_caller" => $count_caller,
            "redirect_track" => $redirect_track
        ];
        broadcast(new SocketReferralCall($referral_call));
    }

    public function arrive(Request $req, $track_id)
    {
        $user = Session::get('auth');
        $date = date('M d, Y h:i A');
        $track = Tracking::find($track_id);

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $track->referred_to,
            'referred_to' => 0,
            'action_md' => $user->id,
            'remarks' => $req->remarks,
            'status' => 'arrived'
        );
        Activity::create($data);

        Tracking::where("id",$track_id)
            ->update([
                'date_arrived' => $date,
                'status' => 'arrived'
            ]);

        $patient = Patients::find($track->patient_id);
        $latest_activity = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred");
        })
        ->orderBy("id","desc")
        ->first();
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $new_arrive = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "current_facility" => Facility::find($user->facility_id)->name,
            "arrived_date" => date('M d, Y h:i A',strtotime($date)),
            "patient_code" => $track->code,
            "activity_id" => $latest_activity->id,
            "referred_from" => $latest_activity->referred_from,
            "remarks" => $req->remarks,
            "redirect_track" => $redirect_track
        ];

        broadcast(new SocketReferralArrived($new_arrive));
    }

    public function archive(Request $req, $track_id)
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');
        $track = Tracking::find($track_id);

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $track->referred_to,
            'referred_to' => 0,
            'action_md' => $user->id,
            'remarks' => $req->remarks,
            'status' => 'archived'
        );
        Activity::create($data);

        Tracking::where("id",$track_id)
            ->update([
                'date_arrived' => $date,
                'status' => 'archived'
            ]);

        $patient = Patients::find($track->patient_id);
        $latest_activity = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred");
        })
            ->orderBy("id","desc")
            ->first();
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $new_notarrived = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "current_facility" => Facility::find($user->facility_id)->name,
            "arrived_date" => date('M d, Y h:i A',strtotime($date)),
            "patient_code" => $track->code,
            "activity_id" => $latest_activity->id,
            "referred_from" => $latest_activity->referred_from,
            "remarks" => $req->remarks,
            "redirect_track" => $redirect_track
        ];

        broadcast(new SocketReferralNotArrived($new_notarrived));
    }

    public function admit(Request $req, $track_id)
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s',strtotime($req->date_time));
        $track = Tracking::find($track_id);

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $track->referred_to,
            'referred_to' => 0,
            'action_md' => $user->id,
            'remarks' => 'admitted',
            'status' => 'admitted'
        );
        Activity::create($data);

        Tracking::where('id',$track_id)
            ->update([
                'status' => 'admitted'
            ]);


        $patient = Patients::find($track->patient_id);
        $latest_activity = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred");
        })
            ->orderBy("id","desc")
            ->first();
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $new_admitted = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "current_facility" => Facility::find($user->facility_id)->name,
            "arrived_date" => date('M d, Y h:i A',strtotime($date)),
            "patient_code" => $track->code,
            "activity_id" => $latest_activity->id,
            "referred_from" => $latest_activity->referred_from,
            "redirect_track" => $redirect_track
        ];

        broadcast(new SocketReferralAdmitted($new_admitted));
    }

    public function discharge(Request $req, $track_id)
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s',strtotime($req->date_time));
        $track = Tracking::find($track_id);

        $track->update([
            'status' => 'discharged'
        ]);

        $patient_form = PatientForm::where('code',$track->code)->first();
        if($patient_form){
            $patient_form->update([
                'dis_clinical_status' => $req->clinical_status,
                'dis_sur_category' => $req->sur_category
            ]);
        }

        $pregnant_form = PregnantForm::where('code',$track->code)->first();
        if($pregnant_form){
            $pregnant_form->update([
                'dis_clinical_status' => $req->clinical_status,
                'dis_sur_category' => $req->sur_category
            ]);
        }

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $track->referred_to,
            'referred_to' => 0,
            'action_md' => $user->id,
            'remarks' => $req->remarks,
            'status' => 'discharged'
        );
        Activity::create($data);

//        foreach($req->icd_ids as $i) { /* FOR WHEN ICD IS TRANSFERRED TO "DISCHARGE" */
//            $icd = new Icd();
//            $icd->code = $track->code;
//            $icd->icd_id = $i;
//            $icd->save();
//        }

        $patient = Patients::find($track->patient_id);
        $latest_activity = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred");
        })
            ->orderBy("id","desc")
            ->first();
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;

        $new_discharged = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "current_facility" => Facility::find($user->facility_id)->name,
            "arrived_date" => date('M d, Y h:i A',strtotime($date)),
            "patient_code" => $track->code,
            "activity_id" => $latest_activity->id,
            "referred_from" => $latest_activity->referred_from,
            "remarks" => $req->remarks,
            "redirect_track" => $redirect_track,
            "status" => "discharged"
        ];

        broadcast(new SocketReferralDischarged($new_discharged));
    }

    public function transfer(Request $req) {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');

        $track = Tracking::where('id',$req->transfer_tracking_id)->first();
        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $track->referred_to,
            'referred_to' => $req->facility,
            'department_id' => $req->department,
            'action_md' => $user->id,
            'remarks' => $req->remarks,
            'status' => "transferred"
        );
        Activity::create($data);

        $new_data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'date_arrived' => '',
            'date_seen' => '',
            'department_id' => $req->department,
            'referred_from' => $track->referred_to,
            'referred_to' => $req->facility,
            'remarks' => $track->remarks,
            'referring_md' => $user->id,
            'status' => 'transferred',
            'type' => $track->type,
            'form_id' => $track->form_id
        );
        $track->update($new_data);

        //websocket
        $patient = Patients::find($track->patient_id);
        $count_seen = Seen::where('tracking_id',$track->id)->count();
        $count_reco = Feedback::where("code",$req->code)->count();
        $redirect_track = asset("doctor/referred?referredCode=").$req->code;
        $new_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find($req->facility)->name,
            "referred_to" => (int)$req->facility,
            "referred_department" => Department::find($req->department)->description,
            "referred_from" => $user->facility_id,
            "form_type" => $track->type,
            "tracking_id" => $track->id,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $req->code,
            "status" => "transferred",
            "count_seen" => $count_seen,
            "count_reco" => $count_reco,
            "redirect_track" => $redirect_track
        ];
        broadcast(new NewReferral($new_referral));
        //end websocket

        return Redirect::back();
    }

    public function redirect(Request $req) // MyRedirect
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');

        $track = Tracking::where("code",$req->code)->first();

        if(!$track) {
            Session::put('redirected_failed',true);
            return Redirect::back();
        }

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => $date,
            'referred_from' => $user->facility_id,
            'referred_to' => $req->facility,
            'referring_md' => $user->id,
            'remarks' => '',
            'status' => 'redirected'
        );

        Activity::create($data);
        $track->update([
            'date_referred' => $date,
            'department_id' => $req->department,
            'date_arrived' => '',
            'date_seen' => '',
            'referred_from' => $user->facility_id,
            'referred_to' => $req->facility,
            'remarks' => '',
            'referring_md' => $user->id,
            'status' => 'redirected'
        ]);

        Activity::where('code',$track->code)->where('status','queued')->delete();

        $patient = Patients::find($track->patient_id);
        $tracking = Tracking::where("code",$req->code)->first();
        $count_seen = Seen::where('tracking_id',$tracking->id)->count();
        $count_reco = Feedback::where("code",$req->code)->count();
        $redirect_track = asset("doctor/referred?referredCode=").$req->code;
        $icds = Icd::where('code', $req->code)->pluck('icd_id')->toArray();
        $diagnosis = Icd10::whereIn('id', $icds)->pluck('description');
        $pregnantForm = PregnantForm::where('patient_woman_id', $track->patient_id)->first();//I am added this
        $patientform = PatientForm::where('patient_id', $track->patient_id)->first();
        $position = Activity::where("code",$req->code)
            ->where(function($query) {
                $query->where("status","redirected")
                    ->orWhere("status","transferred");
            })
            ->count();
        $new_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find($req->facility)->name,
            "referred_to" => (int)$req->facility,
            "referred_department" => Department::find($req->department)->description,
            "referred_from" => $user->facility_id,
            "form_type" => $track->type,
            "tracking_id" => $track->id,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $req->code,
            "status" => "redirected",
            "count_seen" => $count_seen,
            "count_reco" => $count_reco,
            "redirect_track" => $redirect_track,
            "position" => $position,
            "push_diagnosis" =>  $diagnosis->isEmpty() ? $patientform->other_diagnoses : $diagnosis,
            "chiefComplaint" =>  $pregnantForm->woman_major_findings ?: $patientform->case_summary,
        ];
        broadcast(new NewReferral($new_referral)); //websockets notification for new referral
       
        if($req->facility == 790 || $req->facility == 23) {
             try {
                 ApiController::notifierPushNotification(array(
                "age" => (string) ParamCtrl::getAge($patient->dob),
                //"chiefComplaint" => $req->facility,
                "department" => (string) Department::find($req->department)->description,
                "patient" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
                "sex" => (string) $patient->sex,
                "referring_hospital" => (string) Facility::find($user->facility_id)->name,
                "referred_to" => (string) $req->facility,
                "date_referred" => (string) $date
                 ));
             } catch (Exception $e) {
                return Redirect::back();
            }
        }//push notification for cebu south medical center
   
        // return Redirect::back()->with('new_referral', $new_referral);
        if($req->facility == 790 || $req->facility == 23) {
            session()->put('for_firebase_data', $new_referral);
        }
        return Redirect::back();
    }

    public function seenBy($track_id,$code)
    {
        $user = Session::get('auth');
        $data = array(
            'tracking_id' => $track_id,
            'code' => $code,
            'facility_id' => $user->facility_id,
            'user_md' => $user->id
        );
        Tracking::find($track_id)->update([
            "date_seen" => date("Y-m-d H:i:s")
        ]);

        Seen::create($data);

        //start websocket
        $tracking = Tracking::find($track_id);
        $patient = Patients::find($tracking->patient_id);
        $latest_activity = Activity::where("code",$tracking->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred")
                ->orWhere("status","followup");
        })
        ->orderBy("id","desc")
        ->first();
        $count_seen = Seen::where('tracking_id',$tracking->id)->count();
        $redirect_track = asset("doctor/referred?referredCode=").$code;
        $seen_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "seen_by" => ucfirst($user->fname).' '.ucfirst($user->lname),//
            "seen_by_facility" => Facility::find($user->facility_id)->name,//
            "referring_name" => Facility::find($tracking->referred_to)->name,
            "referring_facility_id" => (int)$tracking->referred_from,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $code,
            "activity_id" => $latest_activity->id,
            "count_seen" => $count_seen,
            "redirect_track" => $redirect_track
        ];
        broadcast(new SocketReferralSeen($seen_referral));
        //end websocket
    }

    public function seenByList($track_id)
    {
        $data = Seen::select(
            DB::raw('CONCAT(users.fname," ",users.mname," ",users.lname) as user_md'),
            DB::raw("DATE_FORMAT(seen.created_at,'%M %d, %Y %h:%i %p') as date_seen"),
            'users.contact',
            'facility.name as facility_name'
        )
            ->leftJoin('users','users.id','=','seen.user_md')
            ->leftJoin('facility', 'facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('seen.tracking_id',$track_id)
            ->orderBy('seen.created_at','desc')
            ->get();
        return $data;
    }

    public function callerByList($track_id)
    {
        $data = \App\Tracking::select(
            \DB::raw("concat('Dr. ',users.fname,' ',users.mname,' ',users.lname) as user_md"),
            DB::raw("DATE_FORMAT(activity.created_at,'%M %d, %Y %h:%i %p') as date_call"),
            "users.contact"
        )
            ->Join("activity","activity.code","=","tracking.code")
            ->Join("users","users.id","=","activity.action_md")
            ->where('tracking.id',$track_id)
            ->where("activity.status","=","calling")
            ->get();

        return $data;
    }

    static function checkForCancellation($code)
    {
        $check = Activity::where('code',$code)
            ->where(function($q) {
                $q->where('status','arrived')
                    ->orwhere('status','admitted')
                    ->orwhere('status','discharged')
                    ->orwhere('status','cancelled')
                    ->orwhere('status','archived')
                    ->orwhere('status','transferred');
            })
            ->first();
        if($check)
            return true;
        return false;
    }

    public function cancelReferral(Request $req, $id)
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');
        $track = Tracking::find($id);
        $activity = Activity::where("code",$track->code)->where(function($q){
            $q->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred");
        })
            ->orderBy("id","desc")
            ->first();

        $already_rejected = Activity::where('code',$track->code)->orderBy('id','desc')->first();
        if($already_rejected->status === 'cancelled') {
            Session::put('rejected_by_admin',true);
            return redirect()->back();
        }

        if(isset($req->admin)) {
            $data = array(
                'code' => $activity->code,
                'patient_id' => $activity->patient_id,
                'date_referred' => $date,
                'referred_from' => $activity->referred_from,
                'referred_to' => $activity->referred_to,
                'action_md' => $activity->referring_md,
                'remarks' => "(Cancelled by 711 Admin) - " . $req->reason,
                'status' => 'cancelled'
            );
        } else {
            $data = array(
                'code' => $activity->code,
                'patient_id' => $activity->patient_id,
                'date_referred' => $date,
                'referred_from' => $activity->referred_from,
                'referred_to' => $activity->referred_to,
                'action_md' => $user->id,
                'remarks' => $req->reason,
                'status' => 'cancelled'
            );
        }

        Activity::create($data);

        Tracking::where('id',$id)
            ->update([
                'status' => 'cancelled'
            ]);

        $patient = Patients::find($track->patient_id);
        $latest_activity = Activity::where("code",$track->code)->orderBy("id","desc")->first();
        $count_reco = Feedback::where("code",$track->code)->count();
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $activity_id = Activity::where("code",$track->code)->where("status","referred")->first()->id;

        $md = User::where('id',$latest_activity->action_md)->first();
        $cancel = [
            "patient_code" => $track->code,
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.' '.ucfirst($patient->lname),
            "activity_id" => $activity_id,
            "referring_md" => ucfirst($md->fname).' '.ucfirst($md->lname),
            "referring_name" => Facility::find($md->facility_id)->name,
            "cancelled_date" => date('M d, Y h:i A',strtotime($date)),
            "remarks" => $latest_activity->remarks,
            "referred_from" => $latest_activity->referred_from,
            "referred_to" => $latest_activity->referred_to,
            "count_reco" => $count_reco,
            "redirect_track" => $redirect_track,
            "admin" => (isset($req->admin)) ? 'yes' : 'no',
            "notif_type" => "cancel referral"
        ];
        broadcast(new SocketReferralUpdate($cancel));
        return redirect()->back();
    }

    public function departedReferral(Request $req, $tracking_id){
        $mode_transportation = $req->mode_transportation;
        $other_transportation = $req->other_transportation;
        if($mode_transportation == "5"){
            $mode_transportation .= "-".$other_transportation;
        }

        $user = Session::get('auth');

        $track = Tracking::find($tracking_id);
        if($track->status=='travel') {
            Session::put("already_departed",true);
            return false;
        }

        $track->update([
            "date_transferred" => date('Y-m-d H:i:s'),
            "mode_transportation" => $mode_transportation
        ]);

        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'referred_from' => $track->referred_from,
            'referred_to' => $user->facility_id,
            'department_id' => $track->department_id,
            'referring_md' => $track->referring_md,
            'action_md' => $user->id,
            'remarks' => $mode_transportation,
            'status' => 'travel'
        );

        $activity = Activity::create($data);
        Session::put("departed",true);

        //start websocket
        $departed_by = ucwords(mb_strtolower($user->fname))." ".ucwords(mb_strtolower($user->lname));
        $departed_by_facility = Facility::find($user->facility_id)->name;
        $patient = Patients::find($track->patient_id);
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $departed = [
            "patient_code" => $track->code,
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.' '.ucfirst($patient->lname),
            "departed_by" => $departed_by,
            "departed_by_facility" => $departed_by_facility,
            "referred_to" => $track->referred_to,
            "mode_transportation" => $activity->remarks == 5 ? $other_transportation : ModeTransportation::find($activity->remarks)->transportation,
            "departed_date" => date('M d, Y h:i A',strtotime($activity->created_at)),
            "redirect_track" => $redirect_track
        ];
        broadcast(new SocketReferralDeparted($departed));
        return redirect()->back();
    }

    public function feedback($code){
        $data = Feedback::select(
            'feedback.id as id',
            'feedback.sender as sender',
            'feedback.message',
            'users.fname as fname',
            'users.lname as lname',
            'facility.name as facility',
            'facility.abbr as abbr',
            'feedback.created_at as date',
            'feedback.code'
        )
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('code',$code)
            ->orderBy("id","asc")
            ->get();

        return view('doctor.feedback',[
            'data' => $data,
            'code' => $code
        ]);
    }

    public function loadFeedback($code)
    {
        $id = Session::get('last_scroll_id');
        $data = Feedback::select(
            'feedback.id as id',
            'feedback.sender as sender',
            'feedback.message',
            'users.fname as fname',
            'users.lname as lname',
            'facility.name as facility',
            'facility.abbr as abbr',
            'feedback.created_at as date'
        )
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('code',$code)
            ->where('feedback.id','<',$id)
            ->latest('feedback.id')
            ->take(5)
            ->get();

        if(count($data)==0)
            return 0;

        return view('doctor.feedback',[
            'data' => $data->reverse()
        ]);
    }

    public function replyFeedback($id)
    {
        $user = Session::get('auth');
        $position = '';
        $icon = 'receiver.png';
        $pull = 'right';

        $data = Feedback::select(
            'feedback.sender as sender',
            'feedback.message',
            'users.fname as fname',
            'users.lname as lname',
            'facility.name as facility',
            'facility.abbr as abbr',
            'feedback.created_at as date'
        )
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('feedback.id',$id)
            ->first();

        if($user->id==$data->sender){
            $position = 'right';
            $icon = 'sender.png';
            $pull = 'left';
        }

        $fullname = ucwords(mb_strtolower($data->fname))." ".ucwords(mb_strtolower($data->lname));
        $picture = url('resources/img/'.$icon);

        $content = '
            <div class="direct-chat-msg '.$position.'">
                    <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-'.$position.'">'.$fullname.'</span>
                    <span class="direct-chat-timestamp pull-'.$pull.'">'.date('d M h:i a',strtotime($data->date)).'</span>
                    </div>

                    <img class="direct-chat-img" title="'.$data->facility.'" src="'.$picture.'" alt="'.$data->facility.'">
                    <div class="direct-chat-text">
                        '.$data->message.'
                    </div>

                </div>
        ';

        return $content;
    }

    public function saveFeedback(Request $req)
    {
        $user = Session::get('auth');
        $data = array(
            'code'=> $req->code,
            'sender'=> $user->id,
            'receiver'=> 0,
            'message'=> $req->message,
        );

        Feedback::create($data);
        //reco websocket
        $reco_json = ParamCtrl::feedbackContent($req->code,$user->id,$req->message);
        broadcast(new SocketReco($reco_json));
        //end reco websocket

        $doc = User::find($user->id);
        $name = ucwords(mb_strtolower($doc->fname))." ".ucwords(mb_strtolower($doc->lname));
        return view('doctor.feedback_append',[
            "name" => $name,
            "facility" => Facility::find($user->facility_id)->name,
            "message" => $req->message
        ]);
    }

    public function receiverFeedback($user_id,$msg)
    {
        $user = User::find($user_id);
        $name = ucwords(mb_strtolower($user->fname))." ".ucwords(mb_strtolower($user->lname));
        return view('doctor.feedback_append',[
            "name" => $name,
            "message" => $msg
        ]);
    }

    public function notificationFeedback($code,$user_id)
    {
        $user = Session::get('auth');
        $facility_id = $user->facility_id;
        $dr = User::find($user_id);
        $check = Tracking::where(function($q) use ($facility_id){
            $q->where('referred_from',$facility_id)
                ->orwhere('referred_to',$facility_id);
        })
            ->where('code',$code)
            ->first();
        if($check){
            $data['check'] = 1;
            $data['info'] = array(
                'fname' => ucwords(mb_strtolower($dr->fname)),
                'lname' => ucwords(mb_strtolower($dr->lname))
            );
            return $data;
        }
        return 0;
    }

    public static function editInfo($id,$form_type,$referral_status)
    {
        $track = Tracking::select('code')->where('id', $id)->first();
        $icd = Icd::select('icd10.code', 'icd10.description', 'icd.icd_id as id')
            ->join('icd10', 'icd10.id', '=', 'icd.icd_id')
            ->where('icd.code',$track->code)->get();

        if($form_type == 'normal') {
            $file_link = (PatientForm::select('file_path')->where('code', $track->code)->first())->file_path;
        //    $path = self::securedFile($file_link);
        //    $file_name = basename($path);

            $path = array();
            $file_name = array();

            if($file_link != null) {
                $explode = explode("|",$file_link);
                foreach($explode as $link) {
                    $path_tmp = self::securedFile($link);
                    if($path_tmp != '') {
                        array_push($path, $path_tmp);
                        array_push($file_name, basename($path_tmp));
                    }
                }
            }

            $reason = ReasonForReferral::select('patient_form.reason_referral as id', 'reason_referral.reason as reason')
                ->join('patient_form', 'patient_form.reason_referral', 'reason_referral.id')
                ->where('patient_form.code', $track->code)->first();
            $form = self::normalFormData($id);
       
            return view("doctor.edit_referral_normal", [
                "form" => $form['form'],
                "id" => $id,
                "patient_age" => $form['age'],
                "age_type" => $form['ageType'],
                "reason" => $reason,
                "icd" => $icd,
                "file_path" => $path,
                "file_name" => $file_name,
                "form_type" => $form_type,
                "referral_status" => $referral_status,
                "username" => Session::get('auth')->username
            ]);
        } else if($form_type == 'pregnant') {
            $file_link = (PregnantForm::select('file_path')->where('code', $track->code)->first())->file_path;

            $path = array();
            $file_name = array();

            if($file_link != null) {
                $explode = explode("|",$file_link);
                foreach($explode as $link) {
                    $path_tmp = self::securedFile($link);
                    if($path_tmp != '') {
                        array_push($path, $path_tmp);
                        array_push($file_name, basename($path_tmp));
                    }
                }
            }

            $reason = ReasonForReferral::select('pregnant_form.reason_referral as id', 'reason_referral.reason as reason')
                ->join('pregnant_form', 'pregnant_form.reason_referral', 'reason_referral.id')
                ->where('pregnant_form.code', $track->code)->first();

            return view("doctor.edit_referral_pregnant", [
                "form" => self::pregnantFormData($id),
                "id" => $id,
                "reason" => $reason,
                "icd" => $icd,
                "file_path" => $path,
                "file_name" => $file_name,
                "referral_status" => $referral_status,
                "form_type" => $form_type,
                "username" => Session::get('auth')->username
            ]);
        }
    }

    public static function editForm(Request $req)
    {
        $user = Session::get('auth');
        $id = $req->id;
        $old_facility = (int) $req->old_facility;

        $tracking = Tracking::where('id', $id)->first();

        if($tracking->status == 'rejected') {
            Session::put('ignore_edit',true);
            return redirect()->back();
        }

        $track = $tracking->code;

        $updated = '';
        $date = date('Y-m-d H:i:s');

        $form_type = $req->form_type;
        $dob = date('Y-m-d h:i:s', strtotime($req->baby_dob));
        $data = '';

        $data_update = $req->all();

        /* FACILITY AND DEPARTMENT */
        if($old_facility != $req->referred_to)
            $updated .= "Referred facility, Department";

        if($form_type === 'normal') {
            $data = PatientForm::where('code', $track)->first();

            /* DIAGNOSIS NOTES */
            if(($data->diagnosis !== $req->diagnosis) || $req->notes_diag_cleared)
                $updated .= ", Diagnosis Notes";

            if($req->notes_diag_cleared)
                $data->update(['diagnosis' => NULL]);
            unset($data_update['notes_diag_cleared']);

            /* TIME OF REFERRAL WILL CHANGE IF FACILITY IS UPDATED/CHANGED */
            if($old_facility != $req->referred_to)
                $data->update(['time_referred' => date('Y-m-d H:i:s')]);
        }
        else if($form_type === 'pregnant') {
            $data = PregnantForm::where('code', $track)->first();
            $baby_id = $req->baby_id;
            $match = Patients::where('id', $baby_id)->first();

            if($old_facility != $req->referred_to)
                $data->update(['referred_date' => date('Y-m-d H:i:s')]);

            $baby = array(
                "fname" => $req->baby_fname,
                "mname" => $req->baby_mname,
                "lname" => $req->baby_lname,
                "dob" => $dob
            );
            if(isset($match)) {
                $match->update($baby);
            } else {
                $baby_id = PatientCtrl::storeBabyAsPatient($baby,$req->mother_id);
            }

            $match = Baby::where("baby_id", $baby_id)->first();

            if(isset($match)) {
                if((isset($match->weight) && $match->weight != $req->baby_weight) || (isset($match->gestational_age) && $match->gestational_age != $req->baby_gestational_age) || (isset($match->birth_date) && $match->birth_date != $dob))
                    $updated .= ", Baby's Information";
                $match->weight = ($req->baby_weight) ? $req->baby_weight : '';
                $match->gestational_age = ($req->baby_gestational_age) ? $req->baby_gestational_age : '';
                $match->birth_date = $dob;
                $match->save();
            } else {
                $updated .= ", Baby's Information";
                $b = new Baby();
                $b->baby_id = $baby_id;
                $b->mother_id = $req->mother_id;
                $b->weight = ($req->baby_weight) ? $req->baby_weight : '';
                $b->gestational_age = ($req->baby_gestational_age) ? $req->baby_gestational_age : '';
                $b->birth_date = $dob;
                $b->save();
            }

            unset($data_update['baby_fname']);
            unset($data_update['baby_mname']);
            unset($data_update['baby_lname']);
            unset($data_update['baby_dob']);
            unset($data_update['baby_weight']);
            unset($data_update['baby_gestational_age']);
            unset($data_update['baby_id']);
            unset($data_update['mother_id']);

            if($req->notes_diag_cleared == "true")
                $data->update(['notes_diagnoses' => NULL]);

            unset($data_update['notes_diag_cleared']);

            $woman_before_given_time = date('Y-m-d h:i:s', strtotime($req->woman_before_given_time));
            $woman_transport_given_time = date('Y-m-d h:i:s', strtotime($req->woman_transport_given_time));
            $baby_last_feed = date('Y-m-d h:i:s', strtotime($req->baby_last_feed));
            $baby_before_given_time = date('Y-m-d h:i:s', strtotime($req->baby_before_given_time));
            $baby_transport_given_time = date('Y-m-d h:i:s', strtotime($req->baby_transport_given_time));
            $baby_reason = ($req->baby_reason == null) ? 'None' : $req->baby_reason;
            $baby_information_given = ($req->baby_information_given == null) ? '' : $req->baby_information_given;

            if(isset($data->woman_reaso) && $data->woman_reason != $req->woman_reason)
                $updated .= ", Mother's main reason for referral";
            if(isset($data->woman_major_findings) && $data->woman_major_findings != $req->woman_major_findings)
                $updated .= ", Mother's major findings";
            if(isset($data->woman_before_treatment) && $data->woman_before_treatment != $req->woman_before_treatment)
                $updated .= ", Mother's treatment given before referral";
            if($data->woman_before_given_time != '0000-00-00 00:00:00' && $data->woman_before_given_time != $woman_before_given_time)
                $updated .= ", Mother's treament time before referral";
            if(isset($data->woman_during_transport) && $data->woman_during_transport != $req->woman_during_transport)
                $updated .= ", Mother's treatment given during transport";
            if($data->woman_transport_given_time != '0000-00-00 00:00:00' && $data->woman_transport_given_time != $woman_transport_given_time)
                $updated .= ", Mother's treatment time during transport";
            if(($data->notes_diagnoses != $req->notes_diagnoses) || $req->notes_diag_cleared)
                $updated .= ", Diagnosis Notes";
            if(isset($data->baby_reason) && $data->baby_reason != $baby_reason)
                $updated .= ", Baby's main reason for referral";
            if(isset($data->baby_major_findings) && $data->baby_major_findings != $req->baby_major_findings)
                $updated .= ", Baby's major findings";
            if($data->baby_last_feed != '0000-00-00 00:00:00' && $data->baby_last_feed != $baby_last_feed)
                $updated .= ", Baby's last feeding time";
            if(isset($data->baby_before_treatment) && $data->baby_before_treatment != $req->baby_before_treatment)
                $updated .= ", Baby's treatment given before referral";
            if($data->baby_before_given_time != '0000-00-00 00:00:00' && $data->baby_before_given_time != $baby_before_given_time)
                $updated .= ", Baby's treatment time before referral";
            if(isset($data->baby_during_transport) && $data->baby_during_transport != $req->baby_during_transport)
                $updated .= ", Baby's treatment given during transport";
            if($data->baby_transport_given_time != '0000-00-00 00:00:00' && $data->baby_transport_given_time != $baby_transport_given_time)
                $updated .= ", Baby's treatment time during transport";
            if((isset($data->woman_information_given) && $data->woman_information_given != $req->woman_information_given) || (isset($data->baby_information_given) && $data->baby_information_given !== $baby_information_given))
                $updated .= ", Information given about the reason of referral";

            $data_update['patient_baby_id'] = $baby_id;
            $data_update['woman_before_given_time'] = ($req->woman_before_given_time) ? $woman_before_given_time : '';
            $data_update['woman_transport_given_time'] = ($req->woman_transport_given_time) ? $woman_transport_given_time : '';
            $data_update['baby_last_feed'] = ($req->baby_last_feed) ? $baby_last_feed : '';
            $data_update['baby_before_given_time'] = ($req->baby_before_given_time) ? $baby_before_given_time : '';
            $data_update['baby_transport_given_time'] = ($req->baby_transport_given_time) ? $baby_transport_given_time : '';
        }

        /* COVID NUMBER, CLINICAL STATUS AND SURVEILLANCE CATEGORY */
        if($data->covid_number !== $req->covid_number)
            $updated .= ", Covid Number";

        if($data->refer_clinical_status !== $req->refer_clinical_status)
            $updated .= ", Covid Clinical Status";

        if($data->refer_sur_category !== $req->refer_sur_category)
            $updated .= ", Covid Surveillance Category";

        /* CASE SUMMARY AND SUMMARY OF RECO */
        if($data->case_summary !== $req->case_summary)
            $updated .= ", Case summary";

        if($data->reco_summary !== $req->reco_summary)
            $updated .= ", Summary of ReCo";


        /* DIAGNOSIS THAT IS NOT AN ICD CODE */
        if(($data->other_diagnoses !== $req->other_diagnoses) || $req->other_diag_cleared)
            $updated .= ", Diagnosis";

        if($req->other_diag_cleared == "true") {
            $data->update(['other_diagnoses' => NULL]);
        }
        unset($data_update['other_diag_cleared']);


        /* ICD DIAGNOSIS */
        if($req->icd_cleared === 'true')
            Icd::where('code', $track)->delete();
        unset($data_update['icd_cleared']);

        $updated_icd = false;
        foreach($req->icd_ids as $i) {
            $value = Icd::where('code', $track)->where('icd_id', $i)->first();
            if(!isset($value)) {
                $icd = new Icd();
                $icd->code = $track;
                $icd->icd_id = $i;
                $icd->save();
                $updated_icd = true;
            }
        }
        unset($data_update['icd_ids']);
        if($updated_icd) {
            $updated .= ", ICD-10 Diagnosis";
        }

        /* FILE ATTACHMENT */
        if($req->file_cleared == "true") {
            $data->update([
                'file_path' => ""
            ]);
        }

        $file_paths = $data->file_path;
        $old_file = $file_paths;
        if($_FILES["file_upload"]["name"]) {
            ApiController::fileUpload($req);
            for($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
                $file = $_FILES['file_upload']['name'][$i];
                if(isset($file) && !empty($file)) {
                    $username = $user->username;
                    $file_paths .= ApiController::fileUploadUrl().$username."/".$file;
                    if($i + 1 != count($_FILES["file_upload"]["name"])) {
                        $file_paths .= "|";
                    }
                }
            }
        }
        $data->update([
            'file_path' => $file_paths
        ]);

        if($req->file_cleared == "true" || $old_file != $data->file_path) {
            $updated .= ", File Attachment";
        }
        unset($data_update['file_cleared']);

//        echo $data->file_path . "<br>";

        unset($data_update['file_upload']);
        unset($data_update['username']);
        unset($data_update['id']);
        unset($data_update['referral_status']);
        unset($data_update['form_type']);


        /* REASON FOR REFERRAL */
        $reason_referral = (int) $req->reason_referral;
        if(($data->reason_referral !== $reason_referral) || ($data->other_reason_referral !== $req->other_reason_referral))
            $updated .= ", Reason for Referral";
        $data_update['other_reason_referral'] = isset($req->other_reason_referral) ? $req->other_reason_referral : null;

        if($updated[0] === ',')
            $updated = substr($updated, 2, strlen($updated));

        $updated_remarks = "";
        if($updated !== "") {
            $updated_remarks .= "Updated fields: " . $updated;
        }

        $latest_activity = Activity::select('status')->where('code',$tracking->code)->orderBy('id','desc')->first()->status;
        if($latest_activity == 'accepted') {
            Session::put('already_accepted',true);
            return redirect()->back();
        }

        if($old_facility != $req->referred_to) {
//            Seen::where('tracking_id',$tracking->id)->delete();

            $data2 = array(
                'code' => $track,
                'patient_id' => $tracking->patient_id,
                'date_referred' => $date,
                'referred_from' => $tracking->referred_from,
                'referred_to' => $old_facility,
                'department_id' => $req->department_id,
                'referring_md' => $user->id,
                'action_md' => $user->id,
                'remarks' => "Patient's referral form was updated and was redirected to another facility. ".$updated_remarks,
                'status' => "rejected"
            );
            Activity::create($data2);

            $data2 = array(
                'code' => $track,
                'patient_id' => $tracking->patient_id,
                'date_referred' => $date,
                'referred_from' => $tracking->referred_from,
                'referred_to' => $req->referred_to,
                'department_id' => $req->department_id,
                'referring_md' => $user->id,
                'action_md' => $user->id,
                'remarks' => "Patient's referral form was updated and has been redirected to this facility. ".$updated_remarks,
                'status' => "redirected"
            );
            Activity::create($data2);

            $new_data = array(
                'date_referred' => $date,
                'date_arrived' => '',
                'date_seen' => '',
                'action_md' => $user->id,
                'department_id' => $req->department_id,
                'referred_to' => $req->referred_to,
                'referring_md' => $user->id,
                'status' => 'redirected'
            );
            $tracking->update($new_data);
        } else {
            $data2 = array(
                'code' => $track,
                'patient_id' => $tracking->patient_id,
                'date_referred' => $date,
                'referred_from' => $tracking->referred_from,
                'referred_to' => $req->referred_to,
                'department_id' => $req->department_id,
                'referring_md' => $user->id,
                'action_md' => $user->id,
                'remarks' => $updated_remarks,
                'status' => "form_updated"
            );
            Activity::create($data2);

            $new_data = array(
                'department_id' => $req->department_id,
            );
            $tracking->update($new_data);
        }
        unset($data_update['old_facility']);

        $data_update["department_id"] = $req->department_id;
        $data->update($data_update);
        Session::put('referral_update_save',true);
        Session::put('update_message','Successfully updated referral form!');

        $patient = Patients::find($tracking->patient_id);
        $date = date('Y-m-d H:i:s');
        $count_seen = Seen::where('tracking_id',$tracking->id)->count();
        $count_reco = Feedback::where("code",$track)->count();
        $count_activity = Activity::where("code",$track)
            ->where(function($query){
                $query->where("status","redirected");
            })
            ->groupBy("code")
            ->count();
        $latest_activity = Activity::where("code",$track)->orderBy("id","desc")->first();
        $tracking = Tracking::where('id', $id)->first();
        $redirect_track = asset("doctor/referred?referredCode=").$track;

        $update = [
            "patient_code" => $track,
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.' '.ucfirst($patient->lname),
            "activity_id" => $latest_activity->id,
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "update_date" => date('M d, Y h:i A',strtotime($date)),
            "referred_to" => $latest_activity->referred_to,
            "referred_name" => Facility::find($latest_activity->referred_to)->name,
            "referred_department" => Department::where('id',$tracking->department_id)->first()->description,
            "referred_from" => $user->facility_id,
            "form_type" => $tracking->type,
            "tracking_id" => $tracking->id,
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "status" => $tracking->status,
            "count_activity" => $count_activity,
            "count_seen" => $count_seen,
            "count_reco" => $count_reco,
            "old_facility" => $old_facility,
            "faci_changed" => ($old_facility == $latest_activity->referred_to) ? false : true,
            "redirect_track" => $redirect_track,
            "notif_type" => "update form"
        ];

        broadcast(new SocketReferralUpdate($update));
        return redirect()->back();
    }

    public static function undoCancel(Request $req)
    {
        $id = $req->undo_cancel_id;

        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');
        $track = Tracking::find($id);
        $activity = Activity::where("code",$track->code)
            ->where("status",'!=','cancelled')
            ->where("status",'!=','form_updated')
            ->where("status",'!=','queued')
            ->where("status",'!=','calling')
            ->where("status",'!=','travel')
            ->orderBy("id","desc")
            ->first();

        Tracking::where('id',$id)
            ->update([
                'status' => $activity->status
            ]);
        Activity::where("code",$track->code)->orderBy("id","desc")->first()->delete();

        $patient = Patients::find($track->patient_id);
        $latest_activity = Activity::where("code",$track->code)->orderBy("id","desc")->first();
        $count_seen = Seen::where('tracking_id',$track->id)->count();
        $count_reco = Feedback::where("code",$track->code)->count();
        $count_activity = Activity::where("code",$req->code)
            ->where(function($query){
                $query->where("status","referred")
                    ->orWhere("status","redirected")
                    ->orWhere("status","transferred");
            })
            ->groupBy("code")
            ->count();
        if($latest_activity->status == 'rejected')
            $md = User::select('fname', 'lname', 'mname', 'facility_id')->where('id',$latest_activity->action_md)->first();
        else if($latest_activity->status == 'queued' || $latest_activity->status == 'accepted' || $latest_activity->status == 'calling') {
            $tmp = Activity::where('code',$track->code)->where('status','referred')->orwhere('status','redirected')->orderBy('id','desc')->first();
            $md = User::select('fname', 'lname', 'mname', 'facility_id')->where('id',$tmp->referring_md)->first();
        }  else
            $md = User::select('fname', 'lname', 'mname', 'facility_id')->where('id',$latest_activity->referring_md)->first();

        $referred_md = User::select('fname', 'lname', 'mname', 'facility_id')->where('id',$latest_activity->action_md)->first();
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $track = Tracking::find($id);

        $queue_stat = Activity::where('code',$track->code)->where('status','queued')->orderBy('id','desc')->first();
        if(isset($queue_stat))
            $cur_queue = $queue_stat->remarks;

        $undo = [
            "patient_code" => $track->code,
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.' '.ucfirst($patient->lname),
            "activity_id" => $latest_activity->id,
            "referring_md" => ucfirst($md->fname).' '.ucfirst($md->lname),
            "referring_name" => Facility::find($md->facility_id)->name,
            "referred_md" => ucfirst($referred_md->fname).' '.ucfirst($referred_md->lname),
            "referred_name" => Facility::find($latest_activity->referred_to)->name,
            "referred_to" => $latest_activity->referred_to,
            "referred_department" => Department::where('id',$track->department_id)->first()->description,
            "referred_from" => $user->facility_id,
            "undo_date" => date('M d, Y h:i A',strtotime($date)),
            "form_type" => $track->type,
            "tracking_id" => $track->id,
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "status" => $track->status,
            "count_activity" => $count_activity,
            "count_seen" => $count_seen,
            "count_reco" => $count_reco,
            "redirect_track" => $redirect_track,
            "cur_queue" => isset($cur_queue) ? $cur_queue : '',
            "notif_type" => "undo cancel"
        ];

        broadcast(new SocketReferralUpdate($undo));

        return redirect()->back();
    }

    public function queuePatient(Request $req) {
        /* NOTE:
         *  Updates patient's activity status to queued and triggers websocket to reflect changes
         * */
        $user = Session::get('auth');
        $track = Tracking::find($req->tracking_id);
        $act = Activity::where('code',$track->code)
            ->orderBy('id','desc')
            ->first();
        $data = array(
            'code' => $track->code,
            'patient_id' => $track->patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'referred_from' => $act->referred_from,
            'referred_to' => $act->referred_to,
            'action_md' => $user->id,
            'remarks' => $req->queue_number,
            'status' => "queued"
        );
        $activity = Activity::create($data);
        $patient = Patients::find($track->patient_id);
        $redirect_track = asset("doctor/referred?referredCode=").$track->code;
        $latest_act = Activity::where("code",$track->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred");
        })
            ->orderBy("id","desc")
            ->first();
        $first_queue = Activity::where('code',$track->code)->where('status','queued')->first()->remarks;

        $queue = [
            "patient_code" => $track->code,
            "patient_name" => ucfirst($patient->fname).' '.$patient->mname.' '.ucfirst($patient->lname),
            "queued_by" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "queued_by_facility" => Facility::find($user->facility_id)->name,
            "referred_from" => $activity->referred_from,
            "date_queued" => date('M d, Y h:i A',strtotime($activity->created_at)),
            "remarks" => $activity->remarks,
            "redirect_track" => $redirect_track,
            "activity_id" => $latest_act->id,
            "first_queue" => $first_queue,
            "notif_type" => "queue patient"
        ];

        broadcast(new SocketReferralUpdate($queue));
    }

    public function duplicates(Request $req) {
        /* NOTE:
         *   Returns a list of "possible" duplicate referrals.
         */
        $user = Session::get('auth');
        $referral_type = $req->referral_type;
        $search = $req->search;
        if(isset($req->view_all))
            $search = "";

        if(isset($req->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$req->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$req->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::yesterday()->startOfDay()->format('Y-m-d') . ' 00:00:00';
            $date_end = Carbon::now()->endOfDay()->format('Y-m-d') . ' 23:59:59';
            $req->date_range = $date_start." - ".$date_end;
        }

        $list = Tracking::select(
            'tracking.code',
            'tracking.patient_id',
            'tracking.date_referred',
            'tracking.referred_from',
            'tracking.referred_to',
            'facility.name as referred_facility',
            'tracking.type',
            'tracking.status',
            'patients.fname',
            'patients.mname',
            'patients.lname'
        )
            ->where('tracking.referred_from',$user->facility_id)
            ->where('tracking.walkin','no')
            ->where('tracking.status','!=','cancelled')
            ->where('tracking.status','!=','discharged')
            ->leftJoin('patients','patients.id','=','tracking.patient_id')
            ->leftJoin('facility','facility.id','=','tracking.referred_to');

        if(isset($search) && $search != '') {
            $list = $list->where(function($query) use ($search) {
                $query->where('patients.fname','like','%'.$search.'%')
                    ->orWhere('patients.mname','like','%'.$search.'%')
                    ->orWhere('patients.lname','like','%'.$search.'%');
            });
        }

        $list = $list->whereBetween('tracking.date_referred',[$date_start,$date_end])
            ->orderBy('tracking.patient_id','asc')
            ->get();

        $current = "";
        $data = array();
        $count = 1;
        /* NOTE:
         *  Matching keys for duplicate referrals are:
         *      -> First name
         *      -> Middle Name
         *      -> Last Name
         *      -> Facility (Referred From & Referred To)
         *  Check if it is cancelled or not
         */
        for($i = 0; $i < count($list); $i++) {
            $pt = $list[$i];
            $next = $list[$i+1];
            if($current == "")
                $current = $pt;

            $timestamp = strtotime($pt->date_referred);
            $date = date('M d, Y',$timestamp);
            $time = date('h:i a',$timestamp);
            $pt['date'] = $date;
            $pt['time'] = $time;

            if(($current->lname == $next->lname) && ($current->fname == $next->fname) && ($current->mname == $next->mname) && ($current->referred_from == $next->referred_from) && ($current->referred_to == $next->referred_to)) {
                array_push($data, $pt);
                $count++;
            } else {
                if ($count > 1)
                    array_push($data, $pt);
                $current = $next;
                $count = 1;
            }
        }

        return view('doctor.duplicated',[
            'title' => 'Duplicate Referrals',
            'data' => $data,
            'start' => $date_start,
            'end' => $date_end,
            'referral_type' => $referral_type,
            'user' => $user,
            'search' => $search
        ]);
    }
}