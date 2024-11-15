<?php

namespace App\Http\Controllers\doctor;

use App\Activity;
use App\Baby;
use App\Barangay;
use App\Department;
use App\Events\AdminNotifs;
use App\Events\NewReferral;
use App\Events\NewWalkin;
use App\Facility;
use App\Http\Controllers\DeviceTokenCtrl;
use App\Http\Controllers\ParamCtrl;
use App\Icd;
use App\Icd10;
use App\Muncity;
use App\PatientForm;
use App\Patients;
use App\PregnantForm;
use App\Profile;
use App\Province;
use App\Tracking;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\ApiController;
use App\AppointmentSchedule;
use App\TelemedAssignDoctor;

class PatientCtrl extends Controller
{

    public $referred_patient_data;

    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('doctor');
    }

    public function searchProfile(Request $req)
    {
        $data = array(
            'keyword' => $req->keyword,
            'region' => $req->region,
            'province' => $req->province,
            'muncity' => $req->muncity,
            'brgy' => $req->brgy,
            'province_others' => $req->province_others,
            'muncity_others' => $req->muncity_others,
            'brgy_others' => $req->brgy_others,
            'telemedicine' => $req->telemedicine
        );
        Session::put('profileSearch', $data);
        return self::index();
    }

    public function index()
    {
        ParamCtrl::lastLogin();
        $session = Session::get('profileSearch');
        if (isset($session)) {
            $keyword = $session['keyword'];
            $reg = $session['region'];
            $prov = $session['province'];
            $mun = $session['muncity'];
            $brgy = $session['brgy'];
            $prov_others = $session['province_others'];
            $mun_others = $session['muncity_others'];
            $brgy_others = $session['brgy_others'];

            $tsekap = Profile::orderBy('lname', 'asc')
                ->where(function ($q) use ($keyword) {
                    $q->where('lname', "like", "%$keyword%")
                        ->orWhere('fname', 'like', "%$keyword%")
                        ->orwhere(DB::raw('concat(fname," ",lname)'), "like", "%$keyword%");
                })
                ->where('barangay_id', $brgy)
                ->where('muncity_id', $mun)
                ->get();

            foreach ($tsekap as $req) {
                $unique = array(
                    $req->fname,
                    $req->mname,
                    $req->lname,
                    date('Ymd', strtotime($req->dob)),
                    $req->barangay_id
                );
                $unique = implode($unique);

                $match = array('unique_id' => $unique);
                $data = array(
                    'phic_status' => ($req->phic_status) ? $req->phic_status : '',
                    'phic_id' => ($req->phicID) ? $req->phicID : '',
                    'fname' => ($req->fname) ? $req->fname : '',
                    'mname' => ($req->mname) ? $req->mname : '',
                    'lname' => ($req->lname) ? $req->lname : '',
                    'dob' => ($req->dob) ? $req->dob : '',
                    'sex' => ($req->sex) ? $req->sex : '',
                    'muncity' => ($req->muncity_id) ? $req->muncity_id : '',
                    'province' => ($req->province_id) ? $req->province_id : '',
                    'brgy' => ($req->barangay_id) ? $req->barangay_id : '',
                    'region' => "Region VII"
                );

                $pt = Patients::where('fname', $req->fname)->where('lname', $req->lname)->where('dob', $req->dob)->get();
                if (count($pt) == 0) {
                    Patients::updateOrCreate($match, $data);
                }
            }
        } else {
            $keyword = 'empty_data';
            $reg = 'empty_data';
            $prov = 'empty_data';
            $mun = 'empty_data';
            $brgy = 'empty_data';
            $prov_others = '';
            $mun_others = '';
            $brgy_others = '';
        }

        $source = 'referral';
        $data = Patients::where(function ($q) use ($keyword) {
            $q->where('lname', "like", "%" . $keyword . "%")
                ->orWhere('fname', 'like', "%" . $keyword . "%")
                ->orWhereRaw("concat(fname,' ',lname) like '%$keyword%'");
        })
            ->where('region', $reg)
            ->where('province', $prov)
            ->where('muncity', $mun)
            ->where('brgy', $brgy)
            ->orderBy('lname', 'asc');

        if ($prov_others) {
            $data = $data->where('province_others', $prov_others);
        }
        if ($mun_others) {
            $data = $data->where('muncity_others', $mun_others);
        }
        if ($brgy_others) {
            $data = $data->where('brgy_others', $brgy_others);
        }

         $data = $data->paginate(15);
         Session::put('telemed',  $session['telemedicine']);
         
        return view('doctor.patient', [
            'title' => 'Patient List',
            'data' => $data,
            'province' => Province::get(),
            'source' => $source,
            'telemedicine' => $session['telemedicine'],
        ]);
    }

    public function storePatient(Request $req)
    {
        $unique = array(
            $req->fname,
            $req->mname,
            $req->lname,
            date('Ymd', strtotime($req->dob)),
            $req->brgy
        );
        $unique = implode($unique);

        $match = array('unique_id' => $unique);
        $data = array(
            'phic_status' => $req->phic_status,
            'phic_id' => ($req->phicID) ? $req->phicID : '',
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'contact' => $req->contact,
            'dob' => $req->dob,
            'sex' => $req->sex,
            'civil_status' => $req->civil_status,
            'region' => $req->region,
            'province' => $req->province,
            'muncity' => $req->muncity,
            'brgy' => $req->brgy,
            'province_others' => $req->province_others,
            'muncity_others' => $req->muncity_others,
            'brgy_others' => $req->brgy_others
        );

        Patients::updateOrCreate($match, $data);

        $data = array(
            'keyword' => $req->fname . ' ' . $req->lname,
            'region' => $req->region,
            'province' => $req->province,
            'muncity' => $req->muncity,
            'brgy' => $req->brgy,
            'province_others' => $req->province_others,
            'muncity_others' => $req->muncity_others,
            'brgy_others' => $req->brgy_others
        );
        Session::put('profileSearch', $data);
        if ($req->from_consultation) {
            //return str_replace(' ', '', $unique).'&appointment='.$req->from_consultation;
            return redirect('doctor/patient?appointmentKey=' . $unique . '&appointment=' . urlencode(json_encode($req->from_consultation)));
        }

        return redirect('doctor/patient');
    }

    public function addPatient()
    {
        $session = Session::get('profileSearch');
        $province = Province::get();
        return view('doctor.patient_add', [
            'title' => 'Add New Patient',
            'province' => $province,
            'method' => 'store',
            'telemedAppointment' => $session['telemedicine'],
        ]);
    }

    public function updatePatient(Request $request)
    {
        $data = Patients::find($request->patient_id);

        if ($request->patient_update_button) {
            if ($request->region != 'Region VII') {
                $request->merge([
                    'province' => null,
                    'muncity' => null,
                    'brgy' => null
                ]);
            }

            $data_update = $request->all();
            $old_fname = $request->old_fname;
            $old_lname = $request->old_lname;
            $old_dob = $request->old_dob;
            unset($data_update['_token'], $data_update['old_fname'], $data_update['old_lname'], $data_update['old_dob']);
            unset($data_update['patient_update_button']);
            unset($data_update['patient_id']);

            $data->update($data_update);

            Session::put('patient_update_save', true);
            Session::put('patient_message', 'Successfully updated patient');

            if ($data->region == 'Region VII') { //tsekap update
                $pt = Profile::where('fname', $old_fname)
                    ->where('lname', $old_lname)
                    ->where('dob', $old_dob)
                    ->where('province_id', $request->province)
                    ->where('muncity_id', $request->muncity)
                    ->where('barangay_id', $request->brgy)
                    ->first();

                if ($pt) {
                    $pt->fname = $request->fname;
                    $pt->mname = $request->mname;
                    $pt->lname = $request->lname;
                    $pt->contact = $request->contact;
                    $pt->dob = $request->dob;
                    $pt->sex = $request->sex;
                    $pt->civil_status = $request->civil_status;
                    $pt->phicID = $request->phic_id;
                    $pt->muncity_id = $request->muncity;
                    $pt->barangay_id = $request->brgy;
                    $pt->save();
                }
            }

            $search_patient = array(
                'keyword' => $data->fname . ' ' . $data->lname,
                'region' => $data->region,
                'province' => $data->province,
                'muncity' => $data->muncity,
                'brgy' => $data->brgy,
                'province_others' => $data->province_others,
                'muncity_others' => $data->muncity_others,
                'brgy_others' => $data->brgy_others
            );
            Session::put('profileSearch', $search_patient); //seach patient so it still display in table
            return Redirect::back();
        }

        $province = Province::get();
        return view('doctor.patient_body', [
            "data" => $data,
            "province" => $province
        ]);
    }

    public function showPatientProfile($id)
    {
        $data = Patients::find($id);

        $brgy = Barangay::find($data->brgy)->description;
        $muncity = Muncity::find($data->muncity)->description;
        $province = Province::find($data->province)->description;

        if ($data->region == "Region VII")
            $data->address = "$data->region, $province, $muncity, $brgy";
        else
            $data->address = "$data->region, $data->province_others, $data->muncity_others, $data->brgy_others";

        $data->patient_name = "$data->fname $data->mname $data->lname";
        $data->age = ParamCtrl::getAge($data->dob);
        $data->ageType = "y";
        if ($data->age == 0) {
            $data->age = ParamCtrl::getMonths($data->dob);
            $data->ageType = "m";
        }
        return $data;
    }

    public function showTsekapProfile($id)
    {
        $data = Profile::find($id);
        if ($data->barangay_id) {
            $brgy = Barangay::find($data->barangay_id)->description;
            $muncity = Muncity::find($data->muncity_id)->description;
            $province = Province::find($data->province_id)->description;
            $data->address = "$brgy, $muncity, $province";
        } else {
            $data->address = 'N/A';
        }
        $data->patient_name = "$data->fname $data->mname $data->lname";
        $data->age = ParamCtrl::getAge($data->dob);
        $data->civil_status = 'Single';
        $data->phic_status = 'None';
        $data->phic_id = $data->phicID;
        return $data;
    }

    public function searchTsekap(Request $req)
    {
        $data = array(
            'keyword' => $req->keyword,
            'brgy' => $req->brgy,
            'muncity' => $req->muncity
        );
        Session::put('tsekapSearch', $data);
        return self::tsekap();
    }

    public function tsekap()
    {
        ParamCtrl::lastLogin();
        $keyword = '';
        $brgy = '';
        $mun = '';
        $session = Session::get('tsekapSearch');
        if (isset($session)) {
            $keyword = $session['keyword'];
            $brgy = $session['brgy'];
            $mun = $session['muncity'];
        }
        $user = Session::get('auth');
        $muncity = Muncity::where('province_id', $user->province)->orderby('description', 'asc')->get();

        $data = array();

        if (isset($keyword) && isset($brgy) && isset($mun)) {
            $data = Profile::orderBy('lname', 'asc');
            if (isset($brgy)) {
                $data = $data->where('barangay_id', $brgy);
            } else if (isset($mun)) {
                $data = $data->where('muncity_id', $mun);
            }

            $data = $data->where(function ($q) use ($keyword) {
                $q->where('lname', "$keyword")
                    ->orwhere(DB::raw('concat(fname," ",lname)'), "$keyword");
            });

            $data = $data->where('barangay_id', '>', 0)
                ->paginate(20);
        }

        return view('doctor.tsekap', [
            'title' => 'Patient List: Tsekap Profiles',
            'data' => $data,
            'muncity' => $muncity,
            'source' => 'tsekap',
            'sidebar' => 'tsekap_profile'
        ]);
    }

    public function addTracking($code, $patient_id, $user, $req, $type, $form_id, $status = '')
    {
        $match = array(
            'code' => $code
        );
        $track = array(
            'patient_id' => $patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'referred_from' => ($status == 'walkin') ? $req->referring_facility_walkin : $user->facility_id,
            'referred_to' => ($status == 'walkin') ? $user->facility_id : $req->referred_facility,
            'department_id' => $req->referred_department,
            'referring_md' => ($status == 'walkin') ? 0 : $user->id,
            'action_md' => '',
            'type' => $type,
            'form_id' => $form_id,
            'remarks' => ($req->reason) ? $req->reason : '',
            'status' => ($status == 'walkin') ? 'accepted' : 'referred',
            'walkin' => 'no',
            'telemedicine' => $req->telemedicine
        );

        if ($status == 'walkin') {
            $track['date_seen'] = date('Y-m-d H:i:s');
            $track['date_accepted'] = date('Y-m-d H:i:s');
            $track['action_md'] = $user->id;
            $track['walkin'] = 'yes';
        }

        $tracking = Tracking::updateOrCreate($match, $track);

        $activity = array(
            'code' => $code,
            'patient_id' => $patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'date_seen' => ($status == 'walkin') ? date('Y-m-d H:i:s') : '',
            'referred_from' => ($status == 'walkin') ? $req->referring_facility_walkin : $user->facility_id,
            'referred_to' => ($status == 'walkin') ? $user->facility_id : $req->referred_facility,
            'department_id' => $req->referred_department,
            'referring_md' => ($status == 'walkin') ? 0 : $user->id,
            'action_md' => '',
            'remarks' => ($req->reason) ? $req->reason : '',
            'status' => 'referred'
        );
        Activity::create($activity);

        if ($status == 'walkin') {
            $activity['date_seen'] = date('Y-m-d H:i:s');
            $activity['status'] = 'accepted';
            $activity['remarks'] = 'Walk-In Patient';
            $activity['action_md'] = $user->id;
            Activity::create($activity);
        }

        //start websocket
        $patient = Patients::find($patient_id);
        $redirect_track = asset("doctor/referred?referredCode=") . $code;
        $new_referral = [
            "patient_name" => ucfirst($patient->fname) . ' ' . ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname) . ' ' . ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find($req->referred_facility)->name,
            "referred_to" => (int) $req->referred_facility,
            "referred_department" => Department::find($req->referred_department)->description,
            "referred_from" => $user->facility_id,
            "form_type" => $type,
            "tracking_id" => $tracking->id,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $code,
            "status" => "referred",
            "count_reco" => 0,
            "redirect_track" => $redirect_track,
            "position" => 0 //default for first referred
        ];

        broadcast(new NewReferral($new_referral));
        //end websocket
    }

    public function referPatient(Request $req, $type)
    {
        $user = Session::get('auth');
        if ($req->telemedicine) {
            $telemedAssignDoctor = TelemedAssignDoctor::where('appointment_id', $req->appointmentId)->where('doctor_id', $req->doctorId)->first();
            if ($telemedAssignDoctor->appointment_by) {
                return 'consultation_rejected';
            }
            $telemedAssignDoctor->appointment_by = $user->id;
            $telemedAssignDoctor->save();
        }

        $patient_id = $req->patient_id;
        $user_code = str_pad($user->facility_id, 3, 0, STR_PAD_LEFT);
        $code = date('ymd') . '-' . $user_code . '-' . date('His') . "$user->facility_id" . "$user->id";
        $unique_id = "$patient_id-$user->facility_id-" . date('ymdHis');
        if ($type === 'normal') {
            Patients::where('id', $patient_id)
                ->update([
                    'sex' => $req->patient_sex,
                    'civil_status' => $req->civil_status,
                    'phic_status' => $req->phic_status,
                    'phic_id' => $req->phic_id
                ]);

            $data = array(
                'unique_id' => $unique_id,
                'code' => $code,
                'referring_facility' => $user->facility_id,
                'referred_to' => $req->referred_facility,
                'department_id' => $req->referred_department,
                'covid_number' => $req->covid_number,
                'refer_clinical_status' => $req->clinical_status,
                'refer_sur_category' => $req->sur_category,
                'time_referred' => date('Y-m-d H:i:s'),
                'time_transferred' => '',
                'patient_id' => $patient_id,
                'case_summary' => $req->case_summary,
                'reco_summary' => $req->reco_summary,
                'diagnosis' => $req->diagnosis,
                'referring_md' => $user->id,
                'referred_md' => ($req->reffered_md ? $req->reffered_md : ($req->reffered_md_telemed ? $req->reffered_md_telemed : '')),
                'reason_referral' => $req->reason_referral1,
                'other_reason_referral' => $req->other_reason_referral,
                'other_diagnoses' => $req->other_diagnosis,
            );

            $form = PatientForm::create($data);

            $file_paths = "";
            if ($_FILES["file_upload"]["name"]) {
                ApiController::fileUpload($req);
                for ($i = 0; $i < count($_FILES['file_upload']['name']); $i++) {
                    $file = $_FILES['file_upload']['name'][$i];
                    if (isset($file) && !empty($file)) {
                        $username = $user->username;
                        $file_paths .= ApiController::fileUploadUrl() . $username . "/" . $file;
                        if ($i + 1 != count($_FILES["file_upload"]["name"])) {
                            $file_paths .= "|";
                        }
                    }
                }
            }
            $form->file_path = $file_paths;
            $form->save();

            foreach ($req->icd_ids as $i) {
                $icd = new Icd();
                $icd->code = $form->code;
                $icd->icd_id = $i;
                $icd->save();
            }

            //if($req->referred_facility == 790 && $user->id == 1687) {
            if ($req->referred_facility == 790 || $req->referred_facility == 23) {
                $patient = Patients::find($patient_id);
                // $patient_name = isset($patient->mname[0]) ? ucfirst($patient->fname) . ' ' . strtoupper($patient->mname[0]) . '. ' . ucfirst($patient->lname) : ucfirst($patient->fname) . ' ' . ucfirst($patient->lname);
                $this->referred_patient_data = array(
                    "age" => (string) ParamCtrl::getAge($patient->dob),
                    "chiefComplaint" => $req->case_summary,
                    "department" => (string) Department::find($req->referred_department)->description,
                    "patient" => ucfirst($patient->fname).' '.ucfirst($patient->mname).''.ucfirst($patient->lname),
                    "sex" => (string) $patient->sex,
                    "referring_hospital" => (string) Facility::find($user->facility_id)->name,
                    "referred_to" => (string)$req->referred_facility,
                    "date_referred" => (string) $form->created_at,
                    "userid" => $user->id,
                    "patient_code" => $form->code
                );
                ApiController::notifierPushNotification($this->referred_patient_data);
            } //push notification for cebu south medical center

            session()->forget('profileSearch.telemedicine');
            self::addTracking($code, $patient_id, $user, $req, $type, $form->id, 'refer');
        } else if ($type === 'pregnant') {
            $baby = array(
                'fname' => ($req->baby_fname) ? $req->baby_fname : '',
                'mname' => ($req->baby_mname) ? $req->baby_mname : '',
                'lname' => ($req->baby_lname) ? $req->baby_lname : '',
                'dob' => ($req->baby_dob) ? $req->baby_dob : '',
                'civil_status' => 'Single'
            );
            $baby_id = self::storeBabyAsPatient($baby, $patient_id);

            $baby2 = Baby::updateOrCreate([
                'baby_id' => $baby_id,
                'mother_id' => $patient_id
            ], [
                'weight' => ($req->baby_weight) ? $req->baby_weight : '',
                'gestational_age' => ($req->baby_gestational_age) ? $req->baby_gestational_age : ''
            ]);

            $baby2->birth_date = ($req->baby_dob) ? $req->baby_dob : '';
            $baby2->save();

            $data = array(
                'unique_id' => $unique_id,
                'code' => $code,
                'referring_facility' => ($user->facility_id) ? $user->facility_id : '',
                'referred_by' => ($user->id) ? $user->id : '',
                'record_no' => ($req->record_no) ? $req->record_no : '',
                'referred_date' => date('Y-m-d H:i:s'),
                'referred_to' => ($req->referred_facility) ? $req->referred_facility : '',
                'department_id' => ($req->referred_department) ? $req->referred_department : '',
                'covid_number' => $req->covid_number,
                'refer_clinical_status' => $req->clinical_status,
                'refer_sur_category' => $req->sur_category,
                'health_worker' => ($req->health_worker) ? $req->health_worker : '',
                'patient_woman_id' => $patient_id,
                'woman_reason' => ($req->woman_reason) ? $req->woman_reason : '',
                'woman_major_findings' => ($req->woman_major_findings) ? $req->woman_major_findings : '',
                'woman_before_treatment' => ($req->woman_before_treatment) ? $req->woman_before_treatment : '',
                'woman_before_given_time' => ($req->woman_before_given_time) ? $req->woman_before_given_time : '',
                'woman_during_transport' => ($req->woman_during_treatment) ? $req->woman_during_treatment : '',
                'woman_transport_given_time' => ($req->woman_during_given_time) ? $req->woman_during_given_time : '',
                'woman_information_given' => ($req->woman_information_given) ? $req->woman_information_given : '',
                'patient_baby_id' => $baby_id,
                'baby_reason' => ($req->baby_reason) ? $req->baby_reason : '',
                'baby_major_findings' => ($req->baby_major_findings) ? $req->baby_major_findings : '',
                'baby_last_feed' => ($req->baby_last_feed) ? $req->baby_last_feed : '',
                'baby_before_treatment' => ($req->baby_before_treatment) ? $req->baby_before_treatment : '',
                'baby_before_given_time' => ($req->baby_before_given_time) ? $req->baby_before_given_time : '',
                'baby_during_transport' => ($req->baby_during_treatment) ? $req->baby_during_treatment : '',
                'baby_transport_given_time' => ($req->baby_during_given_time) ? $req->baby_during_given_time : '',
                'baby_information_given' => ($req->baby_information_given) ? $req->baby_information_given : '',
                'notes_diagnoses' => $req->notes_diagnosis,
                'reason_referral' => $req->reason_referral1,
                'other_reason_referral' => $req->other_reason_referral,
                'other_diagnoses' => $req->other_diagnosis,
            );
            $form = PregnantForm::create($data);

            $file_paths = "";

            if ($_FILES["file_upload"]["name"]) {
                ApiController::fileUpload($req);
                for ($i = 0; $i < count($_FILES["file_upload"]["name"]); $i++) {
                    $file = $_FILES['file_upload']['name'][$i];
                    if (isset($file) && !empty($file)) {
                        $username = $user->username;
                        $file_paths .= ApiController::fileUploadUrl() . $username . "/" . $file;
                        if ($i + 1 != count($_FILES["file_upload"]["name"])) {
                            $file_paths .= "|";
                        }
                    }
                }
            }
            $form->file_path = $file_paths;
            $form->save();

            foreach ($req->icd_ids as $i) {
                $icd = new Icd();
                $icd->code = $form->code;
                $icd->icd_id = $i;
                $icd->save();
            }

            //if($req->referred_facility == 790 && $user->id == 1687) {
            if ($req->referred_facility == 790 || $req->referred_facility == 23) {
                $patient = Patients::find($patient_id);
                // $patient_name = isset($patient->mname[0]) ? ucfirst($patient->fname) . ' ' . strtoupper($patient->mname[0]) . '. ' . ucfirst($patient->lname) : ucfirst($patient->fname) . ' ' . ucfirst($patient->lname);
                $this->referred_patient_data = array(
                    "age" =>(string) ParamCtrl::getAge($patient->dob),
                    "chiefComplaint" => $req->woman_major_findings,
                    "department" => (string) Department::find($req->referred_department)->description,
                    "patient" => ucfirst($patient->fname).' '.ucfirst($patient->mname).''.ucfirst($patient->lname),
                    "sex" => (string) $patient->sex,
                    "referring_hospital" => (string) Facility::find($user->facility_id)->name,
                    "referred_to" => (string)$req->referred_facility,
                    "date_referred" => (string) $form->created_at,
                    "userid" => $user->id,
                    "patient_code" => $form->code
                );
                
                ApiController::notifierPushNotification($this->referred_patient_data);

            } //push notification for cebu south medical center
            session()->forget('profileSearch.telemedicine');
            self::addTracking($code, $patient_id, $user, $req, $type, $form->id);
        }

        if ($req->referred_facility == 790 || $req->referred_facility == 23) {
            return $this->referred_patient_data;
        } else {
            Session::put("refer_patient", true);
        }
    }

    function referPatientWalkin(Request $req, $type)
    {
        $user = Session::get('auth');
        $patient_id = $req->patient_id;
        $user_code = str_pad($user->facility_id, 3, 0, STR_PAD_LEFT);
        $code = date('ymd') . '-' . $user_code . '-' . date('His');
        $tracking_id = 0;
        if ($req->source === 'tsekap') {
            $patient_id = self::importTsekap($req->patient_id, $req->patient_status, $req->phic_id, $req->phic_status);
        }

        $unique_id = "$patient_id-$user->facility_id-" . date('ymdH');
        $match = array(
            'unique_id' => $unique_id
        );

        $patient_code = "";

        if ($type === 'normal') {
            Patients::where('id', $patient_id)
                ->update([
                    'sex' => $req->patient_sex,
                    'civil_status' => $req->civil_status,
                    'phic_status' => $req->phic_status,
                    'phic_id' => $req->phic_id
                ]);

            $data = array(
                'referring_facility' => $req->referring_facility_walkin,
                'referred_to' => $user->facility_id,
                'department_id' => $req->referred_department,
                'time_referred' => date('Y-m-d H:i:s'),
                'time_transferred' => '',
                'patient_id' => $patient_id,
                'case_summary' => $req->case_summary,
                'reco_summary' => $req->reco_summary,
                'diagnosis' => $req->diagnosis,
                'referring_md' => 0,
                'referred_md' => ($req->referred_md) ? $req->referred_md : 0,
                'reason_referral' => $req->reason_referral1,
                'other_reason_referral' => $req->other_reason_referral,
                'other_diagnoses' => $req->other_diagnoses,
            );
            $form = PatientForm::updateOrCreate($match, $data);
            $patient_code = $form->code;

            foreach ($req->icd_ids as $i) {
                $icd = new Icd();
                $icd->code = $code;
                $icd->icd_id = $i;
                $icd->save();
            }

            if ($form->wasRecentlyCreated) {
                PatientForm::where('unique_id', $unique_id)
                    ->update([
                        'code' => $code
                    ]);
                $req->reffered_to = $user->facility_id;

                $tracking_id = self::addTracking($code, $patient_id, $user, $req, $type, $form->id, 'walkin');
            }
        } else if ($type === 'pregnant') {
            $baby = array(
                'fname' => ($req->baby_fname) ? $req->baby_fname : '',
                'mname' => ($req->baby_mname) ? $req->baby_mname : '',
                'lname' => ($req->baby_lname) ? $req->baby_lname : '',
                'dob' => ($req->baby_dob) ? $req->baby_dob : '',
                'civil_status' => 'Single'
            );

            $baby_id = self::storeBabyAsPatient($baby, $patient_id);

            $baby2 = Baby::updateOrCreate([
                'baby_id' => $baby_id,
                'mother_id' => $patient_id
            ], [
                'weight' => ($req->baby_weight) ? $req->baby_weight : '',
                'gestational_age' => ($req->baby_gestational_age) ? $req->baby_gestational_age : ''
            ]);

            $baby2->birth_date = ($req->baby_dob) ? $req->baby_dob : '';
            $baby2->save();

            $data = array(
                'referring_facility' => ($req->referring_facility_walkin) ? $req->referring_facility_walkin : '',
                'referred_by' => '',
                'record_no' => ($req->record_no) ? $req->record_no : '',
                'referred_date' => date('Y-m-d H:i:s'),
                'referred_to' => ($user->facility_id) ? $user->facility_id : '',
                'department_id' => ($req->referred_department) ? $req->referred_department : '',
                'health_worker' => ($req->health_worker) ? $req->health_worker : '',
                'patient_woman_id' => $patient_id,
                'woman_reason' => ($req->woman_reason) ? $req->woman_reason : '',
                'woman_major_findings' => ($req->woman_major_findings) ? $req->woman_major_findings : '',
                'woman_before_treatment' => ($req->woman_before_treatment) ? $req->woman_before_treatment : '',
                'woman_before_given_time' => ($req->woman_before_given_time) ? $req->woman_before_given_time : '',
                'woman_during_transport' => ($req->woman_during_treatment) ? $req->woman_during_treatment : '',
                'woman_transport_given_time' => ($req->woman_during_given_time) ? $req->woman_during_given_time : '',
                'woman_information_given' => ($req->woman_information_given) ? $req->woman_information_given : '',
                'patient_baby_id' => $baby_id,
                'baby_reason' => ($req->baby_reason) ? $req->baby_reason : '',
                'baby_major_findings' => ($req->baby_major_findings) ? $req->baby_major_findings : '',
                'baby_last_feed' => ($req->baby_last_feed) ? $req->baby_last_feed : '',
                'baby_before_treatment' => ($req->baby_before_treatment) ? $req->baby_before_treatment : '',
                'baby_before_given_time' => ($req->baby_before_given_time) ? $req->baby_before_given_time : '',
                'baby_during_transport' => ($req->baby_during_treatment) ? $req->baby_during_treatment : '',
                'baby_transport_given_time' => ($req->baby_during_given_time) ? $req->baby_during_given_time : '',
                'baby_information_given' => ($req->baby_information_given) ? $req->baby_information_given : '',
                'notes_diagnoses' => $req->notes_diagnosis,
                'reason_referral' => $req->reason_referral1,
                'other_reason_referral' => $req->other_reason_referral,
                'other_diagnoses' => $req->other_diagnosis,
            );
            $form = PregnantForm::updateOrCreate($match, $data);
            $patient_code = $form->code;

            foreach ($req->icd_ids as $i) {
                $icd = new Icd();
                $icd->code = $code;
                $icd->icd_id = $i;
                $icd->save();
            }

            if ($form->wasRecentlyCreated) {
                PregnantForm::where('unique_id', $unique_id)
                    ->update([
                        'code' => $code
                    ]);
                $tracking_id = self::addTracking($code, $patient_id, $user, $req, $type, $form->id, 'walkin');
            }
        }

        $pt_walkin = Patients::select('fname', 'lname')->where('id', $patient_id)->first();
        $referred_to = Facility::where('id', $form->referred_to)->first()->name;
        broadcast(new AdminNotifs([
            "patient_code" => $patient_code,
            "patient_name" => $pt_walkin->fname . " " . $pt_walkin->lname,
            "referred_to" => $referred_to,
            "date_referred" => date_format($form->updated_at, 'M d, Y h:i a'),
            "notif_type" => "new walkin"
        ]));

        return array(
            'id' => $tracking_id,
            'patient_code' => $code,
            'referred_date' => date('M d, Y h:i A')
        );
    }

    static function storeBabyAsPatient($data, $mother_id)
    {
        if ($data['fname']) {
            if ($data['mname'] == "")
                $data['mname'] = " ";

            $mother = Patients::find($mother_id);
            $data['brgy'] = $mother->brgy;
            $data['muncity'] = $mother->muncity;
            $data['province'] = $mother->province;
            $dob = date('ymd', strtotime($data['dob']));

            $tmp = array(
                $data['fname'],
                $data['mname'],
                $data['lname'],
                $data['brgy'],
                $dob
            );
            $unique = implode($tmp);
            $match = array(
                'unique_id' => $unique
            );

            $patient = Patients::updateOrCreate($match, $data);
            return $patient->id;
        } else {
            return '0';
        }
    }

    function importTsekap($patient_id, $civil_status = '', $phic_id = '', $phic_status = '')
    {
        $profile = Profile::find($patient_id);

        $unique = array(
            $profile->fname,
            $profile->mname,
            $profile->lname,
            date('Ymd', strtotime($profile->dob)),
            $profile->barangay_id
        );
        $unique = implode($unique);
        $match = array(
            'unique_id' => $unique
        );
        $data = array(
            'fname' => $profile->fname,
            'mname' => $profile->mname,
            'lname' => $profile->lname,
            'dob' => $profile->dob,
            'sex' => $profile->sex,
            'civil_status' => ($civil_status) ? $civil_status : 'N/A',
            'phic_id' => ($phic_id) ? $phic_id : 'N/A',
            'phic_status' => ($phic_status) ? $phic_status : 'N/A',
            'brgy' => $profile->barangay_id,
            'muncity' => $profile->muncity_id,
            'province' => $profile->province_id,
            'tsekap_patient' => 1
        );
        $patient = Patients::updateOrCreate($match, $data);
        return $patient->id;
    }

    function accepted(Request $request)
    {
        $user = Session::get('auth');
        $keyword = Session::get('keywordAccepted');
        $start = Session::get('startAcceptedDate');
        $end = Session::get('endAcceptedDate');

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
        } else {
            $start = \Carbon\Carbon::now()->startOfYear();
            $end = \Carbon\Carbon::now()->endOfYear();
        }


        $data = \DB::connection('mysql')->select("call AcceptedFunc('$user->facility_id','$start','$end','$keyword')");
        $patient_count = count($data);
        $data = $this->MyPagination($data, 15, $request);

        return view('doctor.accepted', [
            'title' => 'Accepted Patients',
            'data' => $data,
            'start' => $start,
            'end' => $end,
            'patient_count' => $patient_count
        ]);
    }

    public function MyPagination($list, $perPage, Request $request)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($list);

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return $paginatedItems;
    }

    function AcceptedJimmy()
    {
        $user = Session::get('auth');
        $keyword = Session::get('keywordAccepted');
        $start = Session::get('startAcceptedDate');
        $end = Session::get('endAcceptedDate');

        $data = Tracking::select(
            'tracking.id',
            'tracking.type',
            'tracking.code',
            'facility.name',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("DATE_FORMAT(tracking.date_accepted,'%M %d, %Y %h:%i %p') as date_accepted")
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->join('patients', 'patients.id', '=', 'tracking.patient_id')
            ->where('referred_to', $user->facility_id)
            ->where(function ($q) {
                $q->where('tracking.status', 'accepted')
                    ->orwhere('tracking.status', 'admitted')
                    ->orwhere('tracking.status', 'arrived');
            });
        if ($keyword) {
            $data = $data->where(function ($q) use ($keyword) {
                $q->where('patients.fname', 'like', "%$keyword%")
                    ->orwhere('patients.mname', 'like', "%$keyword%")
                    ->orwhere('patients.lname', 'like', "%$keyword%")
                    ->orwhere('tracking.code', 'like', "%$keyword%");
            });
        }

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $data = $data->whereBetween('tracking.date_accepted', [$start, $end]);
        }

        $data = $data->orderBy('tracking.date_accepted', 'desc')
            ->paginate(15);

        return view('doctor.accepted', [
            'title' => 'Accepted Patients',
            'data' => $data
        ]);
    }

    public function searchAccepted(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));

        $start = $range[0];
        $end = $range[1];

        Session::put('startAcceptedDate', $start);
        Session::put('endAcceptedDate', $end);
        Session::put('keywordAccepted', $req->keyword);

        return redirect('/doctor/accepted');
    }

    function getTrackingData($keyword, $start, $end, $status)
    {
        $user = Session::get('auth');
        $data = Tracking::select(
            'tracking.id',
            'tracking.type',
            'tracking.code',
            'facility.name',
            'tracking.status',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("DATE_FORMAT(tracking.updated_at,'%M %d, %Y %h:%i %p') as date_accepted")
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->join('patients', 'patients.id', '=', 'tracking.patient_id')
            ->where('tracking.referred_to', $user->facility_id);

        if ($keyword) {
            $data = $data->where(function ($q) use ($keyword) {
                $q->where('patients.fname', 'like', "%$keyword%")
                    ->orwhere('patients.mname', 'like', "%$keyword%")
                    ->orwhere('patients.lname', 'like', "%$keyword%")
                    ->orwhere('tracking.code', 'like', "%$keyword%");
            });
        }

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $data = $data
                ->leftJoin('activity', 'activity.code', '=', 'tracking.code')
                ->where(function ($q) use ($status) {
                    $q->where('activity.status', $status);
                })
                ->whereBetween('activity.date_referred', [$start, $end]);
        } else {
            $data = $data->where(function ($q) use ($status) {
                $q->where('tracking.status', $status);
            });
        }

        return $data;
    }

    function discharge()
    {
        $keyword = Session::get('keywordDischarged');
        $start = Session::get('startDischargedDate');
        $end = Session::get('endDischargedDate');

        $data = $this->getTrackingData($keyword, $start, $end, 'discharged');
        $data = $data->orderBy('tracking.updated_at', 'desc')
            ->paginate(15);

        return view('doctor.discharge', [
            'title' => 'Discharged Patients',
            'data' => $data
        ]);
    }

    public function searchDischarged(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));
        $tmp1 = explode('/', $range[0]);
        $tmp2 = explode('/', $range[1]);

        $start = $tmp1[2] . '-' . $tmp1[0] . '-' . $tmp1[1];
        $end = $tmp2[2] . '-' . $tmp2[0] . '-' . $tmp2[1];

        Session::put('startDischargedDate', $start);
        Session::put('endDischargedDate', $end);
        Session::put('keywordDischarged', $req->keyword);

        return redirect('/doctor/discharge');
    }

    public function transferred(Request $req)
    {
        $keyword = Session::get('keywordTransferred');
        $start = Session::get('startTransferredDate');
        $end = Session::get('endTransferredDate');

        $data = $this->getTrackingData($keyword, $start, $end, 'transferred');
        $data = $data->orderBy('tracking.updated_at', 'desc')
            ->paginate(15);

        return view('doctor.transferred', [
            'title' => 'Transferred Patients',
            'data' => $data
        ]);
    }

    public function searchTransferred(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));
        $tmp1 = explode('/', $range[0]);
        $tmp2 = explode('/', $range[1]);

        $start = $tmp1[2] . '-' . $tmp1[0] . '-' . $tmp1[1];
        $end = $tmp2[2] . '-' . $tmp2[0] . '-' . $tmp2[1];

        Session::put('startTransferredDate', $start);
        Session::put('endTransferredDate', $end);
        Session::put('keywordTransferred', $req->keyword);

        return redirect('/doctor/transferred');
    }

    public function redirectReco(Request $req)
    {
        $keyword = Session::get('keywordRedirectReco');
        $start = Session::get('startRedirectRecoDate');
        $end = Session::get('endRedirectRecoDate');
        $faci_filter = Session::get('faciRedirectReco');

        if (!$start) {
            $start = Carbon::now()->startOfYear()->format('m/d/Y');
            $end = Carbon::now()->endOfYear()->format('m/d/Y');
        }

        $user = Session::get('auth');
        $data = Tracking::select(
            'tracking.id',
            'tracking.type',
            'tracking.code',
            'facility.name',
            'tracking.status',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("DATE_FORMAT(tracking.updated_at,'%M %d, %Y %h:%i %p') as date_accepted")
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->join('patients', 'patients.id', '=', 'tracking.patient_id')
            ->where('tracking.referred_to', $user->facility_id)
            ->where('tracking.status', 'rejected');

        $facilities = Tracking::select(
            'facility.id',
            'facility.name'
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->where('tracking.referred_to', $user->facility_id)
            ->where('tracking.status', 'rejected')
            ->groupBy('facility.name')
            ->orderBy('facility.name', 'asc')
            ->get();

        if ($keyword) {
            $data = $data->where(function ($q) use ($keyword) {
                $q->where('patients.fname', 'like', "%$keyword%")
                    ->orwhere('patients.mname', 'like', "%$keyword%")
                    ->orwhere('patients.lname', 'like', "%$keyword%")
                    ->orwhere('tracking.code', 'like', "%$keyword%");
            });
        }

        if ($faci_filter) {
            $data = $data->where('tracking.referred_from', $faci_filter);
        }

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $data = $data
                ->whereBetween('tracking.updated_at', [$start, $end]);
        }

        $data = $data->orderBy('tracking.updated_at', 'desc')
            ->paginate(15);

        return view('doctor.redirect_reco', [
            'title' => 'Recommended to be Redirected Patients',
            'data' => $data,
            'facilities' => $facilities
        ]);
    }

    public function searchRedirectReco(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));
        $tmp1 = explode('/', $range[0]);
        $tmp2 = explode('/', $range[1]);

        $start = $tmp1[2] . '-' . $tmp1[0] . '-' . $tmp1[1];
        $end = $tmp2[2] . '-' . $tmp2[0] . '-' . $tmp2[1];

        $keyword = $req->keyword;
        $faci_filter = $req->faci_filter;
        if ($req->view_all) {
            $keyword = '';
            $faci_filter = '';
        }

        Session::put('startRedirectRecoDate', $start);
        Session::put('endRedirectRecoDate', $end);
        Session::put('keywordRedirectReco', $keyword);
        Session::put('faciRedirectReco', $faci_filter);

        return redirect('/doctor/redirect/reco');
    }

    function cancel()
    {
        $user = Session::get('auth');
        $keyword = Session::get('keywordCancelled');
        $start = Session::get('startCancelledDate');
        $end = Session::get('endCancelledDate');

        $data = Tracking::select(
            'tracking.id',
            'tracking.type',
            'tracking.code',
            'facility.name',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("DATE_FORMAT(tracking.updated_at,'%M %d, %Y %h:%i %p') as date_accepted")
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->join('patients', 'patients.id', '=', 'tracking.patient_id')
            ->where('referred_to', $user->facility_id)
            ->where('tracking.status', 'cancelled');

        if ($keyword) {
            $data = $data->where(function ($q) use ($keyword) {
                $q->where('patients.fname', 'like', "%$keyword%")
                    ->orwhere('patients.mname', 'like', "%$keyword%")
                    ->orwhere('patients.lname', 'like', "%$keyword%")
                    ->orwhere('tracking.code', 'like', "%$keyword%");
            });
        }

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $data = $data->whereBetween('tracking.updated_at', [$start, $end]);
        }

        $data = $data->orderBy('date_referred', 'asc')
            ->paginate(15);

        return view('doctor.cancel', [
            'title' => 'Cancelled Patients',
            'data' => $data
        ]);
    }

    public function searchCancelled(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));
        $tmp1 = explode('/', $range[0]);
        $tmp2 = explode('/', $range[1]);

        $start = $tmp1[2] . '-' . $tmp1[0] . '-' . $tmp1[1];
        $end = $tmp2[2] . '-' . $tmp2[0] . '-' . $tmp2[1];

        Session::put('startCancelledDate', $start);
        Session::put('endCancelledDate', $end);
        Session::put('keywordCancelled', $req->keyword);

        return redirect('/doctor/cancelled');
    }

    function archived()
    {
        $user = Session::get('auth');
        $keyword = Session::get('keywordArchived');
        $start = Session::get('startArchivedDate');
        $end = Session::get('endArchivedDate');

        $data = Tracking::select(
            'tracking.id',
            'tracking.type',
            'tracking.code',
            'facility.name',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("DATE_FORMAT(tracking.updated_at,'%M %d, %Y %h:%i %p') as date_accepted")
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->join('patients', 'patients.id', '=', 'tracking.patient_id')
            ->where('referred_to', $user->facility_id)
            ->where(function ($q) {
                $q->where('tracking.status', 'referred')
                    ->orwhere('tracking.status', 'seen')
                    ->orWhere('tracking.status', 'archived');
            })
            ->where(DB::raw("TIMESTAMPDIFF(MINUTE,tracking.date_referred,now())"), ">", 4320);

        if ($keyword) {
            $data = $data->where(function ($q) use ($keyword) {
                $q->where('patients.fname', 'like', "%$keyword%")
                    ->orwhere('patients.mname', 'like', "%$keyword%")
                    ->orwhere('patients.lname', 'like', "%$keyword%")
                    ->orwhere('tracking.code', 'like', "%$keyword%");
            });
        }

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $data = $data->whereBetween('tracking.updated_at', [$start, $end]);
        }

        Session::put("export_archived_excel", $data->get());
        $data = $data->orderBy('date_referred', 'desc')
            ->paginate(15);

        return view('doctor.archive', [
            'title' => 'Archived Patients',
            'data' => $data
        ]);
    }

    public function searchArchived(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));
        $tmp1 = explode('/', $range[0]);
        $tmp2 = explode('/', $range[1]);

        $start = $tmp1[2] . '-' . $tmp1[0] . '-' . $tmp1[1];
        $end = $tmp2[2] . '-' . $tmp2[0] . '-' . $tmp2[1];

        Session::put('startArchivedDate', $start);
        Session::put('endArchivedDate', $end);
        Session::put('keywordArchived', $req->keyword);

        return redirect('/doctor/archived');
    }

    function redirected()
    {
        $user = Session::get('auth');
        $keyword = Session::get('keywordRedirected');
        $start = Session::get('startRedirectedDate');
        $end = Session::get('endRedirectedDate');
        $faci_filter = Session::get('faciRedirected');

        $data = Tracking::select(
            'tracking.id',
            'tracking.type',
            'tracking.code',
            'facility.name',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("DATE_FORMAT(tracking.updated_at,'%M %d, %Y %h:%i %p') as date_accepted")
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->join('patients', 'patients.id', '=', 'tracking.patient_id')
            ->where('referred_to', $user->facility_id)
            ->where('tracking.status', 'redirected');

        $facilities = Tracking::select(
            'facility.id',
            'facility.name'
        )
            ->join('facility', 'facility.id', '=', 'tracking.referred_from')
            ->where('referred_to', $user->facility_id)
            ->where('tracking.status', 'redirected')
            ->groupBy('facility.name')
            ->orderBy('facility.name', 'asc')
            ->get();

        if ($keyword) {
            $data = $data->where(function ($q) use ($keyword) {
                $q->where('patients.fname', 'like', "%$keyword%")
                    ->orwhere('patients.mname', 'like', "%$keyword%")
                    ->orwhere('patients.lname', 'like', "%$keyword%")
                    ->orwhere('tracking.code', 'like', "%$keyword%");
            });
        }

        if ($faci_filter) {
            $data = $data->where('tracking.referred_from', $faci_filter);
        }

        if ($start && $end) {
            $start = Carbon::parse($start)->startOfDay();
            $end = Carbon::parse($end)->endOfDay();
            $data = $data->whereBetween('tracking.updated_at', [$start, $end]);
        }

        $data = $data->orderBy('date_referred', 'desc')
            ->paginate(15);

        return view('doctor.redirected', [
            'title' => 'Redirected Patients',
            'data' => $data,
            'facilities' => $facilities
        ]);
    }

    public function searchRedirected(Request $req)
    {
        $range = explode('-', str_replace(' ', '', $req->daterange));
        $tmp1 = explode('/', $range[0]);
        $tmp2 = explode('/', $range[1]);

        $start = $tmp1[2] . '-' . $tmp1[0] . '-' . $tmp1[1];
        $end = $tmp2[2] . '-' . $tmp2[0] . '-' . $tmp2[1];

        $keyword = $req->keyword;
        $faci_filter = $req->facility_filter;
        if ($req->view_all) {
            $keyword = '';
            $faci_filter = '';
        }

        Session::put('startRedirectedDate', $start);
        Session::put('endRedirectedDate', $end);
        Session::put('keywordRedirected', $keyword);
        Session::put('faciRedirected', $faci_filter);

        return redirect('/doctor/redirected');
    }

    static function getRedirectedDate($status, $code)
    {
        $date = Tracking::where('code', $code)
            ->where('status', $status)
            ->first();
        if ($date)
            $date = $date->updated_at;
        else
            return false;

        return date('F d, Y h:i A', strtotime($date));
    }

    static function getCancellationReason($status, $code)
    {
        $act = Activity::where('code', $code)
            ->where('status', $status)
            ->first();
        if ($act)
            return $act->remarks;
        return 'No Reason';
    }

    static function getDischargeDate($status, $code)
    {
        $date = Activity::where('code', $code)
            ->where('status', $status)
            ->first();
        if ($date)
            $date = $date->date_referred;
        else
            return false;

        return date('F d, Y h:i A', strtotime($date));
    }

    public function history($code)
    {
        Session::put('keywordDischarged', $code);
        return redirect('doctor/referred');
    }

    public function walkinPatient(Request $request)
    {
        $user = Session::get('auth');
        if (isset($request->date_range)) {
            $date_start = date('Y-m-d', strtotime(explode(' - ', $request->date_range)[0])) . ' 00:00:00';
            $date_end = date('Y-m-d', strtotime(explode(' - ', $request->date_range)[1])) . ' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfYear()->format('Y-m-d') . ' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d') . ' 23:59:59';
        }

        $walkin_patient = \DB::connection('mysql')->select("call walkin('$date_start','$date_end','$user->facility_id')");
        return view('doctor.walkin', [
            "walkin_patient" => $walkin_patient,
            "user_level" => $user->level,
            "date_start" => $date_start,
            "date_end" => $date_end
        ]);
    }
}
