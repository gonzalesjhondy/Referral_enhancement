<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Login;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogoutCtrl extends Controller
{
    public function logout() {
        $user = Session::get('auth');
        session()->flush();
        session()->regenerate(); //by using this code, my bugs has been fixed, where after logout, the session never flush
        if(isset($user)){
            User::where('id',$user->id)
                ->update([
                    'login_status' => 'logout'
                ]);
            $logout = date('Y-m-d H:i:s');

            $logoutId = Login::where('userId',$user->id)
                ->orderBy('id','desc')
                ->first()
                ->id;

            Login::where('id',$logoutId)
                ->update([
                    'status' => 'login_off',
                    'logout' => $logout
                ]);

            /*$multiple_faci_id = Session::get('multiple_faci_id');
            $faci = FacilityAssign::where('user_id', $user->id)->where('facility_id', $multiple_faci_id)->first();
            if(count($faci) > 0) {
                $faci->login_status = "logout";
                $faci->save();
            }*/
        }
        return redirect('login');
    }

    public function checkSession() {
        return session()->getId();
    }
}
