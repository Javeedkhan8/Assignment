<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function states(Request $request)
    {
        $states = State::where('country_id', $request->integer('country_id'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($states);
    }

    public function cities(Request $request)
    {
        $cities = City::where('state_id', $request->integer('state_id'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }

    public function areas(Request $request)
    {
        $areas = Area::where('city_id', $request->integer('city_id'))
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($areas);
    }

    public function subcategories(Request $request)
    {
        $subcategories = Category::with('subcategories:id,category_id,name')
            ->where('id', $request->integer('category_id'))
            ->first();

        return response()->json($subcategories?->subcategories ?? []);
    }
}
