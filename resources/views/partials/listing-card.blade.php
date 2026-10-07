<a href="{{ route('listings.show', $listing) }}"
   class="group flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md hover:border-indigo-200">
    <div class="relative h-44 w-full overflow-hidden bg-gradient-to-br from-indigo-50 to-indigo-100">
        @if ($listing->image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($listing->image) }}" alt="{{ $listing->name }}"
                 class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="flex h-full w-full items-center justify-center">
                <span class="text-5xl font-bold text-indigo-200">{{ strtoupper(substr($listing->name, 0, 1)) }}</span>
            </div>
        @endif

        <span class="absolute left-2 top-2 rounded-full bg-white/90 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-indigo-600">
            {{ $listing->type }}
        </span>
    </div>

    <div class="flex flex-1 flex-col p-4">
        <div class="flex items-start justify-between gap-2">
            <h3 class="text-base font-semibold text-gray-900 group-hover:text-indigo-600 line-clamp-2">{{ $listing->name }}</h3>
            <div class="shrink-0 text-base font-bold text-gray-900">&#8377;{{ number_format((float) $listing->price) }}</div>
        </div>

        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ \Illuminate\Support\Str::limit($listing->detail, 90) }}</p>

        <div class="mt-auto flex items-center justify-between pt-3 text-xs text-gray-400">
            <span class="inline-flex items-center gap-1">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $listing->city?->name }}{{ $listing->area?->name ? ', '.$listing->area->name : '' }}
            </span>
            <span>{{ $listing->created_at->diffForHumans(short: true) }}</span>
        </div>

        <div class="mt-2 text-xs text-indigo-500 font-medium">
            {{ $listing->category?->name }}@if ($listing->subcategory) &rsaquo; {{ $listing->subcategory->name }}@endif
        </div>
    </div>
</a>
