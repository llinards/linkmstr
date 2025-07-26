<?php

use App\Models\Link;
use App\Models\User;
use App\Services\LinkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->service = new LinkService;
    Auth::login($this->user);
});

describe('createLink', function () {
    it('creates a link with valid data', function () {
        $data = [
            'original_url' => 'https://example.com',
            'title' => 'Example Site',
            'description' => 'A test site',
        ];

        $link = $this->service->createLink($data);

        expect($link)->toBeInstanceOf(Link::class)
            ->and($link->user_id)->toBe($this->user->id)
            ->and($link->original_url)->toBe('https://example.com')
            ->and($link->title)->toBe('Example Site')
            ->and($link->description)->toBe('A test site')
            ->and($link->short_code)->not->toBeNull();
    });

    it('creates a link with custom code', function () {
        $data = [
            'original_url' => 'https://example.com',
            'custom_code' => 'abc123',
        ];

        $link = $this->service->createLink($data);

        expect($link->short_code)->toBe('abc123');
    });

    it('generates unique code when custom code is empty', function () {
        $data = [
            'original_url' => 'https://example.com',
            'custom_code' => '',
        ];

        $link = $this->service->createLink($data);

        expect($link->short_code)->not->toBeEmpty()
            ->and($link->short_code)->not->toBe('');
    });

    it('generates unique code when custom code is whitespace', function () {
        $data = [
            'original_url' => 'https://example.com',
            'custom_code' => '   ',
        ];

        $link = $this->service->createLink($data);

        expect($link->short_code)->not->toBeEmpty()
            ->and($link->short_code)->not->toBe('   ');
    });

    it('creates a link with expiration date', function () {
        $expiresAt = now()->addDays(7);
        $data = [
            'original_url' => 'https://example.com',
            'expires_at' => $expiresAt->toDateTimeString(),
        ];

        $link = $this->service->createLink($data);

        expect($link->expires_at->format('Y-m-d H:i:s'))->toBe($expiresAt->format('Y-m-d H:i:s'));
    });

    it('throws validation exception for invalid URL', function () {
        $data = ['original_url' => 'not-a-url'];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });

    it('throws validation exception for URL too long', function () {
        $data = ['original_url' => 'https://'.str_repeat('a', 2000).'.com'];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });

    it('throws validation exception for title too long', function () {
        $data = [
            'original_url' => 'https://example.com',
            'title' => str_repeat('a', 256),
        ];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });

    it('throws validation exception for description too long', function () {
        $data = [
            'original_url' => 'https://example.com',
            'description' => str_repeat('a', 1001),
        ];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });

    it('throws validation exception for past expiration date', function () {
        $data = [
            'original_url' => 'https://example.com',
            'expires_at' => now()->subDay()->toDateTimeString(),
        ];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });

    it('throws validation exception for duplicate custom code', function () {
        Link::factory()->create(['short_code' => 'duplicate']);

        $data = [
            'original_url' => 'https://example.com',
            'custom_code' => 'duplicate',
        ];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });

    it('throws validation exception for non-alphanumeric custom code', function () {
        $data = [
            'original_url' => 'https://example.com',
            'custom_code' => 'abc-123',
        ];

        expect(fn () => $this->service->createLink($data))
            ->toThrow(ValidationException::class);
    });
});

describe('updateLink', function () {
    beforeEach(function () {
        $this->link = Link::factory()->create(['user_id' => $this->user->id]);
    });

    it('updates a link with valid data', function () {
        $data = [
            'original_url' => 'https://updated.com',
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ];

        $updatedLink = $this->service->updateLink($this->link, $data);

        expect($updatedLink->original_url)->toBe('https://updated.com')
            ->and($updatedLink->title)->toBe('Updated Title')
            ->and($updatedLink->description)->toBe('Updated Description');
    });

    it('updates only specified fields', function () {
        $originalTitle = $this->link->title;
        $data = ['original_url' => 'https://updated.com'];

        $updatedLink = $this->service->updateLink($this->link, $data);

        expect($updatedLink->original_url)->toBe('https://updated.com')
            ->and($updatedLink->title)->toBe($originalTitle);
    });

    it('updates is_active status', function () {
        $data = ['is_active' => false];

        $updatedLink = $this->service->updateLink($this->link, $data);

        expect($updatedLink->is_active)->toBeFalse();
    });

    it('updates custom code', function () {
        $data = ['custom_code' => 'newcode'];

        $updatedLink = $this->service->updateLink($this->link, $data);

        expect($updatedLink->short_code)->toBe('newcode');
    });

    it('updates expiration date', function () {
        $newExpiration = now()->addDays(14);
        $data = ['expires_at' => $newExpiration->toDateTimeString()];

        $updatedLink = $this->service->updateLink($this->link, $data);

        expect($updatedLink->expires_at->format('Y-m-d H:i:s'))
            ->toBe($newExpiration->format('Y-m-d H:i:s'));
    });

    it('throws validation exception for invalid URL on update', function () {
        $data = ['original_url' => 'not-a-url'];

        expect(fn () => $this->service->updateLink($this->link, $data))
            ->toThrow(ValidationException::class);
    });

    it('allows same custom code for same link', function () {
        $data = ['custom_code' => $this->link->short_code];

        $updatedLink = $this->service->updateLink($this->link, $data);

        expect($updatedLink->short_code)->toBe($this->link->short_code);
    });

    it('throws validation exception for duplicate custom code from other link', function () {
        $otherLink = Link::factory()->create(['short_code' => 'taken']);

        $data = ['custom_code' => 'taken'];

        expect(fn () => $this->service->updateLink($this->link, $data))
            ->toThrow(ValidationException::class);
    });
});

describe('deleteLink', function () {
    it('deletes a link successfully', function () {
        $link = Link::factory()->create(['user_id' => $this->user->id]);

        $result = $this->service->deleteLink($link);

        expect($result)->toBeTrue()
            ->and(Link::find($link->id))->toBeNull();
    });

    it('returns boolean result', function () {
        $link = Link::factory()->create(['user_id' => $this->user->id]);

        $result = $this->service->deleteLink($link);

        expect($result)->toBeBool();
    });
});
