<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Listing;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::with(['category', 'subcategory', 'city', 'area', 'state', 'user'])
            ->where('is_active', true);

        $query = $this->applyFilters($query, $request);

        $sort = $request->input('sort');
        if ($sort === 'price_asc') {
            $query->orderBy('price');
        } elseif ($sort === 'price_desc') {
            $query->orderByDesc('price');
        } else {
            $query->latest();
        }

        $listings = $query->paginate(12)->withQueryString();

        $categories = Category::withCount('listings')->orderBy('position')->get();

        return view('listings.index', [
            'listings' => $listings,
            'categories' => $categories,
            'cities' => City::orderBy('name')->get(),
            'filters' => $request->only(['q', 'type', 'category', 'subcategory', 'city', 'min_price', 'max_price', 'sort']),
        ]);
    }

    public function create()
    {
        $categories = Category::with('subcategories')->orderBy('position')->get();

        return view('listings.create', [
            'categories' => $categories,
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['product', 'service'])],
            'name' => ['required', 'string', 'max:120'],
            'detail' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:subcategories,id'],
            'country_id' => ['required', 'exists:countries,id'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999999'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'image.max' => 'Image must be smaller than 2 MB.',
        ]);

        if ($request->filled('subcategory_id')) {
            $belongsToCategory = Subcategory::where('id', $data['subcategory_id'])
                ->where('category_id', $data['category_id'])
                ->exists();

            if (! $belongsToCategory) {
                return back()->withErrors(['subcategory_id' => 'The selected subcategory does not belong to the chosen category.'])->withInput();
            }
        }

        $data['user_id'] = auth()->id();
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('listings', 'public');
        }

        $listing = Listing::create($data);

        return redirect()->route('listings.show', $listing)
            ->with('status', 'Your ad has been published successfully.');
    }

    public function show(Listing $listing)
    {
        if (! $listing->is_active && $listing->user_id !== auth()->id()) {
            abort(404);
        }

        $listing->load(['category', 'subcategory', 'country', 'state', 'city', 'area', 'user']);

        $related = Listing::with(['category', 'city', 'area'])
            ->where('is_active', true)
            ->where('id', '!=', $listing->id)
            ->where('category_id', $listing->category_id)
            ->where('city_id', $listing->city_id)
            ->latest()
            ->take(4)
            ->get();

        return view('listings.show', compact('listing', 'related'));
    }

    public function mine()
    {
        $listings = Listing::with(['category', 'city', 'area'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('listings.mine', compact('listings'));
    }

    public function destroy(Listing $listing)
    {
        abort_unless($listing->user_id === auth()->id(), 403);

        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }

        $listing->delete();

        return redirect()->route('listings.mine')->with('status', 'Listing deleted.');
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->filled('q')) {
            $term = '%'.$request->input('q').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)->orWhere('detail', 'like', $term);
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->input('category')));
        }

        if ($request->filled('subcategory')) {
            $query->whereHas('subcategory', fn ($q) => $q->where('slug', $request->input('subcategory')));
        }

        if ($request->filled('city')) {
            $query->whereHas('city', fn ($q) => $q->where('slug', $request->input('city')));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        return $query;
    }
}
