@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Moji oglasi</h4>
        <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Dodaj oglas</a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle bg-white shadow-sm">
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Tip</th>
                    <th>Cena</th>
                    <th>Status</th>
                    <th>Objavljen</th>
                    <th class="text-end">Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                    <tr>
                        <td>
                            <a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a>
                        </td>
                        <td>{{ $property->propertyType->name }}</td>
                        <td>{{ number_format((float) $property->price, 0, ',', '.') }} &euro;</td>
                        <td>
                            <span class="badge {{ $property->status->badgeClass() }}">{{ $property->status->label() }}</span>
                            @if($property->status->value === 'rejected' && $property->rejection_reason)
                                <div class="small text-danger">{{ $property->rejection_reason }}</div>
                            @endif
                        </td>
                        <td>{{ $property->created_at->format('d.m.Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('properties.destroy', $property) }}" class="d-inline" onsubmit="return confirm('Obrisati ovaj oglas?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Nemate objavljenih oglasa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $properties->links() }}
@endsection
