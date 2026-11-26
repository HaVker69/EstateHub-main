@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Omiljene nekretnine</h4>

    <div class="row g-4">
        @forelse($favorites as $property)
            @include('properties._card', ['property' => $property])
        @empty
            <p class="text-muted">Još uvek nemate omiljenih nekretnina.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $favorites->links() }}
    </div>
@endsection
