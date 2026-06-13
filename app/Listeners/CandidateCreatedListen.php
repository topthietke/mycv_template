<?php

namespace App\Listeners;

use App\Events\CandidateCreated;
use App\Events\CandidateCreatedEvent;
use App\Factories\UserFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue; // ← chạy ngầm qua Queue

class CandidateCreatedListen implements ShouldQueue
{
    public function __construct(protected UserFactory $user_factory) {
        
    }

    public function handle(CandidateCreatedEvent $event): void
    {
        $candidate = $event->candidate;

        $password = Str::random(16);

        $users = $this->user_factory->create([
            'name'     => $candidate['fullname'],
            'email'    => $candidate['email'],
            'password' => Hash::make($password),
        ]);

        if (!empty($users)) {
            $this->sendMail([
                'name'     => $candidate['fullname'],
                'email'    => $candidate['email'],
                'password' => $password,
                'url'      => config('app.url') . '/login',
            ]);
        }
    }

    protected function sendMail(array $data): void
    {
        // logic gửi mail của bạn
    }
}
