<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('front.layouts.head')
</head>

<body>
    <div class="position-relative">
        <div class="container">
            @include('front.partials.btn-github')

            @if (request()->routeIs('fo.games.show') || request()->routeIs('fo.ranks.index'))
                @include('front.layouts.nav')
            @endif

            <div data-aos="fade">
                <!-- Main content -->
                @yield('content')

                <!-- Footer -->
                @include('front.layouts.footer')
            </div>
        </div>

        @if (request()->routeIs('fo.games.show'))
            @include('front.partials.toast')
        @endif

        <!-- Other -->
        @include('front.modules.window-system')
        @vite(['resources/ts/fo/front.ts'])
        @stack('scripts')
    </div>
</body>

</html>
