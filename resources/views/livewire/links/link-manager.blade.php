<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Your Links</h1>

        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="search"
                   class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white"
                   placeholder="Search links...">
        </div>
    </div>

    @if (session('message'))
        <x-success-alert class="mb-6">
            {{ session('message') }}
        </x-success-alert>
    @endif

    @if (session('error'))
        <x-error-alert class="mb-6">
            {{ session('error') }}
        </x-error-alert>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('title')">
                    <div class="flex items-center">
                        Title
                        @if ($sortField === 'title')
                            <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('short_code')">
                    <div class="flex items-center">
                        Short URL
                        @if ($sortField === 'short_code')
                            <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('clicks')">
                    <div class="flex items-center">
                        Clicks
                        @if ($sortField === 'clicks')
                            <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('created_at')">
                    <div class="flex items-center">
                        Created
                        @if ($sortField === 'created_at')
                            <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5. пропорц5a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                            </svg>
                        @endif
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($links as $link)
                <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex flex-col">
                            <span>{{ $link->title ?? 'Untitled' }}</span>
                            <span
                                class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">{{ $link->original_url }}</span>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="pr-2">{{ $link->short_url }}</span>
                            <button wire:click="copyToClipboard({{ $link->id }})"
                                    class="text-gray-700 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                    <path
                                        d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ number_format($link->clicks) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $link->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-start space-y-2">
                            <span
                                class="text-xs font-medium {{ $link->is_active ? 'text-green-500' : 'text-red-500' }}">
                                {{ $link->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <flux:switch :checked="$link->is_active"
                                         wire:click="toggleActive({{ $link->id }})"/>
                        </div>
                        <flux:error name="links.{{ $link->id }}.is_active"/>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <!-- Edit Icon -->
                            <a href="{{ route('links.edit', $link) }}" wire:navigate
                               class="text-gray-700 hover:text-blue-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-zinc-700 rounded-lg transition-colors"
                               title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </a>

                            <!-- Stats Icon -->
                            <a href="{{ route('links.stats', $link) }}" wire:navigate
                               class="text-gray-700 hover:text-blue-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-zinc-700 rounded-lg transition-colors"
                               title="Statistics">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>
                            </a>

                            <!-- Delete Icon -->
                            <button wire:confirm="Are you sure?" wire:click="deleteLink({{ $link->id }})" wire:navigate
                                    class="text-red-600 hover:text-red-800 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-zinc-700 rounded-lg transition-colors"
                                    title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <p class="text-xl font-medium">No links found</p>
                            <p class="mt-1">Get started by creating your first shortened link</p>
                            <flux:button class="mt-4" href="{{route('links.create')}}" wire:navigate variant="primary">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                         fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span>Create Link</span>
                                </div>
                            </flux:button>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $links->links() }}
    </div>
</div>
@script
<script>
    document.addEventListener('livewire:initialized', () => {
    @this.on('copy-to-clipboard', handleClipboardCopy)
        ;
    });

    async function handleClipboardCopy(event) {
        try {
            await navigator.clipboard.writeText(event.url);
        } catch (error) {
            console.error('Failed to copy to clipboard:', error);
        }
    }
</script>
@endscript
