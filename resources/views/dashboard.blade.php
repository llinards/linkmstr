<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl py-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 dark:bg-zinc-800 p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Total Links</h2>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Link::where('user_id', auth()->id())->count() }}</p>
                    <a href="{{ route('links.index') }}" class="mt-4 text-sm text-blue-600 hover:underline dark:text-blue-400" wire:navigate>View all links →</a>
                </div>
            </div>
            <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 dark:bg-zinc-800 p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Total Clicks</h2>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Link::where('user_id', auth()->id())->sum('clicks') }}</p>
                    <a href="{{ route('links.create') }}" class="mt-4 text-sm text-blue-600 hover:underline dark:text-blue-400" wire:navigate>Create new link →</a>
                </div>
            </div>
            <div class="bg-white overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 dark:bg-zinc-800 p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Top Link</h2>
                    @php
                        $topLink = \App\Models\Link::where('user_id', auth()->id())
                            ->orderByDesc('clicks')
                            ->first();
                    @endphp
                    @if ($topLink)
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($topLink->clicks) }}</p>
                        <p class="mt-1 text-center text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $topLink->title ?? 'Untitled' }}</p>
                        <a href="{{ route('links.stats', $topLink) }}" class="mt-4 text-sm text-blue-600 hover:underline dark:text-blue-400" wire:navigate>View statistics →</a>
                    @else
                        <p class="mt-2 text-gray-500 dark:text-gray-400">No links yet</p>
                        <a href="{{ route('links.create') }}" class="mt-4 text-sm text-blue-600 hover:underline dark:text-blue-400" wire:navigate>Create first link →</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-800 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Quick Link Creator</h2>
            <livewire:links.link-shortener />
        </div>
    </div>
</x-layouts.app>
