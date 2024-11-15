<?php

namespace App\Http\Controllers\Opcen;

use App\Barangay;
use App\ClientAddendum;
use App\Department;
use App\Facility;
use App\ItAddendum;
use App\ItCall;
use App\ItOfflineReason;
use App\Monitoring;
use App\Muncity;
use App\OpcenClient;
use App\Province;
use App\ReferenceNumber;
use App\RepeatCall;
use App\Tracking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

class OpcenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function opcenDashboard(){
        //for past 10 days
        $date_start = date('Y-m-d',strtotime(Carbon::now()->subDays(15))).' 00:00:00';
        $date_end = date('Y-m-d',strtotime(Carbon::now()->subDays(1))).' 23:59:59';
        $past_days = \DB::connection('mysql')->select("call opcen_past_report_call('$date_start','$date_end')");
        ///

        for($i=1; $i<=12; $i++)
        {
            $date = date('Y').'/'.$i.'/01';
            $startdate = Carbon::parse($date)->startOfMonth();
            $enddate = Carbon::parse($date)->endOfMonth();

            $new_call = OpcenClient::where("call_classification","new_call")
                ->whereBetween('time_started',[$startdate,$enddate])
                ->count();
            $data['new_call'][] = $new_call;

            $repeat_call = OpcenClient::where("call_classification","repeat_call")
                ->whereBetween('time_started',[$startdate,$enddate])
                ->count();
            $data['repeat_call'][] = $repeat_call;
        }

        $transaction_complete = OpcenClient::where("transaction_complete","!=",null)
            ->count();

        $transaction_incomplete = OpcenClient::where("transaction_incomplete","!=",null)
            ->count();

        $inquiry = OpcenClient::where("reason_calling","inquiry")
            ->count();

        $referral = OpcenClient::where("reason_calling","referral")
            ->count();

        $others = OpcenClient::where("reason_calling","others")
            ->count();

        $call_total = OpcenClient::count();
        $call_new = OpcenClient::where("call_classification","new_call")->count();
        $call_repeat = OpcenClient::where("call_classification","repeat_call")->count();
        $no_classification = OpcenClient::whereNull("call_classification")->count();

