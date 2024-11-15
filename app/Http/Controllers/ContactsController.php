<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ContactsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('chat');
    }
    
    public function get()
    {
        $user = Session::get('auth');
        $picture = asset('resources/img/receiver.png');
        // get all users except the authenticated one
        if($user->level == 'opcen'){
            $contacts = User::
                select(
                    "users.id",
                    DB::raw("'$picture' as picture"),
                    DB::raw("if(
                            users.level = 'doctor',concat('Dr. ',users.fname,' ',users.lname),concat(users.fname,' ',users.lname)
                        ) as name"),
                    "facility.name as facility",
                    "users.contact"
                )
                ->leftJoin("facility","facility.id","=","users.facility_id") //TODO: possible changes for multiple facility log-in
                ->where('users.id', '!=', Session::get('auth')->id)
                ->where('users.level','=','opcen')
                ->orderBy('users.fname','desc')
                ->get();
        }
        elseif($user->level == 'doctor' || $user->level == 'support'){
            $contacts = User::
                select(
                    "users.id",
                    DB::raw("'$picture' as picture"),
                    DB::raw("if(
                        users.level = 'doctor',concat('Dr. ',users.fname,' ',users.lname),concat(users.fname,' ',users.lname)
                    ) as name"),
                    "facility.name as facility",
                    "users.contact"
                )
                ->leftJoin("facility","facility.id","=","users.facility_id") //TODO: possible changes for multiple facility log-in
                ->where('users.id', '!=', Session::get('auth')->id)
                ->where(function($q){
                    $q->where('users.level','=','doctor');
                    $q->orWhere('users.level','=','support');
                })
                ->orderBy('users.fname','desc')
                ->get();
        }

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', Session::get('auth')->id)
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });


        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', Session::get('auth')->id)->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function($q) use ($id) {
            $q->where('from', Session::get('auth')->id);
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', Session::get('auth')->id);
        })
            ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'from' => $request->from,
            'to' => $request->to,
            'text' => $request->text
        ]);

        broadcast(new MessageSent($this->chatUserOnboard(), $message))->toOthers();
        return ['status' => 'Message Sent!'];
    }

    public function getContact() {
        $user = Session::get('auth');
        $picture = "https://cvehrs.doh.gov.ph/dummy/referral/resources/img/receiver.png";
        $data = User::
        select(
            "users.id",
            DB::raw("'$picture' as picture"),
            DB::raw("if(
                            users.level = 'doctor',concat('Dr. ',users.fname,' ',users.lname),concat(users.fname,' ',users.lname)
                        ) as name"),
            "facility.name as facility",
            "users.contact"
        )
            ->leftJoin("facility","facility.id","=","users.facility_id") //TODO: possible changes for multiple facility log-in
            ->where('users.id', '=', $user->id)
            ->first();

        return $data;
    }

    public function chatUserOnboard(){
        return $this->getContact();
    }
}