<div class="max-w-3xl h-full mx-auto flex items-center">
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

        <x-status-messages/>

        <form wire:submit="updateLink" class="flex flex-col gap-6">
            <flux:input
                wire:model="originalUrl"
                label="URL to shorten"
                type="url"
                placeholder="https://example.com/very/long/url/to/shorten"
                description="Enter the long URL you want to shorten"
            />
            <flux:input
                wire:model="title"
                label="Title (optional)"
                type="text"
                placeholder="My awesome link"
            />
            <div>
                <flux:textarea
                    label="Description (optional)"
                    wire:model="description"
                    rows="3"
                    placeholder="A brief description about this link"
                />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input
                    wire:model="expiresAt"
                    label="Expiration Date (optional)"
                    type="datetime-local"
                    description="When should this link expire?"
                />
                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Short Code</flux:label>
                        <flux:description>The custom code for your shortened URL</flux:description>
                        <flux:input.group>
                            <flux:input.group.prefix>{{ url('/') }}/</flux:input.group.prefix>
                            <flux:input wire:model="customCode"
                                        type="text"
                                        placeholder="abc123"/>
                        </flux:input.group>
                        <flux:error name="customCode"/>
                    </flux:field>
                </div>
            </div>
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
