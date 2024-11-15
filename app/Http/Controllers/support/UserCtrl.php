<?php

namespace App\Http\Controllers\support;

use App\Department;
use App\Facility;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('support');
    }

    public function index(Request $request)
    {
        $user = Session::get('auth');
        $search = $request->search;

        $data = User::where('facility_id',$user->facility_id)
            ->where(function($q) use($search){
                $q->where("users.level","doctor")
                    ->orWhere("users.level","midwife")
                    ->orWhere("users.level","nurse")
                    ->orWhere("users.level","medical_dispatcher");
            })
            ->where(function($q) use($search){
                $q->where('fname','like',"%$search%")
                ->orwhere('mname','like',"%$search%")
                ->orwhere('lname','like',"%$search%")
                ->orwhere('username','like',"%$search%")
                ->orwhere(DB::raw('concat(fname," ",lname)'),'like',"$search")
                ->orwhere(DB::raw('concat(lname," ",fname)'),'like',"$search");
            });

        if($request->department_id)
            $data = $data->where("department_id",$request->department_id == 'no_department' ? 0 : $request->department_id);


        $data = $data
            ->orderBy('fname','asc')
            ->paginate(15);

        $departments = Department::get();
        $group_by_department = User::
                                select(
                                        DB::raw("count(users.id) as y"),
                                        DB::raw("coalesce(department.description,'NO DEPARTMENT') as label"),
                                        DB::raw("coalesce(department.id,'no_id') as department_id")
                                    )
                                    ->leftJoin("department","department.id","=","users.department_id")
                                    ->where("users.facility_id",$user->facility_id) //TODO: possible changes for multiple facility log-in
                                    ->where(function($q) use($search){
                                        $q->where("users.level","doctor")
                                        ->orWhere("users.level","midwife");
                                    })
                                    ->groupBy("users.department_id")
                                    ->get();

        return view('support.users',[
            'title' => 'Manage Users',
            'data' => $data,
            'departments' => $departments,
            'search' => $search,
            "group_by_department" => $group_by_department
        ]);
    }

    public function create()
    {
        $departments = Department::get();
        return view('support.addUser',[
            'title' => 'Add User',
            'departments' => $departments
        ]);
    }

    public function store(Request $req)
    {
        $user = Session::get('auth');
        $match = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname
        );

        $facility = Facility::find($req->facility_id);

        $data = array(
            'level' => $req->level,
            'facility_id' => $user->facility_id,
            'status' => 'active',
            'contact' => $req->contact,
            'email' => $req->email,
            'designation' => $req->designation,
            'department_id' => $req->department_id,
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'muncity' => $facility->muncity,
            'province' => $facility->province,
            'created_by' => $user->id
        );
        User::updateOrCreate($match,$data);
        return 'added';
    }

    public function add(Request $req)
    {
        $user = Session::get('auth');
        $match = array(
            'fname' => $req->fname,
            'mname' => ($req->mname) ? $req->mname: '',
            'lname' => $req->lname
        );
        $email = 'N/A';
        if($req->email)
        {
            $email = $req->email;
        }

        $facility = Facility::find($user->facility_id);
        $data = array(
            'level' => $req->level,
            'facility_id' => $user->facility_id,
            'status' => 'active',
            'contact' => $req->contact,
            'email' => $email,
            'designation' => $req->designation,
            'department_id' => $req->department_id,
            'username' => $req->username,
            'password' => bcrypt($req->password),
            'muncity' => $facility->muncity,
            'province' => $facility->province
        );
        User::updateOrCreate($match,$data);

        return redirect()->back()->with('status','added');
    }

    public function update(Request $req)
    {
        $user = Session::get('auth');
        $facility = Facility::find($user->facility_id);
        $data = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'level' => $req->level,
            'contact' => $req->contact,
            'email' => ($req->email) ? $req->email: 'N/A',
            'designation' => $req->designation,
            'department_id' => $req->department_id,
            'username' => $req->username,
            'status' => $req->status,
            'muncity' => $facility->muncity,
            'province' => $facility->province
        );

        if ($req->password)
        {
            $data['password'] = bcrypt($req->password);
        }


        User::where('id',$req->user_id)
                ->update($data);
        return 'updated';
    }

    public function check($string)
    {
        $user = Session::get('auth');
        $check = User::where('username',$string)
                ->where('id','!=',$user->id)
                ->first();
        if($check){
            return '1';
        }
        return '0';
    }

    public function checkUpdate($string,$user_id)
    {
        $user = Session::get('auth');
        $check = User::where('username',$string)
                ->where('id','!=',$user->id)
                ->where('id','!=',$user_id)
                ->first();
        if($check){
            return '1';
        }
        return '0';
    }

    public function info($user_id)
    {
        return User::find($user_id);
    }
}
