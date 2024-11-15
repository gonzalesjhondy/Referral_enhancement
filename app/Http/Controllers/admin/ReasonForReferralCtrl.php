<?php

namespace App\Http\Controllers\admin;

use App\ReasonForReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ReasonForReferralCtrl extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function view(){
        $reasons = ReasonForReferral::OrderBy('reason', 'asc')->paginate(20);
        return view('admin/reason_referral.reason_referral',[
            'title' => 'Reasons for Referral',
            "reasons" => $reasons
        ]);
    }

    public function addNew(Request $request){
        if(isset($request->reason)){
            $res = new ReasonForReferral();
            $res->reason = $request->reason;
            $res->save();    
        }
        return Redirect::action('admin\ReasonForReferralCtrl@view')->with('notif', 'Reason successfully added!');
    }

    public function showUpdateModal(Request $request){
        $reason = ReasonForReferral::find($request->reason_id);
        return view('admin/reason_referral.update_reason',[
            "reason" => $reason
        ]);
    }

    public function update(Request $request){
        ReasonForReferral::where('id', $request->id)
                ->update(['reason' => $request->reason]);
        return Redirect::action('admin\ReasonForReferralCtrl@view')->with('notif', 'Reason successfully updated!');
    }

    public function delete(Request $request){
        ReasonForReferral::where('id','=', $request->id_delete)->delete();
        return Redirect::action('admin\ReasonForReferralCtrl@view')->with('notif', 'Reason successfully deleted!');
    }

    public function search(Request $request){
        if(isset($request->keyword)){
            $keyword = $request->keyword;
            $reasons = ReasonForReferral::where('reason', 'like', '%'.$keyword.'%')->OrderBy('reason', 'asc')->paginate(20)->appends(["keyword" => $keyword]);
        }else{
            $reasons = ReasonForReferral::OrderBy('reason', 'asc')->paginate(20);   
        }
        return view('admin/reason_referral.reason_referral',[
            "reasons" => $reasons
        ]);
    }
}
