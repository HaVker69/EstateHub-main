@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Tipovi nekretnina</h4>
        <a href="{{ route('admin.property-types.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Dodaj tip</a>
    </div>

    <div class="table-responsive">
        <table class="table bg-white shadow-sm align-middle">
            <thead><tr><th>Naziv</th><th>Opis</th><th>Broj oglasa</th><th class="text-end">Akcije</th></tr></thead>
            <tbody>
                @forelse($propertyTypes as $propertyType)
                    <tr>
                        <td>{{ $propertyType->name }}</td>
                        <td class="text-muted small">{{ $propertyType->description }}</td>
                        <td>{{ $propertyType->properties_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.property-types.edit', $propertyType) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.property-types.destroy', $propertyType) }}" class="d-inline" onsubmit="return confirm('Obrisati ovaj tip nekretnine?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" @if($propertyType->properties_count > 0) disabled title="Postoje oglasi ovog tipa" @endif><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Nema definisanih tipova nekretnina.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $propertyTypes->links() }}
@endsection
