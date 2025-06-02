<div class="max-w-3xl mx-auto">
    @if (!$showForm && $createdLink)
        <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-800 overflow-hidden">
            <div class="flex flex-col items-center justify-center space-y-4 text-center">
                <div class="h-16 w-16 bg-green-100 dark:bg-green-900 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Your link has been shortened!</h3>
                <div class="flex items-center justify-center w-full mt-4">
                    <div class="relative w-full">
                        <input type="text" readonly value="{{ $createdLink->short_url }}" class="block w-full px-4 py-3 text-base text-center bg-gray-100 border border-gray-200 rounded-lg cursor-pointer dark:bg-zinc-700 dark:text-white dark:border-zinc-600" onclick="this.select()">
                        <button wire:click="copyToClipboard" type="button" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @if ($showCopiedMessage)
                    <p class="text-sm text-green-600 dark:text-green-400">Copied to clipboard!</p>
                @endif
                <div class="mt-6">
                    <button wire:click="createAnother" type="button" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create Another Link
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-800">
            <form wire:submit="createLink">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Shorten a URL</h2>

                <div class="mb-6">
                    <label for="originalUrl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL to shorten <span class="text-red-500">*</span></label>
                    <input wire:model="originalUrl" type="url" id="originalUrl" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="https://example.com/very/long/url/to/shorten" required>
                    @error('originalUrl') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title (optional)</label>
                    <input wire:model="title" type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="My awesome link">
                    @error('title') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description (optional)</label>
                    <textarea wire:model="description" id="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="A brief description about this link"></textarea>
                    @error('description') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="expiresAt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiration Date (optional)</label>
                        <input wire:model="expiresAt" type="datetime-local" id="expiresAt" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white">
                        @error('expiresAt') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="customCode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Custom Code (optional)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md dark:bg-zinc-600 dark:text-gray-400 dark:border-zinc-600">
                                {{ url('/') }}/
                            </span>
                            <input wire:model="customCode" type="text" id="customCode" class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="abc123">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank for auto-generated code</p>
                        @error('customCode') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                    Shorten URL
                </button>
            </form>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('copy-to-clipboard', (event) => {
                navigator.clipboard.writeText(event.url);
            });
        });
    </script>
</div>
