<?php

namespace App\Providers;

use App\Events\PasswordChanged;
use App\Listeners\SendPasswordChangedEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    // protected $listen = [
    //     PasswordChanged::class => [
    //         SendPasswordChangedEmail::class,
    //     ],
    // ];

    public function boot(): void
    {}
}
