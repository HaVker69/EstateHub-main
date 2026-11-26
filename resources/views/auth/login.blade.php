@extends('layouts.guest')

@section('content')
    <h4 class="mb-3">Prijava na nalog</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-mail adresa</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror" required autofocus>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Lozinka</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Zapamti me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Prijavi se</button>

        <div class="text-center mt-3 small">
            <a href="{{ route('password.request') }}">Zaboravili ste lozinku?</a>
        </div>
        <div class="text-center mt-2 small">
            Nemate nalog? <a href="{{ route('register') }}">Registrujte se</a>
        </div>
    </form>
@endsection
