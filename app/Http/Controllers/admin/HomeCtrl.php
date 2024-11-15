<?php

namespace App\Http\Controllers\admin;

use App\Facility;
use App\Login;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('admin');
        //$this->middleware('doctor');
    }

    public function index()
    {
        return view('admin.home',[
            'title' => 'Admin: Dashboard'
        ]);
    }

    public function count()
    {
        $tmp = User::where('level','doctor');
        $data['countDoctors'] = $tmp->count();

        $data['countReferral'] = Tracking::count();
        $countFacility = Facility::where('status',1)->count();
        return array(
            'countDoctors' => number_format($data['countDoctors']),
            'countReferral' => number_format($data['countReferral']),
            'countOnline' => number_format(self::countOnline()),
            'countFacility' => number_format($countFacility)
        );
    }

    function countOnline()
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
                ->count();
        return $data;
    }
}
