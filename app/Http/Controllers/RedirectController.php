<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\GeoTargetingService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Request $request, string $shortCode, GeoTargetingService $geoTargetingService)
    {
        $link = Link::where('short_code', $shortCode)
            ->active()
            ->first();

        if (! $link) {
            return view('expired');
        }

        // Get the target URL based on geo-targeting
        $targetUrl = $geoTargetingService->getTargetUrl($link, $request->ip());

        // Get location data for tracking
        $locationData = $geoTargetingService->getLocationData($request->ip());

        // Track the click with geo information
        $link->trackClick($locationData);

        return redirect($targetUrl);
    }
}
