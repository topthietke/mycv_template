<?php

namespace App\Listeners;

use App\Events\CandidateCreatedEvent;
use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Database\Factories\UserFactory;
class CandidateCreatedListener
{   
    use Helpers;
    protected UserFactory $user_factory;

    public function __construct(UserFactory $user_factory)
    {
        $this->user_factory = $user_factory;
    }

    public function handle(CandidateCreatedEvent $event): void
    {
        $candidate = $event->candidate;
        $data_users = [
            'name'     => $candidate->fullname,
            'email'    => $candidate->email,
            'password' => Hash::make($candidate->password),
        ];        
        $this->user_factory->create($data_users);        
    }
}