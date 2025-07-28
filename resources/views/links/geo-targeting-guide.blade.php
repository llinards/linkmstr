<x-layouts.app :title="__('Geo Targeting Guide')">
    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Geo Targeting Guide</h2>
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

            <div class="prose dark:prose-invert max-w-none">
                <h3>What is Geo Targeting?</h3>
                <p>
                    Geo targeting allows you to redirect users to different URLs based on their geographic location, all
                    while using a single short link. This is perfect for:
                </p>

                <ul>
                    <li>Sending users to country-specific websites or landing pages</li>
                    <li>Redirecting to localized content based on region</li>
                    <li>Targeting different audiences with tailored messaging</li>
                    <li>Compliance with regional regulations</li>
                </ul>

                <h3>How It Works</h3>

                <p>
                    When a user clicks your short link, the system automatically detects their location based on their IP
                    address and redirects them to the appropriate URL based on your configured rules.
                </p>

                <h3>Setting Up Geo Rules</h3>

                <p>To configure geo targeting for a link:</p>

                <ol>
                    <li>Edit your link</li>
                    <li>Scroll down to the Geo Targeting section</li>
                    <li>Click "Add Rule"</li>
                    <li>Select countries and/or continents to target</li>
                    <li>Enter the destination URL</li>
                    <li>Set priority (higher numbers are evaluated first)</li>
                    <li>Save your rule</li>
                </ol>

                <h3>Rule Priority</h3>

                <p>
                    Rules are evaluated in priority order (highest first). If a user matches multiple rules, the
                    highest-priority matching rule will be used. If no rules match, the user will be redirected to
                    the link's original URL.
                </p>

                <h3>Tips for Effective Geo Targeting</h3>

                <ul>
                    <li><strong>Be specific:</strong> Use country targeting for more precise control</li>
                    <li><strong>Use continents for broader targeting:</strong> Group regions together when appropriate</li>
                    <li><strong>Set meaningful priorities:</strong> Put your most important rules at the top</li>
                    <li><strong>Test your links:</strong> Use VPN services to verify your rules work as expected</li>
                </ul>

                <h3>Country and Continent Codes</h3>

                <p>The system uses standard two-letter codes:</p>

                <ul>
                    <li><strong>Countries:</strong> ISO 3166-1 alpha-2 codes (US, CA, GB, DE, FR, etc.)</li>
                    <li><strong>Continents:</strong> AF (Africa), AN (Antarctica), AS (Asia), EU (Europe), NA (North America), OC (Oceania), SA (South America)</li>
                </ul>

                <h3>Analytics</h3>

                <p>
                    All clicks are tracked with geographic information, allowing you to see which countries and regions
                    your traffic is coming from in the link statistics.
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
