<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name').' - Buy & Sell Near You')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex h-16 items-center justify-between gap-4">
                        <div class="flex items-center gap-6">
                            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-indigo-600">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white text-sm">CK</span>
                                <span class="hidden sm:inline">{{ config('app.name') }}</span>
                            </a>

                            <form action="{{ route('listings.index') }}" method="GET" class="hidden md:flex items-center w-72 lg:w-96">
                                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search ads..."
                                    class="w-full rounded-l-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                <button type="submit" class="rounded-r-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500">
                                    Search
                                </button>
                            </form>
                        </div>

                        <nav class="flex items-center gap-1 sm:gap-3 text-sm font-medium">
                            <a href="{{ route('listings.index') }}"
                               class="hidden sm:inline-block px-3 py-2 rounded-md {{ request()->routeIs('listings.index') ? 'text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                                Browse Ads
                            </a>

                            @auth
                                <a href="{{ route('listings.mine') }}"
                                   class="px-2 sm:px-3 py-2 rounded-md {{ request()->routeIs('listings.mine') ? 'text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                                    My Ads
                                </a>
                                <a href="{{ route('listings.create') }}"
                                   class="rounded-full bg-indigo-600 px-3 sm:px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    + Post Ad
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="px-1 sm:px-3 py-2 text-xs sm:text-sm text-gray-500 hover:text-gray-800">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="px-3 py-2 text-gray-600 hover:text-gray-900">Login</a>
                                <a href="{{ route('register') }}"
                                   class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    Register
                                </a>
                            @endauth

                            <button type="button" class="sm:hidden px-2 text-gray-500" onclick="document.getElementById('mobile-search').classList.toggle('hidden')">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                            </button>
                        </nav>
                    </div>

                    <div id="mobile-search" class="hidden pb-3 md:hidden">
                        <form action="{{ route('listings.index') }}" method="GET" class="flex">
                            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search ads..."
                                class="w-full rounded-l-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                            <button type="submit" class="rounded-r-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white">Search</button>
                        </form>
                    </div>
                </div>
            </header>

            @if (session('status'))
                <div class="max-w-7xl mx-auto w-full px-4 pt-4">
                    <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <main class="flex-1">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto px-4 py-8 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <div class="text-lg font-bold text-indigo-600">{{ config('app.name') }}</div>
                        <p class="mt-2 text-sm text-gray-500">Buy and sell products & services near you. Post your ad for free.</p>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Quick Links</div>
                        <ul class="mt-2 space-y-1 text-sm text-gray-500">
                            <li><a href="{{ route('listings.index') }}" class="hover:text-indigo-600">All Ads</a></li>
                            <li><a href="{{ route('listings.create') }}" class="hover:text-indigo-600">Post an Ad</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-indigo-600">Register</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Categories</div>
                        <ul class="mt-2 space-y-1 text-sm text-gray-500">
                            @foreach (\App\Models\Category::orderBy('position')->take(5)->get() as $cat)
                                <li><a href="{{ route('categories.show', $cat) }}" class="hover:text-indigo-600">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Top Cities</div>
                        <ul class="mt-2 space-y-1 text-sm text-gray-500">
                            @foreach (\App\Models\City::withCount('listings')->orderByDesc('listings_count')->take(5)->get() as $c)
                                <li><a href="{{ route('cities.show', $c) }}" class="hover:text-indigo-600">{{ $c->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-100 py-4 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </footer>
        </div>
    </body>
</html>
