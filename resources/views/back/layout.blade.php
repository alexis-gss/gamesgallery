<!doctype html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('back.layouts.head')
</head>

{{-- blade-formatter-disable --}}
@use('\App\Enums\Theme\BootstrapThemeEnum', 'BootstrapThemeEnum')
<body data-bs-theme="{{ (BootstrapThemeEnum::make(intval(cache()->get('theme'))) ?? BootstrapThemeEnum::light)->name() }}">
    <!-- Header -->
    @include('back.layouts.nav')

    <!-- Main content -->
    <main class="container-fluid row mx-auto">
        <div class="col-12 col-md-10 col-lg-8 mx-auto px-0 py-3">
            @if (!auth('backend')->user())
                <div class="d-flex flex-column align-items-center justify-content-center h-100 pb-5">
            @else
                {{-- Show a message when an action is performed --}}
                @include('back.modules.flash-messages')
            @endif
            @yield('content')
            @if (!auth('backend')->user())
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    @include('back.layouts.footer')

    <!-- Other -->
    @include('back.modules.window-system')
    @vite(['resources/ts/bo/back.ts'])
    @stack('scripts')
</body>
{{-- blade-formatter-enable --}}

</html>
