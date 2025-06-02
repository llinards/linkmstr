<?php

use App\Models\Link;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('dashboard shows link statistics', function () {
    $user = User::factory()->create();

    // Create some links for the user
    Link::factory()->count(3)->create([
        'user_id' => $user->id,
        'clicks' => 10
    ]);

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertStatus(200)
        ->assertSee('Total Links')
        ->assertSee('3') // 3 links
        ->assertSee('Total Clicks')
        ->assertSee('30'); // 30 total clicks (3 links * 10 clicks)
});

test('dashboard shows top link', function () {
    $user = User::factory()->create();

    // Create links with varying click counts
    Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'Low Clicks',
        'clicks' => 5
    ]);

    Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'Medium Clicks',
        'clicks' => 10
    ]);

    Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'Top Link',
        'clicks' => 100
    ]);

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertStatus(200)
        ->assertSee('Top Link')
        ->assertSee('100'); // 100 clicks for top link
});

test('dashboard shows link shortener component', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertStatus(200)
        ->assertSee('Quick Link Creator')
        ->assertSee('Shorten a URL');
});

test('dashboard shows correct stats for each user', function () {
    // Create two users with different link counts and clicks
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // User 1 has 2 links with 5 clicks each
    Link::factory()->count(2)->create([
        'user_id' => $user1->id,
        'clicks' => 5
    ]);

    // User 2 has 5 links with 10 clicks each
    Link::factory()->count(5)->create([
        'user_id' => $user2->id,
        'clicks' => 10
    ]);

    // Check User 1's dashboard
    $this->actingAs($user1);
    $response1 = $this->get('/dashboard');
    $response1->assertSee('2'); // 2 links
    $response1->assertSee('10'); // 10 total clicks

    // Check User 2's dashboard
    $this->actingAs($user2);
    $response2 = $this->get('/dashboard');
    $response2->assertSee('5'); // 5 links
    $response2->assertSee('50'); // 50 total clicks
});
