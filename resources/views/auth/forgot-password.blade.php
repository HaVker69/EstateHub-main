@extends('layouts.guest')

@section('content')
    <h4 class="mb-3">Zaboravljena lozinka</h4>
    <p class="text-muted small">Unesite svoju e-mail adresu i poslaćemo vam link za resetovanje lozinke.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-mail adresa</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Pošalji link za reset</button>
    </form>
@endsection
