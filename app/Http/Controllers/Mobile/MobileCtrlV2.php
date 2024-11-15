<?php

namespace App\Http\Controllers\Mobile;

use App\Barangay;
use App\Facility;
use App\Http\Controllers\Controller;
use App\Icd10;
use App\Muncity;
use App\Province;
use App\ReasonForReferral;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MobileCtrlV2 extends Controller {

	public function loginAPI(Request $req){
		$user = User::where('username', $req->username)->first();
		if($user){
			if(Hash::check($req->password, $user->password)){
				$res = array(
						"code" => http_response_code(),
						"id" => $user->id,
						"username" => $user->username,
						"fullname" => $user->fname." ".$user->mname." ".$user->lname,
						"pin" => 0,
						"log" => 0
					);
			}else{
				$res = array(
					"code" => "###",
					"id" => null,
					"username" => null,
					"fullname" => null,
					"pin" => 0,
					"log" => 0
				);
			}
		}else{
			$res = array(
				"code" => "###",
				"id" => null,
				"username" => null,
				"fullname" => null,
				"pin" => 0,
				"log" => 0
			);
		}
		return $res;
    }

    public function latestFacilityAPI(Request $req){
    	$last_dl = $req->date;
    	if($last_dl == "0000-00-00 00:00:00"){
    		$facilities = Facility::join('province','province.id','=','facility.province')
    							->select('facility.id','facility.name','province.description as province', 'facility.status')->get();
    	}else{
    		$facilities = Facility::where("facility.updated_at",">=",$last_dl)
    							->join('province','province.id','=','facility.province')
    							->select('facility.id','facility.name','province.description as province', 'facility.status')->get();
    	}
    	return $facilities;
    }

    public function latestProvinceAPI(Request $req){
    	$last_dl = $req->date;
    	if($last_dl == "0000-00-00 00:00:00"){
    		$provinces = Province::select('id', 'description as name')->get();
    	}else{
    		$provinces = Province::where("updated_at",">=",$last_dl)
    							->select('id', 'description as name')->get();
    	}
    	return $provinces;
    }

    public function latestMuncityAPI(Request $req){
    	$last_dl = $req->date;
    	if($last_dl == "0000-00-00 00:00:00"){
    		$mun = Muncity::join('province','province.id','=','muncity.province_id')
    						->select('muncity.id', 'muncity.description as name', 'province.description as province')
    						->get();
    	}else{
    		$mun = Muncity::where("muncity.updated_at",">=",$last_dl)
    						->join('province','province.id','=','muncity.province_id')
    						->select('muncity.id', 'muncity.description as name', 'province.description as province')
    						->get();
    	}
    	return $mun;
    }

    public function latestBarangayAPI(Request $req){
    	$last_dl = $req->date;
    	if($last_dl == "0000-00-00 00:00:00"){
    		$bar = Barangay::join('province','province.id','=','barangay.province_id')
    						->join('muncity','muncity.id','=','barangay.muncity_id')
    						->select('barangay.id', 'barangay.description as name', 'muncity.description as municipality', 'province.description as province')->get();
    	}else{
    		$bar = Barangay::where("barangay.updated_at",">=",$last_dl)
    						->join('province','province.id','=','barangay.province_id')
    						->join('muncity','muncity.id','=','barangay.muncity_id')
    						->select('barangay.id', 'barangay.description as name', 'muncity.description as municipality', 'province.description as province')->get();
    	}
    	return $bar;
    }

    public function latestIcd10API(Request $req){
        $last_dl = $req->date;
        if($last_dl == "0000-00-00 00:00:00"){
            $icd = Icd10::
                    select('code', 'description', 'group', 'case_rate', 'professional_fee', 'health_care_fee', 'source')->get();
        }else{
            $icd = Icd10::where("updated_at",">=",$last_dl)
                    ->select('code', 'description', 'group', 'case_rate', 'professional_fee', 'health_care_fee', 'source')->get();
        }
        return $icd;
    }

    public function latestReasonForReferralAPI(Request $req){
        $last_dl = $req->date;
        if($last_dl == "0000-00-00 00:00:00"){
            $reason = ReasonForReferral::select('reason')->get();
        }else{
            $reason = ReasonForReferral::where("updated_at",">=",$last_dl)->select('reason')->get();
        }
        return $reason;
    }


}
