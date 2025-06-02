<?php

use App\Jobs\CleanupExpiredLinks;
use App\Models\Link;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('cleanup job marks expired links as inactive', function () {
    $user = User::factory()->create();

    // Create an active link that's expired
    $expiredLink = Link::factory()->create([
        'user_id' => $user->id,
        'is_active' => true,
        'expires_at' => now()->subDay() // Expired 1 day ago
    ]);

    // Create an active link that's not expired
    $activeLink = Link::factory()->create([
        'user_id' => $user->id,
        'is_active' => true,
        'expires_at' => now()->addDay() // Expires in 1 day
    ]);

    // Create an inactive link that's expired (should remain inactive)
    $inactiveExpiredLink = Link::factory()->create([
        'user_id' => $user->id,
        'is_active' => false,
        'expires_at' => now()->subDay() // Expired 1 day ago
    ]);

    // Run the cleanup job
    CleanupExpiredLinks::dispatch();

    // Check the links after cleanup
    expect($expiredLink->fresh()->is_active)->toBeFalse()
        ->and($activeLink->fresh()->is_active)->toBeTrue()
        ->and($inactiveExpiredLink->fresh()->is_active)->toBeFalse();
});

test('cleanup command dispatches cleanup job', function () {
    // Mock the dispatcher to make sure the job is dispatched
    $this->mock('Illuminate\Contracts\Bus\Dispatcher')
        ->shouldReceive('dispatch')
        ->with(Mockery::type(CleanupExpiredLinks::class))
        ->once();

    // Run the command
    $this->artisan('links:cleanup')
        ->expectsOutput('Cleaning up expired links...')
        ->expectsOutput('Cleanup job dispatched!')
        ->assertExitCode(0);
});
