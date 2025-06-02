<?php

use App\Models\Link;
use App\Models\User;
use App\Services\LinkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('link service can create a link with minimum data', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $linkService = new LinkService();
    $link = $linkService->createLink([
        'original_url' => 'https://example.com'
    ]);

    expect($link)->toBeInstanceOf(Link::class)
        ->and($link->user_id)->toBe($user->id)
        ->and($link->original_url)->toBe('https://example.com')
        ->and($link->short_code)->not->toBeEmpty();
});

test('link service validates urls', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $linkService = new LinkService();

    $this->expectException(ValidationException::class);

    $linkService->createLink([
        'original_url' => 'not-a-valid-url'
    ]);
});

test('link service can create a link with all optional data', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $linkService = new LinkService();
    $expiresAt = now()->addDays(30);

    $link = $linkService->createLink([
        'original_url' => 'https://example.com',
        'title' => 'Example Link',
        'description' => 'This is an example link',
        'expires_at' => $expiresAt,
        'custom_code' => 'custom123'
    ]);

    expect($link->title)->toBe('Example Link')
        ->and($link->description)->toBe('This is an example link')
        ->and($link->expires_at->timestamp)->toBe($expiresAt->timestamp)
        ->and($link->short_code)->toBe('custom123');
});

test('link service can update a link', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $link = Link::factory()->create(['user_id' => $user->id]);

    $linkService = new LinkService();
    $updatedLink = $linkService->updateLink($link, [
        'original_url' => 'https://updated-example.com',
        'title' => 'Updated Title',
        'is_active' => false
    ]);

    expect($updatedLink->original_url)->toBe('https://updated-example.com')
        ->and($updatedLink->title)->toBe('Updated Title')
        ->and($updatedLink->is_active)->toBeFalse();
});

test('link service can delete a link', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $link = Link::factory()->create(['user_id' => $user->id]);

    $linkService = new LinkService();
    $result = $linkService->deleteLink($link);

    expect($result)->toBeTrue();
    $this->assertDatabaseMissing('links', ['id' => $link->id]);
});

test('link service validates custom code uniqueness', function () {
    $user = User::factory()->create();
    Auth::login($user);

    // Create a link with a specific code
    Link::factory()->create([
        'user_id' => $user->id,
        'short_code' => 'duplicate'
    ]);

    $linkService = new LinkService();

    $this->expectException(ValidationException::class);

    $linkService->createLink([
        'original_url' => 'https://example.com',
        'custom_code' => 'duplicate'
    ]);
});
