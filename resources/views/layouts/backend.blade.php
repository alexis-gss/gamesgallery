<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.backend.head')
    @stack('styles')
</head>

<body id="app">
    <!-- Header -->
    @include('layouts.backend.header')

    <main class="container-fluid">
        {{-- Show a message when an action is performed --}}
        @auth
            @include('back.modules.message')
        @endauth
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 py-4">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('layouts.backend.footer')
</body>

</html>
