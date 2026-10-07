@extends('layouts.market')

@section('title', 'My Ads - '.config('app.name'))

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Ads</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $listings->total() }} ads posted by you</p>
            </div>
            <a href="{{ route('listings.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                + Post Ad
            </a>
        </div>

        <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Ad</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">City</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Posted</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($listings as $listing)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <a href="{{ route('listings.show', $listing) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                    {{ $listing->name }}
                                </a>
                                <div class="text-xs text-gray-400 uppercase">{{ $listing->type }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $listing->category?->name }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $listing->city?->name }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">&#8377;{{ number_format((float) $listing->price) }}</td>
                            <td class="px-4 py-3 text-gray-400">{{ $listing->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('listings.destroy', $listing) }}" class="inline" onsubmit="return confirm('Delete this ad?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                You have not posted any ads yet.
                                <a href="{{ route('listings.create') }}" class="text-indigo-600 hover:underline">Post your first ad</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $listings->links() }}
        </div>
    </div>
@endsection
