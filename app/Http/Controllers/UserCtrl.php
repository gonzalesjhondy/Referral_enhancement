<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Login;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserCtrl extends Controller
{
    public function createUser()
    {
        $facilities = Facility::get();
        $username = '';
        foreach($facilities as $row){
            $code = str_pad($row->id,2,0,STR_PAD_LEFT);
            $username = 'DOH'.$code;
            $data = array(
                'password' => bcrypt($username),
                'level' => 'doctor',
                'facility_id' => $row->id,
                'department_id' => 1,
                'fname' => self::getFirstName(),
                'mname' => self::getMiddleName().'.',
                'lname' => self::getLastName(),
                'title' => '',
                'contact' => '418-48'.$code,
                'email' => $username.'@gmail.com',
                'muncity' => '63',
                'province' => '2',
                'accreditation_no' => '',
                'accreditation_validity' => '',
                'license_no' => '',
                'prefix' => '',
                'picture' => '',
                'designation' => '',
                'status' => 'active'
            );
            $match = array('username'=>$username);
            User::updateOrCreate($match,$data);
        }
    }

    function getFirstName()
    {
        $firstNameCollection = array("Harry","Ross",
            "Bruce","Cook",
            "Carolyn","Morgan",
            "Albert","Walker",
            "Randy","Reed",
            "Larry","Barnes",
            "Lois","Wilson",
            "Jesse","Campbell",
            "Ernest","Rogers",
            "Theresa","Patterson",
            "Henry","Simmons",
            "Michelle","Perry",
            "Frank","Butler",
            "Shirley");
        $newFirstName = $firstNameCollection[rand(0, count($firstNameCollection)-1)];
        return $newFirstName;
    }

    function getMiddleName()
    {
        $middleNameCollection = array(
            'A','B','C','D','E','F','G','H','I','J','K','L'
        );
        $newMiddleName = $middleNameCollection[rand(0, count($middleNameCollection)-1)];
        return $newMiddleName;
    }

    function getLastName()
    {
        $lastNameCollection = array("Ruth","Jackson",
            "Debra","Allen",
            "Gerald","Harris",
            "Raymond","Carter",
            "Jacqueline","Torres",
            "Joseph","Nelson",
            "Carlos","Sanchez",
            "Ralph","Clark",
            "Jean","Alexander",
            "Stephen","Roberts",
            "Eric","Long",
            "Amanda","Scott",
            "Teresa","Diaz",
            "Wanda","Thomas");
        $newLastName = $lastNameCollection[rand(0, count($lastNameCollection)-1)];
        return $newLastName;
    }

    public function duty($option)
    {
        $user = Session::get('auth');
        $option = ($option=='onduty') ? 'login' : 'login_off';
        User::where('id',$user->id)
            ->update([
                'login_status' => $option
            ]);

        Login::where('userId',$user->id)
            ->orderBy('id','desc')
            ->first()
            ->update([
                'status' => $option
            ]);
        Session::put('duty',true);
    }
}
