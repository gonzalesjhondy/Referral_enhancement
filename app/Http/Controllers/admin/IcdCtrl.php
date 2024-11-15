<?php

namespace App\Http\Controllers\admin;

use App\Icd10;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class IcdCtrl extends Controller
{
    public function view() {
        $icd = Icd10::OrderBy('code', 'asc')->paginate(50);
        return view('admin.icd.icd', [
            'title' => 'List of ICD Codes',
            "icd" => $icd
        ]);
    }

    public function add(Request $request) {
        if($request->add_btn) {
            $icd = new Icd10();
            $icd->code = $request->code;
            $icd->description = $request->description;
            $icd->group = $request->group;
            $icd->case_rate = $request->case_rate;
            $icd->professional_fee = $request->professional_fee;
            $icd->health_care_fee = $request->health_care_fee;
            $icd->source = $request->source;
            $icd->save();
            Session::put('icd_notif',true);
            Session::put('icd_msg','Successfully added!');
            return Redirect::action('admin\IcdCtrl@view');
        }else{
            return view('admin.icd.icd_add');
        }
    }

    public function update(Request $request) {
        $data = Icd10::find($request->icd_id);
        if($request->icd_update_btn) {
            $data_update = $request->all();
            unset($data_update['_token']);
            unset($data_update['icd_update_btn']);
            unset($data_update['icd_id']);
            $data->update($data_update);
            Session::put('icd_notif',true);
            Session::put('icd_msg','Successfully updated!');
            return Redirect::back();
        }
        return view('admin.icd.icd_update',[
            "data" => $data
        ]);
    }

    public function delete(Request $request) {
        Icd10::where('id', $request->id_delete)->delete();
        Session::put('icd_notif',true);
        Session::put('icd_msg','Successfully deleted!');
        return Redirect::action('admin\IcdCtrl@view');
    }

    public function search(Request $request) {
        if(isset($request->keyword)){
            $keyword = $request->keyword;
            $icd = Icd10::where('description', 'like', '%'.$keyword.'%')
                        ->orWhere('code', 'like', '%'.$keyword.'%')->OrderBy('code', 'asc')
                        ->paginate(50)->appends(["keyword" => $keyword]);
        }else{
            $icd = Icd10::OrderBy('code', 'asc')->paginate(50);   
        }
        return view('admin.icd.icd',[
            'title' => 'List of ICD Codes',
            "icd" => $icd
        ]);
    }

    public function checkIfExistICD(Request $request) {
        $icd = Icd10::where('code', $request->code)->first();
        if($icd)
            return ['exist' => 1, 'id' => $icd->id];

        return ['exist' => 0];
    }
}
