<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Property;
use Illuminate\Validation\ValidationException;

class InquiryController extends Controller
{
    public function index()
    {
        $sent = auth()->user()->sentInquiries()->with(['property'])->latest()->get();

        $received = auth()->user()->properties()
            ->with(['inquiries.user'])
            ->get()
            //colletion metode
            ->pluck('inquiries')
            ->flatten()
            ->sortByDesc('created_at')  
            ->values();

        return view('inquiries.index', compact('sent', 'received'));
    }

    public function store(StoreInquiryRequest $request, Property $property)
    {
        if ($property->user_id === $request->user()->id) {
            throw ValidationException::withMessages([
                'message' => 'Ne možete poslati upit za sopstvenu nekretninu.',
            ]);
        }

        $property->inquiries()->create([
            'user_id' => $request->user()->id,
            'message' => $request->validated('message'),
        ]);

        return back()->with('status', 'Upit je uspešno poslat vlasniku nekretnine.');
    }
}
