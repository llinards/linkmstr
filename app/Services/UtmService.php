<?php

namespace App\Services;

class UtmService
{
    /**
     * Popular UTM sources and their default parameters
     */
    private const POPULAR_SOURCES = [
        'facebook' => [
            'source' => 'facebook',
            'medium' => 'social',
        ],
        'instagram' => [
            'source' => 'instagram',
            'medium' => 'social',
        ],
        'klaviyo' => [
            'source' => 'klaviyo',
            'medium' => 'email',
        ],
        'google' => [
            'source' => 'google',
            'medium' => 'cpc',
        ],
        'twitter' => [
            'source' => 'twitter',
            'medium' => 'social',
        ],
        'linkedin' => [
            'source' => 'linkedin',
            'medium' => 'social',
        ],
        'tiktok' => [
            'source' => 'tiktok',
            'medium' => 'social',
        ],
        'youtube' => [
            'source' => 'youtube',
            'medium' => 'social',
        ],
        'pinterest' => [
            'source' => 'pinterest',
            'medium' => 'social',
        ],
        'snapchat' => [
            'source' => 'snapchat',
            'medium' => 'social',
        ],
    ];

    /**
     * Generate UTM parameters for a URL.
     *
     * @param  string  $url  The base URL
     * @param  array  $utmParams  UTM parameters (source, medium, campaign, term, content)
     * @return string The URL with UTM parameters
     */
    public function generateUtmUrl(string $url, array $utmParams): string
    {
        $validParams = $this->validateUtmParams($utmParams);

        if (empty($validParams)) {
            return $url;
        }

        $separator = parse_url($url, PHP_URL_QUERY) ? '&' : '?';
        $utmQuery = http_build_query($validParams);

        return $url.$separator.$utmQuery;
    }

    /**
     * Generate UTM URL for popular services.
     *
     * @param  string  $url  The base URL
     * @param  string  $service  The service name (facebook, instagram, klaviyo, etc.)
     * @param  string  $campaign  The campaign name
     * @param  array  $additionalParams  Additional UTM parameters
     * @return string The URL with UTM parameters
     */
    public function generatePopularServiceUtm(string $url, string $service, string $campaign, array $additionalParams = []): string
    {
        $service = strtolower($service);

        if (! isset(self::POPULAR_SOURCES[$service])) {
            throw new \InvalidArgumentException("Service '{$service}' is not supported. Supported services: ".implode(', ', array_keys(self::POPULAR_SOURCES)));
        }

        $utmParams = array_merge(
            self::POPULAR_SOURCES[$service],
            ['utm_campaign' => $campaign],
            $additionalParams
        );

        return $this->generateUtmUrl($url, $utmParams);
    }

    /**
     * Get list of supported popular services.
     */
    public function getSupportedServices(): array
    {
        return array_keys(self::POPULAR_SOURCES);
    }

    /**
     * Get default parameters for a service.
     */
    public function getServiceDefaults(string $service): ?array
    {
        $service = strtolower($service);

        return self::POPULAR_SOURCES[$service] ?? null;
    }

    /**
     * Validate and clean UTM parameters.
     */
    private function validateUtmParams(array $params): array
    {
        $validParams = [];
        $allowedKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

        // Handle both prefixed and non-prefixed keys
        foreach ($params as $key => $value) {
            $value = trim($value);
            if (empty($value)) {
                continue;
            }

            // Add utm_ prefix if not present
            if (! str_starts_with($key, 'utm_') && in_array('utm_'.$key, $allowedKeys)) {
                $key = 'utm_'.$key;
            }

            if (in_array($key, $allowedKeys)) {
                $validParams[$key] = $value;
            }
        }

        return $validParams;
    }
}
