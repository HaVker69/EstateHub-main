@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Upiti</h4>

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sent" type="button">Poslati ({{ $sent->count() }})</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#received" type="button">Primljeni ({{ $received->count() }})</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="sent">
            @forelse($sent as $inquiry)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('properties.show', $inquiry->property) }}" class="fw-semibold text-decoration-none">{{ $inquiry->property->title }}</a>
                            <span class="text-muted small">{{ $inquiry->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <p class="mb-0 mt-1">{{ $inquiry->message }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted">Niste poslali nijedan upit.</p>
            @endforelse
        </div>

        <div class="tab-pane fade" id="received">
            @forelse($received as $inquiry)
                <div class="card mb-2 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('properties.show', $inquiry->property) }}" class="fw-semibold text-decoration-none">{{ $inquiry->property->title }}</a>
                                <span class="text-muted small"> (od {{ $inquiry->user->name }})</span>
                            </div>
                            <span class="text-muted small">{{ $inquiry->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <p class="mb-0 mt-1">{{ $inquiry->message }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted">Niste primili nijedan upit.</p>
            @endforelse
        </div>
    </div>
@endsection
