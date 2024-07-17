@extends(request()->is('bo/*') ? 'back.layout' : 'front.layout')
@section('title', __('errors.error_title'))
@section('description', __('errors.error_message'))

@section('content')
    <div class="main-page d-flex flex-column justify-content-center align-items-center">
        <h1 class="title-font-regular position-relative text-primary text-center w-fit px-sm-5 mx-auto mb-3 p-0 py-1">
            {{ config('app.name') }}
            <span class="d-none d-sm-block angles"></span>
        </h1>
        <h2>@yield('errorTitle')</h2>
        <p class="my-3">@yield('errorMessage')</p>
        <p class="text-body-secondary">{{ __('errors.error_code') }} @yield('errorCode')</p>
        @if (View::hasSection('errorBtnHome'))
            <a class="btn btn-primary btn-sm" href="{{ request()->is('bo/*') ? route('bo.home') : route('fo.games.index') }}">
                {{ __('errors.error_text') }}
            </a>
        @endif
    </div>
@endsection
