<?php

namespace App\Http\Controllers\support;

use App\Feedback;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ChatCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('support');
    }

    public function index()
    {
        return view('support.chat');
    }

    public function send(Request $req)
    {
        $user = Session::get('auth');

        $data = array(
            'code'=> 'it-group-chat',
            'sender'=> $user->id,
            'receiver'=> 0,
            'message'=> $req->message,
        );

        $f = Feedback::create($data);

        return $f->id;
    }

    public function messages(){
        $data = Feedback::select(
            'feedback.id as id',
            'feedback.sender as sender',
            'feedback.message',
            'users.fname as fname',
            'users.lname as lname',
            'facility.name as facility',
            'facility.abbr as abbr',
            'feedback.created_at as date'
        )
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('code','it-group-chat')
            ->latest('feedback.id')
            ->take(7)
            ->get();

        return view('support.chat_template',[
            'data' => $data->reverse()
        ]);
    }

    public function loadMessages()
    {
        $id = Session::get('last_scroll_id');

        $data = Feedback::select(
            'feedback.id as id',
            'feedback.sender as sender',
            'feedback.message',
            'users.fname as fname',
            'users.lname as lname',
            'facility.name as facility',
            'facility.abbr as abbr',
            'feedback.created_at as date'
        )
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('code','it-group-chat')
            ->where('feedback.id','<',$id)
            ->latest('feedback.id')
            ->take(7)
            ->get();

        if(count($data)==0)
            return '';

        return view('support.chat_template',[
            'data' => $data->reverse()
        ]);
    }

    public function reply($id)
    {
        $user = Session::get('auth');
        $position = '';
        $icon = 'receiver.png';

        $data = Feedback::select(
            'feedback.sender as sender',
            'feedback.message',
            'users.fname as fname',
            'users.lname as lname',
            'facility.name as facility',
            'facility.abbr as abbr',
            'feedback.created_at as date'
        )
            ->leftJoin('users','users.id','=','feedback.sender')
            ->leftJoin('facility','facility.id','=','users.facility_id') //TODO: possible changes for multiple facility log-in
            ->where('feedback.id',$id)
            ->first();

        if($user->id==$data->sender){
            $position = 'right';
            $icon = 'sender.png';
        }

        $fullname = ucwords(mb_strtolower($data->fname))." ".ucwords(mb_strtolower($data->lname));
        $picture = url('resources/img/'.$icon);

        $content = '
            <div class="direct-chat-msg '.$position.'">
                    <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">'.$fullname.'</span>
                    <span class="direct-chat-timestamp pull-right">'.date('d M h:i a',strtotime($data->date)).'</span>
                    </div>

                    <img class="direct-chat-img" title="'.$data->facility.'" src="'.$picture.'" alt="'.$data->facility.'">
                    <div class="direct-chat-text">
                        '.$data->message.'
                    </div>

                </div>
        ';

        return $content;
    }

    public function sample()
    {
        echo Session::get('last_scroll_id');
    }
}
