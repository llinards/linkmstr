<?php

namespace App\Livewire\Links;

use App\Models\Link;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LinkStats extends Component
{
    public Link $link;
    public string $period = 'week';
    public array $clickData = [];

    /**
     * Mount the component.
     */
    public function mount(Link $link)
    {
        $this->link = $link;
        $this->loadStats();
    }

    /**
     * Change the time period for stats.
     */
    public function changePeriod(string $period)
    {
        $this->period = $period;
        $this->loadStats();
    }

    /**
     * Load statistics based on the selected period.
     */
    public function loadStats()
    {
        $periodMap = [
            'day' => 1,
            'week' => 7,
            'month' => 30,
            'year' => 365,
            'all' => null,
        ];

        $days = $periodMap[$this->period] ?? 7;

        // Get clicks by day
        $query = $this->link->clicks();

        if ($days) {
            $query->where('created_at', '>=', now()->subDays($days));
        }

        $clicksByDay = $query->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->map(function ($item) {
                return $item->count;
            })
            ->toArray();

        // Create a full date range
        $dateRange = [];
        if ($days) {
            $startDate = now()->subDays($days)->startOfDay();
            $endDate = now()->endOfDay();
        } else {
            $firstClick = $this->link->clicks()->orderBy('created_at')->first();
            $startDate = $firstClick ? $firstClick->created_at->startOfDay() : now()->startOfDay();
            $endDate = now()->endOfDay();
        }

        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateKey = $currentDate->format('Y-m-d');
            $dateRange[$dateKey] = $clicksByDay[$dateKey] ?? 0;
            $currentDate->addDay();
        }

        $this->clickData = $dateRange;
    }

    /**
     * Get top referrers.
     */
    public function getTopReferrers()
    {
        return $this->link->clicks()
            ->whereNotNull('referer')
            ->select('referer', DB::raw('count(*) as count'))
            ->groupBy('referer')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.links.link-stats', [
            'topReferrers' => $this->getTopReferrers(),
        ]);
    }
}
