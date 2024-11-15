<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\AppointmentStatus;
use App\Events\AdminNotifs;
use App\Events\NewAppointment;
use App\Events\NewFeedback;
use App\Facility;
use App\FacilityAssign;
use App\Login;
use App\User;
use App\UserFeedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class LoginCtrl extends Controller
{
    public function index()
    {
        if($login = Session::get('auth')){
            return redirect($login->level);
        }

        return view('login');
    }

    public function index2()
    {
        if($login = Session::get('auth')){
            return redirect($login->level);
        }

        return view('login2');
    }

    public function index3()
    {
        #return session()->getId();
        #return storage_path('framework/sessions');
        if($login = Session::get('auth')){
            return redirect($login->level);
        }

        return view('login3');
    }

    public function validateLogin2(Request $req)
    {
        $login = User::where('username',$req->username)
            ->first();
        if($login)
        {
            if(Hash::check($req->password,$login->password))
            {
                Session::put('auth',$login);
                $last_login = date('Y-m-d H:i:s');
                User::where('id',$login->id)
                    ->update([
                        'last_login' => $last_login,
                        'login_status' => 'login'
                    ]);
                $checkLastLogin = self::checkLastLogin($login->id);

                $l = new Login();
                $l->userId = $login->id;
                $l->login = $last_login;
                $l->logout = date("Y-m-d H:i:s",strtotime("0000-00-00 00:00:00"));
                $l->status = 'login';
                $l->type = $req->login_type;
                $l->login_link = $req->login_link;
                $l->save();

                if($checkLastLogin > 0 ){
                    Login::where('id',$checkLastLogin)
                        ->update([
                            'logout' => $last_login
                        ]);
                }

                $multiple = FacilityAssign::where('user_id',$login->id)->where('status','Active')->count();
                if($multiple > 1)
                    Session::put('multiple_login', true);
                else
                    Session::put('multiple_login', false);

                if($login->status=='inactive'){
                    Session::forget('auth');
                    return [
                        "error_notif" => true,
                        "error_msg" => "Your account was deactivated by the administrator, please call 711 DOH Health Line."
                    ];
                }
                elseif($login->level=='doctor')
                    return url('doctor');
                else if($login->level=='chief')
                    return url('chief');
                else if($login->level=='support')
                    return url('support');
                else if($login->level=='mcc')
                    return url('mcc');
                else if($login->level=='admin')
                    return url('admin');
                else if($login->level=='eoc_region')
                    return url('eoc_region');
                else if($login->level=='eoc_city')
                    return url('eoc_city');
                else if($login->level=='opcen')
                    return url('opcen');
                else if($login->level=='bed_tracker')
                    return url('bed_tracker');
                else if($login->level=='midwife')
                    return url('midwife');
                else if($login->level=='medical_dispatcher')
                    return url('medical_dispatcher');
                else if($login->level=='nurse')
                    return url('nurse');
                else if($login->level=='vaccine')
                    return url('vaccine');
                else if($login->level=='mayor')
                    return url('doctor');
                else if($login->level=='dmo')
                    return url('doctor');
                else{
                    Session::forget('auth');
                    return [
                        "error_notif" => true,
                        "error_msg" => "You don't have access in this system."
                    ];
                }
            }
            else{
                return [
                    "error_notif" => true,
                    "error_msg" => "These credentials do not match our records."
                ];
            }
        }
        else{
            return [
                "error_notif" => true,
                "error_msg" => "These credentials do not match our records."
            ];
        }
    }

    public function validateLogin(Request $req)
    {
        $login = User::where('username',$req->username)
            ->first();
        if($login)
        {
            if(Hash::check($req->password,$login->password))
            {
                Session::put('auth',$login);
                $last_login = date('Y-m-d H:i:s');
                User::where('id',$login->id)
                    ->update([
                        'last_login' => $last_login,
                        'login_status' => 'login'
                    ]);
                $checkLastLogin = self::checkLastLogin($login->id);

                $l = new Login();
                $l->userId = $login->id;
                $l->login = $last_login;
                $l->logout = date("Y-m-d H:i:s",strtotime("0000-00-00 00:00:00"));
                $l->status = 'login';
                $l->type = $req->login_type;
                $l->login_link = $req->login_link;
                $l->save();

                if($checkLastLogin > 0 ){
                    Login::where('id',$checkLastLogin)
                        ->update([
                            'logout' => $last_login
                        ]);
                }

                if($login->status=='inactive'){
                    Session::forget('auth');
                    return Redirect::back()->with('error','Your account was deactivated by the administrator, please call 711 DOH health line.');
                }
                elseif($login->level=='doctor')
                    return redirect('doctor');
                else if($login->level=='chief')
                    return redirect('chief');
                else if($login->level=='support')
                    return redirect('support');
                else if($login->level=='mcc')
                    return redirect('mcc');
                else if($login->level=='admin')
                    return redirect('admin');
                else if($login->level=='eoc_region')
                    return redirect('eoc_region');
                else if($login->level=='eoc_city')
                    return redirect('eoc_city');
                else if($login->level=='opcen')
                    return redirect('opcen');
                else if($login->level=='bed_tracker')
                    return redirect('bed_tracker');
                else if($login->level=='midwife')
                    return redirect('midwife');
                else if($login->level=='medical_dispatcher')
                    return redirect('medical_dispatcher');
                else if($login->level=='nurse')
                    return redirect('nurse');
                else if($login->level=='vaccine')
                    return redirect('vaccine');
                else if($login->level=='mayor')
                    return redirect('doctor');
                else if($login->level=='dmo')
                    return redirect('doctor');
                else{
                    Session::forget('auth');
                    return Redirect::back()->with('error','You don\'t have access in this system.')->with('username',$req->username);
                }
            }
            else{
                return Redirect::back()->with('error','These credentials do not match our records')->with('username',$req->username);
            }
        }
        else{
            return Redirect::back()->with('error','These credentials do not match our records')->with('username',$req->username);
        }
    }

    function checkLastLogin($id)
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

    public function resetPassword(Request $req)
    {
        $user = Session::get('auth');
        if(Hash::check($req->current,$user->password))
        {
            if($req->newPass == $req->confirm){
                $lenght = strlen($req->newPass);
                if($lenght>=6)
                {
                    $password = bcrypt($req->newPass);
                    User::where('id',$user->id)
                        ->update([
                            'password' => $password
                        ]);
                    return 'changed';
                }else{
                    return 'length';
                }
            }else{
                return 'not_match';
            }
        }else{
            return 'error';
        }
    }

    public function updateToken($token){
        $user = Session::get("auth");
        Login::where("userId",$user->id)->where("login","like","%".date('Y-m-d')."%")->where("logout","0000-00-00 00:00:00")
                ->update([
                    "token" => $token
                ]);
    }

    public function createAppointment(Request $req) {
        $data = new Appointment();
        $data->name = $req->faci_name;
        $data->requester = $req->requester;
        $data->email = $req->email;
        $data->contact = $req->contact;
        $data->preferred_date = (isset($req->date)) ? $req->date : '';
        $data->category = $req->category;
        $data->message = $req->message;
        $data->status = 'new';
        $data->save();

        $status = new AppointmentStatus();
        $status->appt_id = $data->id;
        $status->status = 'new';
        $status->save();

        broadcast(new AdminNotifs([
            "appt_id" => $data->id,
            "appt_faci" => $data->name,
            "appt_requester" => $data->requester,
            "date_requested" => date_format($data->created_at, 'M d, Y h:i a'),
            "notif_type" => "new appointment"
        ]));

        /* send email to user with the message that their appointment was created successfully */
        $email_doh = $_ENV['EMAIL_ADDRESS'];
        $email_password = $_ENV['EMAIL_PASSWORD'];
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $email_doh;                             //SMTP username
            $mail->Password   = $email_password;                        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($email_doh, 'DOH-CVCHD E-Referral');
            $mail->addAddress($req->email);     //Add a recipient
            $mail->addReplyTo($email_doh);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Appointment Request Sent!';
            $mail->AddEmbeddedImage('resources/img/doh.png', 'doh_logo');
            $mail->AddEmbeddedImage('resources/img/f1.jpg', 'f1_logo');
            $mail->Body    =
                '<html><body>
                <div align="center">
                <div style="width: 600px; border: 20px groove whitesmoke; background: linear-gradient(to bottom right, #ffffff 23%, #ccffcc 104%); padding: 30px; margin: 10px;">
                    <div align="center">
                        <img src="cid:doh_logo" width="100"> &emsp;&emsp;
                        <img src="cid:f1_logo" width="100"><br><br>
                        <div style="font-size: 14px">
                            Republic of the Philippines<br>&emsp;&emsp;
                            DEPARTMENT OF HEALTH<br>
                            <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                            Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                            Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                            Official Website: <a href="http://www.ro7.doh.gov.ph" target="_blank">http://www.ro7.doh.gov.ph</a> Email Address: dohro7@gmail.com<br>
                        </div>
                    </div>
                
                    <div align="center">
                        <div align="center" style="font-family: Trebuchet MS; font-size: 14px; width: 500px; background-color: ghostwhite; border: 15px double darkgreen; padding: 25px; margin: 20px;">
                            Good day!<br><br>
                            
                            This is to inform you that your appointment request has been successfully sent to the E-Referral team. 
                            The team will evaluate your request and will get back to you as soon as possible.<br><br>
                            Thank you and have a great day.<br><br><br>
                            
                            Sincerely, <br>
                            The DOH-CVCHD E-Referral Team
                        </div>
                    </div>
                </div></div>
                </body></html>
                ';
            $mail->AltBody = '
                    Good day!<br><br>
                    
                    This is to inform you that your appointment request has been successfully sent to the E-Referral team. 
                    The team will evaluate your request and will get back to you as soon as possible.<br><br>
                    
                    Thank you and have a great day.<br><br><br>
                    
                    Sincerely, <br>
                    The DOH-CVCHD E-Referral Team';
            $mail->send();
            return 'Email has been sent';
        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendFeedback(Request $req) {
        $data = new UserFeedback();
        $data->name = $req->name;
        $data->email = $req->email;
        $data->contact = $req->contact;
        $data->subject = $req->subject;
        $data->message = $req->message;
        $data->status = "new";
        $data->save();

        broadcast(new AdminNotifs([
            "feedback_id" => $data->id,
            "date_submitted" => date_format($data->created_at, 'M d, Y h:i a'),
            "notif_type" => "new feedback"
        ]));

        /* send email to user with the message that their feedback was received successfully */
        $email_doh = $_ENV['EMAIL_ADDRESS'];
        $email_password = $_ENV['EMAIL_PASSWORD'];
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $email_doh;                             //SMTP username
            $mail->Password   = $email_password;                        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($email_doh, 'DOH-CVCHD E-Referral');
            $mail->addAddress($req->email);     //Add a recipient
            $mail->addReplyTo($email_doh);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Feedback Received!';
            $mail->AddEmbeddedImage('resources/img/doh.png', 'doh_logo');
            $mail->AddEmbeddedImage('resources/img/f1.jpg', 'f1_logo');
            $mail->Body    =
                '<html><body>
                <div align="center">
                <div style="width: 600px; border: 20px groove whitesmoke; background: linear-gradient(to bottom right, #ffffff 23%, #ccffcc 104%); padding: 30px; margin: 10px;">
                    <div align="center">
                        <img src="cid:doh_logo" width="100"> &emsp;&emsp;
                        <img src="cid:f1_logo" width="100"><br><br>
                        <div style="font-size: 14px">
                            Republic of the Philippines<br>&emsp;&emsp;
                            DEPARTMENT OF HEALTH<br>
                            <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                            Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                            Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                            Official Website: <a href="http://www.ro7.doh.gov.ph" target="_blank">http://www.ro7.doh.gov.ph</a> Email Address: dohro7@gmail.com<br>
                        </div>
                    </div>
                
                    <div align="center">
                        <div align="center" style="font-family: Trebuchet MS; font-size: 14px; width: 500px; background-color: ghostwhite; border: 15px double darkgreen; padding: 25px; margin: 20px;">
                            Good day!<br><br>
                            
                            We have received your feedback. Our team is always finding ways to improve the system.
                            We appreciate your response and we will use it to further improve the system.<br><br>
                
                            Thank you and stay safe.<br><br><br>
                
                            Sincerely, <br>
                            The DOH-CVCHD E-Referral Team
                        </div>
                    </div>
                </div></div>
                </body></html>
                ';
            $mail->AltBody =
                'Good day!<br>
                We have received your feedback. Our team is always finding ways to improve the system.
                We appreciate your response and we will use it to further improve the system.<br>
    
                Thank you and stay safe.<br>
    
                Sincerely, <br>
                The DOH-CVCHD E-Referral Team
                ';
            $mail->send();
            return 'Email has been sent';
        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function countUsers(){
        $doctor = User::where('level','doctor')->where('status','active')->count();
        $government = Facility::where('referral_used','yes')
            ->where(function($query){
                $query->where('hospital_type','doh_hospital')
                    ->orWhere('hospital_type','government');
            })->count();
        $private = Facility::where('referral_used','yes')->where('hospital_type','private')->count();
        $rhu = Facility::where('referral_used','yes')->where('hospital_type','RHU')->count();

        return [
            'doctor' => $doctor,
            'government' => $government,
            'private' => $private,
            'rhu' => $rhu
        ];
    }
}