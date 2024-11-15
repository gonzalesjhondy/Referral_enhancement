<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Baby;
use App\Facility;
use App\Feedback;
use App\PatientForm;
use App\PregnantForm;
use App\Tracking;
use App\User;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ParamCtrl extends Controller
{
    static function getAge($date){
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = date('m/d/Y',strtotime($date));
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $date_referral = Session::get('date_referral');
        if(isset($date_referral)) { // age compared to date of referral
            $date_referral = explode('/', $date_referral);
            $bday = mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]);
            $refer = mktime(0, 0, 0, $date_referral[0], $date_referral[1], $date_referral[2]);
            $age = (date("md", $bday)) > date("md", $refer)
                ? ((date("Y", $refer) - (date("Y", $bday)) - 1))
                : (date("Y", $refer) - $birthDate[2]);
            if($age > 0)
                Session::put('date_referral', null);
        } else { // age compared to now
            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                ? ((date("Y") - $birthDate[2]) - 1)
                : (date("Y") - $birthDate[2]));
        }
        return $age;
    }

    static function getMonths($date){
        $date_referral = Session::get('date_referral');

        if(isset($date_referral)) {
            $diff = date_diff(date_create($date), date_create($date_referral));
            Session::put('date_referral', null);
        } else {
            $diff = date_diff(date_create($date), date_create('now'));
        }

        return ['month' => $diff->m, 'days' => $diff->d];
    }

    function getDoctorList($facility_id,$department_id)
    {
        $user = User::select('id','fname','mname','lname','contact')
            ->where('facility_id',$facility_id)
            ->where('department_id',$department_id)
            ->where('level','doctor')
            ->get();
        return $user;
    }

    public function upload()
    {
        $file = fopen(url('public/facility.csv'),'r');
        $data = array();
        while(! feof($file))
        {
            $data[] = fgetcsv($file);
        }
        $count = 1;
        foreach($data as $row)
        {
            if($count==1){
                $count=0;
                continue;
            }
            $facility = array(
                'province' => $row[0],
                'name' => $row[1],
                'contact' => $row[2],
                'email' => $row[3]
            );
            Facility::create($facility);
        }
        fclose($file);
    }

    public function maintenance()
    {
        return view('error',[
            'title' => 'Under Maintenance'
        ]);
    }

    public function defaultTable()
    {
        Activity::truncate();
        Baby::truncate();
        PatientForm::truncate();
        PregnantForm::truncate();
        Tracking::truncate();

        return redirect('doctor/patient/tsekap');
    }

    public static function getLastLogin($facility_id)
    {
        $doctor = User::where('level','doctor')
                ->where('facility_id',$facility_id)
                ->where('last_login','!=','0000-00-00 00:00:00')
                ->orderBy('last_login','desc')
                ->first();
        return $doctor;
    }

    public function admin()
    {
        $data = array(
            'username' => 'admin_doh',
            'password' => bcrypt('s3cur1ty'),
            'level' => 'admin',
            'facility_id' => 63,
            'fname' => 'Admin',
            'mname' => 'RO7',
            'lname' => 'DOH',
            'contact' => '418-7633',
            'email' => 'jimmy.lomocso@gmail.com',
            'muncity' => 63,
            'province' => 2,
            'designation' => 'CP II',
            'status' => 'active'
        );
        User::create($data);
    }

    public function support()
    {
        $data = array(
            'username' => 'IT_VSMMC',
            'password' => bcrypt('IT_VSMMC'),
            'level' => 'support',
            'facility_id' => 24,
            'fname' => 'IT',
            'mname' => 'Support',
            'lname' => 'VSMMC',
            'contact' => 'N/A',
            'email' => 'N/A',
            'muncity' => 63,
            'province' => 2,
            'designation' => 'IT',
            'status' => 'active'
        );
        User::create($data);

        $data = array(
            'username' => 'IT_SAMCH',
            'password' => bcrypt('IT_SAMCH'),
            'level' => 'support',
            'facility_id' => 19,
            'fname' => 'IT',
            'mname' => 'Support',
            'lname' => 'SAMCH',
            'contact' => 'N/A',
            'email' => 'N/A',
            'muncity' => 63,
            'province' => 2,
            'designation' => 'IT',
            'status' => 'active'
        );
        User::create($data);

        $data = array(
            'username' => 'IT_TDH',
            'password' => bcrypt('IT_TDH'),
            'level' => 'support',
            'facility_id' => 23,
            'fname' => 'IT',
            'mname' => 'Support',
            'lname' => 'TDH',
            'contact' => 'N/A',
            'email' => 'N/A',
            'muncity' => 67,
            'province' => 2,
            'designation' => 'IT',
            'status' => 'active'
        );
        User::create($data);

        $data = array(
            'username' => 'IT_ECS',
            'password' => bcrypt('IT_ECS'),
            'level' => 'support',
            'facility_id' => 25,
            'fname' => 'IT',
            'mname' => 'Support',
            'lname' => 'ECS',
            'contact' => 'N/A',
            'email' => 'N/A',
            'muncity' => 80,
            'province' => 2,
            'designation' => 'IT',
            'status' => 'active'
        );
        User::create($data);
    }

    public function returnToAdmin()
    {
        Session::forget('admin');
        $user = Session::get('auth');
        $user = User::find($user->id);
        Session::put('auth',$user);
        print_r($user);
        return redirect($user->level);
    }

    static function lastLogin()
    {
        $user = Session::get('auth');
        $date = date('Y-m-d H:i:s');
        User::where('id',$user->id)
            ->update([
                'last_login' => $date
            ]);
    }

    public function verifyCode($code) {
        $user = Session::get('auth');

        if($user->level == 'admin')
            return 1;

        $tracking = Tracking::where('code',$code)->first();

        if($tracking) {
            if($tracking->referred_from == $user->facility_id) {
                return 1;
            }
            return 0;
        }
        return 0;
    }

    public function verifyRedirected($code) {
        $user = Session::get('auth');

        if($user->level == 'admin')
            return 1;

        $activity = Activity::where('code',$code)->where("status","redirected")->orderBy("date_referred","desc")->first();

        if($activity){
            if($activity->referred_to == $user->facility_id){
                return 1;
            }
            return 0;
        }
        return 0;
    }


    public static function feedbackContent($code,$sender,$msg){
        $sender = User::find($sender);
        $user = Session::get("auth");

        $redirect_track = asset("doctor/referred?referredCode=").$code;

        $name_sender = ucwords(mb_strtolower($sender->fname))." ".ucwords(mb_strtolower($sender->lname));
        $date_now = date('d M h:i a');
        $feedback_count = Feedback::where("code",$code)->count();

        return [
            "code" => $code,
            "picture" => url('resources/img/ro7.png'),
            "feedback_count" => $feedback_count,
            "sender_facility" => $sender->facility_id,
            "user_facility" => $user->facility_id,
            "message" => $msg,
            "userid_sender" => $sender->id,
            "name_sender" => $name_sender,
            "facility_sender" => Facility::find($sender->facility_id)->name,
            "date_now" => $date_now,
            "redirect_track" => $redirect_track
        ];
    }

}
