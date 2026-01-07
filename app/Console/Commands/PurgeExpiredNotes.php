<?php

namespace App\Console\Commands;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PurgeExpiredNotes extends Command
{
    protected $signature = 'notes:purge-expired';

    protected $description = 'Permanently delete all expired notes from the database';

    public function handle(): int
    {
        $count = Note::where('expiry_date', '<', Carbon::now())->count();

        if ($count === 0) {
            $this->info('No expired notes to purge.');
            return Command::SUCCESS;
        }

        Note::where('expiry_date', '<', Carbon::now())->delete();

        $this->info("Purged {$count} expired note(s).");

        return Command::SUCCESS;
    }
}
