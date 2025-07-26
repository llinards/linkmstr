<?php

use App\Livewire\Links\LinkShortener;
use App\Models\Link;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('link shortener component renders properly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(LinkShortener::class)
        ->assertViewIs('livewire.links.link-shortener')
        ->assertSee('Shorten a URL');
});

test('link can be created with minimum required data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $originalUrl = 'https://example.com/very/long/url';

    Livewire::test(LinkShortener::class)
        ->set('originalUrl', $originalUrl)
        ->call('createLink')
        ->assertHasNoErrors()
        ->assertSet('showForm', false)
        ->assertSet('createdLink.original_url', $originalUrl);

    $this->assertDatabaseHas('links', [
        'user_id' => $user->id,
        'original_url' => $originalUrl,
    ]);
});

test('link creation validates url format', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(LinkShortener::class)
        ->set('originalUrl', 'not-a-valid-url')
        ->call('createLink')
        ->assertHasErrors(['originalUrl' => 'url']);
});

test('link can be created with all optional fields', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $originalUrl = 'https://example.com/very/long/url';
    $title = 'My Test Link';
    $description = 'This is a test link description';
    $customCode = 'test123';
    $expiresAt = now()->addDays(30)->format('Y-m-d\TH:i');

    Livewire::test(LinkShortener::class)
        ->set('originalUrl', $originalUrl)
        ->set('title', $title)
        ->set('description', $description)
        ->set('customCode', $customCode)
        ->set('expiresAt', $expiresAt)
        ->call('createLink')
        ->assertHasNoErrors()
        ->assertSet('showForm', false)
        ->assertSet('createdLink.original_url', $originalUrl)
        ->assertSet('createdLink.title', $title)
        ->assertSet('createdLink.description', $description)
        ->assertSet('createdLink.short_code', $customCode);

    $this->assertDatabaseHas('links', [
        'user_id' => $user->id,
        'original_url' => $originalUrl,
        'title' => $title,
        'description' => $description,
        'short_code' => $customCode,
    ]);
});

test('duplicate custom code shows validation error', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create a link with a specific code first
    Link::factory()->create([
        'user_id' => $user->id,
        'short_code' => 'abc123',
    ]);

    // Try to create another with the same code
    Livewire::test(LinkShortener::class)
        ->set('originalUrl', 'https://example.com')
        ->set('customCode', 'abc123')
        ->call('createLink')
        ->assertHasErrors('customCode');
});
