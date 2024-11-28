<!doctype html>
<html dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-back.layouts.head :brParam="isset($brParam) ? $brParam : []" />
</head>

{{-- blade-formatter-disable --}}
@use('\App\Enums\Theme\BootstrapThemeEnum', 'BootstrapThemeEnum')
<body class="bg-body-tertiary" data-bs-theme="{{ (BootstrapThemeEnum::make(intval(cache()->get('theme'))) ?? BootstrapThemeEnum::light)->name() }}">
    {{-- HEADER --}}
    <x-back.layouts.header/>

    {{-- MAIN CONTENT --}}
    <main class="container-fluid">
        <div class="row @guest row-custom @endguest">
            <x-back.layouts.navigation/>
            <section id="page-content" class="col-12 @guest d-flex flex-column justify-content-center align-items-center @endguest bg-body p-3">
                <div class="container p-0">
                    <x-back.noscript-warning/>
                    @auth('backend')
                        <x-back.flash-messages />
                    @endauth
                    @yield('content')
                </div>
            </section>
        </div>
    </main>

    {{-- FOOTER --}}
    <x-back.layouts.footer/>

    {{-- OTHER --}}
    <x-back.window-system />
    @vite(['resources/ts/bo/back.ts'])
    @stack('scripts')
</body>
{{-- blade-formatter-enable --}}

</html>