        return view('opcen.opcen',[
            "data" => $data,
            "transaction_complete" => $transaction_complete,
            "transaction_incomplete" => $transaction_incomplete,
            "inquiry" => $inquiry,
            "referral" => $referral,
            "others" => $others,
            "past_days" => $past_days,
            "call_total" => $call_total,
            "call_new" => $call_new,
            "call_repeat" => $call_repeat,
            "no_classification" => $no_classification
        ]);
    }

    public function opcenClient(Request $request){
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $search = $request->search;
        $client = OpcenClient::where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            });
        if($request->call_reason) {
            $client = $client->where("reason_calling",$request->call_reason);
        }
        $client = $client->whereBetween("time_started",[$date_start,$date_end])
            ->orderBy("time_started","desc");
        $client_call = $client->get();
        Session::put("client_call",$client_call);
        $client = $client->paginate(15);

        $call_total = OpcenClient::where(function($q) use ($search){
            $q->where('reference_number','like',"%$search%")
                ->orWhere('name','like',"%$search%");
            });
        if($request->call_reason) {
            $call_total = $call_total->where("reason_calling",$request->call_reason);
        }
        $call_total = $call_total->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $call_new = OpcenClient::where("call_classification","new_call")->where(function($q) use ($search){
            $q->where('reference_number','like',"%$search%")
                ->orWhere('name','like',"%$search%");
            });
        if($request->call_reason) {
            $call_new = $call_new->where("reason_calling",$request->call_reason);
        }
        $call_new = $call_new->whereBetween("time_started",[$date_start,$date_end])
        ->count();

        $call_repeat = OpcenClient::where("call_classification","repeat_call")->where(function($q) use ($search){
            $q->where('reference_number','like',"%$search%")
                ->orWhere('name','like',"%$search%");
            });
        if($request->call_reason) {
            $call_repeat = $call_repeat->where("reason_calling",$request->call_reason);
        }
        $call_repeat = $call_repeat->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $no_classification = OpcenClient::whereNull("call_classification")->where(function($q) use ($search){
            $q->where('reference_number','like',"%$search%")
                ->orWhere('name','like',"%$search%");
            });
        if($request->call_reason) {
            $no_classification = $no_classification->where("reason_calling",$request->call_reason);
        }
        $no_classification = $no_classification->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $call_inquiry = OpcenClient::where("reason_calling","inquiry")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $call_referral = OpcenClient::where("reason_calling","referral")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $call_others = OpcenClient::where("reason_calling","others")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $no_reason_for_calling = OpcenClient::whereNull("reason_calling")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $call_complete = OpcenClient::whereNotNull("transaction_complete")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $call_incomplete = OpcenClient::whereNotNull("transaction_incomplete")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        $no_transaction = OpcenClient::whereNull("transaction_complete")
            ->whereNull("transaction_incomplete")
            ->where(function($q) use ($search){
                $q->where('reference_number','like',"%$search%")
                    ->orWhere('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();


        return view('opcen.client',[
            "client" => $client,
            "search" =>$search,
            'date_range_start' => $date_start,
            'date_range_end' => $date_end,
            "call_total" => $call_total,
            "call_new" => $call_new,
            "call_repeat" => $call_repeat,
            "no_classification" => $no_classification,
            "call_inquiry" => $call_inquiry,
            "call_referral" => $call_referral,
            "call_others" => $call_others,
            "no_reason_for_calling" => $no_reason_for_calling,
            "call_complete" => $call_complete,
            "call_incomplete" => $call_incomplete,
            "no_transaction" => $no_transaction,
            "call_reason" => $request->call_reason
        ]);
    }

    public function bedAvailable(){
        return view('opcen.bed_available');
    }

    public function supplyReferenceNumber(){
        $encoded_by = Session::get('auth')->id;
        $reference_number = new ReferenceNumber();
        $reference_number->encoded_by = $encoded_by;
        $reference_number->save();
        return $reference_number->id;
    }

    public function newCall(){
        $province = Province::get();
        $facility = Facility::where("id","!=","63")->orderBy("name","asc")->get();
        Session::put("client",false); //from repeat call so that need to flush session
        return view('opcen.call',[
            "province" => $province,
            "facility" => $facility,
            "reference_number" => str_pad($this->supplyReferenceNumber(), 5, '0', STR_PAD_LEFT)
        ]);
    }

    public function repeatCall($client_id){
        $province = Province::get();
        $client = OpcenClient::find($client_id);
        $municipality = Muncity::where("province_id",$client->province_id)->get();
        $barangay = Barangay::where("muncity_id",$client->municipality_id)->get();
        $facility = Facility::where("id","!=","63")->orderBy("name","asc")->get();
        Session::put("client",$client);
        return view('opcen.call',[
            "province" => $province,
            "municipality" => $municipality,
            "barangay" => $barangay,
            "client" => $client,
            "facility" => $facility,
            "reference_number" => str_pad($this->supplyReferenceNumber(), 5, '0', STR_PAD_LEFT)
        ]);
    }

    public function reasonCalling($reason){
        return view('opcen.reason_calling',[
            "reason" => $reason,
        ]);
    }

    public function transactionComplete(){
        return view('opcen.transaction_complete');
    }

    public function transactionInComplete(){
        return view('opcen.transaction_incomplete');
    }

    public function availabilityAndService(){
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

    public function sendSMS(){
        // Your Account SID and Auth Token from twilio.com/console
        $account_sid = 'AC3cdea35db1d24c05750207bf434c46ea';
        $auth_token = '351ea813ced84cb56a2102d95df47ca6';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+19123485641";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
        // Where to send a text message (your cell phone?)
            '+639238309990',
            array(
                'from' => $twilio_number,
                'body' => "\n".date('m/d/Y H:i:s')."\nDaghang salamat sa pag tawag sa DOH HealthLine. Amping!"
            )
        );
    }

    public function onChangeProvince($province_id){
        return Muncity::select("id","description")->where("province_id","=",$province_id)->get();
    }

    public function onChangeMunicipality($municipality_id){
        return Barangay::select("id","description")->where("muncity_id","=",$municipality_id)->get();
    }

    public function transactionEnd(Request $request){
        $time_started = date("Y-m-d H:i:s",strtotime($request->time_started));
        $time_ended = date("Y-m-d H:i:s",strtotime($request->time_ended));
        $start_date = new DateTime($time_started);
        $duration_time = $start_date->diff(new DateTime($time_ended));
        $encoded_by = Session::get('auth')->id;

        $opcen_client = new OpcenClient();
        $opcen_client->reference_number = $request->reference_number;
        $opcen_client->encoded_by = $encoded_by;
        $opcen_client->call_classification = $request->call_classification;
        $opcen_client->reference_number = $request->reference_number;
        $opcen_client->name = $request->name;
        $opcen_client->company = $request->company;
        $opcen_client->age = $request->age;
        $opcen_client->sex = $request->sex;
        $opcen_client->region = $request->region;
        $opcen_client->province_id = $request->province_id;
        $opcen_client->municipality_id = $request->municipality_id;
        $opcen_client->barangay_id = $request->barangay_id;
        $opcen_client->sitio = $request->sitio;
        $opcen_client->contact_number = $request->contact_number;
        $opcen_client->relationship = $request->relationship;
        $opcen_client->reason_calling = $request->reason_calling;
        $opcen_client->reason_notes = $request->reason_notes;
        $opcen_client->reason_patient_data = $request->reason_patient_data;
        $opcen_client->reason_chief_complains = $request->reason_chief_complains;
        $opcen_client->reason_action_taken = $request->reason_action_taken;
        if($request->transaction_incomplete)
            $opcen_client->transaction_incomplete = $request->transaction_incomplete;
        else
            $opcen_client->transaction_complete = 'complete_call';
        $opcen_client->time_started = $time_started;
        $opcen_client->time_ended = $time_ended;
        $opcen_client->time_duration = $duration_time->h.':'.$duration_time->i.':'.$duration_time->s;
        $opcen_client->save();

        Session::put('opcen',true);
        return redirect('/opcen/client');
    }

    public function clientInfo($client_id){
        $client = OpcenClient::find($client_id);
        return view('opcen.client_info',[
            "client" => $client
        ]);
    }

    public function addendumBody(){
        return view('opcen.client_addendum');
    }

    public function addendumPost(Request $request){
        foreach($request->addendum as $addendum){
            $client_addendum = new ClientAddendum();
            $client_addendum->reference_number = $request->reference_number;
            $client_addendum->client_id = $request->client_id;
            $client_addendum->encoded_by = Session::get('auth')->id;
            $client_addendum->notes = $addendum;
            $client_addendum->save();
        }
        Session::put("addendum",true);
        return Redirect::back();
    }

    public function exportClientCall(){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=client_call.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $client = Session::get("client_call");
        return view('opcen.export_call',[
            "client" => $client
        ]);
    }


    public function itClient(Request $request){
        if(isset($request->date_range)){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfYear()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        $search = $request->search;
        $client = ItCall::where(function($q) use ($search){
                $q->where('name','like',"%$search%");
            });
        if($request->call_reason) {
            $client = $client->where("reason_calling",$request->call_reason);
        }
        $client = $client->whereBetween("time_started",[$date_start,$date_end])
            ->orderBy("time_started","desc");

        $client_call = $client->get();
        Session::put("it_call_excel",$client_call);
        $client = $client->paginate(15);

        $call_total = ItCall::where(function($q) use ($search){
                $q->where('name','like',"%$search%");
            })
            ->whereBetween("time_started",[$date_start,$date_end])
            ->count();

        return view('it.client',[
            "client" => $client,
            "search" =>$search,
            'date_range_start' => $date_start,
            'date_range_end' => $date_end,
            "call_total" => $call_total,
            "call_reason" => $request->call_reason
        ]);
    }

    public function itNewCall(){
        $province = Province::get();
        $facility = Facility::where("id","!=","63")->orderBy("name","asc")->get();
        $department = Department::get();
        Session::put("client",false); //from repeat call so that need to flush session
        return view('it.call',[
            "province" => $province,
            "facility" => $facility,
            "department" => $department
        ]);
    }

    public function itReasonCalling($reason){
        return view('it.reason_calling',[
            "reason" => $reason,
        ]);
    }

    public function itTransactionInComplete(){
        return view('it.transaction_incomplete');
    }

    public function itCallReasonSearch($patient_code,$reason){
        if(Tracking::where("code",$patient_code)->first()){
            $reason_action = Monitoring::where("code",$patient_code)->where("status",$reason)->orderBy("created_at","desc")->get();
            Session::put("it_reason_call",$reason_action);
        } else {
            return "not_found";
        }
    }

    public function itCallSaved(Request $request)
    {
        $encoded_by = Session::get('auth')->id;
        $time_started = date("Y-m-d H:i:s",strtotime($request->time_started));
        $time_ended = date("Y-m-d H:i:s",strtotime($request->time_ended));
        $start_date = new DateTime($time_started);
        $time_duration = $start_date->diff(new DateTime($time_ended));

        $it_call = new ItCall();
        $it_call->encoded_by = $encoded_by;
        $it_call->name = $request->name;
        $it_call->facility_id = $request->facility_id;
        $it_call->code = $request->patient_code;
        $it_call->department = $request->department;
        $it_call->designation = $request->designation;
        $it_call->contact_no = $request->contact_no;
        $it_call->email = $request->email;
        $it_call->type_call = $request->type_call;
        $it_call->call_classification = $request->call_classification;
        $it_call->reason_calling = $request->reason_calling;
        $it_call->reason_others = $request->reason_others;
        $it_call->notes = $request->notes;
        $it_call->action = $request->action;
        $it_call->transaction_complete = !$request->transaction_incomplete ? "Yes" : "";
        $it_call->transaction_incomplete = $request->transaction_incomplete ? $request->transaction_incomplete : "";
        $it_call->time_started = $time_started;
        $it_call->time_ended = $time_ended;
        $it_call->time_duration = $time_duration->h.':'.$time_duration->i.':'.$time_duration->s;
        $it_call->save();

        if(count($request->offline_reason) > 0 && $request->reason_calling == 'offline'){
            foreach($request->offline_reason as $offline_reason){
                $it_offline_reason = new ItOfflineReason();
                $it_offline_reason->encoded_by = $encoded_by;
                $it_offline_reason->it_call_id = $it_call->id;
                $it_offline_reason->remarks = $offline_reason;
                $it_offline_reason->save();
            }
        }
        elseif($request->reason_calling == 'walkin' || $request->reason_calling == 'issue'){
            $walkin = new Monitoring();
            $walkin->code = $request->patient_code;
            $walkin->remark_by = $encoded_by;
            $walkin->notes = $request->notes;
            $walkin->remarks = $request->action;
            $walkin->status = $request->reason_calling;
            $walkin->save();
        }

        Session::put('it_call',true);
        return Redirect::back();
    }

    public function itCallInfo($client_id){
        $client = ItCall::find($client_id);

        return view("it.client_info",[
            "client" => $client
        ]);
    }

    public function itAddendum(Request $request){
        foreach($request->addendum as $addendum){
            $client_addendum = new ItAddendum();
            $client_addendum->client_id = $request->client_id;
            $client_addendum->encoded_by = Session::get('auth')->id;
            $client_addendum->notes = $addendum;
            $client_addendum->save();
        }
        Session::put("it_addendum",true);
        return Redirect::back();
    }

    public function itRepeatCall($client_id){
        $client = ItCall::find($client_id);
        $facility = Facility::get();
        return view("it.call",[
            "client" => $client,
            "facility" => $facility
        ]);
    }

    public function exportItCall(){
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;filename=it_call.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $client = Session::get("it_call_excel");
        return view('it.export_call',[
            "client" => $client
        ]);
    }


}
