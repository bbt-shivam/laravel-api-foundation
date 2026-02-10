<?php

namespace App\Events\Password;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword
{
    use Dispatchable, SerializesModels;

    public function __construct(public User $user, public string $token)
    {}

}
