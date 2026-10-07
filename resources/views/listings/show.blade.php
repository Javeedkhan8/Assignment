@extends('layouts.market')

@section('title', $listing->name.' - '.config('app.name'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <nav class="text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('categories.show', $listing->category) }}" class="hover:text-indigo-600">{{ $listing->category?->name }}</a>
            <span class="mx-1">/</span>
            <span class="text-gray-700">{{ $listing->name }}</span>
        </nav>

        <div class="mt-5 grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="relative h-72 w-full bg-gradient-to-br from-indigo-50 to-indigo-100">
                        @if ($listing->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($listing->image) }}" alt="{{ $listing->name }}" class="h-full w-full object-contain">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <span class="text-7xl font-bold text-indigo-200">{{ strtoupper(substr($listing->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-600">
                            {{ $listing->type }}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $listing->name }}</h1>
                            <div class="text-2xl font-bold text-indigo-600">&#8377;{{ number_format((float) $listing->price, 2) }}</div>
                        </div>

                        <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-gray-500">
                            <span class="inline-flex items-center gap-1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $listing->location() }}
                            </span>
                            <span>Posted {{ $listing->created_at->diffForHumans() }}</span>
                            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                {{ $listing->category?->name }}@if ($listing->subcategory) &rsaquo; {{ $listing->subcategory->name }}@endif
                            </span>
                        </div>

                        <h2 class="mt-6 text-sm font-semibold uppercase tracking-wide text-gray-400">Description</h2>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-700">{{ $listing->detail }}</p>

                        @if ($listing->user_id === auth()->id())
                            <div class="mt-6 flex gap-3 border-t border-gray-100 pt-4">
                                <a href="{{ route('listings.mine') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Manage my ads</a>
                                <form method="POST" action="{{ route('listings.destroy', $listing) }}" onsubmit="return confirm('Delete this ad?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500">Delete Ad</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($related->isNotEmpty())
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Similar ads near {{ $listing->city?->name }}</h2>
                        <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2">
                            @include('partials.listing-grid', ['listings' => $related])
                        </div>
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="text-sm font-semibold text-gray-900">Seller Details</div>

                    <div class="mt-4 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">
                            {{ strtoupper(substr($listing->user?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">{{ $listing->user?->name }}</div>
                            <div class="text-xs text-gray-400">Member since {{ $listing->user?->created_at?->format('M Y') }}</div>
                        </div>
                    </div>

                    <dl class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Ad ID</dt>
                            <dd class="font-medium text-gray-700">#{{ $listing->id }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Type</dt>
                            <dd class="font-medium text-gray-700">{{ ucfirst($listing->type) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Country</dt>
                            <dd class="font-medium text-gray-700">{{ $listing->country?->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">State</dt>
                            <dd class="font-medium text-gray-700">{{ $listing->state?->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">City</dt>
                            <dd class="font-medium text-gray-700">
                                <a href="{{ route('cities.show', $listing->city) }}" class="text-indigo-600 hover:underline">{{ $listing->city?->name }}</a>
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Area</dt>
                            <dd class="font-medium text-gray-700">{{ $listing->area?->name ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Price</dt>
                            <dd class="font-bold text-gray-900">&#8377;{{ number_format((float) $listing->price, 2) }}</dd>
                        </div>
                    </dl>

                    <a href="{{ route('listings.create') }}" class="mt-6 block rounded-md bg-indigo-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-indigo-500">
                        + Post a similar ad
                    </a>
                </div>
            </aside>
        </div>
    </div>
@endsection
