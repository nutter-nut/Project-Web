<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogActivity implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $user_name;
    public $type;
    public $page;
    public $icon;
    public $description;
    public $now;

    public function __construct($user_id, $user_name, $type, $page, $icon, $description, $now)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->type = $type;
        $this->page = $page;
        $this->icon = $icon;
        $this->description = $description;
        $this->now = $now;
    }

    public function broadcastOn()
    {
        return ['log-activity'];
    }

    public function broadcastAs()
    {
        return 'LogActivity';
    }
}
