<?php

namespace App\Http\Controllers;

use App\Devicetoken;
use Illuminate\Http\Request;
use Kawankoding\Fcm\Fcm;

class FcmCtrl extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function send()
    {
        $devices = Devicetoken::get();
        $ids = array();
        foreach($devices as $row){
            $ids[] = $row->token;
        }

        $result = Fcm()
            ->to($ids)
            ->data([
                'title' => 'Test FCM part 2',
                'body' => 'This is a test of FCM',
                'icon' => url('resources/img/doh.png')
            ])
            ->send();

        print_r($result);
    }
}
