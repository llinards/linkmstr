<?php

use App\Models\Link;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests cannot access link management pages', function () {
    // Try to access link management pages as a guest
    $this->get('/links')->assertRedirect('/login');
    $this->get('/links/create')->assertRedirect('/login');

    // Create a link to try to edit/view stats
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    $this->get("/links/{$link->id}/edit")->assertRedirect('/login');
    $this->get("/links/{$link->id}/stats")->assertRedirect('/login');
});

test('users can only edit their own links', function () {
    // Create two users
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Create a link for user1
    $link = Link::factory()->create(['user_id' => $user1->id]);

    // User1 can edit their own link
    $this->actingAs($user1);
    $this->get("/links/{$link->id}/edit")->assertStatus(200);

    // User2 cannot edit user1's link
    $this->actingAs($user2);
    $this->get("/links/{$link->id}/edit")->assertStatus(403);
});

test('users can only view stats for their own links', function () {
    // Create two users
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Create a link for user1
    $link = Link::factory()->create(['user_id' => $user1->id]);

    // User1 can view stats for their own link
    $this->actingAs($user1);
    $this->get("/links/{$link->id}/stats")->assertStatus(200);

    // User2 cannot view stats for user1's link
    $this->actingAs($user2);
    $this->get("/links/{$link->id}/stats")->assertStatus(403);
});

test('public redirect route is accessible to everyone', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id' => $user->id,
        'original_url' => 'https://example.com',
        'short_code' => 'public123',
    ]);

    // Guest can access the redirect route
    $this->get('/public123')->assertRedirect('https://example.com');

    // Another user can access the redirect route
    $anotherUser = User::factory()->create();
    $this->actingAs($anotherUser);
    $this->get('/public123')->assertRedirect('https://example.com');
});
