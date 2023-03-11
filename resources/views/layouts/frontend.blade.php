<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front.layouts.head')
</head>

<body class="container position-relative bg-first light-theme">
    @if (!Route::is('fo.homepage'))
        <!-- Navigation -->
        @include('front.layouts.nav')
    @endif

    <div data-aos="fade">
        <!-- Main content -->
        @yield('content')

        <!-- Footer -->
        @include('front.layouts.footer')
    </div>

    <!-- Other -->
    @include('front.modules.window-system')
</body>

</html>
