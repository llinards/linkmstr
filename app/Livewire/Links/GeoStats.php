<?php

namespace App\Livewire\Links;

use App\Models\Link;
use App\Services\GeoLocationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GeoStats extends Component
{
    public Link $link;
    public array $countries = [];
    public array $continents = [];

    public function mount(Link $link, GeoLocationService $geoLocationService)
    {
        $this->link = $link;

        // Get country stats
        $countryData = $this->link->clicks()
            ->select('country_code', 'country', DB::raw('count(*) as count'))
            ->whereNotNull('country_code')
            ->groupBy('country_code', 'country')
            ->orderBy('count', 'desc')
            ->get();

        $totalCountryClicks = $countryData->sum('count');

        $this->countries = $countryData->map(function ($item) use ($totalCountryClicks) {
            return [
                'code' => $item->country_code,
                'name' => $item->country,
                'count' => $item->count,
                'percentage' => $totalCountryClicks > 0 ? ($item->count / $totalCountryClicks * 100) : 0,
            ];
        })->toArray();

        // Get continent stats
        $continentData = $this->link->clicks()
            ->select('continent_code', 'continent', DB::raw('count(*) as count'))
            ->whereNotNull('continent_code')
            ->groupBy('continent_code', 'continent')
            ->orderBy('count', 'desc')
            ->get();

        $totalContinentClicks = $continentData->sum('count');

        $this->continents = $continentData->map(function ($item) use ($totalContinentClicks) {
            return [
                'code' => $item->continent_code,
                'name' => $item->continent,
                'count' => $item->count,
                'percentage' => $totalContinentClicks > 0 ? ($item->count / $totalContinentClicks * 100) : 0,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.links.geo-stats');
    }
}
