<?php

// app/Events/TestEvent.php
// app/Events/TestEvent.php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new Channel('test-channel');
    }

    // Se quiser customizar o nome do evento no front
    public function broadcastAs()
    {
        return 'my-event';
    }
}
