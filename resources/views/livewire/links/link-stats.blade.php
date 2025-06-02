<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Link Statistics</h2>
        <a href="{{ route('links.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">← Back to Links</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden dark:bg-zinc-800 mb-6">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $link->title ?? 'Untitled Link' }}</h3>
                    <div class="mt-1 flex items-center space-x-2">
                        <a href="{{ $link->short_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $link->short_url }}</a>
                        <span class="text-xs px-2 py-1 rounded-full {{ $link->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                            {{ $link->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Original URL: <a href="{{ $link->original_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ Str::limit($link->original_url, 50) }}</a></p>
                </div>
                <div class="bg-gray-100 dark:bg-zinc-700 rounded-lg px-6 py-3 flex flex-col md:items-end">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($link->clicks) }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Clicks</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-6">
                <button wire:click="changePeriod('day')" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $period === 'day' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' }}">
                    Last 24 Hours
                </button>
                <button wire:click="changePeriod('week')" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $period === 'week' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' }}">
                    Last 7 Days
                </button>
                <button wire:click="changePeriod('month')" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $period === 'month' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' }}">
                    Last 30 Days
                </button>
                <button wire:click="changePeriod('year')" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $period === 'year' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' }}">
                    Last Year
                </button>
                <button wire:click="changePeriod('all')" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $period === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-gray-300' }}">
                    All Time
                </button>
            </div>

            <div class="h-64 bg-gray-50 dark:bg-zinc-900 rounded-lg p-4">
                @if (count($clickData) > 0)
                    <!-- This is a placeholder for a chart - in a real app you'd use Chart.js or similar -->
                    <div class="h-full flex items-end justify-between relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <p class="text-gray-400 dark:text-gray-500 text-sm">Chart visualization would appear here</p>
                        </div>
                        @foreach ($clickData as $date => $count)
                            @php
                                $maxCount = max($clickData);
                                $height = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                            @endphp
                            <div class="relative h-full flex flex-col items-center z-10">
                                <div class="text-xs text-gray-500 dark:text-gray-400 absolute -top-6">{{ \Carbon\Carbon::parse($date)->format('M d') }}</div>
                                <div class="w-10 bg-blue-500 dark:bg-blue-600 rounded-t-sm" style="height: {{ $height }}%"></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $count }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-full flex items-center justify-center">
                        <p class="text-gray-400 dark:text-gray-500">No click data available for this period</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Top Referrers -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden dark:bg-zinc-800">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top Referrers</h3>

                @if ($topReferrers->count() > 0)
                    <div class="space-y-4">
                        @foreach ($topReferrers as $referrer)
                            <div class="flex items-center justify-between">
                                <div class="truncate max-w-xs text-sm text-gray-600 dark:text-gray-300">
                                    {{ $referrer->referer ?: 'Direct / Unknown' }}
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $referrer->count }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">clicks</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-6 text-center text-gray-500 dark:text-gray-400">
                        No referrer data available
                    </div>
                @endif
            </div>
        </div>

        <!-- Click Details -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden dark:bg-zinc-800">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Click Details</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">First Click</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $link->clicks()->oldest()->first() ? $link->clicks()->oldest()->first()->created_at->format('M d, Y') : 'N/A' }}
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Last Click</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $link->clicks()->latest()->first() ? $link->clicks()->latest()->first()->created_at->format('M d, Y') : 'N/A' }}
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Avg. Clicks/Day</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            @php
                                $firstClick = $link->clicks()->oldest()->first();
                                $daysSinceCreated = $firstClick ? now()->diffInDays($firstClick->created_at) + 1 : 1;
                                $avgClicks = $daysSinceCreated > 0 ? round($link->clicks / $daysSinceCreated, 1) : 0;
                            @endphp
                            {{ $avgClicks }}
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-zinc-700 rounded-lg p-4">
                        <div class="text-sm text-gray-500 dark:text-gray-400">Created</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $link->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
