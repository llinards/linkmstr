<div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm p-6 mt-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Geo Targeting</h3>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        Configure different target URLs based on visitor's location. Rules are evaluated in priority order (highest
        first).
    </p>

    <!-- Flash Messages -->
    <x-status-messages/>

    <!-- Current Geo Rules -->
    <div class="mb-6">
        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Current Rules</h4>

        @if ($geoRules->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                No geo targeting rules defined. Add a rule below.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Priority
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Countries
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Continents
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Target URL
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($geoRules as $rule)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">{{ $rule->priority }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">
                                @if ($rule->country_codes)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (explode(',', $rule->country_codes) as $code)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    {{ $code }}
                                                </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400 italic">Any</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">
                                @if ($rule->continent_codes)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (explode(',', $rule->continent_codes) as $code)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ $code }}
                                                </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400 italic">Any</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">
                                <div class="max-w-xs truncate" title="{{ $rule->target_url }}">
                                    {{ $rule->target_url }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if ($rule->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Active
                                        </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            Inactive
                                        </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex space-x-2">
                                    <flux:button wire:click="editGeoRule({{ $rule->id }})" size="xs" variant="ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </flux:button>
                                    <flux:button wire:click="deleteGeoRule({{ $rule->id }})" size="xs" variant="danger"
                                                 color="danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Add/Edit Geo Rule Form -->
    <div class="bg-gray-50 dark:bg-zinc-700/50 p-4 rounded-lg">
        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">
            {{ $editingRuleId ? 'Edit' : 'Add' }} Rule
        </h4>

        <form wire:submit.prevent="{{ $editingRuleId ? 'updateGeoRule' : 'createGeoRule' }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Countries Selection -->
                <div>
                    <flux:field>
                        <flux:label>Target Countries</flux:label>
                        <flux:description>Select countries to target with this rule</flux:description>
                        <select
                            wire:model="selectedCountries"
                            multiple
                            class="w-full px-3 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-accent-foreground dark:bg-zinc-900 dark:text-white"
                        >
                            @foreach ($countries as $code => $name)
                                <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                            @endforeach
                        </select>
                        <flux:error name="countryCodesInput"/>
                    </flux:field>

                </div>

                <!-- Continents Selection -->
                <div>
                    <flux:field>
                        <flux:label>Target Continents</flux:label>
                        <flux:description>Select continents to target with this rule</flux:description>
                        <select
                            wire:model="selectedContinents"
                            multiple
                            class="w-full px-3 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-accent-foreground dark:bg-zinc-900 dark:text-white"
                        >

                            @foreach ($continents as $code => $name)
                                <option value="{{ $code }}">{{ $name }} ({{ $code }})</option>
                            @endforeach
                        </select>
                        <flux:error name="continentCodesInput"/>
                    </flux:field>
                </div>
            </div>

            <!-- Target URL -->
            <flux:input
                wire:model="targetUrl"
                label="Target URL"
                type="url"
                placeholder="https://example.com/geo-specific-page"
                description="URL to redirect users to when they match this rule"
            />

            <!-- Priority -->
            <flux:input
                wire:model="priority"
                label="Priority"
                type="number"
                min="0"
                description="Higher priority rules are evaluated first"
            />

            <!-- Active Status -->
            <div class="flex items-center h-full">
                <flux:field variant="inline">
                    <flux:checkbox wire:model="isActive" id="isActive"/>
                    <flux:label>Rule is active</flux:label>
                </flux:field>
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                @if ($editingRuleId)
                    <flux:button wire:click="cancelEdit" type="button" variant="ghost">
                        Cancel
                    </flux:button>
                @endif

                <flux:button type="submit" variant="primary">
                    {{ $editingRuleId ? 'Update' : 'Add' }} Rule
                </flux:button>
            </div>
        </form>
    </div>
</div>
