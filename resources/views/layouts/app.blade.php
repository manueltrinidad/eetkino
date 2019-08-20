<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.head')
<body>
    <div class="container">
        @auth
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @endauth
        @include('layouts.partials.navbar')
        @yield('content')
        @include('layouts.partials.createbutton')
        @include('layouts.partials.bottomscripts')
        @yield('optional-scripts')
        @include('cookieConsent::index')
    </div>
</body>
</html>