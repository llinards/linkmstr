<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeoRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'country_codes',
        'continent_codes',
        'target_url',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    public function getCountryCodesArrayAttribute(): array
    {
        return $this->country_codes ? explode(',', $this->country_codes) : [];
    }

    public function getContinentCodesArrayAttribute(): array
    {
        return $this->continent_codes ? explode(',', $this->continent_codes) : [];
    }

    public function matchesLocation(string $countryCode, string $continentCode): bool
    {
        if (! $this->is_active) {
            return false;
        }

        // Check country codes first (more specific)
        if ($this->country_codes && in_array($countryCode, $this->country_codes_array)) {
            return true;
        }

        // Check continent codes (less specific)
        if ($this->continent_codes && in_array($continentCode, $this->continent_codes_array)) {
            return true;
        }

        return false;
    }
}
