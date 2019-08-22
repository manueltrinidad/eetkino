<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.head')
<body>
    @auth
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endauth
    @include('layouts.partials.navbar')
    <div class="container">
        @yield('content')
        @include('layouts.partials.createbutton')
        @yield('optional-scripts')
        @include('cookieConsent::index')
    </div>
</body>
</html>