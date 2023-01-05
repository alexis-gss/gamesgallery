<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front.layouts.head')
    @stack('styles')
</head>

<body class="container position-relative bg-first light-theme"
    data-aos="fade">
    @if (!Route::is('homepage'))
        <!-- Navigation -->
        @include('front.layouts.nav')
    @endif

    <!-- Main content -->
    @yield('content')

    <!-- Footer -->
    @include('front.layouts.footer')

    <!-- Other -->
    @include('front.modules.window-system')
</body>

</html>
