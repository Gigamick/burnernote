<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PurgeAbandonedSignups extends Command
{
    protected $signature = 'users:purge-abandoned';

    protected $description = 'Delete user accounts that never completed onboarding after 24 hours';

    public function handle(): int
    {
        $count = User::whereNull('account_mode')
            ->where('created_at', '<', now()->subHours(24))
            ->count();

        if ($count === 0) {
            $this->info('No abandoned signups to purge.');
            return Command::SUCCESS;
        }

        User::whereNull('account_mode')
            ->where('created_at', '<', now()->subHours(24))
            ->delete();

        $this->info("Purged {$count} abandoned signup(s).");

        return Command::SUCCESS;
    }
}
