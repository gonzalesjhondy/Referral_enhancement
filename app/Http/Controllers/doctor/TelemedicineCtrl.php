<?php

namespace App\Http\Controllers\doctor;

use App\AppointmentSchedule;
use App\Department;
use App\Facility;
use App\TelemedAssignDoctor;
use App\Tracking;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class TelemedicineCtrl extends Controller
{
    public function index(Request $req)
    {
        return view('doctor.video-call', ['referral_type'=>$req->form_type]);
    }

    public function manageAppointment(Request $req)
    {
        $facility = Session::get('auth')->facility_id;
        
        $appointment_schedule = AppointmentSchedule::
            with([
                'createdBy' => function ($query) {
                    $query->select(
                        'id',
                        'username'
                    );
                },
                'facility' => function ($query) {
                    $query->select(
                        'id',
                        'name'
                    );
                },
                'department' => function ($query) {
                    $query->select(
                        'id',
                        'description'
                    );
                },
                'telemedAssignedDoctor' => function ($query) {
                    $query->with(['doctor' => function ($query) {
                        $query->select(
                            'id',
                            'fname',
                            'lname'
                        );
                    }]);
                }
            ])
            ->where('facility_id',$facility)
            ->orderBy('created_at', 'desc')
            ->paginate(20); 

            $user_facility = User::where('department_id',5)
            ->where('level','doctor')
            ->where('facility_id',$facility)
            ->with('facility')
            ->groupBy('facility_id')
            ->get();
           
        $data = [
            'appointment_schedule' => $appointment_schedule,
            'facility' => $user_facility,
            'keyword' => $req->input('appt_keyword', ''),
            'status' => $req->input('status_filter', ''),
            'date' => $req->input('date_filter', ''),
        ];
        return view('doctor.manage_appointment', $data);
    }

    public function appointmentCalendar() {
        $user = Session::get('auth');
        $appointment_sched = AppointmentSchedule::select("appointment_schedule.*",DB::raw("sum(appointment_schedule.slot) as slot"))->groupBy('appointment_schedule.facility_id')->with('facility')->get();
        
         $facility_id = AppointmentSchedule::pluck('facility_id');

        $appointment_slot = Facility::with(['appointmentSchedules.telemedAssignedDoctor'])->find($facility_id);
        
        //  return $appointment_slot;
        
        return view('doctor.telemedicine_calendar1',[
            'appointment_sched' => $appointment_sched,
            'appointment_slot' => $appointment_slot,
            'user' => $user
        ]);
    }

    public function createAppointment(Request $request)
    {
        $user = Session::get('auth');
        for($i=1; $i<=$request->appointment_count; $i++) {

            if (empty($request['add_appointed_time'.$i]) || empty($request['add_appointed_time_to'.$i]) || empty($request->add_opdCategory.$i) || empty($request['add_available_doctor'.$i])) {
                continue;
            }

            $appointment_schedule = new AppointmentSchedule();
            $appointment_schedule->appointed_date = $request->appointed_date;
            $appointment_schedule->facility_id = $request->facility_id;
            $appointment_schedule->department_id = 5;
            $appointment_schedule->appointed_time = $request['add_appointed_time'.$i];
            $appointment_schedule->appointedTime_to = $request['add_appointed_time_to'.$i];
            $appointment_schedule->opdCategory = $request['add_opdCategory'.$i];
            //$appointment_schedule->slot = $request->slot.$i;
            $appointment_schedule->created_by = $user->id;
            $appointment_schedule->save();

            for($x=0; $x<count($request['add_available_doctor'.$i]); $x++) {
                $tele_assign_doctor = new TelemedAssignDoctor();
                $tele_assign_doctor->appointment_id = $appointment_schedule->id;
                $tele_assign_doctor->doctor_id = $request['add_available_doctor'.$i][$x];
                $tele_assign_doctor->created_by = $user->id;
                $tele_assign_doctor->save();
            }
        }

        Session::put('appointment_save',true);
        return redirect()->back();
    }
    //-------------Get all booked Dates--------------------------------------
    public function getBookedDates(){
        $user = Session::get('auth');

        // $bookDates = AppointmentSchedule::where('facility_id', $user->facility_id)->pluck('appointed_date')->toArray();
        $bookDates = AppointmentSchedule::with(['telemedAssignedDoctor'])
                    ->where('facility_id', $user->facility_id)->get();
        return response()->json($bookDates);
    }
    //-------------End of get all booked dates-------------------------------
    public function getAppointmentData(Request $request)
    {
        $appointment = AppointmentSchedule::find($request->id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        return response()->json($appointment);
    }

    //-------My version of getAppointmentData------------->

    public function displayAppointment(Request $request)
    {
        //dd($id);
        // $doctor_id =TelemedAssignDoctor::where('appointment_id', $request->id)
        // ->pluck('doctor_id')->first();
        // $appointment = AppointmentSchedule::find($request->id);
        $facility = Session::get('auth')->facility_id;

        $appointed_date = AppointmentSchedule::where('id', $request->id)
        ->pluck('appointed_date')
        ->first();
        $appointment = AppointmentSchedule::where('appointed_date', $appointed_date)->
            with([
                'createdBy' => function ($query) {
                    $query->select(
                        'id',
                        'username'
                    );
                },
                'facility' => function ($query) {
                    $query->select(
                        'id',
                        'name'
                    );
                },
                'department' => function ($query) {
                    $query->select(
                        'id',
                        'description'
                    );
                },
                'telemedAssignedDoctor' => function ($query) {
                    $query->with(['doctor' => function ($query) {
                        $query->select(
                            'id',
                            'fname',
                            'lname'
                        );
                    }]);
                }
            ])->where('facility_id', $facility)
            ->get();

           
        return response()->json($appointment);

    }

    public function deleteAppointmentSched(Request $request){
        $facility_id = Session::get('auth')->facility_id;

        $appointed_date = AppointmentSchedule::where('id', $request->id)
        ->pluck('appointed_date')
        ->first();
        $appointment = AppointmentSchedule::where('appointed_date', $appointed_date)->
            with([
                'createdBy' => function ($query) {
                    $query->select(
                        'id',
                        'username'
                    );
                },
                'facility' => function ($query) {
                    $query->select(
                        'id',
                        'name'
                    );
                },
                'department' => function ($query) {
                    $query->select(
                        'id',
                        'description'
                    );
                },
                'telemedAssignedDoctor' => function ($query) {
                    $query->with(['doctor' => function ($query) {
                        $query->select(
                            'id',
                            'fname',
                            'lname'
                        );
                    }]);
                }
            ])->where('facility_id', $facility_id)
            ->get();
    
        return response()->json($appointment);
    }

    //------------end-------------------------------------->
    // public function updateAppointment(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'id' => 'required|integer',
    //         'appointed_date' => 'required|date',
    //         'appointed_time' => 'required',
    //         'appointedTime_to' => 'required',
    //         'facility_id' => 'required',
    //         'department_id' => 'required',
    //         'opdCategory' => 'required',
    //         'slot' => 'required|integer',
    //     ]);

    //     $appointmentId = $validatedData['id'];
    //     $appointment = AppointmentSchedule::find($appointmentId);

    //     if (!$appointment) {
    //         return response()->json(['error' => 'Appointment not found'], 404);
    //     }

    //     $appointment->fill($validatedData); // Update appointment attributes

    //     if ($appointment->save()) {
    //         return response()->json(['message' => 'Appointment updated successfully'], 200);
    //     } else {
    //         return response()->json(['error' => 'Failed to update appointment'], 500);
    //     }
    // }

    //-------------------------Version of updateAppointment -----------------------------//

    public function updateAppointment(Request $request)
    {
        
        $user = Session::get('auth');
        $appointmentDate = $request->input('update_appointment_date');
        
        $appointed_id = $request->input("appointment_id");
        $appointed_date = AppointmentSchedule::where('id', $appointed_id)
            ->pluck('appointed_date')
            ->first();
      
        $requestCount = $request->appointment_count;
      
            for($i=2; $i<=$requestCount; $i++) { 
                $appointment_id = $request->input('appointment_id' . $i);
           
                $appointment = AppointmentSchedule::with(['telemedAssignedDoctor' => function ($query) {
                    $query->with(['doctor' => function ($query) {
                        $query->select('id', 'fname', 'lname');
                    }]);
                }])->find($appointment_id);
                
                if($appointment){

                    $appointment->appointed_date = $request->input('appointed_date'); 
                    $appointment->appointed_time =  $request->input('update_appointed_time' . $i);  
                    $appointment->appointedTime_to = $request->input('update_appointed_time_to' . $i);
                    $appointment->opdCategory = $request->input('opdCategory' . $i);
                    $appointment->save();
                    
                   // $appointment->telemedAssignedDoctor()->delete();

                    $doctor_ids = $request->input('Update_available_doctor' . $i);
                    if(!is_array($doctor_ids)){
                        $doctor_ids = [$doctor_ids];
                    }

                    $existingDoctorIds = $appointment->telemedAssignedDoctor->pluck('doctor_id')->toArray();
                    $doctorsToDelete = array_diff($existingDoctorIds, $doctor_ids);

                    $doctorsToAdd = array_diff($doctor_ids, $existingDoctorIds);

                    if(!empty($doctorsToDelete)){ // Delete doctors that are no longer in the request
                        $appointment->telemedAssignedDoctor()->whereIn('doctor_id', $doctorsToDelete)->delete();
                    }

                    foreach($doctorsToAdd as $doctor_id){
                        $appointment->telemedAssignedDoctor()->create([
                            'doctor_id' => $doctor_id
                        ]);
                    }
                    // foreach($appointment->telemedAssignedDoctor as $assignedoctor){
                      
                    //     $assignedoctor->doctor_id = $request->input('available_doctor' . $i);
                    //     $assignedoctor->save();
                    // }  
                }
            }
       
           
        for($i=1; $i<=$request->appointment_count; $i++) { 
                
                if(empty($request['Add_appointed_time'.$i]) || empty($request['Add_appointed_time_to'.$i]) || empty($request['opdCategory'.$i])) {
                    continue;
                }
                
                $Update_appointment_data = new AppointmentSchedule();
                $Update_appointment_data->appointed_date = $appointmentDate;
                $Update_appointment_data->facility_id = $request->facility_id;
                $Update_appointment_data->department_id = 5;
                $Update_appointment_data->appointed_time = $request['Add_appointed_time'.$i];
                $Update_appointment_data->appointedTime_to = $request['Add_appointed_time_to'.$i];
                $Update_appointment_data->opdCategory = $request['opdCategory'.$i];
                $Update_appointment_data->created_by = $user->id;
                $Update_appointment_data->save();
                
                $availableDoctors = is_array($request['Add_Update_available_doctor'.$i])
                ? $request['Add_Update_available_doctor'.$i]
                : [$request['Add_Update_available_doctor'.$i]];
    
                foreach($availableDoctors as $doctorId){
                    $tele_assign_doctor = new TelemedAssignDoctor();
                    $tele_assign_doctor->appointment_id = $Update_appointment_data->id;
                    $tele_assign_doctor->doctor_id = $doctorId;
                    $tele_assign_doctor->created_by = $user->id;
                    $tele_assign_doctor->save();
                }
        }

           
            // dd($request->all());
            Session::put('appointment_save',true);       
        
        return redirect()->back();
    }

    public function deleteTimeSlot($id){
      
        $appointedSlot = AppointmentSchedule::findOrFail($id);
        $telemedAssignDoctor = TelemedAssignDoctor::where('appointment_id', $id)->delete();
        $appointedSlot->delete();

        return response()->json(['message' => 'Appointment successfully deleted']);
    }

    //-------------------------End version of updateAppointment ------------------------//

    public function deleteAppointment(Request $request)
    {
        $appointedIds = [];
        for($i=2; $i<=$request->appointment_count; $i++) { 
            $appointedId = $request->input('appointment_id' . $i);
            $key = 'appointment_id' . $i;
            $appointed_date = AppointmentSchedule::where('id', $appointedId)
            ->pluck('appointed_date')
            ->first();
           
           $appointment = AppointmentSchedule::where('appointed_date', $appointed_date)->delete();
           //TelemedAssignDoctor

           if(array_key_exists($key, $request->all())){
                $appointedIds[] = $request->input($key);
           }
        }
    
        if(!empty($appointedIds)){

            $teleme_assign = TelemedAssignDoctor::whereIn('appointment_id', $appointedIds)->delete();
        }

        Session::put('appointment_delete',true);       
        return redirect()->back();
    
    }

    public function getUserData($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function getFacilityDetails(Request $request)
    {
        $facility_data = AppointmentSchedule::where('facility_id', $request->id)->groupBy('appointed_date')->get();

        if (!$facility_data) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        return response()->json(['facility_data' => $facility_data]);
    }

    public function getAvailableTimeSlots(Request $request)
    {
        $timeSlots = AppointmentSchedule::
            with([
                'telemedAssignedDoctor' => function ($query) {
                    $query->with(['doctor' => function ($query) {
                        $query->select(
                            'id',
                            'fname',
                            'lname'
                        );
                    }]);
                }
            ])
            ->where('appointed_date', $request->selected_date)
            ->where('facility_id', $request->facility_id)
            ->get();

        return $timeSlots;
    }

    public function getDoctors($facility)
    {
        $doctors = User::where('facility_id', $facility)
                ->where('department_id','=',5)
                ->where('level', 'doctor')
                ->get(['id', 'fname', 'lname']);

        return $doctors;
    }

}

