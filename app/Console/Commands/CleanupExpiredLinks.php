<?php

namespace App\Console\Commands;

use App\Jobs\CleanupExpiredLinks as CleanupExpiredLinksJob;
use Illuminate\Console\Command;

class CleanupExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired links';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning up expired links...');

        CleanupExpiredLinksJob::dispatch();

        $this->info('Cleanup job dispatched!');

        return Command::SUCCESS;
    }
}
