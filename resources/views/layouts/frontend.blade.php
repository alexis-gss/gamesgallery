<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.frontend.head')
    @stack('styles')
</head>

<body>
    <!-- Main content -->
    <main>
        @include('layouts.frontend.header')
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.frontend.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/front.js') }}" type="text/javascript"></script>
    @stack('scripts')
</body>

</html>
