<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>linkmstr.io.io</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-zinc-900">
<!-- Header -->
<header class="border-b border-zinc-200 dark:border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">linkmstr.io</h1>
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

<!-- Hero Section -->
<section class="py-20 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-950 dark:to-zinc-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-6xl font-bold text-zinc-900 dark:text-white mb-6">
            Shorten Links.<br>
            <span class="text-accent">Track Performance.</span>
        </h1>
        <p class="text-xl text-zinc-600 dark:text-zinc-400 mb-8 max-w-3xl mx-auto">
            Transform long, unwieldy URLs into short, branded links. Track clicks, analyze performance, and optimize
            your marketing campaigns with powerful analytics.
        </p>

        <!-- Link Shortener Demo -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex flex-col sm:flex-row gap-4">
                    <input type="url"
                           placeholder="Enter your long URL here..."
                           class="flex-1 px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:bg-zinc-900 dark:text-white">
                    <button
                        class="bg-accent text-accent-foreground px-6 py-3 rounded-lg font-medium hover:bg-accent/90 transition-colors">
                        Shorten URL
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}"
               class="bg-accent text-accent-foreground px-8 py-4 rounded-lg font-semibold text-lg hover:bg-accent/90 transition-colors">
                Start Free Trial
            </a>
            <a href="#features"
               class="text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white font-medium">
                Learn More →
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white dark:bg-zinc-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-zinc-900 dark:text-white mb-4">
                Everything you need to manage links
            </h2>
            <p class="text-xl text-zinc-600 dark:text-zinc-400 max-w-3xl mx-auto">
                From simple URL shortening to advanced analytics and team collaboration
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-xl bg-zinc-50 dark:bg-zinc-800">
                <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">Smart URL Shortening</h3>
                <p class="text-zinc-600 dark:text-zinc-400">Create branded short links with custom domains and track
                    every click with detailed analytics.</p>
            </div>

            <div class="text-center p-8 rounded-xl bg-zinc-50 dark:bg-zinc-800">
                <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">Advanced Analytics</h3>
                <p class="text-zinc-600 dark:text-zinc-400">Get insights into click performance, geographic data, and
                    traffic sources to optimize your campaigns.</p>
            </div>

            <div class="text-center p-8 rounded-xl bg-zinc-50 dark:bg-zinc-800">
                <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">Team Collaboration</h3>
                <p class="text-zinc-600 dark:text-zinc-400">Share links with your team, set permissions, and collaborate
                    on campaigns with ease.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="py-20 bg-zinc-50 dark:bg-zinc-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-zinc-900 dark:text-white mb-4">
                Choose the perfect plan
            </h2>
            <p class="text-xl text-zinc-600 dark:text-zinc-400">
                Start free and scale as you grow
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Starter Plan -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg p-8 border border-zinc-200 dark:border-zinc-800">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">Starter</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white">$0</span>
                        <span class="text-zinc-600 dark:text-zinc-400">/month</span>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">Perfect for personal use</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">100 links per month</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Basic analytics</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">7-day data retention</span>
                    </li>
                </ul>

                <button
                    class="w-full bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-white py-3 rounded-lg font-medium hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                    Get Started Free
                </button>
            </div>

            <!-- Pro Plan -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg p-8 border-2 border-accent relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-accent text-accent-foreground px-4 py-1 rounded-full text-sm font-medium">
                            Most Popular
                        </span>
                </div>

                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">Pro</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white">$19</span>
                        <span class="text-zinc-600 dark:text-zinc-400">/month</span>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">For growing businesses</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">5,000 links per month</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Advanced analytics</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Custom domains</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">1-year data retention</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Team collaboration (5 users)</span>
                    </li>
                </ul>

                <button
                    class="w-full bg-accent text-accent-foreground py-3 rounded-lg font-medium hover:bg-accent/90 transition-colors">
                    Start Free Trial
                </button>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg p-8 border border-zinc-200 dark:border-zinc-800">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">Enterprise</h3>
                    <div class="mb-4">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white">$99</span>
                        <span class="text-zinc-600 dark:text-zinc-400">/month</span>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">For large organizations</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Unlimited links</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Enterprise analytics & API</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">White-label solution</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Unlimited data retention</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">Unlimited team members</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-zinc-700 dark:text-zinc-300">24/7 priority support</span>
                    </li>
                </ul>

                <button
                    class="w-full bg-zinc-200 dark:bg-zinc-700 text-zinc-900 dark:text-white py-3 rounded-lg font-medium hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                    Contact Sales
                </button>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-accent">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-accent-foreground mb-6">
            Ready to transform your links?
        </h2>
        <p class="text-xl text-accent-foreground/80 mb-8">
            Join thousands of businesses using linkmstr.io to track and optimize their link performance.
        </p>
        <a href="{{ route('register') }}"
           class="bg-white text-accent px-8 py-4 rounded-lg font-semibold text-lg hover:bg-zinc-100 transition-colors inline-block">
            Start Your Free Trial Today
        </a>
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
            <div class="border-t border-zinc-800 mt-12 pt-8 text-center text-zinc-400">
                <p>&copy; 2024 linkmstr.io. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
