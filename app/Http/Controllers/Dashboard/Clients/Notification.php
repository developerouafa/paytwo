<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;

class Notification extends Controller
{
    //* function markeAsRead | Delete
    public function markeAsRead(){
        $client = Client::find(auth()->user()->id);
        foreach ($client->unreadNotifications as $notification){
            $notification->delete();
        }
        return redirect()->back();
    }
}
