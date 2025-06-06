<div class="max-w-3xl mx-auto">
    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-zinc-800">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Link</h2>
            <flux:button
                tag="a"
                href="{{ route('links.index') }}"
                variant="ghost"
                size="sm"
            >
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span>Back to Links</span>
                </div>
            </flux:button>
        </div>

        @if (session('message'))
            <div
                class="mb-6 p-4 flex items-center text-sm text-green-600 border border-green-200 rounded-lg bg-green-50 dark:border-green-800 dark:bg-green-900/50 dark:text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="updateLink" class="flex flex-col gap-6">
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
                    label="Description (optional)"
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
                        <flux:input.group label="Short Code" description="The custom code for your shortened URL">
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

            <!-- Status Toggle -->
            <div class="flex flex-col space-y-1">
                <div class="flex items-center">
                    <flux:field variant="inline">
                        <flux:checkbox wire:model="isActive" id="isActive"/>
                        <flux:label>Link is
                            active
                        </flux:label>
                    </flux:field>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 ms-6">When checked, this link will be accessible to
                    users</p>
            </div>

            <div class="flex space-x-4 justify-center mt-2">
                <flux:button type="submit" variant="primary">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span>Update Link</span>
                    </div>
                </flux:button>

                <flux:button
                    tag="a"
                    href="{{ route('links.index') }}"
                    variant="filled"
                >
                    Cancel
                </flux:button>
            </div>
        </form>
    </div>
</div>
