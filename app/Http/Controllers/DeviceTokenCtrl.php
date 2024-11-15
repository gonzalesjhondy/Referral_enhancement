<?php

namespace App\Http\Controllers;

use App\Devicetoken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kawankoding\Fcm\Fcm;

class DeviceTokenCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save($token)
    {
        $user = Session::get('auth');
        $facility_id = $user->facility_id;

        $data = array(
            'facility_id' => $facility_id,
            'token' => $token
        );
        Devicetoken::updateOrCreate($data,$data);

        Session::put('tokenSaved',true);
    }

    static function send($title,$body,$facility_id)
    {
        $list = Devicetoken::where('facility_id',$facility_id)->get();

        if(count($list)==0)
            exit();

        $devices = array();
        foreach($list as $row){
            $devices[] = $row->token;
        }

        Fcm()
            ->to($devices)
            ->data([
                'title' => $title,
                'body' => $body,
                'icon' => url('resources/img/doh.png')
            ])
            ->send();
    }
}
