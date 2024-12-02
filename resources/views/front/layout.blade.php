<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php $brParam = isset($brParam) ? $brParam : []; @endphp

<head>
    <x-front.layouts.head :brParam="$brParam" />
</head>

<body>
    <x-front.layouts.loading-screen />

    <main class="container overflow-hidden">
        <x-noscript-warning />
        <x-front.btn-github />

        {{-- NAVIGATION --}}
        <x-front.layouts.nav :brParam="$brParam" :gameModel="isset($gameModel) ? $gameModel : null"
            :gameModels="$gameModels" :folderModels="$folderModels" :tagModels="$tagModels" />

        {{-- MAIN CONTENT --}}
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <x-front.layouts.footer />

    {{-- TOAST MESSAGES CONTAINER --}}
    <x-front.toast-container />

    {{-- OTHER --}}
    <x-front.window-system />
    @vite(['resources/ts/fo/front.ts'])
    @stack('scripts')
</body>

</html>
