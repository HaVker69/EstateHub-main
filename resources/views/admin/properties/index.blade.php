@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Moderacija oglasa</h4>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Pretraga po nazivu">
        </div>
        <div class="col-auto">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Svi statusi</option>
                <option value="pending" @selected(request('status') === 'pending')>Na čekanju</option>
                <option value="approved" @selected(request('status') === 'approved')>Odobreno</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Odbijeno</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table bg-white shadow-sm align-middle">
            <thead><tr><th>Naziv</th><th>Vlasnik</th><th>Tip</th><th>Status</th><th>Datum</th><th class="text-end">Akcije</th></tr></thead>
            <tbody>
                @forelse($properties as $property)
                    <tr>
                        <td><a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a></td>
                        <td>{{ $property->user->name }}</td>
                        <td>{{ $property->propertyType->name }}</td>
                        <td><span class="badge {{ $property->status->badgeClass() }}">{{ $property->status->label() }}</span></td>
                        <td>{{ $property->created_at->format('d.m.Y') }}</td>
                        <td class="text-end">
                            @if($property->status->value !== 'approved')
                                <form method="POST" action="{{ route('admin.properties.approve', $property) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success">Odobri</button>
                                </form>
                            @endif
                            @if($property->status->value !== 'rejected')
                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $property->id }}">Odbij</button>
                            @endif
                            <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('properties.destroy', $property) }}" class="d-inline" onsubmit="return confirm('Obrisati ovaj oglas?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="rejectModal{{ $property->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.properties.reject', $property) }}">
                                    @csrf @method('PATCH')
                                    <div class="modal-header">
                                        <h6 class="modal-title">Odbijanje oglasa: {{ $property->title }}</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label">Razlog odbijanja</label>
                                        <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Otkaži</button>
                                        <button type="submit" class="btn btn-warning">Odbij oglas</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Nema pronađenih oglasa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $properties->links() }}
@endsection
