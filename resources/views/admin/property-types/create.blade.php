@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Dodaj tip nekretnine</h4>

    <div class="card shadow-sm" style="max-width: 500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.property-types.store') }}">
                @include('admin.property-types._form')
                <button type="submit" class="btn btn-primary mt-2">Sačuvaj</button>
                <a href="{{ route('admin.property-types.index') }}" class="btn btn-outline-secondary mt-2">Nazad</a>
            </form>
        </div>
    </div>
@endsection
