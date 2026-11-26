@extends('layouts.app')

@section('content')
    <h4 class="mb-3">Izmena korisnika: {{ $user->name }}</h4>

    <div class="card shadow-sm" style="max-width: 480px;">
        <div class="card-body">
            <p><strong>E-mail:</strong> {{ $user->email }}</p>
            <p><strong>Telefon:</strong> {{ $user->phone ?? '-' }}</p>

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Uloga</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="user" @selected($user->hasRole('user'))>Registrovani korisnik</option>
                        <option value="admin" @selected($user->hasRole('admin'))>Administrator</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Sačuvaj</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Nazad</a>
            </form>
        </div>
    </div>
@endsection
