<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.backend.head')
    @stack('styles')
</head>

<body>
    <div id="app">
        @include('layouts.backend.navbar')
        <div class="container-fluid">
            @auth
                @include('bo.modules.message')
            @endauth
            <div class="row d-flex flex-row">
                @auth
                    @include('layouts.backend.sidenav')
                @endauth
                <main role="main" class="mt-2 mb-5 @auth col @endauth">
                    @yield('content')
                </main>
            </div>
            <div class="row">
                @include('layouts.backend.footer')
            </div>
        </div>
    </div>
</body>

</html>
