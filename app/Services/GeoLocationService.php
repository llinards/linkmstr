<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoLocationService
{
    private const CACHE_TTL = 3600; // 1 hour

    /**
     * Get location information from an IP address
     */
    public function getLocationFromIp(string $ip): array
    {
        // Return default for local/invalid IPs
        if ($this->isLocalIp($ip) || ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return $this->getDefaultLocation();
        }

        $cacheKey = "geo_location_{$ip}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($ip) {
            return $this->fetchLocationData($ip);
        });
    }

    /**
     * Fetch location data from IP geolocation API
     */
    private function fetchLocationData(string $ip): array
    {
        try {
            // Using ip-api.com (free tier: 1000 requests/minute with no API key)
            // For production, consider paid services like MaxMind, IPGeolocation, etc.
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}", [
                'fields' => 'status,country,countryCode,continent,continentCode,city,region,timezone',
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === 'success') {
                    return [
                        'country' => $data['country'] ?? 'Unknown',
                        'country_code' => $data['countryCode'] ?? 'XX',
                        'continent' => $data['continent'] ?? 'Unknown',
                        'continent_code' => $data['continentCode'] ?? 'XX',
                        'city' => $data['city'] ?? 'Unknown',
                        'region' => $data['region'] ?? 'Unknown',
                        'timezone' => $data['timezone'] ?? 'UTC',
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error('GeoLocation API failed', [
                'ip' => $ip,
                'error' => $e->getMessage(),
            ]);
        }

        return $this->getDefaultLocation();
    }

    /**
     * Get default location data when geolocation fails
     */
    private function getDefaultLocation(): array
    {
        return [
            'country' => 'Unknown',
            'country_code' => 'XX',
            'continent' => 'Unknown',
            'continent_code' => 'XX',
            'city' => 'Unknown',
            'region' => 'Unknown',
            'timezone' => 'UTC',
        ];
    }

    /**
     * Check if IP address is a local/private IP
     */
    private function isLocalIp(string $ip): bool
    {
        return in_array($ip, ['127.0.0.1', '::1', 'localhost']) ||
               str_starts_with($ip, '192.168.') ||
               str_starts_with($ip, '10.') ||
               (str_starts_with($ip, '172.') &&
                preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip));
    }

    /**
     * Get continent name by its code
     */
    public function getContinentByCode(string $code): string
    {
        $continents = [
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'NA' => 'North America',
            'OC' => 'Oceania',
            'SA' => 'South America',
        ];

        return $continents[$code] ?? 'Unknown';
    }

    /**
     * Get a list of all countries with their codes
     */
    public function getCountries(): array
    {
        return [
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            // Add more countries as needed
            'US' => 'United States',
            'CA' => 'Canada',
            'GB' => 'United Kingdom',
            'AU' => 'Australia',
            'FR' => 'France',
            'DE' => 'Germany',
            'JP' => 'Japan',
            'CN' => 'China',
            'BR' => 'Brazil',
            'IN' => 'India',
            // Add more as needed or use a complete list
        ];
    }

    /**
     * Get a list of all continents with their codes
     */
    public function getContinents(): array
    {
        return [
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'NA' => 'North America',
            'OC' => 'Oceania',
            'SA' => 'South America',
        ];
    }
}
