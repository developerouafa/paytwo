<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyEventData implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client_id;
    public $invoice_id;

    public function __construct($data)
    {
        $clients = Client::find($data['client_id']);
        $this->client_id = $clients->name;
        $this->invoice_id = $data['invoice_id'];
    }

    public function broadcastOn()
    {
        return ['my-channeldata'];
    }

    public function broadcastAs()
    {
        return 'my-event-data';
    }
}
