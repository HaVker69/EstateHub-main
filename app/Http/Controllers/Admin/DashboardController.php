<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatus;
use App\Enums\ViewingStatus;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use App\Models\Viewing;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_properties' => Property::count(),
            'pending_properties' => Property::where('status', PropertyStatus::Pending)->count(),
            'approved_properties' => Property::where('status', PropertyStatus::Approved)->count(),
            'rejected_properties' => Property::where('status', PropertyStatus::Rejected)->count(),
            'total_users' => User::count(),
            'total_inquiries' => Inquiry::count(),
            'scheduled_viewings' => Viewing::where('status', ViewingStatus::Pending)
                ->orWhere('status', ViewingStatus::Confirmed)
                ->count(),
        ];

        $latestProperties = Property::with(['user', 'propertyType'])->latest()->take(5)->get();
        $pendingProperties = Property::where('status', PropertyStatus::Pending)
            ->with(['user', 'propertyType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestProperties', 'pendingProperties'));
    }
}
