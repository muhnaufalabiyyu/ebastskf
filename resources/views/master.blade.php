<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logoskf.svg') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- -->
    <link rel="stylesheet" href="{{ asset('fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/css/style.css">

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #001524;">
        <div class="container">
            <a class="navbar-brand" href=" {{ url('/') }}" style="color:#0068B0">e-BAST <span
                    style="color: #FFF">System</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                @if (Auth::user()->acting == 2)
                    <li class="nav-item">
                        <a href="{{ route('approval') }}"
                            class="nav-link {{ request()->routeIs('approval') ? 'active' : '' }}">Approval BAST</a>
                    </li>
                @else
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" aria-current="page"
                        href=" {{ route('home') }}">Home</a>
                @endif
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}"
                            href="{{ route('history') }}">History BAST</a>
                    </li>
                </ul>
                <ul class="d-flex navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="listbox" aria-expanded="false">
                            {{ Auth::user()->name }}<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a href="{{ url('actionlogout') }}" class="dropdown-item">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('main')
    </main>

    @include('layouts.footer')
</body>

</html>
