<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Listing;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show(Request $request, City $city)
    {
        return $this->renderCityListings($request, $city, null);
    }

    public function showCategory(Request $request, City $city, Category $category)
    {
        return $this->renderCityListings($request, $city, $category);
    }

    private function renderCityListings(Request $request, City $city, ?Category $category)
    {
        $query = Listing::with(['category', 'subcategory', 'area', 'state', 'user'])
            ->where('is_active', true)
            ->where('city_id', $city->id);

        if ($category) {
            $query->where('category_id', $category->id);

            if ($request->filled('sub')) {
                $query->whereHas('subcategory', fn ($q) => $q->where('slug', $request->input('sub')));
            }
        }

        if ($request->filled('q')) {
            $term = '%'.$request->input('q').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)->orWhere('detail', 'like', $term);
            });
        }

        $listings = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::withCount(['listings' => function ($q) use ($city) {
            $q->where('city_id', $city->id)->where('is_active', true);
        }])->orderBy('position')->get();

        return view('city', [
            'city' => $city,
            'category' => $category,
            'listings' => $listings,
            'categories' => $categories,
            'siblingCities' => City::withCount(['listings' => fn ($q) => $q->where('is_active', true)])
                ->orderBy('name')
                ->get(),
        ]);
    }
}
