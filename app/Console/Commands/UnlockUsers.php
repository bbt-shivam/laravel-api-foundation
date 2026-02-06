<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UnlockUsers extends Command
{
    protected $signature = 'app:unlock-users';

    protected $description = 'Unlock user accounts';

    public function handle()
    {
        User::whereNotNull('lock_until')->where('lock_until', '<=', now())->update(['lock_until' => null]);
    }
}
