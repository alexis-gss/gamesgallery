<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.backend.head')
    @stack('styles')
</head>

<body id="app">
    <!-- Header -->
    @include('layouts.backend.navbar')

    <!-- Main -->
    <section class="main container-fluid">
        <div class="row d-flex flex-row">
            @auth
                <!-- Navigation -->
                @include('layouts.backend.sidenav')
            @endauth
            <!-- Main content -->
            <main role="main" class="mt-2 mb-5 @auth col @endauth">
                @yield('content')
            </main>
        </div>
    </section>

    <!-- Footer -->
    @include('layouts.backend.footer')

    {{-- Show a message when an action is performed --}}
    @auth
        @include('bo.modules.message')
    @endauth
</body>

</html>
