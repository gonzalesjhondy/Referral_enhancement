<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Facility;
use App\Muncity;
use App\Province;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LocationCtrl extends Controller
{
    function getBarangay($muncity_id)
    {
        $brgy = Barangay::where('muncity_id',$muncity_id)
            ->orderBy('description','asc')
            ->get();
        return $brgy;
    }

    function getMuncity($province_id)
    {
        $muncity = Muncity::where('province_id',$province_id)
            ->where(function($q){
                $q->where("vaccine_used","!=","Yes")
                    ->orWhereNull("vaccine_used");
            })
            ->orderBy('description','asc')
            ->get();
        return $muncity;
    }

    function getBarangay1($province_id,$muncity_id)
    {
        $brgy = Barangay::
            where("province_id",$province_id)
            ->where("muncity_id",$muncity_id)
            ->orderBy('description','asc')
            ->get();
        return $brgy;
    }


    static function facilityAddress($facility_id)
    {
        $data['address'] = 'N/A';
        $data['departments'] = array();

        $facility = Facility::select(
                'barangay.description as brgy',
                'muncity.description as muncity',
                'province.description as province',
                'facility.address'
            )
            ->leftJoin('barangay','barangay.id','=','facility.brgy')
            ->leftJoin('muncity','muncity.id','=','facility.muncity')
            ->leftJoin('province','province.id','=','facility.province')
            ->where('facility.id',$facility_id)
            ->first();

        $address = '';
        if(!$facility){
            return $data;
        }

        $address .= ($facility->address) ? $facility->address.', ':null;
        $address .= ($facility->brgy) ? $facility->brgy.', ':null;
        $address .= ($facility->muncity) ? $facility->muncity.', ':null;
        $address .= ($facility->province) ? $facility->province:null;

        $data['address'] = $address;
        $data['facility_id'] = $facility_id;

        $data['departments'] = User::select('department.id','department.description')
                ->leftJoin('department','department.id','=','users.department_id')
                ->where('users.department_id','!=',0)
                ->where('users.facility_id',$facility_id) //TODO: possible changes for multiple facility log-in
                ->groupBy('users.department_id')
                ->get();

        return $data;
    }

    static function getDepartmentByFacility($facility_id)
    {
        $departments = User::select('department.id','department.description')
            ->leftJoin('department','department.id','=','users.department_id')
            ->where('department.id','!=',null)
            ->where('users.facility_id',$facility_id) //TODO: possible changes for multiple facility log-in
            ->groupBy('users.department_id')
            ->get();

        return $departments;
    }

    static function getBrgyName($id)
    {
        $name = Barangay::find($id);
        if($name){
            return $name->description;
        }
        return 'N/A';
    }

    static function getMuncityName($id)
    {
        $name = Muncity::find($id);
        if($name){
            return $name->description;
        }
        return 'N/A';
    }

    static function getProvinceName($id)
    {
        $name = Province::find($id);
        if($name){
            return $name->description;
        }
        return 'N/A';
    }

    public function selectFacilityByProvince($province_id) {
        $facilities = Facility::select('id','name')
            ->where('status',1)
            ->where('referral_used','yes')
            ->where('province',$province_id)
            ->orderBy('name','asc')
            ->get();

        return $facilities;
    }
}
