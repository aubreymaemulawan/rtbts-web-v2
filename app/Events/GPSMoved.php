<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GPSMoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public float $lat;
    public float $lng;
    public float $bus_id;

    public function __construct($lat, $lng, $bus_id)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->bus_id = $bus_id;
    }

    public function broadcastOn()
    {
        return new Channel('rtbtsWeb');
        // return new PrivateChannel('channel-name');
    }
}
