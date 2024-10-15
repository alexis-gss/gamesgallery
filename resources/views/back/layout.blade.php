<!doctype html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('back.layouts.head')
</head>

{{-- blade-formatter-disable --}}
@use('\App\Enums\Theme\BootstrapThemeEnum', 'BootstrapThemeEnum')
<body class="bg-body-tertiary" data-bs-theme="{{ (BootstrapThemeEnum::make(intval(cache()->get('theme'))) ?? BootstrapThemeEnum::light)->name() }}">
    {{-- HEADER --}}
    @include('back.layouts.header')

    {{-- MAIN CONTENT --}}
    <main class="container-fluid">
        <div class="row @guest row-custom @endguest">
            @include('back.layouts.navigation')
            <section id="page-content" class="col-12 @guest d-flex flex-column justify-content-center align-items-center @endguest bg-body p-3">
                <div class="container">
                    <x-back.noscript-warning/>
                    @auth('backend')
                        @include('back.modules.flash-messages')
                    @endauth
                    @yield('content')
                </div>
            </section>
        </div>
    </main>

    {{-- FOOTER --}}
    @include('back.layouts.footer')

    {{-- OTHER --}}
    @include('back.modules.window-system')
    @vite(['resources/ts/bo/back.ts'])
    @stack('scripts')
</body>
{{-- blade-formatter-enable --}}

</html>
