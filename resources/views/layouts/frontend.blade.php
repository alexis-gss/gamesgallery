<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front.layouts.head')
    @stack('styles')
</head>

<body>
    <!-- Main content -->
    @yield('content')

    <!-- Footer -->
    @include('front.layouts.footer')
</body>

</html>
