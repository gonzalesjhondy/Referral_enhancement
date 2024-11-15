<?php

namespace App\Http\Controllers\admin;

use App\Department;
use App\Facility;
use App\FacilityAssign;
use App\Login;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Twilio\TwiML\Voice\Redirect;

class UserCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function index(Request $request)
    {
        $keyword = $request->search;
        $data = new User();
        if($keyword){
            $data = $data
                ->where(function($q) use($keyword){
                $q->where('fname','like',"%$keyword%")
                    ->orwhere('mname','like',"%$keyword%")
                    ->orwhere('lname','like',"%$keyword%")
                    ->orwhere('username','like',"%$keyword%")
                    ->orwhere(\DB::raw('concat(fname," ",lname)'),'like',"$keyword")
                    ->orwhere(\DB::raw('concat(lname," ",fname)'),'like',"$keyword");
            });
        }

        if($request->facility_filter)
            $data = $data->where("facility_id",$request->facility_filter);

        $data = $data
                ->where(function($q){
                    $q->where("level",'support')
                        ->orWhere("level","opcen")
                        ->orWhere("level","bed_tracker")
                        ->orWhere("level","mayor")
                        ->orWhere("level","dmo");
                    })
                ->orderBy('lname','asc')
                ->paginate(20);

        $facility = Facility::orderBy('name','asc')->get();

        return view('admin.users',[
            'title' => 'List of Support User',
            'data' => $data,
            'facility' => $facility,
            'search' => $keyword,
            'facility_filter' => $request->facility_filter
        ]);
    }

    public function loginAs()
    {
        return view('admin.loginAs',[
            'title' => 'Login As'
        ]);
    }

    public function assignLogin(Request $req)
    {
        $user = Session::get('auth');

        Session::put('multiple_login', false);
        Session::put('multiple_faci_id', $req->facility_id);
        Session::put('admin',true);

        $faci = FacilityAssign::where('user_id', $user->id)->where('facility_id', $req->facility_id)->first();
        if(count($faci) > 0) {
            $login = Login::where('userId', $user->id)->orderBy('id','desc')->first();
            $faci->last_login = $login->login;
            $faci->login_status = "login";
            $faci->save();
            $user->department_id = $faci->department_id;
            Session::put('admin', false);
        }

        $user->facility_id = $req->facility_id;
        $province = Facility::find($req->facility_id)->province;

        $user->level = $req->level;
        $user->province = $province;

        Session::put('auth',$user);

        return redirect($user->level);
    }

    public function info($user_id)
    {
        $user = User::find($user_id);
        $facility = Facility::get();
        return view('admin.users_body',[
            "user" => $user,
            "facility" => $facility,
            "user_id" => $user_id
        ]);
    }

    public function check($string)
    {
        $user = Session::get('auth');
        $check = User::where('username',$string)
            ->where('id','!=',$user->id)
            ->first();
        if($check){
            return '1';
        }
        return '0';
    }

    public function store(Request $req)
    {
        $user = Session::get('auth');
        $facility = Facility::find($req->facility_id);
        $data = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'level' => $req->level,
            'facility_id' => $req->facility_id,
            'status' => $req->status,
            'contact' => $req->contact,
            'email' => $req->email,
            'designation' => $req->designation,
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'muncity' => $facility->muncity,
            'province' => $facility->province,
            'created_by' => $user->id,
        );
        if($req->user_id == "no_id"){
            Session::put("manage_user","Successfully added new account");
            User::create($data);
        }
        else{
            Session::put("manage_user","Successfully updated account");
            User::find($req->user_id)->update($data);
        }
    }


    public function faciAssign(Request $req) {
        $keyword = $req->search_assign;
        $data = [];
        if(isset($keyword)) {
            $users = User::select(
                'id', 'username',  'fname', 'mname', 'lname'
            )
                ->where(function($q) use($keyword){
                    $q->where('fname','like',"%$keyword%")
                        ->orwhere('mname','like',"%$keyword%")
                        ->orwhere('lname','like',"%$keyword%")
                        ->orwhere('username','like',"%$keyword%")
                        ->orwhere(DB::raw('concat(fname," ",lname)'),'like',"$keyword")
                        ->orwhere(DB::raw('concat(lname," ",fname)'),'like',"$keyword");
                })
                ->where('level','doctor')
                ->get();
            foreach($users as $user) {
                $tmp = [
                    'user_id' => $user->id,
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'username' => $user->username
                ];
                $tmp['facilities'] = self::getUserFacilities($user->id);
                array_push($data, $tmp);
            }
        }
        return view('admin.faci_assign.faci_assign', [
            'data' => $data,
            'keyword' => $keyword
        ]);
    }

    public static function getUserFacilities($id) {
        $data = FacilityAssign::select(
            'facility_assignment.facility_id as faci_id',
            'facility_assignment.facility_code as faci_code',
            'facility_assignment.department_id',
            'facility_assignment.contact',
            'facility_assignment.email',
            'facility_assignment.status',
            'facility_assignment.last_login',
            'facility_assignment.login_status',
            'facility.name as faci_name'
        )
            ->leftJoin('facility','facility.id','=','facility_assignment.facility_id')
            ->where('facility_assignment.user_id',$id)->get();

        if(count($data) == 0) {
            $data = User::select(
                'users.facility_id as faci_id',
                'facility.facility_code',
                'facility.name as faci_name',
                'users.department_id',
                'users.contact',
                'users.email',
                'users.status',
                'users.last_login'
            )
                ->leftJoin('facility','facility.id','=','users.facility_id')
                ->where('users.id',$id)->get();
        }

        return $data;
    }

    public function getUserInfo(Request $req) {
        $user = User::select(
            'users.id',
            'users.username',
            'users.fname',
            'users.mname',
            'users.lname'
        )
            ->where('id',$req->user_id)->first();
        $user_faci= self::getUserFacilities($req->user_id);
        $facilities = Facility::select('id', 'facility_code', 'name')
            ->where('status','1')
            ->where('referral_used','yes')
            ->get();
        $departments = Department::all();
        return view('admin.faci_assign.user_assign', [
            'user' => $user,
            'user_faci' => $user_faci,
            'facilities' => $facilities,
            'departments' => $departments
        ]);
    }

    public function updateAssignment(Request $req) {
        $existing = FacilityAssign::select('facility_id')->where('username', $req->username)->get();
        $user = User::where('id',$req->user_id)->first();

        for($i = 0; $i < count($req->faci); $i++) {
            $faci_id = (int) $req->faci[$i];
            $data = array(
                'username' => $req->username,
                'user_id' => $req->user_id,
                'facility_id' => $faci_id,
                'facility_code' => Facility::where('id',$faci_id)->first()->facility_code
            );

            if($user->facility_id === $faci_id) { // already assigned to this facility in table "users"
                $data['last_login'] = $user->last_login;
                $data['login_status'] = $user->login_status;
            } else{
                $data['last_login'] = "0000-00-00 00:00:00";
                $data['login_status'] = "logout";
            }
            $data['department_id'] = $req->department[$i];
            $data['contact'] = $req->contact[$i];
            $data['email'] = $req->email[$i];
            $data['status'] = $req->status[$i];

            $exist = FacilityAssign::where('username',$req->username)->where('facility_id', $faci_id)->first();
            if(count($exist) == 0) {
                FacilityAssign::create($data);
            } else {
                FacilityAssign::where('username',$req->username)->where('facility_id',$faci_id)->update($data);
            }

            for($j = 0; $j < count($existing); $j++) {
                if($faci_id == $existing[$j]->facility_id) {
                    $existing[$j] = null;
                    break;
                }
            }
            // check logic again
        }

        foreach($existing as $delete) {
            FacilityAssign::where('facility_id', $delete->facility_id)->where('username', $req->username)->delete();
        }

        return redirect()->back();
    }
}