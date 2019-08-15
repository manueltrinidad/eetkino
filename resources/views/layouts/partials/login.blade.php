<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
    <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">account_circle</i>
        </a>
        <div class="dropdown-menu" aria-labelledby="userDropdown">
            @guest
            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
            @if (Route::has('register'))
            <a class="dropdown-item" href="{{ route('register') }}">Register</a>
            @endif
            @else
            <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
            class="dropdown-item">
            Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
        </div>
    </li>
</ul>