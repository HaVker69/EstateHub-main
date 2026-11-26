@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Dobrodošli, {{ auth()->user()->name }}</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-primary">{{ $stats['properties'] }}</h3>
                    <p class="mb-0 small text-muted">Moji oglasi</p>
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
                    <h3 class="text-danger">{{ $stats['favorites'] }}</h3>
                    <p class="mb-0 small text-muted">Omiljeno</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h3 class="text-success">{{ $stats['viewings'] }}</h3>
                    <p class="mb-0 small text-muted">Zakazani obilasci</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('properties.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Dodaj oglas</a>
        <a href="{{ route('my-properties.index') }}" class="btn btn-outline-secondary">Moji oglasi</a>
        <a href="{{ route('inquiries.index') }}" class="btn btn-outline-secondary">Upiti</a>
        <a href="{{ route('viewings.index') }}" class="btn btn-outline-secondary">Obilasci</a>
    </div>

    <h5>Poslednji oglasi</h5>
    <div class="table-responsive">
        <table class="table bg-white shadow-sm align-middle">
            <thead><tr><th>Naziv</th><th>Tip</th><th>Status</th><th>Datum</th></tr></thead>
            <tbody>
                @forelse($recentProperties as $property)
                    <tr>
                        <td><a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a></td>
                        <td>{{ $property->propertyType->name }}</td>
                        <td><span class="badge {{ $property->status->badgeClass() }}">{{ $property->status->label() }}</span></td>
                        <td>{{ $property->created_at->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Još uvek nemate oglasa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
