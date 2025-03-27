<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdateEvent implements shouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $lat;
    public $lng;
    public function __construct($lat ,$lng)
    {

        $this->lat =$lat;
        $this->lng= $lng;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('deliveries'),//auth  دي بدل ما كانت برايفت تشانال بقيت تشانال بس عشان تبعت لاي حد مش لازم يكون عامل
        ];
    }
    public function broadcastWith(){
        return[
            'lat'=>$this->lat,
            'lng'=>$this->lng,
        ];


    }
}
