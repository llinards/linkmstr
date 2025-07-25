<div class="border-t pt-6">
    <div class="flex items-center gap-3 mb-4">
        <flux:checkbox wire:model.live="enableUtm"/>
        <div>
            <flux:label class="text-base font-medium">Add UTM Parameters</flux:label>
            <flux:description>Track your marketing campaigns with UTM parameters</flux:description>
        </div>
    </div>

    @if($enableUtm)
        <div class="space-y-4 p-4 bg-gray-50 dark:bg-zinc-700 rounded-lg">
            <!-- Popular Services Dropdown -->
            <div>
                <flux:field>
                    <flux:label>Popular Services (optional)</flux:label>
                    <select
                        wire:model.live="utmService"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-zinc-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:text-white"
                    >
                        <option value="">Choose a service for quick setup</option>
                        @foreach($this->supportedServices as $service)
                            <option value="{{ $service }}">{{ ucfirst($service) }}</option>
                        @endforeach
                    </select>
                    <flux:description class="mt-1">
                        Select a service to automatically fill source and medium fields
                    </flux:description>
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input
                    wire:model.live="utmSource"
                    label="UTM Source"
                    type="text"
                    placeholder="facebook"
                    description="The referrer (e.g., facebook, newsletter)"
                />

                <flux:input
                    wire:model.live="utmMedium"
                    label="UTM Medium"
                    type="text"
                    placeholder="social"
                    description="Marketing medium (e.g., social, email)"
                />
            </div>

            <flux:input
                wire:model.live="utmCampaign"
                label="UTM Campaign"
                type="text"
                placeholder="spring_sale_2024"
                description="Campaign name (e.g., spring_sale_2024)"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input
                    wire:model.live="utmTerm"
                    label="UTM Term (optional)"
                    type="text"
                    placeholder="running shoes"
                    description="Paid search keywords"
                />

                <flux:input
                    wire:model.live="utmContent"
                    label="UTM Content (optional)"
                    type="text"
                    placeholder="banner_ad"
                    description="Ad content identifier"
                />
            </div>
        </div>
    @endif
</div>
