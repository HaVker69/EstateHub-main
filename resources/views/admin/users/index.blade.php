@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Upravljanje korisnicima</h4>

    <form method="GET" class="mb-3">
        <div class="input-group" style="max-width: 350px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pretraga po imenu ili e-mailu">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table bg-white shadow-sm align-middle">
            <thead><tr><th>Ime</th><th>E-mail</th><th>Uloga</th><th>Oglasi</th><th>Registrovan</th><th class="text-end">Akcije</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge text-bg-secondary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->properties_count }}</td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Obrisati ovog korisnika?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Nema pronađenih korisnika.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
@endsection
