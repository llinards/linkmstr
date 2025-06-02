<?php

use App\Livewire\Links\LinkManager;
use App\Models\Link;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('link manager component renders properly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(LinkManager::class)
        ->assertViewIs('livewire.links.link-manager')
        ->assertSee('Your Links');
});

test('link manager shows only user own links', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    // Create links for both users
    $link1 = Link::factory()->create(['user_id' => $user1->id, 'title' => 'User 1 Link']);
    $link2 = Link::factory()->create(['user_id' => $user2->id, 'title' => 'User 2 Link']);

    // User 1 should only see their own links
    $this->actingAs($user1);
    Livewire::test(LinkManager::class)
        ->assertSee('User 1 Link')
        ->assertDontSee('User 2 Link');

    // User 2 should only see their own links
    $this->actingAs($user2);
    Livewire::test(LinkManager::class)
        ->assertSee('User 2 Link')
        ->assertDontSee('User 1 Link');
});

test('link manager can toggle link active status', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id, 'is_active' => true]);

    $this->actingAs($user);

    Livewire::test(LinkManager::class)
        ->call('toggleActive', $link->id);

    expect($link->fresh()->is_active)->toBeFalse();

    // Toggle back to active
    Livewire::test(LinkManager::class)
        ->call('toggleActive', $link->id);

    expect($link->fresh()->is_active)->toBeTrue();
});

test('link manager can delete a link', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(LinkManager::class)
        ->call('confirmDelete', $link->id)
        ->assertSet('showDeleteModal', true)
        ->assertSet('linkToDelete.id', $link->id)
        ->call('deleteLink')
        ->assertSet('showDeleteModal', false);

    $this->assertDatabaseMissing('links', ['id' => $link->id]);
});

test('link manager can search links', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create links with specific titles
    Link::factory()->create(['user_id' => $user->id, 'title' => 'Apple Website', 'original_url' => 'https://apple.com']);
    Link::factory()->create(['user_id' => $user->id, 'title' => 'Google Search', 'original_url' => 'https://google.com']);
    Link::factory()->create(['user_id' => $user->id, 'title' => 'Microsoft Products', 'original_url' => 'https://microsoft.com']);

    // Search by title
    Livewire::test(LinkManager::class)
        ->set('search', 'Apple')
        ->assertSee('Apple Website')
        ->assertDontSee('Google Search')
        ->assertDontSee('Microsoft Products');

    // Search by URL
    Livewire::test(LinkManager::class)
        ->set('search', 'google.com')
        ->assertSee('Google Search')
        ->assertDontSee('Apple Website')
        ->assertDontSee('Microsoft Products');
});

test('link manager can sort links', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create links with specific data
    $linkA = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'A Link',
        'clicks' => 100,
        'created_at' => now()->subDays(5)
    ]);

    $linkB = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'B Link',
        'clicks' => 50,
        'created_at' => now()->subDays(2)
    ]);

    $linkC = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'C Link',
        'clicks' => 200,
        'created_at' => now()->subDays(10)
    ]);

    // Default sort is created_at desc (newest first)
    Livewire::test(LinkManager::class)
        ->assertSeeInOrder(['B Link', 'A Link', 'C Link']);

    // Sort by title
    Livewire::test(LinkManager::class)
        ->call('sortBy', 'title')
        ->assertSet('sortField', 'title')
        ->assertSet('sortDirection', 'asc')
        ->assertSeeInOrder(['A Link', 'B Link', 'C Link']);

    // Sort by clicks
    Livewire::test(LinkManager::class)
        ->call('sortBy', 'clicks')
        ->assertSet('sortField', 'clicks')
        ->assertSet('sortDirection', 'asc')
        ->assertSeeInOrder(['B Link', 'A Link', 'C Link']);

    // Reverse sort direction
    Livewire::test(LinkManager::class)
        ->call('sortBy', 'clicks')
        ->call('sortBy', 'clicks')
        ->assertSet('sortDirection', 'desc')
        ->assertSeeInOrder(['C Link', 'A Link', 'B Link']);
});
