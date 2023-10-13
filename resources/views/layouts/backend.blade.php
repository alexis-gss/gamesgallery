<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('back.layouts.head')
</head>

<body id="app">
    <!-- Header -->
    @include('back.layouts.nav')

    <!-- Main content -->
    <main class="container-fluid">
        <!-- Show a message when an action is performed -->
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
    @include('back.layouts.footer')

    <!-- Other -->
    @include('back.modules.window-system')
</body>

</html>
