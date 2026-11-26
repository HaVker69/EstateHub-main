<?php

namespace App\Http\Controllers;

use App\Enums\ViewingStatus;
use App\Http\Requests\StoreViewingRequest;
use App\Models\Property;
use App\Models\Viewing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ViewingController extends Controller
{
    public function index()
    {
        $myViewings = auth()->user()->viewings()->with(['property'])->latest()->get();

        $receivedViewings = auth()->user()->properties()
            ->with(['viewings.user'])
            ->get()
            ->pluck('viewings')
            ->flatten()
            ->sortByDesc('created_at')
            ->values();

        return view('viewings.index', compact('myViewings', 'receivedViewings'));
    }

    public function store(StoreViewingRequest $request, Property $property)
    {
        if ($property->user_id === $request->user()->id) {
            throw ValidationException::withMessages([
                'scheduled_at' => 'Ne možete zakazati obilazak sopstvene nekretnine.',
            ]);
        }

        $property->viewings()->create([
            'user_id' => $request->user()->id,
            'scheduled_at' => $request->validated('scheduled_at'),
            'notes' => $request->validated('notes'),
        ]);

        return back()->with('status', 'Obilazak je uspešno zakazan.');
    }

    public function updateStatus(Request $request, Viewing $viewing)
    {
        abort_unless(
            auth()->user()->isAdmin() || auth()->id() === $viewing->property->user_id,
            403
        );

        $validated = $request->validate([
            'status' => [Rule::enum(ViewingStatus::class)],
        ]);

        $viewing->update(['status' => $validated['status']]);

        return back()->with('status', 'Status obilaska je ažuriran.');
    }
}
