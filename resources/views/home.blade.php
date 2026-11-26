@extends('layouts.app')

@section('content')
    <div class="hero p-5 p-md-5 mb-5">
        <div class="row align-items-center position-relative">
            <div class="col-lg-7">
                <div class="eyebrow mb-2">Nekretnine &middot; Srbija</div>
                <h1 class="display-5 mb-3">Pronađite prostor koji<br class="d-none d-md-block"> zaista odgovara vama</h1>
                <p class="lead mb-4">EstateHub povezuje kupce, zakupce i vlasnike nekretnina na jednom mestu, bez posrednika i bez gubljenja vremena.</p>

                <form action="{{ route('properties.index') }}" method="GET" class="hero-search row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control border-0" placeholder="Naziv, grad ili adresa...">
                    </div>
                    <div class="col-md-4">
                        <select name="type" class="form-select border-0">
                            <option value="">Svi tipovi</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row text-center mb-5 g-3">
        <div class="col-md-4">
            <div class="stat-figure display-6">{{ $stats['properties'] }}</div>
            <p class="text-muted mb-0">Aktivnih oglasa</p>
        </div>
        <div class="col-md-4">
            <div class="stat-figure display-6">{{ $stats['cities'] }}</div>
            <p class="text-muted mb-0">Gradova</p>
        </div>
        <div class="col-md-4">
            <div class="stat-figure display-6">{{ $stats['types'] }}</div>
            <p class="text-muted mb-0">Tipova nekretnina</p>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <div>
            <div class="eyebrow text-muted mb-1" style="color: var(--accent) !important;">Preporuka</div>
            <h4 class="mb-0">Izdvojene nekretnine</h4>
        </div>
        <a href="{{ route('properties.index') }}" class="btn btn-outline-primary btn-sm">Pogledaj sve <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row g-4">
        @forelse($featuredProperties as $property)
            @include('properties._card', ['property' => $property])
        @empty
            <p class="text-muted">Trenutno nema dostupnih nekretnina.</p>
        @endforelse
    </div>
@endsection
