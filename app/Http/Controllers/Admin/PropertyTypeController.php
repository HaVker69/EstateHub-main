<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyTypeRequest;
use App\Http\Requests\UpdatePropertyTypeRequest;
use App\Models\PropertyType;

class PropertyTypeController extends Controller
{
    public function index()
    {
        $propertyTypes = PropertyType::withCount('properties')->orderBy('name')->paginate(15);

        return view('admin.property-types.index', compact('propertyTypes'));
    }

    public function create()
    {
        return view('admin.property-types.create');
    }

    public function store(StorePropertyTypeRequest $request)
    {
        PropertyType::create($request->validated());

        return redirect()->route('admin.property-types.index')->with('status', 'Tip nekretnine je kreiran.');
    }

    public function edit(PropertyType $property_type)
    {
        return view('admin.property-types.edit', ['propertyType' => $property_type]);
    }

    public function update(UpdatePropertyTypeRequest $request, PropertyType $property_type)
    {
        $property_type->update($request->validated());

        return redirect()->route('admin.property-types.index')->with('status', 'Tip nekretnine je izmenjen.');
    }

    public function destroy(PropertyType $property_type)
    {
        if ($property_type->properties()->exists()) {
            return back()->withErrors(['property_type' => 'Tip nekretnine se ne može obrisati jer postoje oglasi tog tipa.']);
        }

        $property_type->delete();

        return back()->with('status', 'Tip nekretnine je obrisan.');
    }
}
