<?php

use App\Models\Link;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('link belongs to a user', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    expect($link->user)->toBeInstanceOf(User::class)
                       ->and($link->user->id)->toBe($user->id);
});

//test('link has many clicks', function () {
//    $link = Link::factory()->create();
//    LinkClick::factory()->count(3)->create(['link_id' => $link->id]);
//
//    // Refresh the link instance and load the relationship
//    $link = $link->fresh(['clicks']);
//
//    expect($link->clicks)->toBeInstanceOf(\Illuminate\Database\Eloquent\Collection::class)
//                         ->and($link->clicks)->toHaveCount(3)
//                         ->and($link->clicks->first())->toBeInstanceOf(LinkClick::class);
//});

test('link active scope filters correctly', function () {
    // Create various link states
    $activeLink   = Link::factory()->active()->create();
    $inactiveLink = Link::factory()->inactive()->create();
    $expiredLink  = Link::factory()->expired()->create();
    $futureLink   = Link::factory()->expiresInFuture()->create();

    $activeLinks = Link::active()->get();

    // Active links should include active links and links with future expiration
    expect($activeLinks)->toHaveCount(2)
                        ->and($activeLinks->pluck('id')->toArray())->toContain($activeLink->id)
                        ->and($activeLinks->pluck('id')->toArray())->toContain($futureLink->id)
                        ->and($activeLinks->pluck('id')->toArray())->not->toContain($inactiveLink->id)
                                                                        ->and($activeLinks->pluck('id')->toArray())->not->toContain($expiredLink->id);
});

test('link can generate a unique short code', function () {
    $shortCode1 = Link::generateUniqueShortCode();
    $shortCode2 = Link::generateUniqueShortCode();

    expect($shortCode1)->toBeString()
                       ->and(strlen($shortCode1))->toBe(6)
                       ->and($shortCode1)->not->toBe($shortCode2);
});

test('link can track clicks', function () {
    $link = Link::factory()->create(['clicks' => 0]);

    // Mock request data
    $this->instance('request', new \Illuminate\Http\Request());

    $link->trackClick();

    expect($link->fresh()->clicks)->toBe(1)
                                  ->and($link->fresh()->clicks()->count())->toBe(1);
});

test('link has short url attribute', function () {
    $link = Link::factory()->create(['short_code' => 'abc123']);

    expect($link->short_url)->toBe(url('abc123'));
});
