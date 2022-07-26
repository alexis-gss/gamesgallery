<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="@yield('description')" />
<meta name="robots" content="@yield('metaIndex')">

<!-- Title -->
<title>
    {{ config('app.name') }}
    @hasSection('title')
        - @yield('title')
    @endif
</title>

<!-- Others -->
<link rel="icon" type="image/png" href="{{ asset('assets/images/global/logo.png') }}" />
<link rel="canonical" href="{{ url()->current() }}">

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/back.css') }}" rel="stylesheet">

<!-- Scripts -->
<script src="{{ asset('js/back.js') }}" type="text/javascript"></script>
@stack('scripts')
