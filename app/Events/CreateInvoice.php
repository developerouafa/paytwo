<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateInvoice implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client;
    public $invoice_id;
    public $user_id;
    public $message;
    public $created_at;


    public function __construct($data)
    {
        $client = Client::find($data['client']);
        $this->client = $client->name;
        $this->user_id = $data['user_id'];
        $this->invoice_id = $data['invoice_id'];
        $this->message = "فاتورة جديد : ";
        $this->created_at = date('Y-m-d H:i:s');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

     public function broadcastOn()
     {
         return ['create-invoice'];
     }

     public function broadcastAs()
     {
         return 'create-invoice';
     }
}
