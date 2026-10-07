@forelse ($listings as $listing)
    @include('partials.listing-card', ['listing' => $listing])
@empty
    <div class="col-span-full rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">
        <p class="text-sm font-medium text-gray-600">No ads found.</p>
        <p class="mt-1 text-sm text-gray-400">Try a different filter or be the first to <a href="{{ route('listings.create') }}" class="text-indigo-600 hover:underline">post an ad</a>.</p>
    </div>
@endforelse
