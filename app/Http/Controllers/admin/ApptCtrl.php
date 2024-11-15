<?php

namespace App\Http\Controllers\admin;

use App\Appointment;
use App\AppointmentStatus;
use App\Feedback;
use App\UserFeedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Ratchet\App;

class ApptCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function appointment(Request $req) {
        if($req->view_all) {
            $keyword = '';
            $status = '';
            Session::put('appt_keyword','');
            Session::put('appt_date','');
        } else {
            $status = $req->status_filter;
            $keyword = $req->appt_keyword;
            if(!$keyword || $keyword == '') {
                $keyword = Session::get('appt_keyword');
            }
            $date = $req->date_filter;
        }

        $data = Appointment::orderBy('id', 'desc');

        if($keyword && $keyword != '') {
            $data = $data->where('name', 'like', '%'.$keyword.'%');
        }

        Session::put('appt_status', $status);
        if($status && $status != '') {
            $data = $data->where('status', $status);
        }

        if($date) {
            $start = Carbon::parse($date)->startOfDay();
            $end = Carbon::parse($date)->endOfDay();
            $data = $data
                ->whereBetween('created_at', [$start, $end]);
        }
        $count = $data->count();

        Session::put('appt_keyword', $keyword);
        Session::put('appt_date', $date);
        Session::put('appt_data', $data->get());

        $data = $data->paginate(30);

        return view('admin.appointment.appt',[
            'title' => 'Appointment',
            'data' => $data,
            'keyword' => $keyword,
            'count' => $count,
            'date' => $date,
            'status' => $status
        ]);
    }

    public function appointmentDetails(Request $req) {
        $user = Session::get('auth');
        $data = Appointment::where('id', $req->id)->first();
        if($data->status == 'new') {
            $data->status = 'seen';
            $data->save();

            $status = new AppointmentStatus();
            $status->appt_id = $req->id;
            $status->encoded_by = $user->id;
            $status->status = 'seen';
            $status->save();
        }

        $remarks = AppointmentStatus::select(
                'appointment_status.remarks',
                'appointment_status.status',
                'users.fname',
                'users.mname',
                'users.lname',
                'appointment_status.created_at'
            )
            ->where('appointment_status.appt_id',$req->id)
            ->where(function($query) {
                $query->where('appointment_status.status','ongoing')
                    ->orWhere('appointment_status.status','resolved');
            })
            ->leftJoin('users','users.id','=','appointment_status.encoded_by')
            ->get();

        return view('admin.appointment.appt_modal', [
            'data' => $data,
            'remarks' => $remarks
        ]);
    }

    public function addOngoing(Request $req) {
        $user = Session::get('auth');
        $data = new AppointmentStatus();
        $data->appt_id = $req->appt_id;
        $data->encoded_by = $user->id;
        $data->remarks = $req->remarks;
        $data->status = "ongoing";
        $data->save();

        $appt = Appointment::where('id',$req->appt_id)->first();
        if($appt->status === 'seen') {
            $appt->status = 'ongoing';
            $appt->save();
        }

        return [
            'data' => $data,
            'user' => $user
        ];
    }

    public function apptResolve(Request $req) {
        $data = Appointment::where('id', $req->appt_id)->first();
        $data->status = 'resolved';
        $data->save();

        $user = Session::get('auth');
        $status = new AppointmentStatus();
        $status->appt_id = $req->appt_id;
        $status->encoded_by = $user->id;
        $status->remarks = $req->remarks;
        $status->status = "resolved";
        $status->save();

        Session::put('appt_msg','Successfully resolved appointment!');
        Session::put('appt_notif',true);

        return [
            'data' => $status,
            'user' => $user
        ];
    }

    public function exportAppointment() {
        $date = Session::get('appt_date');
        $data = Session::get('appt_data');
        $status = Session::get('appt_status');

        $file_name = "Appointments";
        if(isset($date))
            $file_name .= " for ".$date;
        $file_name .= ".xls";
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('admin.appointment.export_appt',[
            "data" => $data,
            "status" => $status,
            "date" => $date
        ]);
    }

    public function feedback(Request $req){
        if($req->view_all) {
            $keyword = '';
        } else {
            $keyword = $req->keyword;
            if(!$keyword || $keyword == '') {
                $keyword = Session::get('user_feedback_keyword');
            }
        }

        Session::put('user_feedback_keyword', $keyword);

        $data = UserFeedback::orderBy('id', 'desc');

        if($keyword && $keyword != '') {
            $data = $data->where('name', 'like', '%'.$keyword.'%');
        }

        $count = $data->count();
        $data = $data->paginate(30);

        return view('admin.user_feedback.user_feedback',[
            'title' => 'User Feedback',
            'data' => $data,
            'count' => $count
        ]);
    }

    public function feedbackSeen(Request $req) {
        $feedback = UserFeedback::where('id', $req->id)->first();
        $feedback->status = 'seen';
        $feedback->save();
        return array('success' => true);
    }

    public function feedbackDetails(Request $req) {
        return UserFeedback::where('id', $req->id)->first();
    }

    public function feedbackResolve(Request $req) {
        $feedback = UserFeedback::where('id', $req->id)->first();
        $feedback->remarks = $req->remarks;
        $feedback->status = 'resolved';
        $feedback->save();
        Session::put('user_feedback_msg','User Feedback resolved!');
        Session::put('user_feedback_notif',true);
        return Redirect::back();
    }

}