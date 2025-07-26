<x-layouts.guest :title="__('This Link Has Expired')">
    <!-- Header -->
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/"
                       class="text-2xl font-bold text-zinc-900 dark:text-white hover:opacity-80 transition-opacity">
                        linkmstr.io
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                            Sign In
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="bg-accent text-accent-foreground px-4 py-2 rounded-lg font-medium hover:bg-accent/90 transition-colors">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-20 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-950 dark:to-zinc-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Expired Icon -->
            <div
                class="w-24 h-24 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <!-- Main Message -->
            <h1 class="text-4xl md:text-5xl font-bold text-zinc-900 dark:text-white mb-6">
                This Link Has Expired
            </h1>

            <p class="text-xl text-zinc-600 dark:text-zinc-400 mb-8 max-w-2xl mx-auto">
                Sorry! The shortened link you're trying to access has expired and is no longer available.
            </p>

            <!-- Link Details Card -->
            @if(isset($link))
                <div class="max-w-2xl mx-auto mb-12">
                    <div
                        class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-8 border border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-12 h-12 bg-zinc-100 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-4 text-left">
                            <div>
                                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Short Link:</p>
                                <p class="text-zinc-900 dark:text-white font-mono bg-zinc-50 dark:bg-zinc-900 px-3 py-2 rounded border">
                                    {{ request()->getSchemeAndHttpHost() }}/{{ $link->short_code ?? 'N/A' }}
                                </p>
                            </div>

                            @if($link->expires_at)
                                <div>
                                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Expired On:</p>
                                    <p class="text-red-600 dark:text-red-400 font-medium">
                                        {{ $link->expires_at->format('F j, Y \a\t g:i A') }}
                                    </p>
                                </div>
                            @endif

                            <div>
                                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400 mb-1">Total Clicks:</p>
                                <p class="text-zinc-900 dark:text-white font-medium">
                                    {{ number_format($link->clicks_count ?? 0) }} clicks
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                <a href="/"
                   class="bg-accent text-accent-foreground px-8 py-4 rounded-lg font-semibold text-lg hover:bg-accent/90 transition-colors">
                    Create Your Own Short Link
                </a>
                <button onclick="history.back()"
                        class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white font-medium text-lg">
                    ← Go Back
                </button>
            </div>

            <!-- Information Cards -->
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div
                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-8 border border-zinc-200 dark:border-zinc-700">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">Why Do Links Expire?</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Links can expire for security, privacy, or promotional reasons. This helps protect against spam
                        and ensures content remains relevant.
                    </p>
                </div>

                <div
                    class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-8 border border-zinc-200 dark:border-zinc-700">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">Create Your Own Links</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">
                        Start creating your own short links with custom expiration dates, analytics, and more powerful
                        features.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-zinc-50 dark:bg-zinc-950">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-4">
                Need Help?
            </h2>
            <p class="text-lg text-zinc-600 dark:text-zinc-400 mb-8">
                If you believe this link expired in error or need assistance, we're here to help.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="mailto:support@linkmstr.io"
                   class="bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-white px-6 py-3 rounded-lg font-medium hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                    Contact Support
                </a>
                <a href="#"
                   class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white font-medium">
                    View Help Center →
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-zinc-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">linkmstr.io</h3>
                    <p class="text-zinc-400">The most powerful link management platform for modern businesses.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-zinc-400">
                        <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Integrations</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-zinc-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-zinc-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Status</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-zinc-800 mt-12 pt-8 text-center text-zinc-400">
                <p>&copy; 2024 linkmstr.io. All rights reserved.</p>
            </div>
        </div>
    </footer>
</x-layouts.guest>
