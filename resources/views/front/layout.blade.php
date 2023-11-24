<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front.layouts.head')
</head>

<body class="position-relative text-font-regular bg-first container">
    @include('front.partials.btn-github')
    @include('front.partials.btn-lang')

    @if (!request()->routeIs('fo.ranks.index'))
    @include('front.partials.btn-ranking')
    @endif

    @if (!request()->routeIs('fo.games.index'))
    @include('front.layouts.nav')
    @include('front.partials.btn-scroll')
    @endif

    <div data-aos="fade">
        <!-- Main content -->
        @yield('content')

        <!-- Footer -->
        @include('front.layouts.footer')
    </div>

    <!-- Other -->
    @include('front.modules.window-system')
    @vite(['resources/ts/fo/front.ts'])
    @stack('scripts')
</body>

</html>
