<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class Notification extends Controller
{
    //* function markeAsRead | Delete
    public function markeAsRead(){
        $client = Client::find(auth()->user()->id);
        foreach ($client->unreadNotifications as $notification){
            $notification->delete();
        }
        // return redirect()->back();
    }
}
