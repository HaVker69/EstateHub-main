@php $image = $property->images->first(); @endphp
<div class="col-md-6 col-lg-4">
    <div class="card property-card h-100 shadow-sm">
        <a href="{{ route('properties.show', $property) }}">
            <img src="{{ $image?->url ?? "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='600'%3E%3Crect width='800' height='600' fill='%232f4d3f'/%3E%3Ctext x='400' y='300' font-family='Georgia,serif' font-size='42' fill='%23f4f1e9' text-anchor='middle' dominant-baseline='middle'%3EEstateHub%3C/text%3E%3C/svg%3E" }}" class="card-img-top" alt="{{ $property->title }}">
        </a>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-1">
                <h5 class="card-title mb-0">
                    <a href="{{ route('properties.show', $property) }}" class="text-decoration-none text-dark">{{ $property->title }}</a>
                </h5>
                @if($property->status->value !== 'approved')
                    <span class="badge {{ $property->status->badgeClass() }}">{{ $property->status->label() }}</span>
                @endif
            </div>
            <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> {{ $property->city }}, {{ $property->address }}</p>
            <p class="mb-2">
                <span class="badge text-bg-light">{{ $property->propertyType->name }}</span>
                <span class="badge text-bg-light">{{ $property->rooms }} soba</span>
                <span class="badge text-bg-light">{{ (float) $property->area }} m&sup2;</span>
            </p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="price-tag">{{ number_format((float) $property->price, 0, ',', '.') }} &euro;</span>
                <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-primary">Detalji</a>
            </div>
        </div>
    </div>
</div>
