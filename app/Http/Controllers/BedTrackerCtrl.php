<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Province;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\BedTracker;
use Illuminate\Support\Facades\Session;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BedTrackerCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(){
        ParamCtrl::lastLogin();

        $user = Session::get("auth");

        if($user->level == 'admin') {
            $group_by_department = User::
            select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
                ->leftJoin("department","department.id","=","users.department_id")
                ->where("users.level","doctor")
                ->groupBy("users.department_id")
                ->get();
        }
        else {
            $group_by_department = User::
            select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
                ->leftJoin("department","department.id","=","users.department_id")
                ->where("users.facility_id",$user->facility_id) //TODO: possible changes for multiple facility log-in
                ->where("users.level","doctor")
                ->groupBy("users.department_id")
                ->get();
        }

        $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
        $date_end = Carbon::now()->endOfYear()->format('Y-m-d').' 23:59:59';

        //$incoming_statistics = \DB::connection('mysql')->select("call statistics_report_facility('$date_start','$date_end','$user->facility_id','$user->level')")[0];
        //return json_encode($incoming_statistics);

        $referred_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','referred','$user->level')");
        $accepted_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','accepted','$user->level')");
        $redirected_query = DB::connection('mysql')->select("call doctor_monthly_report('$date_start','$date_end','$user->facility_id','redirected','$user->level')");


        //for past 15 days

        $date_start_past = date('Y-m-d',strtotime(Carbon::now()->subDays(15))).' 00:00:00';
        $date_end_past = date('Y-m-d',strtotime(Carbon::now()->subDays(1))).' 23:59:59';
        //$emergency_room_covid = DB::connection('mysql')->select("call bed_past_transaction('$date_start_past','$date_end_past','$user->facility_id','emergency_room_covid','$user->level')");
        //$icu_covid = DB::connection('mysql')->select("call bed_past_transaction('$date_start_past','$date_end_past','$user->facility_id','icu_covid','$user->level')");
        //$beds_covid = DB::connection('mysql')->select("call bed_past_transaction('$date_start_past','$date_end_past','$user->facility_id','beds_covid','$user->level')");
        //$isolation_covid = DB::connection('mysql')->select("call bed_past_transaction('$date_start_past','$date_end_past','$user->facility_id','isolation_covid','$user->level')");

        $index = 0;
        foreach($referred_query as $row){
            $data['referred'][] = $row->value;
            $data['accepted'][] = $accepted_query[$index]->value;
            $data['redirected'][] = $redirected_query[$index]->value;
            $index++;
        }

        return view('bed_tracker.home',[
            "group_by_department" => $group_by_department,
            "doctor_monthly_report" => $data,
            /*"emergency_room_covid" => $emergency_room_covid,
            "icu_covid" => $icu_covid,
            "beds_covid" => $beds_covid,
            "isolation_covid" => $isolation_covid,*/
            "date_start" => $date_start,
            "date_end" => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function bed($facility_id){
        $facility = Facility::find($facility_id);
        return view('bed_tracker.bed_in_facility',[
            "facility" => $facility
        ]);
    }

    public function bedUpdate(Request $request){
        $facility = Facility::find($request->facility_id);

        $facility->update([
            $request->column => $request->value
        ]);

        $bed_tracker = new BedTracker();
        $bed_tracker->encoded_by = Session::get('auth')->id;
        $bed_tracker->facility_id = $facility->id;
        $bed_tracker->emergency_room_covid = $facility->emergency_room_covid;
        $bed_tracker->emergency_room_covid_vacant = $facility->emergency_room_covid_vacant;
        $bed_tracker->emergency_room_covid_occupied = $facility->emergency_room_covid_occupied;
        $bed_tracker->icu_covid = $facility->icu_covid;
        $bed_tracker->icu_covid_vacant = $facility->icu_covid_vacant;
        $bed_tracker->icu_covid_occupied = $facility->icu_covid_occupied;
        $bed_tracker->beds_covid = $facility->beds_covid;
        $bed_tracker->beds_covid_vacant = $facility->beds_covid_vacant;
        $bed_tracker->beds_covid_occupied = $facility->beds_covid_occupied;
        $bed_tracker->isolation_covid = $facility->isolation_covid;
        $bed_tracker->isolation_covid_vacant = $facility->isolation_covid_vacant;
        $bed_tracker->isolation_covid_occupied = $facility->isolation_covid_occupied;
        $bed_tracker->mechanical_used_covid = $facility->mechanical_used_covid;
        $bed_tracker->mechanical_vacant_covid = $facility->mechanical_vacant_covid;
        $bed_tracker->emergency_room_non = $facility->emergency_room_non;
        $bed_tracker->emergency_room_non_vacant = $facility->emergency_room_non_vacant;
        $bed_tracker->emergency_room_non_occupied = $facility->emergency_room_non_occupied;
        $bed_tracker->icu_non = $facility->icu_non;
        $bed_tracker->icu_non_vacant = $facility->icu_non_vacant;
        $bed_tracker->icu_non_occupied = $facility->icu_non_occupied;
        $bed_tracker->beds_non = $facility->beds_non;
        $bed_tracker->beds_non_vacant = $facility->beds_non_vacant;
        $bed_tracker->beds_non_occupied = $facility->beds_non_occupied;
        $bed_tracker->isolation_non = $facility->isolation_non;
        $bed_tracker->isolation_non_vacant = $facility->isolation_non_vacant;
        $bed_tracker->isolation_non_occupied = $facility->isolation_non_occupied;
        $bed_tracker->mechanical_used_non = $facility->mechanical_used_non;
        $bed_tracker->mechanical_vacant_non = $facility->mechanical_vacant_non;
        $bed_tracker->emergency_room_covid_wait = $facility->emergency_room_covid_wait;
        $bed_tracker->icu_covid_wait = $facility->icu_covid_wait;
        $bed_tracker->emergency_room_non_wait = $facility->emergency_room_non_wait;
        $bed_tracker->icu_non_wait = $facility->icu_non_wait;
        $bed_tracker->remarks = $facility->remarks;
        $bed_tracker->save();

        $user = Session::get('auth');
        $data["encoded_by"] = ucfirst($user->fname).' '.ucfirst($user->mname[0]).'. '.ucfirst($user->lname);
        $data["encoded_date"] = date("F d,Y");
        $data["encoded_time"] = "(".date("g:i a").")";

        return $data;
    }

    public function bedAdmin(Request $request){

        $province_select = $request->province;
        $facility_select = $request->facility;

        $facility = Facility::where(function($q){
                $q->where("hospital_type","government")->orWhere("hospital_type","private")->orWhere("hospital_type","doh_hospital");
            })
            ->where("referral_used","yes")
            ->orderBy("province","asc")
            ->orderBy("name","asc");

        if($province_select)
            $facility = $facility->where("province",$province_select);
        if($facility_select)
            $facility = $facility->where("id",$facility_select);

        $facility = $facility->get();
        Session::put('bed_facility',$facility);

        $province = Province::get();

        return view('bed_tracker.bed_in_admin',[
            "facility" => $facility,
            "province" => $province,
            "province_select" => $province_select,
            "facility_select" => $facility_select
        ]);
    }

    public function selectFacility($province_id){
        return Facility::select("id","name")
                ->where("province",$province_id)
                ->where(function($q){
                    $q->where("hospital_type","government")->orWhere("hospital_type","private");
                })
                ->orderBy("name","asc")
                ->get();
    }

    public function bedExport(){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=bed_export.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        return view('bed_tracker.excel');
    }

}
