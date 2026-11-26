<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->user()
            ->favoriteProperties()
            ->with(['propertyType', 'images'])
            ->latest('favorites.created_at')
            ->paginate(9);

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request, Property $property)
    {
        $request->user()->favoriteProperties()->syncWithoutDetaching([$property->id]);

        return back()->with('status', 'Nekretnina je dodata u omiljene.');
    }

    public function destroy(Request $request, Property $property)
    {
        $request->user()->favoriteProperties()->detach($property->id);

        return back()->with('status', 'Nekretnina je uklonjena iz omiljenih.');
    }
}
