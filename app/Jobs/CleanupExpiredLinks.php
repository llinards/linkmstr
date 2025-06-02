<?php

namespace App\Jobs;

use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanupExpiredLinks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find all links that have expired
        $expiredLinks = Link::where('expires_at', '<', now())
            ->where('is_active', true)
            ->get();

        foreach ($expiredLinks as $link) {
            // Mark link as inactive
            $link->is_active = false;
            $link->save();
        }
    }
}
