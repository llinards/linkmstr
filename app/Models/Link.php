<?php

namespace App\Models;

use App\Services\GeoLocationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'clicks' => 'integer',
    ];

    /**
     * Get the user that owns the link.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the clicks for the link.
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(LinkClick::class);
    }

    /**
     * Get the geo rules for the link.
     */
    public function geoRules(): HasMany
    {
        return $this->hasMany(GeoRule::class)->orderBy('priority', 'desc');
    }

    /**
     * Get the active geo rules for the link.
     */
    public function activeGeoRules(): HasMany
    {
        return $this->hasMany(GeoRule::class)->where('is_active', true)->orderBy('priority', 'desc');
    }

    /**
     * Scope a query to only include active links.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Generate a unique short code.
     */
    public static function generateUniqueShortCode(int $length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        do {
            $shortCode = '';
            for ($i = 0; $i < $length; $i++) {
                $shortCode .= $characters[random_int(0, $charactersLength - 1)];
            }
        } while (static::where('short_code', $shortCode)->exists());

        return $shortCode;
    }

    /**
     * Track a click on this link.
     */
    public function trackClick(): void
    {
        $this->increment('clicks');

        $geoService = app(GeoLocationService::class);
        $location = $geoService->getLocationFromIp(request()->ip());

        $this->clicks()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer' => request()->header('referer'),
            'country' => $location['country'],
            'country_code' => $location['country_code'],
            'city' => $location['city'],
            'continent' => $location['continent'],
            'continent_code' => $location['continent_code'],
        ]);
    }

    /**
     * Get the full shortened URL.
     */
    public function getShortUrlAttribute(): string
    {
        return url($this->short_code);
    }
}
