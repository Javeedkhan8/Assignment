<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Listing;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['listings' => fn ($q) => $q->where('is_active', true)])
            ->with('subcategories')
            ->orderBy('position')
            ->get();

        $latestListings = Listing::with(['category', 'city', 'area', 'state'])
            ->where('is_active', true)
            ->latest()
            ->take(12)
            ->get();

        $cities = City::withCount(['listings' => fn ($q) => $q->where('is_active', true)])
            ->orderByDesc('listings_count')
            ->take(8)
            ->get();

        return view('home', compact('categories', 'latestListings', 'cities'));
    }
}
