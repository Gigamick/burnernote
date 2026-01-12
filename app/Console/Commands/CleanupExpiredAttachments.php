<?php

namespace App\Console\Commands;

use App\Models\NoteAttachment;
use Illuminate\Console\Command;

class CleanupExpiredAttachments extends Command
{
    protected $signature = 'attachments:cleanup';

    protected $description = 'Delete expired attachments from database and R2 storage';

    public function handle(): int
    {
        $expired = NoteAttachment::whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->get();

        $count = $expired->count();

        if ($count === 0) {
            $this->info('No expired attachments to clean up.');
            return self::SUCCESS;
        }

        $this->info("Cleaning up {$count} expired attachments...");

        foreach ($expired as $attachment) {
            $attachment->deleteFromStorage();
            $attachment->delete();
        }

        $this->info("Deleted {$count} attachments.");

        return self::SUCCESS;
    }
}
