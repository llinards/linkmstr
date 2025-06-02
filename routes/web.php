<?php

use App\Http\Controllers\RedirectController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Settings routes
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Link management routes
    Route::get('links', function () {
        return view('links.index');
    })->name('links.index');

    Route::get('links/create', function () {
        return view('links.create');
    })->name('links.create');

    Route::get('links/{link}/edit', function (\App\Models\Link $link) {
        if (auth()->id() !== $link->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('links.edit', ['link' => $link]);
    })->name('links.edit');

    Route::get('links/{link}/stats', function (\App\Models\Link $link) {
        if (auth()->id() !== $link->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('links.stats', ['link' => $link]);
    })->name('links.stats');
});

require __DIR__.'/auth.php';

// Public redirect route for short URLs
Route::get('/{shortCode}', RedirectController::class)->name('redirect');


