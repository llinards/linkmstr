<?php

namespace App\Services;

use App\Models\GeoRule;
use App\Models\Link;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GeoTargetingService
{
    public function __construct(
        private GeoLocationService $geoLocationService
    ) {}

    /**
     * Get target URL based on user's location
     */
    public function getTargetUrl(Link $link, string $ip): string
    {
        // Get user's location
        $location = $this->geoLocationService->getLocationFromIp($ip);

        // Find matching geo rule
        $geoRule = $this->findMatchingRule($link, $location['country_code'], $location['continent_code']);

        if ($geoRule) {
            return $geoRule->target_url;
        }

        // Return original URL if no geo rule matches
        return $link->original_url;
    }

    /**
     * Get location data for tracking
     */
    public function getLocationData(string $ip): array
    {
        return $this->geoLocationService->getLocationFromIp($ip);
    }

    /**
     * Find matching geo rule for a location
     */
    private function findMatchingRule(Link $link, string $countryCode, string $continentCode): ?GeoRule
    {
        return $link->activeGeoRules()
            ->get()
            ->first(function (GeoRule $rule) use ($countryCode, $continentCode) {
                return $rule->matchesLocation($countryCode, $continentCode);
            });
    }

    /**
     * Create a new geo rule
     *
     * @throws ValidationException
     */
    public function createGeoRule(Link $link, array $data): GeoRule
    {
        $validator = Validator::make($data, [
            'country_codes' => 'nullable|string',
            'continent_codes' => 'nullable|string',
            'target_url' => 'required|url|max:2000',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Ensure at least one targeting method is specified
        if (empty($data['country_codes']) && empty($data['continent_codes'])) {
            throw ValidationException::withMessages([
                'country_codes' => 'At least one country code or continent code must be specified.',
            ]);
        }

        return $link->geoRules()->create([
            'country_codes' => $data['country_codes'] ?? null,
            'continent_codes' => $data['continent_codes'] ?? null,
            'target_url' => $data['target_url'],
            'priority' => $data['priority'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Update an existing geo rule
     *
     * @throws ValidationException
     */
    public function updateGeoRule(GeoRule $geoRule, array $data): GeoRule
    {
        $validator = Validator::make($data, [
            'country_codes' => 'nullable|string',
            'continent_codes' => 'nullable|string',
            'target_url' => 'required|url|max:2000',
            'priority' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Ensure at least one targeting method is specified
        if (empty($data['country_codes']) && empty($data['continent_codes'])) {
            throw ValidationException::withMessages([
                'country_codes' => 'At least one country code or continent code must be specified.',
            ]);
        }

        $geoRule->update([
            'country_codes' => $data['country_codes'] ?? null,
            'continent_codes' => $data['continent_codes'] ?? null,
            'target_url' => $data['target_url'],
            'priority' => $data['priority'] ?? $geoRule->priority,
            'is_active' => $data['is_active'] ?? $geoRule->is_active,
        ]);

        return $geoRule;
    }

    /**
     * Delete a geo rule
     */
    public function deleteGeoRule(GeoRule $geoRule): bool
    {
        return $geoRule->delete();
    }
}
