    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the cleanup of expired links to run daily
        $schedule->command('links:cleanup')->daily();
    }
