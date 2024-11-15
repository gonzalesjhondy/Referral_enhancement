<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\ParamCtrl;
use App\Login;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class UserCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function searchDoctor(Request $req)
    {
        $data = array(
            'keyword' => $req->keyword,
            'facility_id' => $req->facility_id
        );
        Session::put('search_doctor',$data);
        return self::index();
    }

    public function index()
    {
        ParamCtrl::lastLogin();

        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        $data = Login::select(
            'login.login as login',
            'users.id as id',
            'users.fname as fname',
            'users.lname as lname',
            'users.mname as mname',
            'users.level as level',
            'users.contact',
            'facility.name as facility',
            'facility.abbr as abbr',
            'department.description as department',
            'login.status as status',
            'login.type as type'    
        );

        $data = $data->where(function($q) {
            $q->where('login.status','login')
                ->orwhere('login.status','login_off');
        });

        $data = $data->join('users','users.id','=','login.userId')
                ->join('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
                ->leftJoin('department','department.id','=','users.department_id')
                ->whereBetween('login.login',[$start,$end])
                ->where('login.logout','0000-00-00 00:00:00')
                ->orderBy('facility.name','asc')
                ->get();

        $final = array();
        $temp = array();
        $current = $data[0]->facility;
        for($i = 0; $i < count($data); $i++) {
            $row = $data[$i];
            array_push($temp, $row);
            if($current !== $data[$i+1]->facility) {
                rsort($temp);
                array_push($final, $temp);
                $temp = array();
                $current = $data[$i+1]->facility;
            }
        }

        $hospitals = \DB::connection('mysql')->select("call online_facility_view('$start','$end')");

        return view('doctor.list',[
            'title' => 'Online Users',
            'data' => $final,
            'hospitals' => $hospitals
        ]);
    }

    public function changeLogin(Request $req)
    {
        $login = User::find($req->loginId);

        if($login->status==='inactive'){
            return 'inactive';
        }else{
            if(Hash::check($req->loginPassword,$login->password))
            {
                $user = Session::get('auth');
                Session::flush();
//                User::where('id',$user->id)
//                    ->update([
//                        'login_status' => 'logout'
//                    ]);
//                $logout = date('Y-m-d H:i:s');
//                $logoutId = Login::where('userId',$user->id)
//                    ->orderBy('id','desc')
//                    ->first()
//                    ->id;
//
//                Login::where('id',$logoutId)
//                    ->update([
//                        'logout' => $logout
//                    ]);

                Session::put('auth',$login);
                $last_login = date('Y-m-d H:i:s');
                User::where('id',$login->id)
                    ->update([
                        'last_login' => $last_login,
                        'login_status' => 'login'
                    ]);
                $checkLastLogin = self::checkLastLogin($login->id);

                if(!$checkLastLogin){
                    $l = new Login();
                    $l->userId = $login->id;
                    $l->login = $last_login;
                    $l->status = 'login';
                    $l->save();
                }

                if($checkLastLogin > 0 ){
                    Login::where('id',$checkLastLogin)
                        ->update([
                            'logout' => $last_login
                        ]);

                    $l = new Login();
                    $l->userId = $login->id;
                    $l->login = $last_login;
                    $l->status = 'login';
                    $l->save();
                }

                return redirect('doctor');
            }
            else
            {
                return redirect('doctor?error=1');
            }
        }
    }

    function checkLastLogin($id)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();
        $login = Login::where('userId',$id)
            ->whereBetween('login',[$start,$end])
            ->orderBy('id','desc')
            ->first();
        if($login && (!$login->logout>=$start && $login->logout<=$end)){
            return true;
        }
        if(!$login){
            return false;
        }

        return $login->id;
    }

    public function setLogoutTime(Request $request){
        $user = Session::get('auth');
        $input_time_logout = date('Y-m-d H:i:s',strtotime($request->input_time_logout));
        Login::where("userId",$user->id)->orderBy("id","desc")->first()->update([
            "logout" => $input_time_logout
        ]);
        Session::put('logout_time',true);
        return Redirect::back();
    }

    public function editProfile(Request $req) {
        $user = Session::get('auth');
        $data = $req->all();
        unset($data['_token'], $data['id'], $data['choose']);

        if(isset($data['sign_type']) && isset($data['signature'])) {
            if($data['sign_type'] == "draw" || $data['sign_type'] == "upload") {
                $sign = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['signature']));
                $file_path = base_path()."/public/signatures/";
                $name = $user->id."-".strtolower($user->lname)."-".strtolower($user->fname).".png";
                $filename = $file_path.$name;
                if(!is_dir($file_path)) {
                    mkdir($file_path);
                }
                file_put_contents($filename, $sign);
            } 
        }

        if(isset($data['signature']))
            $user->signature = "public/signatures/".$name;
        else
            $user->signature = null;

        unset($data['signature'], $data['sign_type']);
        $user->update($data);
        Session::forget('auth');
        $user = User::where('username',$user->username)->first();

        Session::put('auth', $user);
        return Redirect::back();
    }

}
