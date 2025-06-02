<?php

use App\Livewire\Links\LinkEditor;
use App\Models\Link;
use App\Models\User;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('link editor component renders properly', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(LinkEditor::class, ['link' => $link])
            ->assertViewIs('livewire.links.link-editor')
            ->assertSee('Edit Link');
});

test('link editor component initializes with link data', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id'      => $user->id,
        'original_url' => 'https://example.com',
        'title'        => 'Example Link',
        'description'  => 'This is an example link',
        'short_code'   => 'abc123',
        'is_active'    => true,
    ]);

    $this->actingAs($user);

    Livewire::test(LinkEditor::class, ['link' => $link])
            ->assertSet('originalUrl', 'https://example.com')
            ->assertSet('title', 'Example Link')
            ->assertSet('description', 'This is an example link')
            ->assertSet('customCode', 'abc123')
            ->assertSet('isActive', true);
});

test('link can be updated with valid data', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id'      => $user->id,
        'original_url' => 'https://example.com',
        'title'        => 'Original Title',
        'description'  => 'Original description',
        'is_active'    => true,
    ]);

    $this->actingAs($user);

    Livewire::test(LinkEditor::class, ['link' => $link])
            ->set('originalUrl', 'https://updated-example.com')
            ->set('title', 'Updated Title')
            ->set('description', 'Updated description')
            ->set('isActive', false)
            ->call('updateLink')
            ->assertHasNoErrors()
            ->assertDispatched('link-updated');

    $updatedLink = $link->fresh();

    expect($updatedLink->original_url)->toBe('https://updated-example.com')
                                      ->and($updatedLink->title)->toBe('Updated Title')
                                      ->and($updatedLink->description)->toBe('Updated description')
                                      ->and($updatedLink->is_active)->toBeFalse();
});

test('link editor validates url format', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(LinkEditor::class, ['link' => $link])
            ->set('originalUrl', 'not-a-valid-url')
            ->call('updateLink')
            ->assertHasErrors(['originalUrl' => 'url']);
});

test('link short code can be changed if new code is unique', function () {
    $user = User::factory()->create();
    $link = Link::factory()->create([
        'user_id'    => $user->id,
        'short_code' => 'oldcode',
    ]);

    $this->actingAs($user);

    Livewire::test(LinkEditor::class, ['link' => $link])
            ->set('customCode', 'newcode')
            ->call('updateLink')
            ->assertHasNoErrors();

    $updatedLink = $link->fresh();
    expect($updatedLink->short_code)->toBe('newcode');
});

test('link short code change fails if code is already taken', function () {
    $user = User::factory()->create();

    // Create a link with the code we'll try to use
    Link::factory()->create([
        'user_id'    => $user->id,
        'short_code' => 'takencode',
    ]);

    // Create the link we'll update
    $link = Link::factory()->create([
        'user_id'    => $user->id,
        'short_code' => 'originalcode',
    ]);

    $this->actingAs($user);

    $component = Livewire::test(LinkEditor::class, ['link' => $link])
                         ->set('customCode', 'takencode')
                         ->call('updateLink');

    // The error should be added manually by the component
    $component->assertHasErrors('customCode');

    $updatedLink = $link->fresh();
    expect($updatedLink->short_code)->toBe('originalcode');
});
