<?php

namespace App\Http\Controllers\support;

use App\Login;
use App\PatientForm;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeCtrl extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('support');
    }

    public function index()
    {
        $user = Session::get("auth");
        $group_by_department = User::
        select(DB::raw("count(users.id) as y"),DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"))
            ->leftJoin("department","department.id","=","users.department_id")
            ->where("users.facility_id",$user->facility_id) //TODO: possible changes for multiple facility log-in
            ->where("users.level","doctor")
            ->groupBy("users.department_id")
            ->get();
        return view('support.home',[
            'title' => 'Support: Dashboard',
            "group_by_department" => $group_by_department
        ]);
    }

    public function count()
    {
        $user = Session::get('auth');
        $facility_id = $user->facility_id;
        $tmp = User::where('facility_id',$facility_id)
                ->where('level','doctor');

        $data['countDoctors'] = $tmp->count();

        $data['countReferral'] = Tracking::where('referred_from',$facility_id)->count();
        return array(
            'countDoctors' => number_format($data['countDoctors']),
            'countReferral' => number_format($data['countReferral']),
            'countOnline' => number_format(self::countOnline($facility_id))
        );
    }

    function countOnline($facility_id)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        $data = Login::where(function($q) {
                    $q->where('login.status','login')
                        ->orwhere('login.status','login_off');
                })
                ->join('users','users.id','=','login.userId')
                ->where('users.level','doctor')
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->where('users.facility_id',$facility_id) //TODO: possible changes for multiple facility log-in
                ->count();
        return $data;
    }
}
