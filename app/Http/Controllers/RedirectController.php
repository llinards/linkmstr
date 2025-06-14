<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * Handle the redirect for a short URL.
     *
     * @param Request $request
     * @param string $shortCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, string $shortCode)
    {
        $link = Link::where('short_code', $shortCode)
            ->active()
            ->first();

        if (!$link) {
            return redirect()->route('home')->with('error', 'This link is invalid or has expired.');
        }

        // Track the click
        $link->trackClick();

        return redirect($link->original_url);
    }
}
