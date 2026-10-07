@extends('layouts.market')

@section('title', config('app.name').' - Buy & Sell Products and Services Near You')

@section('content')
    <section class="bg-gradient-to-r from-indigo-600 to-indigo-500 text-white">
        <div class="max-w-7xl mx-auto px-4 py-14">
            <h1 class="text-3xl sm:text-4xl font-bold">Buy &amp; Sell Anything, Near You</h1>
            <p class="mt-2 text-indigo-100">Register, post your product or service ad, and reach buyers in your city.</p>

            <form action="{{ route('listings.index') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-3 max-w-3xl">
                <input type="search" name="q" placeholder="What are you looking for?"
                       class="flex-1 rounded-lg border-0 text-gray-900 text-sm focus:ring-white focus:border-white" />
                <select name="city" class="rounded-lg border-0 text-sm text-gray-900 focus:ring-white focus:border-white sm:w-48">
                    <option value="">All cities</option>
                    @foreach ($cities as $c)
                        <option value="{{ $c->slug }}" @selected(request('city') === $c->slug)>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-white px-6 py-2.5 text-sm font-semibold text-indigo-600 hover:bg-indigo-50">
                    Search
                </button>
            </form>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Browse Categories</h2>
            <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">View all ads</a>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="group rounded-xl border border-gray-200 bg-white p-4 text-center shadow-sm transition hover:border-indigo-300 hover:shadow-md">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 text-xl font-bold text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white">
                        {{ strtoupper(substr($category->name, 0, 1)) }}
                    </div>
                    <div class="mt-3 text-sm font-semibold text-gray-900 group-hover:text-indigo-600">{{ $category->name }}</div>
                    <div class="mt-1 text-xs text-gray-400">{{ $category->listings_count }} ads</div>
                    <div class="mt-2 text-xs text-gray-400 line-clamp-2">
                        {{ $category->subcategories->pluck('name')->take(3)->implode(', ') }}
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 pb-10">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Fresh Listings</h2>
            <a href="{{ route('listings.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">See more</a>
        </div>

        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @include('partials.listing-grid', ['listings' => $latestListings])
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 pb-12">
        <h2 class="text-xl font-bold text-gray-900">Popular Cities</h2>
        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-4">
            @foreach ($cities as $city)
                <a href="{{ route('cities.show', $city) }}"
                   class="rounded-xl border border-gray-200 bg-white px-4 py-4 shadow-sm transition hover:border-indigo-300 hover:shadow-md">
                    <div class="text-sm font-semibold text-gray-900">{{ $city->name }}</div>
                    <div class="mt-1 text-xs text-gray-400">{{ $city->listings_count }} ads</div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
