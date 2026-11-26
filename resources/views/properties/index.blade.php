@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Nekretnine</h4>

    <form method="GET" action="{{ route('properties.index') }}" class="card card-body shadow-sm mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control" placeholder="Naziv, grad, adresa...">
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">Svi tipovi</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type->id }}" @selected(($filters['type'] ?? '') == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="city" value="{{ $filters['city'] ?? '' }}" class="form-control" placeholder="Grad">
            </div>
            <div class="col-md-1">
                <input type="number" name="rooms" value="{{ $filters['rooms'] ?? '' }}" class="form-control" placeholder="Sobe">
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}" class="form-control" placeholder="Cena od">
                    <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}" class="form-control" placeholder="Cena do">
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
            </div>
        </div>
        <div class="row g-2 mt-1">
            <div class="col-md-2">
                <input type="number" name="min_area" value="{{ $filters['min_area'] ?? '' }}" class="form-control" placeholder="Kvadratura od">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_area" value="{{ $filters['max_area'] ?? '' }}" class="form-control" placeholder="Kvadratura do">
            </div>
            <div class="col-md-2">
                <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary w-100">Resetuj filtere</a>
            </div>
        </div>
    </form>

    <p class="text-muted">Pronađeno {{ $properties->total() }} oglasa.</p>

    <div class="row g-4">
        @forelse($properties as $property)
            @include('properties._card', ['property' => $property])
        @empty
            <p class="text-muted">Nema nekretnina koje odgovaraju zadatim kriterijumima.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $properties->links() }}
    </div>
@endsection
