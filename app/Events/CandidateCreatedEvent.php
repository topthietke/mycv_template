<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use App\Models\Candidate;

class CandidateCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Candidate $candidate;

    /**
     * Create a new event instance.
     */
    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }
}