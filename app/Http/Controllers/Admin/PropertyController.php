<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::query()
            ->with(['user', 'propertyType'])
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->search, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function approve(Property $property)
    {
        $property->update([
            'status' => PropertyStatus::Approved,
            'rejection_reason' => null,
        ]);

        return back()->with('status', 'Oglas je odobren.');
    }

    public function reject(Request $request, Property $property)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:255'],
        ]);

        $property->update([
            'status' => PropertyStatus::Rejected,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('status', 'Oglas je odbijen.');
    }
}
