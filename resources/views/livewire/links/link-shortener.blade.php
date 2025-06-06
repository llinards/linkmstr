<div class="max-w-3xl mx-auto">
    @if (!$showForm && $createdLink)
        <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-800 overflow-hidden">
            <div class="flex flex-col items-center justify-center space-y-4 text-center">
                <div class="h-16 w-16 bg-green-100 dark:bg-green-900 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-400"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>

                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Your link has been shortened!</h3>

                <div class="flex items-center justify-center w-full mt-4">
                    <div class="relative w-full">
                        <flux:input
                            type="text"
                            readonly
                            :value="$createdLink->short_url"
                            class="text-center cursor-pointer"
                            onclick="this.select()"
                        />
                        <flux:button
                            wire:click="copyToClipboard"
                            type="button"
                            variant="ghost"
                            size="sm"
                            class="absolute inset-y-0 right-0 flex items-center px-4"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                <path
                                    d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                            </svg>
                        </flux:button>
                    </div>
                </div>

                @if ($showCopiedMessage)
                    <div
                        class="mb-6 p-4 flex items-center text-sm text-green-600 border border-green-200 rounded-lg bg-green-50 dark:border-green-800 dark:bg-green-900/50 dark:text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Copied to clipboard!
                    </div>
                @endif

                <div class="mt-6">
                    <div class="flex justify-center">
                        <flux:button
                            wire:click="createAnother"
                            type="button"
                            variant="primary"
                        >
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span>Create Another Link</span>
                            </div>
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-800">
            <form wire:submit="createLink" class="flex flex-col gap-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Shorten a URL</h2>

                <!-- URL to shorten -->
                <flux:input
                    wire:model="originalUrl"
                    label="URL to shorten"
                    type="url"
                    required
                    placeholder="https://example.com/very/long/url/to/shorten"
                    description="Enter the long URL you want to shorten"
                />

                <!-- Title -->
                <flux:input
                    wire:model="title"
                    label="Title (optional)"
                    type="text"
                    placeholder="My awesome link"
                />

                <!-- Description -->
                <div>
                    <flux:textarea
                        label="Description
                        (optional)"
                        wire:model="description"
                        rows="3"
                        placeholder="A brief description about this link"
                    />
                    @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Expiration Date -->
                    <flux:input
                        wire:model="expiresAt"
                        label="Expiration Date (optional)"
                        type="datetime-local"
                        description="When should this link expire?"
                    />

                    <!-- Custom Code -->
                    <div class="space-y-2">
                        <div class="flex">
                            <flux:input.group label="Custom Code
                            (optional)"
                                              description="Leave blank for auto-generated code">
                                <flux:input.group.prefix>{{ url('/') }}/</flux:input.group.prefix>
                                <flux:input wire:model="customCode"
                                            type="text"
                                            placeholder="abc123"/>
                            </flux:input.group>
                        </div>
                        @error('customCode')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-center">
                    <flux:button type="submit" variant="primary">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Shorten URL</span>
                        </div>
                    </flux:button>
                </div>
            </form>
        </div>
    @endif

    <script>
        function copyToClipboard(text) {
            // Check if the modern Clipboard API is available
            if (navigator.clipboard && window.isSecureContext) {
                return navigator.clipboard.writeText(text);
            } else {
                // Fallback method for older browsers or non-secure contexts
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                return new Promise((resolve, reject) => {
                    try {
                        const successful = document.execCommand('copy');
                        document.body.removeChild(textArea);
                        if (successful) {
                            resolve();
                        } else {
                            reject(new Error('Copy command failed'));
                        }
                    } catch (err) {
                        document.body.removeChild(textArea);
                        reject(err);
                    }
                });
            }
        }

        document.addEventListener('livewire:initialized', () => {
        @this.on('copy-to-clipboard', (event) => {
            copyToClipboard(event.url)
                .then(() => {
                    console.log('Successfully copied to clipboard');
                })
                .catch(err => {
                    console.error('Failed to copy to clipboard:', err);
                });
        })
            ;
        });
    </script>
</div>
