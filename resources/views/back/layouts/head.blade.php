<!-- Title -->
<title>{{ config('app.name') }} - @yield('title')</title>

<!-- Meta -->
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="description" content="@yield('description')" />
<meta name="robots" content="noindex,nofollow">
<meta name="theme-color" content="#121416" />

<!-- Open Graph -->
<meta property="og:title" content="{{ config('app.name') }} - @yield('title')" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ config('app.url') }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ asset('assets/images/visual-bo.png') }}" />
<meta property="og:description" content="@yield('description')" />

<!--  Favicon -->
<link rel="icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
<meta name="msapplication-TileColor" content="#2b5797">
<meta name="msapplication-TileImage" content="{{ asset('mstile-144x144.png') }}">
<meta name="theme-color" content="#121416">

<!-- Others -->
<link rel="canonical" href="{{ url()->current() }}" />
@include('breadcrumbs.breadcrumb-head')

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<!-- Styles -->
@vite(['resources/sass/bo/back.scss'])

@if(config('app.debug'))
<script @if (!empty($nonce)) nonce="{{ $nonce }}" @endif>window.vueDebug = true;</script>
@endif
