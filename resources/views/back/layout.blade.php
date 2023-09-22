<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('back.layouts.head')
</head>

<body data-bs-theme="{{ \App\Enums\Theme\BootstrapThemeEnum::make(intval(Cache::get('theme')))->name() }}">
    @auth
    <!-- Header -->
    @include('back.layouts.nav')
    @endauth

    <!-- Main content -->
    <main class="container-fluid row mx-auto">
        <div class="col-12 col-md-10 col-lg-8 px-0 py-3 mx-auto">
            @if (!Auth::check())
            <div class="d-flex flex-column align-items-center justify-content-center h-100 pb-5">
                @endauth
                <!-- Show a message when an action is performed -->
                @include('back.modules.flash-messages')
                @yield('content')
                @if (!Auth::check())
            </div>
            @endauth
        </div>
    </main>

    <!-- Footer -->
    @include('back.layouts.footer')

    <!-- Other -->
    @include('back.modules.window-system')
    @vite(['resources/ts/bo/back.ts'])
    @stack('scripts')
</body>

</html>
