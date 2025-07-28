<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Geographic Data</h3>

    @if($countries->isEmpty())
        <p class="text-sm text-gray-500 dark:text-gray-400">No geographic data available yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Countries Chart -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm p-4">
                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Top Countries</h4>
                <div class="space-y-3">
                    @foreach($countries as $country)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300 flex items-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 mr-2">
                                        {{ $country['code'] }}
                                    </span>
                                    {{ $country['name'] }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">{{ $country['count'] }} ({{ number_format($country['percentage'], 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $country['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Continents Chart -->
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm p-4">
                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Continents</h4>
                <div class="space-y-3">
                    @foreach($continents as $continent)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300 flex items-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mr-2">
                                        {{ $continent['code'] }}
                                    </span>
                                    {{ $continent['name'] }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">{{ $continent['count'] }} ({{ number_format($continent['percentage'], 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $continent['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
