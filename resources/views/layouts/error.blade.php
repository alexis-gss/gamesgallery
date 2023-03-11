@extends(Request::is('bo/*') ? 'layouts.backend' : 'layouts.frontend')
@section('title', __('errors.error_title'))
@section('description', __('errors.error_message'))

@section('content')
    <div clas="row">
        <h1>@yield('errorTitle')</h1>
        <p>@yield('errorMessage')</p>
        <p class="text-muted">{{ __('errors.error_code') }} @yield('errorCode')</p>
        <a class="text-decoration-none" href="{{ Request::is('bo/*') ? route('bo.homepage') : route('fo.homepage') }}">
            {{ __('errors.error_text') }}
        </a>
    </div>
@endsection
