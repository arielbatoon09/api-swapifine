<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;
    // public $user;
    public $message;
    public $msg_inbox_key;

    public function __construct($inbox_key, $message)
    {
        $this->msg_inbox_key = $inbox_key;
        // $this->user = $user;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // return new PrivateChannel('private-chat.'.$this->user->id);
        return new PrivateChannel('private-chat.' . $this->msg_inbox_key);
    }

    public function broadcastAs()
    {
        return 'private-chat-event';
    }

}
