@extends('layouts.market')

@section('title', ($category ? $category->name.' in ' : '').$city->name.' - '.config('app.name'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <nav class="text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('cities.show', $city) }}" class="hover:text-indigo-600">{{ $city->state?->name }}</a>
            <span class="mx-1">/</span>
            <span class="text-gray-700">{{ $city->name }}</span>
            @if ($category)
                <span class="mx-1">/</span>
                <span class="text-gray-700">{{ $category->name }}</span>
            @endif
        </nav>

        <div class="mt-3 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $category ? $category->name : 'All Ads' }} in {{ $city->name }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">{{ $listings->total() }} listings available</p>
            </div>
            <a href="{{ route('listings.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                + Post an Ad in {{ $city->name }}
            </a>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('cities.show', $city) }}"
               class="rounded-full px-4 py-1.5 text-sm font-medium border {{ ! $category ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-indigo-400' }}">
                All Categories
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('cities.category', [$city, $cat]) }}"
                   class="rounded-full px-4 py-1.5 text-sm font-medium border {{ $category?->id === $cat->id ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-300 text-gray-600 hover:border-indigo-400' }}">
                    {{ $cat->name }}
                    <span class="text-xs opacity-70">({{ $cat->listings_count }})</span>
                </a>
            @endforeach
        </div>

        @if ($category)
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($category->subcategories as $subcategory)
                    <a href="{{ $category ? route('cities.category', [$city, $category, 'sub' => $subcategory->slug]) : '#' }}"
                       class="rounded-full border border-dashed border-gray-300 px-3 py-1 text-xs font-medium text-gray-500 hover:border-indigo-400 hover:text-indigo-600 {{ request('sub') === $subcategory->slug ? 'border-indigo-400 text-indigo-600' : '' }}">
                        {{ $subcategory->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <form action="{{ $category ? route('cities.category', [$city, $category]) : route('cities.show', $city) }}" method="GET" class="mt-4 flex max-w-md gap-2">
            @if (request('sub'))
                <input type="hidden" name="sub" value="{{ request('sub') }}">
            @endif
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search in {{ $city->name }}..."
                   class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500" />
            <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Search</button>
        </form>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-4">
            <aside class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="text-sm font-semibold text-gray-900">Other cities</div>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach ($siblingCities as $sibling)
                            <li>
                                <a href="{{ route('cities.show', $sibling) }}"
                                   class="flex items-center justify-between {{ $sibling->id === $city->id ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-indigo-600' }}">
                                    <span>{{ $sibling->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $sibling->listings_count }}</span>
                                </a>
                            </li>
                        @endforeach
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
