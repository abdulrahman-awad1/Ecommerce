<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order) // v دي عشان لو عايز اباصي داتا او استقبل اوبجيكت
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array //PUSHER دي خاصه ب ال
    {
        $user_id=Auth::user();
        return [
            new PrivateChannel('App.Models.User.'.$user_id),
        ];
    }
    // تحديد البيانات التي سيتم إرسالها عبر البث
    public function broadcastWith()
    {
        return [
            'message' =>$this->order,
        ];
    }
}
