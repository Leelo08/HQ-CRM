<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Jobs\SendMailJob;
use Carbon\Carbon;
use App\User;
use App\Mail\NewArrivals;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('message');
    }

    public function getMessages(){
        return Message::orderBy('created_at', 'desc')->get();
    }

    public function sendMail(Request $request)
    {
        $message = new Message();
        $message->toName = $request->toName;
        $message->toEmail = $request->toEmail;
        $message->fromName = $request->fromName;
        $message->fromEmail = $request->fromEmail;
        $message->body = $request->body;
        $message->save();
        if($request->item == "now") {
            $message->delivered = 'YES';
            $message->send_date = Carbon::now();
            $message->save();   
                dispatch(new SendMailJob($message->toEmail, new NewArrivals($message)));
                
            return response()->json('Mail sent.', 201);
        } else { 
            $message->date_string = date("Y-m-d H:i", strtotime($request->send_date));
            $message->save();   
            return response()->json('Notification will be sent later.', 201);
        }
    }
}
