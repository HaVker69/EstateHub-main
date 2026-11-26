<?php

namespace App\Http\Controllers;

use App\Enums\PropertyStatus;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'type', 'city', 'min_price', 'max_price', 'min_area', 'max_area', 'rooms']);

        $properties = Property::approved()
            ->with(['propertyType', 'images'])
            ->filter($filters)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $propertyTypes = PropertyType::orderBy('name')->get();

        return view('properties.index', compact('properties', 'propertyTypes', 'filters'));
    }

    public function show(Property $property)
    {
        if ($property->status !== PropertyStatus::Approved) {
            abort_unless(
                auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $property->user_id),
                404
            );
        }

        $property->load(['propertyType', 'images', 'user']);

        return view('properties.show', compact('property'));
    }

    public function myIndex()
    {
        $properties = auth()->user()
            ->properties()
            ->with(['propertyType', 'images'])
            ->latest()
            ->paginate(10);

        return view('properties.my', compact('properties'));
    }

    public function create()
    {
        $propertyTypes = PropertyType::orderBy('name')->get();

        return view('properties.create', compact('propertyTypes'));
    }

    public function store(StorePropertyRequest $request)
    {
        $property = $request->user()->properties()->create($request->safe()->except('images'));

        $this->storeImages($request, $property);

        return redirect()
            ->route('my-properties.index')
            ->with('status', 'Oglas je uspešno kreiran i čeka odobrenje administratora.');
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);

        $propertyTypes = PropertyType::orderBy('name')->get();

        return view('properties.edit', compact('property', 'propertyTypes'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $this->authorize('update', $property);

        $property->fill($request->safe()->except('images'));

        // Non-admin edits must go back through moderation before they are public again.
        if (! $request->user()->isAdmin()) {
            $property->status = PropertyStatus::Pending;
            $property->rejection_reason = null;
        }

        $property->save();

        $this->deleteImages($request, $property);
        $this->storeImages($request, $property);

        $redirect = $request->user()->isAdmin()
            ? redirect()->route('admin.properties.index')
            : redirect()->route('my-properties.index');

        return $redirect->with('status', 'Oglas je uspešno izmenjen.');
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        foreach ($property->images as $image) {
            if (! str_starts_with($image->path, 'http')) {
                Storage::disk('public')->delete($image->path);
            }
        }

        $property->delete();

        return back()->with('status', 'Oglas je obrisan.');
    }

    protected function deleteImages(Request $request, Property $property): void
    {
        $imageIds = collect($request->input('remove_images', []))->map(fn ($id) => (int) $id);

        if ($imageIds->isEmpty()) {
            return;
        }

        $images = $property->images()->whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            if (! str_starts_with($image->path, 'http')) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();
        }
    }

    protected function storeImages(Request $request, Property $property): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $nextOrder = $property->images()->max('sort_order') + 1;

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('properties', 'public');

            $property->images()->create([
                'path' => $path,
                'sort_order' => $nextOrder + $index,
            ]);
        }
    }
}
