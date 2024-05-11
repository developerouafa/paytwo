<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatForm($user_id){
        $receiver = User::where('id',2)->first();
        return view('Dashboard/dashboard_user/chat.chat', compact('receiver'));
    }

    public function sendMessage($user_id, Request $request)
    {
        $data['sender'] = Auth::user()->id;
        $data['receiver'] = 2;
        $data['message'] = $request->message;
        Message::create($data);
        $receiver = User::where('id', 2)->first();
        \broadcast(new ChatSent($receiver, $request->message));
        return response()->json('Message Sent');
    }
}
