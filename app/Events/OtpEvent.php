<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OtpEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $otp;
    public $token;
    public $user;
    /**
     * Create a new event instance.
     */
    public function __construct($otp,$token,$user)
    {
        //
        $this->token    = $token;
        $this->otp      = $otp;
        $this->user     = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('otp-mail'),
        ];
    }
}
