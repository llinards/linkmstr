<?php

use App\Models\Link;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('valid short links redirect to original url', function () {
    $user = User::factory()->create();
    $link = Link::factory()->active()->create([
        'user_id'      => $user->id,
        'original_url' => 'https://example.com',
        'short_code'   => 'test123',
        'clicks'       => 0, // Explicitly set initial clicks to 0
    ]);

    // Verify initial state
    expect($link->clicks)->toBe(0)
                         ->and($link->clicks()->count())->toBe(0);

    $response = $this->get('/test123');

    $response->assertRedirect('https://example.com');

    // Refresh the model from database
    $link->refresh();

    // Check if the click was tracked
    expect($link->clicks)->toBe(1)
                         ->and($link->clicks()->count())->toBe(1);
});

test('inactive links do not redirect', function () {
    $user = User::factory()->create();
    $link = Link::factory()->inactive()->create([
        'user_id'      => $user->id,
        'original_url' => 'https://example.com',
        'short_code'   => 'inactive',
        'clicks'       => 0, // Explicitly set initial clicks to 0
    ]);

    $response = $this->get('/inactive');

    $response->assertRedirect(route('home'))
             ->assertSessionHas('error');

    // Refresh the model from database
    $link->refresh();

    // Check that no click was tracked
    expect($link->clicks)->toBe(0)
                         ->and($link->clicks()->count())->toBe(0);
});

test('expired links do not redirect', function () {
    $user = User::factory()->create();
    $link = Link::factory()->expired()->create([
        'user_id'      => $user->id,
        'original_url' => 'https://example.com',
        'short_code'   => 'expired',
        'clicks'       => 0, // Explicitly set initial clicks to 0
    ]);

    $response = $this->get('/expired');

    $response->assertRedirect(route('home'))
             ->assertSessionHas('error');

    // Refresh the model from database
    $link->refresh();

    // Check that no click was tracked
    expect($link->clicks)->toBe(0)
                         ->and($link->clicks()->count())->toBe(0);
});

test('nonexistent short codes do not redirect', function () {
    $response = $this->get('/nonexistent');

    $response->assertRedirect(route('home'))
             ->assertSessionHas('error');
});
