<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Baby;
use App\Barangay;
use App\BedTracker;
use App\Department;
use App\Events\NewReferral;
use App\Events\SocketReferralCall;
use App\Events\SocketReferralDischarged;
use App\Facility;
use App\Feedback;
use App\Http\Controllers\doctor\ReferralCtrl;
use App\Icd;
use App\Icd10;
use App\Issue;
use App\ModeTransportation;
use App\Muncity;
use App\PatientForm;
use App\Patients;
use App\PregnantForm;
use App\Profile;
use App\Province;
use App\Seen;
use App\Tracking;
use App\PrescribedPrescription;
use App\LabRequest;
use Illuminate\Http\Request;
use App\User;
use App\TelemedAssignDoctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Login;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Matrix\Exception;
use App\Events\SocketReco;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function testSocketReferred() {
        $user = User::find(25);
        $patient = Patients::find(5);
        $new_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find(24)->name,
            "referred_to" => 163,
            "referred_department" => Department::find(4)->description,
            "referred_from" => $user->facility,
            "form_type" => "pregnant",
            "tracking_id" => 1111,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => "220527-023-151044231016",
            "status" => "referred",
            "count_reco" => 0
        ];
        broadcast(new NewReferral($new_referral)); //websockets notification for new referral
    }

    public function patientExamined(Request $request) {
        if($request->username) //it means from mobile
            $user = User::where('username',$request->username)->first();
        else
            $user = Session::get('auth');

        $patient_form = null;
        $patient_id = 0;

        $tracking = Tracking::where("code",$request->code)->first();

        if($tracking->type == 'normal') {
            $patient_form = PatientForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_id;
        }
        else if($tracking->type == 'pregnant') {
            $patient_form = PregnantForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_woman_id;
        }

        if($patient_form) {
            $activity = array(
                'code' => $request->code,
                'patient_id' => $patient_id,
                'date_referred' => date('Y-m-d H:i:s'),
                'date_seen' => "0000-00-00 00:00:00",
                'referred_from' => $tracking->referred_from,
                'referred_to' => $tracking->referred_to,
                'department_id' => $tracking->department_id,
                'referring_md' => $tracking->referring_md,
                'action_md' => $user->id,
                'remarks' => 'patient examined',
                'status' => 'examined'
            );
            Activity::create($activity);

            $latest_activity = Activity::where("code",$tracking->code)->where(function($query) {
                $query->where("status","referred")
                    ->orWhere("status","redirected")
                    ->orWhere("status","transferred")
                    ->orWhere("status","followup");
            })
                ->orderBy("id","desc")
                ->first();

            $broadcast_examined = [
                "activity_id" => $latest_activity->id,
                "code" => $request->code,
                "referred_from" => $latest_activity->referred_from,
                "status" => "telemedicine",
                "telemedicine_status" => "examined"
            ];

            broadcast(new SocketReferralDischarged($broadcast_examined));

            $response =  "success";
        } else {
            $response = "failed";
        }

        if($request->username) { //it means from mobile
            if($response == 'success') {
                return [
                    "status_code" => 200,
                    "activity_id" => $latest_activity->id
                ];
            } else {
                return [
                    "status_code" => 204
                ];
            }
        } else {
            return $response;
        }
    }

    public function endorseUpward(Request $request) {
        if($request->username) //it means from mobile
            $user = User::where('username',$request->username)->first();
        else
            $user = Session::get('auth');

        $patient_form = null;
        $patient_id = 0;
        if($request->form_type == 'normal') {
            $patient_form = PatientForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_id;
        }
        else if($request->form_type == 'pregnant') {
            $patient_form = PregnantForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_woman_id;
        }
        if($patient_form) {
            $tracking = Tracking::where("code",$request->code)->first();
            $activity = array(
                'code' => $request->code,
                'patient_id' => $patient_id,
                'date_referred' => date('Y-m-d H:i:s'),
                'date_seen' => "0000-00-00 00:00:00",
                'referred_from' => $tracking->referred_from,
                'referred_to' => $tracking->referred_to,
                'department_id' => $tracking->department_id,
                'referring_md' => $tracking->referring_md,
                'action_md' => $user->id,
                'remarks' => 'patient endorse for an upward level of referral',
                'status' => 'upward'
            );
            Activity::create($activity);

            $latest_activity = Activity::where("code",$tracking->code)->where(function($query) {
                $query->where("status","referred")
                    ->orWhere("status","redirected")
                    ->orWhere("status","transferred")
                    ->orWhere("status","followup");
            })
                ->orderBy("id","desc")
                ->first();

            $broadcast_upward = [
                "activity_id" => $latest_activity->id,
                "code" => $request->code,
                "referred_from" => $latest_activity->referred_from,
                "status" => "telemedicine",
                "telemedicine_status" => "upward"
            ];

            broadcast(new SocketReferralDischarged($broadcast_upward));

            return "success";
        }
        return "failed";
    }

    public function callADoctor(Request $request) {
        $user = Session::get('auth');
        $doctorCaller = "Dr. ".$user->fname.' '.$user->lname;
        $call = [
            "tracking_id" => $request->tracking_id,
            "code" => $request->code,
            "action_md" => (int)$request->action_md,
            "referring_md" => (int)$request->referring_md,
            "trigger_by" => (int)$request->trigger_by,
            "status" => "telemedicine",
            "doctorCaller" => $doctorCaller,
            "form_type" => $request->form_type,
            "activity_id" => $request->activity_id,
            "referred_to" => (int)$request->referred_to
        ];
        broadcast(new SocketReferralDischarged($call));
    }

    public function checkPrescription(Request $request) {
        $prescriptionStatus = Activity::where("code", $request->code)
            ->whereIn("status", ['prescription', 'followup'])
            ->latest()
            ->first();
    
        if ($prescriptionStatus) {
            if ($prescriptionStatus->status === 'followup') {
                $latestPrescription = Activity::where("code", $request->code)
                    ->where("status", 'prescription')
                    ->latest()
                    ->first();
    
                if ($latestPrescription && $prescriptionStatus->id > $latestPrescription->id) {
                    return response()->json(['status' => 'failed', 'message' => 'No prescriptions found.']);
                }
            }
            $prescriptions = PrescribedPrescription::where("code", $request->code)
                ->where("prescribed_activity_id", $prescriptionStatus->id)
                ->get();
    
            if ($prescriptions->isNotEmpty()) {
                return response()->json(['status' => 'success', 'prescriptions' => $prescriptions]);
            }
        } 
        return response()->json(['status' => 'failed', 'message' => 'No prescriptions found.']);
    }
    
    //-----------------------------------------------------------
    // public function updatePrescription(Request $request) {
    //     //return $request->all();
    //     if($request->username) //it means from mobile
    //         $user = User::where('username',$request->username)->first();
    //     else
    //         $user = Session::get('auth');

    //     $patient_form = null;
    //     $patient_id = 0;
    //     if($request->form_type == 'normal') {
    //         $patient_form = PatientForm::where("code",$request->code)->first();
    //         $patient_id = $patient_form->patient_id;
    //     }
    //     else if($request->form_type == 'pregnant') {
    //         $patient_form = PregnantForm::where("code",$request->code)->first();
    //         $patient_id = $patient_form->patient_woman_id;
    //     }
    //     if($patient_form) {
    //         $activity_prescription = Activity::where("code",$request->code)->where("status","prescription")->where("id",">",$request->activity_id)->first();

    //         if($activity_prescription) {
    //             $activity_prescription->lab_result = $request->lab_result;
    //             $activity_prescription->dosage = $request->dosage;
    //             $activity_prescription->formulation = $request->formulation;
    //             $activity_prescription->brandname = $request->brandname;
    //             $activity_prescription->frequency = $request->frequency;
    //             $activity_prescription->duration = $request->duration;
    //             $activity_prescription->quantity = $request->quantity;
    //             $activity_prescription->save();
    //         } else {
    //             $tracking = Tracking::where("code",$request->code)->first();
    //             $activity = array(
    //                 'code' => $request->code,
    //                 'patient_id' => $patient_id,
    //                 'date_referred' => date('Y-m-d H:i:s'),
    //                 'date_seen' => "0000-00-00 00:00:00",
    //                 'referred_from' => $tracking->referred_from,
    //                 'referred_to' => $tracking->referred_to,
    //                 'department_id' => $tracking->department_id,
    //                 'referring_md' => $tracking->referring_md,
    //                 'action_md' => $user->id,
    //                 'lab_result' => $request->lab_result,
    //                 'dosage' => $request->dosage,
    //                 'formulation' => $request->formulation,
    //                 'brandname' => $request->brandname,
    //                 'frequency' => $request->frequency,
    //                 'duration' => $request->duration,
    //                 'quantity' => $request->quantity,
    //                 'status' => 'prescription'
    //             );
    //             Activity::create($activity); //new prescription in activity
    //         }

    //         $latest_activity = Activity::where("code",$tracking->code)->where(function($query) {
    //             $query->where("status","referred")
    //                 ->orWhere("status","redirected")
    //                 ->orWhere("status","transferred")
    //                 ->orWhere('status',"followup");
    //         })
    //             ->orderBy("id","desc")
    //             ->first();

    //         $broadcast_prescribed = [
    //             "activity_id" => $latest_activity->id,
    //             "code" => $request->code,
    //             "referred_from" => $latest_activity->referred_from,
    //             "status" => "telemedicine",
    //             "telemedicine_status" => "prescription"
    //         ];

    //         broadcast(new SocketReferralDischarged($broadcast_prescribed));

    //         $response =  "success";
    //     } else {
    //         $response = "failed";
    //     }

    //     if($request->username) { //it means from mobile
    //         if($response == 'success') {
    //             return [
    //                 "status_code" => 200
    //             ];
    //         } else {
    //             return [
    //                 "status_code" => 204
    //             ];
    //         }
    //     } else {
    //         return $response;
    //     }
    // }
    //-------------------------------------------------------------------
    
    public function getPrescriptions($code) {
        $statuses = Activity::where('code', $code)
            ->whereIn('status', ['followup', 'prescription'])
            ->latest()
            ->get();

        $followupStatus = $statuses->where('status', 'followup')->first();
        $prescriptionStatus = $statuses->where('status', 'prescription')->first();

        if ($prescriptionStatus && (!$followupStatus || $prescriptionStatus->id > $followupStatus->id)) {
            $prescriptions = PrescribedPrescription::where('code', $code)
                ->where('prescribed_activity_id', $prescriptionStatus->id)
                ->get();

            return response()->json(['prescriptions' => $prescriptions], 200);
        } else {
            return response()->json(['message' => 'Prescription activity not found'], 404);
        }   
    }

    private function saveSinglePrescription($singlePrescription, $request) {

        if(!empty($singlePrescription)) {
            if($request->username) //it means from mobile
                $user = User::where('username',$request->username)->first();
            else
                $user = Session::get('auth');

            $patient_form = null;
            $patient_id = 0;
                if($singlePrescription['form_type'] == 'normal') {
                    $patient_form = PatientForm::where("code",$singlePrescription['code'])->first();
                    $patient_id = $patient_form->patient_id;
                }
                else if($singlePrescription['form_type'] == 'pregnant') {
                    $patient_form = PregnantForm::where("code",$singlePrescription['code'])->first();
                    $patient_id = $patient_form->patient_woman_id;
                }

            $latestActivity = new Activity();
            $latestActivity->patient_id = $patient_id;
            $latestActivity->date_referred = $patient_form->time_referred;
            $latestActivity->date_seen = $patient_form->time_transferred;
            $latestActivity->referred_from = $patient_form->referring_facility;
            $latestActivity->referred_to = $patient_form->referred_to;
            $latestActivity->department_id = $patient_form->department_id;
            $latestActivity->referring_md = $patient_form->referring_md;
            $latestActivity->action_md = $patient_form->referred_md;
            $latestActivity->code = $singlePrescription['code'];
            $latestActivity->status = "prescription";
            $latestActivity->remarks = "prescription examined";
            $latestActivity->save();

            $prescribed_activity_id = $latestActivity->id;

            $prescribed = new PrescribedPrescription();
            $prescribed->prescribed_activity_id = $prescribed_activity_id;
            $prescribed->code = $latestActivity->code;
            $prescribed->generic_name = $singlePrescription['generic_name'];
            $prescribed->brandname = $singlePrescription['brandname'];
            $prescribed->dosage = $singlePrescription['dosage'];
            $prescribed->quantity = $singlePrescription['quantity'];
            $prescribed->formulation = $singlePrescription['formulation'];
            $prescribed->frequency = $singlePrescription['frequency'];
            $prescribed->duration = $singlePrescription['duration'];
            $prescribed->referred_from = $latestActivity->referred_from;
            $prescribed->referred_to = $latestActivity->referred_to;
            $prescribed->save();
        }

        //----------------------------------------------------- jondy added
        $latest_activity = Activity::where("code",$latestActivity->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred")
                ->orWhere('status',"followup");
        })
            ->orderBy("id","desc")
            ->first();

        $broadcast_prescribed = [
            "activity_id" => $latest_activity->id,
            "code" => $latestActivity->code,
            "referred_from" => $latest_activity->referred_from,
            "status" => "telemedicine",
            "telemedicine_status" => "prescription",
        ];
        broadcast(new SocketReferralDischarged($broadcast_prescribed)); 
        //-------------------------------------------------------jondy added
    }
    
    public function saveMultiPrescriptions($prescriptions, $request) {
        $latestActivity = Activity::where('status', 'prescription')->latest()->first();

        if (!$latestActivity) {
            $latestActivity = new Activity();
            $latestActivity->code = $prescriptions[0]['code'];
            $latestActivity->save();
        }
        $prescribed_activity_id = $latestActivity->id;

        foreach ($prescriptions as $prescriptionData) {

            $existingPrescription = PrescribedPrescription::where([
                'id' => $prescriptionData['id'],
                'prescribed_activity_id' => $prescribed_activity_id,
            ])->first();

            if ($existingPrescription) {
                $existingPrescription->update($prescriptionData);
            } else {
                $prescription = new PrescribedPrescription();
                $prescription->code = $latestActivity['code'];
                $prescription->prescribed_activity_id = $prescribed_activity_id;
                $prescription->generic_name = $prescriptionData['generic_name'];
                $prescription->brandname = $prescriptionData['brandname'];
                $prescription->dosage = $prescriptionData['dosage'];
                $prescription->quantity = $prescriptionData['quantity'];
                $prescription->formulation = $prescriptionData['formulation'];
                $prescription->frequency = $prescriptionData['frequency'];
                $prescription->duration = $prescriptionData['duration'];
                $prescription->referred_from = $latestActivity->referred_from;
                $prescription->referred_to = $latestActivity->referred_to;
                $prescription->save();
            }
        }

        //----------------------------------------------------- jondy added
        $latest_activity = Activity::where("code",$latestActivity->code)->where(function($query) {
            $query->where("status","referred")
                ->orWhere("status","redirected")
                ->orWhere("status","transferred")
                ->orWhere('status',"followup");
        })
            ->orderBy("id","desc")
            ->first();

        $broadcast_prescribed = [
            "activity_id" => $latest_activity->id,
            "code" => $latestActivity->code,
            "referred_from" => $latest_activity->referred_from,
            "status" => "telemedicine",
            "telemedicine_status" => "prescription",
        ];
        broadcast(new SocketReferralDischarged($broadcast_prescribed)); 
        //-------------------------------------------------------jondy added
    }

    public function savePrescriptions(Request $request) {
        $validatedData = $request->validate([
            'singlePrescription.generic_name' => 'required|string',
            'singlePrescription.brandname' => '',
            'singlePrescription.dosage' => 'required|string',
            'singlePrescription.quantity' => 'required|integer',
            'singlePrescription.formulation' => 'required|string',
            'singlePrescription.frequency' => 'required|string',
            'singlePrescription.duration' => 'required|string',
            'singlePrescription.code' => 'required|string',
            'singlePrescription.form_type' => 'required|string',
            'singlePrescription.prescribed_activity_id' => '',
            'singlePrescription.referred_from' => '',
            'singlePrescription.referred_to' => '',
            'multiplePrescriptions' => 'array',
        ]);

        $singlePrescription = $validatedData['singlePrescription'];
        $multiplePrescriptions = $validatedData['multiplePrescriptions'];

        $referredOrFollowup = Activity::where('code', $singlePrescription['code'])
            ->whereIn('status', ['referred', 'followup'])
            ->latest()
            ->first();

        $status = Activity::where('code', $singlePrescription['code'])
            ->where('status', ['examined', 'prescription'] )
            ->latest()
            ->first();

        if ($referredOrFollowup) {
            if ($referredOrFollowup->status == 'followup') {

                $activityExisting = Activity::where('code', $singlePrescription['code'])
                    ->where('status', 'prescription')
                    ->where('id', $singlePrescription['prescribed_activity_id'])
                    ->latest()
                    ->first();
    
                $existingFollowupPrescription = PrescribedPrescription::where('code', $singlePrescription['code'])
                    ->where('prescribed_activity_id', $activityExisting->id)
                    ->first();

                if ($status->status == 'examined' && $status->created_at > $status->status == 'prescription' && $status->created_at) {

                    if ($existingFollowupPrescription) {
                        $existingFollowupPrescription->fill($singlePrescription);
                        $existingFollowupPrescription->save();
                    } 
                    $this->saveMultiPrescriptions($multiplePrescriptions, $request);
                } 
                else {
                    if ($existingFollowupPrescription) {
                        $existingFollowupPrescription->fill($singlePrescription);
                        $existingFollowupPrescription->save();
                    } 
                    else {
                        $this->saveSinglePrescription($singlePrescription, $request);
                    }
                    $this->saveMultiPrescriptions($multiplePrescriptions, $request);
                }
            } 
            elseif($referredOrFollowup->status == 'referred') {

                $existingReferredPrescription = PrescribedPrescription::where('code', $singlePrescription['code'])
                ->first();

                if ($status->status == 'examined' && $status->created_at > $status->status == 'prescription' && $status->created_at) {
    
                    if ($existingReferredPrescription) {
                        $existingReferredPrescription->fill($singlePrescription);
                        $existingReferredPrescription->save(); 
                    } 
                    $this->saveMultiPrescriptions($multiplePrescriptions, $request);
                }
                else {
                    if ($existingReferredPrescription) {
                        $existingReferredPrescription->fill($singlePrescription);
                        $existingReferredPrescription->save();
                    } 
                    else {
                        $this->saveSinglePrescription($singlePrescription, $request);
                    }
                    $this->saveMultiPrescriptions($multiplePrescriptions, $request);
                }
            }  
        }
        //I comment this 
        // $latest_activity = Activity::where("code",$latestActivity->code)->where(function($query) {
        //     $query->where("status","referred")
        //         ->orWhere("status","redirected")
        //         ->orWhere("status","transferred")
        //         ->orWhere('status',"followup");
        // })
        //     ->orderBy("id","desc")
        //     ->first();

        // $broadcast_prescribed = [
        //     "activity_id" => $latest_activity->id,
        //     "code" => $latestActivity->code,
        //     "referred_from" => $latest_activity->referred_from,
        //     "status" => "telemedicine",
        //     "telemedicine_status" => "prescription",
        // ];
        // broadcast(new SocketReferralDischarged($broadcast_prescribed));    
    }

    public function deletePrescriptions($id) {
        try {
            $prescription = PrescribedPrescription::findOrFail($id);
            $prescription->delete();
            return response()->json(['message' => 'Prescription deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete prescription'], 500);
        }
    }

    public function patientTreated(Request $request) {
        $user = Session::get('auth');
        $patient_form = null;
        $patient_id = 0;

        $tracking = Tracking::where("code",$request->code)->first();

        if($tracking->type == 'normal') {
            $patient_form = PatientForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_id;
        }
        else if($tracking->type == 'pregnant') {
            $patient_form = PregnantForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_woman_id;
        }

        if($patient_form) {
            $activity = array(
                'code' => $request->code,
                'patient_id' => $patient_id,
                'date_referred' => date('Y-m-d H:i:s'),
                'date_seen' => "0000-00-00 00:00:00",
                'referred_from' => $tracking->referred_from,
                'referred_to' => $tracking->referred_to,
                'department_id' => $tracking->department_id,
                'referring_md' => $tracking->referring_md,
                'action_md' => $user->id,
                'remarks' => 'patient treated',
                'status' => 'treated'
            );
            Activity::create($activity);

            return "success";
        }
        return "failed";
    }

    public function getFacilityName($id)
    {
        //$facility_id = $request->facility_name_ID;
        // $facility = Facility::select('id', 'name')->where('id',  $id)->first();
        // $facilityId = $request->id
        $facility = Facility::find($id)->name;

        if ($facility) {
            return response()->json(['name' => $facility]);
        } else {
            return response()->json(['error' => 'Facility not found'], 404);
        }
    }

    public function patientFollowUp(Request $request) {
        $user = Session::get('auth');
        $patient_form = null;
        $patient_id = 0;
        
        $tracking = Tracking::where("code",$request->code)->first();
        $tracking->status = 'followup';
        $tracking->save();

        $telemedAssignDoctor = TelemedAssignDoctor::where('appointment_id', $request->Appointment_id)->where('doctor_id', $request->Doctor_id)->first();
        $telemedAssignDoctor->appointment_by = $user->id;
        $telemedAssignDoctor->save();

        if($tracking->type == 'normal') {
            $patient_form = PatientForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_id;
        }
        else if($tracking->type == 'pregnant') {
            $patient_form = PregnantForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_woman_id;
        }

        if($patient_form) {
            $activity = array(
                'code' => $request->code,
                'patient_id' => $patient_id,
                'date_referred' => date('Y-m-d H:i:s'),
                'date_seen' => "0000-00-00 00:00:00",
                'referred_from' => $tracking->referred_from,
                'referred_to' => $tracking->referred_to,
                'department_id' => $tracking->department_id,
                'referring_md' => $tracking->referring_md,
                'action_md' => $user->id,
                'remarks' => 'patient follow up',
                'status' => 'followup'
            );
            Activity::create($activity);
        }


        //  ---------------------jondy changes--------------------------->
        if ($request->hasFile('files')) {
            $uploadFiles = $request->file('files');
            $filePaths = [];
            $fileNames2 = [];
            foreach ($uploadFiles as $file) {
                $filepath = public_path() . '/fileupload/' . $user->username;
                $originalName = $file->getClientOriginalName();
                $counter = 1;
                while (file_exists($filepath . '/' . $originalName)) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                    $counter++;
                }
                $file->move($filepath, $originalName);// the pdf file will move here
                //$file->move($filepath, $originalName);
                $filePaths[] = $filepath . '/' . $originalName;
                $fileNames2[] = $originalName;
            }
            $activityFile = Activity::where('id', $request->followup_id)
                ->where('code', $request->code)
                ->orderby('id')
                ->first();
            json_encode($filePaths);
            $activityFile->lab_result = implode('|', $fileNames2);
            $activityFile->save();
            session()->flash('first_save'); 
        }
        //  -----------------------jondy changes------------------------->

        //start broadcast
        $patient = Patients::find($tracking->patient_id);
        $count_seen = Seen::where('tracking_id',$tracking->id)->count();
        $count_reco = Feedback::where("code",$tracking->code)->count();
        $redirect_track = asset("doctor/referred?referredCode=").$tracking->code;
        $position = Activity::where("code",$tracking->code)
            ->where(function($query) {
                $query->where("status","redirected")
                    ->orWhere("status","transferred")
                    ->orWhere("status","followup");
            })
            ->count();

        $new_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find($tracking->referred_to)->name,
            "referred_to" => (int)$tracking->referred_to,
            "referred_department" => Department::find($tracking->department_id)->description,
            "referred_from" => $user->facility_id,
            "form_type" => $tracking->type,
            "tracking_id" => $tracking->id,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $tracking->code,
            "status" => "followup",
            "count_seen" => $count_seen,
            "count_reco" => $count_reco,
            "redirect_track" => $redirect_track,
            "position" => $position
        ];
        broadcast(new NewReferral($new_referral)); //websockets notification for new referral
        //end broadcast

        return Redirect::route('doctor_referred');
    }


    // ----------------------I add this for controller of file upload update
    public function editpatientFollowUpFile(Request $request)
    {
        $user = Session::get('auth');
        $retrieveFiles = $request->selectedFileName;

        if ($request->hasFile('files')){
            $uploadFile = $request->file('files');
            $filepath = public_path() . '/fileupload/' . $user->username;
            $originalName = $uploadFile->getClientOriginalName();
                // Check if the file already exists, and rename if necessary
            $counter = 1;
                while (file_exists($filepath . '/' . $originalName)) {
                    $originalName = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $counter . '.' . $uploadFile->getClientOriginalExtension();
                    $counter++;
                }
              
            $activityFile = Activity::where('id', $request->referred_id)
                ->where('code', $request->code)
                ->orderby('id')
                ->first();
            $activity_followup = Activity::where('id', $request->followup_id)
                ->where('code', $request->code)
                ->orderby('id')
                ->first();
            $uploadFile->move($filepath, $originalName);
                if($request->position_count_number == 1){
                   
                    $genericNameArray = explode('|', $activityFile->lab_result);
                    $key = array_search($retrieveFiles, $genericNameArray);
                    
                    if($originalName !== $retrieveFiles){
                        unlink($filepath . '/' . $retrieveFiles);
                    }
        
                    if($key !== false) {
                        $genericNameArray[$key] = $originalName;
                    }
                    $activityFile->lab_result = implode('|', $genericNameArray);
                    $activityFile->save();
                    return response()->json(['filename' =>$activityFile->lab_result ]); // add this to access lab_request file
                }else if($request->position_count_number >= 2){
                    $genericNameArray = explode('|', $activity_followup->lab_result);
                    $key = array_search($retrieveFiles, $genericNameArray);

                    if($originalName !== $retrieveFiles){
                        unlink($filepath . '/' . $retrieveFiles);
                    }
                    if($key !== false) {
                        $genericNameArray[$key] = $originalName;
                    }
                    $activity_followup->lab_result = implode('|', $genericNameArray);
                    $activity_followup->save(); 
                    return response()->json(['filename' =>$activity_followup->lab_result ]);// add this to access lab_request file
                }
        }
         session()->flash('update_file', $request->position_count_number);
        return Redirect::back();
    }
    //---------------------------------Add files if empty or Add more files------------------------------->
    public function addpatientFollowUpFileIfEmpty(Request $request){
       
        $user = Session::get('auth');

        if ($request->hasFile('filesInput')) {

            $uploadFiles = $request->file('filesInput');

            $filePaths = [];
            $fileNames2 = [];
            foreach ($uploadFiles as $file) {
                $filepath = public_path() . '/fileupload/' . $user->username;
                $originalName = $file->getClientOriginalName();
                // Check if the file already exists, and rename if necessary
                $counter = 1;
                    while (file_exists($filepath . '/' . $originalName)) {
                        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                        $counter++;
                    }
           
                $file->move($filepath, $originalName);// the pdf file will move here
                $filePaths[] = $filepath . '/' . $originalName;
                $fileNames2[] = $originalName;
            }
            
            $referredFile = Activity::where('id', $request->referred_id)
                ->where('code', $request->code)
                ->orderby('id')
                ->first();
            
            $followupfile = Activity::where('id', $request->followup_id)
                ->where('code', $request->code)
                ->orderby('id')
                ->first();
          
           
            if(empty($request->filename)){
                if($request->position_count == 1){
                    json_encode($filePaths);
                    $referredFile->lab_result = implode('|', $fileNames2);
                    $referredFile->save();
                    return response()->json(['filename' => $referredFile->lab_result]);
                }else if($request->position_count >= 2){
                    json_decode($filepath);
                    $followupfile->lab_result = implode('|', $fileNames2);
                    $followupfile->save();
                    return response()->json(['filename' => $followupfile->lab_result ]);// add this to access lab_request file
                }

            }else{
                
                if($request->position_count == 1){
                    $genericname_array = explode('|', $referredFile->lab_result);
                    $genericname_array = array_merge($genericname_array, $fileNames2);
    
                    $referredFile->lab_result = implode('|', $genericname_array);
                    $referredFile->save();
                    return response()->json(['filename' => $referredFile->lab_result ]);
                }else if($request->position_count >= 2){
                    $genericname_array = explode('|', $followupfile->lab_result);
                    $genericname_array = array_merge($genericname_array, $fileNames2);
    
                    $followupfile->lab_result = implode('|', $genericname_array);
                    $followupfile->save();
                    return response()->json(['filename' => $followupfile->lab_result]);// add this to access lab_request file
                }
            }
        }          
        session()->flash('file_save', $request->position_count); 
        return redirect()->back();
    }

    public function deletepatientFollowUpFile(Request $request){
        $user = Session::get('auth');
        $selectedfile = $request->selectedFileName;
        $filepath = public_path() . '/fileupload/' . $user->username;
        
        $referred_activity = Activity::where('id', $request->referred_id)
            ->where('code', $request->code)
            ->first();
        $followup_activity = Activity::where('id', $request->followup_id)
            ->where('code', $request->code)
            ->first();

        if($request->position_counter == 1){
            $referredfile_array = explode('|', $referred_activity->lab_result);
            $key = array_search($selectedfile, $referredfile_array);
            
            if($key !== false){// Check if the selected file exists in the array
                unset($referredfile_array[$key]);

                unlink($filepath . '/' . $selectedfile);
            }

            $referred_activity->lab_result = implode('|', $referredfile_array);
            $referred_activity->save();
            return response()->json(['filename' => $referred_activity->lab_result]);
        }else if($request->position_counter >= 2){
            $followfile_array = explode('|', $followup_activity->lab_result);
            $key = array_search($selectedfile, $followfile_array);

            if($key !== false){
                unset($followfile_array[$key]);

                unlink($filepath . '/' . $selectedfile);
            }
            $followup_activity->lab_result = implode('|', $followfile_array);
            $followup_activity->save();
            return response()->json(['filename' => $followup_activity->lab_result ]);// add this to access lab_request file
        }

        session()->flash('delete_file', $request->position_counter);
        return Redirect::back();
    }

     //Multiple files can be deleted
    function deletemultipleFiles(Request $request){
        $files = $request->input('files');
        $code = $request->input('code');
        $baseUrl = $request->input('baseUrl');
        $actvity_id = $request->input('activity_id');
        $follow_id = $request->input('follow_id');
        $position = $request->input('position');
        
        $referred_Activity = Activity::where('id', $actvity_id)
            ->where('code', $code)
            ->first();
        
        $follow_Activity = Activity::where('id', $follow_id)
            ->where('code', $code)
            ->first();

        if($position == 1){
            $referredfile_array = explode('|', $referred_Activity->lab_result);
            
            foreach($files as $file){
                $key = array_search($file, $referredfile_array);

                if($key !== false){
                    unset($referredfile_array[$key]);

                    unlink($baseUrl . '/' . $file);
                }
            }
            $referred_Activity->lab_result = implode('|',$referredfile_array);
            $referred_Activity->save();
            return response()->json(['message' => $referred_Activity->lab_result]);
        }else if($position >= 2){
            $follow_array = explode('|', $follow_Activity->lab_result);
            foreach($files as $file){
                $key = array_search($file, $follow_array);

                if($key !== false){
                    unset($follow_array[$key]);
                    
                    unlink($baseUrl . '/' . $file);
                }
            }
            $follow_Activity->lab_result = implode('|', $follow_array);
            $follow_Activity->save();
            return response()->json(['message' => $follow_Activity->lab_result]);
        }
    }
    // ----------------------end of my changes jondy file upload------------------------->


    // ----------------------end of my changes jondy file upload------------------------->


    public function patientEndCycle(Request $request) {
        $user = Session::get('auth');
        $patient_form = null;
        $patient_id = 0;

        $tracking = Tracking::where("code",$request->code)->first();

        if($tracking->type == 'normal') {
            $patient_form = PatientForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_id;
        }
        else if($tracking->type == 'pregnant') {
            $patient_form = PregnantForm::where("code",$request->code)->first();
            $patient_id = $patient_form->patient_woman_id;
        }

        if($patient_form) {
            $activity = array(
                'code' => $request->code,
                'patient_id' => $patient_id,
                'date_referred' => date('Y-m-d H:i:s'),
                'date_seen' => "0000-00-00 00:00:00",
                'referred_from' => $tracking->referred_from,
                'referred_to' => $tracking->referred_to,
                'department_id' => $tracking->department_id,
                'referring_md' => $tracking->referring_md,
                'action_md' => $user->id,
                'remarks' => 'patient end cycle',
                'status' => 'end'
            );
            Activity::create($activity);

            return "success";
        }

        return "failed";
    }

    public function testSocketRedirected(Request $request) {
        $user = User::find(25);
        $patient = Patients::find(5);
        $count_activity = Activity::where("code",$request->code)
            ->where(function($query){
                $query->where("status","referred")
                    ->orWhere("status","redirected")
                    ->orWhere("status","transferred");
            })
            ->groupBy("code")
            ->count();
        $tracking = Tracking::where("code",$request->code)->first();
        $count_seen = Seen::where('tracking_id',$tracking->id)->count();
        $count_reco = Feedback::where("code",$request->code)->count();
        $new_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find(24)->name,
            "referred_to" => (int)163,
            "referred_department" => Department::find(4)->description,
            "referred_from" => $user->facility,
            "form_type" => "pregnant",
            "tracking_id" => $tracking->id,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $request->code,
            "status" => "redirected",
            "count_activity" => $count_activity,
            "count_seen" => $count_seen,
            "count_reco" => $count_reco
        ];
        broadcast(new NewReferral($new_referral)); //websockets notification for new referral
    }

    public function testSocketTransferred(Request $request) {
        $user = User::find(25);
        $patient = Patients::find(5);
        $count_activity = Activity::where("code",$request->code)
            ->where(function($query){
                $query->where("status","referred")
                    ->orWhere("status","redirected")
                    ->orWhere("status","transferred");
            })
            ->groupBy("code")
            ->count();
        $tracking = Tracking::where("code",$request->code)->first();
        $count_seen = Seen::where('tracking_id',$tracking->id)->count();
        $count_reco = Feedback::where("code",$request->code)->count();
        $new_referral = [
            "patient_name" => ucfirst($patient->fname).' '.ucfirst($patient->lname),
            "referring_md" => ucfirst($user->fname).' '.ucfirst($user->lname),
            "referring_name" => Facility::find($user->facility_id)->name,
            "referred_name" => Facility::find(163)->name,
            "referred_to" => (int)163,
            "referred_department" => Department::find(4)->description,
            "referred_from" => $user->facility,
            "form_type" => "pregnant",
            "tracking_id" => $tracking->id,
            "referred_date" => date('M d, Y h:i A'),
            "patient_sex" => $patient->sex,
            "age" => ParamCtrl::getAge($patient->dob),
            "patient_code" => $request->code,
            "status" => "transferred",
            "count_activity" => $count_activity,
            "count_seen" => $count_seen,
            "count_reco" => $count_reco
        ];
        broadcast(new NewReferral($new_referral)); //websockets notification for new referral
    }

    public function testSocketReco(Request $request) {
        $reco_json = $this->feedbackContent($request->code,$request->sender,$request->reciever,"The quick brown fox jumps over the lazy dog");
        broadcast(new SocketReco($reco_json));
    }

    public function feedbackContent($code,$sender,$receiver,$msg){
        $sender = User::find($sender);
        $user = User::find($receiver);

        $redirect_track = asset("doctor/referred?referredCode=").$code;

        $name_sender = ucwords(mb_strtolower($sender->fname))." ".ucwords(mb_strtolower($sender->lname));
        $date_now = date('d M h:i a');
        $picture_sender = url('resources/img/receiver.png');
        $feedback_receiver = "<div class='direct-chat-msg left'>
                                <div class='direct-chat-info clearfix'>
                                    <span class='direct-chat-name pull-left'>$name_sender</span>
                                    <span class='direct-chat-timestamp pull-right'>$date_now</span>
                                </div>
                                <img class='direct-chat-img' title='' src='$picture_sender' alt='Message User Image'>
                                <div class='direct-chat-text'>
                                    $msg
                                </div>
                            </div>";

        $feedback_count = Feedback::where("code",$code)->count();

        return [
            "code" => $code,
            "picture" => url('resources/img/ro7.png'),
            "content" => "<button class='btn btn-xs btn-info' onclick='viewReco($(this))' data-toggle='modal'
                               data-target='#feedbackModal'
                               data-code='$code'
                               >
                           <i class='fa fa-comments'></i> ReCo <span class='badge bg-blue' id='reco_count".$code."'>$feedback_count</span>
                       </button><a href='$redirect_track' class='btn btn-xs btn-warning' target='_blank'>
                                                <i class='fa fa-stethoscope'></i> Track
                                            </a>",
            "feedback_receiver" => $feedback_receiver,
            "feedback_count" => $feedback_count,
            "sender_facility" => $sender->facility_id,
            "user_facility" => $user->facility_id
        ];
    }

    public function checkCode($code, $facility_id) {
        $activity = Activity::where("code",$code)
            ->where(function($q) use($facility_id){
                $q->where("referred_from",$facility_id)->orWhere("referred_to",$facility_id);
            })
            ->first();
        return $activity ? json_encode(true) : json_encode(false);
    }

    public function api(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Activity::select("created_at")->orderBy("created_at","asc")->first()->created_at;
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        if($request->request_type=='facility'){
            return $this->getFacilities($request);
        }
        if($request->request_type == 'incoming' || $request->request_type == 'outgoing') {
            if($request->top){
                if($request->top == "denied"){
                    $top = "denied";
                    $request->top = "rejected";
                }
                else
                    $top = $request->top;

                $top_referred = $this->topReferral($request,$date_start,$date_end);
                $data = [];
                foreach($top_referred as $referred){
                    $data[] = [
                        "province" => Province::find($request->province)->description ? Province::find($request->province)->description  : "ALL",
                        "facility_name" => $referred->facility_name,
                        "request_type" => $request->request_type,
                        "date_range" => date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)),
                        "data" => [
                            $top => $referred->count
                        ]
                    ];
                }
                return $data;
            }

            $incoming = $this->apiReport($request,$date_start,$date_end);
            $data = [];

            foreach($incoming as $inc){
                $data[] = [
                    "province" => $inc->province,
                    "facility_id" => $inc->facility_id,
                    "facility_name" => $inc->name,
                    "hospital_type" => $inc->hospital_type,
                    "date_range" => date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)),
                    "data" => [
                        "referred" => $inc->referred,
                        "redirected" => $inc->redirected,
                        "transferred" => $inc->transferred,
                        "accepted" => $inc->accepted,
                        "denied" => $inc->denied,
                        "cancelled" => $inc->cancelled,
                        "seen_only" => $inc->seen_only,
                        "request_call" => $inc->request_call,
                        "not_seen" => $inc->not_seen,
                        "redirected_spam" => $inc->redirected_spam
                    ]
                ];

            }

            return $data;
        }

        elseif($request->request_type=="bed"){
            $beds = $this->apiBedAvailability($request);
            $data = [];
            foreach($beds as $bed){

                $encoded_by = BedTracker::
                select("bed_tracker.id","users.fname","users.mname","users.lname","bed_tracker.created_at")
                    ->leftJoin("users","users.id","=","bed_tracker.encoded_by")
                    ->where("bed_tracker.facility_id","=",$bed->id)
                    ->where("users.level","!=","opcen")
                    ->orderBy("bed_tracker.id","desc")
                    ->first();
                $created_at = $encoded_by->created_at;
                $encoded_by = ucfirst($encoded_by->fname).' '.strtoupper($encoded_by->mname[0]).'. '.ucfirst($encoded_by->lname);

                $data[] = [
                    "province" => Province::find($bed->province)->description,
                    "facility_name" => $bed->facility_name,
                    "hospital_type" => $bed->hospital_type,
                    "encoded_by" => $encoded_by,
                    "created_at" => $created_at,
                    "data" => [
                        [
                            "UnusedCovid" => $bed->UnusedCovid,
                            "UsedCovid" => $bed->UsedCovid,
                            "UnusedNoncovid" => $bed->UnusedNoncovid,
                            "UsedNoncovid" => $bed->UsedNoncovid
                        ]
                    ]
                ];
            }
            return $data;
        }
        else{
            return 'Error API';
        }
    }

    public function apiGetReport(Request $request){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Activity::select("created_at")->orderBy("created_at","asc")->first()->created_at;
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        if($request->request_type=='incoming' || $request->request_type=='outgoing'){
            if($request->top){
                if($request->top == "denied"){
                    $top = "denied";
                    $request->top = "rejected";
                }
                else
                    $top = $request->top;

                return $this->dataResponse($request,$date_start,$date_end,$top);
            }
        }
        elseif($request->request_type=="bed"){
            $beds = $this->apiReportBedAvailability($request);
            $data = [];
            foreach($beds as $bed){

                $encoded_by = BedTracker::
                select("bed_tracker.id","users.fname","users.mname","users.lname","bed_tracker.created_at")
                    ->leftJoin("users","users.id","=","bed_tracker.encoded_by")
                    ->where("bed_tracker.facility_id","=",$bed->id)
                    ->where("users.level","!=","opcen")
                    ->orderBy("bed_tracker.id","desc")
                    ->first();
                $created_at = $encoded_by->created_at;
                $encoded_by = ucfirst($encoded_by->fname).' '.strtoupper($encoded_by->mname[0]).'. '.ucfirst($encoded_by->lname);

                $data[] = [
                    "province" => Province::find($bed->province)->description,
                    "facility_name" => $bed->facility_name,
                    "hospital_type" => $bed->hospital_type,
                    "encoded_by" => $encoded_by,
                    "created_at" => $created_at,
                    "data" => [
                        [
                            "UnusedCovid" => $bed->UnusedCovid,
                            "UsedCovid" => $bed->UsedCovid,
                            "UnusedNoncovid" => $bed->UnusedNoncovid,
                            "UsedNoncovid" => $bed->UsedNoncovid
                        ]
                    ]
                ];
            }
            return $data;
        }
        else{
            return 'Error API';
        }
    }

    public function dataResponse($request,$date_start,$date_end,$top){
        $response = $this->reportReferral($request,$date_start,$date_end);
        $data = [];
        foreach($response as $row){
            $data[] = [
                "province" => Province::find($request->province)->description ? Province::find($request->province)->description  : "ALL",
                "facility_name" => $row->facility_name,
                "request_type" => $request->request_type,
                "date_range" => date("m/d/Y",strtotime($date_start)).' - '.date("m/d/Y",strtotime($date_end)),
                "data" => [
                    $top => $row->count
                ]
            ];
        }
        return $data;
    }

    public function individualList(Request $request){
        if(!$request->facility_id)
            return "NO FACILITY FILTERED";
        elseif(!$request->request_type)
            return "NO REQUEST TYPE FILTERED";

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

        if($request->status == 'denied')
            $request->status = 'rejected';

        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Activity::select("created_at")->orderBy("created_at","asc")->first()->created_at;
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }
        $data = \DB::connection('mysql')->select("call statistics_report_individual('$request->request_type','$request->facility_id','$date_start','$date_end','$request->status')");
        Session::put("statistics_report_individual",$data);
        Session::put("individual_status",$request->status);
        return $data;

        $data = Activity::select(
            "activity.code",
            DB::raw("concat(capitalize_name(pat.fname),' ',capitalize_name(pat.mname),'. ',capitalize_name(pat.lname)) as patient_name"),
            DB::raw("YEAR(CURRENT_TIMESTAMP) - YEAR(pat.dob) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(pat.dob, 5)) as age"),
            "fac_from.name as referring_facility",
            "fac_to.name as referred_facility",
            DB::raw("if(tra.type = 'normal',patient_f.diagnosis,pregnant_f.woman_major_findings) as diagnosis"),
            DB::raw("if(tra.type = 'normal',patient_f.reason,pregnant_f.woman_reason) as reason")
        )
            ->whereBetween("activity.date_referred",[$date_start,$date_end]);

        if($request->request_type == 'incoming')
            $data = $data->where("activity.referred_to",$request->facility_id);
        elseif($request->request_type == 'outgoing')
            $data = $data->where("activity.referred_from",$request->facility_id);
        else
            return 'ERROR API';

        $data = $data->leftJoin('tracking as tra','tra.code','=','activity.code')
            ->leftJoin('patients as pat','pat.id','=','activity.patient_id')
            ->leftJoin('patient_form as patient_f','patient_f.code','=','activity.code')
            ->leftJoin('pregnant_form as pregnant_f','pregnant_f.code','=','activity.code')
            ->leftJoin('facility as fac_from','fac_from.id','=','activity.referred_from')
            ->leftJoin('facility as fac_to','fac_to.id','=','activity.referred_to')
        ;

        if($request->status == 'cancelled')
            $data = $data->groupBy("activity.code");

        if($request->status == 'seen_only'){
            $data = $data->join("seen as see","see.code","=","activity.code")
                ->leftJoin("activity as act1",function($join){
                    $join->on("activity.code","=",'act1.code');
                    $join->on("activity.id",'<','act1.id');
                    $join->on('act1.referred_to','=','activity.referred_to');
                })
                ->where(function($query){
                    $query->where('activity.status','=','referred');
                    $query->orWhere('activity.status','=','redirected');
                    $query->orWhere('activity.status','=','transferred');
                })
                ->whereNull("act1.id")
                ->groupBy('activity.code');
        }
        else
            $data = $data->where("activity.status",$request->status);

        $data = $data->get();

        return $data;
    }

    public function exportIndividualList(){
        $status = Session::get("individual_status");
        $file_name = $status.".xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = Session::get("statistics_report_individual");
        return view('admin.report.export.individual',[
            "data" => $data,
            "status" => $status
        ]);
    }

    public function apiReport(Request $request,$date_start,$date_end){
        if($request->request_type == "incoming")
            return \DB::connection('mysql')->select("call statistics_report_incoming('$date_start','$date_end','$request->province_id','$request->facility_id','$request->muncity_id','$request->barangay_id','$request->hospital_type')");

        return \DB::connection('mysql')->select("call statistics_report_outgoing('$date_start','$date_end','$request->province_id','$request->facility_id','$request->muncity_id','$request->barangay_id','$request->hospital_type')");
    }

    public function apiBedAvailability(Request $request){
        $facility = Facility::
        select(
            "id",
            "province",
            "name as facility_name",
            "hospital_type",
            DB::raw("COALESCE(emergency_room_covid_vacant,0) + COALESCE(icu_covid_vacant,0) + COALESCE(beds_covid_vacant,0) + COALESCE(isolation_covid_vacant,0) AS UnusedCovid"),
            DB::raw("COALESCE(emergency_room_covid_occupied,0) + COALESCE(icu_covid_occupied,0) + COALESCE(beds_covid_occupied,0) + COALESCE(isolation_covid_occupied,0) AS UsedCovid"),
            DB::raw("COALESCE(emergency_room_non_vacant,0) + COALESCE(icu_non_vacant,0) + COALESCE(beds_non_vacant,0) + COALESCE(isolation_non_vacant,0) AS UnusedNoncovid"),
            DB::raw("COALESCE(emergency_room_non_occupied,0) + COALESCE(icu_non_occupied,0) + COALESCE(beds_non_occupied,0) + COALESCE(isolation_non_occupied,0) AS UsedNoncovid")
        )
            ->where(function($q){
                $q->where("hospital_type","government")->orWhere("hospital_type","private");
            })
            ->where("referral_used","yes");

        if($request->top == "most_bed")
            $facility->orderBy(DB::raw("COALESCE(emergency_room_covid_vacant,0) + COALESCE(icu_covid_vacant,0) + COALESCE(beds_covid_vacant,0) + COALESCE(isolation_covid_vacant,0) + COALESCE(emergency_room_covid_occupied,0) + COALESCE(icu_covid_occupied,0) + COALESCE(beds_covid_occupied,0) + COALESCE(isolation_covid_occupied,0)"),"desc")->limit(10);
        elseif($request->top == "least_bed"){
            $facility->orderBy(DB::raw("COALESCE(emergency_room_covid_vacant,0) + COALESCE(icu_covid_vacant,0) + COALESCE(beds_covid_vacant,0) + COALESCE(isolation_covid_vacant,0) + COALESCE(emergency_room_covid_occupied,0) + COALESCE(icu_covid_occupied,0) + COALESCE(beds_covid_occupied,0) + COALESCE(isolation_covid_occupied,0)"),"asc")->limit(10);
        }

        if($request->province)
            $facility = $facility->where("province",$request->province);

        $facility = $facility->get();

        return $facility;
    }

    public function apiReportBedAvailability(Request $request){
        $facility = Facility::
        select(
            "id",
            "province",
            "name as facility_name",
            "hospital_type",
            DB::raw("COALESCE(emergency_room_covid_vacant,0) + COALESCE(icu_covid_vacant,0) + COALESCE(beds_covid_vacant,0) + COALESCE(isolation_covid_vacant,0) AS UnusedCovid"),
            DB::raw("COALESCE(emergency_room_covid_occupied,0) + COALESCE(icu_covid_occupied,0) + COALESCE(beds_covid_occupied,0) + COALESCE(isolation_covid_occupied,0) AS UsedCovid"),
            DB::raw("COALESCE(emergency_room_non_vacant,0) + COALESCE(icu_non_vacant,0) + COALESCE(beds_non_vacant,0) + COALESCE(isolation_non_vacant,0) AS UnusedNoncovid"),
            DB::raw("COALESCE(emergency_room_non_occupied,0) + COALESCE(icu_non_occupied,0) + COALESCE(beds_non_occupied,0) + COALESCE(isolation_non_occupied,0) AS UsedNoncovid")
        )
            ->where(function($q){
                $q->where("hospital_type","government")->orWhere("hospital_type","private");
            })
            ->where("referral_used","yes");

        if($request->top == "most_bed")
            $facility->orderBy(DB::raw("COALESCE(emergency_room_covid_vacant,0) + COALESCE(icu_covid_vacant,0) + COALESCE(beds_covid_vacant,0) + COALESCE(isolation_covid_vacant,0) + COALESCE(emergency_room_covid_occupied,0) + COALESCE(icu_covid_occupied,0) + COALESCE(beds_covid_occupied,0) + COALESCE(isolation_covid_occupied,0)"),"desc");
        elseif($request->top == "least_bed"){
            $facility->orderBy(DB::raw("COALESCE(emergency_room_covid_vacant,0) + COALESCE(icu_covid_vacant,0) + COALESCE(beds_covid_vacant,0) + COALESCE(isolation_covid_vacant,0) + COALESCE(emergency_room_covid_occupied,0) + COALESCE(icu_covid_occupied,0) + COALESCE(beds_covid_occupied,0) + COALESCE(isolation_covid_occupied,0)"),"asc");
        }

        if($request->province)
            $facility = $facility->where("province",$request->province);

        $facility = $facility->get();

        return $facility;
    }

    public function getFacilities(Request $request){
        $facility = Facility::select("facility.id","facility.name as facility_name")->where("referral_used","yes")->orderBy("facility.name","asc");
        if($request->province)
            $facility = $facility->where("province",$request->province);

        $facility = $facility->get();
        return $facility;
    }

    public function topReferral($request,$date_start,$date_end){
        $data = \DB::connection('mysql')->select("call top_referral('$date_start','$date_end','$request->province','$request->top','$request->request_type')");
        return $data;
    }

    public function reportReferral($request,$date_start,$date_end){
        $data = \DB::connection('mysql')->select("call report_referral('$date_start','$date_end','$request->province','$request->top','$request->request_type')");
        return $data;
    }

    public function apiGetReferralList(Request $request){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

        if($request->date_range){
            $date_start = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[0])).' 00:00:00';
            $date_end = date('Y-m-d',strtotime(explode(' - ',$request->date_range)[1])).' 23:59:59';
        } else {
            $date_start = Carbon::now()->startOfMonth()->format('Y-m-d').' 00:00:00';
            $date_end = Carbon::now()->endOfMonth()->format('Y-m-d').' 23:59:59';
        }

        if(!$request->referring_facility && !$request->referred_facility)
            return "error API";

        $data = $data = \DB::connection('mysql')->select("call referral_list('$request->referring_facility','$request->referred_facility','$date_start','$date_end')");
        return $data;
    }

    public function apiGetReferralTrack(Request $request){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        $data = $data = \DB::connection('mysql')->select("call referral_track('$request->code')");
        return $data;
    }

    public function login(Request $req)
    {
        $user = $req->user;
        $pass = $req->pass;

        $login = User::
        select('users.*','facility.name as hospital','department.description as department')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->leftJoin('department','department.id','=','users.department_id')
            ->where('username','=',$user)
            ->first();
        if($login){
            if($login->status==='inactive'){
                return 'inactive';
            }else{
                if(Hash::check($pass,$login->password))
                {
                    $last_login = date('Y-m-d H:i:s');
                    User::where('id',$login->id)
                        ->update([
                            'last_login' => $last_login,
                            'login_status' => 'login'
                        ]);
                    $checkLastLogin = self::checkLastLogin($login->id);

                    if(!$checkLastLogin){
                        $l = new Login();
                        $l->userId = $login->id;
                        $l->login = $last_login;
                        $l->status = 'login';
                        $l->save();
                    }

                    if($checkLastLogin > 0 ){
                        Login::where('id',$checkLastLogin)
                            ->update([
                                'logout' => $last_login
                            ]);

                        $l = new Login();
                        $l->userId = $login->id;
                        $l->login = $last_login;
                        $l->status = 'login';
                        $l->save();
                    }
                    return array(
                        'name' => $login->fname.' '.$login->lname,
                        'department' => $login->department,
                        'hospital' => $login->hospital,
                        'facility_id' => $login->facility_id,
                        'level' => $login->level,
                        'status' => 'success'
                    );
                }
                else
                {
                    return array(
                        'status' => 'denied'
                    );
                }
            }
        }else{
            return array(
                'status' => 'denied'
            );
        }
    }

    public function checkLastLogin($id)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();
        $login = Login::where('userId',$id)
            ->whereBetween('login',[$start,$end])
            ->orderBy('id','desc')
            ->first();
        if($login && (!$login->logout>=$start && $login->logout<=$end)){
            return true;
        }

        if(!$login){
            return false;
        }

        return $login->id;
    }

    public function getActivity($offset,$limit,Request $request){
        if($request->count)
            return Activity::count();

        return Activity::skip($offset)->take($limit)->get();
    }
    public function getBaby(Request $request){
        if($request->count)
            return Baby::count();

        return Baby::get();
    }
    public function getBarangay(Request $request){
        if($request->count)
            return Barangay::count();

        return Barangay::get();
    }
    public function getDepartment(Request $request){
        if($request->count)
            return Department::count();

        return Department::get();
    }
    public function getFacility(Request $request){
        if($request->count)
            return Facility::count();

        return Facility::get();
    }
    public function getFeedback(Request $request){
        if($request->count)
            return Feedback::count();

        return Feedback::get();
    }
    public function getIcd10(Request $request){
        if($request->count)
            return Icd10::count();

        return Icd10::get();
    }
    public function getIssue(Request $request){
        if($request->count)
            return Issue::count();

        return Issue::get();
    }
    public function getLogin($offset,$limit,Request $request){
        if($request->count)
            return Login::count();

        return Login::skip($offset)->take($limit)->get();
    }
    public function getModeTransportation(Request $request){
        if($request->count)
            return ModeTransportation::count();

        return ModeTransportation::get();
    }
    public function getMuncity(Request $request){
        if($request->count)
            return Muncity::count();

        return Muncity::get();
    }
    public function getPatientForm($offset,$limit,Request $request){
        if($request->count)
            return PatientForm::count();

        return PatientForm::skip($offset)->take($limit)->get();
    }
    public function getPatients($offset,$limit,Request $request){
        if($request->count)
            return Patients::count();

        return Patients::skip($offset)->take($limit)->get();
    }
    public function getPregnantForm($offset,$limit,Request $request){
        if($request->count)
            return PregnantForm::count();

        return PregnantForm::skip($offset)->take($limit)->get();
    }
    public function getProvince(Request $request){
        if($request->count)
            return Province::count();

        return Province::get();
    }
    public function getSeen(Request $request){
        if($request->count)
            return Seen::count();

        return Seen::get();
    }
    public function getTracking($offset,$limit,Request $request){
        if($request->count)
            return Tracking::count();

        return Tracking::skip($offset)->take($limit)->get();
    }
    public function getUsers(Request $request){
        if($request->count)
            return User::count();

        return User::get();
    }

    public function telemedicineToPatient(Request $req){
        if(!$province = Province::where("province_code",$req->province)->first()->id)
            return 'Invalid Province Code';

        if(!$muncity = Muncity::where("muncity_code",$req->muncity)->first()->id)
            return 'Invalid Municipality Code';

        if(!$barangay = Barangay::where("barangay_code",$req->barangay)->first()->id)
            return 'Invalid Barangay Code';

        $unique = array(
            $req->fname,
            $req->mname,
            $req->lname,
            date('Ymd',strtotime($req->dob)),
            $barangay
        );
        $unique = implode($unique);

        if(!$patient = Profile::where("unique_id",$unique)->first())
            $patient = new Profile();

        $patient->unique_id = $unique;
        $patient->phicID = ($req->phicID) ? $req->phicID: '';
        $patient->fname = $req->fname;
        $patient->mname = $req->mname;
        $patient->lname = $req->lname;
        $patient->dob = $req->dob;
        $patient->sex = $req->sex;
        $patient->province_id = $province;
        $patient->muncity_id = $muncity;
        $patient->barangay_id = $barangay;
        $patient->dengvaxia = "telemedicine";
        $patient->save();

        if($patient->income == "1")
            $patient->income = "Less than 7,890";
        elseif($patient->income == "2")
            $patient->income = "Between 7,890 to 15,780";
        elseif($patient->income == "3")
            $patient->income = "Between 15,780 to 31,560";
        elseif($patient->income == "4")
            $patient->income = "Between 31,560 to 78,900";
        elseif($patient->income == "5")
            $patient->income = "Between 78,900 to 118,350";
        elseif($patient->income == "6")
            $patient->income = "Between 118,350 to 157,800";
        elseif($patient->income == "7")
            $patient->income = "At least 157,800";


        if($patient->unmet == "1")
            $patient->unmet = "Women of Reproductive Age who wants to limit/space but no access to Family Planning Method.";
        elseif($patient->unmet == "2")
            $patient->unmet = "Couples and individuals who are fecund and sexually active and report not wanting any more children or wanting to delay the next pregnancy but are not using any Family Planning Method.";
        elseif($patient->unmet == "3")
            $patient->unmet = "Currently using Family Planning Method but in inappropriate way thus leading to pregnancy.";

        if($patient->water == "1")
            $patient->water = "Farthest user is not more than 250m from point source";
        elseif($patient->water == "2")
            $patient->water = "Farthest user is not more than 25m from communal faucet";
        elseif($patient->water == "3")
            $patient->water = "It has service connection from system.";

        if($patient->toilet == "non")
            $patient->toilet = "Farthest user is not more than 250m from point source";
        elseif($patient->toilet == "comm")
            $patient->toilet = "Farthest user is not more than 25m from communal faucet";
        elseif($patient->toilet == "indi")
            $patient->toilet = "It has service connection from system.";

        if($patient->education == "non")
            $patient->education = "No Education";
        elseif($patient->education == "elem")
            $patient->education = "Elementary Level";
        elseif($patient->education == "elem_grad")
            $patient->education = "Elementary Graduate";
        elseif($patient->education == "high")
            $patient->education = "High School Level";
        elseif($patient->education == "high_grad")
            $patient->education = "High School Graduate";
        elseif($patient->education == "college")
            $patient->education = "College Level";
        elseif($patient->education == "college_grad")
            $patient->education = "College Graduate";
        elseif($patient->education == "vocational")
            $patient->education = "Vocational Course";
        elseif($patient->education == "master")
            $patient->education = "Masteral Degree";

        $patient->province_id = $req->province;
        $patient->muncity_id = $req->muncity;
        $patient->barangay_id = $req->barangay;
        $patient->dengvaxia = "no";
        return $patient;
    }

    public static function fileUploadUrl(){
        return 'http://180.232.110.32/';
    }

    public static function fileUpload(Request $request) {
        $username = Session::get('auth')->username;
        for($i = 0; $i < count(array_filter($_FILES["file_upload"]["tmp_name"])); $i++) {
            $filePath = $_FILES['file_upload']['tmp_name'][$i];
            if(!empty($filePath) && isset($filePath)) {
                $type=$_FILES['file_upload']['type'][$i];
                $fileName = $_FILES['file_upload']['name'][$i];

                $data = array(
                    'file_upload' => curl_file_create($filePath, $type, $fileName),
                    'username' => $username
                );

                //$url = self::fileUploadUrl().'file_upload.php';
                $url = 'https://fileupload.user.edgecloudph.com/file_upload.php';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_exec($ch);
                //Check for errors.
                if(curl_errno($ch)){
                    throw new Exception(curl_error($ch));
                }
                curl_close($ch);
            }
        }
    }

    public function apiReferPatient(Request $req)
    {

        if(!$province = Province::where("province_code","like","$req->province%")->first())
            return array(
                'code' => 227,
                'message' => 'Invalid Province Code. Province not found.'
            );

        if(!$muncity = Muncity::where("muncity_code",$req->muncity)->first())
            return array(
                'code' => 228,
                'message' => 'Invalid Municipality Code. Municipality not found.'
            );

        if(!$barangay = Barangay::where("barangay_code",$req->barangay)->first())
            return array(
                'code' => 229,
                'message' => 'Invalid Barangay Code. Barangay not found.'
            );

        if(!$referring_facility = Facility::where("facility_code",$req->referring_facility)->first())
            return array(
                'code' => 230,
                'message' => 'Invalid Referring Facility. Facility not found.'
            );

        if(!$referred_facility = Facility::where("facility_code",$req->referred_facility)->first())
            return array(
                'code' => 231,
                'message' => 'Invalid Referred Facility. Facility not found.'
            );


        $unique = array(
            $req->fname,
            $req->mname,
            $req->lname,
            date('Ymd',strtotime($req->dob)),
            $barangay->id
        );
        $unique = implode($unique);


        if(!$patient = Patients::where("unique_id",$unique)->first())
            $patient = new Patients();

        $patient->unique_id = $unique;
        $patient->phic_id = $req->phic_id;
        $patient->fname = $req->fname;
        $patient->mname = $req->mname;
        $patient->lname = $req->lname;
        $patient->contact = $req->contact;
        $patient->dob = $req->dob;
        $patient->sex = $req->sex;
        $patient->civil_status = $req->civil_status;
        $patient->muncity = $muncity->id;
        $patient->province = $province->id;
        $patient->brgy = $barangay->id;
        $patient->save();


        //referring doctor
        if(!$referring_doctor = User::where("fname",$req->referring_md_fname)->where("mname",$req->referring_md_mname)->where("lname",$req->referring_md_lname)->first())
            $referring_doctor = new User();

        $referring_doctor->fname = $req->referring_md_fname;
        $referring_doctor->mname = $req->referring_md_mname;
        $referring_doctor->lname = $req->referring_md_lname;
        $referring_doctor->level = 'doctor';
        $referring_doctor->facility_id = $referring_facility->id;
        $referring_doctor->status = 'active';
        $referring_doctor->contact = $req->referring_md_contact;
        $referring_doctor->email = "n/a";
        $referring_doctor->designation = "doctor";
        $referring_doctor->department_id = $req->department_id;
        $referring_doctor->username = "$req->referring_md_fname$req->referring_md_mname$req->referring_md_lname";
        $referring_doctor->password = bcrypt('123');
        $referring_doctor->muncity = $muncity->id;
        $referring_doctor->province = $province->id;
        $referring_doctor->save();


        if(!$referred_doctor = User::where("fname",$req->referred_md_fname)->where("mname",$req->referred_md_mname)->where("lname",$req->referred_md_lname)->first())
            $referred_doctor = new User();

        $referred_doctor->fname = $req->referred_md_fname;
        $referred_doctor->mname = $req->referred_md_mname;
        $referred_doctor->lname = $req->referred_md_lname;
        $referred_doctor->level = 'doctor';
        $referred_doctor->facility_id = $referred_facility->id;
        $referred_doctor->status = 'active';
        $referred_doctor->contact = $req->referred_md_contact;
        $referred_doctor->email = "n/a";
        $referred_doctor->designation = "doctor";
        $referred_doctor->department_id = $req->department_id;
        $referred_doctor->username = "$req->referred_md_fname$req->referred_md_mname$req->referred_md_lname";
        $referred_doctor->password = bcrypt('123');
        $referred_doctor->muncity = $muncity->id;
        $referred_doctor->province = $province->id;
        $referred_doctor->save();

        //refer patient
        $unique_id = "$patient->id-$referring_facility->id-".date('ymdHis');
        $user_code = str_pad($referring_facility->id,3,0,STR_PAD_LEFT);
        $code = date('ymd').'-'.$user_code.'-'.date('His');

        $data = array(
            'unique_id' => $unique_id,
            'code' => $code,
            'referring_facility' => $referring_facility->id,
            'referred_to' => $referred_facility->id,
            'department_id' => $req->department_id,
            'time_referred' => date('Y-m-d H:i:s'),
            'time_transferred' => '',
            'patient_id' => $patient->id,
            'case_summary' => $req->case_summary,
            'reco_summary' => $req->reco_summary,
            'diagnosis' => $req->diagnosis,
            'reason' => $req->reason,
            'referring_md' => $referring_doctor->id,
            'referred_md' => ($referred_doctor->id) ? $referred_doctor->id: 0,
            'covid_number' => $req->covid_number,
            'refer_clinical_status' => $req->clinical_status,
            'refer_sur_category' => $req->sur_category,
            'reason_referral' => $req->reason_referral1,
            'other_reason_referral' => $req->other_reason_referral,
            'other_diagnoses' => $req->other_diagnosis,
        );

        $form = PatientForm::create($data);

//        if($_FILES["file_upload"]["name"]) {
//            $req->username = $referring_doctor->username;
//            $file = $_FILES['file_upload']['name'];
//
//            self::fileUpload($req);
//            $form->file_path = self::fileUploadUrl().$req->username."/".$file;
//        }
        $file_paths = "";
        if($_FILES["file_upload"]["name"]) {
            $username = $referring_doctor->username;
            ApiController::fileUpload($req);
            for($i = 0; $i < count(array_filter($_FILES["file_upload"]["name"])); $i++) {
                $file = $_FILES['file_upload']['name'][$i];
                if(isset($file) && !empty($file)) {
                    $file_paths .= ApiController::fileUploadUrl().$username."/".$file;
                    if($i + 1 != count(array_filter($_FILES["file_upload"]["name"]))) {
                        $file_paths .= "|";
                    }
                }
            }
        }
        $form->file_path = $file_paths;

        $form->save();
        foreach($req->icd_code as $i) {
            if($icd10 = Icd10::where("code",$i)->first()) {
                $icd = new Icd();
                $icd->code = $form->code;
                $icd->icd_id = $icd10->id;
                $icd->save();
            }
        }
        $type = 'normal';
        $this->addTracking($code,$patient->id,$referring_doctor,$referred_doctor,$req,$type,$form->id,'refer');

        return array(
            'code' => http_response_code(),
            'message' => "Successfully referred patient!"
        );
    }

    function addTracking($code,$patient_id,$referring_doctor,$referred_doctor,$req,$type,$form_id,$status='')
    {
        $match = array(
            'code' => $code
        );
        $track = array(
            'patient_id' => $patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'referred_from' => $referring_doctor->facility_id,
            'referred_to' => $referred_doctor->facility_id,
            'department_id' => $referring_doctor->department_id,
            'referring_md' =>  $referring_doctor->id,
            'action_md' => '',
            'type' => $type,
            'form_id' => $form_id,
            'remarks' => ($req->reason) ? $req->reason: '',
            'status' => ($status=='walkin') ? 'accepted' : 'referred',
            'walkin' => 'no',
            'source' => $req->source
        );

        Tracking::updateOrCreate($match,$track);

        $activity = array(
            'code' => $code,
            'patient_id' => $patient_id,
            'date_referred' => date('Y-m-d H:i:s'),
            'date_seen' => '',
            'referred_from' => $referred_doctor->facility_id,
            'referred_to' => $referring_doctor->facility_id,
            'department_id' => $req->department_id,
            'referring_md' => $referring_doctor->id,
            'action_md' => '',
            'remarks' => ($req->reason) ? $req->reason: '',
            'status' => 'referred'
        );

        Activity::create($activity); //save the tracking

        $this->sendNotification($code,$referred_doctor->facility_id);
    }

    public function sendNotification($code,$referred_facility){
        /**
         * Server Key
         **/
        $SERVER_KEY = "AAAA4yHdicc:APA91bHLB-9vT2V6v3k6EjEXPIJ_OC70Lmd63ftlM3X3fEa1CgLYmCxoYLSIq4f0IULHDtG062jQ2cQ2Uy5hszVtSobwKc59dTZOzlNRV3NdjuIsNcax0UkKSjWwFKhN9VlO7V-rtuad";


        $url = 'https://fcm.googleapis.com/fcm/send';
        /**
         * Give title,body and other param in notification
         **/
        $messageAndroidIos                   = array();
        $messageAndroidIos['code']          = $code;
        $messageAndroidIos['referred_facility']          = $referred_facility;

        $login_token = Login::whereNotNull("token")->where("login","like","%".date('Y-m-d')."%")->where("logout","0000-00-00 00:00:00")->pluck('token')->toArray();
        /**
         * `registration_ids` send token in array for multiple devices
         **/

        $fields = array(
            'registration_ids'  =>  $login_token, // Put your token in Array.
            'data'              =>  $messageAndroidIos,
            'notification'      =>  $messageAndroidIos,
        );

        $headers = array(
            'Authorization: key='.$SERVER_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL,$url);
        curl_setopt( $ch,CURLOPT_POST,true);
        curl_setopt( $ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

    }

    public function referralAppend($code){
        $tracking = Tracking::select(
            'tracking.*',
            DB::raw('CONCAT(patients.fname," ",patients.mname," ",patients.lname) as patient_name'),
            DB::raw("TIMESTAMPDIFF(YEAR, patients.dob, CURDATE()) AS age"),
            'patients.sex',
            'facility.name as facility_name',
            DB::raw('CONCAT(
                        if(users.level="doctor","Dr. ",""),
                    users.fname," ",users.mname," ",users.lname) as referring_md'),
            DB::raw('CONCAT(action.fname," ",action.mname," ",action.lname) as action_md')
        )
            ->join('patients','patients.id','=','tracking.patient_id')
            ->join('facility','facility.id','=','tracking.referred_from')
            ->leftJoin('users','users.id','=','tracking.referring_md')
            ->leftJoin('users as action','action.id','=','tracking.action_md')
            ->where('code',$code)
            ->first();

        return view('doctor.referral_append',[
            "tracking" => $tracking
        ]);
    }

    // public static function pushNotificationCCMCOld($push) {
    //     /*if(date("H:i:s") >= "17:00:00" && date("H:i:s") <= "21:00:00") {
    //         $topic = "/topics/referrals_ER";
    //     } else {
    //         $topic = "/topics/referrals_TRIAGGE";
    //     }*/

    //     $topic = "/topics/referrals_TRIAGGE";
    //     $data = [
    //         "age" => $push['age'],
    //         "patient" => $push['patient'],
    //         "hospital_referrer" => $push['referring_hospital'],
    //         "sex"=> $push['sex']
    //     ];
    //     $CURL_POST_FIELDS = ["to"=>$topic,"data"=>$data];

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => json_encode($CURL_POST_FIELDS),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: key=AAAAU6ekIBA:APA91bEtfmASYObVAvEasSdtyaBqz6e0yi9gJrZ0J9fSxdYpDCdf6JWeN-Kbs7O-sEwEGoGxIn6cIw52RLi-Z2iRH2XfmHf2KH3xDdPWV4Of5C_GxJlq1rstQoNVCFzs_K_W3INFD0ks',
    //             'Content-Type: application/json'
    //         ),
    //     ));

    //     curl_exec($curl);
    //     curl_close($curl);
    // }

    // public function pushNotificationCCMC($push)
    public static function notifierPushNotification($push)
    {

        // try {
        //     \Log::info('Inside notifierPushNotification with data:', $push);
        //     // Notification logic
        // } catch (\Exception $e) {
        //     \Log::error('Error in notifierPushNotification: '.$e->getMessage());
        // }

        if(date("H:i:s") >= "17:00:00" && date("H:i:s") <= "21:00:00") {
             $topic = "referrals_ER";
         } else {
             $topic = "referrals_TRIAGGE";
         }

        // $topic = "referrals_TRIAGGE";

        try {
            // static data
            // $post_params = [
            //     "topic" => "referrals_TRIAGGE",
            //     "hospital_referrer" => "CSMC",
            //     "patient" => "Sample P. Patient",
            //     "age" => "23",
            //     "sex" => "Male"
            // ];
            //dynamic data
            $post_params  = [
                "topic" => $topic,
                "hospital_referrer" => $push['referring_hospital'],
                "patient" => $push['patient'],
                "age"=> $push['age'],
                "sex"=> $push['sex']
            ];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://dohcsmc.com/notifier/api/send_push_notification',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($post_params),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                CURLOPT_SSL_VERIFYHOST => 0,  // Disable SSL host verification
                CURLOPT_SSL_VERIFYPEER => 0   // Disable SSL certificate verification
            ));

            $response = curl_exec($curl);

            if ($response === false) {
                // cURL error occurred
                $error = curl_error($curl);
                curl_close($curl);
                return 'Curl error: ' . $error;
            }

            curl_close($curl);
            return $response;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function verifyTracking($code) {
        if(Tracking::where("code",$code)->first()){
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function getFormData(Request $request) {
        $tracking = Tracking::where("code",$request->code)->first();
        if($tracking->type == 'normal') {
            $response = ReferralCtrl::normalFormData($tracking->id);
            $response['form']['age'] = $response['age'];
            $response['form']['type'] = $tracking->type;
            $response['form']['icd'] = Icd::select("icd10.code","icd10.description")->where("icd.code",$tracking->code)->leftJoin("icd10","icd10.id","=","icd.icd_id")->get();
            $patient_form = PatientForm::select('patient_form.file_path','reason_referral.reason')->where('patient_form.code', $tracking->code)->leftJoin("reason_referral","reason_referral.id","=","patient_form.reason_referral")->first();
            $file_link = $patient_form->file_path;
            $file_attachment = [];
            if($file_link != null && $file_link != "") {
                $explode = explode("|",$file_link);
                foreach($explode as $link) {
                    $path_tmp = ReferralCtrl::securedFile($link);
                    if($path_tmp != '') {
                        $file_attachment[] = [
                            "file_name" => basename($path_tmp),
                            "file_path" => $path_tmp,
                        ];
                    }
                }
            }
            $response['form']['file_attachment'] = $file_attachment;
            $response['form']['note_diagnosis'] = $response['form']['diagnosis'];
            $response['form']['other_diagnosis'] = $response['pregnant']['other_diagnoses'];
            $response['form']['reason_referral'] = $patient_form->reason;
            unset($response['form']['notes_diagnoses']);
            unset($response['form']['diagnosis']);
            return $response['form'];
        } elseif($tracking->type == 'pregnant') {
            $response = ReferralCtrl::pregnantFormData($tracking->id);
            $response['pregnant']['age'] = $response['pregnant']['woman_age'];
            $response['pregnant']['type'] = $tracking->type;
            $response['pregnant']['baby'] = $response['baby'];
            $response['pregnant']['icd'] = Icd::select("icd10.code","icd10.description")->where("icd.code",$tracking->code)->leftJoin("icd10","icd10.id","=","icd.icd_id")->get();
            $pregnant_form = PregnantForm::select('pregnant_form.file_path','reason_referral.reason')->where('pregnant_form.code', $tracking->code)->leftJoin("reason_referral","reason_referral.id","=","pregnant_form.reason_referral")->first();
            $file_link = $pregnant_form->file_path;
            $file_attachment = [];
            if($file_link != null && $file_link != "") {
                $explode = explode("|",$file_link);
                foreach($explode as $link) {
                    $path_tmp = ReferralCtrl::securedFile($link);
                    if($path_tmp != '') {
                        $file_attachment[] = [
                            "file_name" => basename($path_tmp),
                            "file_path" => $path_tmp,
                        ];
                    }
                }
            }
            $response['pregnant']['file_attachment'] = $file_attachment;
            $response['pregnant']['note_diagnosis'] = $response['pregnant']['notes_diagnoses'];
            $response['pregnant']['other_diagnosis'] = $response['pregnant']['other_diagnoses'];
            $response['pregnant']['reason_referral'] = $pregnant_form->reason;
            unset($response['pregnant']['notes_diagnoses']);
            unset($response['pregnant']['other_diagnoses']);
            return $response['pregnant'];
        }
    }

    public function checkUsername(Request $request) {
        $username = $request->username;
        $patient_code = $request->patient_code;
        $result = User::select(
                            "users.id",
                            DB::raw("concat('Dr.',users.fname,' ',users.lname) as name"),
                            DB::raw("if(users.facility_id = tracking.referred_from,'referring','referred') as status"),
                            DB::raw("200 as status_code")
                        )
                        ->where("users.username",$username)
                        ->where("tracking.status","accepted")
                        ->where("tracking.code",$patient_code)
                        ->leftJoin("tracking",function($join){
                            $join->on(function($query) {
                                $query->whereRaw("tracking.referred_from = users.facility_id")
                                    ->orWhereRaw("tracking.referred_to = users.facility_id");
                            });
                        })
                        ->first();

        if($result->status_code == "200")
            return $result;
        else {
            return [
                "status_code" => 204
            ];
        }
    }

    public function index() {
        $data = array(
            'LABOR00195' => '24 Hour Albumin',
            'LABOR00196' => '24 Hour Creatinine',
            'LABOR00283' => '24 Hour Urine Albumin',
            'LABOR00284' => '24 Hour Urine Creatinine',
            'LABOR00079' => '24 Hr. Urine Protein Det.',
            'LABOR00156' => 'A/G Ratio',
            'LABOR00112' => 'ABO Typing',
            'LABOR00018' => 'ABO/Rh typing',
            'LABOR00203' => 'Acid Fast Staining',
            'LABOR00086' => 'Acid Phosphatase',
            'LABOR00120' => 'AFB culture',
            'LABOR00119' => 'AFB Stain',
            'LABOR00198' => 'ALAT (SGPT)',
            'LABOR00155' => 'Albumin',
            'LABOR00242' => 'Alfa Feto Protein (AFP)',
            'LABOR00050' => 'Alk. Phosphatase',
            'LABOR00163' => 'Alkaline Phosphatase',
            'LABOR00351' => 'ALT',
            'LABOR00167' => 'Amylase',
            'LABOR00220' => 'Anti DNA',
            'LABOR00250' => 'Anti HBs (Quantitative)',
            'LABOR00252' => 'Anti HCV (Hepa C Antibody)',
            'LABOR00186' => 'APT\'S Test',
            'LABOR00269' => 'APTT',
            'LABOR00094' => 'Arterial Blood Gas Analysis',
            'LABOR00199' => 'ASAT (SGOT)',
            'LABOR00053' => 'ASO',
            'LABOR00296' => 'ASO (qualitative)',
            'LABOR00213' => 'ASO Titre',
            'LABOR00074' => 'Autopsy',
            'LABOR00075' => 'Autopsy - Partial',
            'LABOR00300' => 'B-HCG (quantitative)',
            'LABOR00279' => 'B1B2 Total & Direct',
            'LABOR00206' => 'Bactec not Provided',
            'LABOR00205' => 'Bactec Provided',
            'LABOR00188' => 'Bence Jones Protein',
            'LABOR00253' => 'Beta HCG (Quantitative)',
            'LABOR00299' => 'Beta HCG (undiluted)',
            'LABOR00254' => 'Beta HCG with Titar',
            'LABOR00194' => 'Bilirubin, Total Direct',
            'LABOR00227' => 'Biopsy, large',
            'LABOR00226' => 'Biopsy, medium',
            'LABOR00225' => 'Biopsy, small',
            'LABOR00027' => 'Bleeding Time - Disposable',
            'LABOR00026' => 'Bleeding Time - Manual',
            'LABOR01002' => 'Blood Cholesterol',
            'LABOR00117' => 'Blood Culture / sensitivity test',
            'LABOR00301' => 'Blood Culture with Bactec',
            'LABOR00303' => 'Blood Culture without Bactec',
            'LABOR00197' => 'Blood Extraction',
            'LABOR00111' => 'Blood Indices (MCV, MCH, MCHC)',
            'LABOR00109' => 'Blood smear',
            'LABOR00173' => 'Blood Typing',
            'LABOR00286' => 'Blood Typing, ABO Only',
            'LABOR00285' => 'Blood Typing, ABO Rh',
            'LABOR00287' => 'Blood Typing, RH Only',
            'LABOR00001' => 'BLOOD UREA NITROGEN (BUN)',
            'LABOR00004' => 'BLOOD URIC ACID',
            'LABOR00030' => 'Bone marrow',
            'LABOR00067' => 'Bone Marrow Aspirate',
            'LABOR00268' => 'Bone Marrow Smears',
            'LABOR00180' => 'BSMP',
            'LABOR00147' => 'BUN',
            'LABOR00219' => 'C-Reactive Protein',
            'LABOR00060' => 'C3',
            'LABOR00247' => 'CA 125 (Ovary)',
            'LABOR00245' => 'CA 15-3 (Breast)',
            'LABOR00244' => 'CA 19-9 (Pancreas)',
            'LABOR00246' => 'CA 72-4 (GIT)',
            'LABOR00093' => 'Calcium',
            'LABOR00006' => 'CBC',
            'LABOR00243' => 'CEA (Colorectal)',
            'LABOR00282' => 'Cell and Differential Count, Sugar and Protein',
            'LABOR00230' => 'Cell Block',
            'LABOR00228' => 'Cell Cytology',
            'LABOR00291' => 'Cervical Biopsy',
            'LABOR00231' => 'Cervical Punch Biopsy',
            'LABOR00092' => 'Chloride',
            'LABOR00145' => 'Chloride and Sugar',
            'LABOR00045' => 'Cholesterol',
            'LABOR00166' => 'CKMB',
            'LABOR00107' => 'Clot Retraction Time (CRT, castor oil Method)',
            'LABOR00025' => 'Clotting Time',
            'LABOR00275' => 'Clotting Time (Lee White)',
            'LABOR00005' => 'CLOTTING TIME - BLEEDING TIME',
            'LABOR00105' => "Clotting Time, Bleeding Time (Slide, Duke's method)",
            'LABOR00098' => 'Complete blood count (includes WBC count differential count, hemoglobin, hematocrit)',
            'LABOR00115' => "Coomb's Test (Direct)",
            'LABOR00019' => "Coomb's test - direct",
            'LABOR00020' => "Coomb's test - indirect",
            'LABOR00264' => 'Cortisol',
            'LABOR00088' => 'CPK-MB',
            'LABOR00047' => 'Crea Nitrogen',
            'LABOR00148' => 'Creatinine Clearance Test ( CCT )',
            'LABOR00046' => 'Creatinine Test',
            'LABOR00207' => 'Cross Matching',
            'LABOR00114' => 'Cross Matching (3 Phase)',
            'LABOR00288' => 'Crossmatching per bag',
            'LABOR00054' => 'CRP',
            'LABOR00143' => 'CSF Analysis (cell count)',
            'LABOR00070' => 'CSF Analysis (complete)',
            'LABOR00071' => 'CSF Analysis - cell count / diff. count',
            'LABOR00033' => 'CSF Analysis - Protein',
            'LABOR00032' => 'CSF Analysis - Sugar',
            'LABOR00187' => 'CSF, Body Fluids Transudate, Exudate Cell & Differential Ct. Sugar, Protein Analysis',
            'LABOR00177' => 'CT, BT',
            'LABOR00116' => 'Culture & Sensitivity',
            'LABOR00248' => 'Cyfral 21-1 (Lungs)',
            'LABOR00036' => 'Cytology (fluids) with cell block',
            'LABOR00035' => 'Cytology (FNAB)',
            'LABOR00294' => 'Decalcification of Bone',
            'LABOR00059' => 'Dengue Antigen IgM',
            'LABOR00058' => 'Dengue dot',
            'LABOR00062' => 'DIC panel',
            'LABOR00024' => 'DIC panel - Activated PT',
            'LABOR00065' => 'DIC panel - Fibrin Degredation Product',
            'LABOR00064' => 'DIC panel - Fibrinogen Assay',
            'LABOR00023' => 'DIC panel - Prothrombin Time',
            'LABOR00063' => 'DIC panel - Thrombin Time',
            'LABOR00158' => 'Direct Bilirubin',
            'LABOR00210' => 'DU Variant (Anti Du)',
            'LABOR01004' => 'ECG',
            'LABOR00102' => 'Erythrocytes Sedimentation Rate (ESR)',
            'LABOR00061' => 'ESR',
            'LABOR00258' => 'Estradiol',
            'LABOR00281' => 'Extraction Fee',
            'LABOR01003' => 'Fasting / Random Blood Sugar (FBS / RBS)',
            'LABOR01000' => 'Fasting Blood Sugar',
            'LABOR00191' => 'FBS / RBS',
            'LABOR00040' => 'Fecalysis',
            'LABOR00136' => 'Fecalysis - Apts Test',
            'LABOR00134' => 'Fecalysis - Bile and Bilirubin',
            'LABOR00138' => 'Fecalysis - Concentration Technic',
            'LABOR00133' => 'Fecalysis - Occult Blood',
            'LABOR00132' => 'Fecalysis - Routine Stool Exam',
            'LABOR00140' => 'Fecalysis - Scock Tape for Enerobius',
            'LABOR00139' => 'Fecalysis - Smear for Amoeba',
            'LABOR00137' => 'Fecalysis - Sudan Test',
            'LABOR00135' => 'Fecalysis - Urobilinogen & Stercobilinogen',
            'LABOR00277' => 'Fecalysis w/ Kato Thick',
            'LABOR00263' => 'Ferritin',
            'LABOR00290' => 'FFP, Cryoppt Retyping per bag',
            'LABOR00270' => 'Filaria',
            'LABOR00229' => 'FNAB',
            'LABOR00073' => 'Frozen Section',
            'LABOR00256' => 'FSH',
            'LABOR00297' => 'FT3',
            'LABOR00238' => 'FT4',
            'LABOR00223' => 'FTI',
            'LABOR00298' => 'FTI (FT3/FT4 Index)',
            'LABOR00239' => 'FTI/FTT4 Index',
            'LABOR00202' => 'Geimsa Staining',
            'LABOR00043' => 'Glucose',
            'LABOR00149' => 'Glucose (FBS)',
            'LABOR00118' => 'Gram Staining',
            'LABOR00304' => 'Gram Staining (Direct)',
            'LABOR00293' => 'Gram Staining of Cervical Smears',
            'LABOR00292' => 'Gram Staining of Tissue',
            'LABOR00002' => "Gram's Stain",
            'LABOR00153' => 'GTT (Glucose Tolerance Test)',
            'LABOR00221' => 'H.pylori',
            'LABOR00295' => 'HbsAg',
            'LABOR00251' => 'HbsAg & Anti HBs (Package)',
            'LABOR00249' => 'HbsAg (Quantitative)',
            'LABOR00083' => 'HDL / LDL',
            'LABOR00176' => 'Hematocrit',
            'LABOR00100' => 'Hemoglobin',
            'LABOR00216' => 'Hepa B Antigen Quanti',
            'LABOR00218' => 'Hepa C Antibody',
            'LABOR00010' => 'Hepatitis - HBc',
            'LABOR00012' => 'Hepatitis - HBe / HBeAg',
            'LABOR00011' => 'Hepatitis - HBs',
            'LABOR00009' => 'Hepatitis - HBsAg (EIA)',
            'LABOR00008' => 'Hepatitis - HBsAg (RPHA)',
            'LABOR00051' => 'Hepatitis - HBsAg (strips)',
            'LABOR00208' => 'Hepatitis A Antigen',
            'LABOR00209' => 'Hepatitis B Antigen',
            'LABOR00013' => 'Hepatitis B profile',
            'LABOR00015' => 'Hepatitis C profile - HCV (EIA)',
            'LABOR00014' => 'Hepatitis C profile HCV (PA)',
            'LABOR00217' => 'Hepatitis Test',
            'LABOR00350' => 'HGT',
            'LABOR00039' => 'Histopathology - Large',
            'LABOR00038' => 'Histopathology - Medium or (2) small',
            'LABOR00037' => 'Histopathology - Small (1)',
            'LABOR00016' => 'HIV',
            'LABOR00215' => 'HIV Antibody',
            'LABOR00017' => 'HIV EIA',
            'LABOR00122' => 'India Ink',
            'LABOR00159' => 'Indirect Bilirubin',
            'LABOR00172' => 'Inorganic Phospharous',
            'LABOR00121' => 'KGH Mounting',
            'LABOR00003' => 'KOH',
            'LABOR00029' => "L.E.  Schilling's Hemogram",
            'LABOR00028' => 'L.E. Preparation (manual)',
            'LABOR00162' => 'LDH',
            'LABOR00110' => 'LE Cell Preparation',
            'LABOR00182' => 'Lee White, CT',
            'LABOR00255' => 'LH (Luteinizing Hormone)',
            'LABOR00201' => 'Lipid Profile',
            'LABOR00108' => 'Malarial Smear',
            'LABOR00068' => 'Malarial Smear - QBC',
            'LABOR00069' => 'Malarial Smear- Slide',
            'LABOR555' => 'MISCELLANEOUS TESTING',
            'LABOR00041' => 'Occult Blood',
            'LABOR00087' => 'OGTT',
            'LABOR00280' => 'OGTT (3 takes))',
            'LABOR00031' => 'Osmotic Fragility Test',
            'LABOR00034' => "PAP's Smear",
            'LABOR00099' => 'Partial Blood count ( WBC count, diff. count)',
            'LABOR00091' => 'Patassium',
            'LABOR00178' => 'Peripheral Smear',
            'LABOR00007' => 'PLATELET COUNT',
            'LABOR00103' => 'Platelet Count / Actual Platelet Count',
            'LABOR00289' => 'Platelet Crossmatching',
            'LABOR00169' => 'Potassium',
            'LABOR00146' => 'Pregnancy Test',
            'LABOR00081' => 'Pregnancy Test (Preg Test)',
            'LABOR00259' => 'Progesterone',
            'LABOR00257' => 'Prolactin',
            'LABOR00106' => 'Prothrombin Time (INR) DerivedFibrinogen, Protime %  Activity',
            'LABOR00181' => 'Protime',
            'LABOR00241' => 'PSA (Prostate)',
            'LABOR00189' => 'Quali Pregnancy Test',
            'LABOR00190' => 'Quanti Pregnancy Test',
            'LABOR00072' => 'Radical (Breast, Uterus, RND)',
            'LABOR00278' => 'Rapid Blood Sugar / RBS',
            'LABOR00174' => 'RBC Count',
            'LABOR00101' => 'Red Blood Cell Count',
            'LABOR00022' => 'Reticulocyte Count',
            'LABOR00104' => 'Reticulocytos count',
            'LABOR00113' => 'RH Blood Typing (Tube Method)',
            'LABOR00055' => 'Rheumatoid factor',
            'LABOR00214' => 'RPR (VDRL)',
            'LABOR1005' => 'RT PCR',
            'LABOR01005' => 'SAMPLE SAMPLE',
            'LABOR00066' => "Schilling's Hemogram",
            'LABOR00052' => 'Screening fee per blood unit',
            'LABOR00082' => 'Semen Analysis',
            'LABOR00142' => 'Seminal Fluid Analysis',
            'LABOR00273' => 'Serial HB, HCT',
            'LABOR00272' => 'Serial HB, HCT, Platelet',
            'LABOR00274' => 'Serial HCT, PLatelet Ct',
            'LABOR00049' => 'Serum Albumin',
            'LABOR00096' => 'SGOT',
            'LABOR00097' => 'SGPT',
            'LABOR00042' => 'Smear for Amoeba',
            'LABOR00271' => 'Smear for Malaria (SMP)',
            'LABOR00090' => 'Sodium',
            'LABOR00232' => 'Special Staining',
            'LABOR0099' => 'SPUTUM',
            'LABOR00204' => 'Stool / Rectal Swab Blood Culture:',
            'LABOR01001' => 'SYPHILIS TEST',
            'LABOR00240' => 'T Uptake',
            'LABOR00234' => 'T3',
            'LABOR00224' => 'T3 Uptake',
            'LABOR00237' => 'T3, T4, TSH',
            'LABOR00212' => 'T3T4',
            'LABOR00235' => 'T4',
            'LABOR00157' => 'Total Bilirubin',
            'LABOR00095' => 'Total Bilirubin B1B2',
            'LABOR00192' => 'Total Cholesterol',
            'LABOR00165' => 'Total CPR',
            'LABOR00048' => 'Total Protein',
            'LABOR00144' => 'Total Protein & Globulin',
            'LABOR00179' => 'Toxic Granules',
            'LABOR00085' => 'TP, Albumin, AG ratio',
            'LABOR00266' => 'TPAG',
            'LABOR00152' => 'Triglycerides',
            'LABOR00084' => 'Triglycerides / LDH',
            'LABOR00200' => 'Trop T',
            'LABOR00302' => 'Trop T (qualitative)',
            'LABOR00262' => 'Trop T (Quantitative)',
            'LABOR00222' => 'TSH',
            'LABOR00056' => 'Typhidot',
            'LABOR00193' => 'Urea (BUN)',
            'LABOR00150' => 'Uric Acid',
            'LABOR00044' => 'Uric Acid (Urates)',
            'LABOR00129' => 'Urinalysis - Bench Jones Protein',
            'LABOR00127' => 'Urinalysis - Bilirubin & Bile',
            'LABOR00128' => 'Urinalysis - Diabetic & Calcium',
            'LABOR00126' => 'Urinalysis - Qualitative & Quantitative Urobilinogen',
            'LABOR00125' => 'Urinalysis - Qualitative Albumin',
            'LABOR00124' => 'Urinalysis - Qualitative Sugar & Acetone',
            'LABOR00123' => 'Urinalysis - Routine (Qualitative & Microscopic)',
            'LABOR00130' => 'Urinalysis - Stone Analysis',
            'LABOR00076' => 'Urinalysis MARTEST',
            'LABOR00265' => 'Urinary Caculi (Stone Analysis)',
            'LABOR00077' => 'Urine Albumin',
            'LABOR00276' => 'Urine Bilirubin',
            'LABOR00078' => 'Urine Ketone/Acetone',
            'LABOR00184' => 'Urine PH',
            'LABOR00185' => 'Urine Specific Gravity',
            'LABOR00080' => 'Urine Sugar',
            'LABOR00131' => 'Urine Sugar (Clinitest)',
            'LABOR00175' => 'WBC Count',
            'LABOR00057' => 'Widal',
            'LABOR00141' => 'Widal Test'
        );

        return $data;
    }

    public function store(Request $request)
    {
        labRequest::where('activity_id', $request->activity_id)
        ->delete();
        foreach($request->laboratory_code as $row) {
            LabRequest::create([
                'activity_id' => $request->activity_id,
                'requested_by' => $request->requested_by,
                'laboratory_code' => $row
            ]);
        }
        // $broadcast_labrequest = [ // I add this changes
        //     "laboratory_code" =>$request->laboratory_code,
        //     "request_by" =>$request->requested_by,
        //     "activity_id" =>$request->activity_id
        // ];
        // broadcast(new SocketReferralDischarged($broadcast_labrequest)); 
        return response()->json(['lab_request' => $request->all()], Response::HTTP_CREATED);
    }

    public function checkLabResult(Request $request) {
        return labRequest::where('activity_id', $request->activity_id)->first();
    }

}