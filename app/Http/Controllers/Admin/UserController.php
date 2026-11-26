<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with('roles')
            ->when($request->search, fn ($q, $search) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            }))
            ->withCount('properties')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::enum(RoleName::class)],
        ]);

        if ($user->id === auth()->id() && $validated['role'] !== RoleName::Admin->value) {
            return back()->withErrors(['role' => 'Ne možete sami sebi ukinuti administratorska prava.']);
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('status', 'Uloga korisnika je ažurirana.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'Ne možete obrisati sopstveni nalog.']);
        }

        $user->delete();

        return back()->with('status', 'Korisnik je obrisan.');
    }
}
