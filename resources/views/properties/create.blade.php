@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Dodaj novi oglas</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
                @include('properties._form')

                <button type="submit" class="btn btn-primary mt-4">
                    <i class="bi bi-check-lg"></i> Objavi oglas
                </button>
            </form>
        </div>
    </div>
@endsection
