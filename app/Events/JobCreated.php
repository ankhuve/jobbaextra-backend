<?php

namespace App\Events;

use App\Events\Event;
use App\Http\Requests\Request;
use App\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobCreated extends Event
{
    use SerializesModels;

    public $job;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job, Request $request)
    {
        $this->job = $job;
        $this->request = $request;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
