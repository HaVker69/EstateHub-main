@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Izmeni oglas</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('properties.update', $property) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('properties._form')

                <button type="submit" class="btn btn-primary mt-4">
                    <i class="bi bi-check-lg"></i> Sačuvaj izmene
                </button>
            </form>
        </div>
    </div>
@endsection
