<?php

namespace App\Http\Controllers\Eoc;

use App\Bed;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facility;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $facility = Facility::select("facility.*","province.description as province")
                            ->leftJoin("province","province.id","=","facility.province")
                            ->get();
        return view('eoc.home',[
            "data" => $facility
        ]);
    }

    public function bed($facility_id){
        $bed = Bed::where("facility_id",$facility_id)->get();
        return view('eoc.bed',[
            "facility_id" => $facility_id,
            "bed" => $bed
        ]);
    }

    public function bedAdd(Request $request){
        $bed = new Bed();
        $bed->encoded_by = Session::get("auth")->id;
        $bed->facility_id = $request->facility_id;
        $bed->name = $request->name;
        $bed->temporary = $request->temporary;
        $bed->allowable_no = $request->allowable;
        $bed->actual_no = $request->actual;
        $bed->status = 'Active';
        $bed->save();

        Session::put('bed',true);
        return Redirect::back();
    }

    public function EocCity(){
        $inventory = Inventory::select("inventory.*","facility.name as facility")
            ->leftJoin("facility","facility.id","=","inventory.facility_id")
            ->where("facility.province",2)
            ->where("facility.muncity",63)
            ->where("facility.name","not like","%RHU%")
            ->where("facility.name","not like","%department%")
            ->where("facility.name","not like","%referred%")
            ->orderBy("facility.name","asc")
            ->orderBy("inventory.name","asc")
            ->get();

        Session::put("inventory",$inventory);

        return view('eoc.eoc_city',[
            "inventory" => $inventory
        ]);
    }

    public function EocRegion(){
        $inventory = Inventory::select("inventory.*","facility.name as facility","facility.province as province","facility.id as facility_id")
            ->leftJoin("facility","facility.id","=","inventory.facility_id")
            ->where("facility.name","not like","%RHU%")
            ->where("facility.name","not like","%department%")
            ->where("facility.name","not like","%referred%")
            ->orderBy("facility.province","asc")
            ->orderBy("facility.name","asc")
            ->orderBy("inventory.name","asc")
            ->get();

        Session::put("inventory",$inventory);

        return view('eoc.eoc_region',[
            "inventory" => $inventory
        ]);
    }

    public function Graph(Request $request){
        if($request->isMethod('post') ){
            Session::put("graph",true);
            return Redirect::back();
        }

        $facility = Facility::where("facility.province",2)
            ->where("facility.muncity",63)
            ->where("facility.name","not like","%RHU%")
            ->where("facility.name","not like","%department%")
            ->where("facility.name","not like","%referred%")
            ->orderBy("facility.name","asc")
            ->get();
        return view("eoc.graph",[
            "facility" => $facility
        ]);
    }


}
