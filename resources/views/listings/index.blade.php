@extends('layouts.market')

@section('title', 'Browse Ads - '.config('app.name'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">All Ads</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $listings->total() }} listings found</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-4">
            <aside class="lg:col-span-1">
                <form action="{{ route('listings.index') }}" method="GET" class="rounded-xl border border-gray-200 bg-white p-5 space-y-4 shadow-sm">
                    <div class="text-sm font-semibold text-gray-900">Filters</div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500">Keyword</label>
                        <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search"
                               class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500">Type</label>
                        <select name="type" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All</option>
                            <option value="product" @selected(($filters['type'] ?? '') === 'product')>Product</option>
                            <option value="service" @selected(($filters['type'] ?? '') === 'service')>Service</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500">Category</label>
                        <select name="category" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>
                                    {{ $category->name }} ({{ $category->listings_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500">City</label>
                        <select name="city" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All cities</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->slug }}" @selected(($filters['city'] ?? '') === $city->slug)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Min &#8377;</label>
                            <input type="number" name="min_price" min="0" value="{{ $filters['min_price'] ?? '' }}"
                                   class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500">Max &#8377;</label>
                            <input type="number" name="max_price" min="0" value="{{ $filters['max_price'] ?? '' }}"
                                   class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500">Sort by</label>
                        <select name="sort" class="mt-1 w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Newest first</option>
                            <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price: High to Low</option>
                        </select>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="flex-1 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                            Apply
                        </button>
                        <a href="{{ route('listings.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </aside>

            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @include('partials.listing-grid', ['listings' => $listings])
                </div>

                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
