<?php

namespace App\Providers;

use App\Events\CandidateCreatedEvent;
use App\Events\SendMailEvent;
use App\Listeners\CandidateCreatedListener;
use App\Listeners\SendMailListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CandidateCreatedEvent::class => [ 
            CandidateCreatedListener::class
        ],        
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
