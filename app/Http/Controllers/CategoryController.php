<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Listing;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $query = Listing::with(['subcategory', 'city', 'area', 'state', 'user'])
            ->where('is_active', true)
            ->where('category_id', $category->id);

        $activeSubcategory = null;

        if ($request->filled('sub')) {
            $activeSubcategory = $category->subcategories()->where('slug', $request->input('sub'))->first();

            if ($activeSubcategory) {
                $query->where('subcategory_id', $activeSubcategory->id);
            }
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->input('q').'%');
        }

        $listings = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::withCount('listings')->orderBy('position')->get();

        return view('category', [
            'category' => $category,
            'activeSubcategory' => $activeSubcategory,
            'subcategories' => $category->subcategories()->withCount('listings')->get(),
            'listings' => $listings,
            'categories' => $categories,
            'cities' => City::withCount('listings')
                ->whereHas('listings', fn ($q) => $q->where('category_id', $category->id)->where('is_active', true))
                ->orderBy('name')
                ->get(),
        ]);
    }
}
