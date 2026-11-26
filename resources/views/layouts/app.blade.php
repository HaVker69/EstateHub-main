<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' - ' : '' }}{{ config('app.name', 'EstateHub') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg site-navbar sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-house-door brand-mark"></i> EstateHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}" href="{{ route('properties.index') }}">Nekretnine</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('my-properties.*') ? 'active' : '' }}" href="{{ route('my-properties.index') }}">Moji oglasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}" href="{{ route('favorites.index') }}">Omiljeno</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inquiries.*') ? 'active' : '' }}" href="{{ route('inquiries.index') }}">Upiti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('viewings.*') ? 'active' : '' }}" href="{{ route('viewings.index') }}">Obilasci</a>
                        </li>
                        @hasrole('admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Admin panel
                                </a>
                            </li>
                        @endhasrole
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-lg-2" href="{{ route('register') }}">Registracija</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Kontrolna tabla</a></li>
                                <li><a class="dropdown-item" href="{{ route('properties.create') }}">Dodaj oglas</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Odjava</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <footer class="site-footer py-4 mt-5">
        <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 small">
            <span><i class="bi bi-house-door brand-mark me-1"></i>EstateHub, platforma za upravljanje nekretninama</span>
            <span>&copy; {{ date('Y') }} Sva prava zadržana.</span>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
