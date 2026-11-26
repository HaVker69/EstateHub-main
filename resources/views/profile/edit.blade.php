@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Moj profil</h4>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Podaci profila</h6>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Ime i prezime</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">E-mail adresa</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Promena lozinke</h6>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Trenutna lozinka</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nova lozinka</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Potvrda nove lozinke</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Promeni lozinku</button>
                    </form>
                </div>
            </div>

            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="text-danger mb-3">Brisanje naloga</h6>
                    <p class="small text-muted">Ova akcija je trajna i ne može se poništiti.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Da li ste sigurni da želite da obrišete nalog?');">
                        @csrf
                        @method('DELETE')
                        <input type="password" name="password" class="form-control mb-2" placeholder="Unesite lozinku za potvrdu">
                        <button type="submit" class="btn btn-danger">Obriši nalog</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
