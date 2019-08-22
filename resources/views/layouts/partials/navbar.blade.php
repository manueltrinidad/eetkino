<!-- Navbar -->
<nav class="navbar sticky-top navbar-expand-lg navbar-light p-1" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="/">Culture Kino</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
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
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>