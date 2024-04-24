@extends(request()->is('bo/*') ? 'back.layout' : 'front.layout')
@section('title', __('errors.error_title'))
@section('description', __('errors.error_message'))

@section('content')
    <div clas="row">
        <h1>@yield('errorTitle')</h1>
        <p>@yield('errorMessage')</p>
        <p class="text-body-secondary">{{ __('errors.error_code') }} @yield('errorCode')</p>
        <a class="text-decoration-none" href="{{ request()->is('bo/*') ? route('bo.home') : route('fo.games.index') }}">
            {{ __('errors.error_text') }}
        </a>
    </div>
@endsection
