<?php

use App\Livewire\Links\LinkStats;
use App\Models\Link;
use App\Models\LinkClick;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('link stats component renders properly', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(LinkStats::class, ['link' => $link])
        ->assertViewIs('livewire.links.link-stats')
        ->assertSee('Link Statistics');
});

test('link stats shows basic link information', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Link',
        'original_url' => 'https://example.com',
        'clicks' => 42
    ]);

    $this->actingAs($user);

    Livewire::test(LinkStats::class, ['link' => $link])
        ->assertSee('Test Link')
        ->assertSee('https://example.com')
        ->assertSee('42'); // Total clicks
});

test('link stats period can be changed', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(LinkStats::class, ['link' => $link])
        ->assertSet('period', 'week')
        ->call('changePeriod', 'month')
        ->assertSet('period', 'month')
        ->call('changePeriod', 'all')
        ->assertSet('period', 'all');
});

test('link stats shows click data', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    // Create clicks with different dates
    LinkClick::factory()->create([
        'link_id' => $link->id,
        'created_at' => now()->subDays(1)
    ]);

    LinkClick::factory()->count(2)->create([
        'link_id' => $link->id,
        'created_at' => now()->subDays(2)
    ]);

    LinkClick::factory()->count(3)->create([
        'link_id' => $link->id,
        'created_at' => now()->subDays(3)
    ]);

    $this->actingAs($user);

    $component = Livewire::test(LinkStats::class, ['link' => $link]);

    // We can't easily test the exact chart data, but we can verify it's populated
    expect($component->get('clickData'))->toBeArray()
        ->and($component->get('clickData'))->not->toBeEmpty();
});

test('link stats shows top referrers', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    // Create clicks with different referrers
    LinkClick::factory()->count(3)->create([
        'link_id' => $link->id,
        'referer' => 'https://google.com'
    ]);

    LinkClick::factory()->count(2)->create([
        'link_id' => $link->id,
        'referer' => 'https://facebook.com'
    ]);

    LinkClick::factory()->create([
        'link_id' => $link->id,
        'referer' => 'https://twitter.com'
    ]);

    $this->actingAs($user);

    Livewire::test(LinkStats::class, ['link' => $link])
        ->assertSee('google.com')
        ->assertSee('facebook.com')
        ->assertSee('twitter.com');
});
