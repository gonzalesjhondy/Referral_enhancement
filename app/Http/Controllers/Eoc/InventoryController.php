<?php

namespace App\Http\Controllers\Eoc;

use App\Facility;
use App\Inventory;
use App\InventoryLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function insertInventory(){
        $facility = Facility::get();
        foreach($facility as $row){
            $facility_id = $row->id;
            $inventory = Inventory::where("facility_id",$facility_id)->first();
            if(!$inventory){
                $inventory = new Inventory();
                $inventory->facility_id = $facility_id;
                $inventory->name = "Regular Covid Beds";
                $inventory->capacity = 0;
                $inventory->occupied = 0;
                $inventory->available = 0;
                $inventory->status = 'Active';
                $inventory->save();

                $inventory = new Inventory();
                $inventory->facility_id = $facility_id;
                $inventory->name = "ICU Beds";
                $inventory->capacity = 0;
                $inventory->occupied = 0;
                $inventory->available = 0;
                $inventory->status = 'Active';
                $inventory->save();

                $inventory = new Inventory();
                $inventory->facility_id = $facility_id;
                $inventory->name = "Mechanical Ventilators";
                $inventory->capacity = 0;
                $inventory->occupied = 0;
                $inventory->available = 0;
                $inventory->status = 'Active';
                $inventory->save();

                $inventory = new Inventory();
                $inventory->facility_id = $facility_id;
                $inventory->name = "Dialysis Machines";
                $inventory->capacity = 0;
                $inventory->occupied = 0;
                $inventory->available = 0;
                $inventory->status = 'Active';
                $inventory->save();

                $inventory = new Inventory();
                $inventory->facility_id = $facility_id;
                $inventory->name = "Patients Waiting for Admission";
                $inventory->capacity = 0;
                $inventory->occupied = 0;
                $inventory->available = 0;
                $inventory->status = 'Active';
                $inventory->save();
            }
        }

        return 'success!';
    }

    public function Inventory($facility_id){
        $inventory = Inventory::where("facility_id",$facility_id)->get();

        return view('eoc.inventory',[
            "inventory" => $inventory,
            "facility_id" => $facility_id
        ]);
    }

    public function inventoryUpdatePage(Request $request){
        $inventory = Inventory::find($request->inventory_id);
        return view('eoc.inventory_update',[
            "inventory" => $inventory
        ]);
    }

    public function inventoryUpdateSave(Request $request){
        $inventory = Inventory::find($request->inventory_id);
        $inventory->capacity = $request->capacity;
        $inventory->occupied = $request->occupied;
        $inventory->save();

        $user = Session::get("auth");
        $inventory_logs = new InventoryLogs();
        $inventory_logs->facility_id = $user->facility_id;
        $inventory_logs->encoded_by = $user->id;
        $inventory_logs->inventory_id = $inventory->id;
        $inventory_logs->capacity = $request->capacity;
        $inventory_logs->occupied = $request->capacity;
        $inventory_logs->time_created = date('H:i:s');
        $inventory_logs->save();

        Session::put('inventory_update',true);
        return Redirect::back();
    }

    public function appendInventory($facility_id){
        $inventory = Inventory::where("facility_id",$facility_id)->get();
        return view("eoc.inventory_append",[
            "inventory" => $inventory,
            "facility_id" => $facility_id
        ]);
    }

}
