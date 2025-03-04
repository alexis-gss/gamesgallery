{{-- Title --}}
{{-- blade-formatter-disable --}}
<title>@hasSection('title')@yield('title') - @endif{{ config('app.name') }}</title>
{{-- blade-formatter-enable --}}

{{-- Meta --}}
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="@yield('description')">
<meta name="robots" content="index,follow">

{{-- Open Graph --}}
{{-- blade-formatter-disable --}}
<meta property="og:title" content="@hasSection('title')@yield('title') - @endif{{ config('app.name') }}">
{{-- blade-formatter-enable --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ \config('app.url') }}/{{ \request()->path() }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:image" content="{{ asset('assets/images/visual-fo.png') }}">
<meta property="og:description" content="@yield('description')">

{{--  Favicon --}}
<link rel="icon" type="image/png" sizes="36x36" href="{{ asset('android-icon-36x36.png') }}">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('android-icon-48x48.png') }}">
<link rel="icon" type="image/png" sizes="72x72" href="{{ asset('android-icon-72x72.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('android-icon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="144x144" href="{{ asset('android-icon-144x144.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-icon-192x192.png') }}">
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180') }}">
<link rel="icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
<link rel="manifest" href="{{ asset('manifest') }}">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">
<meta name="theme-color" content="#121416">

{{-- Others --}}
<link href="{{ \config('app.url') }}/{{ \request()->path() }}" rel="canonical">
<x-breadcrumbs.breadcrumb-head :brParam="$brParam" />

{{-- Styles --}}
@vite(['resources/sass/fo/front.scss'])
@stack('styles')

{{-- DEBUG --}}
@if (config('app.debug'))
    <script @if (!empty($nonce)) nonce="{{ $nonce }}" @endif>
        window.vueDebug = true;
    </script>
@endif
