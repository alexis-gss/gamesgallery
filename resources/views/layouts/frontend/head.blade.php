<!-- Meta -->
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="@yield('description')">
<meta name="keywords" content="@yield('keywords')">

<!-- Title -->
<title>{{ config('app.name') }} - @yield('title')</title>

<!-- Others -->
<link rel="icon" type="image/png" href="{{ asset('assets/images/global/logo.png') }}" />
<link rel="canonical" href="{{ url()->current() }}">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
