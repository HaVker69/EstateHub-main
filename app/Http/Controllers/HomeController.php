<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = Property::approved()
            ->with(['propertyType', 'images'])
            ->latest()
            ->take(6)
            ->get();

        $propertyTypes = PropertyType::withCount('properties')->orderBy('name')->get();

        $stats = [
            'properties' => Property::approved()->count(),
            'cities' => Property::approved()->distinct('city')->count('city'),
            'types' => $propertyTypes->count(),
        ];

        return view('home', compact('featuredProperties', 'propertyTypes', 'stats'));
    }
}
