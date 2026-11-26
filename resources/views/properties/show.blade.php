@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Početna</a></li>
            <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">Nekretnine</a></li>
            <li class="breadcrumb-item active">{{ $property->title }}</li>
        </ol>
    </nav>

    @if($property->status->value !== 'approved')
        <div class="alert alert-warning">
            Status oglasa: <strong>{{ $property->status->label() }}</strong>
            @if($property->status->value === 'rejected' && $property->rejection_reason)
                <br>Razlog: {{ $property->rejection_reason }}
            @endif
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            @if($property->images->isNotEmpty())
                <div id="propertyCarousel" class="carousel slide shadow-sm rounded overflow-hidden mb-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($property->images as $image)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <img src="{{ $image->url }}" class="d-block w-100" style="height:420px;object-fit:cover;" alt="{{ $property->title }}">
                            </div>
                        @endforeach
                    </div>
                    @if($property->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            @endif

            <h2>{{ $property->title }}</h2>
            <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $property->city }}, {{ $property->address }}</p>

            <div class="d-flex gap-2 mb-3">
                <span class="badge text-bg-light">{{ $property->propertyType->name }}</span>
                <span class="badge text-bg-light">{{ $property->rooms }} soba</span>
                <span class="badge text-bg-light">{{ (float) $property->area }} m&sup2;</span>
            </div>

            <p style="white-space: pre-line;">{{ $property->description }}</p>

            <hr>
            <p class="small text-muted">Oglas objavio: {{ $property->user->name }}, {{ $property->created_at->format('d.m.Y') }}</p>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h3 class="price-tag">{{ number_format((float) $property->price, 0, ',', '.') }} &euro;</h3>

                    @auth
                        @if(auth()->id() !== $property->user_id)
                            <form method="POST" action="{{ $property->isFavoritedBy(auth()->user()) ? route('favorites.destroy', $property) : route('favorites.store', $property) }}" class="mb-2">
                                @csrf
                                @if($property->isFavoritedBy(auth()->user()))
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-heart-fill"></i> Ukloni iz omiljenih</button>
                                @else
                                    <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-heart"></i> Dodaj u omiljene</button>
                                @endif
                            </form>
                        @endif

                        @can('update', $property)
                            <a href="{{ route('properties.edit', $property) }}" class="btn btn-outline-secondary w-100 mb-2">
                                <i class="bi bi-pencil"></i> Izmeni oglas
                            </a>
                        @endcan
                        @can('delete', $property)
                            <form method="POST" action="{{ route('properties.destroy', $property) }}" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj oglas?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100"><i class="bi bi-trash"></i> Obriši oglas</button>
                            </form>
                        @endcan
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Prijavite se za kontakt</a>
                    @endauth
                </div>
            </div>

            @auth
                @if(auth()->id() !== $property->user_id)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h6>Pošaljite upit vlasniku</h6>
                            <form method="POST" action="{{ route('inquiries.store', $property) }}">
                                @csrf
                                <textarea name="message" class="form-control mb-2" rows="3" placeholder="Vaša poruka..." required>{{ old('message') }}</textarea>
                                <button type="submit" class="btn btn-primary w-100">Pošalji upit</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Zakažite obilazak</h6>
                            <form method="POST" action="{{ route('viewings.store', $property) }}">
                                @csrf
                                <div class="mb-2">
                                    <input type="datetime-local" name="scheduled_at" class="form-control" required>
                                </div>
                                <textarea name="notes" class="form-control mb-2" rows="2" placeholder="Napomena (opciono)"></textarea>
                                <button type="submit" class="btn btn-outline-primary w-100">Zakaži obilazak</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
@endsection
