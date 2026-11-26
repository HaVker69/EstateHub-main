@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Zakazani obilasci</h4>

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mine" type="button">Moji zahtevi ({{ $myViewings->count() }})</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#received" type="button">Zahtevi za moje oglase ({{ $receivedViewings->count() }})</button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="mine">
            <div class="table-responsive">
                <table class="table bg-white shadow-sm align-middle">
                    <thead><tr><th>Nekretnina</th><th>Termin</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($myViewings as $viewing)
                            <tr>
                                <td><a href="{{ route('properties.show', $viewing->property) }}">{{ $viewing->property->title }}</a></td>
                                <td>{{ $viewing->scheduled_at->format('d.m.Y H:i') }}</td>
                                <td><span class="badge {{ $viewing->status->badgeClass() }}">{{ $viewing->status->label() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Niste zakazali nijedan obilazak.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="received">
            <div class="table-responsive">
                <table class="table bg-white shadow-sm align-middle">
                    <thead><tr><th>Nekretnina</th><th>Zatražio</th><th>Termin</th><th>Status</th><th class="text-end">Akcije</th></tr></thead>
                    <tbody>
                        @forelse($receivedViewings as $viewing)
                            <tr>
                                <td><a href="{{ route('properties.show', $viewing->property) }}">{{ $viewing->property->title }}</a></td>
                                <td>{{ $viewing->user->name }}</td>
                                <td>{{ $viewing->scheduled_at->format('d.m.Y H:i') }}</td>
                                <td><span class="badge {{ $viewing->status->badgeClass() }}">{{ $viewing->status->label() }}</span></td>
                                <td class="text-end">
                                    @if($viewing->status->value === 'pending')
                                        <form method="POST" action="{{ route('viewings.update-status', $viewing) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Potvrdi</button>
                                        </form>
                                        <form method="POST" action="{{ route('viewings.update-status', $viewing) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Otkaži</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">Nema zahteva za obilazak vaših oglasa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
