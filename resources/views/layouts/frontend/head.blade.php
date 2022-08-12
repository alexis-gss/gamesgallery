<!-- Title -->
<title>{{ config('app.name') }} - @yield('title')</title>

<!-- Meta -->
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="@yield('description')" />
<meta name="keywords" content="@yield('keywords')" />

<!-- Open Graph -->
<meta property="og:title" content="{{ config('app.name') }} - @yield('title')" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ env('APP_URL') }}" />
<meta property="og:site_name" content="{{ env('APP_NAME') }}" />
<meta property="og:image" content="{{ asset('assets/images/visual-fo.png') }}" />
<meta property="og:description" content="@yield('description')" />

<!-- Others -->
<link rel="icon" type="image/png" href="{{ asset('assets/images/icon.png') }}" />
<link rel="canonical" href="{{ url()->current() }}" />

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Antonio:wght@100;700&display=swap" rel="stylesheet" />
