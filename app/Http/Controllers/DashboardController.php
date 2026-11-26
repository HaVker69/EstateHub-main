<?php

namespace App\Http\Controllers;

use App\Enums\PropertyStatus;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'properties' => $user->properties()->count(),
            'pending_properties' => $user->properties()->where('status', PropertyStatus::Pending)->count(),
            'favorites' => $user->favoriteProperties()->count(),
            'sent_inquiries' => $user->sentInquiries()->count(),
            'viewings' => $user->viewings()->count(),
        ];

        $recentProperties = $user->properties()->with('propertyType')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentProperties'));
    }
}
