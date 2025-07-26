<?php

use App\Models\Link;
use App\Models\LinkClick;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Link model', function () {
    it('generates unique short code', function () {
        $code1 = Link::generateUniqueShortCode();
        $code2 = Link::generateUniqueShortCode();

        expect($code1)->not->toBe($code2)
            ->and(strlen($code1))->toBeGreaterThan(0)
            ->and(strlen($code2))->toBeGreaterThan(0);
    });

    it('generates unique code that does not exist in database', function () {
        $link = Link::factory()->create();
        $newCode = Link::generateUniqueShortCode();

        expect($newCode)->not->toBe($link->short_code);
    });

    it('belongs to user', function () {
        $user = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $user->id]);

        expect($link->user)->toBeInstanceOf(User::class)
            ->and($link->user->id)->toBe($user->id);
    });

    it('has many clicks', function () {
        $link = Link::factory()->create();
        LinkClick::factory()->count(3)->create(['link_id' => $link->id]);

        expect($link->clicks()->count())->toBe(3);
    });

    it('casts expires_at to datetime', function () {
        $link = Link::factory()->create([
            'expires_at' => '2024-12-31 23:59:59',
        ]);

        expect($link->expires_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
    });

    it('has active scope', function () {
        Link::factory()->create(['is_active' => true]);
        Link::factory()->create(['is_active' => false]);

        $activeLinks = Link::active()->get();

        expect($activeLinks)->toHaveCount(1)
            ->and($activeLinks->first()->is_active)->toBeTrue();
    });
});
