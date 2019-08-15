<!DOCTYPE html>
<html lang="en">
@include('layouts.partials.head')
<body>
    <div class="container">
        @include('layouts.partials.navbar')
        @yield('content')
        @include('layouts.partials.bottomscripts')
        @include('layouts.partials.create')
        @include('cookieConsent::index')
    </div>
</body>
</html>