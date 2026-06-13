<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CandidateCreatedEvent
{
    use Dispatchable, SerializesModels;

    public array $candidate;

    public function __construct(array $candidate)
    {
        $this->candidate = $candidate;
    }
}
