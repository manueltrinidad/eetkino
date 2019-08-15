<!-- Navbar -->
<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light shadow p-1">
    <div class="container">
        <a class="navbar-brand" href="/">KiNO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stats') }}">Stats</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('films.index') }}">Films</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('names.index') }}">Names</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('countries.index') }}">Countries</a>
                </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('watchlists.index') }}">Watchlists</a>
                </li>
            </ul>
            <!-- Leave login be for now, remove in production -->
            @auth
            @include('layouts.partials.login') 
            @endauth
        </div>
    </div>
</nav>