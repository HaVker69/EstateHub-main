@extends('layouts.app')

@section('content')
    <h4 class="mb-4"><i class="bi bi-speedometer2"></i> Admin panel</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $stats['total_properties'] }}</h3>
                    <p class="mb-0 small text-muted">Ukupno oglasa</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-warning">{{ $stats['pending_properties'] }}</h3>
                    <p class="mb-0 small text-muted">Na čekanju</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-success">{{ $stats['approved_properties'] }}</h3>
                    <p class="mb-0 small text-muted">Odobreno</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-danger">{{ $stats['rejected_properties'] }}</h3>
                    <p class="mb-0 small text-muted">Odbijeno</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-dark">{{ $stats['total_users'] }}</h3>
                    <p class="mb-0 small text-muted">Registrovanih korisnika</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-dark">{{ $stats['total_inquiries'] }}</h3>
                    <p class="mb-0 small text-muted">Poslatih upita</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-dark">{{ $stats['scheduled_viewings'] }}</h3>
                    <p class="mb-0 small text-muted">Aktivnih obilazaka</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-primary">Moderacija oglasa</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Korisnici</a>
        <a href="{{ route('admin.property-types.index') }}" class="btn btn-outline-primary">Tipovi nekretnina</a>
    </div>

    <h5>Oglasi na čekanju</h5>
    <div class="table-responsive mb-4">
        <table class="table bg-white shadow-sm align-middle">
            <thead><tr><th>Naziv</th><th>Vlasnik</th><th>Tip</th><th>Datum</th><th class="text-end">Akcije</th></tr></thead>
            <tbody>
                @forelse($pendingProperties as $property)
                    <tr>
                        <td><a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a></td>
                        <td>{{ $property->user->name }}</td>
                        <td>{{ $property->propertyType->name }}</td>
                        <td>{{ $property->created_at->format('d.m.Y') }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.properties.approve', $property) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-success">Odobri</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Nema oglasa na čekanju.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
