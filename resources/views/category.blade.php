@extends('layouts.market')

@section('title', $category->name.' Ads - '.config('app.name'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <nav class="text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span class="mx-1">/</span>
            <span class="text-gray-700">{{ $category->name }}</span>
            @if ($activeSubcategory)
                <span class="mx-1">/</span>
                <span class="text-gray-700">{{ $activeSubcategory->name }}</span>
            @endif
        </nav>

        <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $activeSubcategory ? $activeSubcategory->name : $category->name }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">{{ $listings->total() }} ads in this category</p>
            </div>
            <a href="{{ route('listings.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                + Post an Ad
            </a>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('categories.show', $category) }}"
               class="rounded-full px-4 py-1.5 text-sm font-medium border {{ ! $activeSubcategory ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-indigo-400' }}">
                All
            </a>
            @foreach ($subcategories as $subcategory)
                <a href="{{ route('categories.show', [$category, 'sub' => $subcategory->slug]) }}"
                   class="rounded-full px-4 py-1.5 text-sm font-medium border {{ $activeSubcategory?->id === $subcategory->id ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-indigo-400' }}">
                    {{ $subcategory->name }}
                    <span class="text-xs opacity-70">({{ $subcategory->listings_count }})</span>
                </a>
            @endforeach
        </div>

        <form action="{{ route('categories.show', $category) }}" method="GET" class="mt-4 flex max-w-md gap-2">
            @if ($activeSubcategory)
                <input type="hidden" name="sub" value="{{ $activeSubcategory->slug }}">
            @endif
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search in {{ $category->name }}..."
                   class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
            <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Search</button>
        </form>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-4">
            <aside class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="text-sm font-semibold text-gray-900">Cities with {{ $category->name }} ads</div>
                    <ul class="mt-3 space-y-2 text-sm">
                        @forelse ($cities as $city)
                            <li>
                                <a href="{{ route('cities.category', [$city, $category]) }}"
                                   class="flex items-center justify-between text-gray-600 hover:text-indigo-600">
                                    <span>{{ $city->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $city->listings_count }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-400">No city data yet.</li>
                        @endforelse
                    </ul>
                </div>
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
